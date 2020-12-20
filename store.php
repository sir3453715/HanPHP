<?php
require 'public_include.php';
$data = array('status' => '1');
$stores = $db->select('store', $data, 'sort', 'desc');
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php';?>
</head>
<body class="page-store">
	<?php include 'include/header.php';?>
	<div class="pgHero" style="background-image: url(images/store/store_bg.jpg);">
		<div class="pgHero__con">
			<div class="pgHero__intro">
				<img src="images/comm_dec_black.png" alt="" class="aboutDec01">
				<img src="images/store/dec_store.png" alt="" class="pgHero__decMain">
				<h2 class="pgHero__tit">
					<span class="tw">銷售據點</span>
					<span class="jp">ショップガイド</span>
				</h2>
				<p>三五好友相聚一起，趁貓咪午睡的時候，來杏屋找乳酪！<br />第一家、第二家、第三家，吃得好飽好飽～<br />什麼！竟然被喵咪發現了！</p>
			</div>
		</div>
	</div>
	<div class="main store">
		<div class="container">
			<div class="storeList">
				<?php foreach ($stores as $store): ?>
				<div class="storeItem">
					<div class="storeItem__pic">
						<img src="webimages/<?=$store['img']?>" alt="">
						<div class="storeItem__click"><img src="images/store/btn_click.png"></div>
						<div class="storeItem__zoom"><img src="images/store/icon_zoom.png"></div>
						<a href="https://maps.google.com.tw/maps?f=q&hl=zh-TW&q=<?=$store['address']?>&z=16" target="_blank">&nbsp;</a>
					</div>
					<div class="storeItem__bd">
						<div class="storeItem__title"><?=$store['title']?></div>
						<div class="storeItem__info">
							<span>| 營業時間 |</span>
							<ul>
								<li><?=nl2br($store['hours'])?></li>
								<li><i><img src="images/store/icon_add.png"></i> <?=$store['address']?><br /><?=$store['address_note']?></li>
								<li><i><img src="images/store/icon_tel.png"></i> <?=$store['tel']?></li>
							</ul>
						</div>
					</div>
				</div>
				<?endforeach;?>
				<img src="images/store/dec01.png" class="dec dec01">
				<img src="images/store/dec02.png" class="dec dec02">
				<img src="images/store/dec03.png" class="dec dec03">
			</div>
		</div>
	</div>
	<?php include 'include/footer.php';?>
	<?php include 'include/f2e.php';?>
</body>
</html>