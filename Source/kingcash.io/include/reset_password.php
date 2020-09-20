<?php
	$f_email = $_POST['email'];
	$f_password = $_POST['password'];
	$f_confirm_password = $_POST['confirm_password'];
	$token = $_POST['token'];
	if(strlen($f_password)<6){
		header('Location: ../reset_password?res=pwd_length&token='.$token);
		exit;
	}
	if($f_password!=$f_confirm_password){
		$result = false;
		header('Location: ../reset_password?res=pwd&token='.$token);
		exit;
	}
	require_once('mysql_connect.php'); 
	$query = "UPDATE `tb_users` SET `f_password`='".$f_password."' WHERE `f_token`='".$token."'";
	if ($conn->query($query) === TRUE) {}else{
		header('Location: ../reset_password?res=db&token='.$token);
		exit;
	}
	$conn->close();
    header('Location: ../reset_password?token='.$token.'&res=success');
	exit;
?>