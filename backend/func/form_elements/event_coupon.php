<?php
$id = GetSQLValueString($_GET['id']);
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>
		<div id="list_coupon"></div>
<INPUT TYPE="hidden" name="coupon_id" id="coupon_id">
</div>';
?>