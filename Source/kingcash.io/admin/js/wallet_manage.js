var ajax_url_get_wallet_list =  'include/ajax_get_wallet_list.php';
var datatable_wallet_list = $('#datatable_wallet_list').DataTable( {
    "ajax": ajax_url_get_wallet_list
});
datatable_wallet_list
    .order( [ 0, 'asc' ] )
    .draw();

var total_btc_in_wallet, total_btc_in_exchange, total_kcp_in_wallet, total_kcp_in_exchange;
$.ajax({
    url: 'include/ajax_get_wallet_info.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
    	total_btc_in_wallet = data['total_btc'];
    	total_kcp_in_wallet = data['total_kcp'];
    	total_btc_in_exchange = data['total_btc_in_exchange'];
    	total_kcp_in_exchange = data['total_kcp_in_exchange'];
    	$("#total_btc_in_wallet").html(total_btc_in_wallet);
    	$("#total_btc_in_exchange").html(total_btc_in_exchange);
    	$("#total_kcp_in_wallet").html(total_kcp_in_wallet);
    	$("#total_kcp_in_exchange").html(total_kcp_in_exchange);
    }
});