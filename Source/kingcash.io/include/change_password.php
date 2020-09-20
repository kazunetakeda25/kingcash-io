<?php
	$current_password = $_POST['current_password'];	
	$f_password = $_POST['password'];
	$f_confirm_password = $_POST['confirm_password'];
	$f_token = $_POST['token'];
	require_once('mysql_connect.php'); 
	$query =  'SELECT * FROM tb_users WHERE f_token="'.$f_token.'"';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
	        $f_current_password = $row['f_password'];
	    }			    
	}else{
		header('Location: ../profile?res=db');
		exit;
	}
	if($current_password!=$f_current_password){
		header('Location: ../profile?res=curpwd');
		exit;
	}
	if(strlen($f_password)<6){
		header('Location: ../profile?res=pwd_length');
		exit;
	}
	if($f_password!=$f_confirm_password){
		header('Location: ../profile?res=pwd');
		exit;
	}
	$query = "UPDATE `tb_users` SET `f_password`='".$f_password."'  WHERE `f_token`='".$f_token."'";
	if ($conn->query($query) === TRUE) {}else{
		header('Location: ../profile?res=db');
		exit;
	}
	$conn->close();
    header('Location: ../profile?res=pwd_success');
	exit;
?>