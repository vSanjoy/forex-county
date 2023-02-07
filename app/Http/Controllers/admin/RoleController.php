<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      : 31/01/2023
# Page/Class name   : RoleController
# Purpose           : Role Management
/*****************************************************/

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RolePage;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Traits\GeneralMethods;
use DataTables;

class RoleController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'Role';
    public $management;
    public $modelName       = 'Role';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'role';
    public $listUrl         = 'role.list';
    public $listRequestUrl  = 'role.ajax-list-request';
    public $createUrl       = 'role.create';
    public $editUrl         = 'role.edit';
    public $statusUrl       = 'role.change-status';
    public $deleteUrl       = 'role.delete';
    public $viewFolderPath  = 'admin.role';
    public $model           = 'Role';
    public $as              = 'role';

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

        $this->management  = __('custom_admin.label_role');
        $this->model        = new Role();

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
            'pageTitle'     => __('custom_admin.label_role_list'),
            'panelTitle'    => __('custom_admin.label_role_list'),
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
        * Created Date  : 31/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returnsdata
    */
    public function ajaxListRequest(Request $request) {
        $data = [
            'pageTitle'     => __('custom_admin.label_role_list'),
            'panelTitle'    => __('custom_admin.label_role_list')
        ];

        try {
            if ($request->ajax()) {
                $data   = $this->model->where('id', '!=', '1')->get();

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
                        ->addColumn('name', function ($row) {
                            return excerpts($row->name, 10);
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

                                $btn .= '<a href="'.$editLink.'" class="btn btn-icon btn-outline-primary rounded-pill btn-small"><i class="bx bx-edit"></i></a>';
                            }
                            if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                                $btn .= ' <a href="javascript: void(0);" class="btn btn-icon btn-outline-danger rounded-pill btn-small ms-1 delete" data-action-type="delete" data-id="'.customEncryptionDecryption($row->id).'"><i class="bx bx-trash"></i></a>';
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
        * Created Date  : 31/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns data
    */
    public function create(Request $request) {
        $data = [
            'pageTitle'     => __('custom_admin.label_create_role'),
            'panelTitle'    => __('custom_admin.label_create_role'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'name'  => 'required|unique:'.($this->model)->getTable().',name,NULL,id,deleted_at,NULL',
                );
                $validationMessages = array(
                    'name.required' => __('custom_admin.error_role'),
                    'name.unique'   => __('custom_admin.error_role_unique'),
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $input          = $request->all();
                    $input['slug']  = generateUniqueSlug($this->model, trim($request->name,' '));
                    $save           = $this->model->create($input);

                    if ($save) {
                        // Inserting role_page_id into role_permission table
                        if (isset($request->role_page_ids) && count($request->role_page_ids)) {
                            foreach ($request->role_page_ids as $keyRolePageId => $rolePageId) {
                                $rolePermission[$keyRolePageId]['role_id'] = $save->id;
                                $rolePermission[$keyRolePageId]['page_id'] = $rolePageId;
                            }
                            RolePermission::insert($rolePermission);
                        }

                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->listUrl);
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }

            $routeCollection        = self::getRoutes();
            $data['routeCollection']= $routeCollection;

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
        * Input Params  : Request $request, Role $role = model binding
        * Return Value  : Returns data
    */
    public function edit(Request $request, Role $role) {
        $data = [
            'pageTitle'     => __('custom_admin.label_edit_role'),
            'panelTitle'    => __('custom_admin.label_edit_role'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['role']   = $role;
            
            if ($request->isMethod('PUT')) {
                if ($role->id == null) {
                    $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route($this->pageRoute.'.'.$this->listUrl);
                }
                $validationCondition = array(
                    'name' => 'required|unique:'.($this->model)->getTable().',name,'.$role->id.',id,deleted_at,NULL',
                );
                $validationMessages = array(
                    'name.required' => __('custom_admin.error_role'),
                    'name.unique'   => __('custom_admin.error_role_unique'),
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $input          = $request->all();
                    $input['slug']  = generateUniqueSlug($this->model, trim($request->name,' '), $role->id);
                    $update         = $role->update($input);

                    if ($update) {
                        // Deleting and Inserting role_page_id into role_permission table
                        $deleteRolePermissions = RolePermission::where('role_id', $role->id)->delete();
                        if (isset($request->role_page_ids) && count($request->role_page_ids)) {
                            foreach ($request->role_page_ids as $keyRolePageId => $rolePageId) {
                                $rolePermission[$keyRolePageId]['role_id'] = $role->id;
                                $rolePermission[$keyRolePageId]['page_id'] = $rolePageId;
                            }
                            RolePermission::insert($rolePermission);
                        }

                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->listUrl);
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }

            $existingPermission = [];
            if (count($role->permissions) > 0) {
                foreach ($role->permissions as $permission) {
                    $existingPermission[] = $permission['page_id'];
                }
            }
            $routeCollection            = self::getRoutes();
            $data['routeCollection']    = $routeCollection;
            $data['existingPermission'] = $existingPermission;
            
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
        * Created Date  : 31/01/2023
        * Modified date :
        * Input Params  : Request $request, Role $role = model binding
        * Return Value  : Returns json
    */
    public function status(Request $request, Role $role) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($role != null) {
                    if ($role->status == 1) {
                        $isRelatedWithAnotherTable = UserRole::where('role_id', $role->id)->count();
                        if ($isRelatedWithAnotherTable > 0) {
                            $title      = __('custom_admin.message_warning');
                            $message    = __('custom_admin.message_inactive_related_records_exist');
                            $type       = 'warning';
                        } else {
                            $role->status = '0';
                            $role->save();
                            
                            $title      = __('custom_admin.message_success');
                            $message    = __('custom_admin.success_status_updated_successfully');
                            $type       = 'success';
                        }
                    } else if ($role->status == 0) {
                        $role->status = '1';
                        $role->save();
    
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
        * Created Date  : 31/01/2023
        * Modified date :
        * Input Params  : Request $request, Role $role = model binding
        * Return Value  : Returns json
    */
    public function delete(Request $request, Role $role) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($role != null) {
                    $isRelatedWithAnotherTable = UserRole::where('role_id', $role->id)->count();
                    if ($isRelatedWithAnotherTable > 0) {
                        $message = __('custom_admin.error_role_user');
                    } else {
                        $delete = $role->delete();
                        if ($delete) {
                            RolePermission::where('role_id',$role->id)->delete();
                            $title      = __('custom_admin.message_success');
                            $message    = __('custom_admin.success_data_deleted_successfully');
                            $type       = 'success';
                        } else {
                            $message    = __('custom_admin.error_took_place_while_deleting');
                        }
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
        * Function name : getRoutes
        * Purpose       : This function is to get all routes
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : Returns array
    */
    public function getRoutes() {
        $routeCollection = \Route::getRoutes();

        // echo "<table style='width:100%'>";
        //     echo "<tr>";
        //         echo "<td width='10%'><h4>Serial</h4></td>";
        //         echo "<td width='10%'><h4>HTTP Method</h4></td>";
        //         echo "<td width='10%'><h4>Route</h4></td>";
        //         echo "<td width='10%'><h4>Name</h4></td>";
        //         echo "<td width='70%'><h4>Corresponding Action</h4></td>";
        //     echo "</tr>";
        //     $k = 1;
        //     foreach ($routeCollection as $route) {
        //         $namespace = $route->uri();
        //         if (!in_array("POST", $route->methods)  && strstr($namespace,'adminpanel/') != '' && strstr($route->getName(),'admin') != '') {
        //             echo "<tr>";
        //                 echo "<td>" . $k . "</td>";
        //                 echo "<td>" . $route->methods[0] . "</td>";
        //                 echo "<td>" . $route->uri() . "</td>";
        //                 echo "<td>" . $route->getName() . "</td>";
        //                 echo "<td>" . $route->getActionName() . "</td>";
        //             echo "</tr>";
        //             $k++;
        //         }                
        //     }
        // echo "</table>";
        // die('here');

        $list = [];
        $excludedSections = ['admin.auth.forgot-password','admin.auth.reset-password','admin.auth.logout','admin.account.settings','admin.account.dashboard','role'];
        
        foreach($routeCollection as $route) {
            $namespace = $route->uri();
            
            if (!in_array("POST", $route->methods) && !in_array("PUT", $route->methods) && !in_array("PATCH", $route->methods) && strstr($namespace,'adminpanel/') != '' && strstr($route->getName(),'admin') != '' && !in_array($route->getName(), $excludedSections)) {
                $group = str_replace("admin.", "", $route->getName());
                $group = strstr($group, ".", true);
                
                if ($group) {
                    if (!in_array($group, $excludedSections)) {
                        $pagePath       = explode('admin.',$route->getName());
                        $getPagePath    = $pagePath[1];
                        
                        // Checking route exist in role_pages table or not, if not then insert and get the id
                        $rolePageDetails = RolePage::where('routeName', '=', $getPagePath)->first();
                        if ($rolePageDetails == null) {
                            $rolePageDetails = new RolePage();
                            $rolePageDetails->routeName = $getPagePath;
                            $rolePageDetails->save();
                        }

                        if (!array_key_exists($group, $list)) {
                            $list[$group] = [];
                        }
                        array_push($list[$group], [
                            "method" => $route->methods[0],
                            "uri" => $route->uri(),
                            "path" => $getPagePath,
                            "role_page_id" => $rolePageDetails->id,
                            "group_name" => ($group) ? $group : '',
                            "middleware"=>$route->middleware()
                        ]);
                    }
                }
            }
        }
        return $list;
    }

}