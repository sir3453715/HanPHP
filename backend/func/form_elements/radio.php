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
        echo '<label class="form-check-inline">';
        if ($kkk == $vv['value'])
        {

            echo '<input class="form-check-input" type="radio" value="' . $kkk . '"  name="' . $vv['name'] . '" Checked>' . htmlspecialchars($vvv) . '<br>';
        }
        else
        {
            echo '<input class="form-check-input" type="radio" value="' . $kkk . '" name="' . $vv['name'] . '">' . htmlspecialchars($vvv) . '<br>';
        }
        echo '</label>';
    }
}
echo '</div>
</div>
';
?>
