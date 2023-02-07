@extends('admin.layouts.app', ['title' => $panelTitle])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        @include('admin.user.user-breadcrumb')
        <!-- / Breadcrumb -->

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ $panelTitle }}</h5>
                    <div class="card-body">
                    {{ Form::open([
                        'method'=> 'POST',
                        'class' => '',
                        'route' => [$routePrefix.'.'.$pageRoute.'.recipient.recipient-edit', customEncryptionDecryption($recipient->id)],
                        'name'  => 'updateRecipientForm',
                        'id'    => 'updateRecipientForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_business_name') }}</label>
                                {{ Form::text('business_name', $recipient->business_name, [
                                                            'id' => 'title',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_business_name')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_email') }}<span class="red_star">*</span></label>
                                {{ Form::email('email_address', $recipient->email_address, [
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
                                    <option value="P" @if($recipient->type == "P") selected @endif >Personal</option>
                                    <option value="B" @if($recipient->type == "B") selected @endif>Business</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_account_holder') }}<span class="red_star">*</span></label>
                                {{ Form::text('account_holder_name', $recipient->account_holder_name, [
                                                            'id' => 'account_holder_name',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_account_holder'),
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_account_number') }}<span class="red_star">*</span></label>
                                {{ Form::text('account_number', $recipient->account_number, [
                                                            'id' => 'account_number',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_account_number')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_iban_number') }}</label>
                                {{ Form::text('iban_number', $recipient->iban_number, [
                                                            'id' => 'iban_number',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_iban_number')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_uk_shortcode') }}</label>
                                {{ Form::text('uk_shortcode', $recipient->uk_shortcode, [
                                                            'id' => 'uk_shortcode',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_uk_shortcode')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_ach_routing_number') }}</label>
                                {{ Form::text('ach_routing_number', $recipient->ach_routing_number, [
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
                                    <option value="C" @if($recipient->account_type == "C") selected @endif>Current</option>
                                    <option value="S" @if($recipient->account_type == "S") selected @endif>Saving</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_beneficiary_bank') }}</label>
                                {{ Form::text('beneficiary_bank', $recipient->beneficiary_bank, [
                                                            'id' => 'beneficiary_bank',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_beneficiary_bank')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_ifsc_code') }}</label>
                                {{ Form::text('ifsc_code', $recipient->ifsc_code, [
                                                            'id' => 'ifsc_code',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_ifsc_code')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country') }}</label>
                                <select name="country" id="country" class="form-select">
                                    @foreach($countries AS $country)
                                        <option value="{{ $country->id}}" @if($recipient->country == $country->id) selected @endif>{{ $country->countryname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_city') }}</label>
                                {{ Form::text('city', $recipient->city, [
                                                            'id' => 'city',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_city')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_address') }}</label>
                                {{ Form::text('address', $recipient->address, [
                                                            'id' => 'address',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_address')
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_postal_code') }}</label>
                                {{ Form::text('postal_code', $recipient->postal_code, [
                                                            'id' => 'postal_code',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_postal_code')
                                                            ]) }}
                            </div>
                            <div class="col-md-12 mt-4">
                                <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel" href="{{ route($routePrefix.'.'.$pageRoute.'.recipient.recipient-list', customEncryptionDecryption($recipient->user_id)) }}"><i class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
                                <button type="submit" class="btn rounded-pill btn-primary float-right" id="btn-updating"><i class='bx bx-save'></i> {{ __('custom_admin.btn_save') }}</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
