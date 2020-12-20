<?php
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
<input class="form-control" type="text" id="'.$vv['name'].'" name="'.$vv['name'].'" value="'.htmlspecialchars($vv['value']).'" '.(($vv['required'])?'required autofocus':'').'>
';
?>
<p></p>
<a href="#" onclick="window.open('<?=htmlspecialchars($vv['value'])?>','window1',config='height=600,width=600,toolbar=no');" class="btn btn-warning">預覽</a>
<?
echo '</div>
';
?>
