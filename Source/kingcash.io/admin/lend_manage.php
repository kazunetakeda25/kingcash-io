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
                <li class="active"><a href="lend_manage"><i class="icon icon-strikethrough"></i> <span>Lending Management</span></a></li>
                <li><a href="settings"><i class="icon icon-cogs"></i> <span>Settings</span></a></li>
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>  
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="profile" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-strikethrough"></i>Lending Management</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span4">
                            <div class="widget-box">
                                <div class="widget-content nopadding">
                                    <ul class="recent-posts">
                                        <li>
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="../img/kcp.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info">Total KCP In Lending</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="total_kcp_in_lending">
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
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="../img/usd.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info">Total USD In Lending</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="total_usd_in_lending">
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
                                            <div class="user-thumb"> <img width="40" height="40" alt="BTC" src="../img/usd.jpg"> </div>
                                            <div class="article-post">                                              
                                                <span class="user-info">Total USD Earned From Lend</span>
                                                <p>
                                                    <a href="#" style="font-size: 24px;" id="total_usd_earned_from_lend">
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
                                <h5>User List</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped" id="datatable_lend_list" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Token</th>
                                            <th>KCP Amount</th>
                                            <th>USD Amount</th>
                                            <th>USD Earned</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div> 
                    </div>        
                </div>  
            </div>      
        </div>
        <?php include('footer.php');?>
        <script type="text/javascript" src="js/lend_manage.js"></script>
    </body>
</html>

