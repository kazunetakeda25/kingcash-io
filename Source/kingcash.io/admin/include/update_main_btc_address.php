<?php
	include('mysql_connect.php');
	$main_btc_address = $_POST['main_btc_address'];
	$main_btc_address_privatekey = $_POST['main_btc_address_privatekey'];
	$query = "UPDATE `tb_values` SET `f_value`='".$main_btc_address."' WHERE `f_title`='main_btc_address'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$main_btc_address_privatekey."' WHERE `f_title`='main_btc_address_privatekey'";
	$conn->query($query);
?>