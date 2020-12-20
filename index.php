<?php
require 'public_include.php';
$data = array('status' => '1', 'ishot' => '1');
$product = $db->select('product', $data, 'sort', DESC, 4);
$i = 0;
foreach ($product as $products):
    if (Func::check_shelf($products['onshelf'], $products['offshelf']) == 1):
        $id_list[$i] = $products['id'];
        $i++;
    endif;
endforeach;
$id_list = implode(',', $id_list);
$andSQL = "ORDER BY sort ASC,id DESC";
if ($id_list == '') {
    $strSQL = "SELECT * FROM `product` WHERE id IN (0) " . $andSQL;
} else {
    $strSQL = "SELECT * FROM `product` WHERE id IN ($id_list) " . $andSQL;
}
$Hot_product = $db->Execute($strSQL);
$data = array('status' => '1');
$index_banner = $db->select('index_banner', $data, 'sort', 'DESC');
$data = array('status' => '1', 'isindex' => '1');
$news = $db->select('news', $data, 'create_date', 'DESC', 4);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php';?>
	<link rel="stylesheet" type="text/css" href="js/lib/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="js/lib/slick/slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>
<body class="page-index sr">
	<?php include 'include/header.php';?>
	<div class="idxHero main">
		<img src="images/index/idxHero_txt.png" class="idxHero__txt">
		<div class="js-idxHeroSlider">
			<?php foreach ($index_banner as $index_banners): ?>
				<div style="background-image: url(webimages/<?=$index_banners['img']?>);"><img src="webimages/<?=$index_banners['img']?>"></div>
			<?php endforeach;?>
		</div>
		<a href="#idxPro" class="idxHero__scroll smooth">
			<div class="arrow"><img src="images/index/idxHero_scroll.png"></div>
			<img src="images/index/scroll_txt.png">
		</a>
	</div>
	<!-- idxPro -->
	<div id="idxPro" class="idxPro block">
		<div class="idxPro__container container">
			<div class="idxPro__list">
				<?php
$i = 0;
foreach ($Hot_product as $Hot):
?>
					<div class="idxProItem">
						<div class="idxProItem__pic">
							<img src="webimages/<?=$Hot['img']?>" alt="">
						</div>
						<div class="idxProItem__sale">熱門商品</div>
						<div class="idxProItem__dec"><?=$Hot['title']?></div>
						<?php
$strSQL = "SELECT * FROM `list_class_detail` WHERE templet_id = '" . $Hot['id'] . "' AND class_id != '0' ORDER BY class_id ASC LIMIT 1";
$class_id = $db->Execute($strSQL);
?>
						<img src="images/babycakes/proHoverTxt.png" class="idxProItem__hover">
						<?php if ($class_id[0]['class_id'] == 9): ?>
							<a href="https://shop.mousecake.com.tw/baby_products_view.php?class_id=<?=$class_id[0]['class_id']?>&id=<?=$Hot['id']?>"  target="_blank" class="idxProItem__link">熱門商品</a>
						<?php else: ?>
							<a href="https://shop.mousecake.com.tw/products_view.php?class_id=<?=$class_id[0]['class_id']?>&id=<?=$Hot['id']?>" target="_blank" class="idxProItem__link">熱門商品</a>
						<?php endif;?>
					</div>
					<?php
$i++;
if ($i == 2):
?>
					<div class="idxPro__hot">
						<img src="images/index/idxPro_dec.png" class="idxPro__dec">
						<h3>
							<span class="tw">熱賣商品</span>
							<span class="jp">ホットアイテム</span>
						</h3>
						<div class="idxPro__hotPc">
							<a href="https://shop.mousecake.com.tw/" target="_blank" class="idxPro__go">GO SHOP NOW</a>
						<div class="idxPro__or">OR</div>
							<a href="https://shop.mousecake.com.tw/" target="_blank" class="idxPro__view">VIEW MORE</a>
						</div>
					</div>
				<?php
