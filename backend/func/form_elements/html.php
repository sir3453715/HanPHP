<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
';
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';

$config = array();
$config['height'] = $vv['height'];
$CKEditor->editor($vv['name'], $vv['value'], $config);
echo '
	</div>
    </div>
';
?>