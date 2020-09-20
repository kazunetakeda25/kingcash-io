<?php
	include('mysql_connect.php');
	$query =  "SELECT * FROM `tb_users`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $query =  "SELECT SUM(`f_kcpvolume`), SUM(`f_usdvolume`), SUM(`f_earnedusdvolume`) FROM `tb_lends` WHERE `f_token`='".$row['f_token']."'";
            $sub_result = $conn->query($query);
            if ($sub_result->num_rows > 0) {
                while($sub_row = $sub_result->fetch_assoc()) {
                    $f_kcpvolume = $sub_row['SUM(`f_kcpvolume`)'];
                    $f_usdvolume = $sub_row['SUM(`f_usdvolume`)'];
                    $f_earnedusdvolume = $sub_row['SUM(`f_earnedusdvolume`)'];
                }
            }else{
                $f_kcpvolume = "0.00000000";
                $f_usdvolume = "0.00";
                $f_earnedusdvolume = "0.00";
            }
            $data[] = array(
            	$row['f_id'],
            	$row['f_email'],
                $row['f_token'],
                $f_kcpvolume,
                $f_usdvolume,
                $f_earnedusdvolume
            );
        }
    }else{
        $data[] = array("", "", "", "", "",  "0 results");
    }
    $output = array(
        "data" => $data
    );
    echo json_encode($output);
?>