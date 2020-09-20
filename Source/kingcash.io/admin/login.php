<!DOCTYPE html>
<html>
  <head>
    <title>KING CASH</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="../assets/css/matrix-style.css" />
    <link rel="stylesheet" href="../assets/css/matrix-media.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="../css/customize.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../assets/css/uniform.css" />
    <link rel="stylesheet" href="../assets/css/select2.css" /> 
    <link rel="shortcut icon" href="../img/favicon.ico">
  </head>
  <body style="background-color: #f0f8fb;color: #000;">
    <div id="content" style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 0px;">
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
            <div class="span9">
              <div class="login_image"></div>
            </div>
            <div class="span3">   
              <form action="include/login_validation" method="POST" class="span11" id="login_register_form">                
                <img src="../img/logo.png" style="width: 60%;margin-left: 20%;">
                <p style="text-align: center;color:#2b3036;font-size: 28px;line-height: 28px;"><b>ADMIN PANEL</b></p>
                <br>
                <?php
                  if(isset($_GET['res'])){
                    $error = $_GET['res'];
                    switch ($error) {
                      case 'info':
                        $warning = "Input correct information";
                        echo '  <div class="alert alert-danger">
                                  Oops! '.$warning.'
                                </div>';
                        break;
                    }
                  }
                ?>
                <br>
                <div class="control-group">
                  <div class="controls">
                    <input type="text" class="span12" style="width: 100%;" placeholder="Username" name="username" required="required"/>
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                    <input type="password" class="span12" style="width: 100%;" placeholder="Password" name="password" required="required"/>
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                    <input type="submit" class="btn btn-primary" style="width: 100%;" value="Login"/>
                  </div>
                </div>
              </form>         
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script> 
    <script src="../assets/js/jquery.ui.custom.js"></script> 
    <script src="../assets/js/bootstrap.min.js"></script>
  </body>
</html>