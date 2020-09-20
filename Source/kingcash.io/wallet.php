    <?php require_once('common/header.php');?>
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Wallet</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li class="active"><a href="wallet"><i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
                <li><a href="exchange"><i class="icon icon-signal"></i> <span>Exchange</span></a> </li>
                <li><a href="history"><i class="icon icon-sitemap"></i> <span>History</span></a></li>
                <li><a href="referrals"><i class="icon-group"></i> <span>Referrals</span></a></li>
                <li><a href="profile"><i class="icon-cogs"></i> <span>Profile</span></a></li>
                <li><a href="security"><i class="icon-lock"></i> <span>Security</span></a></li> 
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>      
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="wallet" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-money"></i>Wallet</a></div>
            </div>  
            <div class="container-fluid">                
                <div class="row-fluid">  
                    <div class="span12">
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-content nopadding">
                                    <?php include('include/get_last_api_request_and_delay.php');?>
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="img/btc.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info" id="btcusd_balance"> BTC | USD 0.00</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="btc_balance_text">
                                                        0.00000000
                                                        <input type="hidden" id="token" value="<?php echo $_SESSION['token'];?>">
                                                        <input type="hidden" id="btc_balance">
                                                    </a> 
                                                </p>
                                            </div>
                                        </li>
                                    </ul>        
                                    <?php include('include/update_last_api_request.php');?>
                                </div>
                            </div>
                            <div class="widget-box">
                                <?php
                                    $query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$_SESSION['token']."'";
                                    $result = $conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $btc_real_address = $row['f_btcaddress'];
                                        }
                                    }
                                ?>
                                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                                    <h5>Receive Bitcoin (BTC)</h5>
                                </div>
                                <div class="widget-content">
                                    Get address to deposit Bitcoin (BTC)<br>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deposit_btc" style="margin-top: 10px;">Deposit Bitcoin (BTC)</button>
                                    <div id="deposit_btc" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">                                                
                                                <div class="modal-body"> 
                                                    <p style="text-align: center;"><input class="span10" type="text" value="<?php echo $btc_real_address;?>" id="btc_real_address_string" readonly="readonly" style="margin-bottom:0px;cursor: pointer;">
                                                    <input type="button" class="btn btn-primary" value="Copy" id="copy_btc_real_address"></p>
                                                    <p style="text-align: center;"><img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?php echo $btc_real_address;?>" width="250"></p>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                                    <h5>Send Bitcoin (BTC)</h5>
                                </div>
                                <div class="widget-content">
                                    <form action="include/btc_withdraw" method="POST">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
                                        <input type="hidden" name="balance" id="form_btc_balance"/>
                                        <input type="hidden" name="from_address" value="<?php echo $btc_real_address;?>"/>
                                        To Address
                                        <input type="text" class="span12" name="to_address" required="required" />
                                        Amount in Bitcoin <a href="#" id="select_all_btc">(All : 0.00000000 BTC)</a>
                                        <input type="text" class="span12" id="btc_amount" name="amount" required="required"/>
                                        <label class="control-label">Fee : 0.0005 BTC</label><br>
                                        Password
                                        <input type="password" class="span12" name="password" required="required"/>
                                        <input type="submit" name="submit" class="btn btn-primary" value="Withdraw from BTC wallet"/>
                                        <?php
                                        if(isset($_GET['res'])){
                                            $error = $_GET['res'];
                                            switch ($error) {
                                                case 'btc_password':
                                                    $warning = "Input correct password";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_balance':
                                                    $warning = "Withdraw amount is larger than balance";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_low':
                                                    $warning = "Withdraw amount must larger than 0.0005 BTC";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_wrong':
                                                    $warning = "Input correct address";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_hash':
                                                    $warning = "Withdraw failed";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_maintenance':
                                                    $warning = "BTC wallet under maintenance";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_db':
                                                    $warning = "Database connection failed";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_api':
                                                    $warning = "Error BTC_S5. Please try again after some time.";
                                                    echo '  <hr><div class="alert alert-danger">
                                                        '.$warning.'
                                                    </div>';
                                                    break;
                                                case 'btc_success':
                                                    $warning = "Withdraw BTC successful";
                                                    echo '  <hr><div class="alert alert-success">
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
                                <div class="widget-content nopadding">
                                    <?php include('include/get_last_api_request_and_delay.php');?>
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="KCP" src="img/kcp.jpg"> </div>
                                            <div class="article-post">                                             
                                                <span class="user-info" id="kcpusd_balance"> KCP | USD 0.00 </span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="kcp_balance_text">
                                                        0.00000000
                                                        <input type="hidden" id="token" value="<?php echo $_SESSION['token'];?>">
                                                        <input type="hidden" id="kcp_balance">
                                                    </a> 
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php include('include/update_last_api_request.php');?>
                                </div>
                            </div>
                            <div class="widget-box">
                                <?php
                                    $query =  "SELECT * FROM `tb_address` WHERE `f_token`='".$_SESSION['token']."'";
                                    $result = $conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $kcp_real_address = "0x".$row['f_kcpaddress'];
                                        }
                                    }
                                ?>
                                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                                    <h5>Receive Kingcash (KCP)</h5>
                                </div>
                                <div class="widget-content">
                                    Get address to deposit KingCash (KCP)<br>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deposit_kcp_from_eth" style="margin-top: 10px;">Deposit KCP from MyEtherWallet</button>
                                    <div id="deposit_kcp_from_eth" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">                                                
                                                <div class="modal-body">                                                    
                                                    <p style="text-align: center;"><input class="span10" type="text" value="<?php echo $kcp_real_address;?>" id="kcp_real_address_string" readonly="readonly" style="margin-bottom:0px;cursor: pointer;">
                                                    <input type="button" class="btn btn-primary" value="Copy" id="copy_kcp_real_address"></p>
                                                    <p style="text-align: center;"><img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?php echo $kcp_real_address;?>" width="250"></p>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deposit_kcp_from_kcp" style="margin-top: 10px;">Deposit KCP from KingCash Account</button>
                                    <div id="deposit_kcp_from_kcp" class="modal fade" role="dialog">
                                        <?php
                                            $query =  "SELECT * FROM `tb_kcpwallet` WHERE `f_token`='".$_SESSION['token']."'";
                                            $result = $conn->query($query);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $kcp_local_address = $row['f_address'];
                                                }
                                            }
                                        ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">                                                
                                                <div class="modal-body">                                                    
                                                    <p style="text-align: center;"><input class="span10" type="text" value="<?php echo $kcp_local_address;?>" id="kcp_local_address_string" readonly="readonly" style="margin-bottom:0px;cursor: pointer;">
                                                    <input type="button" class="btn btn-primary" value="Copy" id="copy_kcp_local_address"></p>
                                                    <p style="text-align: center;"><img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?php echo $kcp_local_address;?>" width="250"></p>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                                    <h5>Send Kingcash (KCP)</h5>
                                </div>
                                <div class="widget-content">
                                    <form action="include/kcp_withdraw" method="POST">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
                                        <input type="hidden" name="balance" id="form_kcp_balance"/>
                                        To Address
                                        <input type="text" class="span12" name="to_address" required="required" />
                                        Amount in Kingcash <a href="#" id="select_all_kcp">(All : 0.00000000 KCP)</a>
                                        <input type="text" class="span12" name="amount" id="kcp_amount" required="required"/>
                                        <label class="control-label">Fee : 0.00 KCP</label><br>
                                        Password
                                        <input type="password" class="span12" name="password" required="required"/>                                        
                                        <button type="submit" class="btn btn-primary">Withdraw from KCP wallet</button>
                                        <?php
                                            if(isset($_GET['res'])){
                                                $error = $_GET['res'];
                                                switch ($error) {
                                                    case 'kcp_balance':
                                                        $warning = "Withdraw amount is larger than balance";
                                                        echo '  <hr><div class="alert alert-danger">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'kcp_low':
                                                        $warning = "Withdraw amount must larger than 0";
                                                        echo '  <hr><div class="alert alert-danger">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'kcp_password':
                                                        $warning = "Input correct password";
                                                        echo '  <hr><div class="alert alert-danger">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'kcp_address':
                                                        $warning = "Invalid KCP address";
                                                        echo '  <hr><div class="alert alert-danger">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'kcp_db':
                                                        $warning = "Database connection error";
                                                        echo '  <hr><div class="alert alert-danger">
                                                            '.$warning.'
                                                        </div>';
                                                        break;
                                                    case 'kcp_success':
                                                        $warning = "KCP sent successfully";
                                                        echo '  <hr><div class="alert alert-success">
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
                <div class="row-fluid">  
                    <div class="span12">
                        <div class="widget-content">
                            <input type="hidden" id="btc_real_address" value="<?php echo $btc_real_address;?>">
                            <table class="table table-bordered table-striped" id="datatable_withdraw_btc">
                                <thead>
                                    <tr>
                                        <th>Requested At</th>
                                        <th>Address</th>
                                        <th>BTC</th>
                                        <th>Confirmed</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>      
        </div>
        <?php echo include('common/footer.php');?>
        <script type="text/javascript" src="js/wallet.js"></script>
    </body>
</html>