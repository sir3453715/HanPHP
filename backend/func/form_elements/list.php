<?php
// require_once('backend/public_include.php');
$id = ($_GET['id']);
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div id="category"></div>
<INPUT TYPE="hidden" name="category_id" id="category_id">
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>
';

?>
<link rel="STYLESHEET" type="text/css" href="js/codebase/dhtmlx.css">
<script  src="js/codebase/dhtmlx.js"></script>
<script  src="js/codebase/dhtmlx_deprecated.js"></script>

<script>
    tree0 = new dhtmlXTreeObject("category","100%","100%",0);
    tree0.setSkin('dhx_skyblue');
    tree0.setImagePath("js/codebase/imgs/dhxtreeview_material/");
    tree0.enableCheckBoxes(1);
    tree0.enableThreeStateCheckboxes(true);
    tree0.loadXML("product.php?func=category&templet_id=<?=$_GET['id']?>&<?=time()?>");
</SCRIPT>
<script type="text/javascript">
$(document).ready(function(){
	$('#form1').submit(function(){
		$('#category_id').val(tree0.getAllChecked());
	});
});

</script>