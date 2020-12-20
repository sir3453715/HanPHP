<?php
    require('public_include.php');
	$id = $_POST['id'];
	$tmp = explode(',', $id);
	if(count($tmp)>1){
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
			    $return .= '<button type="button" class="btn btn-default" onclick="del_list(\''.$result[0]['id'].'\');"><span class="glyphicon glyphicon-minus"></span></button>';
			    $return .= '</td>';
			    $return .= '<input type="hidden" name="recommend[]" id="recommend[]" value="'.$result[0]['id'].'">';
			    $return .= '</tr>';
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
	    $return .= '<button type="button" class="btn btn-default" onclick="del_list(\''.$result[0]['id'].'\');"><span class="glyphicon glyphicon-minus"></span></button>';
	    $return .= '</td>';
	    $return .= '<input type="hidden" name="recommend[]" id="recommend[]" value="'.$result[0]['id'].'">';
	    $return .= '</tr>';
	}    
    echo $return;
?>