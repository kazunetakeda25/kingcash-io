<?php
    include('mysql_connect.php');
    $ordertype = $_GET['ordertype'];
    $token = $_GET['token'];
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    if($ordertype=="buy"){
        $query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`= 'buy' && `f_token`='".$token."' ORDER BY `f_btcpriceperkcp` DESC limit 0,30";
    }else{
        $query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`= 'sell' && `f_token`='".$token."' ORDER BY `f_btcpriceperkcp` ASC limit 0,30";
    }
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = array(
                $row['f_regdate'],
                $ordertype,
                number_format($row['f_btcpriceperkcp'], 8, '.', ''),
                number_format($row['f_kcpvolume'], 8, '.', ''),
                number_format($row['f_btcvolume'], 8, '.', ''),
                "",
                $row['f_id']
            );
        }
    }else{
        $data[] = array("", "", "", "", "", "0 results", "");
    }
    $output = array(
        "data" => $data
    );
    echo json_encode($output);
?>