<?php
	$token = $_POST['token'];
	$reinvest_kcp_amount = $_POST['reinvest_kcp_amount'];
    $reinvest_usd_amount = $_POST['reinvest_usd_amount'];
    $res['res'] = "true";
    include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_kcpwallet` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $token_kcpwallet_data = $row;
        }
    }
    $from_address_usd_amount = $token_kcpwallet_data['f_transferedusd'] + $reinvest_usd_amount;
    $query = "UPDATE `tb_kcpwallet` SET `f_transferedusd`='".$from_address_usd_amount."' WHERE `f_token`='".$token."'";
    if ($conn->query($query) === TRUE) {}else{
        $res['res'] = "false";
        $res['msg'] = "DB error";
    }
    if($res['res']=="true"){
	    $from_address_kcp_amount = $token_kcpwallet_data['f_amount'] + $reinvest_kcp_amount;
	    $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$from_address_kcp_amount."' WHERE `f_token`='".$token."'";
	    if ($conn->query($query) === TRUE) {}else{
	        $res['res'] = "false";
	        $res['msg'] = "DB error";
	    }
    }
    if($res['res']=="true"){
        $f_regdate = date('Y-m-d H:i:s');
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
            '".$reinvest_usd_amount."',
            'Converted to KCP : ".$reinvest_kcp_amount."',
            'usd',
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
            '".$reinvest_kcp_amount."',
            'Converted from USD : ".$reinvest_usd_amount."',
            'kcp',
            '0'
        )";
        if ($conn->query($query) === TRUE) {
        }else {
            $res['res'] = "false";
            $res['msg'] = "DB error";
        }
    }
    echo json_encode($res);
?>