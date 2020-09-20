    <?php require_once('header.php');?>       
        <div id="sidebar">
            <img src="../img/logo.png" class="page_logo_part" style="margin-top: -30px;">
            <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">ADMIN PANEL</p>
            <a href="#" class="visible-phone"><i class="icon icon-home"></i>Settings</a>
            <ul>
                <li><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
                <li class="active"><a href="user_manage"><i class="icon icon-group"></i> <span>User Management</span></a></li>
                <li><a href="wallet_manage"><i class="icon icon-money"></i> <span>Wallet Management</span></a></li>
                <li><a href="btc_manage"><i class="icon icon-bold"></i> <span>BTC Management</span></a></li>
                <li><a href="lend_manage"><i class="icon icon-strikethrough"></i> <span>Lending Management</span></a></li>
                <li><a href="settings"><i class="icon icon-cogs"></i> <span>Settings</span></a></li>
                <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>  
            </ul>
        </div>
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="profile" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-group"></i>User Management</a></div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box" style="border-top: 0px solid;">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>User List</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped" id="datatable_users" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th>Token</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="user_detail_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">User Information</h4>
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
                            </div>
                        </div> 
                    </div>        
                </div>  
            </div>      
        </div>
        <?php include('footer.php');?>
        <script type="text/javascript" src="js/user_manage.js"></script>
    </body>
</html>

