<?php
    require('public_include.php');
    $strSQL ="SELECT * FROM product_class WHERE status='1' AND id='".$_POST['id']."' ORDER BY sort DESC";
    $result = $db->Execute($strSQL); 
    foreach ($result as $value) {
        $return .= '<option value="'.$value['id'].'">'.$value['title'].'</option>';
    }
    echo $return;
?>