<?php
	include('mysql_connect.php');
	$query =  "SELECT SUM(`f_kcpvolume`), SUM(`f_usdvolume`), SUM(`f_earnedusdvolume`) FROM `tb_lends`";
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
    $data['total_kcp'] = $f_kcpvolume;
    $data['total_usd'] = $f_usdvolume;
    $data['total_usd_earned'] = $f_earnedusdvolume;
    foreach ($data as $key => $value) {
        if((!isset($value))||($value==null)){
            $return_data[$key] = "0.00000000";   
        }else{
            $return_data[$key] = number_format($value, 8, '.', '');   
        }
    }
    echo json_encode($return_data);
?>