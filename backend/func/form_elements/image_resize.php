<?php
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
<input type="file" id="'.$vv['name'].'" max_size="'.$vv['max_size'].'"/>
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
';
if($vv['value']!=''){
	//$size = @filesize(__SERVER_IMAGES_FOLDER.'/'.$vv['value']);
	$data = getimagesize(__SERVER_IMAGES_FOLDER.'/'.$vv['value']);
	//print_r($size);
	//exit;
	if($size>300000){
		$q = 0.5;
	}else{
		$q = 1;
	}
	$q = 1;
	/*echo '
<img src="'.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'" class="img-thumbnail">';
*/
/*
if($vv['w']!=''){
	$andPara .= '&w='.$vv['w'];
}
if($vv['h']!=''){
	$andPara .= '&h='.$vv['h'];
}
*/
if($data[0]/200 > 1 ){
	$andPara .= '&w='.($data[0]/(ceil($data[0]/200)));
	$andPara .= '&h='.($data[1]/(ceil($data[0]/200)));
	$tmp = 'width=' . ($data[0]/(ceil($data[0]/200)));
}else{
	$andPara .= '&w='.$data[0];
	$andPara .= '&h='.$data[1];
	$tmp = 'width=' . $data[0];
}
	//echo '<label><a href="'.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'" target="_blank" class="btn btn-warning">view</a></label><br />';

	// echo '<img src="/backend/webimages/timthumb.php?src=/backend'.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'&q='.$q.'&size='.$size.$andPara.'&zc=0" class="img-thumbnail" /><br />';
	// echo '<img src="/backend/webimages/timthumb.php?src=/backend'.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'&size='.$size.$andPara.'&zc=0" class="img-thumbnail" /><br />';
	echo '<img src="'.__WEB_IMAGES_FOLDER.'/'.$vv['value'].'" '.$tmp.' class="img-thumbnail" />';
	if($vv['delete']){
		echo '<label>
	                    <input type="checkbox" value="true" name="del_'.$vv['name'].'">
	                    delete ?
	                  </label>';
	}
}
echo '
</div>
';
?>
