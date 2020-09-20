<?php
	$token = $_POST['token'];
	$invest_kcp_amount = $_POST['invest_kcp_amount'];
    $invest_usd_amount = $_POST['invest_usd_amount'];
    $f_regdate = date('Y-m-d H:i:s');
    if($invest_usd_amount<=1000){
    	$release_duration = 239*24*3600;
    }else if($invest_usd_amount<=5000){
    	$release_duration = 179*24*3600;
    }else if($invest_usd_amount<=10000){
    	$release_duration = 120*24*3600;
    }else if($invest_usd_amount<=100000){
    	$release_duration = 99*24*3600;
    }else{
    	$release_duration = 60*24*3600;
    }
    $date = new DateTime($f_regdate);
    $current_dateint = $date->getTimestamp();
    $release_dateint = $current_dateint + $release_duration;
    $date = new DateTime;
	$date->setTimestamp($release_dateint); 
    $f_releasedate = $date->format('Y-m-d H:i:s');
    $res['res'] = "true";
    include('mysql_connect.php');
    $query =  "SELECT MAX(`f_id`) FROM `tb_lends`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $f_max_id = $row["MAX(`f_id`)"];
        }
    }
    $f_id = $f_max_id + 1;
    $f_lendid = $f_id;
    $query = "INSERT INTO `tb_lends` (
        `f_id`,
        `f_token`,
        `f_kcpvolume`,
        `f_usdvolume`,
        `f_regdate`,
        `f_releasedate`
    ) VALUES (
        '".$f_id."',
        '".$token."',
        '".$invest_kcp_amount."',
        '".$invest_usd_amount."',
        '".$f_regdate."',
        '".$f_releasedate."'
    )";
    if ($conn->query($query) === TRUE) {
    }else {
        $res['res'] = "false";
        $res['msg'] = "DB error";
    }
    if($res['res']=="true"){
    	$query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$token."'";
	    $result = $conn->query($query);
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $from_address_amount = $row['f_amount'];
	        }
	    }
	    $from_address_amount = $from_address_amount - $invest_kcp_amount;
	    $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$from_address_amount."' WHERE `f_token`='".$token."'";
	    if ($conn->query($query) === TRUE) {}else{
	        $res['res'] = "false";
	        $res['msg'] = "DB error";
	    }
    }
    if($res['res']=="true"){
    	$query =  "SELECT MAX(`f_id`) FROM `tb_history`";
	    $result = $conn->query($query);
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $f_max_id = $row["MAX(`f_id`)"];
	        }
	    }
	    $f_id = $f_max_id + 1;
	    $query = "INSERT INTO `tb_history` (
	        `f_id`,
	        `f_token`,
	        `f_regdate`,
	        `f_inout`,
	        `f_amount`,
	        `f_detail`,
	        `f_type`,
	        `f_isexchange`
	    ) VALUES (
	        '".$f_id."',
	        '".$token."',
	        '".$f_regdate."',
	        'out',
	        '".$invest_kcp_amount."',
	        'Paid for lend ID: ".$f_lendid." (Date of capital release ".$f_releasedate.")',
	        'kcp',
	        '0'
	    )";
	    if ($conn->query($query) === TRUE) {
	    }else {
	        $res['res'] = "false";
	        $res['msg'] = "DB error";
	    }
    }
    if($res['res']=="true"){
    	$query =  "SELECT MAX(`f_id`) FROM `tb_history`";
	    $result = $conn->query($query);
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $f_max_id = $row["MAX(`f_id`)"];
	        }
	    }
	    $f_id = $f_max_id + 1;
	    $query = "INSERT INTO `tb_history` (
	        `f_id`,
	        `f_token`,
	        `f_regdate`,
	        `f_inout`,
	        `f_amount`,
	        `f_detail`,
	        `f_type`,
	        `f_isexchange`
	    ) VALUES (
	        '".$f_id."',
	        '".$token."',
	        '".$f_regdate."',
	        'in',
	        '".$invest_usd_amount."',
	        'Lend ID: ".$f_lendid." (Date of capital release ".$f_releasedate.")',
	        'usd',
	        '0'
	    )";
	    $conn->query($query);
    }
    echo json_encode($res);
?>