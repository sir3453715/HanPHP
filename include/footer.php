<footer class="footer">
	<div class="footer__in container">
		<a href="#" class="footer__logo" title="杏屋乳酪蛋糕"><img src="images/ft_logo.png" alt="杏屋乳酪蛋糕"></a>
		<div class="footer__col">
			<div class="footer__row footer__row--1">
				<div class="footer__info">
					<span>客服時間：<?=$web_setting[0]['hours']?></span><br />
					<span>客服專線：<?=$web_setting[0]['tel']?></span>   <span>客服信箱：<?=$web_setting[0]['mail']?></span>
				</div>
				<ul class="footer__nav">
					<li><a href="about.php" title="關於杏屋">關於杏屋</a></li>
					<li><a href="news.php" title="最新消息">最新消息</a></li>
					<li><a href="store.php" title="銷售據點">銷售據點</a></li>
					<li><a href="babycakes.php" title="彌月專區">彌月專區</a></li>
					<li><a href="http://shop.mousecake.com.tw/" target="_blank" title="網路商店">網路商店</a></li>
					<li><a href="contact.php" title="聯絡我們">聯絡我們</a></li>
				</ul>
			</div>
			<div class="footer__row footer__row--2">
				<div class="footer__cp">
					©<?=date('Y', time())?> mousecake All Rights Reserved. </br>
					<span class="footer__dc"><a href="http://www.asiaway.com.tw target="_blank" " title="網頁設計">網頁設計</a> : <a href="http://www.asiaway.com.tw" target="_blank"  title="網頁設計">亞葳網頁設計</a></span>
				</div>
				<div class="footer__social social">
					<?php if ($web_setting[0]['fb'] != ''): ?>
					<a href="https://www.facebook.com/<?=$web_setting[0]['fb']?>" target="_blank"  class="social__icon"><img src="images/icon_fb.png"><img src="images/icon_fb-h.png"></a>
					<?php endif;if ($web_setting[0]['ig'] != ''): ?>
					<a href="https://www.instagram.com/<?=$web_setting[0]['ig']?>" target="_blank"  class="social__icon"><img src="images/icon_ig.png"><img src="images/icon_ig-h.png"></a>
					<?php endif;if ($web_setting[0]['line'] != ''): ?>
					<a href="https://line.me/<?=$web_setting[0]['line']?>" target="_blank"  class="social__icon"><img src="images/icon_line.png"><img src="images/icon_line-h.png"></a>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</footer>
<a href="#" class="gotop" title="置頂"><img src="images/btn_top.png"></a>