<?php

echo '
<div class="form-group">
<label>' . ($vv['title']) . '</label><br>
';
if (is_array($vv['options']))
{
    foreach ($vv['options'] as $kkk => $vvv)
    {
        if ($kkk == $vv['value'])
        {
            echo '<input type="radio" value="' . $kkk . '"  name="rank" Checked>' . htmlspecialchars($vvv) . '<br>';
        }
        else
        {
            echo '<input type="radio" value="' . $kkk . '" name="rank">' . htmlspecialchars($vvv) . '<br>';
        }
    }
}
echo '
</div>
';
?>
