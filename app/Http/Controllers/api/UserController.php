<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      :
# Page/Class name   : UserController
# Purpose           : API responses
/*****************************************************/
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App;
use Auth;
use Response;
use Validator;
use Hash;
use App\Models\User;
use App\Models\UserDetail;
use App\Http\Resources\UserResource;
use Twilio\Rest\Client;


class UserController extends Controller
{
    /*
        * Function Name : __construct
        * Purpose       : It sets some public variables for being accessed throughout this
        *                   controller
        * Author        :
        * Created Date  :
        * Modified date :
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function __construct($data = null) {
        parent::__construct();
    }

    /*
        * Function name : logIn
        * Purpose       : To login in the app
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Passcode
        * Return Value  : 
    */
    public function logIn(Request $request) {
        $data = [];
        
        try {
            if ($request->isMethod('POST')) {
                $userModel = new User();
                $validation = \Validator::make($request->all(),
                    [
                        'password'  => 'required',
                    ],
                    [
                        'password.required'   => __('custom_api.error_passcode'),
                    ]
                );
                $errors = $validation->errors()->all();
                if ($errors) {
                    return Response::json(generateResponseBody('FC-LI-0001#log_in', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                } else {
                    $input = $request->all();
                    
                    if (Auth::guard('web')->attempt(['type' => 'C', 'password' => $request->password, 'device_token' => $request->device_token])) {
                        if (Auth::user()->verification_code === null && Auth::user()->otp === null) {
                            if (Auth::user()->status == '1') {
                                if (Auth::user()->type == 'C') {
                                    $user                       = Auth::user();
                                    $authenticatedToken         = Hash::make(md5($user->id).env('APP_KEY'));
                                    
                                    $user->auth_token           = $authenticatedToken;
                                    $user->lastlogintime        = strtotime(getCurrentFullDateTime());
                                    $user->save();
                                    
                                    $data['user_details']       = new UserResource($user);
                    
                                    return Response::json(generateResponseBody('FC-LI-0001#log_in', $data, __('custom_api.message_logged_in_successfully'), true, 200));
                                } else {
                                    Auth::guard('web')->logout();   // Logout

                                    return Response::json(generateResponseBodyForSignInSignUp('FC-LI-0002#log_in', $data, __('custom_api.error_unauthorized_access'), false, 401));
                                }
                            } else {
                                Auth::guard('web')->logout();   // Logout

                                return Response::json(generateResponseBody('FC-FP-0003#log_in', $data, __('custom_api.error_inactive_user_or_deleted_user'), false, 400));
                            }
                        } else {
                            Auth::guard('web')->logout();   // Logout

                            return Response::json(generateResponseBody('FC-FP-0004#log_in', $data, __('custom_api.error_reset_passcode'), false, 400));
                        }
                    } else {
                        return Response::json(generateResponseBodyForSignInSignUp('FC-LI-0005#log_in', $data, __('custom_api.error_incorrect_passcode'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-FP-0006#log_in', $data, __('custom_api.error_method_not_supported'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-FP-0007#log_in', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : logOut
        * Purpose       : To logout from the app
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Passcode
        * Return Value  : 
    */
    public function logOut(Request $request) {
        $data       = [];
        $userData   = getUserFromHeader($request);

        try {
            if ($userData != null) {
                if ($request->isMethod('POST')) {
                    User::where(['auth_token' => $userData->auth_token, 'type' => 'C'])->update(['auth_token' => NULL]);

                    $token              = Hash::make(env('APP_KEY'));
                    $data['_authtoken'] = $token;

                    return Response::json(generateResponseBody('FC-LO-0001#log_out', $data, trans('custom_api.message_account_signout'), true, 200));
                    
                } else {
                    return Response::json(generateResponseBody('FC-LO-0003#log_in', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-LO-0002#log_out', $data, trans('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-LO-0004#log_out', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : forgotPasscode
        * Purpose       : To post passcode for forgot passcode screen
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Passcode
        * Return Value  : 
    */
    public function forgotPasscode(Request $request) {
        $data = [];
        
        try {
            if ($request->isMethod('PATCH')) {
                $userModel = new User();
                $validation = \Validator::make($request->all(),
                    [
                        'phone_no'  => 'required',
                    ],
                    [
                        'phone_no.required'   => __('custom_api.error_phone'),
                    ]
                );
                $errors = $validation->errors()->all();
                if ($errors) {
                    return Response::json(generateResponseBody('FC-FP-0001#forgot_passcode', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                } else {
                    $input = $request->all();
                    $getUser = $userModel->where(['phone_no' => $request->phone_no, 'status' => '1'])->whereNull('deleted_at')->first();
                    if ($getUser) {
                        if ($getUser->type == 'C') {    // Only customer can do forgot passcode through app
                            $getUser->otp           = $this->getRandomPasscode();
                            $getUser->device_token  = $request->device_token;
                            $updateData             = $getUser->save();

                            if ($updateData) {
                                $countryCode    = $getUser->countryDetails ? $getUser->countryDetails->country_code_for_phone : getenv('COUNTRY_CODE');
                                $toPhoneNumber  = $countryCode.$getUser->phone_no;
                                $messageBody    = "Hello ".$getUser->first_name."! \nYour security code to reset login passcode is: ".$getUser->otp.". Please do not share the security code with anyone.";

                                $accountSid = getenv('TWILIO_ACCOUNT_SID');
                                $authToken  = getenv('TWILIO_AUTH_TOKEN');
                                $fromNumber = getenv('TWILIO_FROM');
                                
                                $twilio = new Client($accountSid, $authToken);
                                $message = $twilio->messages->create($toPhoneNumber, [
                                                                            'from' => $fromNumber,
                                                                            'body' => $messageBody
                                                                        ]
                                                                    );
                                if ($message->sid) {
                                    $data['user_details'] = new UserResource($getUser);

                                    return Response::json(generateResponseBody('FC-FP-0002#forgot_passcode', $data, __('custom_api.message_security_code_sent_successfully'), true, 200));
                                } else {
                                    return Response::json(generateResponseBody('FC-FP-0003#forgot_passcode', $data, __('custom_api.error_message_not_sent'), true, 200));
                                }
                            } else {
                                return Response::json(generateResponseBody('FC-FP-0004#forgot_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
                            }
                        } else {
                            return Response::json(generateResponseBody('FC-FP-0008#forgot_passcode', $data, __('custom_api.error_unauthorized_access'), false, 400));
                        }
                    } else {
                        return Response::json(generateResponseBody('FC-FP-0005#forgot_passcode', $data, __('custom_api.error_invalid_phone_number_inactive_user'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-FP-0006#forgot_passcode', $data, __('custom_api.error_method_not_supported'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-FP-0007#forgot_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : verifySecurityCode
        * Purpose       : To post passcode for forgot passcode
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Security code (Received on phone)
        * Return Value  : 
    */
    public function verifySecurityCode(Request $request) {
        $data = [];
        
        try {
            if ($request->isMethod('PATCH')) {
                $userModel = new User();
                $validation = \Validator::make($request->all(),
                    [
                        'security_code' => 'required',
                    ],
                    [
                        'security_code.required'    => __('custom_api.error_security_code'),
                    ]
                );
                $errors = $validation->errors()->all();
                if ($errors) {
                    return Response::json(generateResponseBody('FC-VSC-0001#verify_security_code', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                } else {
                    $input = $request->all();
                    $getUser = $userModel->where(['device_token' => $request->device_token, 'otp' => $request->security_code, 'status' => '1'])->whereNull('deleted_at')->first();
                    if ($getUser) {
                        if ($getUser->device_token == $request->device_token) {
                            $getUser->auth_token = Hash::make(md5($getUser['id']).env('APP_KEY'));

                            if ($getUser->save()) {
                                $data['user_details']   = new UserResource($getUser);
                                return Response::json(generateResponseBody('FC-VSC-0002#verify_security_code', $data, __('custom_api.message_security_code_verified_successfully'), true, 200));
                            } else {
                                return Response::json(generateResponseBody('FC-VSC-0003#verify_security_code', $data, __('custom_api.error_invalid_user'), false, 400));
                            }
                        } else {
                            return Response::json(generateResponseBody('FC-VSC-0004#verify_security_code', $data, __('custom_api.error_invalid_user'), false, 400));
                        }
                    } else {
                        return Response::json(generateResponseBody('FC-VSC-0005#verify_security_code', $data, __('custom_api.error_invalid_security_code'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-VSC-0006#verify_security_code', $data, __('custom_api.error_method_not_supported'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-VSC-0007#verify_security_code', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
    /*
        * Function name : newPasscode
        * Purpose       : To post new passcode for forgot passcode
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : New passcode (password)
        * Return Value  : 
    */
    public function newPasscode(Request $request) {
        $data       = [];
        $userData   = getUserFromHeader($request);
        
        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $userModel = new User();
                    $validation = \Validator::make($request->all(),
                        [
                            'password' => 'required',
                        ],
                        [
                            'password.required' => __('custom_api.error_security_code'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-NP-0001#new_passcode', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        $userData['password']           = $request->password;
                        $userData['verification_code']  = customEncryptionDecryption($request->password);
                        $updateUserData = $userData->save();

                        if ($updateUserData) {
                            $data['user_details']   = new UserResource($userData);

                            return Response::json(generateResponseBody('FC-NP-0002#new_passcode', $data, __('custom_api.message_data_added_successfully'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-NP-0003#new_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-NP-0004#new_passcode', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-NP-0005#new_passcode', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-NP-0006#new_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : repeatPasscode
        * Purpose       : To post repeat passcode for forgot passcode
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Repeat passcode
        * Return Value  : 
    */
    public function repeatPasscode(Request $request) {
        $data       = [];
        $userData   = getUserFromHeader($request);

        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $userModel = new User();
                    $validation = \Validator::make($request->all(),
                        [
                            'repeat_password'   => 'required',
                        ],
                        [
                            'repeat_password.required'  => __('custom_api.error_repeat_passcode'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-RP-0001#repeat_passcode', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        $verificationCode = $userData['verification_code'];

                        if ($userData['verification_code'] != null && $userData['otp'] != null) {

                            if (customEncryptionDecryption($request->repeat_password) == $verificationCode) {
                                $updateUserData = User::where('id', $userData['id'])->update(['verification_code' => NULL, 'auth_token' => NULL, 'otp' => NULL]);
                                
                                return Response::json(generateResponseBody('FC-RP-0002#repeat_passcode', $data, __('custom_api.message_passcode_reset_successfully'), true, 200));
                            } else {
                                return Response::json(generateResponseBody('FC-RP-0003#repeat_passcode', $data, __('custom_api.error_passcode_not_matched'), false, 400));
                            }
                        } else {
                            return Response::json(generateResponseBody('FC-RP-0004#repeat_passcode', $data, __('custom_api.error_already_reset_passcode'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-RP-0005#repeat_passcode', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-RP-0006#repeat_passcode', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-NP-0007#repeat_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : userDetails
        * Purpose       : To get user details
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : 
        * Return Value  : 
    */
    public function userDetails(Request $request) {
        $data       = [];
        $userData   = getUserFromHeader($request);

        try {
            if ($userData != null) {
                $data['user_details']   = new UserResource($userData);
                return Response::json(generateResponseBody('FC-UD-0001#user_details', $data, trans('custom_api.message_user_details_received'), true, 200));
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-UD-0002#user_details', $data, trans('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-UD-0003#user_details', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : personalDetails
        * Purpose       : To get user details
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : 
        * Return Value  : 
    */
    public function personalDetails(Request $request) {
        $data       = [];
        $userData   = getUserFromHeader($request);

        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $validation = \Validator::make($request->all(),
                        [
                            'date_of_birth' => 'required',
                            'building_name' => 'required',
                            'city'          => 'required',
                            'post_code'     => 'required',
                        ],
                        [
                            'date_of_birth.required'=> __('custom_api.error_date_of_birth'),
                            'building_name.required'=> __('custom_api.error_building_name'),
                            'city.required'         => __('custom_api.error_city'),
                            'post_code.required'    => __('custom_api.error_post_code'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-PD-0001#personal_details', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        $otp   = $this->getRandomPasscode();
                        $updateUserData = UserDetail::where('user_id', $userData['id'])
                                                        ->update([
                                                            'date_of_birth' => changeDateFormatFromUnixTimestamp(strtotime($input['date_of_birth']), 'Y-m-d'),
                                                            'city' => $input['city'],
                                                            'building_name' => $input['building_name'],
                                                            'post_code' => $input['post_code'],
                                                            'phone_verification_code' => $otp
                                                        ]);
                        if ($updateUserData) {
                            // $countryCode    = $userData->countryDetails ? $userData->countryDetails->country_code_for_phone : getenv('COUNTRY_CODE');
                            // $toPhoneNumber  = $countryCode.$userData->phone_no;
                            // $messageBody    = "Hello ".$userData->first_name."! \nYour security code to verify your identity is: ".$otp.". Please do not share the security code with anyone.";

                            // $accountSid = getenv('TWILIO_ACCOUNT_SID');
                            // $authToken  = getenv('TWILIO_AUTH_TOKEN');
                            // $fromNumber = getenv('TWILIO_FROM');
                            
                            // $twilio = new Client($accountSid, $authToken);
                            // $message = $twilio->messages->create($toPhoneNumber, [
                            //                                             'from' => $fromNumber,
                            //                                             'body' => $messageBody
                            //                                         ]
                            //                                     );
                            // if ($message->sid) {
                                $data['user_details']   = new UserResource($userData);

                                return Response::json(generateResponseBody('FC-PD-0002#repeat_passcode', $data, __('custom_api.message_personal_details_updated_successfully'), true, 200));
                            // } else {
                            //     return Response::json(generateResponseBody('FC-PD-0003#personal_details', $data, __('custom_api.error_sms_sent'), false, 400));
                            // }
                        } else {
                            return Response::json(generateResponseBody('FC-PD-0004#personal_details', $data, __('custom_api.error_something_went_wrong'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-PD-0005#personal_details', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-PD-0006#personal_details', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-PD-0007#personal_details', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
    /*
        * Function name : sendProfileUpdateSecurityCode
        * Purpose       : To send security code for verify identity
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : send security code (Received on phone)
        * Return Value  : 
    */
    public function sendProfileUpdateSecurityCode(Request $request) {
        $data       = [];
        $userData   = getUserFromHeader($request);
        
        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $otp            = $this->getRandomPasscode();

                    $updateUserData = UserDetail::where('user_id', $userData['id'])->update(['phone_verification_code' => $otp]);

                    if ($updateUserData) {
                        $countryCode    = $userData->countryDetails ? $userData->countryDetails->country_code_for_phone : getenv('COUNTRY_CODE');
                        $toPhoneNumber  = $countryCode.$userData->phone_no;
                        $messageBody    = "Hello ".$userData->first_name."! \nYour security code to verify your identity is: ".$otp.". Please do not share the security code with anyone.";

                        // $accountSid = getenv('TWILIO_ACCOUNT_SID');
                        // $authToken  = getenv('TWILIO_AUTH_TOKEN');
                        // $fromNumber = getenv('TWILIO_FROM');
                        
                        // $twilio = new Client($accountSid, $authToken);
                        // $message = $twilio->messages->create($toPhoneNumber, [
                        //                                             'from' => $fromNumber,
                        //                                             'body' => $messageBody
                        //                                         ]
                        //                                     );
                        // if ($message->sid) {
                            $data['user_details']   = new UserResource($userData);

                            return Response::json(generateResponseBody('FC-SPUSC-0001#send_profile_update_security_code', $data, __('custom_api.message_security_code_sent_successfully'), true, 200));
                        // } else {
                        //     return Response::json(generateResponseBody('FC-SPUSC-0002#send_profile_update_security_code', $data, __('custom_api.error_sms_sent'), false, 400));
                        // }
                    } else {
                        return Response::json(generateResponseBody('FC-SPUSC-0006#send_profile_update_security_code', $data, __('custom_api.error_something_went_wrong'), false, 400));
                    }
                } else {
                    return Response::json(generateResponseBody('FC-SPUSC-0003#send_profile_update_security_code', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-SPUSC-0004#send_profile_update_security_code', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-SPUSC-0005#send_profile_update_security_code', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : verifyProfileUpdateSecurityCode
        * Purpose       : To post security code for verify identity
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Security code (Received on phone)
        * Return Value  : 
    */
    public function verifyProfileUpdateSecurityCode(Request $request) {
        $data = [];
        $userData   = getUserFromHeader($request);
        
        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $validation = \Validator::make($request->all(),
                        [
                            'security_code' => 'required',
                        ],
                        [
                            'security_code.required'    => __('custom_api.error_security_code'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-VSC-0001#verify_profile_security_code', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        $getUser = UserDetail::where(['user_id' => $userData['id'], 'phone_verification_code' => $input['security_code']])->first();
                        if ($getUser) {
                            return Response::json(generateResponseBody('FC-VSC-0002#verify_profile_security_code', $data, __('custom_api.message_security_code_verified_successfully'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-VSC-0003#verify_profile_security_code', $data, __('custom_api.error_invalid_security_code'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-VSC-0004#verify_profile_security_code', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-VSC-0005#verify_profile_security_code', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-VSC-0006#verify_profile_security_code', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
    /*
        * Function name : updatePhoneNumber
        * Purpose       : To update customer phone number
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Country id & phone number
        * Return Value  : 
    */
    public function updatePhoneNumber(Request $request) {
        $data = [];
        $userData   = getUserFromHeader($request);
        
        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $validation = \Validator::make($request->all(),
                        [
                            'country_id'=> 'required',
                            'phone_no'  => 'required',
                        ],
                        [
                            'country_id.required'   => __('custom_api.error_country_id'),
                            'phone_no.required'     => __('custom_api.error_phone_no'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-UPN-0001#update_phone_number', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input      = $request->all();
                        $checkUser  = User::where('id', '<>', $userData['id'])->where(['country_id' => $input['country_id'], 'phone_no' => $input['phone_no']])->first();

                        if ($checkUser) {
                            return Response::json(generateResponseBody('FC-UPN-0002#update_phone_number', $data, __('custom_api.error_country_with_phone_number_exist'), false, 400));
                        } else {
                            $otp = $this->getRandomPasscode();

                            $userData['country_id']             = $input['country_id'];
                            $userData['phone_no']               = $input['phone_no'];
                            $updateData = $userData->save();
                            if ($updateData) {
                                $countryCode    = $userData->countryDetails ? $userData->countryDetails->country_code_for_phone : getenv('COUNTRY_CODE');
                                $toPhoneNumber  = $countryCode.$userData->phone_no;
                                $messageBody    = "Hello ".$userData->first_name."! \nYour security code to verify your identity is: ".$otp.". Please do not share the security code with anyone.";

                                UserDetail::where('user_id', $userData['id'])->update([
                                                                                'country_code' => $userData->countryDetails->country_code_for_phone,
                                                                                'phone_verification_code' => $otp
                                                                            ]);

                                $accountSid = getenv('TWILIO_ACCOUNT_SID');
                                $authToken  = getenv('TWILIO_AUTH_TOKEN');
                                $fromNumber = getenv('TWILIO_FROM');
                                
                                $twilio = new Client($accountSid, $authToken);
                                $message = $twilio->messages->create($toPhoneNumber, [
                                                                            'from' => $fromNumber,
                                                                            'body' => $messageBody
                                                                        ]
                                                                    );
                                if ($message->sid) {
                                    $data['user_details']   = new UserResource($userData);
    
                                    return Response::json(generateResponseBody('FC-UPN-0003#update_phone_number', $data, __('custom_api.message_phone_number_updated_successfully'), true, 200));
                                } else {
                                    return Response::json(generateResponseBody('FC-UPN-0004#update_phone_number', $data, __('custom_api.error_sms_sent'), false, 400));
                                }
                            } else {
                                return Response::json(generateResponseBody('FC-UPN-0005#update_phone_number', $data, __('custom_api.error_something_went_wrong'), false, 400));
                            }
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-UPN-0006#update_phone_number', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-UPN-0007#update_phone_number', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-UPN-0008#update_phone_number', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
    /*
        * Function name : verifyPhotoIdentityCountry
        * Purpose       : verify photo identity country
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Country id
        * Return Value  : 
    */
    public function verifyPhotoIdentityCountry(Request $request) {
        $data = [];
        $userData   = getUserFromHeader($request);
        
        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $validation = \Validator::make($request->all(),
                        [
                            'country_id'=> 'required',
                        ],
                        [
                            'country_id.required'   => __('custom_api.error_country_id'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-VPIC-0001#verify_photo_identity_country', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        
                        UserDetail::where('user_id', $userData['id'])->update(['photo_id_verified_country' => $input['country_id']]);

                        $data['user_details']   = new UserResource($userData);

                        return Response::json(generateResponseBody('FC-VPIC-0002#verify_photo_identity_country', $data, __('custom_api.message_verify_photo_identity_country_updated_successfully'), true, 200));
                    }
                } else {
                    return Response::json(generateResponseBody('FC-VPIC-0003#verify_photo_identity_country', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-VPIC-0004#verify_photo_identity_country', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-VPIC-0008#verify_photo_identity_country', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
}