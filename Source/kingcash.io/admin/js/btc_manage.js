var is_clicked = 0;

var ajax_url_get_btc_balance_list =  'include/ajax_get_btc_balance_list.php';
var datatable_btc_balance_list = $('#datatable_btc_balance_list').DataTable( {
    "ajax": ajax_url_get_btc_balance_list
});
datatable_btc_balance_list
    .order( [ 0, 'asc' ] )
    .draw();
var ajax_url_get_btc_withdraw_list =  'include/ajax_get_btc_withdraw_list.php';
var datatable_btc_withdraw_list = $('#datatable_btc_withdraw_list').DataTable( {
    "ajax": ajax_url_get_btc_withdraw_list
});
datatable_btc_withdraw_list
    .order( [ 0, 'asc' ] )
    .draw();

var total_user_balance, main_address_balance, withdraw_balance;
$.ajax({
    url: 'include/ajax_get_btc_manage_info.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
    	main_address_balance = data['main_address_balance'];
    	if(data['total_user_balance']!=""){
    		$("#total_user_balance").html(data['total_user_balance']);
    	}
    	if(data['main_address_balance']!=""){
    		$("#main_address_balance").html(data['main_address_balance']);
    	}
    	if((data['withdraw_balance']!="")&&(data['withdraw_balance']!=null)){
    		$("#withdraw_balance").html(data['withdraw_balance']);
    	}
    }
});

var send_btc_to_main_from_address, send_btc_to_main_privatekey, send_btc_to_main_amount, send_btc_to_user_address, send_btc_to_user_amount, token;
$('#datatable_btc_balance_list tbody').on('click', 'tr', function () {
    var data = datatable_btc_balance_list.row( this ).data();
    send_btc_to_main_from_address = data[2];
    send_btc_to_main_privatekey = data[4];
    send_btc_to_main_amount = data[3];
    token = data[1];
    $("#send_btc_to_main_modal_text").html("Send "+data[3]+" BTC To Main Address<br>"+send_btc_to_main_from_address+"<br>"+send_btc_to_main_privatekey);
    $("#send_btc_to_main_modal").modal('show');
});
$("#send_btc_to_main").click(function(){
    if(is_clicked!=1){
        if(send_btc_to_main_amount<0.001){
            alert("Should be larget than 0.001 BTC");
            return false;
        };
        $.ajax({
            url: 'include/ajax_send_btc_to_main.php',
            type: 'POST',
            data : {
                address : send_btc_to_main_from_address,
                privatekey : send_btc_to_main_privatekey,
                amount : send_btc_to_main_amount,
                token : token
            },
            dataType: 'json',
            success: function(data) {
                alert(data);
                window.location.reload();
            }
        });
    }
});

$('#datatable_btc_withdraw_list tbody').on('click', 'tr', function () {
    var data = datatable_btc_withdraw_list.row( this ).data();
    send_btc_to_user_address = data[3];
    send_btc_to_user_amount = data[2];
    token = data[1];
    $("#send_btc_to_user_modal_text").html("Send "+data[2]+" BTC To User")
    $("#send_btc_to_user_modal").modal('show');
});
$("#send_btc_to_user").click(function(){
    if(is_clicked!=1){
        if(send_btc_to_user_amount>main_address_balance){
            alert("Not enough BTC for withdraw");
            return false;
        };
        $.ajax({
            url: 'include/ajax_send_btc_to_user.php',
            type: 'POST',
            data:{
                address : send_btc_to_user_address,
                amount : send_btc_to_user_amount,
                token : token
            },
            dataType: 'json',
            success: function(data) {
                alert(data);
                window.location.reload();
            }
        });
    }
});

