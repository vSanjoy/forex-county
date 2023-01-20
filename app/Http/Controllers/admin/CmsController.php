<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      : 18/01/2023
# Page/Class name   : CmsController
# Purpose           : CMS Management
/*****************************************************/

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Traits\GeneralMethods;
use App\Models\Cms;
use DataTables;

class CmsController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'Cms';
    public $management;
    public $modelName       = 'Cms';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'cms';
    public $listUrl         = 'cms.list';
    public $listRequestUrl  = 'cms.ajax-list-request';
    public $createUrl       = 'cms.create';
    public $editUrl         = 'cms.edit';
    public $statusUrl       = 'cms.change-status';
    public $deleteUrl       = 'cms.delete';
    public $viewFolderPath  = 'admin.cms';
    public $model           = 'Cms';
    public $as              = 'cms';

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
        $this->model        = new Cms();

        // Assign breadcrumb
        $this->assignBreadcrumb();
        
        // Variables assign for view page
        $this->assignShareVariables();
    }

    /*
        * Function name : list
        * Purpose       : This function is for the listing and searching
        * Author        :
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns to the list page
    */
    public function list(Request $request) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_cms_list'),
            'panelTitle'    => trans('custom_admin.label_cms_list'),
            'pageType'      => 'LISTPAGE'
        ];

        try {
            // Start :: Manage restriction
            $data['isAllow']    = false;
            $restrictions       = checkingAllowRouteToUser($this->pageRoute.'.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes']  = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view($this->viewFolderPath.'.list', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
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
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns cms data
    */
    public function ajaxListRequest(Request $request) {
        $data['pageTitle'] = trans('custom_admin.label_cms_list');
        $data['panelTitle']= trans('custom_admin.label_cms_list');

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
                        ->addColumn('page_name', function ($row) {
                            return $row->page_name ?? null;
                        })
                        ->addColumn('title', function ($row) {
                            return $row->title ?? null;
                        })
                        ->addColumn('created_at', function ($row) {
                            return changeDateFormat($row->created_at);
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

                                $btn .= '<a href="'.$editLink.'" class="btn rounded-pill btn-icon btn-primary"><i class="bx bx-edit"></i></a>';
                            }
                            if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                                $btn .= ' <a href="javascript: void(0);" class="btn rounded-pill btn-icon btn-danger ms-1 delete" data-action-type="delete" data-id="'.customEncryptionDecryption($row->id).'"><i class="bx bx-trash"></i></a>';
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
        * Purpose       : This function is to create cms page
        * Author        :
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns cms data
    */
    public function create(Request $request, $id = null) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_create_cms'),
            'panelTitle'    => trans('custom_admin.label_create_cms'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'page_name'     => 'required|unique:'.($this->model)->getTable().',page_name,NULL,id,deleted_at,NULL',
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
    }

    /*
        * Function name : edit
        * Purpose       : This function is to edit cms
        * Author        :
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request, Cms $cms = model binding
        * Return Value  : Returns cms data
    */
    public function edit(Request $request, Cms $cms) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_edit_cms'),
            'panelTitle'    => trans('custom_admin.label_edit_cms'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['cms']        = $cms;
            $data['details']    = $details = $cms;
            
            if ($request->isMethod('PUT')) {
                if ($cms->id == null) {
                    $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route($this->pageRoute.'.'.$this->listUrl);
                }
                $validationCondition = array(
                    'page_name'     => 'required|unique:'.($this->model)->getTable().',page_name,'.$cms->id.',id,deleted_at,NULL',
                    'title'         => 'required',
                    'featured_image'=> 'mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE'),
                );
                $validationMessages = array(
                    'page_name.required'    => trans('custom_admin.error_page_name'),
                    'page_name.unique'      => trans('custom_admin.error_name_unique'),
                    'title.required'        => trans('custom_admin.error_title'),
                    'featured_image.mimes'  => trans('custom_admin.error_image_mimes'),
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $input          = $request->all();
                    $input['slug']  = generateUniqueSlug($this->model, trim($request->page_name,' '), $cms->id);

                    $featuredImage              = $request->file('featured_image');
                    $previousFeaturedImage      = null;
                    $unlinkFeaturedImageStatus  = false;
                    $uploadedFeaturedImage      = '';
                    
                    // Featured image upload
                    $featuredImage              = $request->file('featured_image');
                    if ($featuredImage != '') {
                        $uploadedFeaturedImage  = singleImageUpload($this->modelName, $featuredImage, 'featured_image', $this->pageRoute, false);
                        $input['featured_image']= $uploadedFeaturedImage;
                    }
                    $update = $details->update($input);

                    if ($update) {
                        $this->generateNotifyMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->listUrl);
                    } else {
                        $this->generateNotifyMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.edit', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
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
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request, Cms $cms = model binding
        * Return Value  : Returns json
    */
    public function status(Request $request, Cms $cms) {
        $title      = trans('custom_admin.message_error');
        $message    = trans('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                $details = $cms;
                if ($details != null) {
                    if ($details->status == 1) {
                        $details->status = '0';
                        $details->save();
                        
                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else if ($details->status == 0) {
                        $details->status = '1';
                        $details->save();
    
                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    }
                } else {
                    $message = trans('custom_admin.error_invalid');
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
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request, Cms $cms = model binding
        * Return Value  : Returns json
    */
    public function delete(Request $request, Cms $cms) {
        $title      = trans('custom_admin.message_error');
        $message    = trans('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                $details = $cms;
                if ($details != null) {
                    $delete = $details->delete();
                    if ($delete) {
                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_data_deleted_successfully');
                        $type       = 'success';
                    } else {
                        $message    = trans('custom_admin.error_took_place_while_deleting');
                    }
                } else {
                    $message = trans('custom_admin.error_invalid');
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
        * Function name : upload
        * Purpose       : This function is for upload from ckeditor
        * Author        :
        * Created Date  : 18/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Return image preview to ckeditor
    */
    public function upload(Request $request) {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = 'cms_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
        
            $request->file('upload')->move(public_path('images/uploads/'.$this->pageRoute), $fileName);
            $url = asset('images/uploads/'.$this->pageRoute.'/'.$fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

}