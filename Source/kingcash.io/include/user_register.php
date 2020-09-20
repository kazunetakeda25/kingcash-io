<?php	
	require_once('mysql_connect.php'); 
	if(isset($_POST['referrer'])){
		$f_referrer = $_POST['referrer'];
		$query =  "SELECT * FROM tb_users WHERE f_username='".$f_referrer."'";
		$result = $conn->query($query);
		if ($result->num_rows > 0) {}else{
			header('Location: ../register?referrer='.$f_referrer.'&res=no_referrer');
			exit;
		}	
	}else{
		$f_referrer = "";
	}
	$f_password = $_POST['password'];
	$f_username = $_POST['username'];	
	$query =  "SELECT * FROM tb_users WHERE f_username='".$f_username."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=username');
			exit;
		}else{
			header('Location: ../register?res=username');
			exit;
		}		
	}	
	if (ctype_alnum($f_username)) {} else {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=username_type');
			exit;
		}else{
			header('Location: ../register?res=username_type');
			exit;
		}
    }
	$f_email = $_POST['email'];
	$query =  "SELECT * FROM tb_users WHERE f_email='".$f_email."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=email');
			exit;
		}else{
			header('Location: ../register?res=email');
			exit;
		}
	}
	if(strlen($f_password)<6){
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=pwd_length');
			exit;
		}else{
			header('Location: ../register?res=pwd_length');
			exit;
		}
	}
	$f_name = $_POST['name'];
	$f_phone = $_POST['intlNumber'];
	$temp = explode("(", $_POST['country']);
	$f_country = $temp[0];
	if($f_country==""){
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=country');
			exit;
		}else{
			header('Location: ../register?res=country');
			exit;
		}
	}
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}		
	$f_token = generateRandomString(64);
	$query =  "SELECT f_token FROM tb_users WHERE f_token='".$f_token."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		$token_repeat = true;
	    while($token_repeat==true) {
	        $f_token = generateRandomString(64);
			$query =  "SELECT f_token FROM `tb_users` WHERE f_token='".$f_token."'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$token_repeat = true;			    
			}else{
				$token_repeat = false;
			}
	    }
	}
	$query =  "SELECT MAX(`f_id`) FROM `tb_users`";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $f_max_id = $row["MAX(`f_id`)"];
	    }
	}
	include('../assets/plugin/google2fa/vendor/autoload.php');
    use PragmaRX\Google2FA\Google2FA;
    $google2fa = new Google2FA();
    $f_2fa_secret_key = $google2fa->generateSecretKey();              
	$f_id = $f_max_id + 1;
	require_once('../assets/plugin/PHPMailer/class.phpmailer.php');
	$mail = new PHPMailer;
	$mail->From = "support@kingcash.io";
	$mail->FromName = "KING CASH Support centre";
	$mail->addAddress($f_email);
	$mail->isHTML(true);
	$mail->Subject = "Email verification";
	$mail->Body = '<i><h2>Hello!<h2><br>Thanks for join to our site. Click <a href="http://kingcash.io/user_activate?token='.$f_token.'">here</a> to activate your account.</i>';
	$mail->AltBody = "This is the plain text version of the email content";
	if(!$mail->send()){
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=email_send');
			exit;
		}else{
			header('Location: ../register?res=email_send');
			exit;
		}
	}	
	$f_verified = "false";
	$f_regdate = date("Y-m-d H:m:s");
    $query = "INSERT INTO tb_users (
    	`f_id`,
    	`f_username`, 
    	`f_email`, 
    	`f_name`, 
    	`f_phone`,
    	`f_country`,
    	`f_password`, 
    	`f_token`, 
    	`f_verified`,
    	`f_2fa_status`,
    	`f_2fa_secret_key`,
    	`f_referrer`,
    	`f_regdate`) VALUES (
    	'".$f_id."',
    	'".$f_username."',
    	'".$f_email."',
    	'".$f_name."',
    	'".$f_phone."',
    	'".$f_country."',
    	'".$f_password."',
    	'".$f_token."',
    	'".$f_verified."',
    	'false',
    	'".$f_2fa_secret_key."',
    	'".$f_referrer."',
    	'".$f_regdate."')";
	if ($conn->query($query) === TRUE) {
	}else {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=db_connect');
			exit;
		}else{
			header('Location: ../register?res=db_connect');
			exit;
		}
	}	
	// $query =  "SELECT * FROM `tb_values` WHERE `f_title`='last_api_request'";
 //    $result = $conn->query($query);
 //    if ($result->num_rows > 0) {
 //        while($row = $result->fetch_assoc()) {
 //            $last_api_request_time = $row['f_value'];
 //        }
 //    }
 //    $current_time = new DateTime();
 //    $current_time_int = $current_time->getTimestamp();
 //    if($current_time_int-$last_api_request_time<10){
 //        sleep(0.1);
 //    }
	try {
		$ch = curl_init();
		$url = "https://api.blockcypher.com/v1/btc/main/addrs";
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "token=3ed74a56c3744f4e9bb67ef623e8b35b");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = json_decode(curl_exec($ch));
	    $btcaddress = $result->{'address'};	
	    $btcaddress_private = $result->{'private'};
	    $btcaddress_public = $result->{'public'};
	    $btcaddress_wif = $result->{'wif'};		
	} catch (Exception $e) {
		$btcaddress = "";	
	    $btcaddress_private = "";
	    $btcaddress_public = "";
	    $btcaddress_wif = "";	
	}
	// $current_time = new DateTime();
 //    $current_time_int = $current_time->getTimestamp();
 //    $query = "UPDATE `tb_values` SET `f_value`='".$current_time_int."' WHERE `f_title`='last_api_request'";
 //    $conn->query($query);	
	// $query =  "SELECT * FROM `tb_values` WHERE `f_title`='last_api_request'";
 //    $result = $conn->query($query);
 //    if ($result->num_rows > 0) {
 //        while($row = $result->fetch_assoc()) {
 //            $last_api_request_time = $row['f_value'];
 //        }
 //    }
 //    $current_time = new DateTime();
 //    $current_time_int = $current_time->getTimestamp();
 //    if($current_time_int-$last_api_request_time<10){
 //        sleep(0.1);
 //    }
	try {
		$ch = curl_init();
		$url = "https://api.blockcypher.com/v1/eth/main/addrs";
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "token=3ed74a56c3744f4e9bb67ef623e8b35b");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);	
	    $result_info = json_decode($result);
	    $kcpaddress = $result_info->{'address'};	
	    $kcpaddress_private = $result_info->{'private'};
	    $kcpaddress_public = $result_info->{'public'}; 
	} catch (Exception $e) {
		$kcpaddress = "";	
	    $kcpaddress_private = "";
	    $kcpaddress_public = ""; 
	}
	// $current_time = new DateTime();
 //    $current_time_int = $current_time->getTimestamp();
 //    $query = "UPDATE `tb_values` SET `f_value`='".$current_time_int."' WHERE `f_title`='last_api_request'";
 //    $conn->query($query);	
  	
	$query =  "SELECT MAX(`f_id`) FROM `tb_address`";
	  $result = $conn->query($query);
	  if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $f_max_id = $row["MAX(`f_id`)"];
	    }
	  }
	  $f_id = $f_max_id + 1;
      $query = "INSERT INTO `tb_address` (
    	`f_id`,
    	`f_token`,
    	`f_btcaddress`,
    	`f_btcaddress_private`,
    	`f_btcaddress_public`,
    	`f_btcaddress_wif`,
    	`f_kcpaddress`,
    	`f_kcpaddress_private`,
    	`f_kcpaddress_public`
    	) VALUES (
    	'".$f_id."',
    	'".$f_token."',
    	'".$btcaddress."',
    	'".$btcaddress_private."',
    	'".$btcaddress_public."',
    	'".$btcaddress_wif."',
    	'".$kcpaddress."',
    	'".$kcpaddress_private."',
    	'".$kcpaddress_public."')";
    if ($conn->query($query) === TRUE) {
	}else {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=db_connect');
			exit;
		}else{
			header('Location: ../register?res=db_connect');
			exit;
		}
	}
	$query =  "SELECT MAX(`f_id`) FROM `tb_btcwallet`";
	  $result = $conn->query($query);
	  if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $f_max_id = $row["MAX(`f_id`)"];
	    }
	  }
	  $f_id = $f_max_id + 1;
	  $f_address = generateRandomString(32);
		$query =  "SELECT `f_address` FROM `tb_btcwallet` WHERE `f_address`='".$f_address."'";
		$result = $conn->query($query);
		if ($result->num_rows > 0) {
			$address_repeat = true;
		    while($address_repeat==true) {
		        $f_address = generateRandomString(32);
				$query =  "SELECT `f_address` FROM `tb_btcwallet` WHERE `f_address`='".$f_address."'";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$address_repeat = true;			    
				}else{
					$address_repeat = false;
				}
		    }
		}
		$f_address = "B".$f_address;
      $query = "INSERT INTO `tb_btcwallet` (
    	`f_id`,
    	`f_token`,
    	`f_address`
    	) VALUES (
    	'".$f_id."',
    	'".$f_token."',
    	'".$f_address."')";
    if ($conn->query($query) === TRUE) {
	}else {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=db_connect');
			exit;
		}else{
			header('Location: ../register?res=db_connect');
			exit;
		}
	}
	$query =  "SELECT MAX(`f_id`) FROM `tb_kcpwallet`";
	  $result = $conn->query($query);
	  if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $f_max_id = $row["MAX(`f_id`)"];
	    }
	  }
	  $f_id = $f_max_id + 1;
	  $f_address = generateRandomString(32);
		$query =  "SELECT `f_address` FROM `tb_kcpwallet` WHERE `f_address`='".$f_address."'";
		$result = $conn->query($query);
		if ($result->num_rows > 0) {
			$address_repeat = true;
		    while($address_repeat==true) {
		        $f_address = generateRandomString(32);
				$query =  "SELECT `f_address` FROM `tb_kcpwallet` WHERE `f_address`='".$f_address."'";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$address_repeat = true;			    
				}else{
					$address_repeat = false;
				}
		    }
		}
		$f_address = "K".$f_address;
      $query = "INSERT INTO `tb_kcpwallet` (
    	`f_id`,
    	`f_token`,
    	`f_address`
    	) VALUES (
    	'".$f_id."',
    	'".$f_token."',
    	'".$f_address."')";
    if ($conn->query($query) === TRUE) {
	}else {
		if(isset($_POST['referrer'])){
			header('Location: ../register?referrer='.$f_referrer.'&res=db_connect');
			exit;
		}else{
			header('Location: ../register?res=db_connect');
			exit;
		}
	}
	$conn->close();
	header('Location: ../register?res=success');
	exit;
?>