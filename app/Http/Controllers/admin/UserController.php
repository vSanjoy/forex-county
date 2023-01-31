<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralMethods;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'User';
    public $management;
    public $modelName       = 'User';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'user';
    public $listUrl         = 'user.list';
    public $listRequestUrl  = 'user.ajax-list-request';
    public $createUrl       = 'user.create';
    public $editUrl         = 'user.edit';
    public $statusUrl       = 'user.change-status';
    public $deleteUrl       = 'user.delete';
    public $viewFolderPath  = 'admin.user';
    public $model           = 'User';
    public $as              = 'User';

    /*
        * Function Name : __construct
        * Purpose       : It sets some public variables for being accessed throughout this
        *                   controller and its related view pages
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function __construct($data = null) {
        parent::__construct();

        $this->management   = __('custom_admin.label_user');
        $this->model        = new User();

        // Assign breadcrumb
        $this->assignBreadcrumb();

        // Variables assign for view page
        $this->assignShareVariables();
    }

    public function list(Request $request)
    {

        $data = [
            'pageTitle' => trans('custom_admin.label_user_list'),
            'panelTitle' => trans('custom_admin.label_user_list'),
            'pageType' => 'LISTPAGE'
        ];

        try {
            // Start :: Manage restriction
            $data['isAllow'] = false;
            $restrictions = checkingAllowRouteToUser($this->pageRoute . '.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes'] = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view($this->viewFolderPath . '.list', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix . '.account.dashboard');
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix . '.account.dashboard');
        }
    }

    public function ajaxListRequest(Request $request)
    {
        $data = [
            'pageTitle' => trans('custom_admin.label_user_list'),
            'panelTitle' => trans('custom_admin.label_user_list')
        ];

        try {
            if ($request->ajax()) {

                $data = $this->model->get();
                // Start :: Manage restriction
                $isAllow = false;
                $restrictions = checkingAllowRouteToUser($this->pageRoute . '.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes = $restrictions['allow_routes'];
                // End :: Manage restriction

                return Datatables::of($data, $isAllow, $allowedRoutes)
                    ->addIndexColumn()
                    ->addColumn('email', function ($row) {
                        return $row->nickname ?? null;
                    })
                    ->addColumn('country', function ($row) {
                        return $row->userDetail->countryDetail->countryname ?? null;
                    })
                    ->addColumn('email', function ($row) {
                        return $row->email ?? null;
                    })
                    ->addColumn('phone_no', function ($row) {
                        return $row->phone_no ?? null;
                    })
                    ->addColumn('user_type', function ($row) {
                        return $row->userDetail->user_type ?? null;
                    })
                    ->addColumn('city', function ($row) {
                        return $row->userDetail->city ?? null;
                    })
                    ->addColumn('is_email_verified', function ($row) {
                        return $row->userDetail->is_email_verified ?? null;
                    })
                    ->addColumn('blockpass_approved', function ($row) {
                        return $row->userDetail->blockpass_approved ?? null;
                    })
                    ->addColumn('status', function ($row) use ($isAllow, $allowedRoutes) {
                        if ($isAllow || in_array($this->statusUrl, $allowedRoutes)) {
                            if ($row->status == '1') {
                                $status = ' <a href="javascript:void(0)" data-id="' . customEncryptionDecryption($row->id) . '" data-action-type="inactive" class="status"><span class="badge rounded-pill bg-success">' . __('custom_admin.label_active') . '</span></a>';
                            } else {
                                $status = ' <a href="javascript:void(0)" data-id="' . customEncryptionDecryption($row->id) . '" data-action-type="active" class="status"><span class="badge rounded-pill bg-danger">' . __('custom_admin.label_inactive') . '</span></a>';
                            }
                        } else {
                            if ($row->status == '1') {
                                $status = ' <a data-microtip-position="top" role="" aria-label="' . __('custom_admin.label_active') . '" class="custom_font"><span class="badge rounded-pill bg-success">' . __('custom_admin.label_active') . '</span></a>';
                            } else {
                                $status = ' <a data-microtip-position="top" role="" aria-label="' . __('custom_admin.label_active') . '" class="custom_font"><span class="badge rounded-pill bg-danger">' . __('custom_admin.label_inactive') . '</span></a>';
                            }
                        }
                        return $status;
                    })
                    ->addColumn('action', function ($row) use ($isAllow, $allowedRoutes) {
                        $btn = '';
                        if ($isAllow || in_array($this->editUrl, $allowedRoutes)) {
                            $editLink = route($this->routePrefix . '.' . $this->editUrl, customEncryptionDecryption($row->id));

                            $btn .= '<a href="' . $editLink . '" class="btn rounded-pill btn-icon btn-primary"><i class="bx bx-edit"></i></a>';
                        }
                        if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                            $btn .= ' <a href="javascript: void(0);" class="btn rounded-pill btn-icon btn-danger ms-1 delete" data-action-type="delete" data-id="' . customEncryptionDecryption($row->id) . '"><i class="bx bx-trash"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
            return view($this->viewFolderPath . '.list');
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return '';
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return '';
        }
    }

}
