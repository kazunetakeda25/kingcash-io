<?php	
	$btcusd_currencyrate_data = json_decode(file_get_contents('https://api.bitfinex.com/v1/pubticker/btcusd'));
    $btcusd_currencyrate = $btcusd_currencyrate_data->{'bid'};
    include('../include/mysql_connect.php');
  	$query = "UPDATE `tb_values` SET `f_value`='".number_format($btcusd_currencyrate, 8, '.', '')."' WHERE `f_title`='btcusd'";
    $conn->query($query);
    $conn->close();
?>