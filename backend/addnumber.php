<?php
require_once('public_include.php');
foreach ($_POST as $kk => $vv){
    $$kk = (trim($vv));
}
$strSQL = "select $field from $table where id = '$id'";        
$arr_data = $db->Execute($strSQL);
$original = $arr_data[0][$field];
$new = $original + $value;
 $strSQL = "UPDATE `$table` SET `$field` = '$new'
                                         WHERE `id` = $id";
 $a = $db->Execute($strSQL);