<?php
	include('mysql_connect.php');
	$username = $_POST['username'];
	$password = $_POST['password'];
	$blockcypher_token = $_POST['blockcypher_token'];
	$btc_withdraw_fee = $_POST['btc_withdraw_fee'];
	$exchange_buy_fee = $_POST['exchange_buy_fee'];
	$exchange_sell_fee = $_POST['exchange_sell_fee'];
	$earning_rate = $_POST['earning_rate'];
	$next_earning_rate = $_POST['next_earning_rate'];
	$query = "UPDATE `tb_values` SET `f_value`='".$username."' WHERE `f_title`='username'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$password."' WHERE `f_title`='password'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$blockcypher_token."' WHERE `f_title`='blockcypher_token'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$btc_withdraw_fee."' WHERE `f_title`='btc_withdraw_fee'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$exchange_buy_fee."' WHERE `f_title`='exchange_buy_fee'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$exchange_sell_fee."' WHERE `f_title`='exchange_sell_fee'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$earning_rate."' WHERE `f_title`='earning_rate'";
	$conn->query($query);
	$query = "UPDATE `tb_values` SET `f_value`='".$next_earning_rate."' WHERE `f_title`='next_earning_rate'";
	$conn->query($query);
	header('Location: ../settings?res=success');
    exit;
?>