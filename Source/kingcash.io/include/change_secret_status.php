<?php
	$token = $_POST['token'];	
	$secret_key = $_POST['secret_key'];
	$secret_status_setting = $_POST['secret_status_setting'];
	$secret_code = $_POST['secret_code'];
	require_once('../assets/plugin/google2fa/vendor/autoload.php');
    use PragmaRX\Google2FA\Google2FA;
    $google2fa = new Google2FA();
    $valid = $google2fa->verifyKey($secret_key, $secret_code);
	require_once('mysql_connect.php');
	session_start();
	if($secret_status_setting=="1"){
		$query = "UPDATE `tb_users` SET `f_2fa_status`='false' WHERE `f_token`='".$token."'";
		if ($conn->query($query) === TRUE) {}else{
			header('Location: ../security?res=db');
			exit;
		}
		$_SESSION['2fa_status'] = "false";
		header('Location: ../security?res=off_success');
		exit;	
	}else{
		if($valid) {	     	
			$query = "UPDATE `tb_users` SET `f_2fa_status`='true' WHERE `f_token`='".$token."'";
			if ($conn->query($query) === TRUE) {}else{
				header('Location: ../security?res=db');
				exit;
			}
			$_SESSION['2fa_status'] = "true";
		    header('Location: ../security?res=success');
			exit;
		}else {
		    header('Location: ../security?res=secret_wrong');
			exit;
		}
	}
	$conn->close();	
?>