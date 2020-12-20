<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div class="input-group input-group-flat">
    <input class="datetime_class form-control" type="text" name="'.$vv['name'].'" id="'.$vv['name'].'" value="'.$vv['value'].'">
    <span class="input-group-btn"><button class="btn btn-primary btn-sm input-group-close-icon" onclick="clear_time(\''.$vv['name'].'\');return false;"><i class="ti-close"></i></button></span>
</div>
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>

';
?>
