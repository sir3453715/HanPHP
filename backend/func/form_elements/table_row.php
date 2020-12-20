<?php
$name = explode(",", $vv['table_name']);
// $name = $vv['table_name'];
$field = explode(",", $vv['table_field']);
$title = explode(",", $vv['table_title']);
if(count($vv['value'])==0){
	$statr = 1;
}else{
	$statr = count($vv['value']);
}
?>
<script type="text/javascript">
     $(document).ready(function(){
      var i=<?=$statr?>;
      var limit=<?=$vv['table_limit']?>;
     $("#add_row").click(function(){
     	if(i>=limit){
     		$('#table_row_overlimit').html('超過限制數量');
     		return false;
     	}else{
	      $('#addr'+i).html("<td class='text-center' width='<?=round(100/(count($field)+1))?>'>"+ (i+1) +"</td>"+
	      	<?php
	      		echo '"';
	        	foreach ($name as $key => $value) {
	        		echo '<td class=\'text-center\' width=\''.round(100/(count($field)+1)).'%\'>';
					foreach ($field as $key1 => $value1) {
						if($key1==$key){
							$tmp_value = $value;
							$tmp_title = $title[$key];
						}
					}
					?><input name='<?=$tmp_value?>"+i+"' type='text' placeholder='<?=$tmp_title?>' class='form-control'><?php
					echo '</td>';
				}
	      	?>"
	      	);
	      $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
	      i++; 
	      $('#table_row_count').val(i);
	  	}
	  });
     $("#delete_row").click(function(){
     	$('#table_row_overlimit').html('');
    	 if(i>1){
		 $("#addr"+(i-1)).html('');
		 i--;
		 $('#table_row_count').val(i);
		 }
	 });

});
</script>
<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
';
echo '
<div class="tab-pane active">
    <div class="table-responsive">
        <table class="table" id="tab_logic"> 
            <thead>
                <tr> 
                    <th class="text-center">#</th> 
                    ';
                    foreach ($title as $key => $titles) {
                    	echo '<th class="text-center">'.$titles.'</th>';
                    }
                    echo '
                </tr>                                                             
            </thead>
            <tbody>';
                if(count($vv['value'])==0){
                	echo '<tr class="vertical-md-middle text-center active" id="addr0"> ';
                	echo '<td class="text-center" width="'.round(100/(count($field)+1)).'%">1</td>';
                	foreach ($name as $key => $value) {
                		echo '<td class="text-center" width="'.round(100/(count($field)+1)).'%">';
						foreach ($field as $key1 => $value1) {
							if($key1==$key){
								$tmp_value = $value.$key;
								$tmp_title = $title[$key];
							}
						}
						echo '<input type="text" name="'.$tmp_value.'" class="form-control" placeholder="'.$tmp_title.'">';
						echo '</td>';
					}
					echo '</tr><tr id="addr1"></tr>';
                }else{
                	for ($x=0; $x <count($vv['value']); $x++) { 
                		echo '<tr class="vertical-md-middle text-center active" id="addr'.$x.'"> ';
                		echo '<td class="text-center" width="'.round(100/(count($field)+1)).'%">'.($x+1).'</td>';
                		foreach ($name as $key => $value) {
	                		echo '<td class="text-center" width="'.round(100/(count($field)+1)).'%">';
							foreach ($field as $key1 => $value1) {
								if($key1==$key){
									$tmp_value = $value.$x;
									$tmp_title = $title[$key];
								}
							}
							echo '<input type="text" name="'.$tmp_value.'" class="form-control" placeholder="'.$tmp_title.'" value="'.$vv['value'][$x].'">';
							echo '<input type="hidden" name="'.$tmp_value.'_id" class="form-control" value="'.$vv['value1'][$x].'">';
						}
						echo '</td>';
						echo '</tr>';
                	}
                	echo '</tr><tr id="addr'.($x).'"></tr> ';
                }
                echo '                                                    
            </tbody>                                                        
        </table>
        <p class="help-block" style="color:red;" id="table_row_overlimit"></p>
        <input type="hidden" id="table_row_count" name="table_row_count" value="'.count($vv["value"]).'">
    </div>
    <a id="add_row" class="btn btn-default pull-left"><span class="glyphicon glyphicon-plus"></span> 增加列</a><a id="delete_row" class="pull-right btn btn-default"><span class="glyphicon glyphicon-minus"></span> 刪除列</a>
</div>
</div>
</div>
';
?>
