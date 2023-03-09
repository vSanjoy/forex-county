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
                        $getUser->otp           = $this->getRandomPasscode();
                        $getUser->device_token  = $request->device_token;
                        $updateData             = $getUser->save();

                        if ($updateData) {
                            $countryCode    = $getUser->countryDetails ? $getUser->countryDetails->country_code_for_phone : getenv('COUNTRY_CODE');
                            $toPhoneNumber  = $countryCode.$getUser->phone_no;
                            $messageBody    = "Hello ".$getUser->first_name."! \nYour security code to reset login passcode is: ".$getUser->otp;

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
                        return Response::json(generateResponseBody('FC-FP-0005#forgot_passcode', $data, __('custom_api.error_invalid_phone_number_inactive_user'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-FP-0006#forgot_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
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
                            $getUser->auth_token = Hash::make(md5($getUser['id']).env('APP_KEY').md5($getUser['email']));

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
                return Response::json(generateResponseBody('FC-VSC-0006#verify_security_code', $data, __('custom_api.error_something_went_wrong'), false, 400));
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
                        $updateUserData = User::where('id', $userData['id'])->update(['verification_code' => Hash::make($request->password)]);

                        if ($updateUserData) {
                            $data['user_details']   = new UserResource($userData);

                            return Response::json(generateResponseBody('FC-NP-0002#new_passcode', $data, __('custom_api.message_data_added_successfully'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-NP-0003#new_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-NP-0004#new_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
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
                    $hashedPassword = $userData['verification_code'];

                    if ($userData['verification_code'] != null && $userData['otp'] != null) {
                        if (Hash::check($request->repeat_password, $hashedPassword)) {
                            $updateUserData = User::where('id', $userData['id'])->update(['password' => Hash::make($request->repeat_password), 'auth_token' => NULL, 'verification_code' => NULL, 'otp' => NULL]);
                            
                            return Response::json(generateResponseBody('FC-RP-0002#repeat_passcode', $data, __('custom_api.message_passcode_reset_successfully'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-RP-0003#repeat_passcode', $data, __('custom_api.error_passcode_not_matched'), false, 400));
                        }
                    } else {
                        return Response::json(generateResponseBody('FC-RP-0004#repeat_passcode', $data, __('custom_api.error_already_reset_passcode'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-RP-0005#repeat_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
            }
        } else {
            return Response::json(generateResponseBodyForSignInSignUp('FC-RP-0006#repeat_passcode', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
        }
    }
    
}