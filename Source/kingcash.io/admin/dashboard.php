    <?php require_once('header.php');?>       
    <div id="sidebar">
      <img src="../img/logo.png" class="page_logo_part" style="margin-top: -30px;">
      <p style="text-align: center;font-size: 22px;color:#fff;margin-top:-50px;margin-bottom: 50px;">ADMIN PANEL</p>
      <a href="#" class="visible-phone"><i class="icon icon-home"></i>Dashboard</a>
      <ul>
        <li class="active"><a href="dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
        <li><a href="user_manage"><i class="icon icon-group"></i> <span>User Management</span></a></li>
        <li><a href="wallet_manage"><i class="icon icon-money"></i> <span>Wallet Management</span></a></li>
        <li><a href="btc_manage"><i class="icon icon-bold"></i> <span>BTC Management</span></a></li>
        <li><a href="lend_manage"><i class="icon icon-strikethrough"></i> <span>Lending Management</span></a></li>
        <li><a href="settings"><i class="icon icon-cogs"></i> <span>Settings</span></a></li>
        <li><a href="include/logout"><i class="icon-signout"></i> <span>Logout</span></a></li>  
      </ul>
    </div>
    <div id="content">
      <div id="content-header">
        <div id="breadcrumb"> <a href="profile" title="Go to Home" class="tip-bottom" style="font-size: 14px;"><i class="icon-home"></i>Dashboard</a></div>
      </div>
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
          </div>        
        </div>  
      </div>      
    </div>
    <?php include('footer.php');?>
  </body>
</html>