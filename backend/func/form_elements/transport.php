<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
';
if (is_array($vv['options']))
{
    foreach ($vv['options'] as $kkk => $vvv)
    {
        echo '<label class="control-label radio-inline">';
        if ($kkk == $vv['value'])
        {

            echo '<input type="radio" value="' . $kkk . '"  name="' . $vv['name'] . '" Checked>' . htmlspecialchars($vvv) . '<br>';
        }
        else
        {
            echo '<input type="radio" value="' . $kkk . '" name="' . $vv['name'] . '">' . htmlspecialchars($vvv) . '<br>';
        }
        echo '</label>';
    }
}
echo '
<div id="port1">
<select class="form-control" name="blackcat_transport">
    <option value="60cm">60cm</option>
    <option value="90cm">90cm</option>
    <option value="120cm">120cm</option>
    <option value="150cm">150cm</option>
</select>
</div>
<div id="port2" style="display:none;">
<input class="datepicker" size="16" type="text" name="'.$vv['name'].'" id="'.$vv['name'].'" value="'.$vv['value'].'" data-date-format="yyyy-mm-dd" '.(($vv['required'])?'required autofocus':'').'>
</div>
</div>
</div>

';
?>
