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
							<form action="include/login_validation" method="POST" class="span11" id="login_register_form">								
								<img src="img/logo.png" style="width: 60%;margin-left: 20%;">
								<p style="text-align: center;color:#2b3036;font-size: 28px;">KING CASH</p>
								<br>
								<?php
									if(isset($_GET['res'])){
										$error = $_GET['res'];
										switch ($error) {
											case 'email':
												$warning = "This email account is not exist.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'password':
												$warning = "Wrong password. Please try again.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'repairing':
												$warning = "This site is under maintenance.";
												echo '	<div class="alert alert-danger">
		                        					'.$warning.'
		                        				</div>';
												break;
											case 'verified':
												$warning = "This account has not been activated yet. <br>Please check your email and click on the activation link.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'secret_empty':
												$warning = "Please input your 2fa code.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'secret_wrong':
												$warning = "Wrong 2fa code. Please try again.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
										}

									}
								?>
								<br>
								<div class="control-group">
                                    <div class="controls">
                                        <input type="email" class="span12" style="width: 100%;" placeholder="Email Address" name="email" required="required"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="password" class="span12" style="width: 100%;" placeholder="Password" name="password" required="required"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="text" class="span12" style="width: 100%;" placeholder="2FA Code(Only if you enabled 2FA)" name="secret"/>
                                    </div>
                                </div>
								<div class="control-group">
                                    <div class="controls">
                                        <input type="submit" class="btn btn-primary" style="width: 100%;" value="Login"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        Not a member yet? Click 
										<a href="register">here</a>
										 to register.
										<br>
										<a href="forget_password">Forgot password?</a> 
                                    </div>
                                </div>
							</form>					
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="assets/js/jquery.min.js"></script> 
	    <script src="assets/js/jquery.ui.custom.js"></script> 
	    <script src="assets/js/bootstrap.min.js"></script>
	</body>
</html>