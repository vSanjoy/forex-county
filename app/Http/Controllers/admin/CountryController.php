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

        $this->management  = trans('custom_admin.label_cms');
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

    public function create(Request $request)
    {
        $data = [
            'pageTitle'     => trans('custom_admin.label_create_country'),
            'panelTitle'    => trans('custom_admin.label_create_country'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'country_name'     => 'required|unique:'.($this->model)->getTable().',country_name,NULL,id,deleted_at,NULL',
                    'two_digit_country_code'     => 'required|unique:'.($this->model)->getTable().',two_digit_country_code,NULL,id,deleted_at,NULL',
                    'three_digit_country_code'     => 'required|unique:'.($this->model)->getTable().',three_digit_country_code,NULL,id,deleted_at,NULL',
                    'title'         => 'required',
                    'featured_image'=> 'mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'page_name.required'    => trans('custom_admin.error_page_name'),
                    'page_name.unique'      => trans('custom_admin.error_name_unique'),
                    'title.required'        => trans('custom_admin.error_title'),
                    'featured_image.mimes'  => trans('custom_admin.error_image_mimes')
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $input          = $request->all();
                    $input['slug']  = generateUniqueSlug($this->model, trim($request->page_name,' '));
                    // Featured image upload
                    $featuredImage  = $request->file('featured_image');
                    if ($featuredImage != '') {
                        $uploadedFeaturedImage  = singleImageUpload($this->modelName, $featuredImage, 'featured_image', $this->pageRoute, false);
                        $input['featured_image']= $uploadedFeaturedImage;
                    }
                    $save = $this->model->create($input);

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
        return view('admin.country.create', $data);
    }
}
