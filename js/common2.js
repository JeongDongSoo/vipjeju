if(navigator.userAgent.indexOf("MSIE 7") > 0) {
  $('body, html').css({ overflow: 'auto' });
} else if(navigator.userAgent.indexOf("MSIE 8") > 0) {
  // IE 8.x
  src_height = 210;
	jQuery(function(){
		$(".mlnb_bg").hide();
		$("#lnb #top1menu li.depth1 > .depth1_ti").bind({
			mouseenter:function(){$(this).addClass('on').next('div.top2m').stop().slideDown(300);},
			focusin:function(){
				$('.depth1').find('.depth1_ti').removeClass('on').next('div.top2m').stop().slideUp(100);
				$(this).addClass('on').next('div.top2m').stop().slideDown(300);
			}
		});
		$('#lnb #top1menu li ul').focusin(function(){$(this).prev('a.depth1_ti').addClass('on');});
		$('#lnb #top1menu > .depth1').mouseleave(function(){$(this).find('.on').removeClass('on').next('div.top2m').stop().slideUp(100);});
		$('#lnb #top1menu li:last-child div.top2m div.menu_bg > ul > li:last-child').focusout(function(){
			$('#lnb #top1menu a.on').removeClass('on');
			$(this).parents('li.depth1').find('.depth1_ti').removeClass('on').next('div.top2m').stop().slideUp(100);
		});
		//2차메뉴 클래스 추가
		$(".depth2 > li").bind({
			mouseenter:function(){$(this).addClass('on');},
			focusin:function(){
				$('.depth2').find('li').removeClass('on');
				$(this).addClass('on');
			},
			focusout:function(){$(this).siblings('ul li:last-child()').removeClass('on');}
		});
		$('.depth2 > li').mouseleave(function(){$(this).removeClass('on');});
	});
	jQuery(function(){
		//서브 왼쪽메뉴
		$(".side_menu ul.sm_3th.on").parent("li").addClass("on");
		var side2Depth = $(".side_menu ul.sm_3th").siblings("a");

		side2Depth.click(function(event){
		event.preventDefault();
			$(this).addClass("open").siblings("ul").addClass("open").slideDown(200).parent("li").addClass("open");
			$(this).parent().siblings().children("a.open").removeClass("open").siblings("ul.open").slideUp(100).removeClass("open").parent("li").removeClass("open");
		});
	});
} else {
	//ie8 이상에서 적용됨
	//메인 사이즈
	$("document").ready(function(){
		if ( $(window).width() > 1024){
			pc_menu();
			//sub_menu();
			src_height = 210;
		} else if ($(window).width() > 640 && $(window).width() < 1024){
			mobile_menu();
			mobile_tab();
			src_height = 210;
		} else {
			mobile_menu();
			mobile_tab();
			src_height = 420;
			addCellHeader(document.querySelector('.bbs_default_list'));
			addCellHeader(document.querySelector('.response_table'));
		}
	});

	var windowWidth = $(window).width();

	$(window).resize(function() {

		if( windowWidth != $(window).width() ) {

			if ( $(window).width() > 1024){
				pc_menu();
				//sub_menu();
				src_height = 210;
				return false;
			} else if ($(window).width() > 640 && $(window).width() < 1024){
				mobile_menu();
				mobile_tab();
				src_height = 210;
			} else {
				mobile_menu();
				mobile_tab();
				src_height = 420;
				addCellHeader(document.querySelector('.bbs_default_list'));
				addCellHeader(document.querySelector('.response_table'));
			}

		}

		windowWidth = $(window).width();

	})
}
/* 자주묻는 질문 */
jQuery(function($){
	$(".list_slide li button").click(function(){
		$(this).children("strong").fadeOut("fast");
		$(this).addClass("on");
		$(this).siblings("div.list_slide_detail").slideDown("fast");
		$(this).parent().siblings().children("div.list_slide_detail").slideUp("fast");
		$(this).parent().siblings().children("button").removeClass("on");
		return false;
	});
	$(".list_slide .list_slide_close").click(function(){
		$(".list_slide li button").children("strong").fadeIn("fast");
		$(".list_slide .on").removeClass("on");
		$(this).parent().parent("div.list_slide_detail").slideUp("fast");
		return false;
	});
});
/*function sub_menu(e){ //왼쪽메뉴 2차 버튼
	$(".side_menu ul.sm_3th.on").parent("li").addClass("on");

	var side2Depth = $(".side_menu ul.sm_3th").siblings("a");
	side2Depth.bind({
		click:function(event){
			event.preventDefault();
			$(this).addClass("open").siblings("ul").addClass("open").slideDown(200).parent("li").addClass("open");
			$(this).parent().siblings().children("a.open").removeClass("open").siblings("ul.open").slideUp(100).removeClass("open").parent("li").removeClass("open");
		}
	});
};*/
function pc_menu(e){ //PC 메뉴

	// 기존 이벤트 제거
	$("#lnb #top1menu li.depth1 > .depth1_ti").unbind();
	$('#lnb #top1menu > .depth1').unbind();

	// 모바일에서 활성화 되었던 메뉴 닫기
	$('.depth1').find('.depth1_ti').removeClass('on').next('div.top2m').stop().slideUp(0);
	$("#lnb").css("width","100%"); //마찬가지로 여기서 넓이를 100%로 초기화 시킬경우 모바일에선 처음부터 메뉴가 100%로 뜨는 현상이 발생함.
	$(".mlnb_bg").hide();
	$("#lnb #top1menu li.depth1 > .depth1_ti").bind({
		mouseenter:function(){$(this).addClass('on').next('div.top2m').stop().slideDown(300);},
		focusin:function(){
			$('.depth1').find('.depth1_ti').removeClass('on').next('div.top2m').stop().slideUp(100);
			$(this).addClass('on').next('div.top2m').stop().slideDown(300);
		}
	});
	$('#lnb #top1menu > .depth1').mouseleave(function(){$(this).find('.on').removeClass('on').next('div.top2m').stop().slideUp(100);});
	//포커스가 마지막 메뉴를 빠져나왔을 때 펼쳐진 메뉴 가림.
	$('#lnb #top1menu li:last-child div.top2m div.menu_bg > ul > li:last-child').focusout(function(){
		$('#lnb #top1menu a.on').removeClass('on');
		$(this).parents('li.depth1').find('.depth1_ti').removeClass('on').next('div.top2m').stop().slideUp(100);
	});
};

