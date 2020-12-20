<?php
    require('public_include.php');
	$id = $_POST['id'];
	$price = $_POST['price'];
	$func = $_POST['func'];
	// echo $price;
	// echo $func;
	// exit;
	$tmp_price = explode(',', $price);
	$tmp = explode(',', $id);
	if(count($tmp)>1){
		$i = 0;
		foreach ($tmp as $key => $value) {
			if($value!=''):
				$strSQL = "SELECT * FROM `product` WHERE id='$value'";	
			    $result = $db->Execute($strSQL);
			    $return .= '<tr class="vertical-md-middle text-center active" id="item'.$result[0]['id'].'">';
			    $return .= '<td class="text-center">';
			    $return .= $result[0]['code'];
			    $return .= '</td>';
			    $return .= '<td class="text-center">';
			    $return .= $result[0]['title'];
			    $return .= '</td>';
			    $return .= '<td class="text-center">';
			    if($tmp_price[$i]!=''){
			    	$price = $tmp_price[$i];
			    }else{
			    	$price = 0;
			    }
			    $return .= '<input class="form-control" type="text" id="recommend_price[]" name="recommend_price[]" value="'.$price.'"';
			    $return .= '</td>';
			    $return .= '<td class="text-center">';
			    $return .= '<button type="button" class="btn btn-default" onclick="del_list(\''.$result[0]['id'].'\');"><span class="glyphicon glyphicon-minus"></span></button>';
			    $return .= '</td>';
			    $return .= '<input type="hidden" name="recommend[]" id="recommend[]" value="'.$result[0]['id'].'">';
			    $return .= '</tr>';
			    $i++;
		    endif;
		}
	}else{
		$strSQL = "SELECT * FROM `product` WHERE id='$id'";	
	    $result = $db->Execute($strSQL);
	    $return .= '<tr class="vertical-md-middle text-center active" id="item'.$result[0]['id'].'">';
	    $return .= '<td class="text-center">';
	    $return .= $result[0]['code'];
	    $return .= '</td>';
	    $return .= '<td class="text-center">';
	    $return .= $result[0]['title'];
	    $return .= '</td>';
	    $return .= '<td class="text-center">';
	    if($func=='1'){
	    	$price_f = $price;
	    }else{
	    	$price_f = 0;
	    }
	    if($price_f=='undefined'){
	    	$price_f = '';
	    }
	    $return .= '<input class="form-control" type="text" id="recommend_price[]" name="recommend_price[]" value="'.$price_f.'">';
	    $return .= '</td>';
	    $return .= '<td class="text-center">';
	    $return .= '<button type="button" class="btn btn-default" onclick="del_list(\''.$result[0]['id'].'\');"><span class="glyphicon glyphicon-minus"></span></button>';
	    $return .= '</td>';
	    $return .= '<input type="hidden" name="recommend[]" id="recommend[]" value="'.$result[0]['id'].'">';
	    $return .= '</tr>';
	}    
    echo $return;
?>