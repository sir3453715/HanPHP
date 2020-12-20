<?php
require_once('public_include.php');
foreach ($_POST as $kk => $vv){
    $$kk = (trim($vv));
}
 $strSQL = "UPDATE `$table` SET `sort` = '$value'
                                         WHERE `id` = $id";
 $a = $db->Execute($strSQL);
//  echo $strSQL;