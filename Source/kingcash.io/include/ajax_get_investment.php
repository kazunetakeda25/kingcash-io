<?php   
    $token = $_GET['token'];
    include('mysql_connect.php');
    $query =  "SELECT * FROM `tb_lends` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $regdate = $row['f_regdate'];
            $releasedate = $row['f_releasedate'];
            $regdate = new DateTime($regdate);
            $regdate_int = $regdate->getTimestamp();
            $releasedate = new DateTime($releasedate);
            $releasedate_int = $releasedate->getTimestamp();
            $date_difference = $releasedate_int - $regdate_int;
            $currentdate = date('Y-m-d H:i:s');
            $currentdate = new DateTime($currentdate);
            $currentdate_int = $currentdate->getTimestamp();
            $date_gone = $currentdate_int - $regdate_int;
            $date_difference = floor($date_difference/(24*3600));
            $date_gone = floor($date_gone/(24*3600));
            $compare_today = date('Y-m-d');
            $query =  "SELECT * FROM `tb_earnings` WHERE `f_lendid`='".$row['f_id']."' && `f_regdate`>='".$compare_today."' ORDER BY `f_regdate` ASC limit 0, 1";
            $sub_result = $conn->query($query);
            if ($sub_result->num_rows > 0) {
                while($sub_row = $sub_result->fetch_assoc()) {
                    $today_earned = $sub_row['f_amount'];
                }
            }else{
                $today_earned = 0;
            }
            $return_data[] = array(
                $row['f_regdate'], 
                number_format($row['f_usdvolume'], 2, '.', ''), 
                $row['f_kcpvolume'], 
                $date_gone."/".$date_difference, 
                number_format($today_earned, 2, '.', ''),
                number_format($row['f_earnedusdvolume'], 2, '.', '')
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