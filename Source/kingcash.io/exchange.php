    <?php require_once('common/header.php');?>
        <div id="sidebar">
            <img src="img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">KING CASH</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Exchange</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                <li><a href="wallet"><i <i class="icon icon-money"></i> <span>Wallet</span></a></li>
                <li><a href="lending"><i class="icon icon-inbox"></i> <span>Lending</span></a> </li>
                <li class="active"><a href="exchange"><i class="icon icon-signal"></i> <span>Exchange</span></a> </li>
                <li><a href="history"><i class="icon icon-sitemap"></i> <span>History</span></a></li>
                <li><a href="referrals"><i class="icon-group"></i> <span>Referrals</span></a></li>
                <li><a href="profile"><i class="icon-cogs"></i> <span>Profile</span></a></li>
                <li><a href="security"><i class="icon-lock"></i> <span>Security</span></a></li> 
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>      
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="exchange" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-signal"></i>Exchange</a></div>
            </div>
            <div class="container-fluid">            
                <div class="row-fluid">   
                    <div class="span12">
                        <input class="span6" type="text" value="https://kingcash.io/register?referrer=<?php echo $_SESSION['username'];?>" id="referrer_url" readonly="readonly" style="margin-bottom:0px;cursor: pointer;">       
                        <input type="button" class="btn btn-primary" value="Copy" id="copy-text"> 
                    </div>
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
                    <style>
                        #chartdiv {
                          width : 100%;
                          height  : 500px;
                        }                                 
                    </style>
                    <!-- <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
                    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
                    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
                    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
                    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
                    <div id="chartdiv"></div>    -->
                    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
                    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
                    <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
                    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
                    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
                    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
                    <div id="chartdiv"></div>          
                </div>
            </div>
            <div class="container-fluid">            
                <div class="row-fluid">   
                    <div class="span12">
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-refresh"></i> </span>
                                    <h5>SUMMARY</h5>
                                </div>
                                <div class="widget-content nopadding updates" style="height: 65px;">
                                    <div class="new-update clearfix">
                                        <div class="update-done" style="font-size: 16px;line-height: 49px;">LAST</div>
                                        <div class="update-date" style="width:auto;float: right;line-height: 15px;color:#666;"><span class="update-day" id="span_last_price"></span><br><span id="span_last_price_usd" style="text-align: right;"></span></div>
                                    </div>
                                </div>
                                <div class="widget-content nopadding updates" style="height: 65px;">
                                    <div class="new-update clearfix">
                                        <div class="update-done" style="font-size: 16px;line-height: 49px;">24H VOLUME</div>
                                        <div class="update-date" style="width:auto;float: right;line-height: 15px;color:#666;"><span class="update-day" id="span_24h_volume"></span><br><span id="span_24h_volume_usd" style="text-align: right;"></span></div>
                                    </div>
                                </div>
                                <div class="widget-content nopadding updates" style="height: 65px;">
                                    <div class="new-update clearfix">
                                        <div class="update-done" style="font-size: 16px;line-height: 49px;">24H HIGH</div>
                                        <div class="update-date" style="width:auto;float: right;line-height: 15px;color:#666;"><span class="update-day" id="span_24h_high_price"></span><br><span id="span_24h_high_price_usd" style="text-align: right;"></span></div>
                                    </div>
                                </div>
                                <div class="widget-content nopadding updates" style="height: 65px;">
                                    <div class="new-update clearfix">
                                        <div class="update-done" style="font-size: 16px;line-height: 49px;">24H LOW</div>
                                        <div class="update-date" style="width:auto;float: right;line-height: 15px;color:#666;"><span class="update-day" id="span_24h_low_price"></span><br><span id="span_24h_low_price_usd" style="text-align: right;"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="widget-box" id="create_order_part">
                                <div class="widget-title"> <span class="icon"> <i class="icon-refresh"></i> </span>
                                    <h5>CREATE AN ORDER (BTC/KCP)</h5>
                                </div>
                                <div class="widget-content nopadding updates">
                                    <ul class="nav nav-tabs" style="width: 100%;" id="create_order_tab">
                                        <li class="active" style="width: 50%;" id="buy_order_tab"><a data-toggle="pill" href="#buyorder">Buy Order</a></li>
                                        <li style="width: 50%;" id="sell_order_tab"><a data-toggle="pill" href="#sellorder">Sell Order</a></li>
                                    </ul>                                    
                                    <div class="tab-content">
                                        <div id="buyorder" class="tab-pane fade in active">
                                            <div class="form-horizontal">
                                                <div class="control-group">
                                                    <label class="control-label">Available balance :</label>
                                                    <div class="controls">
                                                        <input type="text"  class="span11" id="createorder_btc_balance" readonly="readonly" style="border-width: 0px;width: auto;" /> BTC (All)
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">KCP To Buy :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span11" id="createbuyorder_kcpvolume" class="span11"/>     
                                                    </div>
                                                </div> 
                                                <div class="control-group">
                                                    <label class="control-label">KCP Price (In BTC) :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span11" id="createbuyorder_btcpriceperkcp"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Total BTC Spent :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span11" id="createbuyorder_btcvolume"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"><span class="label">Fee <?php echo $system_values['exchange_buy_fee'];?>%</span></label>
                                                    <input type="hidden" id="exchange_buy_fee" value="<?php echo $system_values['exchange_buy_fee'];?>">
                                                    <div class="controls">
                                                        <input type="text" id="createbuyorder_google2facode" class="span11" placeholder="2FA code"/>      
                                                    </div>
                                                </div>                                
                                                <div class="form-actions" style="text-align: center;">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createbuyorder_modal">Create Order</button>
                                                </div>
                                            </div>
                                            <div id="createbuyorder_modal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Confirm</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span id="create_buyorder_confirm_message"></span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" id="createbuyorder_confirmed">Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sellorder" class="tab-pane fade">
                                            <div class="form-horizontal">
                                                <div class="control-group">
                                                    <label class="control-label">Available balance :</label>
                                                    <div class="controls">
                                                        <input type="text"  class="span11" id="createorder_kcp_balance" readonly="readonly" style="border-width: 0px;width: auto;" /> KCP (All)
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">KCP To Sell :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span11" id="createsellorder_kcpvolume"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">KCP Price (In BTC) :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span11" id="createsellorder_btcpriceperkcp"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Total BTC Received :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span11" id="createsellorder_btcvolume" class="span11"/>     
                                                    </div>
                                                </div>   
                                                <div class="control-group">
                                                    <label class="control-label"><span class="label">Fee <?php echo $system_values['exchange_sell_fee'];?>%</span></label>
                                                    <input type="hidden" id="exchange_sell_fee" value="<?php echo $system_values['exchange_sell_fee'];?>">
                                                    <div class="controls">
                                                        <input type="text" id="createsellorder_google2facode" class="span11" placeholder="2FA code"/>      
                                                    </div>
                                                </div>                                
                                                <div class="form-actions" style="text-align: center;">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createsellorder_modal">Create Order</button>
                                                </div>
                                            </div>
                                            <div id="createsellorder_modal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Confirm</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span id="create_sellorder_confirm_message"></span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" id="createsellorder_confirmed">Confirm</button>
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
                </div>
                <div class="row-fluid">   
                    <div class="span12">
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                    <h5>BUYING ORDERS</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <table class="table table-bordered table-striped" id="datatable_buying_orders">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>VOLUME (BTC)</th>
                                                <th>RATE (BTC)</th>
                                                <th>RATE (USD)</th>
                                                <th>VOLUME (KCP)</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                    <h5>SELLING ORDERS</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <table class="table table-bordered table-striped" id="datatable_selling_orders">
                                      <thead>
                                            <tr>
                                                <th></th>
                                                <th>VOLUME (BTC)</th>
                                                <th>RATE (BTC)</th>
                                                <th>RATE (USD)</th>
                                                <th>VOLUME (KCP)</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">   
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-refresh"></i> </span>
                                <h5>MY OPEN ORDER</h5>
                            </div>
                            <div class="widget-content nopadding updates">
                                <ul class="nav nav-tabs" style="width: 100%;">
                                    <li class="active" style="width: 50%;"><a data-toggle="pill" href="#my_buy_order">Buy Order</a></li>
                                    <li style="width: 50%;"><a data-toggle="pill" href="#my_sell_order">Sell Order</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="my_buy_order" class="tab-pane fade in active">
                                        <div class="widget-box" style="border-top: 0px solid;">
                                            <div class="widget-content nopadding" style="border-color: #fff;">
                                                <table class="table table-bordered table-striped" id="datatable_my_open_buying_orders" style="cursor: pointer;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:25%;">DATE</th>
                                                            <th style="width:15%;">TYPE</th>
                                                            <th style="width:15%;">PRICE</th>
                                                            <th style="width:15%;">UNITS TOTAL KCP</th>
                                                            <th style="width:15%;">ESTIMATED TOTAL BTC</th>
                                                            <th style="width:15%;">Cancel Order</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="my_sell_order" class="tab-pane fade">
                                        <div class="widget-box" style="border-top: 0px solid;">
                                            <div class="widget-content nopadding" style="border-color: #fff;">
                                                <table class="table table-bordered table-striped" id="datatable_my_open_selling_orders" style="width:100%;cursor: pointer;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:25%;">DATE</th>
                                                            <th style="width:15%;">TYPE</th>
                                                            <th style="width:15%;">PRICE</th>
                                                            <th style="width:15%;">UNITS TOTAL KCP</th>
                                                            <th style="width:15%;">ESTIMATED TOTAL BTC</th>
                                                            <th style="width:15%;">Cancel Order</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="cancel_my_order_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Confirm My Order</h4>
                                            </div>
                                            <div class="modal-body">
                                                <span id="my_order_type"></span> : <span id="my_order_kcpvolume"></span> KCP<br>
                                                <span id="my_order_btckcprate"></span>BTC Per KCP<br>
                                                Total : <span id="my_order_btcvolume"></span> BTC
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="my_order_cancel">Cancel Order</button>
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
                                <h5>MARKET HISTORY</h5>
                            </div>
                            <div class="widget-content nopadding" style="margin-top: 30px;">
                                <table class="table table-bordered table-striped" id="datatable_market_history">
                                    <thead>
                                        <tr>
                                            <th width="10">BUY / SELL</th>
                                            <th width="30">DATE</th>
                                            <th width="15">TYPE</th>
                                            <th width="15">PRICE (BTC)</th>
                                            <th width="15">VOLUME (KCP)</th>
                                            <th width="15">TOTAL (BTC)</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>      
        </div>
        <?php include('common/footer.php');?>
        <script src="js/exchange.js"></script> 
    </body>
</html>