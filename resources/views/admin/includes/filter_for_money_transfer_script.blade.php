// Filter according to the options selected
$(document).on('click', '.filterList', function() {
	var fromDate	= $('#from_date').val();
	var toDate		= $('#to_date').val();
	
	if (from_date != '' || to_date != '') {
		var getListUrlWithFilter = "{{route($routePrefix.'.'.$listUrl)}}?from_date=" + fromDate + "&to_date=" + toDate;
		window.history.pushState({href: getListUrlWithFilter}, '', getListUrlWithFilter);
		getList();
	} else {
		var getListUrlWithFilter = "{{route($routePrefix.'.'.$listUrl)}}";
		window.history.pushState({href: getListUrlWithFilter}, '', getListUrlWithFilter);
		getList();
	}
});
// Reset Filter
$(document).on('click', '.resetFilter', function() {
	var fromDate	= $('#from_date').val();
	var toDate		= $('#to_date').val();

	var getListUrlWithFilter = "{{route($routePrefix.'.'.$listUrl)}}";
	window.history.pushState({href: getListUrlWithFilter}, '', getListUrlWithFilter);
	$('#showFilterStatus').trigger("reset");
	$("#filterSection").collapse("toggle");
	getList();	
});