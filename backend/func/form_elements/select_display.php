<?php
echo '
<div class="form-group row" id="'.$vv['name'].'_display">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<select class="form-control" id="'.$vv['name'].'" name="'.$vv['name'].'">
';
if(is_array($vv['options'])){
	foreach($vv['options'] as $kkk=>$vvv){
		if($kkk == $vv['value']){
			echo '<option value="'.$kkk.'" selected>' . htmlspecialchars($vvv).'</option>';
		}else{
			echo '<option value="'.$kkk.'">' . htmlspecialchars($vvv).'</option>';
		}
		
	}

}
echo '
</select>
</div>
</div>
';
?>
