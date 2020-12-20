<?php
$admin_account_id = Session::get('member_id',SESSION_BACKEND);
//擁有權限
$strSQL = "SELECT menu_detail_id FROM acl_mapping WHERE admin_account_id='$admin_account_id'";
$acl_mapping=$db->Execute($strSQL);

//第一層
// $strSQL = 'select * from menu_detail where disyn=1 and ';
$strSQL = 'SELECT * FROM menu_detail where 1 ';
$k=0;
//加入擁有權限項目
if($acl_mapping[0]['menu_detail_id']!=''):
	foreach ($acl_mapping as $vv) {
		if($k==0){
			$strSQL .='AND (';
		}
		if($k>0){
			$strSQL .=' OR ';
		}
		$strSQL .=' id='.$vv['menu_detail_id'];
		$k++;
	}
	if($k>0){
		$strSQL .=') AND up_id=0 ';
	}
	$strSQL .= ' OR id=1 ORDER BY sort DESC,id';
else:
	$strSQL .= ' AND id=1 ORDER BY sort DESC,id';
endif;
// echo $strSQL;
// exit;
$rs = $db->Execute($strSQL);		
unset($arr_menu);
$i  = 0;

foreach ($rs as $vvv) {
	$arr_menu[$i]['menu_name'] = htmlspecialchars($vvv['menu_name']);
	$arr_menu[$i]['id'] = $vvv['id'];
	$arr_menu[$i]['func_page'] = htmlspecialchars($vvv['func_page']);
	$arr_menu[$i]['is_blank'] = ($vvv['is_blank']);
	$arr_menu[$i]['icon'] = ($vvv['icon']);
	// $acl_mapping->MoveFirst();
	
	$k=0;
	//第二層
	$strSQL = 'select * from menu_detail where 1 and ';
	// $strSQL = 'select * from menu_detail where disyn=1 and ';
	//加入擁有權限項目
	foreach ($acl_mapping as $vv) {
		if($k==0){$strSQL .='(';}
		if($k>0){$strSQL .=' or ';}
		$strSQL .=' id='.$vv['menu_detail_id'];
		$k++;
	}
	if($k>0){$strSQL .=') and ';}
	$strSQL .= ' up_id ='.$vvv['id'].' order by sort desc,id';
	$rs1  = $db->Execute($strSQL);
	$j=0;
	foreach ($rs1 as $kk) {
		$arr_menu[$i]['sub_menu'][$j]['menu_name'] = htmlspecialchars($kk['menu_name']);
			$arr_menu[$i]['sub_menu'][$j]['id'] = $kk['id'];
			$arr_menu[$i]['sub_menu'][$j]['func_page'] = htmlspecialchars($kk['func_page']);
			$arr_menu[$i]['sub_menu'][$j]['is_blank'] = ($kk['is_blank']);
			$arr_menu[$i]['sub_menu_id'][]=$kk['id'];
			$j++;
	}
	$i++;

}
//不需權限用
// $strSQL = 'select * from menu_detail where up_id="0" order by sort desc,id';
// $rs = $db->Execute($strSQL);
// unset($arr_menu);
// $arr_menu = $rs;

$nowurl = $_SERVER['PHP_SELF'];
$strary=explode("/",$nowurl);
$nownum = count($strary) - 1;
$nowurl = $strary[$nownum];

$strSQL = "select * from `menu_detail` where func_page = '".$nowurl."'";        
$arr_menudata = $db->Execute($strSQL);
$now_menu_id = $arr_menudata[0]['up_id'];

?>
<ul id="sidebarnav">
	<li class="nav-devider"></li>
	<?php
		Func::MakeMenu($arr_menu, $now_menu_id);
	?>
</ul>