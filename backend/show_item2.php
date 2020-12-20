<?php
    require('public_include.php');
	$id = $_POST['id'];
	$num = $_POST['num'];
	$func = $_POST['func'];
	// echo $num;
	// echo $func;
	// exit;
	$tmp_num = explode(',', $num);
	$tmp = explode(',', $id);
	if(count($tmp)>1){
		$i = 0;
		foreach ($tmp as $key => $value) {
			if($value!=''):
				$strSQL = "SELECT * FROM `product` WHERE id='$value'";	
			    $result = $db->Execute($strSQL);
			    $return .= '<tr class="vertical-md-middle text-center active unsortable" id="item'.$result[0]['id'].'">';
			    $return .= '<td class="text-center">';
			    $return .= $result[0]['code'];
			    $return .= '</td>';
			    $return .= '<td class="text-center">';
			    $return .= $result[0]['title'];
			    $return .= '</td>';
			    $return .= '<td class="text-center">';
			    if($tmp_num[$i]!=''){
			    	$num = $tmp_num[$i];
			    }else{
			    	$num = 0;
			    }
			    $return .= '<input class="form-control input-sm" type="number" id="recommend_num[]" name="recommend_num[]" value="'.$num.'"';
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
	    $return .= '<tr class="vertical-md-middle text-center active unsortable" id="item'.$result[0]['id'].'">';
	    $return .= '<td class="text-center">';
	    $return .= $result[0]['code'];
	    $return .= '</td>';
	    $return .= '<td class="text-center">';
	    $return .= $result[0]['title'];
	    $return .= '</td>';
	    $return .= '<td class="text-center">';
	    if($func=='1'){
	    	$num_f = $num;
	    }else{
	    	$num_f = 0;
	    }
	    if($num_f=='undefined'){
	    	$num_f = 1;
	    }
	    $return .= '<input class="form-control input-sm" type="number" id="recommend_num[]" name="recommend_num[]" value="'.$num_f.'">';
	    $return .= '</td>';
	    $return .= '<td class="text-center">';
	    $return .= '<button type="button" class="btn btn-default" onclick="del_list(\''.$result[0]['id'].'\');"><span class="glyphicon glyphicon-minus"></span></button>';
	    $return .= '</td>';
	    $return .= '<input type="hidden" name="recommend[]" id="recommend[]" value="'.$result[0]['id'].'">';
	    $return .= '</tr>';
	}    
    echo $return;
?>