<?php
require_once('public_include.php');
if(!Session::get('login_flag',SESSION_BACKEND)):
  if(isset($_POST['flag'])){
    $m_id = $_POST['m_id'];
    $m_pwd = $_POST['m_pwd'];
    // echo Password::verify($m_pwd);
    // exit;
    $strSQL="select id,m_name,m_pwd from member where m_id='$m_id' and status='1'";
    $rs = $db->Execute($strSQL);
    if(!Password::verify($m_pwd,$rs[0]['m_pwd'])){
        Func::msg_box('帳號或密碼錯誤!');
        Func::go_to(-1);
        exit;
    }else{
        if (Password::rehash($m_pwd)) {
            $m_pwd = Password::hash($m_pwd);
            $data = array('m_pwd'=>$m_pwd);
            $db->update('member',$data,"id = '".$rs[0]['id']."'");
        }
        Session::set('login_flag',true,SESSION_BACKEND);
        Session::set('member_id',$rs[0]['id'],SESSION_BACKEND);
        Session::set('member_name',$rs[0]['m_name'],SESSION_BACKEND);
        $client_ip = Func::get_client_ip();
        $update_time = date('Y-m-d H:i:s',time());
        $strSQL = "INSERT INTO `desktop_list` (`client_ip`, `update_time`, `member_id`, `member_name`) VALUES ('$client_ip', '$update_time', '".$rs[0]['id']."', '".$rs[0]['m_name']."');";
        $db->Execute($strSQL);
        //清除一天前未結帳購物車暫存資料
        $time = time()-86400;
        $strSQL="SELECT * FROM tmp_orders WHERE isset='0' AND addtime<".$time;
        $tmp_orders = $db->Execute($strSQL);
        foreach ($tmp_orders as $value) {
            // 清除不要的彌月小卡資料
            $strSQL="SELECT * FROM baby_card WHERE isset='0' AND seccode = '".$value['seccode']."'";
            $baby_card = $db->Execute($strSQL);
            foreach ($baby_card as $value) {
                // @unlink("../webimages/".$value['baby_pic']);
                @unlink(__SERVER_IMAGES_FOLDER.$value['baby_pic']);
                $db->delete ('baby_card',"id='".$value['id']."' ");
            }
            $db->delete_all('tmp_orders_item',"order_sn='".$value['sn']."'");
            $db->delete('tmp_orders',"sn='".$value['sn']."'");
        }    
          
        
        //取消超過15天的訂單
        $strSQL = "SELECT * FROM web_setting WHERE id='1'";
        $web_setting = $db->Execute($strSQL);
        $strSQL="SELECT * FROM orders WHERE UNIX_TIMESTAMP(NOW()) - addtime > 1296000 AND pay_state='0' AND isset='1'";//超過15天
        $orders = $db->Execute($strSQL);
        foreach ($orders as $value) {
            //訂單取消
            $data = array('state'=>5,'isset'=>0);
            $a = $db->update('orders',$data,"sn = '".$value['sn']."'");
             
            ?>
            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
                ga('create', 'UA-111731983-1', 'auto');
                ga('set', 'currencyCode', 'TWD');
                ga('set', '&uid', '<?=$value['cust_id']?>');
                ga('require', 'ec');
                ga('ec:setAction', 'refund', {
                    'id': '<?=$value['seccode']?>'
                });
                ga('send', 'pageview'); 
            </script>
        <?php
        }
        //超過繳費期限就取消
        $strSQL="SELECT * FROM orders WHERE UNIX_TIMESTAMP(NOW()) > ExpireDate AND pay_state='0' AND isset='1'";
        $orders = $db->Execute($strSQL);
        foreach ($orders as $value) {
            //訂單取消
            $data = array('state'=>5,'isset'=>0);
            $a = $db->update('orders',$data,"sn = '".$value['sn']."'");
             
        ?>
            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
                ga('create', 'UA-111731983-1', 'auto');
                ga('set', 'currencyCode', 'TWD');
                ga('set', '&uid', '<?=$value['cust_id']?>');
                ga('require', 'ec');
                ga('ec:setAction', 'refund', {
                    'id': '<?=$value['seccode']?>'
                });
                ga('send', 'pageview'); 
            </script>
            <?php
        }
       
        Func::go_to('start.php');
        // Func::go_to($_SERVER['PHP_SELF']);
        exit;      
    }
  }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
        <title>亞數位後台管理系統</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <style>
            .login-bg {
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                z-index: -1;
                background: url(images/bg/002.jpg) center center no-repeat;
                background-size: cover;
                /* -webkit-filter: blur(5px); */
                /* filter: blur(5px); */
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
        <!--[if lt IE 9]>
        <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <!-- Main wrapper  -->
        <div id="main-wrapper">
            <div class="unix-login login-bg">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="login-content card">
                                <div class="login-form">
                                    <h4>亞數位後台管理系統</h4>
                                    <form id='login' action='' method='post' accept-charset='UTF-8'><INPUT TYPE="hidden" name="flag" value="true">
                                        <div class="form-group">
                                            <label>帳號</label>
                                            <input type="text" class="form-control" name='m_id' id='m_id' value="<?=$_POST['m_id']?>" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>密碼</label>
                                            <input type="password" class="form-control" name='m_pwd' id='m_pwd' required autofocus>
                                        </div>
                                        <!-- <div class="checkbox">
                                            <label>
                                                    <input type="checkbox"> Remember Me
                                                </label>
                                            <label class="pull-right">
                                                    <a href="#">Forgotten Password?</a>
                                                </label>

                                        </div> -->
                                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">登入</button>
                                        <!-- <div class="register-link m-t-15 text-center">
                                            <p>Don't have account ? <a href="#"> Sign Up Here</a></p>
                                        </div> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Wrapper -->
        <!-- All Jquery -->
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="js/lib/bootstrap/js/popper.min.js"></script>
        <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="js/jquery.slimscroll.js"></script>
        <!--Menu sidebar -->
        <script src="js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <!--Custom JavaScript -->
        <script src="js/custom.min.js"></script>

    </body>
    <script>
        document.onkeydown = function(e) {
            var ev = document.all ? window.event : e;
            if(ev.keyCode == 13){
                // 如果鍵盤按下的是 Enter 的動作 
                $("#login").submit();
            }
        }
    </script>
</html>
<?php

exit;
else:
  //echo 'config/'.Session::get('module_folder',SESSION_BACKEND).'.config.php';
//exit;
  // require('config/'.Session::get('module_folder',SESSION_BACKEND).'.config.php');
endif;
?>