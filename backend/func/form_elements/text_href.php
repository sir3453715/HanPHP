<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<a href="'.$vv['href'].'?func=update&id='.$vv['id'].'" target="_blank">'.htmlspecialchars($vv['value']).'</a>

<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>
';
?>
<!-- <input class="form-control" type="text" id="'.$vv['name'].'" name="'.$vv['name'].'" value="'.htmlspecialchars($vv['value']).'" '.(($vv['required'])?'required autofocus':'').'> -->