<?php
require_once('public_include.php');
if(!Session::get('login_flag',SESSION_BACKEND)):
  if(isset($_POST['flag'])){
    $m_id = $_POST['m_id'];
    $m_pwd = md5($_POST['m_pwd']);
    $rs = $db->Execute("select * from member where m_id='$m_id' and m_pwd='$m_pwd'");
    if(!$rs){
        Func::msg_box('帳號密碼不對!');
        Func::go_to(-1);
        exit;
    }else{
        Session::set('login_flag',true,SESSION_BACKEND);
        Session::set('member_id',$rs[0]['id'],SESSION_BACKEND);
        // Session::set('module_id',$rs[0]['module_id'],SESSION_BACKEND);
        // $rs = $db->Execute("select * from modules where id='".Session::get('module_id',SESSION_BACKEND)."'");
        // Session::set('module_folder',$rs[0]['folder'],SESSION_BACKEND);
        Session::set('m_name',$rs[0]['m_name'],SESSION_BACKEND);
        Session::set('m_id',$rs[0]['m_id'],SESSION_BACKEND);
        // Session::set('port',$rs[0]['port'],SESSION_BACKEND);
        //print_r($_SESSION[SESSION_BACKEND]);

        //exit;
        //go_to($_SERVER['PHP_SELF']);
        Func::go_to($_SERVER['PHP_SELF']);
        exit;      
    }
  }
endif;
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>數位後台管理系統</title>
        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/sweetalert2/4.0.9/sweetalert2.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
        <link href="css/lib.css" rel="stylesheet" type="text/css">
        <link href="css/custome.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <link href="css/page.css" rel="stylesheet" type="text/css">
    </head>
    <body class="pages-login">
        <div class="login-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">
                    <!-- begin login -->
                    <div class="login">
                        <!-- begin brand -->
                        <div class="login-header">
                            <div class="brand">
                                <span class="logo"></span> 數位後台管理系統
                                <small>Asiaway admin system</small>
                            </div>
                        </div>
                        <!-- end brand -->
                        <div class="login-content">
                            <FORM METHOD="POST"><INPUT TYPE="hidden" name="flag" value="true">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="帳號" name='m_id' id='m_id' value="<?=$_POST['m_id']?>" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="密碼" name='m_pwd' id='m_pwd'>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember-me" value="remember-me" <?=$_COOKIE['remember-me'];?> 記住我的帳號密碼
                                    </label>
                                </div>
                                <div class="login-buttons">
                                    <button type="button" onclick="chkdata();" class="btn btn-block btn-lg btn-primary">登入</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end login -->
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--  sidebar -->
        <!-- wrapper -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.maskedinput.min.js"></script>
        <script src="https://cdn.jsdelivr.net/sweetalert2/4.0.9/sweetalert2.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/lib.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <SCRIPT LANGUAGE="JavaScript">
        <!--
            var f = document.forms[0];

            function chkdata() {
                f.submit();
            }

            function resetdata() {
                f.reset();
            }
            function aa() {
                //console.log($('#tt'));
                $('#tt').attr('src', 'serial.php?' + Math.random());
            }
        //-->
        </SCRIPT>
    </body>
</html>
