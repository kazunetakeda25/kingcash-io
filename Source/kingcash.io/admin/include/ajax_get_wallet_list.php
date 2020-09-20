<?php
    ini_set('max_execution_time', 30000); 
	include('mysql_connect.php');
	$query =  "SELECT * FROM `tb_users`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $return_data['f_id'] = $row['f_id'];
            $return_data['f_email'] = $row['f_email'];
            $return_data['f_token'] = $row['f_token'];
            $query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$row['f_token']."'";
            $sub_result = $conn->query($query);
            if ($sub_result->num_rows > 0) {
                while($sub_row = $sub_result->fetch_assoc()) {
                    $btc_real_balance = $sub_row['f_btcbalance'];
                    $btc_real_balance = $btc_real_balance/pow(10,8);
                }
            }
            $query =  "SELECT f_amount FROM `tb_btcwallet` WHERE `f_token`='".$row['f_token']."'";
            $sub_result = $conn->query($query);
            if ($sub_result->num_rows > 0) {
                while($sub_row = $sub_result->fetch_assoc()) {
                    $btc_local_balance = $sub_row['f_amount'];
                }
            }
            $btc_balance = $btc_real_balance + $btc_local_balance;   
            $return_data['btc_total_balance'] = $btc_balance;
            $return_data['btc_real_balance'] = $btc_real_balance;
            $return_data['btc_local_balance'] = $btc_local_balance;

            $query =  "SELECT `f_kcpbalance` FROM `tb_address` WHERE `f_token`='".$row['f_token']."'";
            $sub_result = $conn->query($query);
            if ($sub_result->num_rows > 0) {
                while($sub_row = $sub_result->fetch_assoc()) {
                    $kcp_real_balance = $sub_row['f_kcpbalance'];
                }
            }
            $query =  "SELECT * FROM `tb_kcpwallet` WHERE `f_token`='".$row['f_token']."'";
            $sub_result = $conn->query($query);
            if ($sub_result->num_rows > 0) {
                while($sub_row = $sub_result->fetch_assoc()) {
                    $kcp_local_amount = $sub_row['f_amount'];
                    $kcp_referrerbonus = $sub_row['f_referrerbonus'];
                }
            }
            $kcp_balance = $kcp_real_balance + $kcp_local_amount + $kcp_referrerbonus;
            $return_data['kcp_total_balance'] = $kcp_balance;
            $return_data['kcp_real_balance'] = $kcp_real_balance;
            $return_data['kcp_local_balance'] = $kcp_local_amount + $kcp_referrerbonus;
            $data[] = array(
            	$return_data['f_id'],
                $return_data['f_email'],
                number_format($return_data['btc_total_balance'], 8, '.', ''),
                number_format($return_data['btc_real_balance'], 8, '.', ''),
                number_format($return_data['btc_local_balance'], 8, '.', ''),
                number_format($return_data['kcp_total_balance'], 8, '.', ''),
                number_format($return_data['kcp_real_balance'], 8, '.', ''),
                number_format($return_data['kcp_local_balance'], 8, '.', '')
            );
        }
    }else{
        $data[] = array("", "", "", "", "", "", "", "0 results");
    }
    $output = array(
        "data" => $data
    );
    echo json_encode($output);
?>