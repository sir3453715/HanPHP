<?php
$name = explode(",", $vv['table_name']);
$field = explode(",", $vv['table_field']);
$title = explode(",", $vv['table_title']);
if(count($vv['value'])==0){
	$statr = 1;
}else{
	$statr = count($vv['value']);
}
?>
<script type="text/javascript">
$(document).ready(function () {
    var counter = <?=$statr?>;
    var limit=<?=$vv['table_limit']?>;
    $("#addrow").on("click", function () {
      if(counter>=limit){
        $('#table_row_ad_overlimit').html('超過限制數量');
        return false;
      }else{
        var newRow = $("<tr>");
        var cols = "";

        cols += '<?php
            echo '"';
            foreach ($name as $key => $value) {
              echo '<td class=text-center>';
          foreach ($field as $key1 => $value1) {
            if($key1==$key){
              $tmp_value = $value.$x;
              $tmp_title = $title[$key];
            }
          }
          ?><input name="<?=$tmp_value?>" type="text" placeholder="<?=$tmp_title?>"" class="form-control"><?php
          echo '</td>';
        }
          ?>';

        cols += '<td><button type="button" class="ibtnDel btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
        console.log(counter);
        $('#table_row_ad_count').val(counter);
      }
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $('#table_row_ad_overlimit').html('');
        $(this).closest("tr").remove();       
        counter -= 1;
        console.log(counter);
        $('#table_row_ad_count').val(counter);
    });


});
function active (table) {
  $(table).addClass("active");
}
function dis_active (table) {
  $(table).removeClass("active");
}
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
        <table id="myTable" class=" table order-list">
            <thead>
                <tr>
                    ';
                    foreach ($title as $key => $titles) {
                      echo '<th class="text-center">'.$titles.'</th>';
                    }
                    echo '
                </tr>
            </thead>
            <tbody>';
                if(count($vv['value'])==0){
                  echo '<tr class="text-center"> ';
                  foreach ($name as $key => $value) {
                    echo '<td class="text-center">';
                    foreach ($field as $key1 => $value1) {
                      if($key1==$key){
                        $tmp_value = $value.$key;
                        $tmp_title = $title[$key];
                      }
                    }
                    echo '<input type="text" name="'.$tmp_value.'" class="form-control" placeholder="'.$tmp_title.'">';
                    echo '</td>';
                  }
                  echo '<td><a class="deleteRow"></a></td>';
                  echo '</tr>';
              }else{
                  for ($x=0; $x <count($vv['value']); $x++) { 
                    echo '<tr class="text-center"> ';
                    foreach ($name as $key => $value) {
                      echo '<td class="text-center">';
                      foreach ($field as $key1 => $value1) {
                        if($key1==$key){
                          $tmp_value = $value.$x;
                          $tmp_title = $title[$key];
                        }
                      }
                      echo '<input type="text" name="'.$tmp_value.'" class="form-control" placeholder="'.$tmp_title.'" value="'.$vv['value'][$x][$value].'">';
                    }
                    echo '</td>';
                    if($x==0){
                      echo '<td><a class="deleteRow"></a></td>';
                    }else{
                      echo '<td><button type="button" class="ibtnDel btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td>';
                    }
                    echo '</tr>';
                  }
              }
                echo '
            </tbody>
            <tfoot>
                <tr class="text-center">
                    <td colspan="'.(count($name)+1).'" style="text-align: left;">
                        <a id="addrow" class="btn btn-default btn-lg btn-block "><span class="glyphicon glyphicon-plus"></span> 增加列</a>
                    </td>
                </tr>
                <tr>
                </tr>
            </tfoot>
        </table>
        <p class="help-block" style="color:red;" id="table_row_ad_overlimit"></p>
        <input type="hidden" id="table_row_ad_count" name="table_row_ad_count" value="'.count($vv[value]).'">
    </div>
    
</div>


</div>
</div>
';
?>
