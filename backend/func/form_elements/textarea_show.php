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
<p class="form-control-static">'.(nl2br($vv['value'])).'</p>
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>
';
?>
