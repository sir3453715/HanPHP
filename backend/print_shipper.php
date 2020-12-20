<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-TW" xml:lang="zh-TW"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	require('public_include.php');
  $sn = $_GET["sn"];
  $strSQL = "SELECT * FROM orders WHERE sn='$sn'";
  $orders = $db->Execute($strSQL);
?>
<style type="text/css">
.tl, .tr {
border:#3F3F3F 2px solid;
}
.tl td {
	text-align:center;
	padding:4px 2px;
	border:#5E5E5E 1px solid;
}
.tl tr {
}
.tr td{
	font-size:12px;
}
.tr .note span{
font-size:10px;
}
</style>
<script src="assets/js/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script> 
<body>
<div id="print_range">
<span style="height:70px;"><h1>購物訂單&nbsp;&nbsp;列表日:<?=date("Y-m-d")?></h1></span>

<div class="div1"><table width="100%">
    <tbody><tr><td valign="top" width="70%">
<table width="100%" cellspacing="0" class="tl">
  <tbody><tr>
    <td width="18%">訂單號碼</td>
    <td width="32%" colspan="2"><?=$orders[0]['seccode']?></td>
    <td width="18%" rowspan="2">訂單日期</td>
    <td width="32%" rowspan="2" colspan="2"><?=date('Y',$orders[0]['addtime'])?>年<?=date('m',$orders[0]['addtime'])?>月<?=date('d',$orders[0]['addtime'])?>日</td>
  </tr>
  <tr>
    <td><font size="2">訂單流水號</font></td>
    <td colspan="2"><?=substr(date('Y',$orders[0]['addtime']),2,2).date('md',$orders[0]['addtime']).sprintf("%05d", $orders[0]['number'])?></td>
  </tr>
  <tr>
    <td><font size="2">收件人姓名</font></td>
    <td colspan="2"><?=$orders[0]['for_name']?></td>
    <td>會員姓名</td>
    <td colspan="2"><?=$orders[0]['payer_name']?></td>
  </tr>
  <tr>
    <td><font size="2">收件人手機</font></td>
    <td colspan="2"><?=trim(Encryption::ZxingCrypt($orders[0]['for_phone'],"DECODE"))?></td>
    <td>會員手機</td>
    <td colspan="2"><?=trim(Encryption::ZxingCrypt($orders[0]['payer_phone'],"DECODE"))?></td>
  </tr>
  <tr>
    <td><font size="2">收件人電話</font></td>
    <td colspan="2"></td>
    <td>會員電話</td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <?php
      if($orders[0]['payment']!='實體店面取貨付款'):
    ?>
      <td>配送地址</td>
      <td colspan="5"><?=trim(Encryption::ZxingCrypt($orders[0]['for_address'],"DECODE"))?></td>
    <?php 
      else:
    ?>
      <td>取貨店面</td>
      <td colspan="5"><?=$orders[0]['pickup_store']?></td>
    <?php endif;?>
  </tr>
  <tr>
      <td>取貨時間</td>
      <td colspan="5"><?=$orders[0]['pickup_date']." ".$orders[0]['pickup_time']?></td>
  </tr>
  <tr>
    <?php
      if($orders[0]['payment']!='信用卡線上刷卡'):
    ?>
      <td>配送地址</td>
      <td colspan="5"><?=trim(Encryption::ZxingCrypt($orders[0]['for_address'],"DECODE"))?></td>
    <?php 
      else:
    ?>
      <td>取貨店面</td>
      <td colspan="5"><?=$orders[0]['pickup_store']?></td>
    <?php endif;?>
  </tr>
  <tr>
    <td>帳單地址</td>
    <td colspan="5"></td>
  </tr>
  <?php 
    switch ($orders[0]['ticktype']) {
      case 0:
          $tick = '捐贈發票';
        break;
      case 1:
          $tick = '個人(二聯式發票)';
        break;
      case 2:
          $tick = '三聯式發票';
        break;
    }
  ?>
  <tr>
    <td>發票類型</td>
    <td colspan="5"><?=$tick?></td>
  </tr>
  <?php if($orders[0]['ticktype']=='2'):?>
  <tr>
    <td>公司抬頭</td>
    <td colspan="2"><?=$orders[0]['tickName']?></td>
    <td>統一編號</td>
    <td colspan="2"><?=$orders[0]['tickNo']?></td>
  </tr>
  <?php endif;?>
  <tr>
    <td>付款方式</td>
    <td colspan="3"><?=$orders[0]['payment']?></td>
    <td colspan="2"><font size="4">☐</font>&nbsp;已付款</td>
  </tr>
  <tr>
    <td><b>類 型</b></td>
    <td colspan="2"><b>商 品 名 稱</b></td>
    <td><b>數 量</b></td>
    <td><b>單 價</b></td>
    <td><b>總 計</b></td>
  </tr>
<?php
	//訂單明細
  $strSQL = "select * from orders_item where order_sn = '$sn'";    
  $orders_items = $db->Execute($strSQL);
  foreach ($orders_items as $orders_item)
    {
?>
    <tr>    
		<td>
    <?php
      if($orders_item['ipp']==1){
        echo '加價購商品';
      }else if($orders_item['ipp']==2){
        echo '滿額贈商品';
      }else{
        echo '購買商品';
      }
    ?>
    </td>
		<td colspan="2"><?=$orders_item['name']?></td>
		<td><?=$orders_item['num']?></td>
		<td>$<?=number_format($orders_item['price'])?></td>
		<td>$<?=number_format($orders_item['num']*$orders_item['price'])?></td>
	</tr>
<?php  
$stot += $orders_item['price'] * $orders_item['num'];
  }
?>
  <tr>
    <td colspan="5" style="text-align:right;"><b>商品總計</b></td>
    <td>$<?=number_format($stot)?></td>
	<?php //2016/11/28 lota fix 原總計金額顯示總金額 + 紅利折扣金額 ，已修改為目前總金額 ?>
  </tr>
  <?php if($orders[0]['cash_discount']!=0):?>
  <tr>
    <td colspan="5" style="text-align:right;"><b>滿額現折</b></td>
    <td><?=number_format($orders[0]['cash_discount'])?>折</td>
  </tr>
  <?php endif; if($orders[0]['coupon_discount']!=0):?>
  <tr>
    <td colspan="5" style="text-align:right;"><b>優惠券折扣</b></td>
    <td><?=number_format($orders[0]['coupon_discount'])?>折</td>
  </tr>
  <?php endif; if($orders[0]['full_station_discount']!=0):?>
  <tr>
    <td colspan="5" style="text-align:right;"><b>全站折扣</b></td>
    <td><?=number_format($orders[0]['full_station_discount'])?>折</td>
  </tr>
  <tr>
  <?php endif;?>
    <td colspan="5" style="text-align:right;"><b>運費</b></td>
    <td>$<?=number_format($orders[0]['ship'])?></td>
  </tr>
    	<tr>
    <td colspan="5" style="text-align:right;"><b>總計</b></td>
    <td>$<?=number_format($orders[0]['total'])?></td>
  </tr>
  <tr>
    <td height="220" colspan="6" valign="top" style="text-align:left;"><b>備註</b><br>
      <?=nl2br($orders[0]['note'])?>
    </td>
  </tr>
  <tr>
    <td><font size="2">繳費單資料</font></td>
	<td colspan="5"></td> </tr>
</tbody></table></td>
</div>
</div>
</body>
<script language="javascript" type="text/javascript">
    $(window).load(function() {
      print();
    })
</script>
</html>