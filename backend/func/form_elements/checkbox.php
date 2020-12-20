<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
';
$str = explode(",", $vv['value']);
if (is_array($vv['options']))
{
    foreach ($vv['options'] as $kkk => $vvv)
    {
        foreach ($str as $aa => $bb)
        {
            if ($kkk == $bb && $bb!='')
            {
                $out += 1;
            }
            else
            {
                $out += 0;
            }
        }
        if ($out >= 1)
        {
            echo '<label class="checkbox-inline form-check-inline mr-1"><input class="form-check-input" type="checkbox" name="' . $vv['name'] . '[]" value="' . $kkk . '" Checked>' . htmlspecialchars($vvv) . '</label><br/>';
            $out = 0;
        }
        elseif($out==0 || $str=='')
        {
            echo '<label class="checkbox-inline form-check-inline mr-1"><input class="form-check-input" type="checkbox" name="' . $vv['name'] . '[]" value="' . $kkk . '">' . htmlspecialchars($vvv) . '</label><br/>';
            $out = 0;
        }
    }
}
echo '
</div>
</div>
';
?>
