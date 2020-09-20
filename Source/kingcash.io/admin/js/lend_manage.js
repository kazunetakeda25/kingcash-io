var ajax_url_get_lend_list =  'include/ajax_get_lend_list.php';
var datatable_lend_list = $('#datatable_lend_list').DataTable( {
    "ajax": ajax_url_get_lend_list
});
datatable_lend_list
    .order( [ 0, 'asc' ] )
    .draw();

var total_kcp_in_lending, total_usd_in_lending, total_usd_earned_from_lend;
$.ajax({
    url: 'include/ajax_get_lend_info.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
    	total_kcp_in_lending = data['total_kcp'];
    	total_usd_in_lending = data['total_usd'];
    	total_usd_earned_from_lend = data['total_usd_earned'];
    	$("#total_kcp_in_lending").html(total_kcp_in_lending);
    	$("#total_usd_in_lending").html(total_usd_in_lending);
    	$("#total_usd_earned_from_lend").html(total_usd_earned_from_lend);
    }
});