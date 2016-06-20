/**
 * 
 */
$(function() {
	$("#identifier_identifier").autocomplete({
		source: function(request, response){
			url = 'http://localhost/php_eclipse_workspace/tor_ibin/web/app_dev.php/admin/search/autocomplete/' + request.term;
			$.getJSON(url, function(data){
				response(data);
			});
		},
		minLength: 2,
	});
});



