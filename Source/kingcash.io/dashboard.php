    <?php require_once('common/header.php');?>
        <div id="sidebar"> 
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>  
            <a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
            <ul>            
                <li class="active"><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i <i class="icon icon-money"></i> <span>Wallet</span></a></li>
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
                <div id="breadcrumb"> <a href="dashboard" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-home"></i>Dashboard</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_lb" style="width:100%;"><a href="dashboard"> <i class="icon-dashboard"></i>Dashboard</a></li>
                            </ul>
                        </div>
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_lo" style="width:100%;"><a href="wallet"> <i class="icon-money"></i>Wallet</a></li>
                            </ul>
                        </div>
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_ls" style="width:100%;"><a href="lending"> <i class="icon-inbox"></i>Lending</a></li>
                            </ul>
                        </div>
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_lg" style="width:100%;"><a href="exchange"> <i class="icon-signal"></i>Exchange</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_ls" style="width:100%;"><a href="history"> <i class="icon-sitemap"></i>History</a></li>
                            </ul>
                        </div>
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_lb" style="width:100%;"><a href="referrals"> <i class="icon-group"></i>referrals</a></li>
                            </ul>
                        </div>
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_ly" style="width:100%;"><a href="profile"> <i class="icon-cogs"></i>Profile</a></li>
                            </ul>
                        </div>
                        <div class="span3">
                            <ul class="quick-actions">
                                <li class="bg_lo" style="width:100%;"><a href="security"> <i class="icon-lock"></i>Security</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr/>
                <!-- <div class="row-fluid">  
                    <input type="hidden" id="current_server_time" value="<?php $current_server_time = new DateTime();$current_server_time_int = $current_server_time->getTimestamp();echo $current_server_time_int;?>">
                    <input type="hidden" id="target_server_time" value="<?php $target_server_time = new DateTime("2017-12-20 15:00:00");$target_server_time_int = $target_server_time->getTimestamp();echo $target_server_time_int;?>">
                    <div class="span12">
                        <p style="text-align: center; font-size: 32px;line-height: 64px;" id="remain_datetime">
                            CROWD SALE STARTS IN 
                            <span id="remain_days" style="color:#da542e;"></span> Days <span id="remain_hours" style="color:#da542e;"></span> Hours <span id="remain_minutes" style="color:#da542e;"></span> Mins<br>
                        </p>
                    </div>
                    <div class="span12">
                        <p style="text-align: center; font-size: 16px;line-height: 32px;">
                            ETH CONTRIBUTION ADDRESS 
                        </p>
                    </div>
                    <div class="span12">
                        <div class="span3"></div>
                        <div class="span6">
                            <input class="span6" type="text" value="0x9D1099BeA74734dc911Fa77d4eFC2Fa7BEC48aE6" id="ETH_address" readonly="readonly" style="margin-bottom:0px;text-align: center;width:100%;cursor:pointer;">  
                        </div>
                        <div class="span3" style="margin-left:0px;">
                            <input type="button" class="btn btn-primary" value="Copy" id="ETH_address_copy" style="float:left"><br>
                        </div>
                    </div>
                    <div class="span12">
                        <p style="text-align:center;font-size: 16px;line-height: 48px;">
                            <a target="_blank" href="https://kingcash.io/support/eth.html" style="color:#27a9e3;">[CLICK HERE TO READ ETH CONTRIBUTION GUIDE]</a>
                        </p>
                    </div>
                    <div class="span12">
                        <p style="text-align: center;font-size: 32px;line-height: 48px;">TOTAL KCP TOKENS IN CROWD SALE</p>
                        <p style="text-align: center;font-size: 32px;line-height: 48px;color:#da542e;" id="total_tokens"></p>
                    </div>
                </div> -->
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
                    <div class="span12">
                        <div class="span4">
                            <ul class="quick-actions" id="none_a_hover_1">
                                <li class="bg_lo" style="width:100%;height: 75px;text-align: center;line-height: 30px;border-radius: 10px;"><a>Total Investment<br>$ <span id="token_total_investment">0.00</span></a></li>
                            </ul>
                        </div>
                        <div class="span4">
                            <ul class="quick-actions" id="none_a_hover_2">
                                <li class="bg_ly" style="width:100%;height: 75px;text-align: center;line-height: 30px;border-radius: 10px;"><a>Active Investment<br>$ <span id="token_active_investment">0.00</span></a></li>
                            </ul>
                        </div>
                        <div class="span4">
                            <ul class="quick-actions" id="none_a_hover_3">
                                <li class="bg_lb" style="width:100%;height: 75px;text-align: center;line-height: 30px;border-radius: 10px;"><a>Total Earned<br>$ <span id="token_total_earned">0.00</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <h3>LAST 5 DAY'S CREDITED INTEREST</h3>
                    <div class="span12" style="margin-left: 0px;">
                        <div class="span2" style="color:#fff;line-height: 32px;">
                            <div style="text-align: center;width:100%;background-color: #40a5e5;border-radius: 10px;">
                                <i class="fa fa-calendar"></i>  <span id="earning_board_date_0"><?php echo date('Y-m-d');?></span>
                                <br>
                                <h3><span id="earning_board_rate_0">0.00</span>%</h3>
                                <i class="fa fa-clock"></i> Pending
                                <br>
                                <p style="background-color: #196391;">$ <span id="earning_board_rate_earned_0">0.00</span></p>
                            </div>
                        </div>
                        <div class="span2" style="color:#fff;line-height: 32px;">
                            <div style="text-align: center;width:100%;background-color: #40a5e5;border-radius: 10px;">
                                <i class="fa fa-calendar"></i>  <span id="earning_board_date_1"><?php echo date('Y-m-d');?></span>
                                <br>
                                <h3 style="color:#76FF03;"><span id="earning_board_rate_1">0.00</span>%</h3>
                                <i class="fa fa-check"></i> Today
                                <br>
                                <p style="background-color: #196391;color:#76FF03;font-weight: bold;">$ <span id="earning_board_rate_earned_1">0.00</span></p>
                            </div>
                        </div>
                        <div class="span2" style="color:#fff;line-height: 32px;">
                            <div style="text-align: center;width:100%;background-color: #40a5e5;border-radius: 10px;">
                                <i class="fa fa-calendar"></i>  <span id="earning_board_date_2"><?php echo date('Y-m-d');?></span>
                                <br>
                                <h3 style="color:#76FF03;"><span id="earning_board_rate_2">0.00</span>%</h3>
                                <i class="fa fa-check"></i> Applied
                                <br>
                                <p style="background-color: #196391;color:#76FF03;font-weight: bold;">$ <span id="earning_board_rate_earned_2">0.00</span></p>
                            </div>
                        </div>
                        <div class="span2" style="color:#fff;line-height: 32px;">
                            <div style="text-align: center;width:100%;background-color: #40a5e5;border-radius: 10px;">
                                <i class="fa fa-calendar"></i>  <span id="earning_board_date_3"><?php echo date('Y-m-d');?></span>
                                <br>
                                <h3 style="color:#76FF03;"><span id="earning_board_rate_3">0.00</span>%</h3>
                                <i class="fa fa-check"></i> Applied
                                <br>
                                <p style="background-color: #196391;color:#76FF03;font-weight: bold;">$ <span id="earning_board_rate_earned_3">0.00</span></p>
                            </div>
                        </div>
                        <div class="span2" style="color:#fff;line-height: 32px;">
                            <div style="text-align: center;width:100%;background-color: #40a5e5;border-radius: 10px;">
                                <i class="fa fa-calendar"></i>  <span id="earning_board_date_4"><?php echo date('Y-m-d');?></span>
                                <br>
                                <h3 style="color:#76FF03;"><span id="earning_board_rate_4">0.00</span>%</h3>
                                <i class="fa fa-check"></i> Applied
                                <br>
                                <p style="background-color: #196391;color:#76FF03;font-weight: bold;">$ <span id="earning_board_rate_earned_4">0.00</span></p>
                            </div>
                        </div>
                        <div class="span2" style="color:#fff;line-height: 32px;">
                            <div style="text-align: center;width:100%;background-color: #40a5e5;border-radius: 10px;">
                                <i class="fa fa-calendar"></i>  <span id="earning_board_date_5"><?php echo date('Y-m-d');?></span>
                                <br>
                                <h3 style="color:#76FF03;"><span id="earning_board_rate_5">0.00</span>%</h3>
                                <i class="fa fa-check"></i> Applied
                                <br>
                                <p style="background-color: #196391;color:#76FF03;font-weight: bold;">$ <span id="earning_board_rate_earned_5">0.00</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row-fluid">
                    <style>
                        #chartdiv {
                          width : 100%;
                          height  : 500px;
                        }                                 
                    </style>
                    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
                    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
                    <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
                    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
                    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
                    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
                    <div id="chartdiv"></div>                                    
                    </div>                                                                   
                </div> -->
            </div>      
        </div>
        <?php include('common/footer.php');?>
        <script src="js/dashboard.js"></script> 
    </body>
</html>