var isMobileResizingMenu = false;
function mobile_menu(e){ //모바일메뉴
	$("#lnb").css("width",0); //여기서 넓이를 초기화 시킬경우 모바일에서 화면 이동시 메뉴가 사라지는 현상이 발생함. css로 초기화
	$(".mlnb_bg").fadeOut(100);
	if ( !isMobileResizingMenu ) {
		isMobileResizingMenu = true;

		$("#top1menu").removeClass("clearfix");
		$(".nav_all").click(function(){

			// 활성화 되었던 메뉴 닫기
			$("#top1menu .depth1_ti").parent().siblings().children("a.depth1_ti").removeClass("open").siblings(".top2m").slideUp(0).removeClass("open").parent("li").removeClass("open");

			$("body").off("mouseenter",".depth1_ti",pc_menu);
			$("#lnb").animate({width:"240px"},300);
			$(".mlnb_bg").fadeIn(100);
		});
		$(".nav_close").click(function(){
			$("#lnb").animate({width:0},300);
			$(".mlnb_bg").fadeOut(100);
		});

	}

	// 기존 이벤트 제거
	$("#lnb #top1menu li.depth1 > .depth1_ti").unbind();
	$('#lnb #top1menu > .depth1').unbind();

	var top1Depth = $("#top1menu .depth1_ti");
	var topDepths = $(".top2m ul").siblings("a");
	top1Depth.bind({
		click:function(event){
			event.preventDefault();
			console.log("aaa");
			$(this).addClass("open").siblings(".top2m").addClass("open").slideDown(200).parent("li").addClass("open");
			$(this).parent().siblings().children("a.depth1_ti").removeClass("open").siblings(".top2m").slideUp(100).removeClass("open").parent("li").removeClass("open");
			$(this).parent().find(".top2m menu_bg .depth2 li ul").hide();
		}
	});
	topDepths.bind({
		click:function(event){
			event.preventDefault();
			$(this).addClass("open").siblings("ul").slideDown(200).parent("li").addClass("open");
			$(this).parent().siblings().children("a").removeClass("open").siblings("ul").slideUp(100).removeClass("open").parent("li").removeClass("open");
		}
	});
	var topParts = $("#top1menu .part_info .depth2 > li:first-child > a");//분야별정보 변수
	topParts.bind({
		click:function(event){
			event.preventDefault();
			alert("aaa");
		}
	}).unbind();
};

