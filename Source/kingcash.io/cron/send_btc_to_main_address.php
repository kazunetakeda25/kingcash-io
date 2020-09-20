<?php	
	require '../assets/plugin/blockcypher/php-client/blockcypher/php-client/sample/bootstrap.php';
	use BlockCypher\Api\TX;
	use BlockCypher\Auth\SimpleTokenCredential;
	use BlockCypher\Client\TXClient;
	use BlockCypher\Client\AddressClient;
	use BlockCypher\Rest\ApiContext;
	include('../include/mysql_connect.php');
	$query =  "SELECT f_value FROM `tb_values` WHERE `f_title`='blockcypher_token'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $blockcypher_token = $row['f_value'];
        }
    }
	$token = $blockcypher_token;

	$apiContext = ApiContext::create(
	    'main', 'btc', 'v1',
	    new SimpleTokenCredential($token),
	    array('mode' => 'live')
	);
	
	$query =  "SELECT f_value FROM `tb_values` WHERE `f_title`='main_btc_address'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $main_btc_address = $row['f_value'];
        }
    }
    $query =  "SELECT f_value FROM `tb_values` WHERE `f_title`='main_btc_address_privatekey'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $main_btc_address_privatekey = $row['f_value'];
        }
    }
	$query =  'SELECT * FROM tb_address';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
	        $btc_real_address 				= $row['f_btcaddress'];
	        $btc_real_address_privatekey 	= $row['f_btcaddress_private'];
	        $f_btctomaintransfered 			= $row['f_btctomaintransfered'];
		    $btc_balance 					= $row['f_btcbalance'];
		    $f_token 						= $row['f_token'];
		    $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$f_token."'";
		    $sub_result = $conn->query($query);
		    if ($sub_result->num_rows > 0) {
		        while($sub_row = $result->fetch_assoc()) {
		            $btcwallet_balance = $sub_row['f_amount'];
		        }
		    }
		    if($btc_balance>100000){
		    	sleep(1);
		    	$send_amount = $btc_balance - 25000;
				try {
					$tx = new TX();
					$input = new \BlockCypher\Api\TXInput();
					$input->addAddress($btc_real_address);
					$tx->addInput($input);
					$output = new \BlockCypher\Api\TXOutput();
					$output->addAddress($main_btc_address);
					$tx->addOutput($output);
					$tx->setPreference('low');
					$tx->setFees(25000);
					$output->setValue($send_amount);
					$txClient = new TXClient($apiContext);
					$txSkeleton = $txClient->create($tx);
					$txSkeleton = $txClient->sign($txSkeleton, $btc_real_address_privatekey);
					$txSkeleton = $txClient->send($txSkeleton);
					$query = "UPDATE `tb_address` SET `f_btcbalance`='' WHERE `f_token`='".$userdata['f_token']."'";
					$conn->query($query);
					$query = "UPDATE `tb_address` SET `f_btctomaintransfered`='".$btc_balance."' WHERE `f_token`='".$f_token."'";
					$conn->query($query);
					$btcwallet_balance_after_transfered = $btcwallet_balance + $btc_balance;
					$query = "UPDATE `tb_btcwallet` SET `f_amount`='".$btcwallet_balance_after_transfered."' WHERE `f_token`='".$f_token."'";
					$conn->query($query);
				} catch (Exception $e) {}
		    }
	    }			    
	}
	$conn->close();
?>