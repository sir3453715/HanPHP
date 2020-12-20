<?php
$id = GetSQLValueString($_GET['id']);
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
		<div id="list_ques"></div>
<INPUT TYPE="hidden" name="ques_id" id="ques_id">
</div>';
?>