<?php
	include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    $to_address = $_POST['address'];
    $amount = $_POST['amount'];
    $token = $_POST['token'];
    $from_address = $system_values['main_btc_address'];
    $privatekey = $system_values['main_btc_address_privatekey'];

    require '../../assets/plugin/blockcypher/php-client/blockcypher/php-client/sample/bootstrap.php';
    use BlockCypher\Api\TX;
    use BlockCypher\Auth\SimpleTokenCredential;
    use BlockCypher\Client\TXClient;
    use BlockCypher\Client\AddressClient;
    use BlockCypher\Rest\ApiContext;
    $blockcypher_token = $system_values['blockcypher_token'];

    $apiContext = ApiContext::create(
        'main', 'btc', 'v1',
        new SimpleTokenCredential($blockcypher_token),
        array('mode' => 'live')
    );
    $tx = new TX();
    $input = new \BlockCypher\Api\TXInput();
    $input->addAddress($from_address);
    $tx->addInput($input);
    $output = new \BlockCypher\Api\TXOutput();
    $output->addAddress($to_address);
    $tx->addOutput($output);
    $output->setValue($amount);
    $output->setPreference('low');
    $output->setFees(25000);
    $txClient = new TXClient($apiContext);
    $txSkeleton = $txClient->create($tx);
    $txSkeleton = $txClient->sign($txSkeleton, $privatekey);
    $txSkeleton = $txClient->send($txSkeleton);

    $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $from_address_amount = $row['f_amount'];
        }
    }
    $from_address_amount = $from_address_amount - $amount;
    $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$from_address_amount."' WHERE `f_token`='".$token."'";
    if($conn->query($query) === TRUE) {
        $data = "Success";
    }else{
        $data = "Failed";
    }
    echo $data;
?>