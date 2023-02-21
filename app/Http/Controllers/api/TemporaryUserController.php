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
        
        if ($request->isMethod('POST')) {
            $userModel = new User();
            $validation = \Validator::make($request->all(),
                [
                    'first_name'=> 'required',
                    'last_name' => 'required',
                    'email'     => 'regex:'.config('global.EMAIL_REGEX').'|unique:'.$userModel->getTable().',email,NULL,id,deleted_at,NULL',
                ],
                [
                    'first_name.required'   => trans('custom_api.error_first_name'),
                    'last_name.required'    => trans('custom_api.error_last_name'),
                    'email.regex'           => trans('custom_api.error_valid_email'),
                    'email.unique'          => trans('custom_api.error_email_unique'),
                ]
            );
            $errors = $validation->errors()->all();
            if ($errors) {
                return Response::json(generateResponseBody('FC-SS1-0001#signup_step1', ['errors' => $errors], trans('custom_api.message_validation_error'), false, 400));
            } else {
                $input              = $request->all();
                $input['full_name'] = Str::headline($request->first_name.' '.$request->last_name);
                $saveData           = TemporaryUser::create($input);

                if ($saveData) {
                    $saveData->token = Hash::make(md5($saveData->id).env('APP_KEY'));
                    $saveData->save();

                    $data['user_details'] = new TemporaryUserResource($saveData);

                    return Response::json(generateResponseBody('FC-SS1-0002#signup_step1', $data, trans('custom_api.message_data_added_successfully'), true, 200));
                } else {
                    return Response::json(generateResponseBody('FC-SS1-0003#signup_step1', $data, trans('custom_api.error_something_went_wrong'), false, 400));
                }
            }
        } else {
            return Response::json(generateResponseBody('FC-SS1-0004#signup_step1', $data, trans('custom_api.error_something_went_wrong'), false, 400));
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

        if ($userData != null) {
            if ($request->isMethod('POST')) {
                $userModel = new User();
                $validation = \Validator::make($request->all(),
                    [
                        'country_id'=> 'required',
                        'phone_no'  => 'required',
                    ],
                    [
                        'country_id.required'   => trans('custom_api.error_country_id'),
                        'phone_no.required'     => trans('custom_api.error_phone_no'),
                    ]
                );
                $errors = $validation->errors()->all();
                if ($errors) {
                    return Response::json(generateResponseBody('FC-AE-0001#signup_step2', ['errors' => $errors], trans('custom_api.message_validation_error'), false, 400));
                } else {
                    $input      = $request->all();
                    $updateData = TemporaryUser::where('id', $userData['id'])->update($input);

                    if ($updateData) {
                        $updatedUserData        = TemporaryUser::where('id', $userData['id'])->first();
                        $data['user_details']   = new TemporaryUserResource($updatedUserData);

                        return Response::json(generateResponseBody('FC-AE-0002#signup_step2', $data, trans('custom_api.message_data_added_successfully'), true, 200));
                    } else {
                        return Response::json(generateResponseBody('FC-AE-0003#signup_step2', $data, trans('custom_api.error_something_went_wrong'), false, 400));
                    }
                }
            } else {
                return Response::json(generateResponseBody('FC-AE-0004#signup_step2', $data, trans('custom_api.error_something_went_wrong'), false, 400));
            }
        } else {
            return Response::json(generateResponseBodyForSignInSignUp('FC-SS2-0002#signup_step2', $data, trans('custom_api.error_invalid_credentials_inactive_user'), false, 401));
        }
        
    }
    
    
    
}