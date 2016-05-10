var listLength; // 대표 메인 자주찾는 서비스 반응형 적용
if(navigator.userAgent.indexOf("MSIE 7") > 0) {
	$( 'body, html' ).css({  overflow: 'auto' });
} else if(navigator.userAgent.indexOf("MSIE 8") > 0) {
	listLength = 3;
} else {

	//메인 사이즈
	$("document").ready(function(){
		//alert($(window).width());
		if ( $(window).width() > 1024){
			listLength = Math.ceil($(".fvrt_list li").length / 9);
		} else if ($(window).width() > 667 && $(window).width() < 1024){
			$(".service.slide_effect .srvc h2").removeClass("open");
			mobile_snsissue('snsHot');
			listLength = Math.ceil($(".fvrt_list li").length / 6);
		} else {
			mobile_snsissue('service');
			listLength = Math.ceil($(".fvrt_list li").length / 4);
		}
	});

	$(window).resize(function() {

		if ( $(window).width() > 1024){
			listLength = Math.ceil($(".fvrt_list li").length / 9);
			mobile_snsissue();
			return false;
		} else if ($(window).width() > 667 && $(window).width() < 1024){
			mobile_snsissue('snsHot');
			listLength = Math.ceil($(".fvrt_list li").length / 6);
			return false;
		} else {
			mobile_snsissue('service');
			listLength = Math.ceil($(".fvrt_list li").length / 4);
		}
	})
}
//메인 비주얼
(function($){
	$.fn.Visual = function(options) {

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

		settings.cnt = settings.areaDiv.find('.visual_list > li').length;
		settings.waitingTime = parseInt(settings.waitingTime);
		settings.nowNum = 0;
		settings.moveFlag = true;
		settings.moveType;
		settings.setTimeOut;
		var status=true;

		function emptySetting() {
			settings.areaDiv.find('.count').html(settings.nowNum+1);
			settings.areaDiv.find('.all').html(settings.cnt);
			settings.areaDiv.find('.visual_list > li').hide();
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

			if(aniFlag) settings.areaDiv.find('.visual_list > li').eq(settings.nowNum).show();
			else settings.areaDiv.find('.visual_list > li').eq(settings.nowNum).fadeIn('normal');
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
			//정지 재생버튼 이미지로 제어.
			if(status){
				clearTimeout(settings.setTimeOut);
				settings.playBtn.find('img').attr('src',"/images/m_banner_btn_play.png");
				settings.playBtn.find('img').attr('alt',"롤링 재생");
				status = false;
			}else{
				settings.playBtn.find('img').attr('src',"/images/m_banner_btn_stop.png");
				settings.playBtn.find('img').attr('alt',"롤링 정지");
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
	};
})(jQuery);
$(document).ready(function(){
	 $('.visual').Visual({
		prevBtn : '.visual_prev',
		nextBtn : '.visual_next',
		playBtn : '.visual_play',
		waitingTime : '5000'
	});
});
/* 자주찾는 서비스 */
$(document).ready(function(){
	var listAfter = 1;
	var moveSize  = $(".fvrt_list li").height();
	var animateVal = 0;

	$leftB=$(".fvrt_ctrl .fvrt_next");
	$rightB=$(".fvrt_ctrl .fvrt_prev");
	$leftB.click(function(){
		if(listAfter < listLength){
			listAfter++;
			animateVal -= parseInt(moveSize);
			$(".fvrt_list").stop().animate({top: animateVal+"px"},200);
		}else{
			return false;
		}
	});
	$rightB.click(function(){
		if(listAfter > 1){
			listAfter--;
			animateVal += parseInt(moveSize);
			$(".fvrt_list").stop().animate({top: animateVal+"px"},200);
		}else{
			return false;
		}
	});
});
//모바일 태블릿의  sns, issue 펼침
function mobile_snsissue( mode ){

	$(".slide_effect div ul").css("display","");

	if( "service" == mode ) {
		$(".slide_effect div h3").removeClass("close");
		$(".slide_effect div h3").unbind();
		$(".slide_effect div h3").click(function(){
			$(this).toggleClass("close");
			$(this).siblings("ul").stop().slideToggle(400);
			return false;
		});
	} else if( "snsHot" == mode ) {
		$(".slide_effect div h3").removeClass("close");
		$(".slide_effect div h3").unbind();
		$(".colgroup3 .slide_effect div h3").click(function(){
			$(this).toggleClass("close");
			$(this).siblings("ul").stop().slideToggle(400);
			return false;
		});
	} else {
		$(".slide_effect div h3").removeClass("close");
		$(".slide_effect div h3").unbind();
	}

//	if ( !ismSnsIssue ) {
//		ismSnsIssue = true;
		/*$(".colgroup3 .wrap div h2.open").click(function(){
			var cntHeight = $(this).siblings(".cnt_height").height();
			$(this).removeClass("open").addClass("close").parent("div").animate({"height": cntHeight},500);
		});
		$(".colgroup3 .wrap div h2.close").click(function(){
			var cntHeight = $(this).siblings(".cnt_height").height();
			$(this).removeClass("open").addClass("close").parent("div").animate({"height": cntHeight},500);
		});*/
//		$(".slide_effect div h2").click(function(){
//			$(this).toggleClass("close");
//			$(this).siblings("ul").stop().slideToggle(400);
//			return false;
//		});
//	}
}

//플로팅
/*
$(document).ready(function(){
	var currentPosition = parseInt($("#floating").css("top"));
	$(window).scroll(function() {
		var position = $(window).scrollTop(); // 현재 스크롤바의 위치값을 반환합니다.
		var pageHeight = $("#container").height();
		//alert(pageHeight);
		//alert(position);
		if(position <= pageHeight){
			$("#floating").stop().animate({"top":position+currentPosition+130+"px"},500);
			//alert(position,currentPosition);
		};
		if(position == 0){
			$("#floating").stop().animate({"top":position+currentPosition+"px"},500);
			//alert(position,currentPosition);
		};
	});
});*/
//Main Visual
/*
function mainVisual_slide(a) {

	var _this   = this,
		$item      = $('.visual_list li'),
		$btns      = $('.visual_ctrl button'),
		_lens   = $item.length;
	_this.index     = 0;
	_this.next      = 0;
	_this.animated  = false;
	_this.interval  = null;
	_this.auto_play = true;
	_this.time      = 5000; //시간

	_this.ani = function() {
		if (_this.animated) return;
		_this.animated  = true;
		$item.eq(_this.next).show();

		$item.eq(_this.index).fadeOut(500, function() {
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
				//_this.next = index || _this.next+1;

				if (_this.next == _lens)
					_this.next = 0;
				_this.ani();
		}
	}
	_this.auto = function() {
		_this.interval = setInterval(function() {
			_this.nextAni();
		}, _this.time);
	}
	_this.stop = function() {
		clearInterval(_this.interval);
		_this.interval = null;
	}

	$btns.on('click', function() {
		var type = $(this).attr('class');
		switch(type) {
			case "prev" :
				_this.stop();
				var next = _this.index - 1;
				if (next < 0 ){
					next = _lens-1;
				}
				_this.nextAni(next);
				if (_this.auto_play)
					_this.auto();
				break;
			case "next" :
				_this.stop();
				var next = _this.index + 1;
				if (next == _lens) {
					next = 0;
				}
				_this.nextAni(next);
				if (_this.auto_play)
					_this.auto();
				break;
		}
		return false;
	});
	_this.init = function( a ) {
		$item.eq(0).addClass('active');
		_this.auto_play = a || _this.auto_play;
		if (_this.auto_play) {
			_this.auto();
		}
	}
}
// 공지사항
(function($){
	$.fn.Notice = function(options) {

		var settings = {
			prevBtn : '',
			nextBtn : '',
			waitingTime : ''
		};

		$.extend(settings, options);
		settings.areaDiv = this;
		settings.prevBtn = $(settings.prevBtn);
		settings.nextBtn = $(settings.nextBtn);

		settings.cnt = settings.areaDiv.find('li').length;  //공지사항 게시물 개수
		settings.waitingTime = parseInt(settings.waitingTime);
		settings.nowNum = 0;
		settings.moveFlag = true;
		settings.moveType;
		settings.setTimeOut;
		var status=true;

		function emptySetting() {
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

			aniFlag = false;
			settings.moveFlag = false;
			if(status){
				settings.setTimeOut= setTimeout(setRolling , settings.waitingTime);
			}
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
	};

})(jQuery);

$(document).ready(function(){
	 $('.notice').Notice({
		prevBtn : '.ntc_btn_prev',
		nextBtn : '.ntc_btn_next',
		waitingTime : '5000'

	});
});

// 이벤트
(function($){
	$.fn.Event = function(options) {

		var settings = {
			prevBtn : '',
			nextBtn : '',
			waitingTime : ''
		};

		$.extend(settings, options);
		settings.areaDiv = this;
		settings.prevBtn = $(settings.prevBtn);
		settings.nextBtn = $(settings.nextBtn);

		settings.cnt = settings.areaDiv.find('li').length;  //공지사항 게시물 개수
		settings.waitingTime = parseInt(settings.waitingTime);
		settings.nowNum = 0;
		settings.moveFlag = true;
		settings.moveType;
		settings.setTimeOut;
		var status=true;

		function emptySetting() {
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

			aniFlag = false;
			settings.moveFlag = false;
			if(status){
				settings.setTimeOut= setTimeout(setRolling , settings.waitingTime);
			}
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
	};

})(jQuery);

$(document).ready(function(){
	 $('.main_event').Event({
		prevBtn : '.eve_btn_prev',
		nextBtn : '.eve_btn_next',
		waitingTime : '5000'

	});
});
//탑메뉴
jQuery(function($){
	$(".topmenu a").mouseenter(function(){
		$("#header .tm2depth").fadeIn("fast");
	});
	$("#header").mouseleave(function(){
		$("#header .tm2depth").fadeOut("fast");
	});
	$(".top_btn").click(function(){
		location.reload(true);
	});
});

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
*/
