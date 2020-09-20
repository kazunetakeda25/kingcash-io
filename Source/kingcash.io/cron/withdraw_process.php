<?php	
	require '../assets/plugin/blockcypher/php-client/blockcypher/php-client/sample/bootstrap.php';
	use BlockCypher\Api\TX;
	use BlockCypher\Auth\SimpleTokenCredential;
	use BlockCypher\Client\TXClient;
	use BlockCypher\Client\AddressClient;
	use BlockCypher\Rest\ApiContext;
	include('../include/mysql_connect.php');
	$query =  "SELECT * FROM `tb_withdraw` WHERE `f_status`='on'";
    $result = $conn->query($query);
    $row_count = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $withdraw_order_data[$row_count] = $row['f_value'];
            $row_count++;
        }
    }

    $query =  "SELECT `f_value` FROM `tb_values` WHERE `f_title`='main_btc_address_privatekey'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $main_btc_address_privatekey = $row['main_btc_address_privatekey'];
        }
    }

    $query =  "SELECT `f_value` FROM `tb_values` WHERE `f_title`='main_btc_address'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $main_btc_address = $row['main_btc_address'];
        }
    }
	
	foreach ($withdraw_order_data as $row) {
		$to_address 					= $row['f_address'];
        $amount 						= $row['f_amount'];	   
		try {
			$tx = new TX();
			$input = new \BlockCypher\Api\TXInput();
			$input->addAddress($main_btc_address);
			$tx->addInput($input);
			$output = new \BlockCypher\Api\TXOutput();
			$output->addAddress($to_address);
			$tx->addOutput($output);
			$tx->setPreference('low');
			$tx->setFees(25000);
			$output->setValue($amount);
			$txClient = new TXClient($apiContext);
			$txSkeleton = $txClient->create($tx);
			$txSkeleton = $txClient->sign($txSkeleton, $main_btc_address_privatekey);
			$txSkeleton = $txClient->send($txSkeleton);
			$query = "UPDATE `tb_withdraw` SET `f_status`='' WHERE `f_token`='".$row['f_token']."'";
			$conn->query($query);
		} catch (Exception $e) {}
	}
	$conn->close();
?>