<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      :
# Page/Class name   : TemporaryUserController
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
use App\Models\TemporaryUser;
use App\Http\Resources\TemporaryUserResource;
use App\Http\Resources\UserResource;

class TemporaryUserController extends Controller
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
        * Function name : signupStep1
        * Purpose       : To post user data @ registration first screen
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : first name, last name & email (optional)
        * Return Value  : 
    */
    public function signupStep1(Request $request) {
        $data = [];
        
        try {
            if ($request->isMethod('POST')) {
                $userModel = new User();
                $validation = \Validator::make($request->all(),
                    [
                        'first_name'=> 'required',
                        'last_name' => 'required',
                        'email'     => 'sometimes|nullable|regex:'.config('global.EMAIL_REGEX').'|unique:'.$userModel->getTable().',email,NULL,id,deleted_at,NULL',
                    ],
                    [
                        'first_name.required'   => __('custom_api.error_first_name'),
                        'last_name.required'    => __('custom_api.error_last_name'),
                        'email.regex'           => __('custom_api.error_valid_email'),
                        'email.unique'          => __('custom_api.error_email_unique'),
                    ]
                );
                $errors = $validation->errors()->all();
                if ($errors) {
                    return Response::json(generateResponseBody('FC-SS1-0001#signup_step1', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                } else {
                    $input                  = $request->all();
                    $input['first_name']    = Str::headline($request->first_name);
                    $input['last_name']     = Str::headline($request->last_name);
                    $input['full_name']     = Str::headline($request->first_name.' '.$request->last_name);
                    $input['device_token']  = $request->device_token;
                    $saveData               = TemporaryUser::create($input);

                    if ($saveData) {
                        $saveData->token = Hash::make(md5($saveData->id).env('APP_KEY'));
                        $saveData->save();

                        $data['user_details'] = new TemporaryUserResource($saveData);

                        return Response::json(generateResponseBody('FC-SS1-0002#signup_step1', $data, __('custom_api.message_data_added_successfully'), true, 200));
                    } else {
                        return Response::json(generateResponseBody('FC-SS1-0003#signup_step1', $data, __('custom_api.error_something_went_wrong'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-SS1-0004#signup_step1', $data, __('custom_api.error_method_not_supported'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-SS1-0005#signup_step1', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : signupStep2
        * Purpose       : To post user data @ registration second screen
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Country & Phone number
        * Return Value  : 
    */
    public function signupStep2(Request $request) {
        $data       = [];
        $userData   = getTemporaryUserFromHeader($request);

        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $userModel = new User();
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
                        return Response::json(generateResponseBody('FC-SS2-0001#signup_step2', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input      = $request->all();
                        $updateData = TemporaryUser::where('id', $userData['id'])->update($input);

                        if ($updateData) {
                            $updatedUserData        = TemporaryUser::where('id', $userData['id'])->first();
                            $data['user_details']   = new TemporaryUserResource($updatedUserData);

                            return Response::json(generateResponseBody('FC-SS2-0002#signup_step2', $data, __('custom_api.message_data_added_successfully'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-SS2-0003#signup_step2', $data, __('custom_api.error_something_went_wrong'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-SS2-0004#signup_step2', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-SS2-0002#signup_step2', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-SS2-0003#signup_step2', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
    /*
        * Function name : signupStep3
        * Purpose       : To post user data @ registration third screen
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Password
        * Return Value  : 
    */
    public function signupStep3(Request $request) {
        $data       = [];
        $userData   = getTemporaryUserFromHeader($request);

        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
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
                        return Response::json(generateResponseBody('FC-SS3-0001#signup_step3', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        $input['password'] = $request->password;

                        $updateData = TemporaryUser::where('id', $userData['id'])->update($input);

                        if ($updateData) {
                            $updatedUserData        = TemporaryUser::where('id', $userData['id'])->first();
                            $data['user_details']   = new TemporaryUserResource($updatedUserData);

                            return Response::json(generateResponseBody('FC-SS3-0003#signup_step3', $data, __('custom_api.message_data_added_successfully'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-SS3-0003#signup_step3', $data, __('custom_api.error_something_went_wrong'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-SS3-0003#signup_step3', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-SS2-0003#signup_step3', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-SS2-0004#signup_step3', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : signupStep4
        * Purpose       : To post user data @ registration fourth screen
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : Repeat password
        * Return Value  : 
    */
    public function signupStep4(Request $request) {
        $data       = [];
        $userData   = getTemporaryUserFromHeader($request);

        try {
            if ($userData != null) {
                if ($request->isMethod('PATCH')) {
                    $userModel = new User();
                    $validation = \Validator::make($request->all(),
                        [
                            'repeat_password'  => 'required',
                        ],
                        [
                            'repeat_password.required'   => __('custom_api.error_repeat_passcode'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-SS4-0001#signup_step4', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input = $request->all();
                        $hashedPassword = $userData['password'];

                        if ($request->repeat_password == $hashedPassword) {
                            $userModel->first_name  = $userData['first_name'];
                            $userModel->last_name   = $userData['last_name'];
                            $userModel->full_name   = $userData['full_name'];
                            $userModel->email       = $userData['email'];
                            $userModel->phone_no    = $userData['phone_no'];
                            $userModel->password    = $userData['password'];
                            $userModel->country_id  = $userData['country_id'];
                            $userModel->device_token= $userData['device_token'];
                            if ($userModel->save()) {
                                Auth::guard('web')->loginUsingId($userModel->id);

                                $authenticatedToken = Hash::make(md5($userModel->id).env('APP_KEY'));
                                    
                                $userModel->auth_token      = $authenticatedToken;
                                $userModel->lastlogintime   = strtotime(getCurrentFullDateTime());
                                $userModel->save();

                                // Move records from temporary_users table to users table
                                TemporaryUser::where('id', $userData['id'])->delete();

                                $data['user_details']   = new UserResource($userModel);
                                
                                return Response::json(generateResponseBody('FC-SS4-0002#signup_step4', $data, __('custom_api.message_account_created_wait_for_activation'), true, 200));
                            } else {
                                return Response::json(generateResponseBody('FC-SS4-0008#signup_step4', $data, __('custom_api.error_something_went_wrong'), false, 400));
                            }
                        } else {
                            return Response::json(generateResponseBody('FC-SS4-0004#signup_step4', $data, __('custom_api.error_passcode_not_matched'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-SS4-0005#signup_step4', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-SS4-0006#signup_step4', $data, __('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-SS4-0007#signup_step4', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
}