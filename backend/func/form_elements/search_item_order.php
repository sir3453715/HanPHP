<script type="text/javascript">
	$(window).load(function() {
		var vv = '<?=$vv['value']?>';
		if(vv!=''){
			add_list(vv);
		}		
		$.ajax({
			type: "POST",
			url: "class_search.php",
			beforeSend: function(){
			},
			success: function(data){
				$("#product_class").html(data);	
			}
		});		
	});
	function class_change(){
		$.ajax({
			type: "POST",
			url: "show_search.php",
			data:'class_id='+$('select[name="product_class"]').val(),
			beforeSend: function(){
			},
			success: function(data){
				$("#show_list").html('');
				$("#show_list").html(data);
			}
		});			
	}
	function show_list(){
		var tmp_rec = $('input[name^=recommend]');
		var list_tmp = new Array();
		for (var i = 0; i <tmp_rec.length; i++) {
			list_tmp.push(tmp_rec[i].value);
		}
		$.ajax({
			type: "POST",
			url: "show_search.php",
			data:'id='+$('select[name="product_class2"]').val()+'&class_id='+$('select[name="product_class"]').val()+'&list='+list_tmp,
			beforeSend: function(){
			},
			success: function(data){
				// console.log(data);
				$("#show_list").html('');
				$("#show_list").html(data);
			}
		});
	}
	function add_list(val){
		// var item_count = Number($('#item_count').val());
		// if(item_count>=4){
		// 	alert('最多僅能新增四筆單品推薦！');
		// }else{
			var tmp_val = val.split(',');
			if(tmp_val.length>1){
				tmp_item_count = item_count + tmp_val.length;
			}else{
				tmp_item_count = item_count + 1;
			}			
			$('#item_count').val(tmp_item_count);
			// console.log($('#item_count').val());
			$.ajax({
				type: "POST",
				url: "show_item2.php",
				data:'id='+val,
				beforeSend: function(){
				},
				success: function(data){
					$("#real_list").append(data);
				}
			});
			$('#btn'+val).attr("onclick","del_list("+val+")");
			$('#btn'+val).html('<span class="glyphicon glyphicon-minus"></span>');
		// }		
	}
	function del_list(val){
		var item_count = Number($('#item_count').val());
		tmp_item_count = item_count - 1;
		$('#item_count').val(tmp_item_count);
		console.log($('#item_count').val());
		$('#item'+val).remove();
		$('#btn'+val).attr("onclick","add_list("+val+")");
		$('#btn'+val).html('<span class="glyphicon glyphicon-plus"></span>');
	}
</script>
<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div class="tab-pane active">
    <div class="table-responsive">
        <table class="table" id="tab_logic"> 
        <input type="hidden" id="item_count" value="0">
            <thead>
                <tr> 
                    <th class="text-center">商品編號</th>
                    <th class="text-center">商品名稱</th>
                    <th class="text-center">數量</th>
                    <th class="text-center">動作</th>
                </tr>                                                             
            </thead>
            <tbody id="real_list"></tbody>                                                        
        </table>
    </div>
</div>
</div>
</div>
';
?>
