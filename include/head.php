<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/css/default.css"/>
<link rel="stylesheet" type="text/css" href="/css/common_top.css"/>
<link rel="stylesheet" type="text/css" href="/css/common_layout.css"/>
<link rel="stylesheet" type="text/css" href="/css/common_bottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/common.css"/>
<link rel="stylesheet" type="text/css" href="/css/main_layout.css"/>

<script type="text/javascript" src="/js/jquery.easing.js"></script>
<script type="text/javascript" src="/js/jquery-migrate-1.2.1.min.js"></script>

<!--<script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="/js/common2.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/map.js"></script>

<title>VIP제주여행</title>

<script type="text/javascript">
function menu_wait() {
	alert("준비중입니다.");
}
</script>
</head>
<body>
<!--<div id="accessibility">
	<a href="#container">vip제주여행</a>
</div>-->
<div class="mlnb_bg"></div>
<div id="header">
	<div class="gnb">
		<div class="wrap clearfix">
			<!--<ul class="gnb_link clearfix">
				<li class="acc"><a href="#container">vip제주여행</a></li>
				<li class="portal on"><a href="#n"><span>vip제주여행</span></a></li>
				<li class="parl"><a href="http://sccl.ne.kr/main/" target="_blank" title="새창"><span>vip제주여행</span></a></li>
				<li class="welf"><a href="#"><span>vip제주여행</span></a></li>
				<li class="gtour"><a href="#"><span>vip제주여행</span></a></li>
			</ul>-->
			<ul class="gnb_navi clearfix">
				<li><a href="/">HOME</a></li>			
				<li><a href="/rent/confirm_01.php">예약확인</a></li>			
				<li><a href="#">여행상담</a></li>
                <li><a href="#">즐겨찾기추가</a></li>
				<!--<li class="language">
					<button class="lang_off">LANGUAGE</button>
				<ul>
						<li><a href="#"><span>VIP제주여행</span></a></li>
						<li><a href="#"><span>VIP제주여행</span></a></li>
						<li><a href="#"><span>VIP제주여행</span></a></li>
					</ul>
				</li>-->
			</ul><!-- 글로벌메뉴 -->
		</div><!-- //gnb wrap -->
	</div><!-- //gnb -->
	<div class="wrap">
		<div class="logo">
			<h1><a href="/"><img src="/images/logo.png"  alt="VIP제주여행" />VIP제주여행</a></h1>
			<!--<span class="flag"><img src="/images/flag.gif" alt="VIP제주여행" /></span>-->
		</div>
		<button class="nav_all"><span>메뉴</span></button>
	</div><!-- // header_ wrap -->

		<div id="lnb">
			<h2 class="skip">VIP제주여행</h2>
				<button class="nav_close">메뉴 닫기</button>
				<ul id="top1menu" class="clearfix">
										<li class="depth1">
								<a href="#" class="depth1_ti" accesskey="1" target="_self"><span>렌터카</span></a>
								<div class="top2m depth1_1">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>렌터카</strong>
														<p>더 안전하고<br />더 저렴한 렌트카로<br />더 즐겁고 편리한<br />제주여행을 즐기세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
						<li class="depth1">
								<a href="#" class="depth1_ti" accesskey="2" target="_self"><span>카텔패키지</span></a>
								<div class="top2m depth1_2">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>카텔패키지</strong>
														<p>제주도내 인기 숙소와<br />저렴한 렌트카를<br />한번에 알뜰하게<br />예약하세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
						<li class="depth1">
								<a href="#" class="depth1_ti" accesskey="3" target="_self"><span>숙소</span></a>
								<div class="top2m depth1_3">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>숙소</strong>
														<p>제주도 최고의 펜션,<br />호텔, 리조트를 엄선하여<br />제주여행을 보다<br />편리하게 즐기세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
						<li class="depth1">
								<a href="#" class="depth1_ti" accesskey="4" target="_self"><span>골프</span></a>
								<div class="top2m depth1_4">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>골프</strong>
														<p>즐거운 힐링골프!<br />제주도에서 시원한<br />라운딩을 즐겨보세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
						<li class="depth1">
								<a href="#" class="depth1_ti" accesskey="4" target="_self"><span>버스</span></a>
								<div class="top2m depth1_5">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>버스</strong>
														<p>효도관광, 친구/연인과<br />추억여행 등 저렴한 비용<br />으로 알찬 버스여행을<br />즐기세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
						<li class="depth1">
								<a href="#" class="depth1_ti" accesskey="4" target="_self"><span>택시</span></a>
								<div class="top2m depth1_6">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>택시</strong>
														<p>친절한 택시기사님이<br />최상의 서비스로<br />최고의 제주여행을<br />만들어 드립니다!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
                        <li class="depth1">
								<a href="#" class="depth1_ti" accesskey="4" target="_self"><span>관광지입장권</span></a>
								<div class="top2m depth1_7">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>관광지입장권</strong>
														<p>최고의 볼거리,<br />즐길거리와 맛집을<br />보다 저렴하고 편하게<br />즐기세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
                        <li class="depth1">
								<a href="#" class="depth1_ti" accesskey="4" target="_self"><span>단체여행</span></a>
								<div class="top2m depth1_8">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>단체여행</strong>
														<p>세미나, 워크샵, 단체등<br />반, 가족여행 등 최고의<br />서비스로 원하시는<br />여행코스를 즐기세요!</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
                        <li class="depth1">
								<a href="#" class="depth1_ti" accesskey="4" target="_self"><span>고객센터</span></a>
								<div class="top2m depth1_9">
										<div class="menu_bg clearfix">
												<div class="tm1_title">
														<strong>고객센터</strong>
														<p>제주여행에 대한<br />모든 궁금한 사항들을<br />신속/정확하고 친절하게<br />성심성의껏 상담해<br />드립니다.</p>
												</div>
                                                <? include($_SERVER[DOCUMENT_ROOT].'/include/menu.php'); ?>
										</div>
								</div>
						</li>
				</ul><!-- //top1menu -->
		</div><!-- //lnb -->

		<div class="src_form">
			<fieldset>
			<input type="text" name="query" id="query" title="검색어를 입력하세요"  placeholder=" 검색어를 입력하세요"/>
			<input type="submit" name="" value="검색"/>
			</fieldset>
			</form>
		</div><!-- //src_form -->			

</div><!-- //header -->
<hr />