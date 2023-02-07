@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        @include($routePrefix.'.includes.breadcrumb')
        <!-- / Breadcrumb -->

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ $panelTitle }}</h5>
                    <div class="card-datatable table-responsive">
                        <table id="list-table" class="dt-row-grouping table border-top table-striped">
                            <thead>
                                <tr>
                                    <th class="zeroColumn table-th-display-none"></th>
                                    <th class="firstColumn">@lang('custom_admin.label_hash')</th>
                                    <th>@lang('custom_admin.label_username')</th>
                                    <th>@lang('custom_admin.label_country')</th>
                                    <th>@lang('custom_admin.label_email')</th>
                                    <th>@lang('custom_admin.label_phone')</th>
                                    <th>@lang('custom_admin.label_user_type')</th>
                                    <th>@lang('custom_admin.label_newsletter_subscription')</th>
                                    <th>@lang('custom_admin.label_email_verified')</th>
                                    <th>@lang('custom_admin.label_blockpass_verified')</th>
                                    <th class="row_status">@lang('custom_admin.label_status')</th>
                                    <th class="more_actions">@lang('custom_admin.label_action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- / Content -->
@endsection

@push('scripts')
    @include($routePrefix.'.'.$pageRoute.'.scripts')
@endpush
