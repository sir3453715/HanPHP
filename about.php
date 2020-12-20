<?php
require 'public_include.php';
$strSQL = "SELECT * FROM `about` ORDER BY create_date DESC";
$about = $db->Execute($strSQL);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php';?>
</head>
<body class="page-about">
	<?php include 'include/header.php';?>
	<div class="pgHero" style="background-image: url(images/about/about_bg.jpg);">
		<div class="pgHero__con">
			<div class="pgHero__intro">
				<img src="images/about/dec_01.png" alt="" class="aboutDec01">
				<img src="images/about/dec_about.png" alt="" class="pgHero__decMain">
				<h2 class="pgHero__tit">
					<span class="tw">關於杏屋</span>
					<span class="jp">ブランド</span>
				</h2>
				<p>小杏就和其他小老鼠一樣，喜歡乳酪、而且怕貓咪！<br />他總是趁貓咪午睡的時候，在貓咪的家裡四處找乳酪，<br />拼拼湊湊、拼拼湊湊，總算組成了自己的乳酪小屋……。</p>
			</div>
			<div class="pgHero__aside aside">
				<a href="#brandStore" title="品牌故事" class="aside__link smooth link1">品牌故事</a>
				<a href="#brandKitchen" title="小杏與喵喵廚房" class="aside__link smooth link2">小杏與喵喵廚房</a>
				<a href="#brandHistory" title="小杏足跡" class="aside__link smooth link3">小杏足跡</a>
			</div>
		</div>
	</div>
	<div class="main about">
		<!-- brandStore -->
		<div id="brandStore" class="brandStore block">
			<div class="brandStore__container container">
				<div class="brandStore__con">
					<h3>
						<span class="tw">品牌故事</span>
						<span class="jp">ブランドストーリー</span>
					</h3>
					<p>乳酪屋上有一個小巧的晒衣場，<br />小杏特別喜歡在早上洗衣服，<br class="showMobile" />把濕濕的上衣晾在屋頂上，<br />清晨微微的風穿透了院子裡的銀杏樹，<br class="showMobile" />風把秋意吹到了衣服上，<br />不但把上衣蔭的乾乾爽爽，<br class="showMobile" />還能有淡淡的銀杏葉味道。</p>
					<p>對小杏來說，生活每天都是一成不變，<br class="showMobile" />在清晨晾衣服、在午休時刻偷搬乳酪、<br />趁著夜晚貓咪溜出去玩的時候，<br class="showMobile" />壯大自己的乳酪小屋。<br />也許日子過的很平凡，但小杏覺得，<br />每天睜開眼都能夠簡單的生活著，<br class="showMobile" />就是一種小確幸。</p>
				</div>
				<div class="brandStore__dec brandStore__left"><img src="images/index/idxAbout_dec_l.png" alt=""></div>
				<div class="brandStore__dec brandStore__top"><img src="images/about/idxAbout_dec_t.png" alt=""></div>
				<div class="brandStore__dec brandStore__right"><img src="images/index/idxAbout_dec_r.png" alt=""></div>
				<div class="brandStore__dec brandStore__bottom"><img src="images/about/idxAbout_dec_b.png" alt=""></div>
			</div>
		</div>
		<!-- brandKitchen -->
		<div id="brandKitchen" class="brandKitchen block">
			<div class="brandKitchen__container container">
				<div class="brandKitchen__con">
					<div class="brandKitchen__intro">
						<img src="images/about/brandKitchen_dec.png" alt="" class="brandKitchen__dec">
						<h3>
							<span class="tw">小杏與喵喵廚房</span>
							<span class="jp">成分の厳選</span>
						</h3>
						<p>來自北海道道南地區，100%鮮奶製成的奶油乳酪、<br />嚴選日本特產三溫糖、HACCP認證殺菌蛋液、進口純牛乳<br />讓輕熟乳酪口感綿密、香氣濃烈……</p>
					</div>
					<div class="brandKitchen__spcial">
						<img src="images/about/brandKitchen_p1.jpg" alt="北海道乳酪">
						<img src="images/about/brandKitchen_p2.jpg" alt="輕熟乳酪蛋糕">
						<img src="images/about/brandKitchen_p3.jpg" alt="日本三溫糖">
						<img src="images/about/brandKitchen_p4.jpg" alt="日本紫羅蘭低粉、頂級法國奶油">
					</div>
				</div>
			</div>
			</div>
		</div>
		<!-- brandHistory -->
		<div id="brandHistory" class="brandHistory block">
			<div class="brandHistoryainer container">
				<div class="brandHistory__con">
					<div class="brandHistory__intro">
						<img src="images/about/brandHistory_dec.png" alt="" class="brandHistory__dec">
						<h3>
							<span class="tw">小杏足跡</span>
							<span class="jp">アンズヤの足跡</span>
						</h3>
					</div>
					<div class="brandHistory__list">
						<!-- brandHistoryItem -->
						<div class="brandHistoryItem">
							<div class="brandHistoryItem__pic">
								<img src="images/about/brandHistory_pic1.jpg" alt="">
							</div>
							<ul class="brandHistoryItem__list">
								<li>
									<span class="date">2018年09月</span><span>榮登「巷弄」APP網路人氣少女系夢幻甜點</span>
									<p>杏屋非常榮幸登上「巷弄」APP的美食店家介紹，女神安苡愛－小愛光臨杏屋囉！非常開心她也很愛我們家的蛋糕呢～吃了會變跟女神ㄧ樣美哦！小愛真心推薦<a href="https://drive.google.com/open?id=151i8nnpeXiWJ17V0otYv-HYO7HdaAFgM">https://drive.google.com/open?id=151i8nnpeXiWJ17V0otYv-HYO7HdaAFgM</a></p>
								</li>
								<li>
									<span class="date">2018年07月</span><span>新竹巨城店開幕</span>
									<p>小杏第四個家盛大開幕拉！在新竹遠東巨城３樓落腳，迫不及待認識新竹的朋友了！喵和小杏在現場等你們，歡迎來找我們合照噢！</p>
								</li>
								<li>
									<span class="date">2018年03月</span><span>受邀電視節目－太太狠犀利</span>
									<p>杏屋的彌月蛋糕很榮幸受邀到太太狠犀利的節目，在節目上跟大家一起分享小杏的乳酪蛋糕，希望能將乳酪蛋糕的美味與彌月蛋糕的喜悅，一起分享給更多的人並且能將這個好味道傳承下去～</p>
								</li>
							</ul>
						</div>
						<div class="brandHistoryItem">
							<div class="brandHistoryItem__pic">
								<img src="images/about/brandHistory_pic2.jpg" alt="">
							</div>
								<ul class="brandHistoryItem__list">
									<li>
										<span class="date">2017年12月</span><span>杏屋在食尚玩家裡播出!</span>
										<p>小杏上電視啦！喵喵說還蠻上鏡的呢！！感謝食尚玩家的採訪，小杏全程目不轉睛的盯著主持人呢~快追隨楊子儀的腳步來找小杏吃爆漿乳酪蛋糕，不同於其他的乳酪蛋糕～</p>
									</li>
									<li>
										<span class="date">2017年08月</span><span>蘋果日報的報導</span>
										<p>日報表示：改裝後的杏屋創始店，增加了許多超萌小物，好適合拍照！杏屋店內布置中還注入更多乳酪與老鼠的俏皮元素，讓吃甜點這件事變得更有趣。</p>
									</li>
									<li>
										<span class="date">2017年08月</span><span>台中新光三越 新光店開幕</span>
										<p>為了我們第三個家整理到好晚呀！歡迎大家來我們家坐坐了！【小杏和喵喵の第三個家】來這裡～台中新光三越百貨B2F！週末假期何處去？快來杏屋乳酪蛋糕台中新光店</p>
									</li>
								</ul>
							</div>
							<div class="brandHistoryItem">
								<div class="brandHistoryItem__pic">
									<img src="images/about/brandHistory_pic3.jpg" alt="">
								</div>
								<ul class="brandHistoryItem__list">
									<li>
										<span class="date">2016年04月</span><span>非凡大探索採訪</span>
										<p>小杏又上電視了！感謝非凡大探索的採訪，感受【下重本的北海道乳酪】爆漿口感滑順綿密～小杏上電視的影片在這邊 <a href="https://youtu.be/PrOODHZuc-4">https://youtu.be/PrOODHZuc-4</a></p>
									</li>
									<li>
										<span class="date">2014年12月</span><span>台中大甲店開幕</span>
										<p>杏屋第二個家正式開幕，台中大甲店設有內用作位，在大甲給大家超好吃的甜點美食，小杏與喵在此為大甲的朋友服務！</p>
									</li>
									<li>
										<span class="date">2014年02月</span><span>網路商店開幕</span>
										<p>2014年2月杏屋歡慶網路商店開幕～懶得出門在家溜溜滑鼠、滑滑手機，下單享有宅配服務超方便的！</p>
									</li>
								</ul>
							</div>
								<div class="brandHistoryItem">
									<div class="brandHistoryItem__pic">
										<img src="images/about/brandHistory_pic4.jpg" alt="">
									</div>
									<ul class="brandHistoryItem__list">
										<li>
											<span class="date">2014年02月</span><span>登上YAHOO的吃喝玩樂首頁推薦</span>
											<p>太感人了！2014/2/10杏屋上過YAHOO的吃喝玩樂首頁推薦！開心～灑花～更謝謝人氣部落客小涼的推薦！<a href="http://sant628.pixnet.net/blog/post/408277138">http://sant628.pixnet.net/blog/post/408277138</a></p>
										</li>
									</ul>
								</div>
						<!-- <?php
