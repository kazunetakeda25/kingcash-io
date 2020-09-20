<?php
	header('Location: ../wallet?res=btc_maintenance');
		exit;
	$balance 		= $_POST['balance'];
	$token 			= $_POST['token'];
	$from_address 	= $_POST['from_address'];
	$to_address 	= $_POST['to_address'];
	$amount 		= $_POST['amount'];
	$calc_amount = $amount * pow(10,8);
	$user_password 		= $_POST['password'];
	require_once('mysql_connect.php');
	$query =  "SELECT `f_password` FROM `tb_users` WHERE `f_token`='".$token."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $f_password = $row['f_password'];
	    }
	}
	if($user_password!=$f_password){
		header('Location: ../wallet?res=btc_password');
		exit;
	}
	if($amount>$balance){
		header('Location: ../wallet?res=btc_balance');
		exit;
	}
	if($amount<=0.0005){
		header('Location: ../wallet?res=btc_low');
		exit;
	}

	$query =  "SELECT MAX(`f_id`) FROM `tb_withdraw`";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $f_max_id = $row["MAX(`f_id`)"];
	    }
	}
	$f_id = $f_max_id + 1;
	$send_amount = $amount - 0.0005;
	$f_regdate = date('Y-m-d H:i:s');
	$query = "INSERT INTO `tb_withdraw` (
    	`f_id`,
    	`f_token`,
    	`f_address`,
    	`f_amount`,
    	`f_regdate`,
    	`f_status`
    	) VALUES (
    	'".$f_id."',
    	'".$token."',
    	'".$to_address."',
    	'".$send_amount."',
    	'".$f_regdate."',
    	'on')";
    if ($conn->query($query) === TRUE) {
	}else {
		header('Location: ../wallet?res=btc_low');
		exit;
	}
  	
	header('Location: ../wallet?res=btc_success');
	exit;
?>