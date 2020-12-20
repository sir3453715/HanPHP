<?php
require_once('public_include.php');
foreach ($_POST as $kk => $vv){
    $$kk = (trim($vv));
}
$arr_list = explode(',',$data);
//找出陣列中排序最大的
foreach ($arr_list as $kk => $vv) {
    $tmp = explode('_',$vv);
    $id = $tmp[1];
    $arr_id .= $id.',';
}
$arr_id = substr($arr_id,0,-1);
$strSQL = "SELECT * FROM `$table` WHERE id in(".$arr_id.") ORDER BY sort DESC LIMIT 1";
$bigone = $db->Execute($strSQL);

$strSQL = "SELECT count(*) FROM `$table`";
$rs1 = $db->Execute($strSQL);
$count = $rs1[0]['count(*)']+1;//遞減用
$arr_id = '';
//更新大於此頁第一筆的
$strSQL = "SELECT * FROM `$table` WHERE id = '".$bigone[0]['id']."'";
$now = $db->Execute($strSQL);
$strSQL = "SELECT * FROM `$table` WHERE sort >= '".$now[0]['sort']."' AND id !='".$bigone[0]['id']."' ORDER BY sort DESC";
$other = $db->Execute($strSQL);
foreach ($other as $value) {
    $arr_id .= $value['id'].',';
    $strSQL = "UPDATE `$table` SET `sort` = '$count' WHERE `id` = '".$value['id']."'";
    $db->Execute($strSQL);
    $count--;
}
// $count = 1;
foreach ($arr_list as $kk => $vv) {
    $tmp = explode('_',$vv);
    $id = $tmp[1];
    $arr_id .= $id.',';
    $strSQL = "UPDATE `$table` SET `sort` = '$count' WHERE `id` = $id";
    $db->Execute($strSQL);
    $count--;
}
$arr_id = substr($arr_id,0,-1);
//更新其他頁面內商品排序
$strSQL = "SELECT * FROM `$table` WHERE id NOT IN($arr_id) ORDER BY sort DESC";
$rs = $db->Execute($strSQL);
foreach ($rs as $value) {
    $id = $value['id'];
    $strSQL = "UPDATE `$table` SET `sort` = '$count' WHERE `id` = $id";
    $db->Execute($strSQL);
    $count--;
}
