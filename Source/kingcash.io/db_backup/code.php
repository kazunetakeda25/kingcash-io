<?php
    ini_set('max_execution_time', 3000); 
    function generateRandomString($length = 10) {
        $characters = 'vwxyzABCDEFGHIJKjklmnopqrJKLMNOPQR0123456789abcdefghijklmnop456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKjklmnopqrJKLMNOPQR0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }   
    include('../include/mysql_connect.php');
    $query =  "SELECT * FROM `tb_kcpwallet`";
    $result = $conn->query($query);
    $count = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id_list[$count] = $row['f_id'];
            $count++;
        }
    }
    for ($i=3000;$i<4000;$i++){
        $repeat = "true";
        while($repeat == "true") {
            $f_address = generateRandomString(32);
            $query =  "SELECT `f_address` FROM `tb_kcpwallet` WHERE `f_address`='".$f_address."'";
            $result = $conn->query($query);
            if ($result->num_rows == 0) break;    
        }
        $f_address = "K".$f_address;
        $query = "UPDATE `tb_kcpwallet` SET `f_address`='".$f_address."' WHERE `f_id`='".$id_list[$i]."'";
        $conn->query($query);
        // $query = "UPDATE `tb_kcpwallet` SET `f_address`='' WHERE `f_id`='".$id_list[$i]."'";
        // $conn->query($query);
    }
    
    
?>