<?php
	include('mysql_connect.php');
	$query =  "SELECT SUM(`f_btcbalance`) FROM `tb_address`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['total_user_balance'] = $row['SUM(`f_btcbalance`)']/pow(10,8);
        }
    }else{
        $data['total_user_balance'] = 0;
    }
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    $btc_address = $system_values['main_btc_address'];
    $balance_info = json_decode(file_get_contents('https://blockchain.info/balance?active='.$btc_address));
    foreach($balance_info as $key){
        $btc_real_balance = $key->{'final_balance'};
    }
    $data['main_address_balance'] = $btc_real_balance/pow(10,8);
    $query =  "SELECT SUM(`f_amount`) FROM `tb_withdraw`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['withdraw_balance'] = $row['SUM(`f_amount`)'];
        }
    }else{
        $data['withdraw_balance'] = 0;
    }
    
    echo json_encode($data);
?>