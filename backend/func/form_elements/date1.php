<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">' . ($vv['title']) . '</label>
<div class="col-sm-10">
<div>
<input class="datepicker form-control" type="text" name="' . $vv['name_1'] . '" id="' . $vv['name_1'] . '" value="' . $vv['value_1'] . '" ' . (($vv['required']) ? 'required autofocus' : '') . '> ~ <input class="datepicker form-control" type="text" name="' . $vv['name_2'] . '" id="' . $vv['name_2'] . '" value="' . $vv['value_2'] . '" ' . (($vv['required']) ? 'required autofocus' : '') . '>
</div>
<p class="help-block">' . $vv['help'] . '</p>
<p class="text-warning" id="' . $vv['name_1'] . '_warning"></p>
</div>
</div>

';
