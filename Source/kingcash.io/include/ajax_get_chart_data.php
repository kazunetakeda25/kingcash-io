<?php	
	include('mysql_connect.php');
    $query =  "SELECT `f_btcpriceperkcp`, `f_regdate` FROM `tb_markethistory` ORDER BY `f_regdate` ASC";
    $result = $conn->query($query);
    $row_count = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $current_date = new DateTime($row['f_regdate']);
            $current_date_int = $current_date->getTimestamp();
            $current_date_format_int = $current_date_int - ($current_date_int%3600);
            $data[$row_count]['date'] = date("Y-m-d H:i:s", $current_date_format_int);
            $data[$row_count]['price'] = number_format($row['f_btcpriceperkcp'], 8, '.', '');
            $row_count++;
        }
    }
    $data_count = 0;
    for($i=0;$i<$row_count;$i++){
        if(isset($data[$i-1])&&($data[$i]['date']===$data[$i-1]['date'])) continue;
        $chartData[$data_count]['date'] = $data[$i]['date'];
        $chartData[$data_count]['price'] = $data[$i]['price'];
        $data_count++;
    }
    echo json_encode($chartData);
?>