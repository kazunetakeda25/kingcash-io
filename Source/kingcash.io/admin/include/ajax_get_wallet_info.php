<?php
	include('mysql_connect.php');
	$query =  "SELECT SUM(`f_btcbalance`), SUM(`f_kcpbalance`) FROM `tb_address`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['total_real_btc'] = $row['SUM(`f_btcbalance`)']/pow(10,8);
            $data['total_real_kcp'] = $row['SUM(`f_kcpbalance`)'];
        }
    }else{
        $data['total_real_btc'] = 0;
        $data['total_real_kcp'] = 0;
    }
    $query =  "SELECT SUM(`f_amount`) FROM `tb_btcwallet`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['total_local_btc'] = $row['SUM(`f_amount`)'];
        }
    }else{
        $data['total_local_btc'] = 0;
    }
    $query =  "SELECT SUM(`f_amount`) FROM `tb_kcpwallet`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['total_local_kcp'] = $row['SUM(`f_amount`)'];
        }
    }else{
        $data['total_local_kcp'] = 0;
    }
    $data['total_btc'] = $data['total_real_btc'] + $data['total_local_btc'];
    $data['total_kcp'] = $data['total_real_kcp'] + $data['total_local_kcp'];

    $query =  "SELECT SUM(`f_btcvolume`) FROM `tb_orders` WHERE `f_ordertype`='buy'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['total_btc_in_exchange'] = $row['SUM(`f_btcvolume`)'];
        }
    }else{
        $data['total_btc_in_exchange'] = 0;
    }

    $query =  "SELECT SUM(`f_kcpvolume`) FROM `tb_orders` WHERE `f_ordertype`='sell'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['total_kcp_in_exchange'] = $row['SUM(`f_kcpvolume`)'];
        }
    }else{
        $data['total_kcp_in_exchange'] = 0;
    }
    foreach ($data as $key => $value) {
        if((!isset($value))||($value==null)){
            $return_data[$key] = "0.00000000";   
        }else{
            $return_data[$key] = number_format($value, 8, '.', '');   
        }
    }
    echo json_encode($return_data);
?>