<?php
require 'public_include.php';
$news_id = $_GET['id'];
if (!is_numeric($news_id) && $news_id != '') {
    Func::msg_box('請勿嘗試違法行為！');
    Func::go_to('index.php');
    exit;
}
$data = array('id' => $news_id);
$news = $db->select('news', $data);
$class_id = $news[0]['class_id'];
$data = array('status' => '1', 'id' => $class_id);
$news_class = $db->select('news_class', $data, 'sort', 'desc');
$now = $news[0]['id'];
$fb_URL = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="zh-TW">
<html prefix='og: https://ogp.me/ns#'>
<head>
	<?php include 'include/meta.php';?>
	<meta property="og:title" content="<?=$news[0]['title']?>">
	<meta property="og:url" content="<?=$fb_URL?>">
	<meta property="og:type" content="article" />
	<meta property="og:image" content="https://<?=$_SERVER['HTTP_HOST'] . '/project/mousecake_2017/webimages/' . $news[0]['con_img']?>">
	<meta property="og:description" content="<?=$news[0]['summary']?>">
	<meta property="og:image:width" content="100">
	<meta property="og:image:height" content="250">
	<meta property="fb:app_id" content="446071489163601"/>
</head>
<body class="page-news" style="background-image: url(images/news/news_bg.jpg);">
	<?php include 'include/header.php';?>
	<div class="pgHero">
		<div class="pgHero__con">
			<div class="pgHero__intro">
				<img src="images/news/newsDec01.png" alt="" class="newsDec01">
				<img src="images/news/newsDec02.png" alt="" class="newsDec02">
				<img src="images/news/newsDec03.png" alt="" class="newsDec03">
				<h2 class="pgHero__tit">
					<span class="tw">最新消息</span>
					<span class="jp">ブランド</span>
				</h2>
				<p>杏屋就是寵粉絲！<br />請記得密切關注小杏與喵喵的動態，<br />就有可能偷偷的把好康送給你！</p>
			</div>
		</div>
	</div>
	<div class="main newsView">
	<?php foreach ($news as $new): ?>
		<div class="container">
			<div class="newsViewCon">
				<div class="newsViewCon__date">
					<span class="year"><i><?=date('Y', $new['create_date'])?></i>公告時間</span>
					<span class="date"><?=date('m/d', $new['create_date'])?></span>
				</div>
				<div class="newsViewCon__tit">
					<?=$new['title']?>
				</div>
				<div class="newsViewCon__con row">
					<div class="newsViewCon__pic">
						<img src="webimages/<?=$new['con_img']?>" alt="">
					</div>
					<div class="newsViewCon__intro">
					<?=$new['content']?>
						<br /><br />
						<p>---------------------------------------------<br />
						<div class="newsViewCon__social newsShare social">
							<a class="social__icon" href="https://www.facebook.com/dialog/feed?app_id=1723364317779489&amp;display=popup&amp;caption=分享給你的親朋好友&amp;link=<?=$fb_URL?>&amp;redirect_uri=<?=$fb_URL?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="images/icon_fb.png"></a>
							<a class="line_pc" href="https://timeline.line.me/social-plugin/share?url=https://<?=$url?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="images/icon_line.png"></a>
						</div>
					</div>
					<img src="images/news_view/dec01.png" class="newsViewCon__dec newsViewCon__dec--1">
					<img src="images/news_view/dec02.png" class="newsViewCon__dec newsViewCon__dec--2">
				</div>
				<a href="news.php" title="" class="newsViewCon__back"><i><img src="images/news_view/icon_back.png" alt="BACK"></i>BACK</a>
			</div>
		</div>
	<?php endforeach;?>
	</div>
	<?php include 'include/footer.php';?>
	<?php include 'include/f2e.php';?>
</body>
</html>