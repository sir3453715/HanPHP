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
$arr_type = array('0'=>'現金折扣','1'=>'%數折扣');
$arr_ison = array('1'=>'啟用','0'=>'不啟用');
$strSQL = "SELECT id FROM menu_detail WHERE func_page='".$func_page.".php'";
$chk_menu_detail = $db->Execute($strSQL);
$strSQL = "SELECT menu_detail_id FROM acl_mapping WHERE admin_account_id='".Session::get('member_id',SESSION_BACKEND)."' AND menu_detail_id='".$chk_menu_detail[0]['id']."'";
$chk_acl_mapping = $db->Execute($strSQL);
if($chk_acl_mapping[0]['menu_detail_id']==''){
	FuncSite::msg_box_error('查無權限！');
	Func::go_to('start.php');
	exit;
}
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