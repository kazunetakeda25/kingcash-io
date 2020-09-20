    <?php require_once('common/header.php');?>
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Lending</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li class="active"><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
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
                <div id="breadcrumb"> <a href="lending" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-inbox"></i>Lending</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">  
                    <div class="span12">
                        <input class="span6" type="text" value="https://kingcash.io/register?referrer=<?php echo $_SESSION['username'];?>" id="referrer_url" readonly="readonly" style="margin-bottom:0px;cursor: pointer;">       
                        <input type="button" class="btn btn-primary" value="Copy" id="copy-text"> 
                    </div>          
                    <div class="span12" style="margin-left: 0px;">
                        <div class="span4">
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
                                                    </a> 
                                                    <input type="hidden" id="btc_balance">
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php include('include/update_last_api_request.php');?>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
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
                                                    </a> 
                                                    <input type="hidden" id="kcp_balance">
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php include('include/update_last_api_request.php');?>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="widget-box">
                                <div class="widget-content nopadding">
                                    <?php include('include/get_last_api_request_and_delay.php');?>
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="KCP" src="img/usd.jpg"> </div>
                                            <div class="article-post">                                             
                                                <span class="user-info"> USD </span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="usd_balance_text">
                                                        0.00
                                                    </a> 
                                                    <input type="hidden" id="usd_balance">
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
                            <ul class="quick-actions">
                                <li class="bg_lo" style="width:100%;height: 75px;text-align: center;line-height: 30px;border-radius: 10px;"><a>Total Investment<br>$ <span id="token_total_investment">0.00</span></a></li>
                            </ul>
                        </div>
                        <div class="span4">
                            <ul class="quick-actions">
                                <li class="bg_ly" style="width:100%;height: 75px;text-align: center;line-height: 30px;border-radius: 10px;"><a>Active Investment<br>$ <span id="token_active_investment">0.00</span></a></li>
                            </ul>
                        </div>
                        <div class="span4">
                            <ul class="quick-actions">
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
                <div class="row-fluid">
                    <div class="span6">
                        <div class="widget-box" id="create_order_part">
                            <div class="widget-content nopadding updates">
                                <ul class="nav nav-tabs" style="width: 100%;">
                                    <li class="active" style="width: 50%;"><a data-toggle="pill" href="#invest_tab">INVEST</a></li>
                                    <li style="width: 50%;"><a data-toggle="pill" href="#reinvest_tab">Convert USD To KCP</a></li>
                                </ul>                                    
                                <div class="tab-content">
                                    <div id="invest_tab" class="tab-pane fade in active">
                                        <p style="text-align: center;background-color: #005580;color:#fff;height: 32px;line-height: 32px;margin-bottom: 10px;padding-left: 10px;font-weight: bold;">Invest KingCash (Minimum: 100 USD)</p>
                                        <div class="widget-box">
                                            <div class="widget-content">
                                                <div class="controls" style="background-color: #005580;color:#fff;height: 32px;line-height: 32px;margin-bottom: 10px;padding-left: 10px;">
                                                    Lending Rate : 1 KCP = <span id="invest_kcpusd_rate"></span>
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="USD" class="span2 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                    <input type="number" min="100" placeholder="Amount in dollar" class="span7 m-wrap" id="invest_usd_amount">
                                                    <input type="button" value=" << ALL ($ 0)" id="invest_usd_total_amount" class="span3 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="KCP" class="span2 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                    <input type="text" placeholder="Amount in KCP" class="span6 m-wrap" id="invest_kcp_amount">
                                                    <input type="button" value=" KCP 0.00000000" class="span4 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;" id="invest_kcp_total_amount">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="Pay from KCP wallet" class="span6 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;" id="pay_for_invest">
                                                    <input type="button" value="Close" class="span6 m-wrap" style="background-color: grey;color:#fff;border-width: 0px;" id="cancel_invest_settings">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="reinvest_tab" class="tab-pane fade">
                                        <p style="text-align: center;background-color: #005580;color:#fff;height: 32px;line-height: 32px;margin-bottom: 10px;padding-left: 10px;font-weight: bold;">Transfer USD to KCP</p>
                                        <div class="widget-box">
                                            <div class="widget-content">
                                                <div class="controls" style="background-color: #005580;color:#fff;height: 32px;line-height: 32px;margin-bottom: 10px;padding-left: 10px;">
                                                    Exchange rate : 1 KCP = <span id="reinvest_kcpusd_rate"></span>
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="USD" class="span2 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                    <input type="number" min="0" placeholder="Amount in dollar" class="span7 m-wrap" id="reinvest_usd_amount">
                                                    <input type="button" value=" << ALL ($ 0)" id="reinvest_usd_total_amount" class="span3 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="KCP" class="span2 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                    <input type="text" placeholder="Amount in KCP" class="span10 m-wrap" id="reinvest_kcp_amount">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="Convert" class="span6 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;" id="pay_for_reinvest">
                                                    <input type="button" value="Close" class="span6 m-wrap" style="background-color: grey;color:#fff;border-width: 0px;" id="cancel_reinvest_settings">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="widget-box" id="create_order_part">
                            <div class="widget-content nopadding updates">
                                <ul class="nav nav-tabs" style="width: 100%;">
                                    <li class="active" style="width: 50%;"><a data-toggle="pill" href="#earning_calc">EARNINGS CALCULATOR</a></li>
                                    <li style="width: 50%;"><a data-toggle="pill" href="#exchange_rate_calc">EXCHANGE RATE CALCULATOR</a></li>
                                </ul>                                    
                                <div class="tab-content">
                                    <div id="earning_calc" class="tab-pane fade in active">
                                        <div class="controls controls-row" style="margin-bottom: 10px;">
                                            <input type="button" value="Last 30 days" id="last_30_days" class="span4 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                            <input type="button" value="Last 6 month" id="last_6_months" class="span4 m-wrap" style="background-color: grey;color:#fff;border-width: 0px;">
                                            <input type="button" value="Last 7 days" id="last_7_days" class="span4 m-wrap" style="background-color: grey;color:#fff;border-width: 0px;">
                                        </div>
                                        <div class="widget-box">
                                            <div class="widget-content">
                                                <div class="controls controls-row">
                                                    <input type="button" value="Total:" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;text-align: right;">
                                                    <input type="number" class="span6 m-wrap" id="calc_total_usd" min="0">
                                                    <input type="button" value="$ (USD)" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;text-align: left;">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="Rate of Interest:" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;text-align: right;">
                                                    <input type="text" class="span6 m-wrap" id="calc_rate_of_interest" readonly="readonly">
                                                    <input type="button" value="% (AVG)" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;text-align: left;">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" value="Term Length:" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;text-align: right;">
                                                    <input type="number" class="span6 m-wrap" id="calc_term_length" min="0">
                                                    <input type="button" value="In days" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;text-align: left;">
                                                </div>
                                                <div class="controls controls-row">
                                                    <input type="button" class="span3 m-wrap" style="background-color: #fff;color:#666;border-width: 0px;">
                                                    <input type="button" value="CALCUALTE" id="calc_calculate" class="span6 m-wrap" style="background-color: #005580;color:#fff;border-width: 0px;">
                                                </div>
                                            </div>
                                        </div>
                                        <p style="text-align: left;background-color: #005580;color:#fff;line-height: 32px;margin-bottom: 15px;padding-left: 10px;">
                                            Your profit: $ <span id="calc_profit">0.00</span>
                                            <br>ROI: <span id="calc_profit_percent">0.00</span>%
                                            <br>Profit with principal: $<span id="calc_profit_with_principal">0.00</span>
                                        </p>
                                    </div>
                                    <div id="exchange_rate_calc" class="tab-pane fade">
                                        <div class="controls controls-row">
                                            <input type="button" class="span3 m-wrap" value="BTC:" style="background-color: #fff;color:#666;border-width: 0px;text-align: right;">
                                            <input type="text" class="span6 m-wrap" id="calc_btc_usd_kcp_btc">
                                        </div>
                                        <div class="controls controls-row">
                                            <input type="button" class="span3 m-wrap" value="USD:" style="background-color: #fff;color:#666;border-width: 0px;text-align: right;">
                                            <input type="text" class="span6 m-wrap" id="calc_btc_usd_kcp_usd">
                                        </div>
                                        <div class="controls controls-row">
                                            <input type="button" class="span3 m-wrap" value="KCP:" style="background-color: #fff;color:#666;border-width: 0px;text-align: right;">
                                            <input type="text" class="span6 m-wrap" id="calc_btc_usd_kcp_kcp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>LENDING</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped" id="datatable_investment">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>INVESTMENT($)</th>
                                            <th>INVESTMENT(KCP)</th>
                                            <th>DAYS</th>
                                            <th>TODAY EARNED($)</th>
                                            <th>TOTAL EARNED($)</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Investment Detail</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left !important;width: 30%;">LENDING AMOUNT</th>
                                            <th style="text-align: left !important;width: 40%;">INTEREST (ACCRUED DAILY)</th>
                                            <th style="text-align: left !important;width: 30%;">CAPITAL BACK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: left !important;">$100.00 - $1,000.00</td>
                                            <td style="text-align: left !important;">
                                                Volatility software interest<br>
                                                <span style="color:green;">(Up to 48% per Month)</span>
                                            </td>
                                            <td style="text-align: left !important;">After <b>239</b> Days</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left !important;">$1,010.00 - $5,000.00</td>
                                            <td style="text-align: left !important;">
                                                Volatility software interest<span style="color:red;"> + 0.15% Daily</span><br>
                                                <span style="color:green;">(Up to 48% per Month)</span>
                                            </td>
                                            <td style="text-align: left !important;">After <b>179</b> Days</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left !important;">$5,010.00 - $10,000.00</td>
                                            <td style="text-align: left !important;">
                                                Volatility software interest<span style="color:red;"> + 0.25% Daily</span><br>
                                                <span style="color:green;">(Up to 48% per Month)</span>
                                            </td>
                                            <td style="text-align: left !important;">After <b>120</b> Days</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left !important;">$10,010.00 - $100,000.00</td>
                                            <td style="text-align: left !important;">
                                                Volatility software interest<span style="color:red;"> + 0.30% Daily</span><br>
                                                <span style="color:green;">(Up to 48% per Month)</span>
                                            </td>
                                            <td style="text-align: left !important;">After <b>99</b> Days</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left !important;">$100,010.00 above</td>
                                            <td style="text-align: left !important;">
                                                Volatility software interest<span style="color:red;"> + 0.35% Daily</span><br>
                                                <span style="color:green;">(Up to 48% per Month)</span>
                                            </td>
                                            <td style="text-align: left !important;">After <b>60</b> Days</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
        <?php include('common/footer.php');?>
        <script src="js/lending.js"></script> 
    </body>
</html>