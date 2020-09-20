    <?php require_once('header.php');?>       
        <div id="sidebar">
            <img src="../img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">ADMIN PANEL</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Settings</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
                <li><a href="user_manage"><i class="icon icon-group"></i> <span>User Management</span></a></li>
                <li><a href="wallet_manage"><i class="icon icon-money"></i> <span>Wallet Management</span></a></li>
                <li><a href="btc_manage"><i class="icon icon-bold"></i> <span>BTC Management</span></a></li>
                <li><a href="lend_manage"><i class="icon icon-strikethrough"></i> <span>Lending Management</span></a></li>
                <li class="active"><a href="settings"><i class="icon icon-cogs"></i> <span>Settings</span></a></li>
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>  
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="profile" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-cogs"></i>Settings</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                    <h5>System Environment Value</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <form action="include/update_sys_env_val" method="POST" class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label">Admin Username</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="username" value="<?php echo $system_values['username'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Admin User Password</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="password" value="<?php echo $system_values['password'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">BlockCypher API Token</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="blockcypher_token" value="<?php echo $system_values['blockcypher_token'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">BTC withdraw Fee (BTC)</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="btc_withdraw_fee" value="<?php echo $system_values['btc_withdraw_fee'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Exchange BUY Fee (%)</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="exchange_buy_fee" value="<?php echo $system_values['exchange_buy_fee'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Exchange SELL Fee (%)</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="exchange_sell_fee" value="<?php echo $system_values['exchange_sell_fee'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Today's Earning Rate (%)</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="earning_rate" value="<?php echo $system_values['earning_rate'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Next Day's Earning Rate (%)</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="next_earning_rate" value="<?php echo $system_values['next_earning_rate'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <?php
                                                    if(isset($_GET['res'])){
                                                        echo '  <div class="alert alert-success">
                                                                    Successfuly changed
                                                                </div>';
                                                    }
                                                ?>
                                                <input type="submit" class="btn btn-primary" value="Save Cahnges"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                    <h5>System Environment Value</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <form action="include/change_main_address" method="get" class="form-horizontal">                                        
                                        <div class="control-group">
                                            <label class="control-label">Main BTC Address</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="main_btc_address" value="<?php echo $system_values['main_btc_address'];?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Main BTC Address Private</label>
                                            <div class="controls">
                                                <input type="text" class="span11" name="main_btc_address_privatekey" value="<?php echo $system_values['main_btc_address_privatekey'];?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="button" class="btn btn-primary" value="Create New Address" id="create_new_address"/>
                                            </div>
                                        </div>
                                        <div id="create_new_address_modal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">New Address Created</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <b>New address</b><br>
                                                        <input type="text" id="new_btc_address" class="span12"><br><br>
                                                        <b>Private Key</b><br>
                                                        <input type="text" id="new_btc_address_privatekey" class="span12"><br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary" id="change_new_address">Change</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>        
                </div>  
            </div>      
        </div>
        <?php include('footer.php');?>
        <script type="text/javascript" src="js/settings.js"></script>
    </body>
</html>