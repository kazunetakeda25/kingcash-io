<?php
	include('../include/mysql_connect.php');
	$query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    $earning_rate = $system_values['earning_rate'];
	$query =  "SELECT * FROM `tb_lends`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $invest_usdvolume = $row['f_usdvolume'];
            $old_earnedusdvolume = $row['f_earnedusdvolume'];
            $f_lendid = $row['f_id'];
            $f_token = $row['f_token'];
            $add_earnedusdvolume = $invest_usdvolume * $earning_rate/100;
            if($invest_usdvolume<=1000){
		    	$add_earnedusdvolume = $add_earnedusdvolume;
		    }else if($invest_usdvolume<=5000){
		    	$add_earnedusdvolume = $add_earnedusdvolume + $invest_usdvolume * 0.15/100;
		    }else if($invest_usdvolume<=10000){
		    	$add_earnedusdvolume = $add_earnedusdvolume + $invest_usdvolume * 0.25/100;
		    }else if($invest_usdvolume<=100000){
		    	$add_earnedusdvolume = $add_earnedusdvolume + $invest_usdvolume * 0.30/100;
		    }else{
		    	$add_earnedusdvolume = $add_earnedusdvolume + $invest_usdvolume * 0.35/100;
		    }
            $new_earnedusdvolume = $old_earnedusdvolume + $add_earnedusdvolume;
            $new_earnedusdvolume = number_format($new_earnedusdvolume, 8, '.', '');
            $query = "UPDATE `tb_lends` SET `f_earnedusdvolume`='".$new_earnedusdvolume."' WHERE `f_id`='".$row['f_id']."'";
    		$conn->query($query);
    		$f_regdate = date('Y-m-d');
    		$query =  "SELECT MAX(`f_id`) FROM `tb_earnings`";
		    $sub_result = $conn->query($query);
		    if ($sub_result->num_rows > 0) {
		        while($sub_row = $sub_result->fetch_assoc()) {
		            $f_max_id = $sub_row["MAX(`f_id`)"];
		        }
		    }
		    $f_id = $f_max_id + 1;
    		$query = "INSERT INTO `tb_earnings` (
	            `f_id`,
	            `f_lendid`,
	            `f_token`,
	            `f_amount`,
	            `f_regdate`,
	            `f_earningrate`
	        ) VALUES (
	            '".$f_id."',
	            '".$f_lendid."',
	            '".$f_token."',
	            '".$add_earnedusdvolume."',
	            '".$f_regdate."',
	            '".$earning_rate."'
	        )";
	        $conn->query($query);
	        $query =  "SELECT MAX(`f_id`) FROM `tb_history`";
	        $sub_result = $conn->query($query);
	        if ($sub_result->num_rows > 0) {
	            while($sub_row = $sub_result->fetch_assoc()) {
	                $f_max_id = $sub_row["MAX(`f_id`)"];
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
	            '".$f_token."',
	            '".$f_regdate."',
	            'in',
	            '".$add_earnedusdvolume."',
	            'Profit for Lend ID: ".$f_lendid." (Amt: $ ".$row['f_usdvolume'].", Interest paid: ".$earning_rate."%)',
	            'usd',
	            '0'
	        )";
	        $conn->query($query);
        }
    }
    $query = "UPDATE `tb_values` SET `f_value`='".$system_values['next_earning_rate']."' WHERE `f_title`='earning_rate'";
    $conn->query($query);
?>