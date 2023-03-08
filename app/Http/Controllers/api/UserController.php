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
        
        if ($request->isMethod('POST')) {
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
                    $getUser->otp   = $this->getRandomPassword();
                    $updateData     = $getUser->save();

                    if ($updateData) {
                        return Response::json(generateResponseBody('FC-FP-0002#forgot_passcode', $data, __('custom_api.message_security_code_sent_successfully'), true, 200));
                    } else {
                        return Response::json(generateResponseBody('FC-FP-0003#forgot_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
                    }
                } else {
                    return Response::json(generateResponseBody('FC-FP-0004#forgot_passcode', $data, __('custom_api.error_invalid_phone_number_inactive_user'), false, 400));
                }
            }
        } else {
            return Response::json(generateResponseBody('FC-FP-0005#forgot_passcode', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
}