<?php
require_once('public_include.php');
foreach ($_POST as $kk => $vv){
    $$kk = (trim($vv));
}
 $strSQL = "DELETE FROM `$table` WHERE `id` = $id";
                   
 $a = $db->Execute($strSQL);                      
 echo $strSQL;