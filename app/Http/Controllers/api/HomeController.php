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
use App\Jobs\SendVerificationCode;
use App\Models\Cms;
use App\Http\Resources\CmsResource;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

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
        return Response::json(generateResponseBody('FC-I-0001#index', $data, trans('custom_api.message_data_fetched_successfully'), true, 200));
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

        return Response::json(generateResponseBody('FC-GT-0002#generate_token', $data, trans('custom_api.message_token_generated_successfully'), true, 200));
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
        if ($id != null) {
            $cmsDetails = Cms::where(['id' => $id, 'status' => '1'])->first();
            if ($cmsDetails != null) {
                $data['cms_details']    = new CmsResource($cmsDetails);
                return Response::json(generateResponseBody('FC-PC-0001#page_content', $data, trans('custom_api.message_data_fetched_successfully'), true, 200));
            } else {
                return Response::json(generateResponseBody('FC-PC-0002#page_content', $data, trans('custom_api.message_no_records_found'), false, 400));
            }
        } else {
            return Response::json(generateResponseBody('FC-PC-0003#page_content', $data, trans('custom_api.message_no_records_found'), false, 400));
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
            return \Response::json(ApiHelper::generateResponseBody('HC-NL-0001#notification_list',  trans('custom.not_authorized'), false, 400));
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