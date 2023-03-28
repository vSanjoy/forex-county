<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Recipient;
use App\Models\User;
use App\Models\UserDetail;
use App\Traits\GeneralMethods;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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

                $data = $this->model->where(['type' => 'C'])->whereNull('deleted_at');
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
                        return $row->userDetail->country_code.' '.$row->phone_no ?? null;
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

                            $btn .= '<a href="' . $editLink . '" class="btn rounded-pill btn-icon btn-outline-primary btn-sm"><i class="bx bx-edit"></i></a>';
                        }
                        if ($isAllow || in_array($this->editUrl, $allowedRoutes)) {
                            $recipientLink = route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($row->id));

                            $btn .= '<a href="' . $recipientLink . '" class="btn rounded-pill btn-icon btn-outline-primary btn-sm ms-1">R</a>';
                        }
                        if ($isAllow || in_array($this->deleteUrl, $allowedRoutes)) {
                            $btn .= ' <a href="javascript: void(0);" class="btn rounded-pill btn-icon btn-outline-danger btn-sm delete" data-action-type="delete" data-id="' . customEncryptionDecryption($row->id) . '"><i class="bx bx-trash"></i></a>';
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

    public function create(Request $request)
    {
        $data = [
            'pageTitle' => trans('custom_admin.label_create_user'),
            'panelTitle' => trans('custom_admin.label_create_user'),
            'pageType' => 'CREATEPAGE'
        ];
        $countries = Country::all(['id', 'countryname']);
        try {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'user_type' => ['required'],
                    'first_name' => ['required'],
                    'last_name' => ['required'],
                    'email'  => ['required', 'unique:users'],
                    'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
                    'country_code' => ['required'],
                    'phone_no' => ['required'],
                    'country' => ['required'],
                    'address' => ['required'],
                    'city' => ['required'],
                    'post_code' => ['required'],
                    'blockpass_recordid' => ['required'],
                    'blockpass_refid' => ['required'],
                );
                $validationMessages = array(
                    'first_name.required'=> trans('custom_admin.error_first_name'),
                    'last_name.required'=> trans('custom_admin.error_last_name'),
                    'email.required'=> trans('custom_admin.error_email'),
                    'email.unique'=> trans('custom_admin.error_email_unique'),
                    'password.required'=> trans('custom_admin.error_password'),
                    'country_code.required'=> trans('custom_admin.error_ph_country_code'),
                    'phone_no.required'=> trans('custom_admin.error_phone_no'),
                    'country.required'=> trans('custom_admin.error_country'),
                    'address.required'=> trans('custom_admin.error_address'),
                    'city.required'=> trans('custom_admin.error_city'),
                    'post_code.required'=> trans('custom_admin.error_postcode'),
                    'blockpass_recordid.required'=> trans('custom_admin.error_blockpass_recordid'),
                    'blockpass_refid.required'=> trans('custom_admin.error_blockpass_refid'),
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $userAttributes = $validator->safe()->only(['first_name', 'last_name', 'email', 'password', 'phone_no','address']);
                    $detailAttributes = $validator->safe()->except(['first_name', 'last_name', 'email', 'password', 'phone_no','address']);
                    $userId = User::create($userAttributes)->id;
                    $detailAttributes['user_id'] = $userId;
                    UserDetail::create($detailAttributes);
                    $this->generateNotifyMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                    return to_route($this->routePrefix . '.' . $this->listUrl);
                }
            }
            return view($this->viewFolderPath . '.create', $data)->with(['countries' => $countries]);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix . '.' . $this->listUrl);
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix . '.' . $this->listUrl);
        }
    }

    public function status(Request $request, User $user)
    {
        $title = trans('custom_admin.message_error');
        $message = trans('custom_admin.error_something_went_wrong');
        $type = 'error';

        try {
            if ($request->ajax()) {
                if ($user != null) {
                    if ($user->status == 1) {
                        $user->status = '0';
                        $user->save();

                        $title = trans('custom_admin.message_success');
                        $message = trans('custom_admin.success_status_updated_successfully');
                        $type = 'success';
                    } else if ($user->status == 0) {
                        $user->status = '1';
                        $user->save();

                        $title = trans('custom_admin.message_success');
                        $message = trans('custom_admin.success_status_updated_successfully');
                        $type = 'success';
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

    public function edit(Request $request, User $user) {
        $data = [
            'pageTitle'     => trans('custom_admin.label_edit_user'),
            'panelTitle'    => trans('custom_admin.label_edit_user'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['countries'] = Country::all(['id', 'countryname']);
            $data['user'] = $user;
            $data['details'] = $details = $user;

            if ($request->isMethod('PUT')) {
                if ($user->id == null) {
                    $this->generateNotifyMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route($this->pageRoute.'.'.$this->listUrl);
                }
                $validationCondition = array(
                    'user_type' => ['required'],
                    'first_name' => ['required'],
                    'last_name' => ['required'],
                    'email'  => ['required', Rule::unique('users')->ignore($user)],
                    // 'country_code' => ['required'],
                    'phone_no' => ['required'],
                    'country' => ['required'],
                    'address' => ['required'],
                    'city' => ['required'],
                    'post_code' => ['required'],
                    'blockpass_recordid' => ['required'],
                    'blockpass_refid' => ['required'],
                );
                $validationMessages = array(
                    'first_name.required'=> trans('custom_admin.error_first_name'),
                    'last_name.required'=> trans('custom_admin.error_last_name'),
                    'email.required'=> trans('custom_admin.error_email'),
                    'email.unique'=> trans('custom_admin.error_email_unique'),
                    // 'country_code.required'=> trans('custom_admin.error_ph_country_code'),
                    'phone_no.required'=> trans('custom_admin.error_phone_no'),
                    'country.required'=> trans('custom_admin.error_country'),
                    'address.required'=> trans('custom_admin.error_address'),
                    'city.required'=> trans('custom_admin.error_city'),
                    'post_code.required'=> trans('custom_admin.error_postcode'),
                    'blockpass_recordid.required'=> trans('custom_admin.error_blockpass_recordid'),
                    'blockpass_refid.required'=> trans('custom_admin.error_blockpass_refid'),
                );

                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                $validator->sometimes('password',
                    [Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'], function ($input) {
                    return $input->password != null;
                });

                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $userAttributes = $validator->safe()->only(['first_name', 'last_name', 'email','password', 'phone_no','address']);
                    $detailAttributes = $validator->safe()->except(['first_name', 'last_name', 'email','password', 'phone_no','address']);
                    $details->update($userAttributes);
                    $details->userDetail->update($detailAttributes);
                    $this->generateNotifyMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                    return to_route($this->routePrefix.'.'.$this->listUrl);
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

    public function delete(Request $request, User $user) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($user != null) {
                    $delete = $user->delete();
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



    /********************************************* Recipient Fees *********************************************/
    /*
        * Function name : transferFeesList
        * Purpose       : This function is for the listing and searching
        * Author        :
        * Created Date  : 24/01/2023
        * Modified date :
        * Input Params  : Request $request
        * Return Value  : Returns to the transfer fees list page
    */
    public function recipientList(User $user) {
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
            $data['user']   = $user;

            return view($this->viewFolderPath.'.recipient_list', $data);
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
    public function ajaxRecipientListRequest(Request $request, User $user) {
        $data = [
            'pageTitle' => __('custom_admin.label_user_list'),
            'panelTitle'=> __('custom_admin.label_user_list')
        ];

        try {
            if ($request->ajax()) {
                $data = $user->recipient;
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
                    ->addColumn('account_holder_name', function ($row) {
                        return $row->account_holder_name ?? null;
                    })
                    ->addColumn('email_address', function ($row) {
                        return $row->email_address ?? null;
                    })
                    ->addColumn('account_number', function ($row) {
                        return $row->account_number ?? null;
                    })
                    ->addColumn('updated_at', function ($row) {
                        return $row->updated_at ?? null;
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
                            $editLink = route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-edit', [customEncryptionDecryption($row->id)]);

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
            return view($this->viewFolderPath.'.recipient_list');
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
    public function recipientCreate(Request $request, User $user) {
        $data = [
            'pageTitle'     => __('custom_admin.label_create_transfer_fees'),
            'panelTitle'    => __('custom_admin.label_create_transfer_fees'),
            'pageType'      => 'TRANSFERFEESCREATEPAGE',
            'user'          => $user
        ];

        try {
            $data['user']   = $user;

            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'email_address' => ['required', 'email'],
                    'account_holder_name' => ['required'],
                    'account_number' => ['required'],
                    'type' => ['required'],

                );
                $validationMessages = array(
                    'email_address.required'    => __('custom_admin.error_email'),
                    'account_holder_name.required'     => __('custom_admin.account_holder_name'),
                    'account_number.required'     => __('custom_admin.account_number'),
                    'type.required'     => __('custom_admin.type'),
                );
                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return back()->withInput();
                } else {
                    $input = $request->all();
                    $input['user_id'] = $user->id;
                    $save = Recipient::create($input);
                    if ($save) {
                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($user->id));
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.recipient_create', $data)->with(['countries' => Country::all()]);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($user->id));
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($user->id));
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
    public function recipientEdit(Request $request, Recipient $recipient) {
        $data = [
            'pageTitle'     => __('custom_admin.label_edit_recipient'),
            'panelTitle'    => __('custom_admin.label_edit_recipient'),
            'pageType'      => 'EDITPAGE'
        ];

        try {
            $data['recipient']    = $recipient;

            if ($request->isMethod('PUT')) {
                if ($recipient->id == null) {
                    $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
                    return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($recipient->user_id));
                }

                $validationCondition = array(
                    'email_address' => ['required', 'email'],
                    'account_holder_name' => ['required'],
                    'account_number' => ['required'],
                    'type' => ['required'],
                );

                $validationMessages = array(
                    'email_address.required'    => __('custom_admin.error_email'),
                    'account_holder_name.required'     => __('custom_admin.account_holder_name'),
                    'account_number.required'     => __('custom_admin.account_number'),
                    'type.required'     => __('custom_admin.type'),
                );

                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);

                if ($validator->fails()) {
                    $validationFailedMessages = validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateNotifyMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $input  = $request->all();
                    $update = $recipient->update($input);

                    if ($update) {
                        $this->generateNotifyMessage('success', __('custom_admin.success_data_updated_successfully'), false);
                        return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($recipient->user_id));
                    } else {
                        $this->generateNotifyMessage('error', __('custom_admin.error_took_place_while_updating'), false);
                        return back()->withInput();
                    }
                }
            }
            return view($this->viewFolderPath.'.recipient_edit', $data)->with(['countries' => Country::all()]);
        } catch (Exception $e) {
            $this->generateNotifyMessage('error', __('custom_admin.error_something_went_wrong'), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($recipient->id));
        } catch (\Throwable $e) {
            $this->generateNotifyMessage('error', $e->getMessage(), false);
            return to_route($this->routePrefix.'.'.$this->pageRoute.'.recipient.recipient-list', customEncryptionDecryption($recipient->id));
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
    public function recipientStatus(Request $request, Recipient $recipient) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($recipient != null) {
                    if ($recipient->status == 1) {
                        $recipient->status = '0';
                        $recipient->save();

                        $title      = __('custom_admin.message_success');
                        $message    = __('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else if ($recipient->status == 0) {
                        $recipient->status = '1';
                        $recipient->save();

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
    public function recipientDelete(Request $request, Recipient $recipient) {
        $title      = __('custom_admin.message_error');
        $message    = __('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                if ($recipient != null) {
                    $delete = $recipient->delete();
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
