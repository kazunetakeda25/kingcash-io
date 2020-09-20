<?php
    ini_set('max_execution_time', 3000); 
	include('../include/mysql_connect.php');
	$query =  "SELECT * FROM `tb_address` ORDER BY `f_id` ASC limit 350,50";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $btc_address = $row['f_btcaddress'];
            $balance_info = file_get_contents('https://blockchain.info/q/addressbalance/'.$btc_address);
            echo $row['f_id'].":".$balance_info." , ";
        }
    }
?>