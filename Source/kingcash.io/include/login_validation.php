<?php
	$f_email = $_POST['email'];
	// if($f_email!="arun_0073@rediffmail.com"){
	//     header('Location: ../login?res=repairing');
	// 	exit;
	// }
	$f_password = $_POST['password'];
	$secret = $_POST['secret'];
	require_once('mysql_connect.php'); 
	$query =  'SELECT * FROM tb_users WHERE f_email="'.$f_email.'"';
	$result = $conn->query($query);
	require_once('../assets/plugin/google2fa/vendor/autoload.php');
    use PragmaRX\Google2FA\Google2FA;
    $google2fa = new Google2FA();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
	        $userdata = $row;
	    }			    
	}else{
		header('Location: ../login?res=email');
		exit;
	}
	if($userdata['f_verified']=="false"){
		header('Location: ../login?res=verified');
		exit;
	}	
	if($userdata['f_password']!=$f_password){
		header('Location: ../login?res=password');
		exit;
	}
	$query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$userdata['f_token']."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $btc_address = $row['f_btcaddress'];
            $balance_info = json_decode(file_get_contents('https://blockchain.info/balance?active='.$btc_address));
            foreach($balance_info as $key){
				$btc_real_balance = $key->{'final_balance'};
			}
        }
    }
    $query = "UPDATE `tb_address` SET `f_btcbalance`='".$btc_real_balance."' WHERE `f_token`='".$userdata['f_token']."'";
	$conn->query($query);
	$query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$userdata['f_token']."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $kcp_address = $row['f_kcpaddress'];
            $api_result = json_decode(file_get_contents('https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0xa7a05cf8d6d8e4e73db47fe4de4cbd5b63d15cfa&address='.$kcp_address.'&tag=latest&apikey=4YYAPWYIDCYFVZ74YWGNGTVV9ZCICQ5AYC'));
		    $kcp_api_balance = $api_result->{'result'};
        }
    }
    $kcp_real_balance = $kcp_api_balance/pow(10,18);
    $query = "UPDATE `tb_address` SET `f_kcpbalance`='".$kcp_real_balance."' WHERE `f_token`='".$userdata['f_token']."'";
	$conn->query($query);
	session_start();
	if($userdata['f_2fa_status']=="true"){
		if($secret==""){
			header('Location: ../login?res=secret_empty');
			exit;
		}else{			
			$valid = $google2fa->verifyKey($userdata['f_2fa_secret_key'], $secret);
			if($valid) {
				ini_set('session.gc_maxlifetime', 10800);
				session_set_cookie_params(10800);
			    $_SESSION['id'] = $userdata['f_id'];
				$_SESSION['email'] = $userdata['f_email'];
				$_SESSION['token'] = $userdata['f_token'];
				$_SESSION['username'] = $userdata['f_username'];
				$_SESSION['name'] = $userdata['f_name'];
				$_SESSION['phone'] = $userdata['f_phone'];
				$_SESSION['2fa_status'] = $userdata['f_2fa_status'];
				$_SESSION['2fa_secret_key'] = $userdata['f_2fa_secret_key'];
				$_SESSION['logged_in'] = "true";
				header('Location: ../dashboard');
				exit;
			}else {
			    header('Location: ../login?res=secret_wrong');
				exit;
			}
		}		
	}else{
		ini_set('session.gc_maxlifetime', 10800);
		session_set_cookie_params(10800);
		$_SESSION['id'] = $userdata['f_id'];
		$_SESSION['email'] = $userdata['f_email'];
		$_SESSION['token'] = $userdata['f_token'];
		$_SESSION['username'] = $userdata['f_username'];
		$_SESSION['name'] = $userdata['f_name'];
		$_SESSION['phone'] = $userdata['f_phone'];
		$_SESSION['2fa_status'] = $userdata['f_2fa_status'];
		$_SESSION['2fa_secret_key'] = $userdata['f_2fa_secret_key'];
		$_SESSION['logged_in'] = "true";
		header('Location: ../dashboard');
		exit;
	}	
?>