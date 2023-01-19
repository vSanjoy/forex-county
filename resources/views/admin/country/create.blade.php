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
                            'name'  => 'createCmsForm',
                            'id'    => 'createCmsForm',
                            'files' => true,
                            'novalidate' => true]) }}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country_name') }}<span
                                        class="red_star">*</span></label>
                                {{ Form::text('country_name', null, [
                                                                'id' => 'page_name',
                                                                'class' => 'form-control',
                                                                'placeholder' => __('custom_admin.placeholder_country_name'),
                                                                'required' => true ]) }}
                            </div>
                            <div class="col-md-6">
                                <label
                                    class="form-label">{{ __('custom_admin.label_two_digit_country_code') }}
                                    <span class="red_star">*</span></label>
                                {{ Form::text('two_digit_country_code', null, [
                                                            'id' => 'two_digit_country_code',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_two_digit_country_code'),
                                                            'required' => true
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_short_three_digit_country_code') }}</label>
                                {{ Form::text('three_digit_country_code', null, [
                                                                    'id' => 'three_digit_country_code',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_short_three_digit_country_code')
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country_code_for_phone') }}</label>
                                {{ Form::text('country_code_for_phone', null, [
                                                                        'id' => 'country_code_for_phone',
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('custom_admin.placeholder_country_code_for_phone')
                                                                        ]) }}
                            </div>

                            {{-- Divider Start --}}
                            <div class="col-md-12">
                                <label for="">Select which details required for bank account add</label>
                                <hr class="my-4">
                            </div>
                            {{-- Divider End --}}


                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_account_holder_name_required') }}</label>
                                    {{ Form::select('is_account_holder_name_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_account_holder_name_required', 'class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_account_number_required') }}</label>
                                    {{ Form::select('is_account_number_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_account_number_required','class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_iban_number_required') }}</label>
                                    {{ Form::select('is_iban_number_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_iban_number_required','class' => 'form-select']) }}
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_uk_sort_code_required') }}</label>
                                    {{ Form::select('is_uk_sort_code_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_uk_sort_code_required', 'class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_ach_routing_number_required') }}</label>
                                    {{ Form::select('is_ach_routing_number_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_ach_routing_number_required','class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_account_type_required') }}</label>
                                    {{ Form::select('is_account_type_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_account_type_required','class' => 'form-select']) }}
                                </div>



                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_beneficiary_bank_required') }}</label>
                                    {{ Form::select('is_beneficiary_bank_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_beneficiary_bank_required', 'class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_ifsc_code_required') }}</label>
                                    {{ Form::select('is_ach_routing_number_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_ifsc_code_required','class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_city_required') }}</label>
                                    {{ Form::select('is_city_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_city_required','class' => 'form-select']) }}
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_address_required') }}</label>
                                    {{ Form::select('is_address_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_address_required', 'class' => 'form-select']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('custom_admin.label_is_postal_code_required') }}</label>
                                    {{ Form::select('is_postal_code_required', ['0' => 'No', 'Y' => 'Yes'], null,
                                                    ['id' => 'is_postal_code_required','class' => 'form-select']) }}
                                </div>


                            <div class="col-md-12 d-flex align-items-start align-items-sm-center gap-3">
                                @php $image = asset("images/".config('global.NO_IMAGE')); @endphp

                                <div class="preview_img_div_upload position_relative" style="position: relative;">
                                    <img src="{{ $image }}" alt="user-avatar" class="d-block rounded" height="100"
                                         width="100" id="uploadedAvatar"/>
                                    <img id="upload_preview" class="mt-2" style="display: none;"/>
                                </div>

                                <div class="button-wrapper">
                                    <label for="upload" class="btn rounded-pill btn-dark mb-4" tabindex="0">
                                        <span class="d-none d-sm-block"><i class='bx bx-upload'></i> {{ __('custom_admin.label_upload_image') }}</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        {{ Form::file('featured_image', [
																		'id' => 'upload',
																		'class' => 'account-file-input upload-image',
																		'hidden' => true
																		]) }}
                                    </label>
                                    <p class="text-muted mb-0">{{ __('custom_admin.message_allowed_file_types', ['fileTypes' => config('global.IMAGE_FILE_TYPES')]) }} </p>
                                </div>
                            </div>
                            <hr class="my-4">
                        </div>


                        <div class="row g-3">
                            <div class="mt-4">
                                <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel"
                                   href="{{ route($routePrefix.'.account.dashboard') }}"><i
                                        class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
                                <button type="submit" class="btn rounded-pill btn-primary float-right" id="btn-saving">
                                    <i class='bx bx-save'></i> {{ __('custom_admin.btn_save') }}</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