var isMobileResizingTab = false;
function mobile_tab(e){

	if( !isMobileResizingTab ) {

		isMobileResizingTab = true;

		var mobileTab = $(".tabmenu_4depth li.on").children();
		mobileTab.prop("href","#n").off("click");
		mobileTab.click(function(){
			$(this).parent().siblings().fadeIn("fast");
		});
	}
}
jQuery(function($){
	$(".lang_off").click(function(){
		$(this).toggleClass("lang_on").siblings().slideToggle(100);
	});
	//통합검색
	$(".src_btn").click(function(){
		$(this).addClass("on").siblings(".search_detail").animate({height : src_height},100).css("border","1px solid #000");
	});
	$(".src_close").click(function(){
		$(this).parent(".search_detail").animate({height : 0},100).css("border","none");
		$(".src_btn").removeClass("on");
	});
	//상단이동
	$(".top_btn").click(function(){
		$("html, body").animate({scrollTop : 0},400);
		return false;
	});
	//풋터  - 관련사이트 바로가기
	$(".site_link div.layer").fadeOut("fast");
	$(".site_link h3 button.open").click(function(){
		$(".site_link div.layer").fadeOut("fast");
		$(this).parent().next("div.layer").fadeIn("fast");return false;
	});
	$(".site_link .close").click(function(){
		$(this).parent().fadeOut("fast");return false;
	});
});
/*  게시판 */
function addCellHeader(table) {
	if (!table) {
		return false;
	}
	var trs = table.getElementsByTagName('tr');
	var trsChild;
	var grid = {};
	var cells;

	for (var i = 0, cntI = trs.length; i < cntI; i++) {
		if (!grid[i]) {
			grid[i] = {};
		}
		trsChild = trs.item(i).childNodes;
		cells = 0
		for (var j = 0, cntJ = trsChild.length; j < cntJ; j++) {
			if (trsChild[j].nodeType == 1) {
				grid[i][cells++] = trsChild[j];
			}
		}
	}
	//alert("aa");
	$("table tr:odd").addClass("odd");
	$("table tr:even").addClass("even");

	var cellHeader = '';
	for (row in grid) {
		if (row == 0) {
			continue;
		}
		for (cell in grid[row]) {
			if (cell == 0) {
				continue;
			}
			//cellHeader = grid[0][cell].innerHTML + ' - ' + grid[row][0].innerHTML
			cellHeader = grid[0][cell].innerHTML + '：' ;
			grid[row][cell].setAttribute('data-cell-header', cellHeader);
		}
	}
};
//popupzone
(function($){

	$.fn.PopupZone = function(options) {
		var pop_length = $(".pop_list li").length;
		if (pop_length > 1)
		{
			var settings = {
				prevBtn : '',
				nextBtn : '',
				playBtn : '',
				waitingTime : ''
			};

			$.extend(settings, options);
			settings.areaDiv = this;
			settings.prevBtn = $(settings.prevBtn);
			settings.nextBtn = $(settings.nextBtn);
			settings.playBtn = $(settings.playBtn);

			settings.cnt = settings.areaDiv.find('li').length;
			settings.waitingTime = parseInt(settings.waitingTime);
			settings.nowNum = 0;
			settings.moveFlag = true;
			settings.moveType;
			settings.setTimeOut;
			var status=true;

			function emptySetting() {
				settings.areaDiv.find('.count').html(settings.nowNum+1);
				settings.areaDiv.find('.all').html(settings.cnt);
				settings.areaDiv.find('li').hide();
			}
			function setRolling(aniFlag) {
				if(!settings.moveFlag){
					if(settings.moveType=="next" || settings.moveType == null){
						settings.nowNum++;
						if(settings.nowNum == settings.cnt) settings.nowNum = 0;
					} else if(settings.moveType=="prev") {
						settings.nowNum--;
						if(settings.nowNum < 0) settings.nowNum = (settings.cnt-1);
					}
				}
				emptySetting();

				if(aniFlag) settings.areaDiv.find('li').eq(settings.nowNum).show();
				else settings.areaDiv.find('li').eq(settings.nowNum).fadeIn('normal');
				 // 기본 : aniFlag 설정 없으면 fade 효과 - 조정

				aniFlag = false;
				settings.moveFlag = false;
				if(status){
					if(settings.cnt >1){
						settings.setTimeOut= setTimeout(setRolling , settings.waitingTime);
					}
				}
			}
			function playRolling(){
				//정지 재생버튼 배경으로 제어.
				if(status){
					clearTimeout(settings.setTimeOut);
					settings.playBtn.attr('class',"pop_play").html("팝업 롤링 재생");
					status = false;
				}else{
					settings.playBtn.attr('class',"pop_stop").html("팝업 롤링 정지");
					status = true;
					setRolling();
				}
				return false;
			}
			function prevRolling(){
				clearTimeout(settings.setTimeOut);
				settings.moveType = "prev";
				setRolling();
				return false;
			}
			function nextRolling() {
				clearTimeout(settings.setTimeOut);
				settings.moveType = "next";
				setRolling();
				return false;
			}
			setRolling();
			settings.prevBtn.click(prevRolling);
			settings.nextBtn.click(nextRolling);
			settings.playBtn.click(playRolling);
		}
	};
})(jQuery);
$(document).ready(function(){
		$('.popup').PopupZone({
			prevBtn : '.pop_prev',
			nextBtn : '.pop_next',
			playBtn : '.pop_stop',
			waitingTime : '5000'
		});
});
//banner
$(document).ready(function(){
	var bn_length = $(".banner li").length;
	if (bn_length > 7)
	{
		var bannerAuto=null;
		var bannerDirect="left";

		function rightBanner(){
			$(".banner ul").stop().animate(
				{left:"-=130px"},0,function(){
						var $bannerObj=$(".banner ul li:first").clone(true);
						$(".banner ul li:first").remove();
						$(".banner ul").css("left",0);
						$(".banner ul").append($bannerObj);
				}
			)
				if(bannerAuto)clearTimeout(bannerAuto);
				bannerAuto=setTimeout(rightBanner,3000)
		}

		function leftBanner(){
			$(".banner ul").stop().animate(
				{left:"0px"},0,function(){
					var $bannerObj=$(".banner ul li:last").clone(true);
					$(".banner ul li:last").remove();
					$(".banner ul").css("left","0");
					$(".banner ul").prepend($bannerObj);
				}
			)
				if(bannerAuto)clearTimeout(bannerAuto);
				bannerAuto=setTimeout(rightBanner,3000)
		}

		$(document).ready(function(){

		bannerAuto=setTimeout(rightBanner,3000)

			$rightB=$(".bn_ctrl .bn_next");
			$leftB=$(".bn_ctrl .bn_prev");
			$pauseB=$(".bn_ctrl .bn_stop");
			$bannerP_btn=$(".bn_ctrl .bn_stop img")
			var bPlay = false;

			$leftB.click(function(){
				bannerDirect="left"
				clearTimeout(bannerAuto);
				$bannerP_btn.attr("src","/common/images/common/bn_stop.gif");
				$bannerP_btn.attr("alt","배너일시정지");
				leftBanner();
				return false;
				/*}*/
			});

			$rightB.click(function(){
				bannerDirect="right"
				clearTimeout(bannerAuto);
				$bannerP_btn.attr("src","/common/images/common/bn_stop.gif");
				$bannerP_btn.attr("alt","배너일시정지");
				rightBanner();
				return false;
				/*}*/
			});


			$pauseB.click(function(){
				if (bPlay == false){
				clearTimeout(bannerAuto); 2
				$bannerP_btn.attr("src","/common/images/common/bn_play.gif");
				$bannerP_btn.attr("alt","배너재생");
				bPlay = true;
				}else{
				bPlay = false;
				$bannerP_btn.attr("src","/common/images/common/bn_stop.gif");
				$bannerP_btn.attr("alt","배너일시정지");
				bannerAuto=setTimeout(rightBanner,1500)
				}
			});

			$(".banner ul li a").bind("mouseover focusin", function(){
				clearTimeout(bannerAuto);
			});
			$(".banner ul li a").bind("mouseleave focusout", function(){
				bPlay = false;
			});
		});
	}
});
(function($){
	$.fn.photo_slide = function(options) {
		var _this   = this,
			$item      = $('.photo_cnt > li'),
			$btns      = $('.slide_ctrl button'),
			$btn_nums  = $('.slide_btn li'),
			_lens   = $item.length;
		_this.index     = 0;
		_this.next      = 0;
		_this.animated  = false;

		_this.ani = function() {
			if (_this.animated) return;
			_this.animated  = true;
			$item.eq(_this.next).show();

			var btn_nums_off = $btn_nums.eq(_this.index).find("button")[0];
				btn_nums_off.className =  btn_nums_off.className.replace("on","off");

			var btn_nums_img = $btn_nums.eq(_this.next).find("button")[0];
				btn_nums_img.className =  btn_nums_img.className.replace("off","on");


			$item.eq(_this.index).fadeOut(200, function() {
				$(this).removeClass('active');
				$item.eq(_this.next).addClass('active');
				_this.animated = false;
				_this.index = _this.next;
			});
		}
		_this.nextAni = function(index) {
			if(index != _this.next){
					if(index == null) {
					  _this.next = _this.next+1;
					}
					else{
					  _this.next = index
					}

					if (_this.next == _lens)
						_this.next = 0;
					_this.ani();
			}
		}

		$btn_nums.on('click', function() {
			_this.stop();

			var num_type = $(this).attr('class');
			var array_num = num_type.split("_");
			var slt_num = array_num[1]-1;

			if (slt_num == _lens) {
				slt_num = 0;
			}
			if (slt_num < 0) {
				slt_num = _lens-1;
			}

			_this.nextAni(slt_num);
		});

		$btns.on('click', function() {
			var type = $(this).attr('class');
			switch(type) {
				case "slide_prev" :
					_this.stop();
					var next = _this.index - 1;
					if (next < 0 ){
						next = _lens-1;
					}

					_this.nextAni(next);
					break;
				case "slide_next" :
					_this.stop();
					var next = _this.index + 1;
					if (next == _lens) {
						next = 0;
					}
					_this.nextAni(next);
					break;
			}
			return false;
		});
	};
})(jQuery);
$(document).ready(function(){
	 $('.photo_slide').photo_slide();
});
//게시물 내 이미지 롤링1
(function($){
	$.fn.board_slide = function(options) {
		var _this   = this,
			$item      = $('.tourism .tour_img_list ul > li'),
			$btns      = $('.tourism .tour_ctrl button'),
			//$btn_nums  = $('.main_btn button'),
			_lens   = $item.length;
		_this.index     = 0;
		_this.next      = 0;
		_this.animated  = false;
   	_this.find('.all').html(_lens);
   	_this.find('.after').html(1);
		_this.ani = function() {
			if (_this.animated) return;
			_this.animated  = true;
			$item.eq(_this.next).show();
			_this.find('.after').html(_this.next+1);

			$item.eq(_this.index).fadeOut(200, function() {
				$(this).removeClass('active');
				$item.eq(_this.next).addClass('active');
				_this.animated = false;
				_this.index = _this.next;
			});
		}

		_this.nextAni = function(index) {
			if(index != _this.next){
					if(index == null) {
					  _this.next = _this.next+1;
					}
					else{
					  _this.next = index
					}

					if (_this.next == _lens)
						_this.next = 0;
					_this.ani();
			}
		}
		$btns.on('click', function() {
			var type = $(this).attr('class');
			switch(type) {
				case "tour_prev" :
					_this.stop();
					var next = _this.index - 1;
					if (next < 0 ){
						next = _lens-1;
					}

					_this.nextAni(next);
					break;
				case "tour_next" :
					_this.stop();
					var next = _this.index + 1;
					if (next == _lens) {
						next = 0;
					}
					_this.nextAni(next);
					break;
			}
			return false;
		});
	};
})(jQuery);
$(document).ready(function(){
	 $('.tourism').board_slide();
});
//게시물 내 이미지 롤링2
(function($){
	$.fn.board_slide2 = function(options) {
		var _this   = this,
			$item      = $('.food_detail .tour_img_list ul > li'),
			$btns      = $('.food_detail .tour_ctrl button'),
			//$btn_nums  = $('.main_btn button'),
			_lens   = $item.length;
		_this.index     = 0;
		_this.next      = 0;
		_this.animated  = false;
   	_this.find('.all').html(_lens);
   	_this.find('.after').html(1);
		_this.ani = function() {
			if (_this.animated) return;
			_this.animated  = true;
			$item.eq(_this.next).show();
			_this.find('.after').html(_this.next+1);

			$item.eq(_this.index).fadeOut(200, function() {
				$(this).removeClass('active');
				$item.eq(_this.next).addClass('active');
				_this.animated = false;
				_this.index = _this.next;
			});
		}

		_this.nextAni = function(index) {
			if(index != _this.next){
					if(index == null) {
					  _this.next = _this.next+1;
					}
					else{
					  _this.next = index
					}

					if (_this.next == _lens)
						_this.next = 0;
					_this.ani();
			}
		}
		$btns.on('click', function() {
			var type = $(this).attr('class');
			switch(type) {
				case "tour_prev" :
					_this.stop();
					var next = _this.index - 1;
					if (next < 0 ){
						next = _lens-1;
					}

					_this.nextAni(next);
					break;
				case "tour_next" :
					_this.stop();
					var next = _this.index + 1;
					if (next == _lens) {
						next = 0;
					}
					_this.nextAni(next);
					break;
			}
			return false;
		});
	};
})(jQuery);
$(document).ready(function(){
	 $('.food_detail').board_slide2();
});
// 탭메뉴 공통적으로 사용
//ex) tabOn(1,1);
function tabOn(tabid,a) {
	for (i=1;i<=10;i++) {
		if(i<10){inn="0"+i;} else {inn=""+i;}
		tabMenu = document.getElementById("tab"+tabid+"m"+i);
		tabContent = document.getElementById("tab"+tabid+"c"+i);
		tabMore = document.getElementById("tab"+tabid+"more"+i);
		if (tabMenu) { //객체가존재하면
			if (tabMenu.tagName=="A") { tabMenu.className=""; } //앵커일때
			if (tabMenu.tagName=="BUTTON") { tabMenu.className=""; } //버튼일때
			if (tabMenu.tagName=="BUTTON") { tabMenu.parentNode.className=""; } //버튼일때
			if (tabMenu.tagName=="SPAN") { tabMenu.className=""; } //span 일때
			if (tabMenu.tagName=="SPAN") { tabMenu.parentNode.className=""; } //span 일때 부모요소에도 클래스 삭제
		}
		if (tabContent) { tabContent.style.display="none"; }
		if (tabMore) { tabMore.style.display="none"; }
	}
	if(a<10){ann="0"+a;} else {ann=""+a;}
	tabMenu = document.getElementById("tab"+tabid+"m"+a);
	tabContent = document.getElementById("tab"+tabid+"c"+a);
	tabMore = document.getElementById("tab"+tabid+"more"+a);
	if (tabMenu) { //객체가존재하면
		if (tabMenu.tagName=="A") { tabMenu.className="on"; } //앵커일때
		if (tabMenu.tagName=="BUTTON") { tabMenu.className="on"; } //버튼일때
		if (tabMenu.tagName=="BUTTON") { tabMenu.parentNode.className="on"; } //버튼일때
		if (tabMenu.tagName=="SPAN") { tabMenu.className="on"; } //span 일때
		if (tabMenu.tagName=="SPAN") { tabMenu.parentNode.className="on"; } //span 일때 부모요소에도 클래스추가
	}
	if (tabContent) { tabContent.style.display="block"; }
	if (tabMore) { tabMore.style.display="block"; }
};
// 문화관광 게시물 상세보기 공통적으로 사용
//ex) ttabOn(1,1);
function ttabOn(ttabid,a) {
	for (i=1;i<=10;i++) {
		if(i<10){inn="0"+i;} else {inn=""+i;}
		tabMenu = document.getElementById("ttab"+ttabid+"m"+i);
		tabContent = document.getElementById("ttab"+ttabid+"c"+i);
		if (tabMenu) { //객체가존재하면
			if (tabMenu.tagName=="A") { tabMenu.className=""; } //앵커일때
			if (tabMenu.tagName=="BUTTON") { tabMenu.className=""; } //버튼일때
			if (tabMenu.tagName=="BUTTON") { tabMenu.parentNode.className=""; } //버튼일때
			if (tabMenu.tagName=="SPAN") { tabMenu.className=""; } //span 일때
			if (tabMenu.tagName=="SPAN") { tabMenu.parentNode.className=""; } //span 일때 부모요소에도 클래스 삭제
		}
		if (tabContent) { tabContent.style.height="0"; }
	}
	if(a<10){ann="0"+a;} else {ann=""+a;}
	tabMenu = document.getElementById("ttab"+ttabid+"m"+a);
	tabContent = document.getElementById("ttab"+ttabid+"c"+a);
	if (tabMenu) { //객체가존재하면
		if (tabMenu.tagName=="A") { tabMenu.className="on"; } //앵커일때
		if (tabMenu.tagName=="BUTTON") { tabMenu.className="on"; } //버튼일때
		if (tabMenu.tagName=="BUTTON") { tabMenu.parentNode.className="on"; } //버튼일때
		if (tabMenu.tagName=="SPAN") { tabMenu.className="on"; } //span 일때
		if (tabMenu.tagName=="SPAN") { tabMenu.parentNode.className="on"; } //span 일때 부모요소에도 클래스추가
	}
	if (tabContent) { tabContent.style.height="inherit"; }
};
$(document).ready(function(){
	//이미지 롤오버
	 $(".overimg").mouseover(function (){
		var file = $(this).attr('src').split('/');
		var filename = file[file.length-1];
		var path = '';
		for(i=0 ; i < file.length-1 ; i++){
		 path = ( i == 0 )?path + file[i]:path + '/' + file[i];
		}
		$(this).attr('src',path+'/'+filename.replace('_off.','_on.'));

	 }).mouseout(function(){
		var file = $(this).attr('src').split('/');
		var filename = file[file.length-1];
		var path = '';
		for(i=0 ; i < file.length-1 ; i++){
		 path = ( i == 0 )?path + file[i]:path + '/' + file[i];
		}
		$(this).attr('src',path+'/'+filename.replace('_on.','_off.'));
	 });
});
// 새창열기
function newWin(url, width, height) {
	window.open(url, "height="+height+",width="+width+",left=0,top=0,toolbar=no,scrollbars=no,status=no,resizable=no");
};
function messageByteCk(viewId, byteId, maxLen, byteAt){

    var ls_str = $('#'+viewId).val();
    var li_str_len = ls_str.length;
    var msg_max_len = maxLen;
    var msg_byte = 0;
    var before_byte = 0;
    var len = 0;
    var ls_one_char = "";
    var result_str = "";

    for(var i=0; i<ls_str.length; i++){
        ls_one_char = ls_str.charAt(i);
        if(escape(ls_one_char).length > 4){
        	if(byteAt){
                msg_byte += 2;
        	}else{
        		msg_byte ++;
        	}
        }else{
            msg_byte++;
        }

        if(msg_byte <= msg_max_len){
            len = i + 1;
            before_byte = msg_byte;
        }else{
			alert("200자를 초과할수 없습니다");
            break;
        }

    }
    if($('#'+viewId).val()==""){
        $('#'+byteId).val(msg_byte);
    }else if(msg_byte > msg_max_len){
        //alert(li_max + " 200자를 초과할수 없습니다.");
        result_str = ls_str.substr(0,len);
        $('#'+viewId).val(result_str);
        $('#'+byteId).val(before_byte);
    }else{
    	$('#'+byteId).val(msg_byte);
    }
}

