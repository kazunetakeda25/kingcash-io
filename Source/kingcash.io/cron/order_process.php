<?php	
    include('../include/mysql_connect.php');
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    $query =  "SELECT COUNT(*) FROM `tb_orders` WHERE `f_orderstatus`='on'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $total_orders_count = $row["COUNT(*)"];
        }
    }
    for($total_order_index=0;$total_order_index<$total_orders_count;$total_order_index++){
    	$f_closeddate = date('Y-m-d H:i:s');
	    $f_changeddate = date('Y-m-d H:i:s');
	  	$query =  "SELECT * FROM `tb_orders` WHERE `f_orderstatus`='on' ORDER BY f_regdate ASC limit ".$total_order_index.",1";
	    $result = $conn->query($query);
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $order_data = $row;
	        }
	    }
	    if($order_data['f_ordertype']=="buy"){
	    	$buy_kcpvolume = $order_data['f_kcpvolume'];
	    	$sellers_total_kcpvolume = 0;
			$query =  "SELECT COUNT(*) FROM `tb_orders` WHERE `f_ordertype`='sell' && `f_orderstatus`='on'";
		    $result = $conn->query($query);
		    if ($result->num_rows > 0) {
		        while($row = $result->fetch_assoc()) {
		            $total_sell_order_count = $row["COUNT(*)"];
		        }
		    }
		    $row_count = 0;
		    $sell_order_count = 0;
	    	while (($buy_kcpvolume>$sellers_total_kcpvolume)&&($row_count<$total_sell_order_count)) {
	    		$query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`='sell' && `f_orderstatus`='on' && `f_btcpriceperkcp`<='".$order_data['f_btcpriceperkcp']."' ORDER BY f_regdate ASC limit ".$row_count.", 1";
			    $result = $conn->query($query);
			    if ($result->num_rows > 0) {
			        while($row = $result->fetch_assoc()) {
			            $sell_order_data[$row_count] = $row;
			            $sellers_total_kcpvolume = $sellers_total_kcpvolume + $sell_order_data[$row_count]['f_kcpvolume'];
			            $sell_order_count++;
			        }
			    }
			    $row_count++;
	    	}
		    for($i=0;$i<$sell_order_count;$i++){
		    	$sell_kcpvolume = $sell_order_data[$i]['f_kcpvolume'];
		    	if ($buy_kcpvolume>$sell_kcpvolume){
		    		$after_buy_kcpvolume = $buy_kcpvolume-$sell_kcpvolume;
		    		$query = "UPDATE `tb_orders` SET `f_kcpvolume`='".$after_buy_kcpvolume."', `f_changeddate`='".$f_changeddate."' WHERE `f_id`='".$order_data['f_id']."'";
					$conn->query($query);
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_mainstatus`='1', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$sell_order_data[$i]['f_id']."'";
					$conn->query($query);
					$query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$order_data['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $buyer_amount = $row['f_amount'];
			            }
			        }
			        $buyer_amount = $buyer_amount + $sell_kcpvolume;
			        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$order_data['f_token']."'";
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
			            '".$order_data['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".$sell_kcpvolume."',
			            'Buy KCP',
			            'kcp',
			            '1'
			        )";
			        $conn->query($query);
			        
			        $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$sell_order_data[$i]['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $seller_amount = $row['f_amount'];
			            }
			        }
			        $seller_amount = $seller_amount + $sell_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100);
			        $seller_amount = number_format($seller_amount, 8, '.', '');
			        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$sell_order_data[$i]['f_token']."'";
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
			            '".$sell_order_data[$i]['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".number_format($sell_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100), 8, '.', '')."',
			            'Sell KCP',
			            'btc',
			            '1'
			        )";
			        $conn->query($query);
			        $buy_kcpvolume = $buy_kcpvolume - $sell_kcpvolume;	 
			        continue;       
		    	}else if($buy_kcpvolume == $sell_kcpvolume){
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_mainstatus`='1', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$order_data['f_id']."'";
					$conn->query($query);
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$sell_order_data[$i]['f_id']."'";
					$conn->query($query);
					$query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$order_data['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $buyer_amount = $row['f_amount'];
			            }
			        }
			        $buyer_amount = $buyer_amount + $sell_kcpvolume;
			        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$order_data['f_token']."'";
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
			            '".$order_data['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".$sell_kcpvolume."',
			            'Buy KCP',
			            'kcp',
			            '1'
			        )";
			        $conn->query($query);
			        
			        $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$sell_order_data[$i]['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $seller_amount = $row['f_amount'];
			            }
			        }
			        $seller_amount = $seller_amount + $sell_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100);
			        $seller_amount = number_format($seller_amount, 8, '.', '');
			        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$sell_order_data[$i]['f_token']."'";
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
			            '".$sell_order_data[$i]['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".number_format($sell_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100), 8, '.', '')."',
			            'Sell KCP',
			            'btc',
			            '1'
			        )";
			        $conn->query($query);	 
			        break;       
		    	}else{
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_mainstatus`='1', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$order_data['f_id']."'";
					$conn->query($query);
					$after_sell_kcpvolume = $sell_kcpvolume-$buy_kcpvolume;
					$query = "UPDATE `tb_orders` SET `f_kcpvolume`='".$after_sell_kcpvolume."', `f_changeddate`='".$f_changeddate."' WHERE `f_id`='".$sell_order_data[$i]['f_id']."'";
					$conn->query($query);
					$query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$order_data['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $buyer_amount = $row['f_amount'];
			            }
			        }
			        $buyer_amount = $buyer_amount + $buy_kcpvolume;
			        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$order_data['f_token']."'";
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
			            '".$order_data['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".$buy_kcpvolume."',
			            'Buy KCP',
			            'kcp',
			            '1'
			        )";
			        $conn->query($query);
			        
			        $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$sell_order_data[$i]['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $seller_amount = $row['f_amount'];
			            }
			        }
			        $seller_amount = $seller_amount + $buy_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100);
			        $seller_amount = number_format($seller_amount, 8, '.', '');
			        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$sell_order_data[$i]['f_token']."'";
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
			            '".$sell_order_data[$i]['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".number_format($buy_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100), 8, '.', '')."',
			            'Sell KCP',
			            'btc',
			            '1'
			        )";
			        $conn->query($query);
			        break;
		    	}
		    }
	    }else{
	    	$sell_kcpvolume = $order_data['f_kcpvolume'];
	    	$buyers_total_kcpvolume = 0;
			$query =  "SELECT COUNT(*) FROM `tb_orders` WHERE `f_ordertype`='buy' && `f_orderstatus`='on'";
		    $result = $conn->query($query);
		    if ($result->num_rows > 0) {
		        while($row = $result->fetch_assoc()) {
		            $total_buy_order_count = $row["COUNT(*)"];
		        }
		    }
		    $row_count = 0;
		    $buy_order_count = 0;
	    	while (($sell_kcpvolume>$buyers_total_kcpvolume)&&($row_count<$total_buy_order_count)) {
	    		$query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`='buy' && `f_orderstatus`='on' && `f_btcpriceperkcp`>='".$order_data['f_btcpriceperkcp']."' ORDER BY f_regdate ASC limit ".$row_count.", 1";
			    $result = $conn->query($query);
			    if ($result->num_rows > 0) {
			        while($row = $result->fetch_assoc()) {
			            $buy_order_data[$row_count] = $row;
			            $buyers_total_kcpvolume = $buyers_total_kcpvolume + $buy_order_data[$row_count]['f_kcpvolume'];
			            $buy_order_count++;
			        }
			    }
			    $row_count++;
	    	}
		    for($i=0;$i<$buy_order_count;$i++){
		    	$buy_kcpvolume = $buy_order_data[$i]['f_kcpvolume'];
		    	if ($sell_kcpvolume>$buy_kcpvolume){
		    		$after_sell_kcpvolume = $sell_kcpvolume - $buy_kcpvolume;
		    		$query = "UPDATE `tb_orders` SET `f_kcpvolume`='".$after_sell_kcpvolume."', `f_changeddate`='".$f_changeddate."' WHERE `f_id`='".$order_data['f_id']."'";
					$conn->query($query);
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_mainstatus`='1', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$buy_order_data[$i]['f_id']."'";
					$conn->query($query);
					$query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$order_data['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $seller_amount = $row['f_amount'];
			            }
			        }
			        $seller_amount = $seller_amount + $buy_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_sell_fee']/100);
			        $seller_amount = number_format($seller_amount, 8, '.', '');
			        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$order_data['f_token']."'";
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
			            '".$order_data['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".number_format($buy_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_sell_fee']/100), 8, '.', '')."',
			            'Sell KCP',
			            'btc',
			            '1'
			        )";
			        $conn->query($query);
			        $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$buy_order_data[$i]['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $buyer_amount = $row['f_amount'];
			            }
			        }
			        $buyer_amount = $buyer_amount + $buy_kcpvolume;
			        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$buy_order_data[$i]['f_token']."'";
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
			            '".$buy_order_data[$i]['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".$buy_kcpvolume."',
			            'Buy KCP',
			            'kcp',
			            '1'
			        )";
			        $conn->query($query);
			        
			        $sell_kcpvolume = $after_sell_kcpvolume;	 
			        continue;       
		    	}else if($sell_kcpvolume == $buy_kcpvolume){
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_mainstatus`='1', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$order_data['f_id']."'";
					$conn->query($query);
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$buy_order_data[$i]['f_id']."'";
					$conn->query($query);
					$query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$order_data['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $seller_amount = $row['f_amount'];
			            }
			        }
			        $seller_amount = $seller_amount + $buy_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_sell_fee']/100);
			        $seller_amount = number_format($seller_amount, 8, '.', '');
			        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$order_data['f_token']."'";
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
			            '".$$order_data['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".number_format($buy_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_buy_fee']/100), 8, '.', '')."',
			            'Sell KCP',
			            'btc',
			            '1'
			        )";
			        $conn->query($query);
			        $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$buy_order_data[$i]['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $buyer_amount = $row['f_amount'];
			            }
			        }
			        $buyer_amount = $buyer_amount + $buy_kcpvolume;
			        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$buy_order_data[$i]['f_token']."'";
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
			            '".$buy_order_data[$i]['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".$buy_kcpvolume."',
			            'Buy KCP',
			            'kcp',
			            '1'
			        )";
			        $conn->query($query);
			        
			        break;       
		    	}else{
		    		$query = "UPDATE `tb_orders` SET `f_orderstatus`='off', `f_mainstatus`='1', `f_closeddate`='".$f_closeddate."' WHERE `f_id`='".$order_data['f_id']."'";
					$conn->query($query);
					$after_sell_kcpvolume = $buy_kcpvolume-$sell_kcpvolume;
					$query = "UPDATE `tb_orders` SET `f_kcpvolume`='".$after_sell_kcpvolume."', `f_changeddate`='".$f_changeddate."' WHERE `f_id`='".$buy_order_data[$i]['f_id']."'";
					$conn->query($query);
					$query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$order_data['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $seller_amount = $row['f_amount'];
			            }
			        }
			        $seller_amount = $seller_amount + $sell_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_sell_fee']/100);
			        $seller_amount = number_format($seller_amount, 8, '.', '');
			        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$seller_amount."' WHERE `f_token`='".$order_data['f_token']."'";
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
			            '".$order_data['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".number_format($sell_kcpvolume*$order_data['f_btcpriceperkcp']*(1-$system_values['exchange_sell_fee']/100), 8, '.', '')."',
			            'Sell KCP',
			            'btc',
			            '1'
			        )";
			        $conn->query($query);
			        $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$buy_order_data[$i]['f_token']."'";
			        $result = $conn->query($query);
			        if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
			                $buyer_amount = $row['f_amount'];
			            }
			        }
			        $buyer_amount = $buyer_amount + $sell_kcpvolume;
			        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$buyer_amount."' WHERE `f_token`='".$buy_order_data[$i]['f_token']."'";
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
			            '".$buy_order_data[$i]['f_token']."',
			            '".$history_regdate."',
			            'in',
			            '".$sell_kcpvolume."',
			            'Buy KCP',
			            'kcp',
			            '1'
			        )";
			        $conn->query($query);
			        
			        break;
		    	}
		    }
	    }
    }
    $conn->close();
?>