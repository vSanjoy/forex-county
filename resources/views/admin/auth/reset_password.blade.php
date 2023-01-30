@extends('admin.layouts.auth', ['title' => $pageTitle])

@section('content')
    <!-- Forgot Password -->
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            @include('admin.includes.logo')
            <!-- /Logo -->
            <h4 class="mb-4 text-center">@lang('custom_admin.label_reset_password')</h4>

            {{ Form::open([
                'method' => 'POST',
                'class' => 'mb-3',
                'name' => 'resetPasswordForm',
                'id' => 'resetPasswordForm',
                'files' => true,
                'novalidate' => true,
            ]) }}
            @method('PATCH')
            <div class="mb-3">
                <label for="email" class="form-label">@lang('custom_admin.label_password')<span class="red_star">*</span></label>
                {{ Form::password('password', array(
                        'id' => 'password',
                        'class' => 'form-control password-checker',
                        'placeholder' => '············',
                        'data-pcid'	=> 'new-password-checker',
                        'required' => true )) }}
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">@lang('custom_admin.label_confirm_password')<span class="red_star">*</span></label>
                {{ Form::password('confirm_password', array(
                         'id' => 'confirm_password',
                         'class' => 'form-control',
                         'placeholder' => '············',
                         'required' => true )) }}
            </div>
            <button class="btn rounded-pill btn-primary d-grid w-100" id="btn-processing"><i class='bx bxs-save'></i> @lang('custom_admin.btn_update')</button>
            {{ Form::close() }}

            <div class="text-center">
                <a href="{{ route('admin.auth.login') }}" class="d-flex align-items-center justify-content-center" id="btn-login">
                    <i class='bx bx-chevron-left'></i>
                    @lang('custom_admin.label_back_to_login')
                </a>
            </div>
        </div>
    </div>
    <!-- /Forgot Password -->
@endsection
