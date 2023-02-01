<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      : 20/01/2023
# Page/Class name   : CountryController
# Purpose           : Country Management
/*****************************************************/

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Traits\GeneralMethods;
use DataTables;

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

        $this->management  = __('custom_admin.label_country');
        $this->model       = new Country();

        // Assign breadcrumb
        $this->assignBreadcrumb();

        // Variables assign for view page
        $this->assignShareVariables();
    }

    /*
        * Function name : list
        * Purpose       : This function is for the listing and searching
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns to the list page
    */
    public function list() {
        $data = [
            'pageTitle'     => __('custom_admin.label_country_list'),
            'panelTitle'    => __('custom_admin.label_country_list'),
            'pageType'      => 'LISTPAGE'
        ];

        try {
            // Start :: Manage restriction
            $data['isAllow']    = false;
            $restrictions       = checkingAllowRouteToUser($this->pageRoute.'.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes'] = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view($this->viewFolderPath.'.list', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.account.dashboard');
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.account.dashboard');
        }
    }

    /*
        * Function name : ajaxListRequest
        * Purpose       : This function is for the reutrn ajax data
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returnsdata
    */
    public function ajaxListRequest(Request $request) {
        $data = [
            'pageTitle'     => __('custom_admin.label_country_list'),
            'panelTitle'    => __('custom_admin.label_country_list')
        ];

        try {
            if ($request->ajax()) {
                $data = $this->model->get();

                // Start :: Manage restriction
                $isAllow = false;
                $restrictions   = checkingAllowRouteToUser($this->pageRoute.'.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes  = $restrictions['allow_routes'];
                // End :: Manage restriction                

                return Datatables::of($data, $isAllow, $allowedRoutes)
                        ->addIndexColumn()
                        ->addColumn('image', function ($row) use ($isAllow, $allowedRoutes) {
                            $image = asset('images/'.config('global.NO_IMAGE'));
                            if ($row->image != null && file_exists(public_path('images/uploads/'.$this->pageRoute.'/'.$row->image))) {
                                $image = asset('images/uploads/'.$this->pageRoute.'/'.$row->image);
                                if (file_exists(public_path('images/uploads/'.$this->pageRoute.'/thumbs/'.$row->image))) {
                                    $image = asset('images/uploads/'.$this->pageRoute.'/thumbs/'.$row->image);
                                }
                            }
                            return $image;
                        })
                        ->addColumn('countryname', function ($row) {
                            return $row->countryname.' ('.$row->code.')' ?? null;
                        })
                        ->addColumn('countrycode', function ($row) {
                            return $row->countrycode ?? null;
                        })
                        ->addColumn('updated_at', function ($row) {
                            return changeDateFormat($row->updated_at);
                        })
                        ->addColumn('status', function ($row) use ($isAllow, $allowedRoutes) {
                            if ($isAllow || in_array($this->statusUrl, $allowedRoutes)) {
                                if ($row->status == '1') {
                                    $status = ' <a href="javascript:void(0)" data-id="'.customEncryptionDecryption($row->id).'" data-action-type="inactive" class="status"><span class="badge rounded-pill bg-success">'.__('custom_admin.label_active').'</span></a>';
                                } else {
                                    $status = ' <a href="javascript:void(0)" data-id="'.customEncryptionDecryption($row->id).'" data-action-type="active" class="status"><span class="badge rounded-pill bg-danger">'.__('custom_admin.label_inactive').'</span></a>';
                                }
                            } else {
                                if ($row->status == '1') {
                                    $status = ' <a data-microtip-position="top" role="" aria-label="'.__('custom_admin.label_active').'" class="custom_font"><span class="badge rounded-pill bg-success">'.__('custom_admin.label_active').'</span></a>';
                                } else {
                                    $status = ' <a data-microtip-position="top" role="" aria-label="'.__('custom_admin.label_active').'" class="custom_font"><span class="badge rounded-pill bg-danger">'.__('custom_admin.label_inactive').'</span></a>';
                                }
                            }
                            return $status;
                        })
                        ->addColumn('action', function ($row) use ($isAllow, $allowedRoutes) {
                            $btn = '';
                            if ($isAllow || in_array($this->editUrl, $allowedRoutes)) {
                                $editLink = route($this->routePrefix.'.'.$this->editUrl, customEncryptionDecryption($row->id));

                                $btn .= '<a href="'.$editLink.'" class="btn rounded-pill btn-icon btn-outline-primary btn-small" title="'.__('custom_admin.label_edit').'"><i class="bx bx-edit"></i></a>';
                            }
                            if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                                $btn .= ' <a href="javascript: void(0);" class="btn rounded-pill btn-icon btn-outline-danger btn-small ms-1 delete" data-action-type="delete" data-id="'.customEncryptionDecryption($row->id).'" title="'.__('custom_admin.label_delete').'"><i class="bx bx-trash"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['status','action'])
                        ->make(true);
            }
            return view($this->viewFolderPath.'.list');
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return '';
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return '';
        }
    }

    /*
        * Function name : create
        * Purpose       : This function is to create page
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns data
    */
    public function create(Request $request) {
        $data = [
            'pageTitle'     => __('custom_admin.label_create_country'),
            'panelTitle'    => __('custom_admin.label_create_country'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'countryname'               => 'required|unique:'.($this->model)->getTable().',countryname,NULL,id,deleted_at,NULL',
                    'code'                      => 'required|max:2',
                    'countrycode'               => 'required',
                    'country_code_for_phone'    => 'required',
                    'image'                     => 'required|mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'countryname.required'          => __('custom_admin.error_country_name'),
                    'countryname.unique'            => __('custom_admin.error_country_unique'),
                    'code.required'                 => __('custom_admin.error_code'),
                    'countrycode.required'          => __('custom_admin.error_countrycode'),
                    'country_code_for_phone.required'=> __('custom_admin.error_country_code_for_phone'),
                    'image.required'                => __('custom_admin.error_image'),
                    'image.mimes'                   => __('custom_admin.error_image_mimes')
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $input  = $request->all();

                    // Image upload
                    $image  = $request->file('image');
                    if ($image != '') {
                        $flagName       = strtolower(preg_replace('/\s*/', '', $request->code));
                        $uploadedImage  = singleImageUpload($this->modelName, $image, $flagName, $this->pageRoute, true, false);
                        $input['image'] = $uploadedImage;
                    }
                    $save = $this->model->create($input);

                    if ($save) {
                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->listUrl);
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.create', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.'.$this->listUrl);
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.'.$this->listUrl);
        }
    }

    /*
        * Function name : edit
        * Purpose       : This function is to edit
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Request $request, Country $country = model binding
        * Return Value  : Returns data
    */
    public function edit(Request $request, Country $country) {
        $data = [
            'pageTitle'     => __('custom_admin.label_edit_country'),
            'panelTitle'    => __('custom_admin.label_edit_country'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['country']    = $country;
            $data['details']    = $details = $country;
            
            if ($request->isMethod('PUT')) {
                if ($country->id == null) {
                    $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route($this->pageRoute.'.'.$this->listUrl);
                }
                $validationCondition = array(
                    'countryname'               => 'required|unique:'.($this->model)->getTable().',countryname,'.$country->id.',id,deleted_at,NULL',
                    'code'                      => 'required|max:2',
                    'countrycode'               => 'required',
                    'country_code_for_phone'    => 'required',
                    'image'                     => 'mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'countryname.required'          => __('custom_admin.error_country_name'),
                    'countryname.unique'            => __('custom_admin.error_country_unique'),
                    'code.required'                 => __('custom_admin.error_code'),
                    'countrycode.required'          => __('custom_admin.error_countrycode'),
                    'country_code_for_phone.required'=> __('custom_admin.error_country_code_for_phone'),
                    'image.mimes'                   => __('custom_admin.error_image_mimes')
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $input          = $request->all();
                    $image          = $request->file('image');
                    $previousImage  = null;
                    $unlinkStatus   = false;

                    // Image upload
                    $image              = $request->file('image');
                    if ($image != '') {
                        if ($country['image'] != null) {
                            $previousImage  = $details['image'];
                            $unlinkStatus   = true;
                        }
                        $flagName       = strtolower(preg_replace('/\s*/', '', $request->code));
                        $uploadedImage  = singleImageUpload($this->modelName, $image, $flagName, $this->pageRoute, true, false, $previousImage, $unlinkStatus);
                        $input['image'] = $uploadedImage;
                    }
                    $update = $details->update($input);

                    if ($update) {
                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->listUrl);
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.edit', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return redirect()->route($this->routePrefix.'.'.$this->listUrl);
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return redirect()->route($this->routePrefix.'.'.$this->listUrl);
        }
    }

    /*
        * Function name : status
        * Purpose       : This function is to status
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Request $request, Country $country = model binding
        * Return Value  : Returns json
    */
    public function status(Request $request, Country $country) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($country != null) {
                    if ($country->status == 1) {
                        $country->status = '0';
                        $country->save();
                        
                        $title      = __('custom_admin.message_success');
                        $message    = __('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else if ($country->status == 0) {
                        $country->status = '1';
                        $country->save();
    
                        $title      = __('custom_admin.message_success');
                        $message    = __('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    }
                } else {
                    $message = __('custom_admin.error_invalid');
                }
                
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        } catch (\Throwable $e) {
            $message = $e->getMessage();
        }        
        return response()->json(['title' => $title, 'message' => $message, 'type' => $type]);
    }

    /*
        * Function name : delete
        * Purpose       : This function is to delete record
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Request $request, Country $country = model binding
        * Return Value  : Returns json
    */
    public function delete(Request $request, Country $country) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($country != null) {
                    $delete = $country->delete();
                    if ($delete) {
                        $title      = __('custom_admin.message_success');
                        $message    = __('custom_admin.success_data_deleted_successfully');
                        $type       = 'success';
                    } else {
                        $message    = __('custom_admin.error_took_place_while_deleting');
                    }
                } else {
                    $message = __('custom_admin.error_invalid');
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        } catch (\Throwable $e) {
            $message = $e->getMessage();
        }        
        return response()->json(['title' => $title, 'message' => $message, 'type' => $type]);
    }
}