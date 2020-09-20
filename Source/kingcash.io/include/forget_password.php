<?php
	$email = $_POST['email'];
	require_once('mysql_connect.php'); 
	$query =  'SELECT f_token FROM tb_users WHERE f_email="'.$email.'"';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
	        $token = $row['f_token'];
	    }			    
	}else{
		header('Location: ../forget_password?res=email');
		exit;
	}
	$conn->close();
	require_once('../assets/plugin/PHPMailer/class.phpmailer.php');
	$mail = new PHPMailer;
	$mail->From = "support@kingcash.io";
	$mail->FromName = "KING CASH Support centre";
	$mail->addAddress($email);
	$mail->isHTML(true);
	$mail->Subject = "Reset Password";
	$mail->Body = '<i><h2>Hello!<h2><br>Click <a href="http://kingcash.io/reset_password?token='.$token.'">here</a> to reset your account password</i>';
	$mail->AltBody = "This is the plain text version of the email content";
	if(!$mail->send()){
	    $result = false;
	    header('Location: ../forget_password?res=email_send');
		exit;
	}
    header('Location: ../forget_password?res=success');
	exit;
?>