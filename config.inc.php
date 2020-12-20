<?php
date_default_timezone_set("Asia/Taipei");

define('__DEBUG_MODE', true);

define('SESSION_NAME', 'mousecake');
define('SESSION_BACKEND', 'mousecake_backend');
//加密KEY不可修改，會讓所有加密資料無法解密
define('ENCRYPTION', 'H19ayGCkyDghZ0HpNMCeQ2trq8C@tyg#5AUc1CD6qKw');
define('URL', 'https://www.mousecake.com.tw/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'han_php');
define('DB_USER', 'han_php');
define('DB_PASS', 's1*P6OU4By');

//FB
define('FB_APPID', '1723364317779489');
define('FB_APPSECRET', '030e4b56bbea1204a7614268b2c152f1');
define('FB_VERSION', 'v3.0');

define('__SERVER_ROOT_DOC', dirname(__FILE__));
define('__FOOTER_COPYRIGHT', '<b>數位媒體設計</b>');

define('LIBS', __SERVER_ROOT_DOC . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR);

define('__WEB_ROOT_DOC', '');
define('__SERVER_IMAGES_FOLDER', __SERVER_ROOT_DOC . DIRECTORY_SEPARATOR . 'webimages');
define('__SERVER_IMAGES_NEW_FOLDER', __SERVER_ROOT_DOC . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'webimages');
define('__WEB_IMAGES_FOLDER', '../webimages');
define('__WEB_IMAGES_NEW_FOLDER', __WEB_ROOT_DOC . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'webimages');

define('__DATA_PER_PAGE', 20);
define('__FRONT_DATA_PER_PAGE', 6);
define('__FRONT_STORE_DATA_PER_PAGE', 10);

$array_img_ext = array('jpg', 'bmp', 'png', 'gif');

define('__SHAREMAN_WIDTH', 300);
define('__SHAREMAN_HEIGHT', 300);

define('__TRIP_WIDTH', 1024);
define('__TRIP_HEIGHT', 768);

// //綠界測試環境
// define('__CARD_MerchantID', '2000132');
// define('__CARD_HashKey', '5294y06JbISpM5x9');
// define('__CARD_HashIV', 'v77hoKGq4kWxNNIS');
// define('__CARD_URL', 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5');
// define('__CARD_CHECK_URL', 'https://payment-stage.ecpay.com.tw/Cashier/QueryTradeInfo/V5'); //更新訂單

//綠界正式環境
// define('__CARD_MerchantID','3078824');
// define('__CARD_HashKey','X96fSAbC4XA2HCF9');
// define('__CARD_HashIV','wp8NWK21Hg03pTfS');
// define('__CARD_URL','https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5');
// define('__CARD_CHECK_URL','https://payment-stage.ecpay.com.tw/Cashier/QueryTradeInfo/V5');//更新訂單

//reCAPTCHA
define('__reCAPTCHA_Site_key', '6LfvOjEUAAAAAGp0ZY__Dva7EyWA-dhQBnXaccIL');
define('__reCAPTCHA_Secret_key', '6LfvOjEUAAAAAP7c1ldMd8_b9CQ6sOlseWFLxfcG');

define('__MAIL_FROM', 'service@mousecake.com.tw');
define('__MAIL_SERVER', 'mail.mousecake.com.tw');
define('__MAIL_NAME', 'service@mousecake.com.tw');
define('__MAIL_PASSWORD', 'Mmbv50#9');
// define('__MAIL_PASSWORD','Gjw7i$63');
