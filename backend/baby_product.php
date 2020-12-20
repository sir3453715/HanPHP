<?php
require_once('public_include.php');

// error_reporting(-1);
// ini_set('display_errors', 'On');
$now_menu_index = 3;
$func = $_GET['func'];
$now_menu = Func::GetMenuData(__FILE__);
$func_page = $now_menu['func_page'];
$func_title = $now_menu['menu_name'];
$arr_ison = array('1'=>'啟用','0'=>'不啟用');
$arr_isindex = array('1'=>'顯示','0'=>'不顯示');
$arr_ishot = array('1'=>'是','0'=>'否');
$arr_isevent = array('1'=>'是','0'=>'否');
$status = $_GET['status'];
$class_id = $_GET['class_id'];
$id = $_GET['id'];
$keyword = $_GET['keyword'];
$output = $_GET['output'];
$arg = array('class_id' => $class_id,'id'=>$id,'keyword'=>$keyword,'status'=>$status,'output'=>$output);
if(is_array($arg)){
	foreach ($arg as $kk => $vv) {
		if($vv!='' && $kk!='id'):
			$tmp .= "{$kk}={$vv}&";
		endif;
	}
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
	case "copy";
		$content_page = $func_page.'_i.php';
	break;
	case "category";
		require_once('list_category.php');
	break;	

	case "category1";
		require_once('list_insert_price_category.php');
	break;	
	default:
		$content_page = $func_page.'_s.php';

}
require('template.php');
//print_r($_SESSION);
?>