<?php
    $result = json_decode(file_get_contents('https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0xa7a05cf8d6d8e4e73db47fe4de4cbd5b63d15cfa&address=0x9D1099BeA74734dc911Fa77d4eFC2Fa7BEC48aE6&tag=latest&apikey=4YYAPWYIDCYFVZ74YWGNGTVV9ZCICQ5AYC'));
    $kcp_api_balance = $result->{'result'};
    $kcp_real_balance = $kcp_api_balance/pow(10,18);
    echo $kcp_real_balance;
?>