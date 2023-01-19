<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\GeneralMethods;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'Country';
    public $management;
    public $modelName       = 'Country';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'country';
    public $listUrl         = 'country.list';
    public $listRequestUrl  = 'country.ajax-list-request';
    public $createUrl       = 'country.create';
    public $editUrl         = 'country.edit';
    public $statusUrl       = 'country.change-status';
    public $deleteUrl       = 'country.delete';
    public $viewFolderPath  = 'admin.country';
    public $model           = 'Country';
    public $as              = 'country';

    /*
        * Function Name : __construct
        * Purpose       : It sets some public variables for being accessed throughout this
        *                   controller and its related view pages
        * Author        :
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function __construct($data = null) {
        parent::__construct();

        $this->management  = trans('custom_admin.label_country');
        $this->model        = new Country();

        // Assign breadcrumb
        $this->assignBreadcrumb();

        // Variables assign for view page
        $this->assignShareVariables();
    }
    public function list()
    {
        $data = [
            'pageTitle'     => trans('custom_admin.label_country_list'),
            'panelTitle'    => trans('custom_admin.label_country_list'),
            'pageType'      => 'LISTPAGE'
        ];
        return view('admin.country.list', $data);
    }

    public function create(Request $request) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_create_country'),
            'panelTitle'    => trans('custom_admin.label_create_country'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'countryname'              => 'required|unique:'.($this->model)->getTable().',countryname,NULL,id,deleted_at,NULL',
                    'code'    => 'required|max:2',
                    'countrycode'  => 'required',
                    'country_code_for_phone'  => 'required',
                    'image'                     => 'required|mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'countryname.required' => trans('custom_admin.error_country_name'),
                    'countryname.unique'   => trans('custom_admin.error_country_unique'),
                    'code.required'         => trans('custom_admin.error_code'),
                    'countrycode.required'  => trans('custom_admin.error_countrycode'),
                    'country_code_for_phone.required'   => trans('custom_admin.error_country_code_for_phone'),
                    'image.mimes'           => trans('custom_admin.error_image'),
                    'image.mimes'           => trans('custom_admin.error_image_mimes')
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $input          = $request->all();
                    
                    // Image upload
                    // $image  = $request->file('featured_image');
                    // if ($image != '') {
                    //     $uploadedImage  = singleImageUpload($this->modelName, $image, 'flag', $this->pageRoute, false);
                    //     $input['image']= $uploadedImage;
                    // }
                    $save = $this->model->create($input);
                    dd('he');

                    if ($save) {
                        $this->generateNotifyMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->listUrl);
                    } else {
                        $this->generateNotifyMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.create', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.'.$this->listUrl);
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.'.$this->listUrl);
        }
    }
}
