<?
$strSQL = "SELECT * FROM web_setting WHERE 1";
$web_setting = $db->Execute($strSQL);
	/* <?=(($get_class=="1")? 'class="selected"':'');?> */
	 // 全站共用來判斷當前頁的變數 
	$actionpg = explode('/',$_SERVER['PHP_SELF']);
	$l_num = count($actionpg) - 1;
	$actionpg = $actionpg[$l_num];
	switch($actionpg){
        case "index.php":
            $get_class = "1";
        break;
        case "about.php":
            $get_class = "2";
        break;
        case "news.php":
        case "news_view.php":
            $get_class = "3";
        break;
        case "store.php":
            $get_class = "4";
        break;
        case "contact.php":
            $get_class = "5";
        break;
        default:
        	$get_class = "0";
    }
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="<?=$web_setting[0]['description']?>">
<meta name="keywords" content="<?=$web_setting[0]['keyword']?>">
<!-- <meta property="og:type"            content="website" /> 
<meta property="og:url"             content="" /> 
<meta property="og:title"           content="" /> 
<meta property="og:image"           content="" /> 
<meta property="og:description"    content="" /> -->
<!-- 1: android 2: apple 3: pc
<link  href="images/myicon.png">
<link rel="apple-touch-icon" href="images/myicon.png">
<link rel="shortcut icon" href="/favicon.ico"> -->
<title><?=$web_setting[0]['title']?></title>
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style>
  .sr .idxHero,
  .sr .intro,
  .sr .block {
    visibility: hidden;
  }z
</style>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lte IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- fb share use -->
<!-- <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.7&appId=";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> -->
<script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>
<script>
var recaptcha1;
var recaptcha2;
var recaptcha3;
var recaptcha4;
var recaptcha5;
var myCallBack = function() {
    if ( $('#recaptcha1').length ) {
        grecaptcha.render('recaptcha1', {'sitekey' : '<?=__reCAPTCHA_Site_key?>'
        });
    }
    if ( $('#recaptcha2').length ) {
        grecaptcha.render('recaptcha2', {'sitekey' : '<?=__reCAPTCHA_Site_key?>'
        });
    }
    if ( $('#recaptcha3').length ) {
        grecaptcha.render('recaptcha3', {'sitekey' : '<?=__reCAPTCHA_Site_key?>'
        });
    }
    if ( $('#recaptcha4').length ) {
        grecaptcha.render('recaptcha4', {'sitekey' : '<?=__reCAPTCHA_Site_key?>'
        });
    }
    if ( $('#recaptcha5').length ) {
        grecaptcha.render('recaptcha5', {'sitekey' : '<?=__reCAPTCHA_Site_key?>'
        });
    }
};
function checkpwd(repwd) {
    var pwd = /^(?=^.{6,12}$)((?=.*[0-9])(?=.*[a-z|A-Z]))^.*$/; 
    if(pwd.test(repwd)){
        return true;
    } else{ 
        return false; 
    }
}
function checkPhone(strPhone){ 
    var cellphone = /^09[0-9]{8}$/; 
    if(cellphone.test(strPhone)){
        return true;
    } else{ 
        return false; 
    } 
}
function checkTel(strTel){
    var tel = /^((0\d{1,2}\d{7,8}),?)*$/;
    if(tel.test(strTel)){
        return true;
    }else{
        return false;
    }
}
function checkMail(remail) {
    if (remail.search(/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/)!=-1) {
        return true;
    } else {
        return false; 
    }
}
function checkSymbol(obj) {
    var str = obj.value;
    newString = str.replace(/[/\'\"<>/]/g," ");
    obj.value = newString;
}
function checkTWid(id) {
    var city = new Array(
    1, 10, 19, 28, 37, 46, 55, 64, 39, 73, 82, 2, 11,
    20, 48, 29, 38, 47, 56, 65, 74, 83, 21, 3, 12, 30)
    id = id.toUpperCase();
    if (id.search(/^[A-Z](1|2)\d{8}$/i) == -1) {
        return false;
    } else {
        id = id.split('');//字串分割為陣列(for IE)
        var total = city[id[0].charCodeAt(0) - 65];
        for (var intTime = 1; intTime <= 8; intTime++) {
            total += eval(id[intTime]) * (9 - intTime);
        }
        total += eval(id[9]);//檢查碼(最後一碼)
        return ((total % 10 == 0));//檢查比對碼
    }
}
function checkCompanyNo(thisObj){
	comNo=thisObj;
	var res = new Array(8);	
	var key = "12121241";	
	var isModeTwo = false; //第七個數是否為七	
	var result = 0;
	if(comNo.length != 8){
	    return false ;
	}
	for(var i=0; i<8; i++){
	var tmp = comNo.charAt(i) * key.charAt(i);
	res[i] = Math.floor(tmp/10) + (tmp%10); //取出十位數和個位數相加
	if(i == 6 && comNo.charAt(i) == 7)
	    isModeTwo = true;
	}    
	for(var s=0; s<8; s++)
	result += res[s];
	if(isModeTwo){     
        if((result % 10) != 0 && ((result + 1) % 10) != 0){//如果第七位數為7
            return false ;
        }
	}	
	else	
	if((result % 10) != 0){	
	    return false ;	
	}   
	return true;
}
function ValidateNumber(e, pnumber){
    if (!/^\d+$/.test(pnumber)){
        e.value = /^\d+/.exec(e.value);
    }
    return false;
}
</script>