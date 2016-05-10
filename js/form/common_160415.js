var num = "0123456789"
var salpha = "abcdefghijklmnopqrstuvwxyz"
var alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"+salpha
var check_email = /^([A-Za-z0-9_-]{1,15})(@{1})([A-Za-z0-9_-]{1,15})(.{1})([A-Za-z0-9_-]{2,10})(.{1}[A-Za-z]{2,10})?(.{1}[A-Za-z]{2,10})?$/;
var home=alpha+num+":/.@?~&=_-%";

$('.btn_popup').click(function() {
	var $href = $(this).attr('value');
	layer_popup($href);
});

function layer_popup(el) {
	var $el = $(el);        //레이어의 id를 $el 변수에 저장
	var isDim = $el.prev().hasClass('dimBg');   //dimmed 레이어를 감지하기 위한 boolean 변수

	isDim ? $('.dim-layer').fadeIn() : $el.fadeIn();

	var $elWidth = ~~($el.outerWidth()),
		$elHeight = ~~($el.outerHeight()),
		docWidth = $(document).width(),
		docHeight = $(document).height();

	// 화면의 중앙에 레이어를 띄운다.
	if ($elHeight < docHeight || $elWidth < docWidth) {
		$el.css({
			marginTop: -$elHeight /2,
			marginLeft: -$elWidth/2
		})
	} else {
		$el.css({top: 0, left: 0});
	}

	$el.find('a.btn-layerClose').click(function() {
		isDim ? $('.dim-layer').fadeOut() : $el.fadeOut(); // 닫기 버튼을 클릭하면 레이어가 닫힌다.
		return false;
	});

	$el.find('a.btn-layerClose2').click(function() {
		if(!$('div.pop-conts').find('#pop_agree2').prop('checked')) {
			alert('[바로예약] 확인사항의 확인 체크를 하셔야 적용됩니다.');
			return false;
		}

		isDim ? $('.dim-layer').fadeOut() : $el.fadeOut(); // 닫기 버튼을 클릭하면 레이어가 닫힌다.
		return false;
	});

	$el.find('a.btn-layerClose3').click(function() {
		if(!$('div.pop-conts').find('#pop_agree3').prop('checked')) {
			alert('[기사 포함 대여] 확인사항의 확인 체크를 하셔야 적용됩니다.');
			return false;
		}

		isDim ? $('.dim-layer').fadeOut() : $el.fadeOut(); // 닫기 버튼을 클릭하면 레이어가 닫힌다.
		return false;
	});

	$('.layer .dimBg').click(function() {
		$('.dim-layer').fadeOut();
		return false;
	});

}

function lay_open(el, content) {
	$('.pop-conts').html(content);
	layer_popup(el);
}

function getLayerOpen(el) {
	var sHtml = $(el).html();

	lay_open('#pop_limit_age', sHtml);

}

function closePopup(popup, today) {
	if (today == "Y")
		setCookie(popup, "done", 1);

	document.getElementById(popup).style.display = "none";
}

function popupLogin() {
	login = getCookie('login');

	if (login != '') {
		successPopupLogin(login);
	} else {
		win = window.open('/member/login_popup', 'login', 'top=150,left=150,width=760,height=451');
		win.focus();
	}
}

function type_check(str, spc) { //입력한 값에 포함한 문자를 하나씩 체크
	var i;
	for(i=0; i< str.length; i++) {
		if(spc.indexOf(str.substring(i, i+1)) < 0) { return false;    }
	}
	return true;
}

function strRegChk(str, start, end) {
	var strReg = new RegExp('^[a-z0-9]{' + start + ',' + end + '}$');
	if( !strReg.test(str) ) {
		return false;
	}
	return true;
}

function strRegSpecialChk(str, start, end) {
//	 var strReg = /^.*(?=.{4,12}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;
	var strReg = new RegExp('^[a-zA-Z0-9!@#$%^&+=*()-_+|]{' + start + ',' + end + '}$');
	if( !strReg.test(str) ) {
		return false;
	}
	return true;
}



