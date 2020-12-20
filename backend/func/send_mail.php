<meta charset="UTF-8">
<?
	foreach($_POST as $kk=>$vv){
			$$kk = $vv;
	}
	mail($to, $subject, $msg, $headers)
?>
