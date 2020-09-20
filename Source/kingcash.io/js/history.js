
var token = $("#token").val();
$.ajax({
    url: 'include/get_btc_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        $("#btc_balance_text").html(data['btc_balance']);
        $("#select_all_btc").html('(All : ' + data['btc_balance'] + ' BTC)');
        $("#btc_balance").val(data['btc_balance']);
        $("#form_btc_balance").val(data['btc_balance']);
        $("#createorder_btc_balance").val(data['btc_balance']);
        $("#btcusd_balance").html('BTC | USD  ' + data['btcusd_balance']);
    }
});
$.ajax({
    url: 'include/get_kcp_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        $("#kcp_balance_text").html(data);
        $("#select_all_kcp").html('(All : ' + data + ' KCP)');
        $("#kcp_balance").val(data);
        $("#form_kcp_balance").val(data);
        $("#createorder_kcp_balance").val(data);
    }
});

var ajax_url_history_kcp =  'include/ajax_get_history?token=' + token +'&type=kcp';
var datatable_history_kcp = $('#datatable_history_kcp').DataTable( {
    "ajax": ajax_url_history_kcp
});

var ajax_url_history_btc =  'include/ajax_get_history?token=' + token +'&type=btc';
var datatable_history_btc = $('#datatable_history_btc').DataTable( {
    "ajax": ajax_url_history_btc
});

var ajax_url_history_usd =  'include/ajax_get_history?token=' + token +'&type=usd';
var datatable_history_usd = $('#datatable_history_usd').DataTable( {
    "ajax": ajax_url_history_usd
});

var ajax_url_history_exchange =  'include/ajax_get_history?token=' + token +'&type=exchange';
var datatable_history_exchange = $('#datatable_history_exchange').DataTable( {
    "ajax": ajax_url_history_exchange
});

datatable_history_kcp
    .order( [ 0, 'desc' ] )
    .draw();

datatable_history_btc
    .order( [ 0, 'desc' ] )
    .draw();

datatable_history_usd
    .order( [ 0, 'desc' ] )
    .draw();

datatable_history_exchange
    .order( [ 0, 'desc' ] )
    .draw();