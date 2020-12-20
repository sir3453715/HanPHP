<?php
echo '
<div class="form-group row" id="text_display" style="display:none;">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<input class="form-control" type="text" id="'.$vv['name'].'" name="'.$vv['name'].'" value="'.htmlspecialchars($vv['value']).'" '.(($vv['required'])?'required autofocus':'').'>
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>
';
?>
