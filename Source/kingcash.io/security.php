<?php
    require_once('common/header.php');    
?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Security</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
                <li><a href="exchange"><i class="icon icon-signal"></i> <span>Exchange</span></a> </li>
                <li><a href="history"><i class="icon icon-sitemap"></i> <span>History</span></a></li>
                <li><a href="referrals"><i class="icon-group"></i> <span>Referrals</span></a></li>
                <li><a href="profile"><i class="icon-cogs"></i> <span>Profile</span></a></li>
                <li class="active"><a href="security"><i class="icon-lock"></i> <span>Security</span></a></li>
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>      
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="security" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-lock"></i>Security</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid"> 
                    <div class="span12">
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
                                    <h5>Two Factor Setup</h5>
                                </div>
                                <div class="widget-content">    
                                    <?php           
                                        $secret = $_SESSION['2fa_secret_key'];     
                                        include('assets/plugin/google2fa/vendor/autoload.php');
                                        use PragmaRX\Google2FA\Google2FA;
                                        $google2fa = new Google2FA();                              
                                        $qrcode_url = $google2fa->getQRCodeGoogleUrl(
                                            'kingcash.io',
                                            $_SESSION['email'],
                                            $secret
                                        ); 
                                    ?>   
                                    To setup two factor authentication you first need to download Google Authenticator:
                                    <br><i class="fa fa-android" style="color:#000;font-weight: bold;"></i>&nbsp;&nbsp;<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Google Authenticator for Android (Play Store)</a>
                                    <br><i class="fa fa-apple" style="color:#000;font-weight: bold;"></i>&nbsp;&nbsp;<a href="https://itunes.apple.com/en/app/google-authenticator/id388497605?mt=8">Google Authenticator for iOS (Apple App Store)</a>
                                    <br>Then scan the below barcode or, if you are not able to scan the barcode, you can enter the "Security Key" manually.
                                    <br>Security Key: <b><?php echo $secret;?></b> (Time Based Code)
                                </div>
                                <div class="widget-content">    
                                    <img src="<?php echo $qrcode_url; ?>" style="width:50%;margin-left: 25%;"/>
                                </div>
                                <div class="widget-content">    
                                    Enter the 6 digit code generated by Google Authenticator in the 2FA Code box and switch "Enable Two-Factor" to On
                                    <br><span class="date badge badge-important">Important</span> Save this secret code for future reference
                                    <br><span style="font-style: italic;">Note: No Google account is required to use Google Authenticator; skip any Google logins</span>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
                                    <h5>Account Security</h5>
                                </div>
                                <div class="widget-content">    
                                    Two Factor Authentication
                                    <form action="include/change_secret_status" method="POST" class="form-horizontal">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
                                        <input type="hidden" name="secret_key" value="<?php echo $secret;?>"/>
                                        <div class="control-group">
                                            <label class="control-label">Enable Two-Factor :</label>
                                            <div class="controls">
                                                <div class="control-group">
                                                    <label style="float: left;">
                                                        <input type="radio" name="secret_status_setting" id="secret_status_setting" value="0" style="margin-top: 0px;" <?php if($_SESSION['2fa_status']=="true") echo 'checked="checked"';?>/>
                                                        On
                                                    </label>
                                                    <label style="float: left;margin-left: 10px;">
                                                        <input type="radio" name="secret_status_setting" id="secret_status_setting" value="1" style="margin-top: 0px;" <?php if($_SESSION['2fa_status']=="false") echo 'checked="checked"';?>/>
                                                        Off
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter 2FA Code :</label>
                                            <div class="controls">
                                                <input type="text"  class="span11" name="secret_code"/>
                                            </div>
                                        </div>                          
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                        <?php
                                            if(isset($_GET['res'])){
                                                $error = $_GET['res'];
                                                switch ($error) {
                                                    case 'off':
                                                        $warning = "Two-Factor Authentication is disabled.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'secret_wrong':
                                                        $warning = "Wrong 2FA Code. Please input correct code.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'db':
                                                        $warning = "DB connection error. Please try again.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'success':
                                                        $warning = "2FA has been turned on successfully.";
                                                        echo '  <div class="alert alert-success">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'off_success':
                                                        $warning = "2FA has been turned off successfully.";
                                                        echo '  <div class="alert alert-success">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                }

                                            }
                                        ?>
                                    </form>
                                </div>    
                            </div>
                        </div>
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
                                    <h5>Google Authenticator Guide</h5>
                                </div>
                                <div class="widget-content"> 
                                    <br>1. Install Google Authenticator for <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" style="color: #000;"><b>Android</b></a> or <a href="https://itunes.apple.com/en/app/google-authenticator/id388497605?mt=8" style="color: #000;"><b>Apple</b></a> and open Google Authenticator
                                    <br>2. Go to <span class="by label">Menu</span> -> <span class="by label">Setup Account</span>
                                    <br>3. Choose <span class="by label">Scan a barcode</span> option, and scan the barcode shown on this page
                                    <br>4. If you are unable to scan the barcode: Choose <span class="by label">Enter provided key</span> and type in the "Security Key"
                                    <br>5. A six digit number will now appear in your Google Authenticator app home screen, enter this code into the 2FA form on this page
                                    <br>6. Every time you login to hextracoin.co you must enter the new 2FA code from your Google Authenticator into the 2FA box on the login form
                                    <br>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="row-fluid">
                </div>
            </div>      
        </div>
        <?php include('common/footer.php');?>
    </body>
</html>