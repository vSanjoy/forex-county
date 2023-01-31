<script type="text/javascript">
$(document).ready(function() {
	@include('admin.includes.notification')
	
	@if (Route::currentRouteName() == $routePrefix.'.'.$listUrl)
	// Get list page data
	var getListDataUrl = "{{route($routePrefix.'.'.$listRequestUrl)}}";	
	var dTable = $('#list-table').on('init.dt', function () {$('#dataTableLoading').hide(); $('ul.pagination').addClass('pagination-round pagination-dark');}).DataTable({
			destroy: true,
			autoWidth: false,
	        responsive: false,
			processing: true,
			language: {
				search: "_INPUT_",
				searchPlaceholder: '{{ trans("custom_admin.btn_search") }}',
				emptyTable: '{{ trans("custom_admin.message_no_records_found") }}',
				zeroRecords: '{{ trans("custom_admin.message_no_records_found") }}',
				paginate: {
					first: '<i class="bx bx-chevrons-left"></i>',
					previous: '<i class="bx bx-chevron-left"></i>',
					next: '<i class="bx bx-chevron-right"></i>',
					last: '<i class="bx bx-chevrons-right"></i>',
				}
			},
			serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
	        	url: getListDataUrl,
				type: 'POST',
				data: function(data) {},
	        },
	        columns: [
				{data: 'id', name: 'id'},
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
				{data: 'status', name: 'status'},
			@if ($isAllow || in_array($editUrl, $allowedRoutes))
				{data: 'action', name: 'action', orderable: false, searchable: false},
			@endif
	        ],
			columnDefs: [
				{
					targets: [ 0 ],
					visible: false,
					searchable: false,
            	},
			],
	        order: [
				[0, 'asc']
			],
			pageLength: 25,
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '{{trans("custom_admin.label_all")}}']],
			fnDrawCallback: function(settings) {
				if (settings._iDisplayLength == -1 || settings._iDisplayLength > settings.fnRecordsDisplay()) {
            		$('#list-table_paginate').hide();
        		} else {
            		$('#list-table_paginate').show();
        		}
			},
	});
	
	// Prevent alert box from datatable & console error message
	$.fn.dataTable.ext.errMode = 'none';	
	$('#list-table').on('error.dt', function (e, settings, techNote, message) {
		$('#dataTableLoading').hide();
		notyf.error(message, "@lang('custom_admin.message_error')");
	});
	
	// Status section
	$(document).on('click', '.status', function() {
		var id 			= $(this).data('id');
		var actionType 	= $(this).data('action-type');
		listActions('{{ $pageRoute }}', 'status', id, actionType, dTable);
	});
	
	// Delete section
	$(document).on('click', '.delete', function() {
		var id = $(this).data('id');
		var actionType 	= $(this).data('action-type');
		listActions('{{ $pageRoute }}', 'delete', id, actionType, dTable);
	});
	@endif

	// Total checkbox count (For Add & Edit page)
	var totalCheckboxCount = $('input[type=checkbox]').length;
	totalCheckboxCount = totalCheckboxCount - 1;
	
	// Top checkbox to select / deselect all "Check" boxes
	$('.mainSelectDeselectAll').click(function(){
		if ($(this).prop('checked') == true) {
			$(".selectDeselectAll").prop('checked', true);
		} else {
			$(".selectDeselectAll").prop('checked', false);
		}
	});

	// Individual section select / deselect
	$('.select_deselect').click(function(){
		var parentRoute = $(this).data('parentroute');
		if ($(this).prop('checked') == true) {
			$("."+parentRoute).prop('checked', true);

			//If total checkbox (except top checkbox) == all checked checkbox then "Check" the Top checkbox
			var totalCheckedCheckbox = $('input[type=checkbox]:checked').length;
			if (totalCheckedCheckbox == totalCheckboxCount) {
				$('.mainSelectDeselectAll').prop('checked', true);
			}
		} else {
			$("."+parentRoute).prop('checked', false);

			//Top checkbox un-check
			$('.mainSelectDeselectAll').prop('checked', false);
		}
	});

	// Particular child checkbox select / deselect
	$(".setPermission").click(function() {
		var routeClass = $(this).data('class');
		var listIndex = $(this).data('listindex');
		var individualSectionCheckboxCount = $('.'+routeClass).length;
		
		if ($(this).prop('checked') == true) {
			//List/Index checkbox "Check"
			$(this).parents('div.section_class').find('input[type=checkbox]:eq(0)').prop('checked', true);

			var childCheckedCheckboxCount = $('.'+routeClass+':checked').length;
			
			//If child checked checkbox count = total checkbox count under individual section
			if (childCheckedCheckboxCount === individualSectionCheckboxCount) {
				//Individual section checkbox "Check"
				$(this).parents('div.individual_section').find('input[type=checkbox]:eq(0)').prop('checked', true);
			}

			//If Total checkbox count == Total checked checkbox count then "Check" the Top checkbox
			if ( ($('input[type=checkbox]').length - 1) == $('input[type=checkbox]:checked').length) {
				$('.mainSelectDeselectAll').prop('checked', true);
			}
		} else {
			//List/index checkbox un-check then "un-check" all child checkbox
			if (listIndex == routeClass+'_list_index') {
				$('.'+routeClass).prop('checked', false);                
			}
			
			//Individual section checkbox "un-check"
			$(this).parents('div.individual_section').find('input[type=checkbox]:eq(0)').prop('checked', false);

			//Top checkbox "un-check"
			$('.mainSelectDeselectAll').prop('checked', false);
		}
	});

});
</script>