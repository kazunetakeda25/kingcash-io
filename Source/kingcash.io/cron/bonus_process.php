<?php 
    ini_set('max_execution_time', 30000); 
    include('../include/mysql_connect.php');
    $query =  "SELECT * FROM `tb_address`";
    $row_count=0;
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $address_data[$row_count]['f_token'] = $row['f_token'];
            $address_data[$row_count]['f_kcpaddress'] = $row['f_kcpaddress'];
            $address_data[$row_count]['f_profile_kcpaddress'] = $row['f_profile_kcpaddress'];
            $address_data[$row_count]['f_to_referrerbonuskcp'] = $row['f_to_referrerbonuskcp'];
            $row_count++;
        }
    }
    foreach ($address_data as $row) {
        $query =  "SELECT `f_username` FROM `tb_users` WHERE `f_token`='".$row['f_token']."'";
        $sub_result = $conn->query($query);
        if ($sub_result->num_rows > 0) {
            while($sub_row = $sub_result->fetch_assoc()) {
                $referral_username = $sub_row['f_username'];
            }
        }
        $query =  "SELECT `f_referrer` FROM `tb_users` WHERE `f_token`='".$row['f_token']."'";
        $sub_result = $conn->query($query);
        if ($sub_result->num_rows > 0) {
            while($sub_row = $sub_result->fetch_assoc()) {
                $f_referrer_username = $sub_row['f_referrer'];
            }
        }
        $query =  "SELECT `f_token` FROM `tb_users` WHERE `f_username`='".$f_referrer_username."'";
        $sub_result = $conn->query($query);
        if ($sub_result->num_rows > 0) {
            while($sub_row = $sub_result->fetch_assoc()) {
                $referrer_token = $sub_row['f_token'];
            }
        }else continue;
        $query =  "SELECT `f_referrerbonus` FROM `tb_kcpwallet` WHERE `f_token`='".$referrer_token."'";
        $sub_result = $conn->query($query);
        if ($sub_result->num_rows > 0) {
            while($sub_row = $sub_result->fetch_assoc()) {
                $referrerbonus_amount = $sub_row['f_referrerbonus'];
            }
        }
        //echo $referral_username.":".$f_referrer_username.":".$referrer_token.":".$referrerbonus_amount." , ";
        $kcpaddress = $row['f_kcpaddress'];
        $profile_kcpaddress = $row['f_profile_kcpaddress'];
        $api_result = json_decode(file_get_contents('https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0xa7a05cf8d6d8e4e73db47fe4de4cbd5b63d15cfa&address='.$kcpaddress.'&tag=latest&apikey=4YYAPWYIDCYFVZ74YWGNGTVV9ZCICQ5AYC'));
        $kcp_api_balance = $api_result->{'result'};
        $kcp_real_balance = $kcp_api_balance/pow(10,18);

        $api_result = json_decode(file_get_contents('https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0xa7a05cf8d6d8e4e73db47fe4de4cbd5b63d15cfa&address='.$profile_kcpaddress.'&tag=latest&apikey=4YYAPWYIDCYFVZ74YWGNGTVV9ZCICQ5AYC'));
        $kcp_api_balance = $api_result->{'result'};
        $kcp_profile_real_balance = $kcp_api_balance/pow(10,18);

        $kcp_real_total_balance = $kcp_real_balance + $kcp_profile_real_balance;
        $to_referrer_kcp = $kcp_real_total_balance*0.1;
        $to_referrer_bonus_kcp = $row['f_to_referrerbonuskcp'];
        if($to_referrer_kcp>$to_referrer_bonus_kcp){
            $to_referrer_bonus = $to_referrer_kcp - $to_referrer_bonus_kcp;
            $to_referrerbonus = $to_referrer_bonus;
            $referrerbonus_amount = $referrerbonus_amount + $to_referrerbonus;
            $query = "UPDATE `tb_kcpwallet` SET `f_referrerbonus`='".$referrerbonus_amount."' WHERE `f_token`='".$referrer_token."'";
            $conn->query($query);
            $history_query =  "SELECT MAX(`f_id`) FROM `tb_history`";
            $history_regdate = date('Y-m-d H:i:s');
            $history_result = $conn->query($history_query);
            if ($history_result->num_rows > 0) {
                while($history_row = $history_result->fetch_assoc()) {
                    $f_max_id = $history_row["MAX(`f_id`)"];
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
                '".$referrer_token."',
                '".$history_regdate."',
                'in',
                '".$to_referrerbonus."',
                'Referral Bonus',
                'kcp',
                '0'
            )";
            $conn->query($query);
            $query = "UPDATE `tb_address` SET `f_to_referrerbonuskcp`='".$to_referrer_kcp."' WHERE `f_token`='".$row['f_token']."'";
            $conn->query($query);
        }
    }    
?>