<?php
require_once('public_include.php');
	$admin_account = $_GET['id'];
	$strSQL = "SELECT * FROM member WHERE id='$admin_account'";
	$rs=$db->Execute($strSQL);

	if($db->Affected_Rows()<1){
        exit;
	}
	//查權限
	$strSQL ="SELECT * FROM acl_mapping WHERE admin_account_id='$admin_account'";
	$rs=$db->Execute($strSQL);
	unset($arr_xml);
	foreach ($rs as $value) {
		$arr_xml[$value['menu_detail_id']]=true;
	}
$strSQL = 'SELECT * FROM menu_detail WHERE up_id=0 AND (menu_name!="後台資訊頁") order by sort desc,id';
$rs = $db->Execute($strSQL);
unset($arr_menu);
$i  = 0;
foreach ($rs as $vvv) {
 $arr_menu[$i]['menu_name'] = htmlspecialchars($vvv['menu_name']);
  $arr_menu[$i]['id'] = $vvv['id'];
  $arr_menu[$i]['func_page'] = htmlspecialchars($vvv['func_page']);
  $arr_menu[$i]['is_blank'] = ($vvv['is_blank']);
  $strSQL = 'SELECT * FROM menu_detail WHERE up_id ='.$vvv['id'].' order by sort desc,id';
  $rs1  = $db->Execute($strSQL);
  $j=0;
  	if($vvv['func_page']=='#'){
  		$a .="\t". '<item text="'.stripInvalidXml($vvv['menu_name']).'" id="group_'.$vvv['id'].'" open="1" im0="icon_folder_closed.gif" im1="icon_folder_opened.gif" im2="folderClosed.gif">'."\n";
  	}else{
  		if($arr_xml[$vvv['id']]===true){
			$check_value='checked="1"';
		}else{
			$check_value='';
		}
		$a .="\t". '<item text="'.stripInvalidXml($vvv['menu_name']).'" id="'.$vvv['id'].'" open="1" im0="icon_folder_closed.gif" im1="icon_folder_opened.gif" im2="folderClosed.gif" '.$check_value.'>'."\n";
  	}
	
	  foreach ($rs1 as $vv) {
	    $arr_menu[$i]['sub_menu'][$j]['menu_name'] = htmlspecialchars($vv['menu_name']);
	    $arr_menu[$i]['sub_menu'][$j]['id'] = $vv['id'];
	    $arr_menu[$i]['sub_menu'][$j]['func_page'] = htmlspecialchars($vv['func_page']);
	    $arr_menu[$i]['sub_menu'][$j]['is_blank'] = ($vv['is_blank']);
	    $arr_menu[$i]['sub_menu_id'][]=$vv['id'];
	    $j++;
			if($arr_xml[$vv['id']]===true){
				$check_value='checked="1"';
			}else{
				$check_value='';
			}
			$name = stripInvalidXml($vv['menu_name']);
			$a .= "\t"."\t".'<item text="'.$name.'" id="'.$vv['id'].'" im0="book_titel.gif" im1="book.gif" im2="book_titel.gif" '.$check_value.'/>'."\n";
	  }
  $i++;
  $a .= "\t".'</item>'."\n";//end group
}
function stripInvalidXml($value)
{
    $ret = "";
    $current;
    if (empty($value)) 
    {
        return $ret;
    }

    $length = strlen($value);
    for ($i=0; $i < $length; $i++)
    {
        $current = ord($value{$i});
        if (($current == 0x9) ||
            ($current == 0xA) ||
            ($current == 0xD) ||
            (($current >= 0x20) && ($current <= 0xD7FF)) ||
            (($current >= 0xE000) && ($current <= 0xFFFD)) ||
            (($current >= 0x10000) && ($current <= 0x10FFFF)))
        {
            $ret .= chr($current);
        }
        else
        {
            $ret .= " ";
        }
    }
    return $ret;
}
	//MENU
	// $strSQL = "select * from  menu_group  order by group_order";
	// $rs_group = $db->Execute($strSQL);
	// while(!$rs_group->EOF){
		// $a .="\t". '<item text="'.$rs_group[0]['group_name'].'" id="group_'.$rs_group[0]['id'].'" open="1" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">'."\n";

		// $menu_group_id = $rs_group[0]['id'];
		// $strSQL = "select * from menu_detail where group_id='$menu_group_id' order by menu_detail_order";
		// $rs_detail=$db->Execute($strSQL);
		// if(!$rs_detail->EOF){
			// while(!$rs_detail->EOF){
				// if($arr_xml[$rs_detail[0]['id']]===true){
					// $check_value='checked="1"';
				// }else{
					// $check_value='';
				// }
				// $a .= "\t"."\t".'<item text="'.$rs_detail[0]['menu_detail_name'].'" id="'.$rs_detail[0]['id'].'" im0="book_titel.gif" im1="book.gif" im2="book_titel.gif" '.$check_value.'/>'."\n";
				// $rs_detail->MoveNext();
			// }
		// }
		// $a .= "\t".'</item>'."\n";//end group
		// $rs_group->MoveNext();
	// }
header('Content-Type: application/xml; charset=utf-8');
echo "<?xml version='1.0' encoding='utf-8'?>
<tree id=\"0\">
$a
</tree>";
