@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    <!-- Content -->
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
						'route' => [$routePrefix.'.cms.create'],
						'name'  => 'createCmsForm',
						'id'    => 'createCmsForm',
						'files' => true,
						'novalidate' => true]) }}
						<div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_page_name') }}<span class="red_star">*</span></label>
								{{ Form::text('page_name', null, [
																'id' => 'page_name',
																'class' => 'form-control',
																'placeholder' => __('custom_admin.placeholder_page_name'),
																'required' => true ]) }}
                            </div>
							<div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_title') }}<span class="red_star">*</span></label>
								{{ Form::text('title', null, [
															'id' => 'title',
															'class' => 'form-control',
															'placeholder' => __('custom_admin.placeholder_title'),
															'required' => true
															]) }}
                            </div>
							<div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_short_title') }}</label>
								{{ Form::text('short_title', null, [
																	'id' => 'short_title',
																	'class' => 'form-control',
																	'placeholder' => __('custom_admin.placeholder_short_title')
																	]) }}
                            </div>
							<div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_short_description') }}</label>
								{{ Form::text('short_description', null, [
																		'id' => 'description2',
																		'class' => 'form-control',
																		'placeholder' => __('custom_admin.placeholder_short_description')
																		]) }}
                            </div>
							<div class="col-md-12">
                                <label class="form-label">{{ __('custom_admin.label_description') }}</label>
								{{ Form::textarea('description', null, [
																	'id' => 'description',
																	'class' => 'form-control',
																	'placeholder' => __('custom_admin.placeholder_description')
																	]) }}
                            </div>
							<div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_meta_title') }}</label>
								{{ Form::text('meta_title', null, [
																	'id' => 'meta_title',
																	'class' => 'form-control',
																	'placeholder' => __('custom_admin.placeholder_meta_title')
																	]) }}
                            </div>
							<div class="col-md-6">
                                <label class="form-label">{{ __('custom_admin.label_meta_keywords') }}</label>
								{{ Form::text('meta_keywords', null, [
																	'id' => 'meta_keywords',
																	'class' => 'form-control',
																	'placeholder' => __('custom_admin.placeholder_meta_keywords')
																	]) }}
                            </div>
							<div class="col-md-12">
                                <label class="form-label">{{ __('custom_admin.label_meta_description') }}</label>
								{{ Form::textarea('meta_description', null, [
																			'id' => 'meta_description',
																			'class' => 'form-control',
																			'placeholder' => __('custom_admin.placeholder_meta_description'),
																			'rows' => 2
																			]) }}
                            </div>
                        </div>
						<hr class="my-4 mx-n4">
						<div class="row g-3">
                            <div class="col-md-6 d-flex align-items-start align-items-sm-center gap-3">
								@php $image = asset("images/".config('global.NO_IMAGE')); @endphp
                                
                                <div class="preview_img_div_upload position_relative" style="position: relative;">
                                    <img src="{{ $image }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                    <img id="upload_preview" class="mt-2" style="display: none;" />
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
    <!-- / Content -->
@endsection

@push('scripts')
    @include($routePrefix.'.includes.image_preview')
@endpush
