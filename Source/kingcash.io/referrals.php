    <?php require_once('common/header.php');?>
        <link rel="stylesheet" href="assets/css/uniform.css" />
        <link rel="stylesheet" href="assets/css/select2.css" /> 
        <link rel="stylesheet" href="assets/plugin/phone/build/css/intlTelInput.css">
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>referrals</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
                <li><a href="exchange"><i class="icon icon-signal"></i> <span>Exchange</span></a> </li>
                <li><a href="history"><i class="icon icon-sitemap"></i> <span>History</span></a></li>
                <li class="active"><a href="referrals"><i class="icon-group"></i> <span>Referrals</span></a></li>
                <li><a href="profile"><i class="icon-cogs"></i> <span>Profile</span></a></li>
                <li><a href="security"><i class="icon-lock"></i> <span>Security</span></a></li> 
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>      
            </ul>
        </div>
        <div id="content">
            <?php
                require_once('include/mysql_connect.php');
                if(isset($_GET['token'])){
                    $token = $_GET['token'];
                }else{
                    $token = $_SESSION['token'];
                }
                $query =  "SELECT f_username FROM `tb_users` WHERE f_token='".$token."'";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $start_username = $row['f_username'];
                    }
                }
                $last_username = $_SESSION['username']; 
             	if($start_username==$last_username){
    	         	$gen = 1;
    			 	$referrers[$gen]['gen'] = $gen;
    			 	$referrers[$gen]['username'] = $start_username;
    			 	$query =  "SELECT f_token FROM `tb_users` WHERE f_username='".$start_username."'";
    	            $result = $conn->query($query);
    	            if ($result->num_rows > 0) {
    	                while($row = $result->fetch_assoc()) {
    	                    $referrers[$gen]['token'] = $row['f_token'];
    	                }
    	            } 	            
    		 	}else{
                    $referrers[1]['gen'] = '1';
                    $referrers[1]['username'] = $start_username;
                    $query =  "SELECT f_token FROM `tb_users` WHERE f_username='".$start_username."'";
                    $result_token = $conn->query($query);
                    if ($result_token->num_rows > 0) {
                        while($row_token = $result_token->fetch_assoc()) {
                            $referrers[1]['token'] = $row_token['f_token'];
                        }
                    }
    	            $reverse_gen = 2;
    	            pos1:;
    	            $query =  "SELECT f_referrer FROM `tb_users` WHERE f_username='".$start_username."'";
    	            $result = $conn->query($query);
    	            if ($result->num_rows > 0) {
    	                while($row = $result->fetch_assoc()) {
    	                    $next_username = $row['f_referrer'];
    	                }
    	                $referrers[$reverse_gen]['gen'] = $reverse_gen;
    	                $referrers[$reverse_gen]['username'] = $next_username;
    	                $query =  "SELECT f_token FROM `tb_users` WHERE f_username='".$next_username."'";
    		            $result_token = $conn->query($query);
    		            if ($result_token->num_rows > 0) {
    		                while($row_token = $result_token->fetch_assoc()) {
    		                    $referrers[$reverse_gen]['token'] = $row_token['f_token'];
    		                }
    		            }	                
    	            }
    	            if($next_username!=$last_username) {
    	            	$reverse_gen++;
    	            	$start_username = $next_username;
    	            	goto pos1;
    				}				
                    $gen = $reverse_gen;
    			}                      
            ?>
            <div id="content-header">
                <div id="breadcrumb"> <a href="referrals" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-group"></i>Referrals</a>
                    <?php 
                        $submenu_str = '';
                        foreach ($referrers as $row) {
                            $submenu_str = '<a href="referrals?token='.$row['token'].'">'.$row['username'].'</a>'.$submenu_str;
                        }
                        echo $submenu_str;
                    ?>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid"> 
                    <input class="span6" type="text" value="https://kingcash.io/register?referrer=<?php echo $_SESSION['username'];?>" id="referrer_url" readonly="readonly" style="margin-bottom:0px;cursor: pointer;">       
                    <input type="button" class="btn btn-primary" value="Copy" id="copy-text">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Members Gen(<?php echo $gen;?>)</h5>
                        </div>
                        <div class="widget-content nopadding" style="margin-top: 30px;">
                            <table class="table table-bordered data-table" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th style="font-size: 12px;text-align: left;">Username</th>
                                        <th style="font-size: 12px;text-align: left;">Downlines</th>
                                        <th style="font-size: 12px;text-align: left;">Country</th>
                                        <th style="font-size: 12px;text-align: left;">Registered At</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    <?php                           
                                        $query =  "SELECT f_username FROM `tb_users` WHERE f_token='".$token."'";
                                        $result = $conn->query($query);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $username = $row['f_username'];
                                            }
                                        }
                                        $query =  'SELECT * FROM tb_users WHERE f_referrer="'.$username.'"';
                                        $result = $conn->query($query);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $query =  'SELECT * FROM tb_users WHERE f_referrer="'.$row['f_username'].'"';
                                                $downline_data_result = $conn->query($query);
                                                $downline_count = 0;
                                                if ($downline_data_result->num_rows > 0) {
                                                    while($downline_data_row = $downline_data_result->fetch_assoc()) {
                                                        $downline_count++;
                                                    }               
                                                }
                                                echo '  <tr>
                                                            <td><a href="referrals?token='.$row['f_token'].'">'.$row['f_username'].'</td>
                                                            <td>'.$downline_count.'</td>
                                                            <td>'.$row['f_country'].'</td>
                                                            <td>'.$row['f_regdate'].'</td>
                                                        </tr>';
                                            }               
                                        }else{
                                            echo '  <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>0 results</td>
                                                    </tr>';
                                        }                                  
                                        $conn->close();
                                    ?>
                                </tbody>                 
                            </table>
                        </div>
                    </div>
                </div> 
            </div>      
        </div>
        <script src="assets/js/jquery.min.js"></script> 
        <script src="assets/js/jquery.ui.custom.js"></script> 
        <script src="assets/js/bootstrap.min.js"></script> 
        <script src="assets/js/jquery.uniform.js"></script> 
        <script src="assets/js/select2.min.js"></script> 
        <script src="assets/js/jquery.dataTables.min.js"></script> 
        <script src="assets/js/matrix.js"></script> 
        <script src="assets/js/matrix.tables.js"></script>
        <script src="assets/plugin/phone/build/js/intlTelInput.js"></script>
        <script type="text/javascript" src="js/referrals.js"></script>
    </body>
</html>