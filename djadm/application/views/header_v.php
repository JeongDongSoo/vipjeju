<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
	<title>렌터카 관리 시스템</title>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
	<script src="/djadm/assets/js/common.js"></script>
	<link rel='stylesheet' href="/djadm/assets/css/bootstrap.css" />
</head>
<body>
<div id="main">
	<header id="header" data-role="header" data-position="fixed"><!-- Header Start -->
		<?php if (@$this->session->userdata['bLoginFlag'] === TRUE) : ?>
		<blockquote>
			<p>메뉴 리스트 !! <a href="<?php echo $sBaseUrl; ?>member/login/logout">로그 아웃</a></p>
		</blockquote>
		<?php endif; ?>
	</header><!-- Header End -->

	<nav id="gnb"><!-- gnb Start -->
		<!-- <ul>
			<li><a rel="external" href="/bbs/<?php echo $this->uri->segment(1);?>/lists/<?php echo $this->uri->segment(3);?>">게시판 프로젝트</a></li>
		</ul> -->
	</nav><!-- gnb End -->