$change = 0;
$i = 1;
foreach ($about as $abouts):
    if ($change % 3 == 0):
        echo '<div class="brandHistoryItem">
																	<div class="brandHistoryItem__pic">
																		<img src="images/about/brandHistory_pic' . $i . '.jpg" alt="">
																	</div>
																<ul class="brandHistoryItem__list">';
    endif;
    ?>
												<li>
													<span class="date"><?=date('Y年m月', $abouts['create_date'])?></span><span><?=$abouts['title']?></span>
													<p><?=$abouts['content']?></p>
												</li>

											<?php
    $change++;
    if ($change % 3 == 0) {
        echo '</ul> </div>';
        $i++;
    }
endforeach;
?> -->
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	<?php include 'include/footer.php';?>
	<?php include 'include/f2e.php';?>
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
			.triggerElement(".brandStore")
			.triggerHook(.5);
			// .reverse(false);
			// .addIndicators();
			newToggle.on("end", function (e) {
				$(".globleAside").toggleClass("is-top")
			});

			new ScrollMagic.Scene({
					triggerElement: "#brandStore",
					duration : $('#brandStore').outerHeight(true)
				})
				.triggerHook(.5)
				.setClassToggle(".link1", "is-active")
				// .addIndicators()
				.addTo(controller);
			new ScrollMagic.Scene({
					triggerElement: "#brandKitchen",
					duration : $('#brandKitchen').outerHeight(true)
				})
				.triggerHook(.5)
				.setClassToggle(".link2", "is-active")
				// .addIndicators()
				.addTo(controller);
			new ScrollMagic.Scene({
					triggerElement: "#brandHistory",
					duration : $('#brandHistory').outerHeight(true)
				})
				.setClassToggle(".link3", "is-active")
				// .addIndicators()
				.addTo(controller);
		});
	</script>
</body>
</html>