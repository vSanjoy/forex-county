<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Country;
use App\Traits\GeneralMethods;
use Illuminate\Http\Request;
use DataTables;

class BankController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'Bank';
    public $management;
    public $modelName       = 'Bank';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'bank';
    public $listUrl         = 'bank.list';
    public $listRequestUrl  = 'bank.ajax-list-request';
    public $createUrl       = 'bank.create';
    public $editUrl         = 'bank.edit';
    public $statusUrl       = 'bank.change-status';
    public $deleteUrl       = 'bank.delete';
    public $viewFolderPath  = 'admin.bank';
    public $model           = 'Bank';
    public $as              = 'bank';

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

        $this->management  = trans('custom_admin.label_bank');
        $this->model        = new Bank();

        // Assign breadcrumb
        $this->assignBreadcrumb();

        // Variables assign for view page
        $this->assignShareVariables();
    }

    public function list(Request $request) {

        $data = [
            'pageTitle'     => trans('custom_admin.label_bank_list'),
            'panelTitle'    => trans('custom_admin.label_bank_list'),
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

    public function ajaxListRequest(Request $request) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_cms_list'),
            'panelTitle'    => trans('custom_admin.label_cms_list')
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
                    ->addColumn('bank_name', function ($row) {
                        return $row->bank_name ?? null;
                    })
                    ->addColumn('bank_code', function ($row) {
                        return $row->bank_code ?? null;
                    })
                    ->addColumn('country_id', function ($row) {
                        return $row->country->countryname ?? null;
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
}
