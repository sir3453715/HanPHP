<?php
    require('public_include.php');
    $strSQL = "SELECT * FROM web_setting WHERE id='1'";
	$web_setting = $db->Execute($strSQL);
    $class_id = $_POST['class_id'];
	$id = $_POST['id'];
	if($id=='null'){
		$id = '';
	}
	$list = $_POST['list'];
	$list = explode(',', $list);
    //列出商品
	if(($class_id=='' && $id=='') || $class_id=='14'){
		$strSQL = "SELECT * FROM `product` WHERE status='1' ORDER BY sort DESC,id DESC";
	}else if($id==''){
		if($class_id==12){//新品上市
			$new_arrivals_day = $web_setting[0]['new_arrivals_day']*86400;
			$end_date = time();
			$start_date = time() - $new_arrivals_day;
			$strSQL = "SELECT * FROM `product` WHERE status='1' AND create_date between $start_date AND $end_date ORDER BY sort DESC,id DESC";
		}else{
			//加入沒有小分類的類別(新品、推薦或其他)
			$fin_class_id .= $class_id . ',';
			//先找項目底下所有class2
			$strSQL = "SELECT * FROM `product_class` WHERE status='1' AND up_id = '$class_id'";
			$product_class2 = $db->Execute($strSQL);
			foreach ($product_class2 as $product_class2s) {
				$fin_class_id .= $product_class2s['id'].',';
			}
			$fin_class_id = substr($fin_class_id, 0, -1);

			$strSQL = "SELECT * FROM `list_class_detail` WHERE class_id IN ($fin_class_id)";
			$list_class_detail = $db->Execute($strSQL);
			$fin_class_id99 = "";
			foreach ($list_class_detail as $list_class_details) {
				$fin_class_id99 .= $list_class_details['templet_id'].',';
			}
			$fin_class_id99 = substr($fin_class_id99, 0, -1);
			if($fin_class_id99!=''){
				$strSQL = "SELECT * FROM `product` WHERE status='1' AND id IN ($fin_class_id99) ORDER BY sort DESC,id DESC";
			}else{
				$strSQL = "SELECT * FROM `product` WHERE status='1' AND id IN (0) ORDER BY sort DESC,id DESC";
			}
		}	
	}else{
		$strSQL = "SELECT * FROM `list_class_detail` WHERE class_id = '$id'";	
		$list_class_detail = $db->Execute($strSQL);
		foreach ($list_class_detail as $list_class_details) {
			$fin_class_id .= $list_class_details['templet_id'].',';
		}
		$fin_class_id = substr($fin_class_id, 0, -1);
		if($fin_class_id!=''){
			$strSQL = "SELECT * FROM `product` WHERE status='1' AND id IN ($fin_class_id) ORDER BY sort DESC,id DESC";
		}else{
			$strSQL = "SELECT * FROM `product` WHERE status='1' AND id IN (0) ORDER BY sort DESC,id DESC";
		}	
	}
    $result = $db->Execute($strSQL); 
    foreach ($result as $value) {				   
        $return .= '<tr class="vertical-md-middle text-center active unsortable">';
        $return .= '<td class="text-center">';
        $return .= $value['code'];
        $return .= '</td>';
        $return .= '<td class="text-center">';
        $return .= $value['title'];
        $return .= '</td>';
        $return .= '<td class="text-center">';
        // if($value['id']==$list){        	
        if(in_array($value['id'],$list)){        	
        	$return .= '<button type="button" class="btn btn-default" id="btn'.$value['id'].'" name="btn'.$value['id'].'" onclick="del_list(\''.$value['id'].'\');"><span class="glyphicon glyphicon-minus"></span></button>';
        }else{
        	$return .= '<button type="button" class="btn btn-default" id="btn'.$value['id'].'" name="btn'.$value['id'].'" onclick="add_list(\''.$value['id'].'\');"><span class="glyphicon glyphicon-plus"></span></button>';
        }        
        $return .= '</td>';
        $return .= '</tr>';
    }
    echo $return;
?>