<?php
	$balance 		= $_POST['balance'];
	$token 			= $_POST['token'];
	$from_address 	= $_POST['from_address'];
	$to_address 	= $_POST['to_address'];
	$amount 		= $_POST['amount'];
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
		header('Location: ../wallet?res=kcp_password');
		exit;
	}
	if($amount>$balance){
		header('Location: ../wallet?res=kcp_balance');
		exit;
	}
	if($amount<=0){
		header('Location: ../wallet?res=kcp_low');
		exit;
	}
	$query =  "SELECT * FROM `tb_kcpwallet` WHERE `f_address`='".$to_address."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {}else{
		header('Location: ../wallet?res=kcp_address');
		exit;
	}
	$query =  "SELECT MAX(`f_id`) FROM `tb_kcpwallet_history`";
    $result = $conn->query($query);
  	if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
        	$f_max_id = $row["MAX(`f_id`)"];
    	}
  	}
  	$f_id = $f_max_id + 1;
  	$f_regdate = date("Y-m-d H:i:s"); 
	$query = "INSERT INTO `tb_kcpwallet_history` (
    	`f_id`,
    	`f_address`,
    	`f_amount`,
    	`f_detail`,
    	`f_regdate`
    	) VALUES (
    	'".$f_id."',
    	'".$from_address."',
    	'".$amount."',
    	'withdraw',
    	'".$f_regdate."')";
    if ($conn->query($query) === TRUE) {}else {
		header('Location: ../wallet?res=kcp_db');
		exit;
	}	
	$query =  "SELECT MAX(`f_id`) FROM `tb_kcpwallet_history`";
    $result = $conn->query($query);
  	if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
        	$f_max_id = $row["MAX(`f_id`)"];
    	}
  	}
  	$f_id = $f_max_id + 1;
  	$f_regdate = date("Y-m-d H:i:s"); 
	$query = "INSERT INTO `tb_kcpwallet_history` (
    	`f_id`,
    	`f_address`,
    	`f_amount`,
    	`f_detail`,
    	`f_regdate`
    	) VALUES (
    	'".$f_id."',
    	'".$to_address."',
    	'".$amount."',
    	'withdraw_received',
    	'".$f_regdate."')";
    if ($conn->query($query) === TRUE) {}else {
		header('Location: ../wallet?res=kcp_db');
		exit;
	}	
	$query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_address`='".$from_address."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $from_address_amount = $row['f_amount'];
	    }
	}
	$from_address_amount = $from_address_amount - $amount;
	$query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$from_address_amount."' WHERE `f_address`='".$from_address."'";
	if ($conn->query($query) === TRUE) {}else{
		header('Location: ../wallet?res=db');
		exit;
	}
	if($res['res']=="true"){
    	$query =  "SELECT MAX(`f_id`) FROM `tb_history`";
	    $result = $conn->query($query);
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $f_max_id = $row["MAX(`f_id`)"];
	        }
	    }
	    $f_id = $f_max_id + 1;
	    $query = "INSERT INTO `tb_history` (
	        `f_id`,
	        `f_token`,
	        `f_regdate`,
	        `f_inout`,
	        `f_amount`,
	        `f_detail`,
	        `f_type`,
	        'f_isexchange'
	    ) VALUES (
	        '".$f_id."',
	        '".$token."',
	        '".$f_regdate."',
	        'out',
	        '".$amount."',
	        'Withdraw KCP to ".$to_address."',
	        'kcp',
	        '0'
	    )";
	    $conn->query($query);
    }
	$query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_address`='".$to_address."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $to_address_amount = $row['f_amount'];
	    }
	}
	$to_address_amount = $to_address_amount + $amount;
	$query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$to_address_amount."' WHERE `f_address`='".$to_address."'";
	if ($conn->query($query) === TRUE) {}else{
		header('Location: ../wallet?res=db');
		exit;
	}
	$query =  "SELECT `f_token` FROM `tb_kcpwallet` WHERE `f_address`='".$to_address."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $to_address_token = $row['f_token'];
	    }
	}
	if($res['res']=="true"){
    	$query =  "SELECT MAX(`f_id`) FROM `tb_history`";
	    $result = $conn->query($query);
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $f_max_id = $row["MAX(`f_id`)"];
	        }
	    }
	    $f_id = $f_max_id + 1;
	    $query = "INSERT INTO `tb_history` (
	        `f_id`,
	        `f_token`,
	        `f_regdate`,
	        `f_inout`,
	        `f_amount`,
	        `f_detail`,
	        `f_type`,
	        'f_isexchange'
	    ) VALUES (
	        '".$f_id."',
	        '".$to_address_token."',
	        '".$f_regdate."',
	        'in',
	        '".$amount."',
	        'Received KCP from ".$from_address."',
	        'kcp',
	        '0'
	    )";
	    $conn->query($query);
    }
	header('Location: ../wallet?res=kcp_success');
	exit;
?>