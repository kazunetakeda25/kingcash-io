<!DOCTYPE html>
<html>
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
	    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
	    <link rel="stylesheet" href="assets/css/uniform.css" />
	    <link rel="stylesheet" href="assets/css/select2.css" /> 
	    <link rel="shortcut icon" href="img/favicon.ico">
	</head>
	<body style="background-color: #f0f8fb;color: #000;">
		<div id="content" style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 0px;">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						<div class="span9">
							<div class="login_image"></div>
						</div>
						<div class="span3">
							<?php
								$token = $_GET['token'];
								require_once('include/mysql_connect.php'); 
								$query =  'SELECT * FROM tb_users WHERE f_token="'.$token.'"';
								$result = $conn->query($query);
								if ($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
								        $userdata = $row;
								    }			    
								}
								$query = "UPDATE `tb_users` SET `f_verified`='true' WHERE `f_token`='".$token."'";
								if ($conn->query($query) === TRUE) {}
								$conn->close();
							?>
							<form action="" method="POST" class="span11" id="login_register_form">
								<h1>Account Activated</h1>
								<br>
								<p style="text-align: center;"><h3>Hi, <?php echo $userdata['f_name'];?>! <br>Your KingCash account is now activated.</h3>
								<br></p>
								<p style="text-align: center;"><a class="btn btn-primary" href="login">Go to login page</a></p>
								<br>						
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>  	
	<script src="assets/js/jquery.min.js"></script> 
    <script src="assets/js/jquery.ui.custom.js"></script> 
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>