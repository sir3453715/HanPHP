<!-- MiniColors -->
<script src="js/jquery.minicolors.js"></script>
<link rel="stylesheet" href="js/jquery.minicolors.css">
<script>
    $(document).ready( function() {
        $('.color').each( function() {
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                format: $(this).attr('data-format') || 'hex',
                keywords: $(this).attr('data-keywords') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                change: function(hex, opacity) {
                    var log;
                    try {
                        log = hex ? hex : 'transparent';
                        if( opacity ) log += ', ' + opacity;
                        console.log(log);
                    } catch(e) {}
                },
                theme: 'default'
            });

        });
    });
</script>
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
     $("#add_row1").click(function(){
     	if(i>=limit){
     		$('#table_row_overlimit_color').html('超過限制數量');
     		return false;
     	}else{
	      $('#addr_color_'+i).html("<td class='text-center' width='<?=round(100/(count($title)+1))?>'>"+ (i+1) +"</td>"+
	      	<?php
	      		echo '"';
	        	foreach ($name as $key => $value) {
	        		echo '<td class=\'text-center\' width=\''.round(100/(count($title)+1)).'%\'>';
					foreach ($field as $key1 => $value1) {
						if($key1==$key){
							$tmp_value = $value;
							$tmp_title = $title[$key];
						}
					}
					?><input name='<?=$tmp_value?>"+i+"' id='<?=$tmp_value?>"+i+"' type='text' placeholder='色碼' class='form-control color'></td><td class=text-center><input name='<?=$tmp_value?>"+i+"_title' id='<?=$tmp_value?>"+i+"_title' type='text' placeholder='顏色名稱' class='form-control'><?php
					echo '</td>';
				}
	      	?>"
	      	);
	      $('#tab_logic_color').append('<tr id="addr_color_'+(i+1)+'"></tr>');
          $('.color').each( function() {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                    change: function(hex, opacity) {
                        var log;
                        try {
                            log = hex ? hex : 'transparent';
                            if( opacity ) log += ', ' + opacity;
                            console.log(log);
                        } catch(e) {}
                    },
                    theme: 'default'
                });

            });
	      i++;
	      $('#table_row_count1').val(i);
	  	}
	  });
     $("#delete_row1").click(function(){
     	$('#table_row_overlimit_color').html('');
    	 if(i>1){
		 $("#addr_color_"+(i-1)).html('');
		 i--;
		 $('#table_row_count1').val(i);
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
    <div>
        <table class="table" id="tab_logic_color"> 
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
                	echo '<tr class="vertical-md-middle text-center active" id="addr_color_0"> ';
                	echo '<td class="text-center" width="'.round(100/(count($title)+1)).'%">1</td>';
                	foreach ($name as $key => $value) {
                		echo '<td class="text-center" width="'.round(100/(count($title)+1)).'%">';
						foreach ($field as $key1 => $value1) {
							if($key1==$key){
								$tmp_value = $value.$key;
								$tmp_title = $title[$key];
							}
						}
                        echo '<input type="text" name="'.$tmp_value.'" id="'.$tmp_value.'" class="form-control color" placeholder="色碼"></td><td class=text-center>';
						echo '<input type="text" name="'.$tmp_value.'_title" id="'.$tmp_value.'_title" class="form-control" placeholder="顏色名稱">';
						echo '</td>';
					}
					echo '</tr><tr id="addr_color_1"></tr>';
                }else{
                	for ($x=0; $x <count($vv['value']); $x++) { 
                		echo '<tr class="vertical-md-middle text-center active" id="addr_color_'.$x.'"> ';
                		echo '<td class="text-center" width="'.round(100/(count($title)+1)).'%">'.($x+1).'</td>';
                		foreach ($name as $key => $value) {
	                		echo '<td class="text-center" width="'.round(100/(count($title)+1)).'%">';
							foreach ($field as $key1 => $value1) {
								if($key1==$key){
									$tmp_value = $value.$x;
									$tmp_title = $title[$key];
								}
							}
                            echo '<input type="text" name="'.$tmp_value.'" id="'.$tmp_value.'" class="form-control color" placeholder="色碼" value="'.$vv['value'][$x].'"></td><td class=text-center>';
                            echo '<input type="text" name="'.$tmp_value.'_title" id="'.$tmp_value.'_title" class="form-control" placeholder="顏色名稱" value="'.$vv['value1'][$x].'">';
							echo '<input type="hidden" name="'.$tmp_value.'_id" id="'.$tmp_value.'_id" value="'.$vv['value2'][$x].'">';
						}
						echo '</td>';
						echo '</tr>';
                	}
                	echo '</tr><tr id="addr_color_'.($x).'"></tr> ';
                }
                echo '                                                    
            </tbody>                                                        
        </table>
        <p class="help-block" style="color:red;" id="table_row_overlimit_color"></p>
        <input type="hidden" id="table_row_count1" name="table_row_count1" value="'.count($vv["value"]).'">
    </div>
    <a id="add_row1" class="btn btn-default pull-left"><span class="glyphicon glyphicon-plus"></span> 增加列</a><a id="delete_row1" class="pull-right btn btn-default"><span class="glyphicon glyphicon-minus"></span> 刪除列</a>
</div>
</div>
';
?>
