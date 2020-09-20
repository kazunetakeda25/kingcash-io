<?php
	$address = $_GET['address'];
	$token = $_GET['token'];
	include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_withdraw` WHERE `f_token`='".$token."' && `f_status`='on'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        	if ($row['f_status']=='on'){
        		$confirmed = "0";
        	}else{
        		$confirmed = "1";
        	}
            $data[] = array(
                    $row['f_regdate'],
                    $row['f_address'],
                    $row['f_amount'],
                    $confirmed
                );
        }
    }else{
        $data[] = array("", "", "", "", "0 results");
    }
	$output = array(
        "data" => $data
    );
    echo json_encode($output);
?>