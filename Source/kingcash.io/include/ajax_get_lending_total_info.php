<?php
    $token = $_POST['token'];
    $current_date = date('Y-m-d H:i:s');
    include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_kcpwallet` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $token_transfered_usd = $row['f_transferedusd'];
        }
    }
    $query =  "SELECT * FROM `tb_lends` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    $token_total_investment = 0;
    $token_active_investment = 0;
    $token_total_earned = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $token_total_investment += $row['f_usdvolume'];
            if($row['f_releasedate']>=$current_date) $token_active_investment += $row['f_usdvolume'];
            $token_total_earned += $row['f_earnedusdvolume'];
        }
    }
    $data['token_total_investment'] = number_format($token_total_investment, 2, '.', '');
    $data['token_active_investment'] = number_format($token_active_investment, 2, '.', '');
    $data['token_total_earned'] = number_format($token_total_earned, 2, '.', '');
    $data['usd_balance'] = number_format($token_total_investment - $token_active_investment + $token_total_earned - $token_transfered_usd, 2, '.', '');
    $current_date = date('Y-m-d H:i:s');
    $date = new DateTime($current_date);
    $current_dateint = $date->getTimestamp();
    for($i=0;$i<=5;$i++){
        $release_duration = 3600*24*($i-1);
        $release_dateint = $current_dateint - $release_duration;
        $date = new DateTime;
        $date->setTimestamp($release_dateint); 
        $date_data[$i] = $date->format('Y-m-d');
        $rate_earned_data[$i] = 0;
        if($i>=1){
            $query =  "SELECT * FROM `tb_earnings` WHERE `f_regdate`='".$date_data[$i]."' limit 0,1";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rate_data[$i] = $row['f_earningrate'];
                }
            }else{
				$rate_data[$i] = 0;
			}
            $query =  "SELECT * FROM `tb_earnings` WHERE `f_token`='".$token."' && `f_regdate`='".$date_data[$i]."'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rate_earned_data[$i] += $row['f_amount'];
                }
            }else{
                $rate_earned_data[$i] = 0;
            }
        }else{
            $query =  "SELECT * FROM `tb_values`";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $system_values[$row['f_title']] = $row['f_value'];
                }
            }
            $rate_data[$i] = $system_values['next_earning_rate'];
            $rate_earned_data[$i] = 0;
        }
        
    }
    $data['earning_board_date_0'] = $date_data[0];
    $data['earning_board_date_1'] = $date_data[1];
    $data['earning_board_date_2'] = $date_data[2];
    $data['earning_board_date_3'] = $date_data[3];
    $data['earning_board_date_4'] = $date_data[4];
    $data['earning_board_date_5'] = $date_data[5];
    $data['earning_board_rate_0'] = number_format($rate_data[0], 2, '.', '');
    $data['earning_board_rate_1'] = number_format($rate_data[1], 2, '.', '');
    $data['earning_board_rate_2'] = number_format($rate_data[2], 2, '.', '');
    $data['earning_board_rate_3'] = number_format($rate_data[3], 2, '.', '');
    $data['earning_board_rate_4'] = number_format($rate_data[4], 2, '.', '');
    $data['earning_board_rate_5'] = number_format($rate_data[5], 2, '.', '');
    $data['earning_board_rate_earned_0'] = number_format($rate_earned_data[0], 2, '.', '');
    $data['earning_board_rate_earned_1'] = number_format($rate_earned_data[1], 2, '.', '');
    $data['earning_board_rate_earned_2'] = number_format($rate_earned_data[2], 2, '.', '');
    $data['earning_board_rate_earned_3'] = number_format($rate_earned_data[3], 2, '.', '');
    $data['earning_board_rate_earned_4'] = number_format($rate_earned_data[4], 2, '.', '');
    $data['earning_board_rate_earned_5'] = number_format($rate_earned_data[5], 2, '.', '');
    echo json_encode($data);
?>