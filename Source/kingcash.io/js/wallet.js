var is_clicked = 0;

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
        console.log(data);
        $("#kcp_balance_text").html(data);
        $("#select_all_kcp").html('(All : ' + data + ' KCP)');
        $("#kcp_balance").val(data);
        $("#form_kcp_balance").val(data);
        $("#createorder_kcp_balance").val(data);
    }
});

$("#copy_btc_real_address").click(function() {
    $("#btc_real_address_string").select();
    document.execCommand('copy');
    $("#copy_btc_real_address").val("Copied");
    var count = 0;
    setTimeout(function(){
        $("#copy_btc_real_address").val("Copy");
    }, 2000);
});

$("#select_all_btc").click(function(){
    var all_btc = $("#form_btc_balance").val();
    $("#btc_amount").val(all_btc);
});

$("#copy_kcp_real_address").click(function() {
    $("#kcp_real_address_string").select();
    document.execCommand('copy');
    $("#copy_kcp_real_address").val("Copied");
    var count = 0;
    setTimeout(function(){
        $("#copy_kcp_real_address").val("Copy");
    }, 2000);
});

$("#copy_kcp_local_address").click(function() {
    $("#kcp_local_address_string").select();
    document.execCommand('copy');
    $("#copy_kcp_local_address").val("Copied");
    var count = 0;
    setTimeout(function(){
        $("#copy_kcp_local_address").val("Copy");
    }, 2000);
});

$("#select_all_kcp").click(function(){
    var all_kcp = $("#form_kcp_balance").val();
    $("#kcp_amount").val(all_kcp);
});

var btc_real_address = $("#btc_real_address").val();
var ajax_url_withdraw_btc =  'include/ajax_get_withdraw_btc.php?token='+token+'&address='+btc_real_address;
console.log(ajax_url_withdraw_btc);
var datatable_withdraw_btc = $('#datatable_withdraw_btc').DataTable( {
    "ajax": ajax_url_withdraw_btc
});

