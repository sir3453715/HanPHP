<?php
$id = GetSQLValueString($_GET['id']);
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
		<div id="list_medals"></div>
<INPUT TYPE="hidden" name="medals_id" id="medals_id">
</div>';
?>