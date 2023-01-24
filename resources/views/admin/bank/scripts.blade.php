<script type="text/javascript">
$(document).ready(function() {
	@include('admin.includes.notification')

	@if (Route::currentRouteName() == $routePrefix.'.'.$listUrl)
	// Get list page data
	var getListDataUrl = "{{route($routePrefix.'.'.$listRequestUrl)}}";
	var dTable = $('#list-table').on('init.dt', function () {
        $('#dataTableLoading').hide();
        $('ul.pagination').addClass('pagination-round pagination-dark');}).DataTable({
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
				{data: 'bank_name', name: 'bank_name'},
				{data: 'bank_code', name: 'bank_code'},
				{data: 'country_id', name: 'country_id'},
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
				[0, 'desc']
			],
			pageLength: 10,
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

});
</script>
