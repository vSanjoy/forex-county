<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransfer;
use App\Traits\GeneralMethods;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;


class MoneyTransferController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'MoneyTransfer';
    public $management;
    public $modelName       = 'MoneyTransfer';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'money-transfer';
    public $listUrl         = 'money-transfer.list';
    public $listRequestUrl  = 'money-transfer.ajax-list-request';
    public $createUrl       = 'money-transfer.create';
    public $editUrl         = 'money-transfer.edit';
    public $viewUrl         = 'money-transfer.view';
    public $statusUrl       = 'money-transfer.change-status';
    public $deleteUrl       = 'money-transfer.delete';
    public $viewFolderPath  = 'admin.money-transfer';
    public $model           = 'MoneyTransfer';
    public $as              = 'MoneyTransfer';

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

        $this->management   = __('custom_admin.label_money_transfer');
        $this->model        = new MoneyTransfer();

        // Assign breadcrumb
        $this->assignBreadcrumb();

        // Variables assign for view page
        $this->assignShareVariables();
    }

    /*
        * Function name : list
        * Purpose       : This function is for the listing and searching
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns to the list page
    */
    public function list() {
        $data = [
            'pageTitle'     => __('custom_admin.label_money_transfer_list'),
            'panelTitle'    => __('custom_admin.label_money_transfer_list'),
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
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns data
    */
    public function ajaxListRequest(Request $request) {
        $data = [
            'pageTitle'     => __('custom_admin.label_country_list'),
            'panelTitle'    => __('custom_admin.label_country_list')
        ];

        try {
            if ($request->ajax()) {
                // From Date
                $fromDate           = $fromFormattedDate = $request->from_date;
                $filterByFromDate   = false;
                if ($fromDate != '') {
                    $filterByFromDate   = true;
                    $filter['from_date']= $fromDate;
                    $fromFormattedDate  = Carbon::createFromFormat('m/d/Y', $fromDate)->format('Y-m-d');
                }
                // To Date
                $toDate             = $toFormattedDate = $request->to_date;
                $filterByToDate     = false;
                if ($toDate != '') {
                    $filterByToDate     = true;
                    $filter['to_date']  = $toDate;
                    $toFormattedDate    = Carbon::createFromFormat('m/d/Y', $toDate)->format('Y-m-d');
                }

                // Main query
                $data = $this->model->where('id', '<>', 1);

                // From date
                if ($filterByFromDate) {
                    $data = $data->where('transfer_datetime', '>=', $fromFormattedDate);
                }
                // To date
                if ($filterByToDate) {
                    $data = $data->where('transfer_datetime', '<=', $toFormattedDate);
                }

                $data = $data->orderBy('id','DESC')->get();

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
                        return $row->senderDetails->full_name ?? null;
                    })
                    ->addColumn('recipient_id', function ($row) {
                        return $row->receiverDetails->full_name ?? null;
                    })
                    ->addColumn('transfer_no', function ($row) {
                        return $row->transfer_no ?? null;
                    })
                    ->addColumn('payment_status', function ($row) {
                        if ($row->payment_status == 'P') :
                            return __('custom_admin.label_paid');
                        elseif ($row->payment_status == 'U') :
                            return __('custom_admin.label_unpaid');
                        else :
                            return __('custom_admin.label_paid_but_in_verification');
                        endif;
                    })
                    ->addColumn('forex_country_transfer_status', function ($row) {
                        return $row->forex_country_transfer_status == 'P' ? __('custom_admin.label_paid') : __('custom_admin.label_unpaid');
                    })
                    ->addColumn('transfer_datetime', function ($row) {
                        return changeDateFormat($row->transfer_datetime);
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == '0') :
                            return __('custom_admin.label_pending');
                        elseif ($row->status == '1') :
                            return __('custom_admin.label_completed');
                        elseif ($row->status == '2') :
                                return __('custom_admin.label_more_details_required');
                        elseif ($row->status == '3') :
                            return __('custom_admin.label_cancelled');
                        elseif ($row->status == '4') :
                            return __('custom_admin.label_proceed_to_pay');
                        else :
                            return __('custom_admin.label_in_verification');
                        endif;
                    })
                    ->addColumn('action', function ($row) use ($isAllow, $allowedRoutes) {
                        $btn = '';
                        if ($isAllow || in_array($this->viewUrl, $allowedRoutes)) {
                            $viewUrl = route($this->routePrefix.'.'.$this->viewUrl, customEncryptionDecryption($row->id));

                            $btn .= '<a href="'.$viewUrl.'" class="btn rounded-pill btn-icon btn-outline-info btn-small" title="'.__('custom_admin.label_view').'"><i class="bx bxs-bullseye"></i></a>';
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

    public function edit(Request $request, MoneyTransfer $money) {
        $data = [
            'pageTitle'     => __('custom_admin.label_view_money_transfer'),
            'panelTitle'    => __('custom_admin.label_view_money_transfer'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['moneyTransfer']    = $money;
            return view($this->viewFolderPath.'.view', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return redirect()->route($this->routePrefix.'.'.$this->listUrl);
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return redirect()->route($this->routePrefix.'.'.$this->listUrl);
        }
    }
}
