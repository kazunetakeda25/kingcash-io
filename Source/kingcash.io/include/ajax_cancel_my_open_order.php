<?php   
    $my_open_order_id = $_POST['my_open_order_id'];
    $token = $_POST['token'];
    include('mysql_connect.php');
    $res['res'] = "true";
    $query =  "SELECT * FROM `tb_orders` WHERE `f_token`='".$token."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $order_type = $row['f_ordertype'];
            $kcpvolume = $row['f_kcpvolume'];
            $btcvolume = $row['f_btcvolume'];
        }
    }
    $query =  "DELETE FROM `tb_orders` WHERE `f_id`='".$my_open_order_id."'";
    $conn->query($query);
    if($order_type=="buy"){
        $query =  "SELECT `f_amount` FROM `tb_btcwallet` WHERE `f_token`='".$token."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $from_address_amount = $row['f_amount'];
            }
        }
        $from_address_amount = $from_address_amount + $btcvolume;
        $query = "UPDATE `tb_btcwallet` SET `f_amount`='".$from_address_amount."' WHERE `f_token`='".$token."'";
        if ($conn->query($query) === TRUE) {}else{
            $res['res'] = "false";
            $res['msg'] = "DB error";
        }
        if($res['res']=="true"){
            $f_regdate = date('Y-m-d H:i:s');
            $query =  "SELECT MAX(`f_id`) FROM `tb_history`";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $f_max_id = $row["MAX(`f_id`)"];
                }
            }
            $f_id = $f_max_id + 1;
            $query = "INSERT INTO `tb_history` (
                `f_id`,
                `f_token`,
                `f_regdate`,
                `f_inout`,
                `f_amount`,
                `f_detail`,
                `f_type`,
                `f_isexchange`
            ) VALUES (
                '".$f_id."',
                '".$token."',
                '".$f_regdate."',
                'in',
                '".$btcvolume."',
                'Cancel My open order, OrderID : ".$my_open_order_id."',
                'btc',
                '1'
            )";
            if ($conn->query($query) === TRUE) {
            }else {
                $res['res'] = "false";
                $res['msg'] = "DB error";
            }
        }
    }else{
        $query =  "SELECT `f_amount` FROM `tb_kcpwallet` WHERE `f_token`='".$token."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $from_address_amount = $row['f_amount'];
            }
        }
        $from_address_amount = $from_address_amount + $kcpvolume;
        $query = "UPDATE `tb_kcpwallet` SET `f_amount`='".$from_address_amount."' WHERE `f_token`='".$token."'";
        if ($conn->query($query) === TRUE) {}else{
            $res['res'] = "false";
            $res['msg'] = "DB error";
        }
        if($res['res']=="true"){
            $f_regdate = date('Y-m-d H:i:s');
            $query =  "SELECT MAX(`f_id`) FROM `tb_history`";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $f_max_id = $row["MAX(`f_id`)"];
                }
            }
            $f_id = $f_max_id + 1;
            $query = "INSERT INTO `tb_history` (
                `f_id`,
                `f_token`,
                `f_regdate`,
                `f_inout`,
                `f_amount`,
                `f_detail`,
                `f_type`,
                `f_isexchange`
            ) VALUES (
                '".$f_id."',
                '".$token."',
                '".$f_regdate."',
                'in',
                '".$kcpvolume."',
                'Cancel My open order, OrderID : ".$my_open_order_id."',
                'kcp',
                '1'
            )";
            if ($conn->query($query) === TRUE) {
            }else {
                $res['res'] = "false";
                $res['msg'] = "DB error";
            }
        }
    }
    echo json_encode($res);
?>