    <?php require_once('common/header.php');?>
        <link rel="stylesheet" href="assets/plugin/phone/build/css/intlTelInput.css">
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Profile</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
                <li><a href="exchange"><i class="icon icon-signal"></i> <span>Exchange</span></a> </li>
                <li><a href="history"><i class="icon icon-sitemap"></i> <span>History</span></a></li>
                <li><a href="referrals"><i class="icon-group"></i> <span>Referrals</span></a></li>
                <li class="active"><a href="profile"><i class="icon-cogs"></i> <span>Profile</span></a></li>
                <li><a href="security"><i class="icon-lock"></i> <span>Security</span></a></li> 
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>      
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="profile" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-cogs"></i>Profile</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                    <h5>Personal Information</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <form action="include/edit_profile" method="POST" class="form-horizontal" id="edit_profile_form">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
                                        <div class="control-group">
                                            <label class="control-label">Username :</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="username" value="<?php echo $_SESSION['username'];?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Email :</label>
                                            <div class="controls">
                                                <input type="email" class="span11" name="email" value="<?php echo $_SESSION['email'];?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Name :</label>
                                            <div class="controls">
                                                <input type="text"  class="span11" name="name" value="<?php echo $_SESSION['name'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Phone :</label>
                                            <div class="controls">
                                                <input id="phone" type="tel" name="intlNumber" class="span11" value="<?php echo $_SESSION['phone'];?>" required="required" style="color: #555;" />
                                                <input type="hidden" name="country">        
                                            </div>
                                        </div>   
                                        <div class="control-group">
                                            <label class="control-label">Your ETH wallet address :</label>
                                            <div class="controls">
                                                <input type="text" name="myethaddress" class="span11" value="<?php 
                                                    require_once('include/mysql_connect.php');
                                                    $query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$_SESSION['token']."'";
                                                    $result = $conn->query($query);
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()) {
                                                            $kcpaddress = $row['f_profile_kcpaddress'];
                                                        }
                                                    }
                                                    echo $kcpaddress;
                                                ?>" required="required" style="color: #555;text-align: left;" />
                                                <input type="hidden" name="country">        
                                            </div>
                                        </div>                                
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                        <?php
                                            if(isset($_GET['res'])){
                                                $error = $_GET['res'];
                                                switch ($error) {
                                                    case 'db':
                                                        $warning = "Changing profile failed on database.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'success':
                                                        $warning = "Your account information has been changed successfuly.";
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
                                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                    <h5>Change Password</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <form action="include/change_password" method="POST" class="form-horizontal">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
                                        <div class="control-group">
                                            <label class="control-label">Current password :</label>
                                            <div class="controls">
                                                <input type="password" class="span11" name="current_password"/>
                                            </div>
                                        </div>                                    
                                        <div class="control-group">
                                            <label class="control-label">New password :</label>
                                            <div class="controls">
                                                <input type="password"  class="span11" name="password"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Confirm password :</label>
                                            <div class="controls">
                                                <input type="password" class="span11" name="confirm_password"/>
                                            </div>
                                        </div>                                
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Change</button>
                                        </div>
                                        <?php
                                            if(isset($_GET['res'])){
                                                $error = $_GET['res'];
                                                switch ($error) {
                                                    case 'db':
                                                        $warning = "Changing password failed on database.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'curpwd':
                                                        $warning = "Wrong current password.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'pwd':
                                                        $warning = "Password doesn't marched with confirm password.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'pwd_length':
                                                        $warning = "The password should be at least 6 characters.";
                                                        echo '  <div class="alert alert-danger">
                                                            Oops! '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'pwd_success':
                                                        $warning = "Your account password has been changed successfuly.";
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
                    </div>        
                </div>  
            </div>      
        </div>
        <?php include('common/footer.php');?>
        <script src="js/edit_profile.js"></script>
    </body>
</html>