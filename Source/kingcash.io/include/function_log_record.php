<?php
	$f_regdate = date("Y-m-d H:i:s");
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
    	`f_amount`,
    	`f_detail`
    	) VALUES (
    	'".$f_id."',
    	'".$f_token."',
    	'".$f_regdate."',
    	'".$f_amount."',
    	'".$f_detail."')";
    $conn->query($query);	
?>