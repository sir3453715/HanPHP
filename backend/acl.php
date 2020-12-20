<?php
require_once('public_include.php');
$id = $_GET['id'];
if(isset($_GET['id'])){
	$strSQL = "SELECT * FROM member WHERE id='$id'";
	$rs=$db->Execute($strSQL);
	if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無此帳號');
            Func::go_to(-1);
            exit;
    }
	$admin_account = $id;
}
switch($_GET['func']){
	case "update";
		require_once('acl_u.php');
		break;
	case "xml":
		require_once('acl_xml.php');
		break;
	default:
		require_once('acl_s.php');
}

