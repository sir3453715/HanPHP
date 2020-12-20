<?php 
	require('public_include.php');
	$class_id = $_POST["class_id"];
	$strSQL = "SELECT * FROM `product_class` WHERE up_id = '$class_id' ORDER BY sort ASC";
	$product_class2 = $db->Execute($strSQL);
	foreach ($product_class2 as $product_class2s) {
		$content .= '<option value="'.$product_class2s['id'].'">'.$product_class2s['title_tw'].'</option>';
	}
	echo $content;
?>

