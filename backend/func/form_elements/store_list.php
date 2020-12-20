<?php
$id = GetSQLValueString($_GET['id']);
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
		<div id="list_store"></div>
<INPUT TYPE="hidden" name="store_id" id="store_id">
</div>';
?>