function GetInternetExplorerVersion() {
	var rv = -1;
	if (navigator.appName == 'Microsoft Internet Explorer') { //ie 7,8,9,10
		var ua = navigator.userAgent;
		var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		if (re.exec(ua) != null)
			rv = parseFloat( RegExp.$1 );
	}
	else if (navigator.appName == 'Netscape') { //ie 11
		var ua = navigator.userAgent;
		var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
		if (re.exec(ua) != null)
			rv = parseFloat( RegExp.$1 );
	}
	return rv;
}

/**
 * 콤마 붙이기 함수
 * @param value int
 */
function setComma(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

/**
 * 콤마 제거 함수
 * @param value int
 */
function unComma(nStr) {
	return parseInt(nStr.replace(/,/g, ""));
}

function setCookie(name, value, expiredays) {
	var ua = navigator.userAgent;
	var msie = ua.indexOf("MSIE");
	var trident = ua.indexOf("Trident");

	if (expiredays == 0) {
		if (msie > 0 || trident > 0)
			document.cookie = name + "=" + escape(value) + "; path=/;";
		else
			document.cookie = name + "=" + escape(value) + "; path=/; expires=0;";
	} else {
		var todayDate = new Date();

		todayDate.setDate(todayDate.getDate() + expiredays);

		document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
	}
}

function getCookie(name) {
	var nameOfCookie = name + "=";
	var x = 0;

	while (x <= document.cookie.length) {
		var y = (x + nameOfCookie.length);

		if (document.cookie.substring(x, y) == nameOfCookie) {
			if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
				endOfCookie = document.cookie.length;

			return unescape(document.cookie.substring(y, endOfCookie));
		}

		x = document.cookie.indexOf(" ", x) + 1;

		if (x == 0)
			break;
	}

	return "";
}

function rangeSelect(name, min, max, select, prefix, postfix, onchange) {
	code = '<select id="' + name + '" name="' + name + '"';

	if (onchange != '')
		code += ' onchange="' + onchange + '"';

	code += '>';

	for (i = min; i <= max; i++) {
		code += '<option value="' + i + '"';

		if (i == select)
			code += ' selected';

		code += '>' + prefix + i + postfix + '</option>';
	}

	code += '</select>';

	return code;
}

$(function() {//포괄적용
	$(".only-hangul").css("imeMode","active").keyup(function(e) {
		regexp = /([^가-힣ㄱ-ㅎㅏ-ㅣ\x20])/i;
		v = $(this).val();
		if( regexp.test(v) ) {
			alert("한글만 입력하세요.");
			$(this).val(v.replace(regexp,''));
		}
	});

	//INPUT박스에 숫자키만 입력
	$(".only-numeric").css("imeMode","disabled").keypress(function(e) {
		var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
		if (verified) {e.preventDefault();}
	});

	//INPUT박스에 숫자키만 입력(동적대응)
	$(document).on("keypress",".only-numeric",function(e){
		$(this).css("imeMode","disabled");
		var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
		if (verified) {e.preventDefault();}
	});

	//차종 선택에 따른 차량 리스트(빠른예약)
	$.getScCarList = function(car_kind) {
		var action = '/rent/get_car_list';
		var set_data = {
			'car_kind' : car_kind
		}

		$.post(action, set_data, function(rdata) {
		}, 'json')
			.done(function(rdata) {
				$('#sc_car_id').empty();
				$('#sc_car_id').append($('<option value="">').text('차량을 선택하세요'));

				var toAppend = '';
				$.each(rdata.aCarList, function(i, obj) {
					if(obj.id == car_id) {
						toAppend += '<option value="'+obj.id+'" selected="selected">'+obj.name+'</option>';
					} else {
						toAppend += '<option value="'+obj.id+'">'+obj.name+'</option>';
					}
				});
				$('#sc_car_id').append(toAppend);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert('데이터 정보 변경에 실패하였습니다.');
			})
			.always(function(rdata) {
			});
	}

	//차종 선택 시(빠른예약)
	$('#sc_car_kind').on('change',function() {
		var sel_car_kind = $(this).find('option:selected').val();

		if(sel_car_kind) {
			$.getScCarList(sel_car_kind);
		}
	});

	if(car_kind) {
		$.getScCarList(car_kind);
	}

	// 이전 다음 버튼
	var $prev = $('.prev');
	var $next = $('.next');

	$prev.on('mouseenter',function() {
		$(this).find('img').attr('src','/assets/images/common/btn_prev01_on.png');
	});
	$prev.on('mouseleave',function() {
		$(this).find('img').attr('src','/assets/images/common/btn_prev01.png');
	});

	$next.on('mouseenter',function() {
		$(this).find('img').attr('src','/assets/images/common/btn_next01_on.png');
	});
	$next.on('mouseleave',function() {
		$(this).find('img').attr('src','/assets/images/common/btn_next01.png');
	});

	$('img').each(function(n){
		$(this).error(function(){
			$(this).attr('src', '/assets/images/car/car_no.jpg');
		});
	});

	//숫자만 입력
	$(".onlynum").keyup(function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});

	/* ---------------------------------------------------- */
	/*	팝업 창 띄우기
	/* ---------------------------------------------------- */
	$.openWin = function(url,title,width,height) {
		window.open(url, title, "top=500, left=0, width="+width+", height="+height+", toolbar=no, menubar=no, scrollbars=yes, resizable=no" );
	}

	/* ---------------------------------------------------- */
	/*	레이어 창 띄우기
	/* ---------------------------------------------------- */
	$('.pop_wrap').on('click', function(e) {
		e.preventDefault();

		var pop_wrap_id = $(this).data('pop-wrap-id');
		var sHtml = $('#'+pop_wrap_id).find('div.pop-target-conts').html();

		lay_open('#pop_limit_age', sHtml);
	});
});

