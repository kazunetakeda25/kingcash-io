var new_btc_address, new_btc_address_privatekey;
$("#create_new_address").click(function(){
    $.post('https://api.blockcypher.com/v1/btc/main/addrs').then(function(d) {
		new_btc_address = d['address'];
		new_btc_address_privatekey = d['private'];
		$("#new_btc_address").val(new_btc_address);
		$("#new_btc_address_privatekey").val(new_btc_address_privatekey);
	});
	$('#create_new_address_modal').modal('show');
});
$("#change_new_address").click(function(){
	new_btc_address = $("#new_btc_address").val();
	new_btc_address_privatekey = $("#new_btc_address_privatekey").val();
	$.ajax({
	    url: 'include/update_main_btc_address.php',
	    type: 'POST',
	    dataType: 'json',
	    data: {
	        main_btc_address: new_btc_address,
	        main_btc_address_privatekey: new_btc_address_privatekey,
	    },
	    success: function(data) {
	        window.location.reload();
	    }
	});
});

