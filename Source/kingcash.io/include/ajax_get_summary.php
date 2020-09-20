<?php

    include('mysql_connect.php');
    $query =  "SELECT `f_value` FROM `tb_values` WHERE `f_title`='btcusd'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $btcusd = $row['f_value'];
        }
    }
    $query =  "SELECT `f_btcpriceperkcp` FROM `tb_markethistory` ORDER BY `f_regdate` DESC limit 0,1";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['last'] = number_format($row['f_btcpriceperkcp'], 8, '.', '');
            $data['last_usd'] = number_format($data['last']*$btcusd, 2, '.', '');
        }
    }else{
    	$data['last'] = "0.00000000";
        $data['last_usd'] = "0.00";
    }

    $query =  "SELECT MIN(`f_btcpriceperkcp`) FROM `tb_markethistory` ORDER BY `f_regdate` DESC limit 0,10";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['lending_kcpusd_rate'] = number_format($row["MIN(`f_btcpriceperkcp`)"]*$btcusd, 2, '.', '');
        }
    }else{
        $data['lending_kcpusd_rate'] = "0.00";
    }
    if($data['lending_kcpusd_rate']>25){
        $data['lending_kcpusd_rate'] = "25.00";
    }

    $date = new DateTime();
	$date->sub(new DateInterval('PT24H'));
	$past_24h = $date->format('Y-m-d H:i:s');
    $query =  "SELECT SUM(`f_kcpvolume`) FROM `tb_markethistory` WHERE `f_regdate`>'".$past_24h."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['volume'] = number_format($row["SUM(`f_kcpvolume`)"], 8, '.', '');
            $data['volume_usd'] = number_format($data['volume']*$data['last_usd'], 2, '.', '');
        }
    }else{
    	$data['volume'] = "0.00000000";
        $data['volume_usd'] = "0.00000000";
    }
    $query =  "SELECT MAX(`f_btcpriceperkcp`) FROM `tb_markethistory` WHERE  `f_regdate`>'".$past_24h."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['price_high'] = number_format($row["MAX(`f_btcpriceperkcp`)"], 8, '.', '');
            $data['price_high_usd'] = number_format($data['price_high']*$btcusd, 2, '.', '');
        }
    }else{
    	$data['price_high'] = "0.00000000";
        $data['price_high_usd'] = "0.00000000";
    }
    $query =  "SELECT MIN(`f_btcpriceperkcp`) FROM `tb_markethistory` WHERE  `f_regdate`>'".$past_24h."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data['price_low'] = number_format($row["MIN(`f_btcpriceperkcp`)"], 8, '.', '');
            $data['price_low_usd'] = number_format($data['price_low']*$btcusd, 2, '.', '');
        }
    }else{
    	$data['price_low'] = "0.00000000";
        $data['price_low_usd'] = "0.00000000";
    }
    echo json_encode($data);
?>