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
                        'route' => [$routePrefix.'.'.$createUrl],
                        'name'  => 'createCountryForm',
                        'id'    => 'createCountryForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country_name') }}<span class="red_star">*</span></label>
                                {{ Form::text('countryname', null, [
                                                                'id' => 'countryname',
                                                                'class' => 'form-control',
                                                                'placeholder' => __('custom_admin.placeholder_country_name'),
                                                                'required' => true ]) }}
                            </div>
                            <div class="col-md-6">
                                <label
                                    class="form-label">{{ __('custom_admin.label_two_digit_country_code') }}<span class="red_star">*</span></label>
                                {{ Form::text('code', null, [
                                                            'id' => 'code',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_two_digit_country_code'),
                                                            'maxlength' => 2,
                                                            'required' => true
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_short_three_digit_country_code') }}<span class="red_star">*</span></label>
                                {{ Form::text('countrycode', null, [
                                                                    'id' => 'countrycode',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_short_three_digit_country_code'),
                                                                    'maxlength' => 3,
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country_code_for_phone') }}<span class="red_star">*</span></label>
                                {{ Form::text('country_code_for_phone', null, [
                                                                        'id' => 'country_code_for_phone',
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('custom_admin.placeholder_country_code_for_phone'),
                                                                        'maxlength' => 5,
                                                                        'required' => true
                                                                        ]) }}
                            </div>

                            <div class="col-md-12 mt-5">
                                <label class="form-label">{{ __('custom_admin.message_country_create_edit') }}</label>
                                <hr class="mt-0 mb-0">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_account_holder_name_required') }}</label>
                                {{ Form::select('require_account_holder', config('global.NO_YES_DROPDOWN'), 'Y', [
                                                                                                                'id' => 'require_account_holder',
                                                                                                                'class' => 'form-select'
                                                                                                                ]) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_account_number_required') }}</label>
                                {{ Form::select('require_account_number', config('global.NO_YES_DROPDOWN'), 'Y', [
                                                                                                                'id' => 'require_account_number',
                                                                                                                'class' => 'form-select'
                                                                                                                ]) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_iban_number_required') }}</label>
                                {{ Form::select('require_iban_number', config('global.NO_YES_DROPDOWN'), null,
                                                ['id' => 'require_iban_number','class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_uk_sort_code_required') }}</label>
                                {{ Form::select('require_uk_short_code', config('global.NO_YES_DROPDOWN'), null,
                                                ['id' => 'require_uk_short_code', 'class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_ach_routing_number_required') }}</label>
                                {{ Form::select('require_ach_routing_number', config('global.NO_YES_DROPDOWN'), null,
                                                ['id' => 'require_ach_routing_number','class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_account_type_required') }}</label>
                                {{ Form::select('require_account_type', config('global.NO_YES_DROPDOWN'), 'N',
                                                ['id' => 'require_account_type','class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_beneficiary_bank_required') }}</label>
                                {{ Form::select('require_beneficiary_bank', config('global.NO_YES_DROPDOWN'), 'Y',
                                                ['id' => 'require_beneficiary_bank', 'class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_ifsc_code_required') }}</label>
                                {{ Form::select('require_ifsc_code', config('global.NO_YES_DROPDOWN'), 'N',
                                                ['id' => 'require_ifsc_code','class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_city_required') }}</label>
                                {{ Form::select('require_city', config('global.NO_YES_DROPDOWN'), 'N',
                                                ['id' => 'require_city','class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_address_required') }}</label>
                                {{ Form::select('require_address', config('global.NO_YES_DROPDOWN'), 'N',
                                                ['id' => 'require_address', 'class' => 'form-select']) }}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('custom_admin.label_is_postal_code_required') }}</label>
                                {{ Form::select('require_postal_code', config('global.NO_YES_DROPDOWN'), 'N',
                                                ['id' => 'require_postal_code','class' => 'form-select']) }}
                            </div>
                        </div>
                        <hr class="my-4 mx-n4">
                        <div class="row g-3">
                            <div class="col-md-12 d-flex align-items-start align-items-sm-center gap-3">
                                @php $image = asset("images/".config('global.NO_IMAGE')); @endphp

                                <div class="preview_img_div_upload position_relative" style="position: relative;">
                                    <img src="{{ $image }}" alt="" class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
                                    <img id="upload_preview" class="mt-2" style="display: none;"/>
                                </div>

                                <div class="button-wrapper">
                                    <label for="upload" class="btn rounded-pill btn-dark mb-4" tabindex="0">
                                        <span class="d-none d-sm-block"><i class='bx bx-upload'></i> {{ __('custom_admin.label_upload_image') }}<span class="red_star">*</span></span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        {{ Form::file('image', [
                                                                'id' => 'upload',
                                                                'class' => 'account-file-input upload-image',
                                                                'hidden' => true
                                                                ]) }}
                                    </label>
                                    <p class="text-muted mb-0">{{ __('custom_admin.message_allowed_file_types', ['fileTypes' => config('global.IMAGE_FILE_TYPES')]) }} </p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel" href="{{ route($routePrefix.'.'.$listUrl) }}"><i class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
                                <button type="submit" class="btn rounded-pill btn-primary float-right" id="btn-saving"><i class='bx bx-save'></i> {{ __('custom_admin.btn_save') }}</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include($routePrefix.'.includes.image_preview')
@endpush