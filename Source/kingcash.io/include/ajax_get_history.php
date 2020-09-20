<?php	
	$token = $_GET['token'];
	$type = $_GET['type'];
	include('mysql_connect.php');
    if($type=='exchange'){
        $query =  "SELECT * FROM `tb_history` WHERE `f_token`='".$token."' && `f_isexchange`='1'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['f_inout']=="in"){
                    $symbol = "+";
                }else{
                    $symbol = "-";
                }
                $data[] = array(
                    $row['f_regdate'],
                    $symbol." ".number_format($row['f_amount'], 8, '.', '')." : ".$row['f_type'],
                    $row['f_detail']
                );
            }
        }else{
            $data[] = array("", "", "0 results");
        }
    }else{
        $query =  "SELECT * FROM `tb_history` WHERE `f_token`='".$token."' && `f_type`='".$type."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['f_inout']=="in"){
                    $symbol = "+";
                }else{
                    $symbol = "-";
                }
                $data[] = array(
                    $row['f_regdate'],
                    $symbol." ".number_format($row['f_amount'], 8, '.', '')." : ".$row['f_type'],
                    $row['f_detail']
                );
            }
        }else{
            $data[] = array("", "", "0 results");
        }
    }
	$output = array(
        "data" => $data
    );
    echo json_encode($output);
?>