<?php
require 'public_include.php';
$class_id = $_GET['class_id'];
if ($class_id == '') {
    $strSQL = "SELECT * FROM `news` WHERE status = '1'  ORDER BY create_date DESC";
    $db->Execute($strSQL);
    $rows = $db->Affected_Rows();
} else {
    $strSQL = "SELECT * FROM `news` WHERE status = '1'  AND class_id = $class_id ORDER BY create_date DESC";
    $db->Execute($strSQL);
    $rows = $db->Affected_Rows();
    $arg = array("class_id" => $class_id);
}
$curr_page = $_GET['p'];
$last_page = ceil($rows / 6);
if ($curr_page > $last_page) {
    $curr_page = $last_page;
}

if ($curr_page < 1) {
    $curr_page = 1;
}

if ($last_page == 0) {
    $curr_page = 0;
}

$news = $db->PageExecute($strSQL, 6, $curr_page);
$data = array('id' => $class_id);
$news_class = $db->select('news_class', $data);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<?php include 'include/meta.php';?>
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
	<div class="main news">
		<div class="container">
			<!-- idxNews -->
			<div class="idxNews idxNews--page">
				<?php foreach ($news as $new): ?>
				<div class="idxNewsItem">
					<div class="idxNewsItem__img">
						<a href="news_view.php?id=<?=$new['id']?>" title="\ <?=$new['title']?> /"><img src="webimages/<?=$new['img']?>" alt=""></a>
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
				<?endforeach;?>
				<div class="idxNews__ft"></div>
			</div>
			<!-- pagination -->
			<?php
FuncSite::fore_page1($curr_page, $last_page, $arg, $rows);
?>
		</div>
	</div>
	<?php include 'include/footer.php';?>
	<?php include 'include/f2e.php';?>
</body>
</html>