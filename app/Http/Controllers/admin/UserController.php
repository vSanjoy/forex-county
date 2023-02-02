<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
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

}
