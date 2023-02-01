<script type="text/javascript">
$(document).ready(function() {
	@include('admin.includes.notification')

	@if (Route::currentRouteName() == $routePrefix.'.'.$listUrl)
	// Get list page data
	getList();

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

	@include($routePrefix.'.includes.filter_for_money_transfer_script')

	@endif

});

@if (Route::currentRouteName() == $routePrefix.'.'.$listUrl)
function getList() {
	var fromDate	= $('#from_date').val();
	var toDate		= $('#to_date').val();

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
	        	url: getListDataUrl + '?from_date=' + fromDate + '&to_date=' + toDate,
				type: 'POST',
				data: function(data) {},
	        },
	        columns: [
				{data: 'id', name: 'id'},
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{data: 'user_id', name: 'user_id'},
				{data: 'recipient_id', name: 'recipient_id'},
				{data: 'transfer_no', name: 'transfer_no'},
				{data: 'payment_status', name: 'payment_status'},
				{data: 'forex_country_transfer_status', name: 'forex_country_transfer_status'},
				{data: 'transfer_datetime', name: 'transfer_datetime'},
				// {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
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
}
@endif
</script>