endif;
endforeach;
?>
			</div>
			<!-- idxFood -->
			<div class="idxFood">
				<div class="idxFood__col"><img src="images/index/idxFood_pic1.jpg"></div>
				<div class="idxFood__col">
					<div class="idxFood__info">
						<h3>嚴選食材</h3>
						<p>來自北海道道南地區<br class="br" />100%鮮奶製成的奶油乳酪、<br class="br" />嚴選日本紫羅蘭低粉與頂級法國奶油<br class="br" />讓輕熟乳酪口感綿密、香氣濃烈</p>
						<a href="about.php" class="idxFood__more">了解更多</a>
					</div>
					<img src="images/index/idxFood_pic2.jpg">
				</div>
				<img src="images/index/idxFoods_dec1.png" class="idxFood__dec1">
				<img src="images/index/idxFoods_dec2.png" class="idxFood__dec2">
			</div>
		</div>
	</div>
	<!-- idxAbout -->
	<div class="idxAbout block">
		<div class="idxAbout__container container">
			<div class="idxAbout__con">
				<div class="idxAbout__tit">
					<h3>
						<span class="tw">關於杏屋</span>
					</h3>
					<p>小杏就和其他小老鼠一樣，喜歡乳酪、而且怕貓咪！<br class="br" />他總是趁貓咪午睡的時候，在貓咪的家裡四處找乳酪，<br class="br" />拼拼湊湊、拼拼湊湊，總算組成了自己的乳酪小屋……。</p>
					<a href="about.php" title="了解更多" class="idxAbout__btn">了解更多</a>
				</div>
			</div>
			<div class="idxAbout__dec idxAbout__left"><img src="images/index/idxAbout_dec_l.png" alt=""></div>
			<div class="idxAbout__dec idxAbout__top"><img src="images/index/idxAbout_dec_t.png" alt=""></div>
			<div class="idxAbout__dec idxAbout__right"><img src="images/index/idxAbout_dec_r.png" alt=""></div>
			<div class="idxAbout__dec idxAbout__bottom"><img src="images/index/idxAbout_dec_b.png" alt=""></div>
		</div>
	</div>
	<div class="container">
		<!-- idxNews -->
		<div class="idxNews block">
			<h2 class="idxNews__hd">
				<div class="idxNews__tit">
					<span class="tw">最新消息</span>
					<span class="jp">イベント</span>
				</div>
				<a href="news.php" class="idxNews__more" title="了解更多">了解更多 </a>
			</h2>
			<?php foreach ($news as $new): ?>
			<div class="idxNewsItem">
				<div class="idxNewsItem__img">
					<a href="news_view.php?id=<?=$new['id']?>"><img src="webimages/<?=$new['img']?>" alt=""></a>
				</div>
				<div class="idxNewsItem__info">
					<div class="idxNewsItem__date">
						<span><i><?=date('Y', $new['create_date'])?></i><br/>公告時間</span>
						<span><?=date('m/d', $new['create_date'])?></span>
					</div>
					<div class="idxNewsItem__con">
						<h3><a href="news_view.php?id=<?=$new['id']?>" title="\ <?=$new['title']?> /">\ <?=$new['title']?> /</a></h3>
						<div><?=nl2br($new['overview'])?></div>
						<a href="news_view.php?id=<?=$new['id']?>" title="\ <?=$new['title']?> /" class="idxNewsItem__btn">〔   <span>M O R E</span>   〕</a>
					</div>
				</div>
			</div>
			<?php endforeach;?>
			<div class="idxNews__ft"></div>
		</div>
		<!-- idxApply -->
		<div class="idxApply block">
			<div class="idxApply__tit">
				<img src="images/index/idxApply_dec.png" alt="" class="idxApply__dec">
				<h3>
					<span class="tw">彌月蛋糕</span>
					<span class="jp">幸福からの贈り物</span>
				</h3>
				<p>每一位大人都是當年的新生兒，每一個新生兒都代表著未來。<br class="br" /><span>杏屋以踏實的方式慶賀生命的延續，慎選食材，不使用人工化學添加物，只以食物製作食物，<br class="br" />希望用好吃又讓人安心的彌月蛋糕，承載為人父母的喜悅送給大家。</span></p>
				<a href="apply.php" title="彌月試吃申請" class="idxApply__btn">彌月試吃申請</a>
			</div>
		</div>
	</div>
	<?php include 'include/footer.php';?>
	<?php include 'include/f2e.php';?>
	<script type="text/javascript" src="js/lib/slick/slick.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.js-idxHeroSlider').slick({
				infinite: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				autoplay: true,
				dots: true,
				arrows: false,
				draggable: false,
				speed: 500,
				fade: true,
				cssEase: 'linear'
			});
			// $(window).load(function() {
			// 	$('body').addClass('is-ready');
			// });
		});
	</script>
</body>
</html>