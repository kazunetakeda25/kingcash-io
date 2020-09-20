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
								$conn->close();
							?>
							<form action="include/reset_password" method="POST" class="span11" id="login_register_form">
								<input type="hidden" name="token" id="token" value="<?php echo $token;?>">
								<h1>Reset Password</h1>
								<?php
									if(isset($_GET['res'])){
										$error = $_GET['res'];
										switch ($error) {
											case 'pwd':
												$warning = "Input correct password.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'pwd_length':
												$warning = "The password should be at least 6 characters.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'recaptcha':
												$warning = "The reCAPTCHA field is required.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'db':
												$warning = "Changing password failed on database.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'success':
												$warning = "Your account password has been changed successfuly. Now you can login with new password. Thank you";
												echo '	<div class="alert alert-success">
		                        					'.$warning.'
		                        				</div>';
												break;
										}

									}
								?>
								Email
								<input type="email" class="span12" value="<?php echo $userdata['f_email']?>" readonly="readonly"/>
								Password
								<input type="password" class="span12" " name="password"/>
								Confirm Password
								<input type="password" class="span12" name="confirm_password"/>
								<script src="https://www.google.com/recaptcha/api.js" async defer></script>
								<div class="g-recaptcha" data-sitekey="6LcjiTsUAAAAAPe16j8YbMaMVoqJBizT3UVuHhWT"></div>
								<br>
								<input type="submit" class="btn btn-primary" style="width: 100%;" value="Reset Password"/>
								<br>
								Already a member? Click 
								<a href="login">here</a>
								 to login.
								<br>
								<a href="forget_password">Forgot password?</a> 
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
    <script src="js/reset_password.js"></script>
</body>
</html>