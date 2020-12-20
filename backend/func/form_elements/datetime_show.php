<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div class="datetime_class1" name="'.$vv['name'].'" id="'.$vv['name'].'" value="'.$vv['value'].'"></div>
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>

';
?>
