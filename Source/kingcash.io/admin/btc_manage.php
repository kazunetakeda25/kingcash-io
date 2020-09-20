    <?php require_once('header.php');?>       
        <div id="sidebar">
            <img src="../img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">ADMIN PANEL</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Settings</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
                <li><a href="user_manage"><i class="icon icon-group"></i> <span>User Management</span></a></li>
                <li><a href="wallet_manage"><i class="icon icon-money"></i> <span>Wallet Management</span></a></li>
                <li class="active"><a href="btc_manage"><i class="fa icon-bold"></i> <span>BTC Management</span></a></li>
                <li><a href="lend_manage"><i class="icon icon-strikethrough"></i> <span>Lending Management</span></a></li>
                <li><a href="settings"><i class="icon icon-cogs"></i> <span>Settings</span></a></li>
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>  
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="profile" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-bold"></i>BTC Management</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span4">
                            <div class="widget-box">
                                <div class="widget-content nopadding">
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="../img/btc.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info" id="btcusd_balance">BTC Of All Users</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="total_user_balance">
                                                        0.00000000
                                                    </a> 
                                                </p>
                                            </div>
                                        </li>
                                    </ul>        
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="widget-box">
                                <div class="widget-content nopadding">
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="../img/btc.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info" id="btcusd_balance">BTC Of Main address</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="main_address_balance">
                                                        0.00000000
                                                    </a> 
                                                </p>
                                            </div>
                                        </li>
                                    </ul>        
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="widget-box">
                                <div class="widget-content nopadding">
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="../img/btc.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info" id="btcusd_balance">BTC Of Withdraw Request</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="withdraw_balance">
                                                        0.00000000
                                                    </a> 
                                                </p>
                                            </div>
                                        </li>
                                    </ul>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box" style="border-top: 0px solid;">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>BTC List</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped" id="datatable_btc_balance_list" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Token</th>
                                            <th>Address</th>
                                            <th>BTC Balance</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="send_btc_to_main_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Send BTC To Main</h4>
                                            </div>
                                            <div class="modal-body">
                                                <span id="send_btc_to_main_modal_text">Send BTC To Main Address</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" id="send_btc_to_main">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box" style="border-top: 0px solid;">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Withdraw List</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped" id="datatable_btc_withdraw_list" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Token</th>
                                            <th>BTC Balance</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="send_btc_to_user_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Send BTC To User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <span id="send_btc_to_user_modal_text">Send BTC To User Address</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" id="send_btc_to_user">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>     
                </div>  
            </div>     
        </div>
        <?php include('footer.php');?>
        <script type="text/javascript" src="js/btc_manage.js"></script>
    </body>
</html>