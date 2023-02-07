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
                        'route' => [$routePrefix.'.'.$editUrl, customEncryptionDecryption($role->id)],
                        'name'  => 'updateRoleForm',
                        'id'    => 'updateRoleForm',
                        'files' => true,
                        'novalidate' => true]) }}
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">{{ __('custom_admin.label_title') }}<span class="red_star">*</span></label>
                                {{ Form::text('name', $role->name ?? null, [
                                                            'id' => 'name',
                                                            'class' => 'form-control',
                                                            'placeholder' => __('custom_admin.placeholder_title'),
                                                            'required' => true ]) }}
                            </div>
                        </div>
                        <hr class="my-4 mx-n4">
                        <div class="row g-3">
                            <!-- Permission section -->
                            <div class="col-md-12 gap-3">
                                <div class="permission-title form-check background-white">
                                    <div>
                                        <input type="checkbox" class="form-check-input cursor-pointer checkAll mainSelectDeselectAll" id="customCheck2All">
                                        <label class="form-check-label cursor-pointer" for="customCheck2All">
                                            <strong>@lang('custom_admin.label_select_deselect_all')</strong>
                                        </label>
                                    </div>
                                </div>

                                @if (count($routeCollection) > 0)
								@php $h = 1; @endphp
								@foreach ($routeCollection as $group => $groupRow)
									@php $mainLabel = $group; @endphp
									<div class="col-md-12 individual_section">
										<div class="permission-title">
											<h2><strong>{{ ucwords($mainLabel) }}</strong></h2>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="form-check-input cursor-pointer checkAll select_deselect selectDeselectAll" id="customCheck{{$h}}" data-parentRoute="{{ $group }}" id="checkboxSuccess{{$h}}">
												<label class="text-dark cursor-pointer ms-1" for="customCheck{{$h}}">
													@lang('custom_admin.label_select_deselect_all')
												</label>
											</div>
										</div>
										<div class="permission-content section_class">
											<ul>
                                            @php $listOrIndex = 1; $individualCheckedCount = 0; @endphp
											@foreach($groupRow as $row)
												@php
												$groupClass = str_replace(' ','_',$group);

												$labelName = str_replace(['admin.','.','-',$group], ['',' ',' ',''], $row['path']);
												if (strpos(trim($labelName), 'index') !== false) {
													$labelName = str_replace('index','List',$labelName);
												} else if (strpos($labelName, 'transfer fees transfer fees') !== false) {
                                                    $labelName = str_replace('transfer fees transfer fees','transfer fees',$labelName);
                                                } else if (strpos($labelName, 'money transfer') !== false) {
                                                    $labelName = str_replace('money transfer','',$labelName);
                                                }
												
												$subClass = str_replace('.','_',$row['path']);

												$listIndexClass = '';
												if ($listOrIndex == 1) $listIndexClass = $group.'_list_index';

                                                if (in_array($row['role_page_id'], $existingPermission)) {
                                                    $individualCheckedCount++;
                                                }
												@endphp
												<li>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" name="role_page_ids[]" value="{{$row['role_page_id']}}" @if(in_array($row['role_page_id'], $existingPermission))checked @endif data-page="{{ $group }}" data-path="{{ $row['path'] }}" data-class="{{ $groupClass }}" data-listIndex="{{$listIndexClass}}" class="form-check-input checkAll setPermission {{ $groupClass }} {{ $subClass }} selectDeselectAll" id="customCheck_{{$h}}_{{$listOrIndex}}">
														<label class="text-dark cursor-pointer" for="customCheck_{{$h}}_{{$listOrIndex}}">
															{{ ucwords($labelName) }}
														</label>
													</div>
												</li>
												@if(count($groupRow) == $individualCheckedCount)
                                                    <script>
                                                    $(document).ready(function(){
                                                        $('.{{$groupClass}}').parents('div.individual_section').find('input[type=checkbox]:eq(0)').prop('checked', true);
                                                    });
                                                    </script>
                                                @php
                                                endif;
                                                $listOrIndex++;
                                                @endphp
											@endforeach
											</ul>
										</div>
									</div>
									@php $h++; @endphp
								@endforeach
							@endif
                            </div>
                            <!-- / Permission section -->

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
    @include($routePrefix.'.'.$pageRoute.'.scripts')
@endpush