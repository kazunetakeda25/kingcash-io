<?php 
	$token = $_POST['token'];
	include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $btc_real_balance = $row['f_btcbalance'];
            $btc_real_balance = $btc_real_balance/pow(10,8);
        }
    }
    $query =  "SELECT f_amount FROM `tb_btcwallet` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $btc_local_balance = $row['f_amount'];
        }
    }
    $btc_balance = $btc_real_balance + $btc_local_balance;
    $btc_balance = number_format($btc_balance, 8, '.', '');
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    $btcusd_balance = number_format($btc_balance*$system_values['btcusd'], 2, '.', '');
    $result_data['btc_balance'] = $btc_balance;
    $result_data['btcusd_balance'] = $btcusd_balance;
    echo json_encode($result_data);
?>    