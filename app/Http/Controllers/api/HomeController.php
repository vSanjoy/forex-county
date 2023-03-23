<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      :
# Page/Class name   : HomeController
# Purpose           : API responses
/*****************************************************/
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App;
use Auth;
use Response;
use Validator;
use Hash;
use App\Models\Cms;
use App\Http\Resources\CmsResource;
use App\Models\Country;
use App\Http\Resources\CountryResource;
use App\Models\Support;
use App\Http\Resources\SupportResource;

class HomeController extends Controller
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
        * Function name : index
        * Purpose       : 
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : Landing api
    */
    public function index() {
        $data['index_data'] = "Api for Forex County";
        return Response::json(generateResponseBody('FC-I-0001#index', $data, __('custom_api.message_data_fetched_successfully'), true, 200));
    }
    
    /*
        * Function name : generateToken
        * Purpose       : To generate api auth token
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : Generated api auth token
    */
    public function generateToken() {
        $token              = Hash::make(env('APP_KEY'));
        $data['_authtoken'] = $token;

        return Response::json(generateResponseBody('FC-GT-0002#generate_token', $data, __('custom_api.message_token_generated_successfully'), true, 200));
    }

    /*
        * Function name : pageContent
        * Purpose       : To get details of a page
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function pageContent(Request $request, $id = null) {
        $data = [];

        try {
            if ($id != null) {
                $cmsDetails = Cms::where(['id' => $id, 'status' => '1'])->first();
                if ($cmsDetails != null) {
                    $data['cms_details'] = new CmsResource($cmsDetails);
                    return Response::json(generateResponseBody('FC-PC-0001#page_content', $data, __('custom_api.message_data_fetched_successfully'), true, 200));
                } else {
                    return Response::json(generateResponseBody('FC-PC-0002#page_content', $data, __('custom_api.message_no_records_found'), false, 400));
                }
            } else {
                return Response::json(generateResponseBody('FC-PC-0003#page_content', $data, __('custom_api.message_no_records_found'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-PC-0004#page_content', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : countryList
        * Purpose       : To get list of country
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function countryList(Request $request) {
        $data = [];

        try {
            $countryList = Country::where(['status' => '1'])->whereNotNull(['country_code_for_phone','image'])->whereNull('deleted_at')->orderBy('countryname','ASC')->get();
            if ($countryList != null) {
                $data['country_list'] = CountryResource::collection($countryList);
                return Response::json(generateResponseBody('FC-CL-0001#country_list', $data, __('custom_api.message_data_fetched_successfully'), true, 200));
            } else {
                return Response::json(generateResponseBody('FC-CL-0002#country_list', $data, __('custom_api.message_no_records_found'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-CL-0003#country_list', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }
    
    /*
        * Function name : countryDetails
        * Purpose       : To get country details
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function countryDetails(Request $request, $countryId = null) {
        $data = [];

        try {
            if ($countryId != null) {
                $countryDetails = Country::where(['id' => $countryId, 'status' => '1'])->whereNull('deleted_at')->first();
                if ($countryDetails != null) {
                    $data['country_details'] = new CountryResource($countryDetails);
                    return Response::json(generateResponseBody('FC-CD-0001#country_details', $data, __('custom_api.message_data_fetched_successfully'), true, 200));
                } else {
                    return Response::json(generateResponseBody('FC-CD-0002#country_details', $data, __('custom_api.message_no_records_found'), false, 400));
                }
            } else {
                return Response::json(generateResponseBody('FC-CD-0003#country_details', $data, __('custom_api.error_id_missing'), false, 400));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-CD-0004#country_details', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }

    /*
        * Function name : support
        * Purpose       : To post support data from my account
        * Author        : 
        * Created Date  : 
        * Modified Date :  
        * Input Params  : issue type, question & email for replies
        * Return Value  : 
    */
    public function support(Request $request) {
        $data = [];
        $userData   = getUserFromHeader($request);
        
        try {
            if ($userData != null) {
                if ($request->isMethod('POST')) {
                    $validation = \Validator::make($request->all(),
                        [
                            'issue_type'=> 'required',
                            'question'  => 'required',
                            'email'     => 'required|regex:'.config('global.EMAIL_REGEX'),
                        ],
                        [
                            'issue_type.required'   => __('custom_api.error_issue_type'),
                            'question.required'     => __('custom_api.error_question'),
                            'email.regex'           => __('custom_api.error_valid_email'),
                            'email.unique'          => __('custom_api.error_email_unique'),
                        ]
                    );
                    $errors = $validation->errors()->all();
                    if ($errors) {
                        return Response::json(generateResponseBody('FC-S-0001#support', ['errors' => $errors], __('custom_api.message_validation_error'), false, 400));
                    } else {
                        $input                      = $request->all();
                        $input['user_id']           = $userData['id'];
                        $input['issue_type']        = $request->issue_type ?? null;
                        $input['question']          = $request->question ?? null;
                        $input['email_for_replies'] = $request->email ?? null;

                        $saveData                   = Support::create($input);

                        if ($saveData) {
                            $siteSetting = getSiteSettings();
                            // Mail
                            \Mail::send('emails.api.support_to_admin',
                            [
                                'user'          => $userData,
                                'inputDetails'  => $input,
                                'siteSetting'   => $siteSetting,
                            ], function ($m) use ($userData, $input, $siteSetting) {
                                $m->from($input['email_for_replies'], $userData['full_name']);
                                $m->to($siteSetting->to_email, $siteSetting->website_title)->subject(__('custom_api.label_support').' - '.$siteSetting->website_title);

                                // $m->from('sanjay@virginworkz.com', 'Test');
                                // $m->to('admins@yopmail.com', 'Test 1')->subject(__('custom_api.label_support').' - '.'Test 1');
                            });
                            
                            $data['support_details'] = new SupportResource($saveData);

                            return Response::json(generateResponseBody('FC-S-0002#support', $data, __('custom_api.message_support'), true, 200));
                        } else {
                            return Response::json(generateResponseBody('FC-S-0003#support', $data, __('custom_api.error_something_went_wrong'), false, 400));
                        }
                    }
                } else {
                    return Response::json(generateResponseBody('FC-S-0004#support', $data, __('custom_api.error_method_not_supported'), false, 400));
                }
            } else {
                return Response::json(generateResponseBodyForSignInSignUp('FC-S-0005#support', $data, trans('custom_api.error_invalid_credentials_inactive_user'), false, 401));
            }
        } catch (Exception $e) {
            return Response::json(generateResponseBody('FC-S-0005#support', $data, __('custom_api.error_something_went_wrong'), false, 400));
        }
    }


    

    


    /*****************************************************/
    # HomeController
    # Function name : notificationList
    # Author        :
    # Created Date  : 28-08-2019
    # Purpose       : get notification list
    # Params        : Request $request
    /*****************************************************/
    public function notificationList(Request $request)
    {
        $getSetLang = ApiHelper::getSetLocale($request);
        $lang       = strtoupper($getSetLang);
        $userData  = ApiHelper::getUserFromHeader($request);
        if (!$userData) {
            return \Response::json(ApiHelper::generateResponseBody('HC-NL-0001#notification_list',  __('custom.not_authorized'), false, 400));
        }

        $offset = 0;
        $limit  = Helper::NOTIFICATION_LIMIT;
        $page   = isset($request->page)?$request->page:0;
        if ($page > 0) {
            $offset = ($limit * $page);
        }
        $pushNotification = PushNotification::where("send_to",$userData->id)->orderBy("id","desc");
        $totalNotifications = $pushNotification->count();
        $pushNotification = $pushNotification->skip($offset)
                            ->take($limit)->get();
        $notificationList = array();
        if($pushNotification->count()){
            foreach($pushNotification as $key => $val){
                $notification = array();
                $notification['id'] = $val->id;
                if($lang == "EN"){
                    $notification['message'] = Helper::cleanString($val->message_en);
                }else{
                    $notification['message'] = Helper::cleanString($val->message_ar);
                }
                $notification['type']               = $val->type;
                $notification['order_id']           = $val->order_id ? (string)$val->order_id : "";
                $notification['order_details_id']   = $val->order_details_id ? (string)$val->order_details_id : "";
                $notification['contract_id']        = $val->contract_id ? (string)$val->contract_id : "";
                $notification['bid_id']             = $val->bid_id ? (string)$val->bid_id : "";
                $notification['created_at']         = $val->created_at->format('dS M,Y H:i');
                $notificationList[]                 = $notification;
            }
        }else{
            $totalNotifications = 0;
        }
        return \Response::json(ApiHelper::generateResponseBody('HC-NL-0002#notification_list', ["count"=>$totalNotifications,"list" =>$notificationList]));
    }

    
}