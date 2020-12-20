<?php
require_once('public_include.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
$now_menu_index = 3;
$func = $_GET['func'];
$now_menu = Func::GetMenuData(__FILE__);
$func_page = $now_menu['func_page'];
$func_title = $now_menu['menu_name'];
$arr_subject = array();
$strSQL = "SELECT * FROM apply_subject ORDER BY sort desc";        
$apply_subject = $db->Execute($strSQL);
foreach ($apply_subject as $value) {
	$arr_subject[$value['title']]=$value['title'];
}
$arr_isread = array('0'=>'未讀','1'=>'已讀','2'=>'已回覆');
$arr_isread1 = array('1'=>'已讀','2'=>'已回覆');
$arr_sex = array('0'=>'男','1'=>'女');
require($func_page.'_data.php');

switch($func){
	case "insert";
		$content_page = $func_page.'_i.php';
	break;
	case "update";
		$content_page = $func_page.'_u.php';
	break;
	case "delete";
		$content_page = $func_page.'_d.php';
	break;
	default:
		$content_page = $func_page.'_s.php';

}
require('template.php');
//print_r($_SESSION);
?>