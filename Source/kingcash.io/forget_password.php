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
							<form action="include/forget_password" method="POST" class="span11" id="login_register_form">
								<h1>Forgot Password</h1>
								<?php
									if(isset($_GET['res'])){
										$error = $_GET['res'];
										switch ($error) {
											case 'recaptcha':
												$warning = "The reCAPTCHA field is required.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'email':
												$warning = "No registered email address.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'email_send':
												$warning = "Email verification error. Please try again.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'success':
												$warning = "Please check your email for password reset link.";
												echo '	<div class="alert alert-success">
		                        					'.$warning.'
		                        				</div>';
												break;
										}

									}
								?>
								<div class="control-group">
									<label class="control-label">Email</label>
                                    <div class="controls">
                                        <input type="email" class="span12" name="email" required="required" style="width: 100%;"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
										<div class="g-recaptcha" data-sitekey="6LcjiTsUAAAAAPe16j8YbMaMVoqJBizT3UVuHhWT"></div>
                                    </div>
                                </div>
								<div class="control-group">
                                    <div class="controls">
                                        <input type="submit" class="btn btn-primary" style="width: 100%;" value="Send Password Reset Link"/>
                                    </div>
                                </div>
								<div class="control-group">
                                    <div class="controls">
                                        Already a member? Click 
										<a href="login">here</a>
										 to login.
										<br>
										or <a href="register">register</a> 
                                    </div>
                                </div>
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
    <script src="js/forget_password.js"></script>
</body>
</html>