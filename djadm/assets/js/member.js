$(document).ready(function() {
	// 회원 검색 처리
	$('#btnSearch').click(function() {
		var act = sCurrentUrl + '/page/1';
		$("#search_form").attr('action', act).submit();
	});

	$('input[name=sSearchWord]').click(function() {
		var keycode = window.event.keyCode;
		if(keycode == 13) $("#btnSearch").click();
	});

	// 회원 선택
	$('.sel_member').dblclick(function() {
		var act = sCurrentUrl + '/page/' + nPage + "/" + $(this).attr("id");
		$("#search_form").attr('action', act).submit();
		//$(location).attr('href', sCurrentUrl + "/" + $(this).attr("id"));
	});
});