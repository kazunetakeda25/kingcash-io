<?php	
	$token = $_POST['token'];
    $kcpvolume = $_POST['createsellorder_kcpvolume'];
    $btcpriceperkcp = $_POST['createsellorder_btcpriceperkcp'];
    $btcvolume = $_POST['createsellorder_btcvolume'];
    $google2facode = $_POST['createsellorder_google2facode'];
    $kcp_balance = $_POST['kcp_balance'];
    $res['res'] = "true";
    if($kcpvolume>$kcp_balance){
        $res['res'] = "false";
        $res['msg'] = "Not enough kcp";
    }
    if($kcpvolume<=0||$btcpriceperkcp<=0||$btcvolume<=0){
        $res['res'] = "false";
        $res['msg'] = "Input correct values";
    }
    require_once('../assets/plugin/google2fa/vendor/autoload.php');
    use PragmaRX\Google2FA\Google2FA;
    $google2fa = new Google2FA();
    if($res['res']=="true"){
        require_once('mysql_connect.php');
        $query =  "SELECT * FROM `tb_users` WHERE `f_token`='".$token."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $userdata = $row;
            }
        }
        if ($userdata['f_2fa_status']=="true"){
            $valid = $google2fa->verifyKey($userdata['f_2fa_secret_key'], $google2facode);
            if($valid) {}else {
                $res['res'] = "false";
                $res['msg'] = "Input correct 2FA code";
            }
        }
    }
    if($res['res']=="true"){
        $f_regdate = date('Y-m-d H:i:s');
        $query =  "SELECT MAX(`f_id`) FROM `tb_orders`";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $f_max_id = $row["MAX(`f_id`)"];
            }
        }
        $f_id = $f_max_id + 1;
        $this_order_id = $f_id;
        $query = "INSERT INTO `tb_orders` (
            `f_id`,
            `f_token`,
            `f_ordertype`,
            `f_kcpvolume`,
            `f_btcpriceperkcp`,
            `f_btcvolume`,
            `f_regdate`
        ) VALUES (
            '".$f_id."',
            '".$token."',
            'sell',
            '".number_format($kcpvolume, 8, '.', '')."',
            '".number_format($btcpriceperkcp, 8, '.', '')."',
            '".number_format($btcvolume, 8, '.', '')."',
            '".$f_regdate."')";
        if ($conn->query($query) === TRUE) {
        }else {
            $res['res'] = "false";
            $res['msg'] = "DB error";
        }
    }
    if($res['res']=="true"){
        $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$token."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $from_address_amount = $row['f_amount'];
            }
        }
        $from_address_amount = $from_address_amount - $kcpvolume;
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
            '".$kcpvolume."',
            'Create sell order for BTC: ".number_format($btcvolume, 8, '.', '')."',
            'kcp',
            '1'
        )";
        if ($conn->query($query) === TRUE) {
        }else {
            $res['res'] = "false";
            $res['msg'] = "DB error";
        }
    }
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    $exchange_sell_fee = $system_values['exchange_sell_fee'];
    $btcpriceperkcp = number_format($btcpriceperkcp, 8, '.', '');
    $query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`='buy' && `f_btcpriceperkcp`>='".$btcpriceperkcp."' ORDER BY `f_regdate` ASC";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this_order_query =  "SELECT * FROM `tb_orders` WHERE `f_id`='".$this_order_id."'";
            $this_order_result = $conn->query($this_order_query);
            if ($this_order_result->num_rows > 0) {
                while($this_order_row = $this_order_result->fetch_assoc()) {
                    $this_order_data = $this_order_row;
                }
            }
            if (($this_order_data['f_kcpvolume']-$row['f_kcpvolume'])>=0.00000001){
                $f_regdate = date('Y-m-d H:i:s');
                $query =  "SELECT MAX(`f_id`) FROM `tb_markethistory`";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $f_max_id = $temp_row["MAX(`f_id`)"];
                    }
                }
                $f_id = $f_max_id + 1;
                $query = "INSERT INTO `tb_markethistory` (
                    `f_id`,
                    `f_ordertype`,
                    `f_kcpvolume`,
                    `f_btcpriceperkcp`,
                    `f_regdate`
                ) VALUES (
                    '".$f_id."',
                    'sell',
                    '".number_format($row['f_kcpvolume'], 8, '.', '')."',
                    '".number_format($this_order_data['f_btcpriceperkcp'], 8, '.', '')."',
                    '".$f_regdate."')";
                if ($conn->query($query) === TRUE) {
                }else {
                    $res['res'] = "false";
                    $res['msg'] = "DB error";
                }
                $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$this_order_data['f_token']."'";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $seller_amount = $temp_row['f_amount'];
                    }
                }
                $add_btcvolume = number_format($this_order_data['f_btcpriceperkcp']*$row['f_kcpvolume']*(1-$exchange_sell_fee/100), 8, '.', '');
                $seller_amount = $seller_amount + $add_btcvolume;    
                $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$this_order_data['f_token']."'";
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
                    '".$this_order_data['f_token']."',
                    '".$history_regdate."',
                    'in',
                    '".$add_btcvolume."',
                    'Sell KCP',
                    'btc',
                    '1'
                )";
                $conn->query($query); 
                $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$row['f_token']."'";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $buyer_amount = $temp_row['f_amount'];
                    }
                }
                $buyer_amount = $buyer_amount + $row['f_kcpvolume'];
                $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$row['f_token']."'";
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
                    '".$row['f_token']."',
                    '".$history_regdate."',
                    'in',
                    '".$row['f_kcpvolume']."',
                    'Buy KCP',
                    'kcp',
                    '1'
                )";
                $conn->query($query);
                $after_sell_kcpvolume = $this_order_data['f_kcpvolume']-$row['f_kcpvolume'];
                $query = "UPDATE `tb_orders` SET `f_kcpvolume`='".$after_sell_kcpvolume."' WHERE `f_id`='".$this_order_id."'";
                $conn->query($query);
                $after_sell_btcvolume = $this_order_data['f_btcvolume']-$row['f_kcpvolume']*$this_order_data['f_btcpriceperkcp']*(1-$exchange_sell_fee/100);
                $query = "UPDATE `tb_orders` SET `f_btcvolume`='".$after_sell_btcvolume."' WHERE `f_id`='".$this_order_id."'";
                $conn->query($query);
                $query =  "DELETE FROM `tb_orders` WHERE `f_id`='".$row['f_id']."'";
                $conn->query($query);
            }else if(abs($this_order_data['f_kcpvolume']-$row['f_kcpvolume'])<0.00000001){
                $f_regdate = date('Y-m-d H:i:s');
                $query =  "SELECT MAX(`f_id`) FROM `tb_markethistory`";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $f_max_id = $temp_row["MAX(`f_id`)"];
                    }
                }
                $f_id = $f_max_id + 1;
                $query = "INSERT INTO `tb_markethistory` (
                    `f_id`,
                    `f_ordertype`,
                    `f_kcpvolume`,
                    `f_btcpriceperkcp`,
                    `f_regdate`
                ) VALUES (
                    '".$f_id."',
                    'sell',
                    '".number_format($row['f_kcpvolume'], 8, '.', '')."',
                    '".number_format($this_order_data['f_btcpriceperkcp'], 8, '.', '')."',
                    '".$f_regdate."')";
                if ($conn->query($query) === TRUE) {
                }else {
                    $res['res'] = "false";
                    $res['msg'] = "DB error";
                }
                $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$this_order_data['f_token']."'";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $seller_amount = $temp_row['f_amount'];
                    }
                }
                $add_btcvolume = number_format($this_order_data['f_btcpriceperkcp']*$row['f_kcpvolume']*(1-$exchange_sell_fee/100), 8, '.', '');
                $seller_amount = $seller_amount + $add_btcvolume;    
                $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$this_order_data['f_token']."'";
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
                    '".$this_order_data['f_token']."',
                    '".$history_regdate."',
                    'in',
                    '".$add_btcvolume."',
                    'Sell KCP',
                    'btc',
                    '1'
                )";
                $conn->query($query); 
                $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$row['f_token']."'";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $buyer_amount = $temp_row['f_amount'];
                    }
                }
                $buyer_amount = $buyer_amount + $row['f_kcpvolume'];
                $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$row['f_token']."'";
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
                    '".$row['f_token']."',
                    '".$history_regdate."',
                    'in',
                    '".$row['f_kcpvolume']."',
                    'Buy KCP',
                    'kcp',
                    '1'
                )";
                $conn->query($query);
                $after_sell_kcpvolume = $this_order_data['f_kcpvolume']-$row['f_kcpvolume'];
                $query =  "DELETE FROM `tb_orders` WHERE `f_id`='".$this_order_data['f_id']."'";
                $conn->query($query);
                $query =  "DELETE FROM `tb_orders` WHERE `f_id`='".$row['f_id']."'";
                $conn->query($query);
            }else{
                $f_regdate = date('Y-m-d H:i:s');
                $query =  "SELECT MAX(`f_id`) FROM `tb_markethistory`";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $f_max_id = $temp_row["MAX(`f_id`)"];
                    }
                }
                $f_id = $f_max_id + 1;
                $query = "INSERT INTO `tb_markethistory` (
                    `f_id`,
                    `f_ordertype`,
                    `f_kcpvolume`,
                    `f_btcpriceperkcp`,
                    `f_regdate`
                ) VALUES (
                    '".$f_id."',
                    'sell',
                    '".number_format($this_order_data['f_kcpvolume'], 8, '.', '')."',
                    '".number_format($this_order_data['f_btcpriceperkcp'], 8, '.', '')."',
                    '".$f_regdate."')";
                if ($conn->query($query) === TRUE) {
                }else {
                    $res['res'] = "false";
                    $res['msg'] = "DB error";
                }
                $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$this_order_data['f_token']."'";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $seller_amount = $temp_row['f_amount'];
                    }
                }
                $seller_amount = $seller_amount + $this_order_data['f_btcvolume'];    
                $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$this_order_data['f_token']."'";
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
                    '".$this_order_data['f_token']."',
                    '".$history_regdate."',
                    'in',
                    '".number_format($this_order_data['f_btcvolume'], 8, '.', '')."',
                    'Sell KCP',
                    'btc',
                    '1'
                )";
                $conn->query($query);
                $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$row['f_token']."'";
                $temp_result = $conn->query($query);
                if ($temp_result->num_rows > 0) {
                    while($temp_row = $temp_result->fetch_assoc()) {
                        $buyer_amount = $temp_row['f_amount'];
                    }
                }
                $buyer_amount = $buyer_amount + $this_order_data['f_kcpvolume'];
                $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$row['f_token']."'";
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
                    '".$row['f_token']."',
                    '".$history_regdate."',
                    'in',
                    '".$this_order_data['f_kcpvolume']."',
                    'Buy KCP',
                    'kcp',
                    '1'
                )";
                $conn->query($query);
                $query =  "DELETE FROM `tb_orders` WHERE `f_id`='".$this_order_data['f_id']."'";
                $conn->query($query);
                $after_sell_kcpvolume = $row['f_kcpvolume'] - $this_order_data['f_kcpvolume'];
                $query = "UPDATE `tb_orders` SET `f_kcpvolume`='".$after_sell_kcpvolume."' WHERE `f_id`='".$row['f_id']."'";
                $conn->query($query);
                $after_sell_btcvolume = $row['f_btcvolume'] - $this_order_data['f_kcpvolume']*$row['f_btcpriceperkcp']*(1+$exchange_sell_fee/100);
                $query = "UPDATE `tb_orders` SET `f_btcvolume`='".$after_sell_btcvolume."' WHERE `f_id`='".$row['f_id']."'";
                $conn->query($query);
            }
        }
    }
    echo json_encode($res);
?>