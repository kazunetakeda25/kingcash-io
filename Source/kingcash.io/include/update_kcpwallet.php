<?php	
	ini_set('max_execution_time', 3000);
	include('mysql_connect.php');
	$query =  "SELECT tb_users.f_token, tb_address.f_kcpaddress FROM tb_users INNER JOIN tb_address ON tb_users.f_token=tb_address.f_token";
    $result = $conn->query($query);
    $row_count = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           	$user_kcpaddress_data[$row_count] = $row;
            $kcp_api_balance = json_decode(file_get_contents('https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0xa7a05cf8d6d8e4e73db47fe4de4cbd5b63d15cfa&address='.$row['f_kcpaddress'].'&tag=latest&apikey=4YYAPWYIDCYFVZ74YWGNGTVV9ZCICQ5AYC'));
            $kcp_real_balance = $kcp_api_balance->{'result'};
            $kcp_real_balance = $kcp_real_balance/pow(10,18);
            $user_kcpaddress_data[$row_count]['kcp_real_amount'] = number_format($kcp_real_balance, 8, '.', '');
           	$row_count++;
        }
    }	
    $conn->close();
?>