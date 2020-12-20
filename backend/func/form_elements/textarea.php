<?php
if(isset($vv['rows'])){
	$rows = $vv['rows'];
}else{
	$rows = 20;
}
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<textarea class="form-control" type="text" rows="'.$rows.'" id="'.$vv['name'].'" name="'.$vv['name'].'" '.(($vv['required'])?'required autofocus':'').' cols="60" rows="20">'.htmlspecialchars($vv['value']).'</textarea> 
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>
';
?>
