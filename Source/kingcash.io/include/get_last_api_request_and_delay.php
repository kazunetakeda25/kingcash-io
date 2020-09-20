<?php	
	$query =  "SELECT * FROM `tb_values` WHERE `f_title`='last_api_request'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $last_api_request_time = $row['f_value'];
        }
    }
  	$current_time = new DateTime();
    $current_time_int = $current_time->getTimestamp();
    if($current_time_int-$last_api_request_time<1){
        sleep(0.1);
    }
?>