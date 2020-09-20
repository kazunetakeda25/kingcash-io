<?php
    ini_set('max_execution_time', 30000); 
    include('../include/mysql_connect.php');
    $query =  "SELECT * FROM `tb_history`";
    $result = $conn->query($query);
    $count = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $query = "UPDATE `tb_history` SET `f_detail`='Referral Bonus' WHERE `f_id`='".$row['f_id']."'";
            $conn->query($query);
        }
    }
?>