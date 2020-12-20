<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<input type="file" id="'.$vv['name'].'" name="'.$vv['name'].'" onchange="readURL(this);" accept="image/*"><br/>
';
if($vv['value']!=''){
	//$size = @filesize(__SERVER_IMAGEG_PATH.'/'.$vv['value']);
	$data = getimagesize(__WEB_IMAGES_FOLDER.'/'.$vv['value']);
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
	echo '<img id="' . $vv['name'] . '_img" src="' . __WEB_IMAGES_FOLDER . '/' . $vv['value'] . '" ' . $tmp . ' class="img-thumbnail" />';
	if($vv['delete']){
		echo '<label>
				&nbsp;&nbsp;<input type="checkbox" value="true" name="del_' . $vv['name'] . '">&nbsp;<i class="fa fa-trash"></i>
	         </label>';
	}
}
else
{
    echo '<img id="' . $vv['name'] . '_img" src="#" class="img-thumbnail" style="display: none;">';
}
echo '
<p class="help-block">' . $vv['help'] . '</p>
<p class="text-warning" id="' . $vv['name'] . '_warning"></p>
</div>
</div>
';
?>
