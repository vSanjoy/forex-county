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
                        'route' => [$routePrefix.'.'.$pageRoute.'.recipient.recipient-create', customEncryptionDecryption($user->id)],
                        'name'  => 'createRecipientForm',
                        'id'    => 'createRecipientForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_business_name') }}</label>
                                {{ Form::text('business_name', null, [
                                                            'id' => 'title',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_business_name')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_email') }}<span class="red_star">*</span></label>
                                {{ Form::email('email_address', null, [
                                                            'id' => 'email_address',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_email'),
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_type') }}
                                    <span class="red_star">*</span>
                                </label>
                                <select class="form-select" name="type" id="type" >
                                    <option value="P">Personal</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_account_holder') }}<span class="red_star">*</span></label>
                                {{ Form::text('account_holder_name', null, [
                                                            'id' => 'account_holder_name',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_account_holder'),
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_account_number') }}<span class="red_star">*</span></label>
                                {{ Form::text('account_number', null, [
                                                            'id' => 'account_number',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_account_number')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_iban_number') }}</label>
                                {{ Form::text('iban_number', null, [
                                                            'id' => 'iban_number',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_iban_number')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_uk_shortcode') }}</label>
                                {{ Form::text('uk_shortcode', null, [
                                                            'id' => 'uk_shortcode',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_uk_shortcode')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_ach_routing_number') }}</label>
                                {{ Form::text('ach_routing_number', null, [
                                                            'id' => 'ach_routing_number',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_ach_routing_number')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_account_type') }}
                                    <span class="red_star">*</span>
                                </label>
                                <select class="form-select" name="account_type" id="account_type" >
                                    <option value="C">Current</option>
                                    <option value="S">Saving</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_beneficiary_bank') }}</label>
                                {{ Form::text('beneficiary_bank', null, [
                                                            'id' => 'beneficiary_bank',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_beneficiary_bank')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_ifsc_code') }}</label>
                                {{ Form::text('ifsc_code', null, [
                                                            'id' => 'ifsc_code',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_ifsc_code')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country') }}
                                    <span class="red_star">*</span>
                                </label>
                                <select name="country" id="country" class="form-select">
                                    @foreach($countries AS $country)
                                        <option value="{{ $country->id}}">{{ $country->countryname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_city') }}</label>
                                {{ Form::text('city', null, [
                                                            'id' => 'city',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_city')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_address') }}</label>
                                {{ Form::text('address', null, [
                                                            'id' => 'address',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_address')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_postal_code') }}</label>
                                {{ Form::text('postal_code', null, [
                                                            'id' => 'postal_code',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_postal_code')
                                                            ]) }}
                            </div>
                            <div class="col-md-12 mt-4">
                                <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel" href="{{ route($routePrefix.'.'.$pageRoute.'.recipient.recipient-list', customEncryptionDecryption($user->id)) }}"><i class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
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
