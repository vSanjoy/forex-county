@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        @include($routePrefix.'.includes.breadcrumb')
        <!-- / Breadcrumb -->

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ $panelTitle }}</h5>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="">Sender</label>
                                <input type="text" class="form-control" value="{{ $moneyTransfer->senderDetails->full_name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Receiver</label>
                                <input type="text" class="form-control" value="{{ $moneyTransfer->receiverDetails->full_name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Transfer No.</label>
                                <input type="text" class="form-control" value="{{ $moneyTransfer->transfer_no }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Payment Status</label>
                                <input type="text" class="form-control" value="{{ paymentStatus($moneyTransfer->payment_status) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Transfer Status</label>
                                <input type="text" class="form-control" value="{{ $moneyTransfer->forex_country_transfer_status == 'P' ? __('custom_admin.label_paid') : __('custom_admin.label_unpaid') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Transfer Date</label>
                                <input type="text" class="form-control" value="{{ changeDateFormat($moneyTransfer->transfer_datetime) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Status</label>
                                <input type="text" class="form-control" value="{{ transferStatus($moneyTransfer->status) }}">
                            </div>

                        </div>
                        <div class="mt-4">
                            <a class="btn rounded-pill btn-secondary btn-buy-now text-white" id="btn-cancel" href="{{ route($routePrefix.'.'.$listUrl) }}"><i class='bx bx-left-arrow-circle'></i> {{ __('custom_admin.btn_cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- / Content -->
@endsection
