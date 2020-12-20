<?php
require_once('public_include.php');

$now_menu_index = 1;
$func = $_GET['func'];
$now_menu = Func::GetMenuData(__FILE__);
$func_page = 'start';
$func_title = $now_menu['menu_name'];

require($func_page.'_data.php');
//print_r($arr_data);
switch($func){
	default:
	//print_r($arr_data);
		$content_page = $func_page.'_s.php';

}
require('template.php');
//print_r($_SESSION);
?>