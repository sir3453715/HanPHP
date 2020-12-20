<?php
$id = GetSQLValueString($_GET['id']);
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td valign="top">
						<div id="list_sex"></div><hr>
						<div id="list_marry"></div>
					</td>
					<td valign="top">
						<div id="list_age"></div>
					</td>
				</tr>
			</table>
<INPUT TYPE="hidden" name="sex_id" id="sex_id">
<INPUT TYPE="hidden" name="age_id" id="age_id">
<INPUT TYPE="hidden" name="marry_id" id="marry_id">
</div>';
?>