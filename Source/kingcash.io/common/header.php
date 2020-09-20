<?php
      session_start();
      if(!isset($_SESSION['logged_in'])||($_SESSION['logged_in']!="true")){
        header('Location: login');
        exit;
      }      
?>
<html lang="en">
  <head>
    <title>KING CASH</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/matrix-style.css" />
    <link rel="stylesheet" href="assets/css/matrix-media.css" />
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="assets/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="css/customize.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/uniform.css" />
    <link rel="stylesheet" href="assets/css/select2.css" /> 
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="img/favicon.ico">
  </head>
  <body style="background-color: #1f262d;font-size:14px;">
    <?php
      require_once('include/mysql_connect.php');
      $query =  "SELECT * FROM `tb_values`";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $system_values[$row['f_title']] = $row['f_value'];
          }
      }
    ?>
    <div id="header">
      <h1><a href="dashboard.php">KING CASH</a></h1>
    </div>
    <div id="user-nav" class="navbar navbar-inverse">
      <ul class="nav">
        <li class=""><a title="" href="#"><span class="text" style="font-size: 14px;">Today Currency</span></a></li>
        <li class=""><a title="" href="#"><span class="text" style="font-size: 14px;">1 KCP = USD <span id="kcpusd"></span></span></a></li>
        <li class=""><a title="" href="#"><span class="text" style="font-size: 14px;">1 BTC = USD <?php echo $system_values['btcusd'];?></span></a></li>
      </ul>
    </div>
    <input type="hidden" id="token" value="<?php echo $_SESSION['token'];?>"/>
    <input type="hidden" id="btcusd_rate" value="<?php echo $system_values['btcusd'];?>"/>