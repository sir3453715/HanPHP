<?php
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
<select class="form-control" id="'.$vv['name'].'" name="'.$vv['name'].'"  Style="Font-Size:14pt;">
';
if(is_array($vv['options'])){ 
	foreach($vv['options'] as $kkk=>$vvv){
		if($vvv == $vv['value']){
			echo '<option value="'.$vvv.'" selected style="color: '.$kkk.';" selected>' . htmlspecialchars($vvv).'</option>';
		}else{
			echo '<option value="'.$vvv.'" style="background-color: '.$kkk.';">' . htmlspecialchars($vvv).'</option>';
		}
		
	}

}
echo '
</select>
</div>
';
?>
