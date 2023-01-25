@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
		<!-- Breadcrumb -->
		@include('admin.currency.currency-breadcrumb')
		<!-- / Breadcrumb -->

		<div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">
						{{ $panelTitle }} ({{ $currency->countryDetails->countryname.' - '.$currency->currency }})
						<a class="btn rounded-pill btn-dark btn-buy-now text-white float-right" href="{{ route($routePrefix.'.'.$pageRoute.'.transfer-fees.transfer-fees-create', customEncryptionDecryption($currency->id)) }}"><i class='bx bx-plus-circle'></i>&nbsp;{{ __('custom_admin.btn_create') }}</a>
					</h5>
						<div class="card-datatable table-responsive">
							<table id="list-table" class="dt-row-grouping table border-top table-striped">
								<thead>
									<tr>
										<th class="zeroColumn table-th-display-none"></th>
										<th class="firstColumn">@lang('custom_admin.label_hash')</th>
										<th>@lang('custom_admin.label_title')</th>
										<th>@lang('custom_admin.label_fees')</th>
										<th>@lang('custom_admin.label_fee_type')</th>
										<th class="modifiedColumn">@lang('custom_admin.label_modified')</th>
										<th class="row_status">@lang('custom_admin.label_status')</th>
										<th class="actions">@lang('custom_admin.label_action')</th>
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
	@include($routePrefix.'.'.$pageRoute.'.transfer_fees_scripts')
@endpush