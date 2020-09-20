    <?php require_once('common/header.php');?>
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>History</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
                <li><a href="exchange"><i class="icon icon-signal"></i> <span>Exchange</span></a> </li>
                <li class="active"><a href="history"><i class="icon icon-sitemap"></i> <span>History</span></a></li>
                <li><a href="referrals"><i class="icon-group"></i> <span>Referrals</span></a></li>
                <li><a href="profile"><i class="icon-cogs"></i> <span>Profile</span></a></li>
                <li><a href="security"><i class="icon-lock"></i> <span>Security</span></a></li>
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>      
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="transaction" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-sitemap"></i>History</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12" style="margin-left: 0px;">
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
                        </div>
                    </div> 
                </div>  
                <div class="row-fluid">
                    <div class="widget-box">
                        <div class="widget-content nopadding updates">
                            <ul class="nav nav-tabs" style="width: 100%;" id="create_order_tab">
                                <li class="active" style="width: 25%;"><a data-toggle="pill" href="#history_kcp">Kingcash</a></li>
                                <li style="width: 25%;"><a data-toggle="pill" href="#history_btc">Bitcoin</a></li>
                                <li style="width: 25%;"><a data-toggle="pill" href="#history_usd">Dollar</a></li>
                                <li style="width: 25%;"><a data-toggle="pill" href="#history_exchange">Exchange</a></li>
                            </ul>                                    
                            <div class="tab-content">
                                <div id="history_kcp" class="tab-pane fade in active">
                                    <table class="table table-bordered table-striped" id="datatable_history_kcp" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="30">DATE</th>
                                                <th width="15">Amount</th>
                                                <th width="15">Description</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="history_btc" class="tab-pane fade">
                                    <table class="table table-bordered table-striped" id="datatable_history_btc" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="30">DATE</th>
                                                <th width="15">Amount</th>
                                                <th width="15">Description</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="history_usd" class="tab-pane fade">
                                    <table class="table table-bordered table-striped" id="datatable_history_usd" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="30">DATE</th>
                                                <th width="15">Amount</th>
                                                <th width="15">Description</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="history_exchange" class="tab-pane fade">
                                    <table class="table table-bordered table-striped" id="datatable_history_exchange" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="30">DATE</th>
                                                <th width="15">Amount</th>
                                                <th width="15">Description</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
        <?php include('common/footer.php');?>
        <script type="text/javascript" src="js/history.js"></script>
    </body>
</html>