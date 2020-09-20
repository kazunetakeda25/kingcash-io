<?php
	include('mysql_connect.php');
	$query =  "SELECT * FROM `tb_address`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = array(
            	$row['f_id'],
            	$row['f_token'],
                $row['f_btcaddress'],
            	$row['f_btcbalance']/pow(10,8),
                $row['f_btcaddress_private']
            );
        }
    }else{
        $data[] = array("", "", "0 results");
    }
    $output = array(
        "data" => $data
    );
    echo json_encode($output);
?>