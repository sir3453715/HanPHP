<?php
$id = trim($_GET['id']);
$strSQL = "SELECT * FROM member WHERE id='$id'";
$rs=$db->Execute($strSQL);
if($db->Affected_Rows()<1){
    FuncSite::msg_box_error('查無此帳號');
    Func::go_to(-1);
    exit;
}
$strSQL = "delete from acl_mapping  where admin_account_id='$id'";
$db->Execute($strSQL);
foreach(explode(',',trim($_POST['total_id'])) as $vv){
	// echo $vv."<br>";
	if(preg_match('/^([0-9]+)$/',$vv)){
		// echo $vv."<br>";
		$strSQL = "insert into acl_mapping values(null,'$id','$vv');";
		$db->Execute($strSQL);
		$strSQL = "SELECT * FROM menu_detail WHERE id='$vv'";
		$rs=$db->Execute($strSQL);
		$strSQL = "SELECT * FROM acl_mapping WHERE admin_account_id='$id' AND menu_detail_id='".$rs[0]['up_id']."'";
		$rs1=$db->Execute($strSQL);
		if($rs1[0]['id']==null){
		$strSQL = "insert into acl_mapping values(null,'$id','".$rs[0]['up_id']."');";
		// echo $strSQL.'<br>';
		$db->Execute($strSQL);
		}
	}
}
// exit;
	 FuncSite::msg_box('修改成功！');
     Func::go_to("admin.php");
     // Func::go_to("admin.php?func=permissions&id=$id");
	//echo $strSQL;
	exit;
?>