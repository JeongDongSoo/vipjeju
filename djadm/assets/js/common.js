$(document).ready(function() {
	/************************************************************************************************
	 * 페이지네이션에서 페이지 클릭 시
	 * Since : 2016-05-06
	 * Version : 1.0.0
	 * Param : int nPage (클릭 page)
	 * Note : 페이지네이션을 추가하는 페이지에 검색폼 아이디('search_form') 와 sSearchUrl 값이 필수 존재!!
	 ************************************************************************************************/
	$.fn.clickPage = function(nPage) {
		var act = sSearchUrl + '/page/' + nPage;
		$("#search_form").attr('action', act).submit();
	}
});