<?php
/*****************************************************/
# Company Name      :
# Author            :
# Created Date      : 20/01/2023
# Page/Class name   : CurrencyController
# Purpose           : Currency Management
/*****************************************************/

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Traits\GeneralMethods;
use DataTables;


class CurrencyController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'Currency';
    public $management;
    public $modelName       = 'Currency';
    public $breadcrumb;
    public $routePrefix     = 'admin';
    public $pageRoute       = 'currency';
    public $listUrl         = 'currency.list';
    public $listRequestUrl  = 'currency.ajax-list-request';
    public $createUrl       = 'currency.create';
    public $editUrl         = 'currency.edit';
    public $statusUrl       = 'currency.change-status';
    public $deleteUrl       = 'currency.delete';
    public $viewFolderPath  = 'admin.currency';
    public $model           = 'Currency';
    public $as              = 'Currency';

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
        $this->model        = new Currency();

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
            'pageTitle'     => trans('custom_admin.label_currency_list'),
            'panelTitle'    => trans('custom_admin.label_currency_list'),
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
            'pageTitle'     => trans('custom_admin.label_currency_list'),
            'panelTitle'    => trans('custom_admin.label_currency_list')
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
                        ->addColumn('country_id', function ($row) {
                            return $row->country_id ?? null;
                        })
                        ->addColumn('currency', function ($row) {
                            return $row->currency.' ('.$row->three_digit_currency_code.')' ?? null;
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
            'pageTitle'     => trans('custom_admin.label_create_currency'),
            'panelTitle'    => trans('custom_admin.label_create_currency'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            $data['countries']      = Country::where(['status' => '1'])->pluck('countryname', 'id');
            $data['otherCurrencies']= Currency::where(['status' => '1'])->with(['countryDetails'])->get();

            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'country_id'                => 'required',
                    'currency'                  => 'required|unique:'.($this->model)->getTable().',currency,NULL,id,deleted_at,NULL',
                    'three_digit_currency_code' => 'required|max:3',
                    'serial_number'             => 'required',
                    'image'                     => 'required|mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'country_id.required'               => trans('custom_admin.error_country_id'),
                    'currency.required'                 => trans('custom_admin.error_currency'),
                    'three_digit_currency_code.unique'  => trans('custom_admin.error_three_digit_currency_code'),
                    'serial_number.required'            => trans('custom_admin.error_serial_number'),
                    'image.mimes'                       => trans('custom_admin.error_image_mimes')
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
                        $uploadedImage  = singleImageUpload($this->modelName, $image, 'bank_image', $this->pageRoute, true);
                        $input['image'] = $uploadedImage;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
