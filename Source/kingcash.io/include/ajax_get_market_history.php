<?php	
	include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_markethistory` ORDER BY `f_regdate` DESC limit 0,200";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['f_ordertype']=="buy"){
                $symbol = "+";
            }else{
                $symbol = "-";
            }
            $data[] = array(
                $symbol,
                $row['f_regdate'],
                $row['f_ordertype'],
                number_format($row['f_btcpriceperkcp'], 8, '.', ''),
                number_format($row['f_kcpvolume'], 8, '.', ''),
                number_format($row['f_btcpriceperkcp']*$row['f_kcpvolume'], 8, '.', '')
            );
        }
    }else{
        $data[] = array("", "", "", "", "", "0 results");
    }
    $output = array(
        "data" => $data
    );
    echo json_encode($output);
?>