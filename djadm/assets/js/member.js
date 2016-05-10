$(document).ready(function() {
	// 로그인 처리
	/*$('#btnLoginAction').click(function() {
		var bCheckFlag = true;
		var strReg = /^[A-Za-z0-9]+$/;

		if ($('#memberId').val() === '') {
			bCheckFlag = false;
			$('#memberIdError').html("아이디를 입력하세요.");
		} else if (strReg.test($('#memberId').val()) === false) {
			bCheckFlag = false;
			$('#memberIdError').html("아이디는 영문과 숫자만 입력가능합니다.");
		} else
			$('#memberIdError').html('&nbsp;');

		if ($('#memberPw').val() === '') {
			bCheckFlag = false;
			$('#memberPwError').html("비밀번호를 입력하세요.");
		} else
			$('#memberPwError').html('&nbsp;');

		if (bCheckFlag === true)
			$('#memberLoginForm').submit();
		else
			return false;
	});*/

	// 회원 검색 처리
	$('#btnSearch').click(function() {
		var act = sSearchUrl + '/page/1';
		$("#search_form").attr('action', act).submit();
	});

	$('input[name=sSearchWord]').click(function() {
		var keycode = window.event.keyCode;
		if(keycode == 13) $("#btnSearch").click();
	});

	/*$('#btnMemberAction').click(function() {
		//alert($('label[for=mNoId]').html());
		$.fn.chkFormValidate();
		return false;
	});*/

	$('#btnMemberCancel').click(function() {
		history.back();
	});
});