/* ---------------------------------------------------- */
/*	사용자 포인트 사용 기능 처리
/* ---------------------------------------------------- */
function userUsePoint() {
	var that = this;
	var pointSolubleType = 'rounding';	//가용포인트 계산방식(rounding:반올림, dscending:버림, ascending:올림)
	var pointSolubleRate = 30; 	//가용포인트 퍼센트률(30%)

	this.init = function(price,elename) {
		that.initSolublePoint(price,elename);
		that.initEvent(elename);
	}

	//사용자 보유 포인트에 대한 가용 가능한 포인트 계산 처리
	this.initSolublePoint = function(price,elename) {
		var solublePoint = 0;
		if(pointSolubleType === 'rounding') {
			solublePoint = Math.round(price * (pointSolubleRate / 100 ));
		} else if(pointSolubleType === 'dscending') {
			solublePoint = Math.floor(price * (pointSolubleRate / 100 ));
		} else if(pointSolubleType === 'ascending') {
			solublePoint = Math.ceil(price * (pointSolubleRate / 100 ));
		}
		$('#'+elename).attr('data-solublepoint',solublePoint);
	}

	/* 이벤트 선언 */
	this.initEvent = function(elename) {
		$('#'+elename).on('keyup',that.onUsePoint); //포인트 input박스 이벤트
		$('#'+elename+'_chk').on('change',that.onUseCheckToggle); //포인트 사용 check박스 이벤트
	}

	this.onUsePoint = function() {
		if( $(this).val() != null && $(this).val() != "" ) {
			var tmps = $(this).val().replace(/^0+/, "");
			tmps = tmps.replace(/[^0-9]/g, "");
			var tmps2 = tmps.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			$(this).val(tmps2);

			//맥스 값이 지정되어 있는 경우
			if(typeof($(this).data("solublepoint")) !== "undefined") {
				var maxs = $(this).data("solublepoint").toString();
				var maxs2 = maxs.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				if(parseInt(tmps) > parseInt(maxs)) {
					alert("사용 가능한 최대 포인트는("+maxs2+"P)입니다.");
					$(this).val(maxs2);
					return false;
				}
			}
		}
	}

	this.onUseCheckToggle = function() {
		var use_point = 0;
		use_point = ($('#'+$(this).attr('id')).prop('checked') === true) ? 1 : 0;
		$('#use_point').val(use_point);
	}
}

