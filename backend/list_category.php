<?php
$templet_id = $_GET['templet_id'];

if($templet_id!=''){
	$strSQL ="SELECT * FROM list_class_detail WHERE templet_id=$templet_id";
	$rs = $db->Execute($strSQL);
	unset($arr_xml);
	foreach ($rs as $value) {
		$arr_xml[$value['class_id']]=true;
	}
}

$strSQL = 'SELECT * FROM product_class ORDER BY sort desc';
$rs = $db->Execute($strSQL);
$i  = 0;
foreach ($rs as $vvv) {
//   $strSQL = 'SELECT * FROM product_class WHERE up_id ='.$vvv['id'].' order by sort desc';
//   $rs1  = $db->Execute($strSQL);
//   $j=0;
	if($arr_xml[$vvv['id']]===true){
		$check_value='checked="1"';
	}else{
		$check_value='';
	}
	$a .="\t". '<item text="'.stripInvalidXml($vvv['title']).'" id="'.$vvv['id'].'" close="1" im0="icon_folder_closed.gif" im1="icon_folder_opened.gif" im2="folderClosed.gif" '.$check_value.'>'."\n";
	
//   foreach ($rs1 as $vvvv) {
//     $j++;
// 		if($arr_xml[$vvvv['id']]===true){
// 			$check_value='checked="1"';
// 		}else{
// 			$check_value='';
// 		}
// 		$name = stripInvalidXml($vvvv['title']);
// 		$a .= "\t"."\t".'<item text="'.$name.'" id="'.$vvvv['id'].'" im0="book_titel.gif" im1="book.gif" im2="book_titel.gif" '.$check_value.'/>'."\n";
//   }
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
// header('Content-Type:   text/xml');
echo "
<tree id=\"0\">
$a
</tree>";
exit;
?>
