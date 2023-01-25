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
                        'route' => [$routePrefix.'.'.$editUrl, customEncryptionDecryption($bank->id)],
                        'name'  => 'updateBankForm',
                        'id'    => 'updateBankForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country_name') }}
                                    <span class="red_star">*</span>
                                </label>
                                <select name="country_id" id="country_id" class="form-select">
                                    @foreach($countries AS $country)
                                        <option value="{{ $country->id}}" @if($bank->country_id == $country->id) {{ 'selected' }} @endif>
                                            {{ $country->countryname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label
                                    class="form-label">{{ __('custom_admin.placeholder_bank_name') }}<span class="red_star">*</span></label>
                                {{ Form::text('bank_name', $bank->bank_name, [
                                                            'id' => 'bank_name',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_bank_name'),
                                                            'required' => true
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_bank_code') }}<span class="red_star">*</span></label>
                                {{ Form::text('bank_code', $bank->bank_code, [
                                                                    'id' => 'bank_code',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.label_bank_code'),
                                                                    'required' => true
                                                                    ]) }}
                            </div>

                        </div>
                        <hr class="my-4 mx-n4">
                        <div class="row g-3">
                            <div class="col-md-6 d-flex align-items-start align-items-sm-center gap-3">
                                @php
                                    $image = asset("images/".config('global.NO_IMAGE'));
                                    if ($bank->bank_image != null && file_exists(public_path('images/uploads/'.$pageRoute.'/'.$bank->bank_image))) :
                                        $image = asset("images/uploads/".$pageRoute."/".$bank->bank_image);
                                    endif;
                                @endphp

                                <div class="preview_img_div_upload position_relative" style="position: relative;">
                                    <img src="{{ $image }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                    <img id="upload_preview" class="mt-2" style="display: none;" />
                                </div>

                                <div class="button-wrapper">
                                    <label for="upload" class="btn rounded-pill btn-dark mb-4" tabindex="0">
                                        <span class="d-none d-sm-block"><i class='bx bx-upload'></i> {{ __('custom_admin.label_upload_image') }}</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        {{ Form::file('bank_image', [
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

@push('scripts')
    @include($routePrefix.'.includes.image_preview')
@endpush