function main_search() {
	if ($.trim($('#top_search').val()) == '') {
		alert('검색어를 입력해 주세요.');
		return false;
	}

	$('#top_search_form').submit();
}

/**
 * 자바스크립트 Date 객체를 Time 스트링으로 변환
 * parameter date: JavaScript Date Object
 */
function toTimeString(date) {
	var year  = date.getFullYear();
	var month = date.getMonth() + 1; // 1월=0,12월=11이므로 1 더함
	var day   = date.getDate();

	if (("" + month).length == 1) {month = "0" + month;}
	if (("" + day).length   == 1) {day   = "0" + day;}

	return ("" + year + month + day)
}

/**
 * 현재 시각을 Time 형식으로 리턴
 */
function getCurrentTime(date) {
	return toTimeString(new Date(date));
}

/**
 * 현재 年을 YYYY형식으로 리턴
 */
function getYear(date) {
	return getCurrentTime(date).substr(0,4);
}

/**
 * 현재 月을 MM형식으로 리턴
 */
function getMonth(date) {
	return getCurrentTime(date).substr(4,2);
}

/**
 * 현재 日을 DD형식으로 리턴
 */
function getDay(date) {
	return getCurrentTime(date).substr(6,2);
}

/**
 * 현재 날짜를 YYYY-MM-DD형식으로 리턴
 */
function getDate(day) {
	var d = new Date();
	var dt = d - day*24*60*60*1000;
	return getYear(dt) + '-' + getMonth(dt) + '-' + getDay(dt);
}

/**
 * 날짜를 YYYY-MM-DD형식으로 리턴
 */
function getDateYmd(date) {
	return getYear(date) + '-' + getMonth(date) + '-' + getDay(date);
}

/**
 * 날짜를 MM/DD형식으로 리턴
 */
function getDateMd(date) {
	return getMonth(date) + '/' + getDay(date);
}

function countTime(mode) {
	//초기값
	var minute = 3;
	var second = 0;
	var txt_second = '00';
	var timer;
	// 초기화
	$("#auth_min_"+mode).html(minute);
	$("#auth_sec_"+mode).html(txt_second);

	timer = setInterval(function () {
		// 설정
		$("#auth_min_"+mode).html(minute);
		$("#auth_sec_"+mode).html(txt_second);

		if(second == 0 && minute == 0) {
			if (mode == 'join') {
				$('#chk_auth').prop('value', 0);
				$('#code_form').css('display', 'none');
				$('#get_code_tag').css('display', '');
				$('#auth_num').prop('value', '');
			} else  if (mode == 'id' || mode == 'pwd') {
				$('#auth_num_'+mode).prop('value', '');

				$('#code_num_'+mode).prop('value', '');
				$('#auth_form_'+mode).removeClass();
				$('#auth_form_'+mode).addClass('dp_none');
			} if (mode == 'login') {
				$('#code_form').css('display', 'none');
				$('#code_num').prop('value', '');
				$('#auth_num').prop('value', '');
			}
			alert("인증번호 입력 시간이 초과 되었습니다.\n인증번호 재전송 후 인증번호를 정확히 입력해 주세요.");
			clearInterval(timer); /* 타이머 종료 */
		} else {
			second--;

			// 분처리
			if(second < 0){
				minute--;
				second = 59;
			}

			if (second < 10) txt_second = '0'+second;
			else {
				txt_second = second;
			}
		}
	}, 1000); /* millisecond 단위의 인터벌 */

	return timer;
}

// 이미 지나간날은 선택막기
function noBefore(date){
	if (date < new Date()) {
		return [false];
	}
	return [true];
}

function isYYYYMMDD(y, m, d) {
	switch (m) {
	case 2:        // 2월의 경우
			if (d > 29) return false;
			if (d == 29) {
					// 2월 29의 경우 당해가 윤년인지를 확인
					if ((y % 4 != 0) || (y % 100 == 0) && (y % 400 != 0))
							return false;
			}
			break;
	case 4:        // 작은 달의 경우
	case 6:
	case 9:
	case 11:
			if (d == 31) return false;
	}
	// 큰 달의 경우
	return true;
}