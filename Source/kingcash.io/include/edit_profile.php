<?php
	$f_username = $_POST['username'];
	$f_email = $_POST['email'];
	$f_name = $_POST['name'];
	$f_phone = $_POST['intlNumber'];
	$temp = explode("(", $_POST['country']);
	$f_country = $temp[0];
	$f_token = $_POST['token'];
	require_once('mysql_connect.php'); 
	$query = "UPDATE `tb_users` SET `f_name`='".$f_name."', `f_phone`='".$f_phone."', `f_country`='".$f_country."'   WHERE `f_token`='".$f_token."'";
	if ($conn->query($query) === TRUE) {}else{
		header('Location: ../profile?res=db');
		exit;
	}
	$myethaddress = $_POST['myethaddress'];
	$query = "UPDATE `tb_address` SET `f_profile_kcpaddress`='".$myethaddress."' WHERE `f_token`='".$f_token."'";
	if ($conn->query($query) === TRUE) {}else{
		header('Location: ../profile?res=db');
		exit;
	}
	$conn->close();
	session_start();
	$_SESSION['name'] = $f_name;
	$_SESSION['phone'] = $f_phone;
    header('Location: ../profile?res=success');
	exit;
?>