<?php
require('public_include.php');
$class_id = '9';
$data = array('class_id'=>$class_id);
$list_class_detail = $db->select('list_class_detail',$data);

foreach ($list_class_detail as $list_class_details) {
	$fin_class_id .= $list_class_details['templet_id'].',';
}
$fin_class_id = substr($fin_class_id, 0, -1);
if($fin_class_id!=''){
	$strSQL = "SELECT * FROM `product` WHERE status='1'  AND id IN ($fin_class_id) ORDER BY sort ASC,id DESC";	
}else{
	$strSQL = "SELECT * FROM `product` WHERE status='1'  AND id IN (0) ORDER BY sort ASC,id DESC";
}
$product = $db->Execute($strSQL);
$i=0;
foreach ($product as $products) :
  if(Func::check_shelf($products['onshelf'],$products['offshelf'])==1):
      $id_list[$i] = $products['id'];
      $i++;
  endif;
endforeach;
$id_list = implode(',', $id_list);
$andSQL = "ORDER BY sort ASC,id DESC";
if($id_list==''){
  $strSQL = "SELECT * FROM `product` WHERE id IN (0) ".$andSQL;
}else{
  $strSQL = "SELECT * FROM `product` WHERE id IN ($id_list) ".$andSQL;
}
// echo $strSQL;
$baby_product = $db->Execute($strSQL);

