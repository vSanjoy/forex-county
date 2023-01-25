@extends('admin.layouts.app', ['title' => $panelTitle])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        @include('admin.includes.breadcrumb')
        <!-- / Breadcrumb -->

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ $panelTitle }}</h5>
                    <div class="card-body">
                    {{ Form::open([
                        'method'=> 'POST',
                        'class' => '',
                        'route' => [$routePrefix.'.'.$pageRoute.'.transfer-fees.transfer-fees-edit', customEncryptionDecryption($transferFee->id)],
                        'name'  => 'updateTransferFeesForm',
                        'id'    => 'updateTransferFeesForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_title') }}<span class="red_star">*</span></label>
                                {{ Form::text('title', $transferFee->title ?? null, [
                                                            'id' => 'title',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_title'),
                                                            'required' => true,
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_fees') }}<span class="red_star">*</span></label>
                                {{ Form::text('fees', formatToTwoDecimalPlaces($transferFee->fees) ?? null, [
                                                            'id' => 'fees',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_fees'),
                                                            'required' => true
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_fee_type') }}<span class="red_star">*</span></label>
                                {{ Form::select('fee_type', config('global.FEE_TYPE_DROPDOWN'), $transferFee->fee_type ?? 'F', [
                                                                                                    'id' => 'fee_type',
                                                                                                    'class' => 'form-select',
                                                                                                    'placeholder' => __('custom_admin.placeholder_fee_type'),
                                                                                                    'required' => true,
                                                                                                    ]) }}
                            </div>
                            <div class="col-md-12" id="description-div">
                                <label class="form-label">{{ __('custom_admin.label_description') }}</label>
                                {{ Form::textarea('description', $transferFee->description ?? null, [
                                                                'id' => 'description',
                                                                'class' => 'form-select',
                                                                'placeholder' => __('custom_admin.placeholder_description')
                                                                ]) }}
                            </div>

                            <div class="col-md-12 mt-4">
                                <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel" href="{{ route($routePrefix.'.'.$pageRoute.'.transfer-fees.transfer-fees-list', customEncryptionDecryption($transferFee->currency_id)) }}"><i class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
                                <button type="submit" class="btn rounded-pill btn-primary float-right" id="btn-updating"><i class='bx bx-save'></i> {{ __('custom_admin.btn_update') }}</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection