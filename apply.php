<?php
require 'public_include.php';
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if ($_POST['flag'] == 'true') {
    foreach ($_POST as $kk => $vv) {
        $$kk = trim($vv);
    }
    if ($email != '') {
        if (!Func::checkemail($email)) {
            Func::msg_box("email格式有誤！");
            Func::go_to(-1);
        }
    }
    if ($phone != '') {
        if (!Func::checktel($phone)) {
            Func::msg_box("聯絡電話格式有誤！");
            Func::go_to(-1);
        }
    }
    if ($budget_money != '') {
        if (!Func::checkisnumber($budget_money)) {
            Func::msg_box("金額只能是數字!");
            Func::go_to(-1);
        }
    }
    if ($budget_box != '') {
        if (!Func::checkisnumber($budget_box)) {
            Func::msg_box("盒數只能是數字!");
            Func::go_to(-1);
        }
    }
    if ($_FILES['baby_pic']['tmp_name']) {
        if ($_FILES['baby_pic']['size'] > 2097152) {
            Func::msg_box('圖檔大小太大！');
            Func::go_to(-1);
            exit;
        }
        $ext = strtolower(pathinfo($_FILES['baby_pic']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $array_img_ext) === false) {
            FuncSite::msg_box('圖片格式錯誤！');
            Func::go_to(-1);
            exit;
        }
        $baby_pic = time() . rand(100, 999) . '.' . $ext;
        $a = copy($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic);
        // if($ext=='png' || $ext=='gif'){
        //     Func::ImageResize_Transparent($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic);
        // }else{
        //     Func::ImageResize($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic);
        // }
    }
    if ($due_or_born == "預產期" || $due_or_born == 'due') {
        $due_date = $born_date;
    } else {
        $due_date = "已出生";
    }
    $address = $zipcode . $county . $district . $addr;
    $message = "姓名：" . Func::cleartag($name) . "<br/>聯絡電話：" . Func::cleartag($phone) . "<br/>宅配地址：" . Func::cleartag($address) . "<br/>預產日期：" . Func::cleartag($due_date) . "<br/>E-Mail：" . Func::cleartag($email) . "<br/>預算金額：" . Func::cleartag($budget_money) . "<br/>預算盒數：" . Func::cleartag($budget_box) . "<br/>付款方式：" . Func::cleartag($payment) . "<br/>寶寶照片：<img src= " . URL . "webimages/" . Func::cleartag($baby_pic) . " >" . "<br/>備註:" . Func::cleartag($note) . "<br/>";
    //
    $tel = Encryption::ZxingCrypt(trim($tel), 'ENCODE'); //加密
    $phone = Encryption::ZxingCrypt(trim($phone), 'ENCODE'); //加密
    $address = Encryption::ZxingCrypt(trim($address), 'ENCODE'); //加密
    $data = array(
        'create_date' => time(),
        'update_date' => time(),
        'name' => Func::cleartag($name),
        'phone' => Func::cleartag($phone),
        'address' => Func::cleartag($address),
        'due_date' => Func::cleartag($due_date),
        'email' => Func::cleartag($email),
        'budget_money' => Func::cleartag($budget_money),
        'budget_box' => Func::cleartag($budget_box),
        'payment' => Func::cleartag($payment),
        'baby_pic' => Func::cleartag($baby_pic),
        'note' => Func::cleartag($note),
        'isread' => 0,
    );
    $times = time();
    $db->insert('apply', $data);

    include "mail.php";
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
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        //Recipients
        $mail->setFrom(__MAIL_FROM, 'mousecake 杏屋乳酪蛋糕');
        $strSQL = "SELECT * FROM apply_mail";
        $apply_mail = $db->Execute($strSQL);
        foreach ($apply_mail as $value) {
            $mail->addAddress($value['title']);
        }
        // $mail->addBCC($value['title']);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'mousecake 杏屋乳酪蛋糕 - 彌月試吃申請';
        $mail->Body = $output;
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        $mail->send();
        Func::msg_box('謝謝您的來信，我們將會盡快回覆您！');
        Func::go_to('apply.php');
        exit;
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php';?>
</head>
<body class="page-apply" style="background-image: url(images/apply/apply_bg.jpg);">
	<?php include 'include/header.php';?>
	<div class="pgHero">
		<div class="pgHero__con">
			<div class="pgHero__intro">
				<img src="images/comm_dec_black.png" alt="" class="aboutDec01">
				<img src="images/apply/dec_apply.png" alt="" class="pgHero__decMain">
				<h2 class="pgHero__tit">
					<span class="tw">試吃申請</span>
					<span class="jp">食べよう</span>
				</h2>
				<p>杏屋特別禮遇辛苦又偉大的媽咪們，任何商品皆可8折帶回品嚐<br />請填寫完以下資訊後，會有專員再次電話聯繫確認哦！</p>
				<p class="point">為配合物流公告，宅配試吃限週二~週六到貨</p>
			</div>
		</div>
	</div>
	<div class="main apply">
		<div class="container applyForm">
			<!-- <div class="applyForm__form form"> -->
			<form class="applyForm__form form" METHOD="POST" enctype="multipart/form-data" id="form1" name="form1" >
				<INPUT TYPE="hidden" name="flag" value="true">
				<div class="shipOrderInfo__recive">
					<div class="shipOrderInfo__col">
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">姓名</div>
							<div class="shipOrderInfo__input">
								<input type="text" name="name" id="name" placeholder="請填入姓名" onkeyup="checkSymbol(this);">
							</div>
						</div>
						<div class="shipOrderInfo__item vat">
							<div class="shipOrderInfo__lable">宅配地址</div>
							<div class="shipOrderInfo__input">
								<div class="addGroup">
									<div id="twzipcode"></div>
									<input type="text" name="addr" id="addr" placeholder="請填入地址" onkeyup="checkSymbol(this);">
								</div>
							</div>
						</div>
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">E-mail</div>
							<div class="shipOrderInfo__input">
								<input type="text" name="email" id="email" placeholder="請填入電子信箱" onkeyup="checkSymbol(this);">
							</div>
						</div>
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">付款方式</div>
							<div class="shipOrderInfo__input">
								<select name="payment" id="payment">
									<option value="貨到付款">貨到付款</option>
									<option value="ATM繳費">ATM繳費</option>
									<option value="線上刷卡">線上刷卡</option>
									<!-- <option value="信用卡繳費">信用卡繳費</option> -->
								</select>
							</div>
						</div>
					</div>
					<div class="shipOrderInfo__col">
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">聯繫電話</div>
							<div class="shipOrderInfo__input">
								<input type="text" name="phone" id="phone" placeholder="手機或市話號碼*" onkeyup="checkSymbol(this);">
							</div>
						</div>
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">預產日期</div>
							<div class="shipOrderInfo__input">
								<select name="due_or_born" id="due_or_born" onchange="dueorborn();">
									<option value="due">預產期</option>
									<option value="born">已出生</option>
								</select>
								<input type="text" class="datepicker form-control" name="born_date" id="born_date" value="" placeholder="年/月/日" >
							</div>
						</div>
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">預算金額</div>
							<div class="shipOrderInfo__input">
								<input type="text" name="budget_money" id="budget_money" placeholder="必填" onkeyup="checkSymbol(this);">
							</div>
						</div>
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">預算盒數</div>
							<div class="shipOrderInfo__input">
								<input type="text" name="budget_box" id="budget_box" placeholder="必填" onkeyup="checkSymbol(this);">
							</div>
						</div>
						<div class="shipOrderInfo__item">
							<div class="shipOrderInfo__lable">媽咪手冊or出生證明</div>
							<div class="shipOrderInfo__input shipOrderInfo__input--file">
								<input type="file" name="baby_pic" id="upcover" style="display:none;"  onchange="uploadImg();"/>
								<label for="upcover" style="display:block;z-index:2;position:relative;">請上傳媽咪手冊封面* (最大解析度為:2560*1440) </label>
							</div>
						</div>
					</div>
				</div>
				<div class="shipOrderInfo__item vat">
					<div class="shipOrderInfo__lable">備註</div>
					<div class="shipOrderInfo__input shipOrderInfo__input--note">
						<textarea placeholder="備註" name="note" id="note" onkeyup="checkSymbol(this);"></textarea>
					</div>
				</div>
				<div class="applyForm__reCAPTCHA control__reCAPTCHA">
					<div id="recaptcha2"></div>
				</div>
				<div class="applyForm__control">
					<button type="button" onclick="chk();" class="applyForm__btn" title="確認送出">S E N D</button>
				</div>
			<!-- </div>			 -->
			</form>
			<img src="images/apply/dec_02.png" class="dec dec02">
		</div>
	</div>
	<?php include 'include/footer.php';?>
	<?php include 'include/f2e.php';?>
	<script>
		$('#upcover').change(function(event) {
			if ($(this).val()) {
				var a = $(this).val();
				var theSplit = a.split('\\');
				$(this).next().text(theSplit[theSplit.length-1])
			} else {
				$(this).next().text('請上傳媽咪手冊封面*');
			}
		});
	</script>
</body>
</html>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript" src="TWzipcode/jquery.twzipcode.js"></script>
<script type="text/javascript" src="TWzipcode/jquery.twzipcode.min.js"></script>

<script>
function uploadImg() {
    var reader = new FileReader();
    var img = new Image();
    var upload_file = $("#upcover")[0].files[0];
    reader.readAsDataURL(upload_file);

    reader.onload = function(e) {
        img.src = e.target.result;
    }

    img.onload = function() {
        if((this.width*this.height)>(2560*1440)){
            alert('上傳的圖片解析度超過限制大小!');
            location.reload();
            return false;
        }
    }

}

	$('#twzipcode').twzipcode({
	  'css': ['addGroup__sel', 'addGroup__sel', 'hide'],
      'countyName': 'county', // 預設值為 county
      'districtName': 'district', // 預設值為 district
      'zipcodeIntoDistrict':true,
      'readonly': true,
    });
	function dueorborn(){
		var due_or_born = $('select[name="due_or_born"]').val();
		if(due_or_born == 'due'){
			$('input[name="born_date"]').attr("type","text");
		}else if(due_or_born == 'born'){
			$('input[name="born_date"]').attr("type","hidden");
			$('input[name="born_date"]').attr("value"," ");
		}
	}
	function chk() {
    	if(document.getElementById("name").value==''){
    		alert('請輸入姓名！');
            return false;
    	}
		if($('select[name="county"]').val()==''){
    		alert('請選擇縣市！');
            return false;
		}
		if($('select[name="district"]').val()==''){
    		alert('請選擇鄉鎮市區！');
            return false;
		}
		if(document.getElementById("addr").value==''){
    		alert('請輸入地址！');
            return false;
    	}
    	if(document.getElementById("phone").value==''){
    		alert('請輸入電話！');
            return false;
		}
		if(document.getElementById("phone").value!=''){
    		if(!checkTel(document.getElementById("phone").value)){
                alert('電話格式錯誤，不需包含特殊符號(-)！');
                document.getElementById("phone").focus();
                return false;
            }
    	}
		if(document.getElementById("email").value==''){
    		alert('請輸入email！');
            return false;
    	}
		if(document.getElementById("payment").value==''){
    		alert('請選擇付款方式！');
            return false;
    	}
        if(document.getElementById("due_or_born").value==''){
    		alert('請選擇預產日期！');
            return false;
    	}
		if(document.getElementById("due_or_born").value=='due'){
    		if(document.getElementById("born_date").value==''){
    		alert('請選擇預產日期！');
            return false;
    	}
    	}
        if(document.getElementById("budget_money").value==''){
    		alert('請輸入預算金額！');
            return false;
    	}
        if(document.getElementById("budget_box").value==''){
    		alert('請選擇預算盒數！');
            return false;
    	}
        if(document.getElementById("upcover").value==''){
    		alert('請上傳寶寶照片！');
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
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="js/datetimepicker/css/daterangepicker.css" />
<script src="js/datetimepicker/js/moment.min.js"></script>
<script src="js/datetimepicker/js/daterangepicker.js"></script>
<script type="text/javascript">
    $('.datepicker').daterangepicker({
        autoUpdateInput:false,
        showDropdowns: true,
        singleDatePicker: true,
        locale: {
        format: 'YYYY-MM-DD',
            "separator": " - ",
            "applyLabel": "允許",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "toLabel": "至",
            "customRangeLabel": "Custom",
            "weekLabel": "週",
            "daysOfWeek": [ "日","一","二","三","四","五","六" ],
            "monthNames": [ "一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月" ],
            "firstDay": 1
		},
		"minDate": "<?=date('Y/m/d')?>"
    });
</script>