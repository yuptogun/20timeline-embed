<?php

// embed.php
// : a script to show the summarized article of 20timeline.com when embedded.
// written by Eojin K. = eojin@me.com

// --------------------------------------------------------------------------

// step 0, get the $wpdb

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path.'/wp-config.php';
include_once $path.'/wp-includes/wp-db.php';
include_once $path.'/wp-includes/pluggable.php';

// --------------------------------------------------------------------------

// step 1, set the variables
// $role means the role of the page
// $show means the list of the visual details according to $role

$role = '';
if (!$_GET['id']) {

// --------------------------------------------------------------------------

// step 2, set the default look

	$role = 'go index';
	$show = array(
		'title' => 'Twenties\' Timeline 기사 임베딩 툴',
		'h1' => '<a href="http://20timeline.com/">트웬티스 타임라인</a>의 기사를 웹페이지에 삽입해 보세요!',
		'small' => 'iframe 태그를 지원하는 모든 곳에서 사용 가능합니다.',
		'p' => '<p>다음 형식으로 사용됩니다.</p>
		<code>&lt;iframe src="http://20timeline.com/embed.php?id=(기사 번호)" width="400" height="200" allowtransparency="true">&lt;/iframe></code>
		<p>없는 기사의 번호를 입력했을 때는 404 화면을 띄웁니다.</p><p class="comment">v0.9, js 애플릿을 넣어서 실제로 링크가 움직이도록 해야 한다. Written by <a href="http://20timeline.com/dev">Eojin K.</a></p>'
	);
} else {

// --------------------------------------------------------------------------

// step 3, handle the 404 case
// 404 case means when $article is returned with null

	global $wpdb;
	$id = intval($_GET['id']);
	$article = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = $id");
	if (empty($article)) {
		$role = 'no-go';
		$show = array(
			'title' => '요청하신 번호의 기사가 트웬티스 타임라인에는 없습니다!',
			'h1' => '404 NOT FOUND',
			'small' => '트웬티스 타임라인에서 '.$id.'번 기사를 찾을 수 없어서, 표시할 것이 없습니다.',
			'p' => '<p><a href="http://20timeline.com/">홈페이지에서 최신 기사 읽기</a></p>'
		);
		$wpdb->flush();
	} else {

// --------------------------------------------------------------------------

// step 4, output the embedded card

		$author = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE ID = '$article->post_author'");
		function get_the_thumbnail_url($post_id) {
			if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post_id) ) {
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
				if (!$thumbnail[0]) return false;
				else return $thumbnail[0];
			}
		}
		$thumbnail = get_the_thumbnail_url($id);
		$role = 'go embedded';
		$show = array(
			'title' => $article->post_title,
			'h1' => '<a href="http://20timeline.com/'.$id.'">'.$article->post_title.'</a><span class="author"> by '.$author.'</span>',
			'small' => $article->post_excerpt
//			'p' => '<p>'.wp_trim_words( strip_shortcodes( $article->post_content ), 15, '...' ).'</p>'
		);
		$wpdb->flush();
	}
}
?><!doctype html>
<html lang="ko">
<head>
	<base target="_top" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<title><?php echo $show['title']; ?></title>
	<style type="text/css">
		@import url(http://notosanskr-hestia.s3-website-ap-northeast-1.amazonaws.com/stylesheets/NotoSansKR-Hestia.css);
		* {
			font-family: 'Noto Sans Korean', sans-serif;
			margin: 0; padding: 0;
		}
		a, a:visited {
			color: white;
			background-color: #d01f3e;
			text-decoration: none;
			padding: 0 4px 1px;
		}
		a:hover, a:focus {
			color: #1b1b1b;
		}
		html, body {
			background: transparent;
			overflow: hidden;
			width: 100%;
			height: 100%;
		}
		body {font-size: 62.5%;}
		h1 {font-size: 8vmin; font-weight: 600; letter-spacing: -0.05em;}
		small {font-size: 6vmin; font-weight: 200;}
		p, code {font-size: 6vmin;}
		code {
			display: inline-block;
			font-family: 'consolas', monospace;
			background: #eee;
			padding: 1px 3px;
			border-radius: 4px;
			line-height: 1.5em;
		}
		#card {
			overflow: hidden;
			width: 100%;
			height: 100%;
			position: relative;
			background: transparent;
		}
		#image {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-image: url('<?php echo $thumbnail; ?>');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			filter: blur(2px);
			-webkit-filter: blur(2px);
		}
		#texts {
			position: absolute;
			width: 100%;
			height: 100%;
		}
		#text {
			padding: 0 2em;
		}
		.author {
			font-size: 75%;
			font-weight: 400;
		}
		.comment,
		.index p.comment {
			font-size: 12px;
			font-family: 'consolas', monospace;
			text-align: right;
			margin-top: 1em;
		}
		.comment a {
			padding: 0;
			background-color: transparent;
			border-bottom: 1px dotted;
			color: inherit;
			font-family: inherit;
		}
/* go */
		.go #card {
			background: none;
			width: 98%;
			height: 96%;
			top: 2%;
			left: 1%;
		}
		.go #text {
			color: #010101;
			position: relative;
			top: 12px;
		}
/* go-index! */
		body.index {
			overflow: initial;
		}
		.index #card {
			overflow: auto;
		}
		.index h1 {
			font-size: 24px;
		}
		.index small {
			font-size: 16px;
		}
		.index p {
			font-size: 18px;
		}
		.index code {
			font-size: 16px;
		}
/* go-embedded! */
		.embedded #card {
			cursor: pointer;
			border-radius: 8px;
		}
		.embedded #texts {
			background: rgba(0,0,0,0.5);
		}
		.embedded #texts:hover {
			background: rgba(0,0,0,0.25);
		}
		.embedded #text,
/* uh-oh, no go here */
		.no-go #text {
			position: relative;
			top: 50%;
			transform: translateY(-50%);
			-o-transform: translateY(-50%);
			-ms-transform: translateY(-50%);
			-moz-transform: translateY(-50%);
			-webkit-transform: translateY(-50%);
			color: white;
		}
		.no-go #card {
			background: #d01f3e;
			color: white;
			text-align: center;
		}
		.no-go h1 {font-size: 24px;}
		.no-go a, .no-go a:visited {
			color: #010101;
			border-bottom: 1px dotted;
			padding: 0;
		}
		.no-go a:hover, .no-go:focus {
			color: white;
		}
	</style>
</head>
<body class="<?php echo $role; ?>">
	<div id="card" <?php if (!empty($article)) : ?>onclick="getArticleOf('<?php echo $id; ?>')"<?php endif; ?>>
		<div id="image"></div>
		<div id="texts">
			<div id="text">
				<h1><?php echo $show['h1']; ?></h1>
				<small><?php echo $show['small']; ?></small>
				<?php echo $show['p']; ?>
			</div>
		</div>
	</div>
<script>
function getArticleOf(id) {
	window.top.location.href = 'http://20timeline.com/'+id;
}
</script>
</body>
</html>			