$data = array('status'=>'1');
$card_set = $db->select('card_set',$data,'sort',DESC);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php'; ?>
</head>
<body class="page-babycakes">
	<?php include 'include/header.php'; ?>
	<div class="pgHero" style="background-image: url(images/babycakes/babycakes_bg.jpg);">
		<div class="pgHero__con">
			<div class="pgHero__intro">
				<img src="images/about/dec_01.png" alt="" class="aboutDec01">
				<img src="images/babycakes/dec_babycakes.png" alt="" class="pgHero__decMain">
				<h2 class="pgHero__tit">
					<span class="tw">彌月專區</span>
					<span class="jp">満月のケーキ</span>
				</h2>
				<p>每一位大人都是當年的新生兒，每一個新生兒都代表著未來。<br />杏屋以踏實的方式慶賀生命的延續，慎選食材，<br />希望用好吃又讓人安心的彌月蛋糕，承載為人父母的喜悅送給大家。</p>
			</div>
			<!--  is-active -->
			<div class="pgHero__aside aside">
				<a href="#gift" title="彌月蛋糕禮盒" class="link1 aside__link smooth">彌月蛋糕禮盒</a>
				<a href="#card" title="彌月小卡" class="link2 aside__link smooth">彌月小卡</a>
				<a href="#apply" title="試吃申請" class="link3 aside__link smooth">試吃申請</a>
			</div>
		</div>
		<img src="images/babycakes/dec_02.png" alt="" class="babycakesDec02">
	</div>
	<div class="main babycakes">
		<div id="gift" class="babycakesGift">
			<div class="container">
				<div class="babycakesGift__tit">
					<img src="images/babycakes/dec_gift.png" alt="" class="babycakesGift__dec">
					<h3>
						<span class="tw">彌月蛋糕禮盒</span>
						<span class="jp">幸福からの贈り物</span>	
					</h3>
					<p>孩子，是天使捎來世上，最純淨無暇的禮物。<br />杏屋提供最佳的彌月蛋糕禮盒，讓我們與孩子濡染著未曾擁有的喜悅及幸福。</p>
					<a href="https://shop.mousecake.com.tw/baby_products.php" target="_blank" title="彌月訂購方案" class="babycakesGift__btn">彌月訂購方案</a>
				</div>
				<a href="https://shop.mousecake.com.tw/baby_products.php" target="_blank" class="babycakesGift__more" title="VIEW MORE CAKES">VIEW MORE CAKES</a>
				<div class="babycakesGift__pro">
					<?php foreach($baby_product as $baby_products): ?>
					<div class="babycakesProItem">
						<div class="babycakesProItem__pic">
							<img src="webimages/<?=$baby_products['img']?>" alt="">
						</div>
						<div class="babycakesProItem__tit"><?=$baby_products['title']?></div>
						<div class="babycakesProItem__price">NT <?=$baby_products['original_price']?></div>
						<img src="images/babycakes/proHoverTxt.png" class="babycakesProItem__hover">
						<a href="https://shop.mousecake.com.tw/baby_products_view.php?class_id=<?=$class_id?>&id=<?=$baby_products['id']?>" target="_blank" class="babycakesProItem__link"><?=$baby_products['title']?></a>
					</div>
					<? endforeach; ?>
				</div>	
			</div>
		</div>
		<!-- babycakesCard -->
		<div id="card" class="babycakesCard">
			<div class="container">
				<div class="babycakesCard__tit">
					<img src="images/babycakes/dec_card.png" alt="" class="babycakesCard__dec">
					<h3>
						<span class="tw">彌月小卡</span>
						<span class="jp">満月カード</span>	
					</h3>
					<p><i>彌月禮盒訂購滿60盒，即可免費製作「彌月小卡」</i><br class="br" />我們替你準備了可愛的彌月小卡，你可以選擇孩子最可愛的一張照片<br class="br" />並寫下對他最真摯的祝福，與所有的親朋好友一同分享喜獲麟兒的喜悅</p>
				</div>
				<div class="babycakesCard__list">
					<?php 
						foreach($card_set as $card_sets ):
					?>
					<div class="cardItem">
						<div class="cardItem__pic"><img src="webimages/<?=$card_sets['web_img']?>" alt="因愛誕生"></div>
						<div class="cardItem__tit"><?=$card_sets['title']?></div>
						<ul class="cardItem__color">
						</ul>
						<div class="cardItem__intro">
							<?=$card_sets['content']?>
						</div>
					</div>
						<?php endforeach;?>
				</div>
				<div class="babycakesCard__control">
					<a href="#gift" class="babycakesCard__btn smooth" title="訂購彌月禮盒">訂購彌月禮盒</a>
					<a href="apply.php" class="babycakesCard__btn" title="試吃申請">試吃申請</a>
				</div>
			</div>
		</div>
		<!-- babycakesApply -->
		<div id="apply" class="babycakesApply">
			<div class="container">
				<div class="babycakesApply__tit">
					<img src="images/babycakes/dec_apply.png" alt="" class="babycakesApply__dec">
					<h3>
						<span class="tw">試吃申請</span>
						<span class="jp">試しに応募する</span>	
					</h3>
					<p>恭喜您的寶貝即將到來，在此獻上我們滿滿的祝福<br />感謝您的喜愛，誠摯地歡迎您親臨門市品鑑，或線上申請宅配試吃品鑑</p>
				</div>
				<div class="babycakesApply__list applyList">
					<div class="applyList__col">
						<div class="applyList__item">
							<div class="applyList__left">
								<span>01</span>
								<span>彌月試吃<br />條件</span>
							</div>
							<div class="applyList__right">
								<p>孕期滿28週的媽咪</p>
								<div class="shopInfo">
									<div>(須附媽咪手冊，每本手冊限申請乙次,每位新生寶貝限兌換一次)</div>
								</div>
							</div>
						</div>
						<div class="applyList__item">
							<div class="applyList__left">
								<span>02</span>
								<span>試吃品項<br />與優惠</span>
							</div>
							<div class="applyList__right">
								<p>商品任選，每種商品限購一盒，以商品原價8折計算。</p>
							</div>
						</div>
					</div>
					<div class="applyList__col applyList__col--2">
						<div class="applyList__item">
							<div class="applyList__left">
								<span><img src="images/babycakes/icon_shop.png"></span>
								<span>店面試吃<br />方式</span>
							</div>
							<div class="applyList__right">
								<p>可由專人為顧客服務解說及試吃，亦可以8折優惠購買蛋糕</p>
								<div class="shopInfo">
									<div>試吃門市：</div><div><a href="store.php">台中黎明店</a>、<a href="store.php">大甲鎮瀾店</a>、<a href="store.php">台中新光店</a></div>
								</div>
							</div>
						</div>
						<div class="applyList__item">
							<div class="applyList__left">
								<span><img src="images/babycakes/icon_ship.png"></span>
								<span>宅配試吃<br />方式</span>
							</div>
							<div class="applyList__right">
								<p>蛋糕價格8折優惠，運費另計。<br /></p>
								<div class="shopInfo">
									<div>付款方式：ATM轉帳及貨到付款</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="babycakesApply__control">
					<a href="apply.php" class="babycakesApply__btn" title="我要試吃">我要試吃</a>
				</div>
			</div>
		</div>
	</div>
	<?php include 'include/footer.php'; ?>
	<?php include 'include/f2e.php'; ?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/ScrollMagic.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js"></script>
	<script>
		$(document).ready(function(){
		  	var controller = new ScrollMagic.Controller();
			var newToggle = new ScrollMagic.Scene({
				duration: '100%'
			})
			.addTo(controller)
			.triggerElement(".babycakesGift")
			.triggerHook(.5);
			// .reverse(false);
			// .addIndicators();
			newToggle.on("end", function (e) {
				$(".globleAside").toggleClass("is-top")
			});
			new ScrollMagic.Scene({
					triggerElement: "#gift",
					duration : $('#gift').outerHeight(true)
				})
				.triggerHook(.5)
				.setClassToggle(".link1", "is-active")
				// .addIndicators()
				.addTo(controller);
			new ScrollMagic.Scene({
					triggerElement: "#card",
					duration : $('#card').outerHeight(true)
				})
				.triggerHook(.5)
				.setClassToggle(".link2", "is-active")
				// .addIndicators()
				.addTo(controller);
			new ScrollMagic.Scene({
					triggerElement: "#apply",
					duration : $('#apply').outerHeight(true)
				})
				.setClassToggle(".link3", "is-active")
				// .addIndicators()
				.addTo(controller);
		});
	</script>
</body>
</html>