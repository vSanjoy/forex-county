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
                        'name'  => 'createCurrencyForm',
                        'id'    => 'createCurrencyForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_country') }}<span class="red_star">*</span></label>
                                {{ Form::select('country_id', $countries, null, [
                                                                                'id' => 'country_id',
                                                                                'class' => 'form-select',
                                                                                'placeholder' => __('custom_admin.placeholder_select_country'),
                                                                                'required' => true,
                                                                                ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_title_currency') }}<span class="red_star">*</span></label>
                                {{ Form::text('currency', null, [
                                                            'id' => 'currency',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_currency'),
                                                            'required' => true
                                                            ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_short_three_digit_country_code') }}<span class="red_star">*</span></label>
                                {{ Form::text('three_digit_currency_code', null, [
                                                                    'id' => 'three_digit_currency_code',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_short_three_digit_country_code'),
                                                                    'maxlength' => 3,
                                                                    'required' => true
                                                                    ]) }}
                            </div>
                            
                            <div class="col-md-12 mt-5">
                                <label class="form-label">{{ __('custom_admin.message_courrency_manual_exchange_rate') }}</label>
                                <hr class="mt-0 mb-0">
                            </div>
                        @if ($otherCurrencies)
                            @foreach ($otherCurrencies as $keyCurrency => $valCurrency)
                            <div class="col-md-6">
                                <label class="form-label">{{ $valCurrency->currency. ' ('.$valCurrency->three_digit_currency_code.') - ('.$valCurrency->countryDetails->countryname.')' }}<span class="red_star">*</span></label>
                                {{ Form::text('exchange_rate_arr['.$valCurrency->id.']', null, [
                                                            'id'=>'exchange_rate'.$valCurrency->id,
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_exchange_rate'),
                                                            'required' => true
                                                            ]) }}
                            </div>
                            @endforeach
                        @endif
                        </div>
                        <hr class="my-4 mx-n4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_serial_number') }}<span class="red_star">*</span></label>
                                {{ Form::number('serial_number', null, [
                                                                        'id' => 'serial_number',
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('custom_admin.placeholder_serial_number'),
                                                                        'tabindex'=> 2,
                                                                        'min'=> 0,
                                                                        'required' => true,
                                                                        ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_is_this_currency_will_be_avaliable_for_sender') }}</label>
                                {{ Form::select('show_in_sender', config('global.NO_YES_DROPDOWN'), 'Y', [
                                                                                                    'id' => 'show_in_sender',
                                                                                                    'class' => 'form-select'
                                                                                                    ]) }}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_is_this_currency_will_be_avaliable_for_receiver') }}</label>
                                {{ Form::select('show_in_receiver', config('global.NO_YES_DROPDOWN'), 'Y', [
                                                                                                    'id' => 'show_in_receiver',
                                                                                                    'class' => 'form-select'
                                                                                                    ]) }}
                            </div>

                            <div class="col-md-12 mt-4">
                                <label class="form-label">{{ __('custom_admin.message_courrency_available_transfer_methods') }}</label>
                                <hr class="mt-0 mb-0">
                            </div>
                            @php
                            $availableTransferOptions = [];
                            $moneyTransferMethods = config('global.AVAILABLE_TRANSFER_METHODS');
                            foreach($moneyTransferMethods as $keyMoneyTransferMethods => $valMoneyTransferMethods) :
                                $checkedFlag = false;
                                $text1 = $text2 = null;
                                if (is_array($availableTransferOptions) && array_key_exists($keyMoneyTransferMethods, $availableTransferOptions)) :
                                    $checkedFlag = true;
                                    $text1 = $availableTransferOptions[$keyMoneyTransferMethods]['avaliable_in'];
                                    $text2 = $availableTransferOptions[$keyMoneyTransferMethods]['description'];
                                endif;
                            @endphp
                                <div class="col-md-12">
                                    <div class="form-check form-check-dark">
                                        {!! Form::checkbox('available_transfer_option_arr['.$keyMoneyTransferMethods.'][id]', $keyMoneyTransferMethods, $checkedFlag, [
                                                                                    'class' => 'form-check-input',
                                                                                    'id'=>'customCheckDark_'.$keyMoneyTransferMethods
                                                                                    ]) !!}
                                        <label class="form-check-label" for="customCheckDark_{{ $keyMoneyTransferMethods }}"> {{ $valMoneyTransferMethods }} </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::text('available_transfer_option_arr['.$keyMoneyTransferMethods.'][avaliable_in]', $text1, [
                                                                    'id' => 'available_transfer_option_avaliable_in_'.$keyMoneyTransferMethods,
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_the_money_will_be_available_in_text')
                                                                    ]) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::textarea('available_transfer_option_arr['.$keyMoneyTransferMethods.'][description]', $text2, [
                                                                    'id'=>'available_transfer_option_description_'.$keyMoneyTransferMethods,
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('custom_admin.placeholder_short_description'),
                                                                    'rows' => 2
                                                                    ]) }}
                                </div>
                                <div class="col-md-12 mt-3"></div>
                            @endforeach
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12 d-flex align-items-start align-items-sm-center gap-3">
                                @php $image = asset("images/".config('global.NO_IMAGE')); @endphp
                                <div class="preview_img_div_upload position_relative" style="position: relative;">
                                    <img src="{{ $image }}" alt="" class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
                                    <img id="upload_preview" class="mt-2" style="display: none;"/>
                                </div>
                                <div class="button-wrapper">
                                    <label for="upload" class="btn rounded-pill btn-dark mb-4" tabindex="0">
                                        <span class="d-none d-sm-block"><i class='bx bx-upload'></i> {{ __('custom_admin.label_upload_bank_image') }}</span>
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