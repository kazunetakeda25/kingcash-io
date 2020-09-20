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
	    <link rel="stylesheet" href="assets/plugin/phone/build/css/intlTelInput.css">
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
							<form action="include/user_register" method="POST" class="span11" id="login_register_form" style="margin-top: 10vh;">						
								<?php
									if(isset($_GET['res'])&&$_GET['res']=="success"){}else{
										echo '	<h1>Sign Up</h1>
												Create your KING CASH Account. It is free and always will be.<br><br>';
									}
									if(isset($_GET['referrer'])){
										echo '	Referrer
												<input type="text" class="span12" name="referrer" required="required" readonly="readonly" value="'.$_GET['referrer'].'"/>';
									}
									if(isset($_GET['res'])){
										$error = $_GET['res'];
										switch ($error) {
											case 'no_referrer':
												$warning = "Not existing referrer.";
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
											case 'pwd':
												$warning = "Input correct password.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'pwd_length':
												$warning = "Password should be more than 6 characters.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'username_type':
												$warning = " Username should be only number or alphabet.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'username':
												$warning = "This username is already exist.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'country':
												$warning = "Select country.";
												echo '	<div class="alert alert-danger">
		                        					Oops! '.$warning.'
		                        				</div>';
												break;
											case 'email':
												$warning = "This email address is already exist.";
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
											case 'db_connect':
												$warning = "DB connection error. Please try again.";
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
											case 'success':
												$warning = "<b>Your account has been successfully created.</b><br>You must confirm your email.";
												echo '	<div class="alert alert-success">
				                					'.$warning.'
				                				</div>';
												break;
										}

									}
									if(isset($_GET['res'])&&$_GET['res']=="success"){}else{
										echo '	<div class="control-group">
													<label class="control-label">Username</label>
				                                    <div class="controls">
				                                        <input type="text" class="span12" name="username" required="required" style="width:100%;"/>
				                                    </div>
				                                </div>
				                                <div class="control-group">
													<label class="control-label">Email</label>
				                                    <div class="controls">
				                                        <input type="email" class="span12" name="email" required="required" style="width:100%;"/>
				                                    </div>
				                                </div>
				                                <div class="control-group">
													<label class="control-label">Name</label>
				                                    <div class="controls">
				                                        <input type="text" class="span12" name="name" required="required" style="width:100%;"/>		
				                                    </div>
				                                </div>
				                                <div class="control-group">
													<label class="control-label">Phone</label>
				                                    <div class="controls">
				                                        <input id="phone" type="tel" class="span12" name="phone" required="required" style="color: #555;width:100%;"/>
				                                    </div>
				                                </div>
				                                <div class="control-group">
													<label class="control-label">Password</label>
				                                    <div class="controls">
				                                        <input type="password" class="span12" name="password" id="password" required="required" style="width:100%;"/>
				                                    </div>
				                                </div>
												<div class="control-group">
													<label class="control-label">Confirm Password</label>
				                                    <div class="controls">
				                                        <input type="password" class="span12" name="confirm_password" id="confirm_password" required="required" style="width:100%;"/>
				                                    </div>
				                                </div>
				                                <div class="control-group">
				                                    <div class="controls">
				                                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
														<div class="g-recaptcha" data-sitekey="6LcjiTsUAAAAAPe16j8YbMaMVoqJBizT3UVuHhWT" style="margin-top: 10px;width:100%;"></div>
				                                    </div>
				                                </div>
				                                <div class="control-group">
				                                    <div class="controls">
				                                        <input type="submit" class="btn btn-primary" style="width: 100%;" value="Sign Up"/>
				                                    </div>
				                                </div>
				                                <div class="control-group">
				                                    <div class="controls">
				                                        Already a member? Click 
												<a href="login">here</a>
												 to login.
												<br>
												<a href="forget_password">Forgot password?</a>
				                                    </div>
				                                </div>';
									}
								?>	
								<input type="hidden" name="intlNumber">		
								<input type="hidden" name="country">						
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
    <script src="assets/plugin/phone/build/js/intlTelInput.js"></script>
    <script src="js/register.js"></script>
	<script>
		$("#phone").intlTelInput({
			allowDropdown: true,
		      autoHideDialCode: false,
		      autoPlaceholder: "off",
		      dropdownContainer: "body",
		      // excludeCountries: ["us"],
		      formatOnDisplay: false,
		      geoIpLookup: function(callback) {
		        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
		          var countryCode = (resp && resp.country) ? resp.country : "";
		          callback(countryCode);
		        });
		      },
		      hiddenInput: "full_number",
		      initialCountry: "us",
		      nationalMode: false,
		      placeholderNumberType: "MOBILE",
		      separateDialCode: true,
		      utilsScript: "assets/plugin/phone/build/js/utils.js"
		});		
		$("form").submit(function() {
			var intlNumber = $("#phone").intlTelInput("getNumber");
			var countryData = $("#phone").intlTelInput("getSelectedCountryData");
			var country = countryData['name'];
		  	$('[name=intlNumber]').val(intlNumber);
		  	$('[name=country]').val(country);
		});
	</script>
</body>
</html>