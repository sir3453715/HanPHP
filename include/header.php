<header class="header">
	<nav class="header__nav container nav">
		<div class="nav__social social">
		<?php if ($web_setting[0]['fb'] != ''): ?>
		<a href="https://www.facebook.com/<?=$web_setting[0]['fb']?>" target="_blank" class="social__icon"><img src="images/icon_fb.png"><img src="images/icon_fb-h.png"></a>
		<?php endif;if ($web_setting[0]['ig'] != ''): ?>
		<a href="https://www.instagram.com/<?=$web_setting[0]['ig']?>" target="_blank" class="social__icon"><img src="images/icon_ig.png"><img src="images/icon_ig-h.png"></a>
		<?php endif;if ($web_setting[0]['line'] != ''): ?>
		<a href="https://line.me/<?=$web_setting[0]['line']?>" target="_blank" class="social__icon"><img src="images/icon_line.png"><img src="images/icon_line-h.png"></a>
		<?php endif;?>
		</div>
		<div class="nav__main">
			<a href="about.php" title="關於杏屋"<?=(($get_class == "2") ? ' class="is-active"' : '');?>><span class="tw">關於杏屋</span><span class="jp">ブランド</span></a>
			<a href="news.php" titlt="最新消息"<?=(($get_class == "3") ? ' class="is-active"' : '');?>><span class="tw">最新消息</span><span class="jp">イベント</span></a>
			<a href="index.php" title="杏屋乳酪蛋糕" class="nav__logo">
				<img src="images/logo.png" alt="杏屋乳酪蛋糕" class="logo">
				<img src="images/logo-fixed.png" alt="杏屋乳酪蛋糕" class="logo-fixed">
			</a>
			<a href="store.php" title="銷售據點"<?=(($get_class == "4") ? ' class="is-active"' : '');?>><span class="tw">銷售據點</span><span class="jp">ショップガイド</span></a>
			<a href="contact.php" title="聯絡我們"<?=(($get_class == "5") ? ' class="is-active"' : '');?>><span class="tw">聯絡我們</span><span class="jp">お問い合わせ</span></a>
		</div>
		<div class="nav__act">
			<a href="babycakes.php" title="彌月專區" class="btn btn--ghost">彌月專區</a>
			<a href="http://shop.mousecake.com.tw/" target="_blank" title="網路商店" class="btn">網路商店</a>
		</div>
		<div class="nav__cp">
			<div>客服專線: <?=$web_setting[0]['tel']?></div>
			<div>客服信箱: <a  title="客服信箱"><?=$web_setting[0]['mail']?></a></div>
			<div class="social">
				<?php if ($web_setting[0]['fb'] != ''): ?>
				<a href="https://www.facebook.com/<?=$web_setting[0]['fb']?>" target="_blank" class="social__icon"><img src="images/icon_fb.png"><img src="images/icon_fb-h.png"></a>
				<?php endif;if ($web_setting[0]['ig'] != ''): ?>
				<a href="https://www.instagram.com/<?=$web_setting[0]['ig']?>" target="_blank" class="social__icon"><img src="images/icon_ig.png"><img src="images/icon_ig-h.png"></a>
				<?php endif;if ($web_setting[0]['line'] != ''): ?>
				<a href="https://line.me/<?=$web_setting[0]['line']?>" target="_blank" class="social__icon"><img src="images/icon_line.png"><img src="images/icon_line-h.png"></a>
				<?php endif;?>
			</div>
		</div>
	</nav>
	<div class="hamburger hamburger--elastic no-tap-highlight">
	  <div class="hamburger-box">
	    <div class="hamburger-inner"></div>
	  </div>
	</div>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-119616029-1', 'auto');
		<?php if ($_SESSION[SESSION_NAME]['website']['member_id'] != ''): ?>
		ga('set', '&uid', '<?=$_SESSION[SESSION_NAME]['website']['member_id']?>');
		<?php endif;?>
	</script>
</header>
