<?php
echo '
<div class="form-group row" id="split_list" style="display:none;">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<font color="red"><b>
※需要在頁面內點選拆單才生效，請勿使用更新鍵執行此動作。
</b></font><br/><br/>
<a href="javascript:void(0);" onclick="checksplit();
    return false;" title="拆單"><button type="button" class="btn btn-danger">確定拆單
</button></a>&nbsp;&nbsp;
<a href="javascript:void(0);" onclick="cancelsplit();
    return false;" title="取消"><button type="button" class="btn btn-active">取消
</button></a>
<br/><br/>

';
for($i=1;$i<=10;$i++):
    echo '<div class="form-group">';
    echo '<div class="col-sm-1 text-right">欲將數量</div>';
    echo '<div class="col-sm-1"><input class="form-control" type="text" id="num'.$i.'" name="num'.$i.'" value="0"></div>';
    echo '<div class="col-sm-2 text-left">拆成另一筆</div>';
    echo '<div class="col-sm-8">&nbsp;</div>';
    echo '</div>';
endfor;
echo '
<input type="hidden" id="split_id" name="split_id">
<input type="hidden" id="split_num" name="split_num">
</div>
</div>
';
?>
<script>
    function cancelsplit() {
        $('#split_list').attr('style','display:none;');
        $('#split_id').val('');
    }
    function isNumber(val) {   
        var reg = /^[0-9]*$/;
        return reg.test(val);
    }

    function checksplit() {
        if (!isNumber($('#num1').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.getElementById("num1").focus();
            return false;
        }
        if (!isNumber($('#num2').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num2.focus();
            return false;
        }
        if (!isNumber($('#num3').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num3.focus();
            return false;
        }
        if (!isNumber($('#num4').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num4.focus();
            return false;
        }
        if (!isNumber($('#num5').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num5.focus();
            return false;
        }
        if (!isNumber($('#num6').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num6.focus();
            return false;
        }
        if (!isNumber($('#num7').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num7.focus();
            return false;
        }
        if (!isNumber($('#num8').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num8.focus();
            return false;
        }
        if (!isNumber($('#num9').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num9.focus();
            return false;
        }
        if (!isNumber($('#num10').val())) {
            alertify.error('欲拆單的數量含有非數字字元,請您檢查！');
            document.form1.num10.focus();
            return false;
        }
        var all = 0;
        for (var i = 1; i <= 10; i++) {
            tmp = 'num'+i;
            if(parseInt(document.getElementById(tmp).value)>0){
                all = all + parseInt(document.getElementById(tmp).value);
            }
        }
        var split_num = parseInt($('#split_num').val());
        var tmp_num = split_num - all;
        if (parseInt(tmp_num) != 0) {
            alertify.error('欲拆單的數量不等於訂購數量！');
            document.form1.num1.focus();
            return false;
        }
        var id = $('#split_id').val();
        if (confirm("一旦拆單即無法復原，請確認？")) {
            $.ajax({
                type: "POST",
                url: "split_orders_item.php",
                data: {num1:$('#num1').val(),num2:$('#num2').val(),num3:$('#num3').val(),num4:$('#num4').val(),num5:$('#num5').val(),num6:$('#num6').val(),num7:$('#num7').val(),num8:$('#num8').val(),num9:$('#num9').val(),num10:$('#num10').val(),id:id},
                success: function (data) {
                    window.location.reload();
                    alertify.success('拆單成功！');
            }, beforeSend: function () {
            }, complete: function () {
            }})
        }
    }
</script>
