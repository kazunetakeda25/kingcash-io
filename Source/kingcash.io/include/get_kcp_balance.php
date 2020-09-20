<?php 
	$token = $_POST['token'];
	include('mysql_connect.php');
    $query =  "SELECT `f_kcpbalance` FROM `tb_address` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $kcp_real_balance = $row['f_kcpbalance'];
        }
    }
    $query =  "SELECT * FROM `tb_kcpwallet` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $kcp_local_amount = $row['f_amount'];
            $kcp_referrerbonus = $row['f_referrerbonus'];
        }
    }
    $kcp_balance = $kcp_real_balance + $kcp_local_amount + $kcp_referrerbonus;
    echo json_encode(number_format($kcp_balance, 8, '.', ''));
?>