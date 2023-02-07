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
use App\Models\TransferFee;
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
    public $as              = 'currency';

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

        $this->management  = __('custom_admin.label_currency');
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
            'pageTitle'     => __('custom_admin.label_currency_list'),
            'panelTitle'    => __('custom_admin.label_currency_list'),
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
            'pageTitle'     => __('custom_admin.label_currency_list'),
            'panelTitle'    => __('custom_admin.label_currency_list')
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
                            if ($row->countryDetails->image != null && file_exists(public_path('images/uploads/country/'.$row->countryDetails->image))) {
                                $image = asset('images/uploads/country/'.$row->countryDetails->image);
                                if (file_exists(public_path('images/uploads/country/thumbs/'.$row->countryDetails->image))) {
                                    $image = asset('images/uploads/country/thumbs/'.$row->countryDetails->image);
                                }
                            }
                            return $image;
                        })
                        ->addColumn('countryname', function ($row) {
                            return $row->countryDetails->countryname ?? null;
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

                                $btn .= '<a href="'.$editLink.'" class="btn rounded-pill btn-icon btn-outline-primary btn-small" title="'.__('custom_admin.label_edit').'"><i class="bx bx-edit"></i></a>';
                            }
                            if ($isAllow || in_array($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees', $allowedRoutes)) {
                                $transferFeesLink = route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($row->id));

                                $btn .= ' <a href="'.$transferFeesLink.'" class="btn rounded-pill btn-icon btn-outline-info btn-small ms-1" title="'.__('custom_admin.label_transfer_fee').'"><i class="bx bx-money"></i></a>';
                            }
                            if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                                $btn .= ' <a href="javascript: void(0);" class="btn rounded-pill btn-icon btn-outline-danger btn-small ms-1 delete" data-action-type="delete" data-id="'.customEncryptionDecryption($row->id).'" title="'.__('custom_admin.label_delete').'"><i class="bx bx-trash"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['countryname','status','action'])
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
        * Modified date : 23/01/2023
        * Input Params  : Request $request
        * Return Value  : Returns data
    */
    public function create(Request $request) {
        $data = [
            'pageTitle'     => __('custom_admin.label_create_currency'),
            'panelTitle'    => __('custom_admin.label_create_currency'),
            'pageType'      => 'CREATEPAGE'
        ];

        try {
            $data['countries']      = Country::where(['status' => '1'])->pluck('countryname', 'id');
            $data['otherCurrencies']= Currency::where(['status' => '1'])->with(['countryDetails'])->get();

            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'country_id'                => 'required',
                    'currency'                  => 'required|unique:'.($this->model)->getTable().',currency,NULL,id,deleted_at,NULL,country_id,'.$request->input('country_id'),
                    'three_digit_currency_code' => 'required|unique:'.($this->model)->getTable().',three_digit_currency_code,NULL,id,deleted_at,NULL,country_id,'.$request->input('country_id').'|max:3',
                    'serial_number'             => 'required',
                    'image'                     => 'required|mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'country_id.required'               => __('custom_admin.error_country_id'),
                    'currency.required'                 => __('custom_admin.error_currency'),
                    'currency.unique'                   => __('custom_admin.error_currency_unique'),
                    'three_digit_currency_code.required'=> __('custom_admin.error_three_digit_currency_code'),
                    'three_digit_currency_code.unique'  => __('custom_admin.error_three_digit_currency_code_unique'),
                    'serial_number.required'            => __('custom_admin.error_serial_number'),
                    'image.mimes'                       => __('custom_admin.error_image_mimes')
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
                        $uploadedImage  = singleImageUpload($this->modelName, $image, 'bank_image', $this->pageRoute, false, false);
                        $input['image'] = $uploadedImage;

                        // Copy to country folder
                        singleImageUpload($this->modelName, $image, 'bank_image', 'country', false, false);
                    }
                    $input['exchange_rate']     = json_encode($input['exchange_rate_arr']);
                    $input['is_euro_available'] = 'N';
                    $input['is_usd_available']  = 'N';

                    $availableTransferOptions   = [];
                    if ($input['available_transfer_option_arr']) :
                        foreach ($input['available_transfer_option_arr'] as $keyTransfer => $valTransfer) :
                            if (isset($valTransfer['id'])) :
                                $availableTransferOptions[$keyTransfer] = $valTransfer;
                            endif;
                        endforeach;
                        $input['available_transfer_option'] = json_encode($availableTransferOptions);
                    endif;

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
        * Created Date  : 23/01/2023
        * Modified date :
        * Input Params  : Request $request, Currency $currency = model binding
        * Return Value  : Returns data
    */
    public function edit(Request $request, Currency $currency) {
        $data = [
            'pageTitle'     => __('custom_admin.label_edit_currency'),
            'panelTitle'    => __('custom_admin.label_edit_currency'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['countries']              = Country::where(['status' => '1'])->pluck('countryname', 'id');
            $data['otherCurrencies']        = Currency::where(['status' => '1'])->with(['countryDetails'])->get();
            $data['currency']               = $currency;
            $data['details']                = $details = $currency;
            $data['exchangeRate']           = json_decode($currency->exchange_rate, true);
            $data['availableTransferOptions']= json_decode($currency->available_transfer_option, true);
            
            if ($request->isMethod('PUT')) {
                if ($currency->id == null) {
                    $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
                    return to_route($this->routePrefix.'.'.$this->listUrl);
                }
                $validationCondition = array(
                    'country_id'                => 'required',
                    'currency'                  => 'required|unique:'.($this->model)->getTable().',currency,'.$currency->id.',id,deleted_at,NULL,country_id,'.$request->input('country_id'),
                    'three_digit_currency_code' => 'required|unique:'.($this->model)->getTable().',three_digit_currency_code,'.$currency->id.',id,deleted_at,NULL,country_id,'.$request->input('country_id').'|max:3',
                    'serial_number'             => 'required',
                    'image'                     => 'mimes:'.config('global.IMAGE_FILE_TYPES').'|max:'.config('global.IMAGE_MAX_UPLOAD_SIZE')
                );
                $validationMessages = array(
                    'country_id.required'               => __('custom_admin.error_country_id'),
                    'currency.required'                 => __('custom_admin.error_currency'),
                    'currency.unique'                   => __('custom_admin.error_currency_unique'),
                    'three_digit_currency_code.required'=> __('custom_admin.error_three_digit_currency_code'),
                    'three_digit_currency_code.unique'  => __('custom_admin.error_three_digit_currency_code_unique'),
                    'serial_number.required'            => __('custom_admin.error_serial_number'),
                    'image.mimes'                       => __('custom_admin.error_image_mimes')
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
                    $image          = $request->file('image');
                    if ($image != '') {
                        if ($currency['bank_image'] != null) {
                            $previousImage  = $currency['bank_image'];
                            $unlinkStatus   = true;
                        }
                        $uploadedImage      = singleImageUpload($this->modelName, $image, 'bank_image', $this->pageRoute, false, false, $previousImage, $unlinkStatus);
                        $input['bank_image']= $uploadedImage;

                        // Copy to country folder
                        singleImageUpload($this->modelName, $image, 'bank_image', 'country', false, false, $previousImage, $unlinkStatus);
                    }
                    $input['exchange_rate']     = json_encode($input['exchange_rate_arr']);
                    $input['is_euro_available'] = 'N';
                    $input['is_usd_available']  = 'N';

                    $availableTransferOptions   = [];
                    if ($input['available_transfer_option_arr']) :
                        foreach ($input['available_transfer_option_arr'] as $keyTransfer => $valTransfer) :
                            if (isset($valTransfer['id'])) :
                                $availableTransferOptions[$keyTransfer] = $valTransfer;
                            endif;
                        endforeach;
                        $input['available_transfer_option'] = json_encode($availableTransferOptions);
                    endif;

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
        * Created Date  : 23/01/2023
        * Modified date :
        * Input Params  : Request $request, Currency $currency = model binding
        * Return Value  : Returns json
    */
    public function status(Request $request, Currency $currency) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($currency != null) {
                    if ($currency->status == 1) {
                        $currency->status = '0';
                        $currency->save();
                        
                        $title      = __('custom_admin.message_success');
                        $message    = __('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else if ($currency->status == 0) {
                        $currency->status = '1';
                        $currency->save();
    
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
        * Created Date  : 23/01/2023
        * Modified date :
        * Input Params  : Request $request, Currency $currency = model binding
        * Return Value  : Returns json
    */
    public function delete(Request $request, Currency $currency) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($currency != null) {
                    $delete = $currency->delete();
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


    /********************************************* Transfer Fees *********************************************/
    /*
        * Function name : transferFeesList
        * Purpose       : This function is for the listing and searching
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns to the transfer fees list page
    */
    public function transferFeesList(Currency $currency) {
        $data = [
            'pageTitle'     => __('custom_admin.label_transfer_fees_list'),
            'panelTitle'    => __('custom_admin.label_transfer_fees_list'),
            'pageType'      => 'TRANSFERFEESLISTPAGE'
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
            $data['currency']   = $currency;

            return view($this->viewFolderPath.'.transfer_fees_list', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.account.dashboard');
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.account.dashboard');
        }
    }

    /*
        * Function name : ajaxTransferFeesListRequest
        * Purpose       : This function is for the reutrn ajax data
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returnsdata
    */
    public function ajaxTransferFeesListRequest(Request $request, Currency $currency) {
        $data = [
            'pageTitle' => __('custom_admin.label_transfer_fees_list'),
            'panelTitle'=> __('custom_admin.label_transfer_fees_list')
        ];

        try {
            if ($request->ajax()) {
                $data = TransferFee::get();

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
                        ->addColumn('title', function ($row) {
                            return $row->title ?? null;
                        })
                        ->addColumn('fees', function ($row) {
                            return $row->fees ? formatToTwoDecimalPlaces($row->fees) : __('custom_admin.label_na');;
                        })
                        ->addColumn('fee_type', function ($row) {
                            return $row->fee_type == 'F' ? __('custom_admin.label_flat') : __('custom_admin.label_percentage');
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
                                $editLink = route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-edit', [customEncryptionDecryption($row->id)]);

                                $btn .= '<a href="'.$editLink.'" class="btn rounded-pill btn-icon btn-outline-primary btn-small" title="'.__('custom_admin.label_edit').'"><i class="bx bx-edit"></i></a>';
                            }
                            if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                                $btn .= ' <a href="javascript: void(0);" class="btn rounded-pill btn-icon btn-outline-danger btn-small ms-1 delete" data-action-type="delete" data-id="'.customEncryptionDecryption($row->id).'" title="'.__('custom_admin.label_delete').'"><i class="bx bx-trash"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['countryname','status','action'])
                        ->make(true);
            }
            return view($this->viewFolderPath.'.transfer_fees_list');
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return '';
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return '';
        }
    }

    /*
        * Function name : transferFeesCreate
        * Purpose       : This function is to create page
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date : 
        * Input Params  : Request $request, Currency $currency
        * Return Value  : Returns data
    */
    public function transferFeesCreate(Request $request, Currency $currency) {
        $data = [
            'pageTitle'     => __('custom_admin.label_create_transfer_fees'),
            'panelTitle'    => __('custom_admin.label_create_transfer_fees'),
            'pageType'      => 'TRANSFERFEESCREATEPAGE',
            'currency'      => $currency
        ];

        try {
            $data['currency']   = $currency;

            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'title'     => 'required|unique:'.(new TransferFee)->getTable().',title,NULL,id,deleted_at,NULL,country_id,'.$currency->country_id,
                    'fees'      => 'required|regex:'.config('global.VALID_AMOUNT_REGEX'),
                    'fee_type'  => 'required'
                );
                $validationMessages = array(
                    'title.required'    => __('custom_admin.error_title'),
                    'title.unique'      => __('custom_admin.error_title_unique'),
                    'fees.required'     => __('custom_admin.error_fees'),
                    'fees.regex'        => __('custom_admin.error_fees_regex'),
                    'fee_type.required' => __('custom_admin.error_price_regx')
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $input                  = $request->all();
                    $input['currency_id']   = $currency->id ?? null;
                    $input['country_id']    = $currency->countryDetails->id ?? null;

                    $save = TransferFee::create($input);
                    if ($save) {
                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($currency->id));
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.transfer_fees_create', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($currency->id));
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($currency->id));
        }
    }

    /*
        * Function name : transferFeesEdit
        * Purpose       : This function is to edit
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request, TransferFee $transferFee = model binding
        * Return Value  : Returns data
    */
    public function transferFeesEdit(Request $request, TransferFee $transferFee) {
        $data = [
            'pageTitle'     => __('custom_admin.label_edit_currency'),
            'panelTitle'    => __('custom_admin.label_edit_currency'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['transferFee']    = $transferFee;
            
            if ($request->isMethod('PUT')) {
                if ($transferFee->id == null) {
                    $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
                    return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($transferFee->currency_id));
                }
                $validationCondition = array(
                    'title'     => 'required|unique:'.(new TransferFee)->getTable().',title,'.$transferFee->id.',id,deleted_at,NULL,country_id,'.$transferFee->country_id,
                    'fees'      => 'required|regex:'.config('global.VALID_AMOUNT_REGEX'),
                    'fee_type'  => 'required'
                );
                $validationMessages = array(
                    'title.required'    => __('custom_admin.error_title'),
                    'title.unique'      => __('custom_admin.error_title_unique'),
                    'fees.required'     => __('custom_admin.error_fees'),
                    'fees.regex'        => __('custom_admin.error_fees_regex'),
                    'fee_type.required' => __('custom_admin.error_price_regx')
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $input  = $request->all();
                    $update = $transferFee->update($input);

                    if ($update) {
                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($transferFee->currency_id));
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.transfer_fees_edit', $data);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($transferFee->currency_id));
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($transferFee->currency_id));
        }
    }

    /*
        * Function name : transferFeesStatus
        * Purpose       : This function is to status
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request, TransferFee $transferFee = model binding
        * Return Value  : Returns json
    */
    public function transferFeesStatus(Request $request, TransferFee $transferFee) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($transferFee != null) {
                    if ($transferFee->status == 1) {
                        $transferFee->status = '0';
                        $transferFee->save();
                        
                        $title      = __('custom_admin.message_success');
                        $message    = __('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else if ($transferFee->status == 0) {
                        $transferFee->status = '1';
                        $transferFee->save();
    
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
        * Function name : transferFeesDelete
        * Purpose       : This function is to delete record
        * Author        :
        * Created Date  : 23/01/2023
        * Modified date :
        * Input Params  : Request $request, TransferFee $transferFee = model binding
        * Return Value  : Returns json
    */
    public function transferFeesDelete(Request $request, TransferFee $transferFee) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($transferFee != null) {
                    $delete = $transferFee->delete();
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