/* 이미지의 원본 사이즈를 추출하여 max-width값으로 넣어준다 */
function fn_imageSize( imgObj ) {

	imgObj.each(function() {
		var image = new Image();
		image.src = $(this).attr("src");
		// 이미지 사이즈 못불러올경우 0으로 들어가게됨으로 사이즈가 0이상일때만 max-width값을 준다.
		if( image.width ) {
			$(this).css("max-width", image.width);
			$(this).css("width", "100%");
			$(this).css("max-height", image.height);
			$(this).css("height","100%");
		}
	});

}
$(document).ready(function(){
	fn_imageSize($("#contents img.img_size,#contents .box_img img"));
});

/* SNS 공유하기 */
function sendSns(sns, url, txt)
{
    var o;
    var _url = encodeURIComponent(url);
    var _txt = encodeURIComponent(txt);
    var _br  = encodeURIComponent('\r\n');

    switch(sns)
    {
        case 'facebook':
            o = {
                method:'popup',
                url:'http://www.facebook.com/sharer/sharer.php?u=' + _url
            };
            break;

        case 'twitter':
            o = {
                method:'popup',
                url:'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
            };
            break;

        case 'google':
            o = {
                method:'popup',
                url:'https://plus.google.com/share?url=' + _url
            };
            break;

        case 'kakaotalk':
            o = {
                method:'web2app',
                param:'sendurl?msg=' + _txt + '&url=' + _url + '&type=link&apiver=2.0.1&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent(document.title),
                a_store:'itms-apps://itunes.apple.com/app/id362057947?mt=8',
                g_store:'market://details?id=com.kakao.talk',
                a_proto:'kakaolink://',
                g_proto:'scheme=kakaolink;package=com.kakao.talk'
            };
            break;

        case 'kakaostory':
            o = {
                method:'web2app',
                param:'posting?post=' + _txt + _br + _url + '&apiver=1.0&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent(document.title),
                a_store:'itms-apps://itunes.apple.com/app/id486244601?mt=8',
                g_store:'market://details?id=com.kakao.story',
                a_proto:'storylink://',
                g_proto:'scheme=kakaolink;package=com.kakao.story'
            };
            break;

        case 'band':
            o = {
                method:'web2app',
                param:'create/post?text=' + _txt + _br + _url,
                a_store:'itms-apps://itunes.apple.com/app/id542613198?mt=8',
                g_store:'market://details?id=com.nhn.android.band',
                a_proto:'bandapp://',
                g_proto:'scheme=bandapp;package=com.nhn.android.band'
            };
            break;

        default:
            alert('지원하지 않는 SNS입니다.');
            return false;
    }

    switch(o.method)
    {
        case 'popup':
            window.open(o.url);
            break;

        case 'web2app':
            if(navigator.userAgent.match(/android/i))
            {
                // Android
                setTimeout(function(){ location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'}, 100);
            }
            else if(navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i))
            {
                // Apple
                setTimeout(function(){ location.href = o.a_store; }, 200);
                setTimeout(function(){ location.href = o.a_proto + o.param }, 100);
            }
            else
            {
                alert('이 기능은 모바일에서만 사용할 수 있습니다.');
            }
            break;
    }
}
