<?php
require('public_include.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if ($_POST['flag'] == 'true'){
	foreach ($_POST as $kk => $vv){
        $$kk = trim($vv);
	}
	if($email !=''){
		if(!Func::checkemail($email)){
			Func::msg_box("email格式有誤！");
			Func::go_to(-1);
		}
	}
	if($tel !=''){
		if(!Func::checktel($tel)){
			Func::msg_box("聯絡電話格式有誤！");
			Func::go_to(-1);
		}
	}
	if($phone !=''){
		if(!Func::checkphone($phone)){
			Func::msg_box("手機格式有誤！");
			Func::go_to(-1);
		}
	}	
	// exit;
	$message = "姓名：" . Func::cleartag($name) . "<br/>電c話：" . Func::cleartag($tel) . "<br/>聯絡手機：" . Func::cleartag($phone) . "<br/>E-MAIL：" . Func::cleartag($email) . "<br/>問題與意見：" . Func::cleartag($content) . "<br/>";
    $tel = Encryption::ZxingCrypt(trim($tel),'ENCODE');//加密
    $phone = Encryption::ZxingCrypt(trim($phone),'ENCODE');//加密
    $data = array(
		'create_date'=>time(),
		'update_date'=>time(),
		'name'=>Func::cleartag($name),
		'tel'=>Func::cleartag($tel),
		'phone'=>Func::cleartag($phone),
		'email'=>Func::cleartag($email),
		'content'=>Func::cleartag($content),
		'isread'=>'0'
	);
    $db->insert('contact',$data);   	
	include("mail.php");
	$mail = new PHPMailer(true); 	
	// echo $output;
	// exit;
	try {
		//Server settings
		$mail->CharSet = 'utf-8'; 
		$mail->Encoding = 'base64'; 
		$mail->isSMTP();
		$mail->Host = __MAIL_SERVER;
		$mail->SMTPAuth = true;
		$mail->Username = __MAIL_NAME;
		$mail->Password = __MAIL_PASSWORD;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 25;
		//Recipients
		$mail->setFrom(__MAIL_FROM, '杏屋乳酪蛋糕');
		$strSQL = "SELECT * FROM contact_mail";        
		$contact_mail = $db->Execute($strSQL);
		foreach ($contact_mail as $value) {
			$mail->addAddress($value['title']);
		}
		// $mail->addBCC($value['title']);		
		//Content
		$mail->isHTML(true);
		$mail->Subject = '杏屋乳酪蛋糕 - 聯絡我們';
		$mail->Body = $output;
		$mail->SMTPOptions = array('ssl'=>array('verify_peer' => false, 'verify_peer_name'=>false, 'allow_self_signed'=>true));
		$mail->send();
		Func::msg_box('謝謝您的來信，我們將會盡快回覆您！');
		Func::go_to('contact.php');
		exit;
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php'; ?>
</head>
<body class="page-contact" style="background-image: url(images/contact/contact_bg.jpg);">
	<?php include 'include/header.php'; ?>
	<div class="pgHero">
		<div class="pgHero__con">
			<div class="pgHero__intro">
				<img src="images/comm_dec_black.png" alt="" class="aboutDec01">
				<img src="images/contact/dec_contact.png" alt="" class="pgHero__decMain">
				<h2 class="pgHero__tit">
					<span class="tw">聯絡我們</span>
					<span class="jp">お問い合わせ</span>
				</h2>
				<p>三五好友相聚一起，趁貓咪午睡的時候，來杏屋找乳酪！<br />如果您有任何問題，歡迎與我們聯繫！</p>
			</div>
		</div>
	</div>
	<div class="main contact">
		<!-- <div class="container contactForm form"> -->
		<form class="container contactForm form" METHOD="POST" id="form1" name="form1"><INPUT TYPE="hidden" name="flag" value="true">
			<div class="form__row form__row--2col">
				<div class="form__col">
					<div class="inputG">
						<div class="inputG__lable">姓名 <span>*</span></div>
						<div class="inputG__input"> 
							<input type="text" name="name" id="name" placeholder="請填入姓名" onkeyup="checkSymbol(this);">
						</div>
					</div>
				</div>
				<div class="form__col">
					<div class="inputG">
						<div class="inputG__lable">電子信箱 <span>*</span></div>
						<div class="inputG__input"> 
							<input type="text" name="email" id="email" placeholder="請填入電子信箱" onkeyup="checkSymbol(this);">
						</div>
					</div>
				</div>
			</div>
			<div class="form__row form__row--2col">
				<div class="form__col">
					<div class="inputG">
						<div class="inputG__lable">聯絡電話 <span>*</span></div>
						<div class="inputG__input"> 
							<input type="text" name="tel" id="tel" placeholder="請填入電話，需填入區碼" onkeyup="checkSymbol(this);">
						</div>
					</div>
				</div>
				<div class="form__col">
					<div class="inputG">
						<div class="inputG__lable">行動電話 <span>*</span></div>
						<div class="inputG__input"> 
							<input type="text" name="phone" id="phone" placeholder="請填入聯絡手機號碼" onkeyup="checkSymbol(this);">
						</div>
					</div>
				</div>
			</div>
			<div class="form__row">
				<div class="form__col">
					<div class="inputG inputG--block">
						<div class="inputG__lable">內容 <span>*</span></div>
						<div class="inputG__input"> 
							<textarea placeholder="請填入您的問題或意見" name="content" id="content" onkeyup="checkSymbol(this);" ></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="form__control control">
				<div class="control__reCAPTCHA">
					<div id="recaptcha3"></div>
				</div>
				<div class="control__btnGroup">
					<button type="button" onclick="res();" class="btn btn--cancel" title="取消重填">R E S E T</button>
					<button type="button" onclick="chk();" class="btn btn--submit" title="確認送出">S E N D</button>
				</div>
			</div>
			<img src="images/contact/dec_02.png" class="dec dec02">
			<img src="images/contact/dec_03.png" class="dec dec03">
		</form>
		<!-- </div> -->
	</div>
	<?php include 'include/footer.php'; ?>
	<?php include 'include/f2e.php'; ?>
	<script>
		$('.contactForm input, .contactForm textarea').focus(function(event) {
			$(this).parent().parent('.inputG').addClass('is-focus');
		}).blur(function(event) {
			$(this).parent().parent('.inputG').removeClass('is-focus');
		});
	</script>
</body>
</html>
<script>
	function chk() {
    	if(document.getElementById("name").value==''){
    		alert('請輸入姓名！');
            return false;
    	}
    	if(document.getElementById("tel").value==''){
    		alert('請輸入電話！');
            return false;
		}
		if(document.getElementById("tel").value!=''){
    		if(!checkTel(document.getElementById("tel").value)){
                alert('電話格式錯誤，不需包含特殊符號(-)！');
                document.getElementById("tel").focus();
                return false;
            }
    	}
    	if(document.getElementById("phone").value==''){
    		alert('請輸入聯絡手機！');
            return false;
		}
		if(document.getElementById("phone").value!=''){
            if(!checkPhone(document.getElementById("phone").value)){
            alert('聯絡手機格式錯誤，不需包含特殊符號(-)！');
                document.getElementById("phone").focus();
            return false;
            }
    	}
    	if(document.getElementById("email").value==''){
    		alert('請輸入E-MAIL！');
            return false;
    	} 
    	if(!checkMail(document.getElementById("email").value)){
	        alert('E-MAIL格式錯誤！');
	        document.getElementById("email").focus();
	        return false;
	    }
        if(document.getElementById("content").value==''){
    		alert('請輸入問題與意見！');
            return false;
    	}
		 $.ajax({
          type: "POST",
          url: "check_reCAPTCHA.php",
          data: $("#form1").serialize(), // serializes the form's elements.
          success: function (data) {
            // console.log(data);
            if(data==0){
              alert('驗證失敗！');
              return false;
            }else if(data==1){
				document.getElementById('form1').submit();
            }
      }, beforeSend: function () {
      }, complete: function () {
      }})
    }
	function res() {
		document.getElementById('form1').reset();
	}
</script>