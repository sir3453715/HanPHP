<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-5">

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
<div class="col-sm-5">        
';
if (is_array($vv['options1']))
{
    foreach ($vv['options1'] as $kkk => $vvv)
    {
        echo '<label class="control-label radio-inline">';
        if ($kkk == $vv['value1'])
        {

            echo '<input type="radio" value="' . $kkk . '"  name="' . $vv['name1'] . '" Checked>' . htmlspecialchars($vvv) . '<br>';
        }
        else
        {
            echo '<input type="radio" value="' . $kkk . '" name="' . $vv['name1'] . '">' . htmlspecialchars($vvv) . '<br>';
        }
        echo '</label>';
    }
}
echo '</div>
</div>
';
?>
