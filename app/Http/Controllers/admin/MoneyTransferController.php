<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransfer;
use App\Traits\GeneralMethods;
use Illuminate\Http\Request;
use DataTables;

class MoneyTransferController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'MoneyTransfer';
    public $management;
    public $modelName       = 'MoneyTransfer';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'money';
    public $listUrl         = 'money.list';
    public $listRequestUrl  = 'money.ajax-list-request';
    public $createUrl       = 'money.create';
    public $editUrl         = 'money.edit';
    public $statusUrl       = 'money.change-status';
    public $deleteUrl       = 'money.delete';
    public $viewFolderPath  = 'admin.money';
    public $model           = 'MoneyTransfer';
    public $as              = 'MoneyTransfer';

    /*
        * Function Name : __construct
        * Purpose       : It sets some public variables for being accessed throughout this
        *                   controller and its related view pages
        * Author        :
        * Created Date  : 20/01/2023
        * Modified date :
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function __construct($data = null) {
        parent::__construct();

        $this->management  = trans('custom_admin.label_currency');
        $this->model        = new MoneyTransfer();

        // Assign breadcrumb
        $this->assignBreadcrumb();

        // Variables assign for view page
        $this->assignShareVariables();
    }

    public function list() {
        $data = [
            'pageTitle'     => trans('custom_admin.label_money_transfer_list'),
            'panelTitle'    => trans('custom_admin.label_money_transfer_list'),
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
            $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.account.dashboard');
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.account.dashboard');
        }
    }

    public function ajaxListRequest(Request $request) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_country_list'),
            'panelTitle'    => trans('custom_admin.label_country_list')
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
                    ->addColumn('user_id', function ($row) {
                        return $row->user_id ?? null;
                    })
                    ->addColumn('recipient_id', function ($row) {
                        return $row->recipient_id ?? null;
                    })
                    ->addColumn('transfer_no', function ($row) {
                        return $row->transfer_no ?? null;
                    })
                    ->addColumn('payment_status', function ($row) {
                        return $row->payment_status ?? null;
                    })
                    ->addColumn('status', function ($row) {
                        return $row->status ?? null;
                    })
                    ->addColumn('forex_country_transfer_status', function ($row) {
                        return $row->forex_country_transfer_status ?? null;
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
