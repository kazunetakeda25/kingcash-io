<?php	
	include('mysql_connect.php');
	$current_time = new DateTime();
    $current_time_int = $current_time->getTimestamp();
    $query = "UPDATE `tb_values` SET `f_value`='".$current_time_int."' WHERE `f_title`='last_api_request'";
    $conn->query($query);
?>