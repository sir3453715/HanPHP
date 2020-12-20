<script src="js/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="css/bootstrap-tagsinput.css">
<!-- <script src="js/jquery-tag-it/tag-it.min.js"></script> -->
<script type="text/javascript">
	$('.bootstrap-tagsinput').tagsinput({
	  confirmKeys: [13, 44],
	  tagClass: function(item) {
	    return (item.length > 10 ? 'big' : 'small');
	  }
	});
	// $('#eventTags').tagit({
	// 		availableTags: autocompleteTag(),
	// 		singleField: true,
	// 		singleFieldNode: $('#<?=$vv['name']?>')
	// 	});
</script>
<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10" class="tag">
<input class="form-control" type="text" id="'.$vv['name'].'" name="'.$vv['name'].'" value="'.htmlspecialchars($vv['value']).'" '.(($vv['required'])?'required autofocus':'').' data-role="tagsinput">
<p class="help-block">'.$vv['help'].'</p>
<p class="text-warning" id="'.$vv['name'].'_warning"></p>
</div>
</div>
';
?>
