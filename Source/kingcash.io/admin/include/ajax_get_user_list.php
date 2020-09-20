<?php
	include('mysql_connect.php');
	$query =  "SELECT * FROM `tb_users`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = array(
            	$row['f_id'],
            	$row['f_email'],
            	$row['f_country'],
            	$row['f_token'],
            	$row['f_verified']
            );
        }
    }else{
        $data[] = array("", "", "", "", "", "", "0 results");
    }
    $output = array(
        "data" => $data
    );
    echo json_encode($output);
?>