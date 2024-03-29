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
                        'route' => [$routePrefix.'.'.$editUrl, customEncryptionDecryption($user->id)],
                        'name'  => 'updateUserForm',
                        'id'    => 'updateUserForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_user_type') }}
                                    <span class="red_star">*</span>
                                </label>
                                <select class="form-select" name="user_type" id="user_type" >
                                    <option value="P" @if($user->userDetail->user_type == 'P') {{ 'selected' }} @endif >Personal</option>
                                    <option value="B" @if($user->userDetail->user_type == 'B') {{ 'selected' }} @endif >Business</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_first_name') }}<span class="red_star">*</span></label>
                                {{ Form::text('first_name', $user->first_name, [
                                                            'id' => 'first_name',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_first_name'),
                                                            'required' => true
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_last_name') }}<span class="red_star">*</span></label>
                                {{ Form::text('last_name', $user->last_name, [
                                                                    'id' => 'last_name',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_last_name'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_email') }}<span class="red_star">*</span></label>
                                {{ Form::email('email', $user->email, [
                                                                    'id' => 'email',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_email'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">@lang('custom_admin.label_password')</label>
                                {{ Form::password('password', array(
                                        'id' => 'password',
                                        'class' => 'form-control password-checker',
                                        'placeholder' => '············',
                                        'data-pcid'	=> 'new-password-checker',
                                         )) }}
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">@lang('custom_admin.label_confirm_password')</label>
                                {{ Form::password('password_confirmation', array(
                                         'id' => 'password_confirmation',
                                         'class' => 'form-control',
                                         'placeholder' => '············',
                                          )) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_ph_country_code') }}<span class="red_star">*</span></label>
                                {{ Form::text('country_code', $user->userDetail->country_code, [
                                                                    'id' => 'country_code',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_ph_country_code'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_phone') }}<span class="red_star">*</span></label>
                                {{ Form::text('phone_no', $user->phone_no, [
                                                                    'id' => 'phone_no',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_phone'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country') }}
                                    <span class="red_star">*</span>
                                </label>
                                <select name="country" id="country" class="form-select">
                                    @foreach($countries AS $country)
                                        <option value="{{ $country->id}}" @if($user->userDetail->country == $country->id) {{ 'selected' }} @endif >{{ $country->countryname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_address') }}<span class="red_star">*</span></label>
                                {{ Form::text('address', $user->address, [
                                                                    'id' => 'address',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_address'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_city') }}<span class="red_star">*</span></label>
                                {{ Form::text('city', $user->userDetail->city, [
                                                                    'id' => 'city',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_city'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_postcode') }}<span class="red_star">*</span></label>
                                {{ Form::text('post_code', $user->userDetail->post_code, [
                                                                    'id' => 'postcode',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_postcode'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_blockpass_recordid') }}<span class="red_star">*</span></label>
                                {{ Form::text('blockpass_recordid', $user->userDetail->blockpass_recordid, [
                                                                    'id' => 'blockpass_recordid',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_blockpass_recordid'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_blockpass_refid') }}<span class="red_star">*</span></label>
                                {{ Form::text('blockpass_refid', $user->userDetail->blockpass_refid, [
                                                                    'id' => 'blockpass_refid',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_blockpass_refid'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>

                        </div>
                        <hr class="my-4 mx-n4">
                        <div class="mt-4">
                            <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel" href="{{ route($routePrefix.'.'.$listUrl) }}"><i class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
                            <button type="submit" class="btn rounded-pill btn-primary float-right" id="btn-updating"><i class='bx bx-save'></i> {{ __('custom_admin.btn_save') }}</button>
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
