<?php
    require('public_include.php');
    // $strSQL ="SELECT * FROM product_class WHERE status='1' ORDER BY sort DESC";
    $strSQL ="SELECT * FROM product_class WHERE status='1' ORDER BY sort DESC";
    $result = $db->Execute($strSQL); 
    $return .= '<option value="">請選擇大類別</option>';
    foreach ($result as $value) {
        $return .= '<option value="'.$value['id'].'">'.$value['title'].'</option>';
    }
    echo $return;
?>