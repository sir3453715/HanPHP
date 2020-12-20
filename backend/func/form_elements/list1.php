<?php
// require_once('backend/public_include.php');
$id = ($_GET['id']);
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div id="category1"></div>
<INPUT TYPE="hidden" name="i_category_id" id="i_category_id">
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
    tree1 = new dhtmlXTreeObject("category1","100%","100%",0);
    tree1.setSkin('dhx_skyblue');
    tree1.setImagePath("js/codebase/imgs/dhxtreeview_material/");
    tree1.enableCheckBoxes(1);
    tree1.enableThreeStateCheckboxes(true);
    tree1.loadXML("product.php?func=category1&templet_id=<?=$_GET['id']?>&<?=time()?>");
</SCRIPT>
<script type="text/javascript">
$(document).ready(function(){
	$('#form1').submit(function(){
		$('#i_category_id').val(tree1.getAllChecked());
	});
});

</script>