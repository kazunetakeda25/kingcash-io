<?php
    include('mysql_connect.php');
    $ordertype = $_GET['ordertype'];
    $query =  "SELECT * FROM `tb_values`";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $system_values[$row['f_title']] = $row['f_value'];
        }
    }
    if($ordertype=="buy"){
        $query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`= 'buy' ORDER BY `f_btcpriceperkcp` DESC limit 0,30";
    }else{
        $query =  "SELECT * FROM `tb_orders` WHERE `f_ordertype`= 'sell' ORDER BY `f_btcpriceperkcp` ASC limit 0,30";
    }
    $result = $conn->query($query);
    $row_count = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $orderdata[$row_count] = $row;
            $row_count++;
        }
    }
    if ($row_count>0){
        for ($i=0;$i<$row_count;$i++) {
            $data[$i]['btcvolume'] = $orderdata[$i]['f_btcpriceperkcp']*$orderdata[$i]['f_kcpvolume'];
            $data[$i]['btcpriceperkcp'] = $orderdata[$i]['f_btcpriceperkcp'];
            $data[$i]['kcpusd'] = $system_values['btcusd']*$orderdata[$i]['f_btcpriceperkcp'];
            $data[$i]['kcpvolume'] = $orderdata[$i]['f_kcpvolume'];
            $temp = 0;
            for($j=0;$j<=$i;$j++){
                $temp = $temp + $orderdata[$j]['f_kcpvolume'];
            }
            $data[$i]['total_kcpvolume'] = $temp;
        }
        foreach ($data as $row) {
            $return_data[] = array(
                "",
                number_format($row['btcvolume'], 8, '.', ''),
                number_format($row['btcpriceperkcp'], 8, '.', ''),
                number_format($row['kcpusd'], 8, '.', ''),
                number_format($row['kcpvolume'], 8, '.', ''),
                number_format($row['total_kcpvolume'], 8, '.', '')
            );
        }
    }else{
        $return_data[] = array("", "", "", "", "", "0 results");
    }
    $output = array(
        "data" => $return_data
    );
    echo json_encode($output);
?>