<?php
echo '<br/><br/>
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div class="row">
	<div class="col-sm-4 text-center">
		<b>大類別</b>
	</div>
	<div class="col-sm-4 text-center">
		<b>小類別</b>
	</div>
	<div class="col-sm-4 text-center">
		<b>商品名稱</b>
	</div>	
</div>
<div class="row">
	<div class="col-sm-4">
		<select class="form-control" id="product_class" name="product_class" onchange="class_change();"></select>
	</div>
	<div class="col-sm-4">
		<select class="form-control" id="product_class2" name="product_class2" onchange="class2_change();"></select>
	</div>
	<div class="col-sm-4">
		<input class="form-control" type="text" id="product_name" name="product_name">
		<div id="suggesstion-box"></div>
	</div>	
</div>
<br/>
<div class="tab-pane active">
    <div class="table-responsive">
        <table class="table"> 
            <thead>
                <tr> 
                    <th class="text-center">商品編號</th>
                    <th class="text-center">商品名稱</th>
                    <th class="text-center">動作</th>
                </tr>                                                             
            </thead>
            <tbody id="show_list"></tbody>                                                        
        </table>
    </div>
</div>

</div>
</div>
';
?>
<script>
$(document).ready(function(){
	// $("#keyword").blur(function(){
	// 	$("#suggesstion-box").hide();
	// 	$("#keyword").css("background","#FFF");
	// });
	$("#product_name").keyup (function (e){var keyCode = e.keyCode || e.which;
        var crt = $(".contact li.cp");        
        if (keyCode == 38){// up
            var prev = crt.prev("li").length ? crt.prev("li") : $(".contact li").last();
            crt.removeClass("cp");
            prev.addClass("cp");
            var offset1 = $('.contact li.cp').last().position().top;            
            var offset = $('.contact li.cp').offset().top;            
            if(offset<$('.contact').height()){
            	document.getElementById('country-list').scrollTop -= 38;
            }
            if(offset>offset1){
            	document.getElementById('country-list').scrollTop += offset1;
            }
        }else if (keyCode == 40){// down
            var next = crt.next("li").length ? crt.next("li") : $(".contact li").first();
            crt.removeClass("cp");
            next.addClass("cp");
            var offset1 = $('.contact li.cp').first().position().top;
            var offset = $('.contact li.cp').offset().top;
            if(offset>$('.contact').height()){
            	document.getElementById('country-list').scrollTop += 38;
            }
            if(offset<0){
            	document.getElementById('country-list').scrollTop = offset1;
            }
        }else if (keyCode == 13){// enter
        	var tmp = crt[0].outerHTML;
        	var tmp1 = tmp.split("'");
        	add_list(tmp1[1]);
            // document.location='shop_view.php?id='+tmp1[1];
            return false;
        }else{
        	$.ajax({
				type: "POST",
				url: "../keyword_search.php",
				data:'keyword='+$(this).val(),
				beforeSend: function(){
					$("#product_name").css("background","#FFF");
					$("#suggesstion-box").css("background","#FFF");
				},
				success: function(data){
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#product_name").css("background","#FFF");
				}
			});
        }
        return false;
    });
});
function selectkeyword(val) {
	// $("#keyword").val(val);
	$("#suggesstion-box").hide();
	// document.location.href="shop_view.php?id="+val;
	add_list(val);
}
function changecp(){
  var crt = $(".contact li.cp"); 
  crt.removeClass("cp");
}
</script>
<style>
#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:324.63px;position: absolute;z-index:99999;max-height: 420px;overflow:auto;}
#country-list li{padding: 10px; background: #FFF; border-bottom: #bbb9b9 0px solid;font-size: 13px;}
#country-list li:hover{background:#009fe9;cursor: pointer;}
#country-list li.cp{background:#009fe9;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>