<?php
require_once('public_include.php');
foreach ($_POST as $kk => $vv){
    $$kk = (trim($vv));
}
 $strSQL = "UPDATE `$table` SET `$field` = '$status'
                                         WHERE `id` = $id";
echo $strSQL;
 $a = $db->Execute($strSQL);