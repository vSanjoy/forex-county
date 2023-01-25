@php
$fromDate		= $todate = null;
$activeStatus	= $showStatus = '';
$collapse 		= 'collapsed';
if (isset($_GET['from_date']) && $_GET['from_date'] != '') { $fromDate = $_GET['from_date']; }
if (isset($_GET['to_date']) && $_GET['to_date'] != '') { $todate = $_GET['to_date']; }

if ( (isset($_GET['from_date']) && $_GET['from_date'] != '') || (isset($_GET['to_date']) && $_GET['to_date'] != '') ) {
	$activeStatus	= 'active';
	$showStatus		= 'show';
	$collapse		= '';
}
@endphp

<!-- Filter -->
<div class="row mb-4 mtm-20">
    <div class="col-md mb-4 mb-md-0">
        <div class="accordion mt-3" id="accordionExample">
            <div class="card accordion-item {{ $activeStatus }}">
                <h2 class="accordion-header" id="headingOne">
                    <button type="button" class="accordion-button {{ $collapse }}" data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="true" aria-controls="filterSection">
                        <h4 class="card-title mt-15 filter-header-title">Filter</h4>
                    </button>
                </h2>
                <div id="filterSection" class="accordion-collapse collapse {{ $showStatus }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
						<form class="mt-4" id="showFilterStatus">
							<div class="row g-3" id="range">
								<div class="col-md-4">
									{{ Form::text('from_date', $fromDate, [
																'id' => 'from_date',
																'placeholder' => __('custom_admin.label_from'),
																'class' => 'form-control',
																'readonly'=>true
															]) }}
								</div>
								<div class="col-md-4">
								{{ Form::text('to_date', $todate, [
															'id' => 'to_date',
															'placeholder' => __('custom_admin.label_to'),
															'class' => 'form-control',
															'readonly'=>true
														]) }}
								</div>

								<div class="col-md-4 mb-4">
									<button type="button" class="btn rounded-pill btn-icon btn-info btn-small filterList" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="{{ __('custom_admin.label_filter') }}">
										<i class='bx bx-search-alt-2'></i>
									</button>
									<button type="button" class="btn rounded-pill btn-icon btn-dark btn-small m-1 resetFilter" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="{{ __('custom_admin.label_reset') }}">
										<i class='bx bx-reset'></i>
									</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    
</div>
<!--/ Filter -->
