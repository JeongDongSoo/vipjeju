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
	});

	// 회원 추가
	$('#btnAddEmployee').click(function() {
		if (confirm("직원을 등록 하시겠습니까?")) {
			var act = sCurrentUrl + '/page/' + nPage + "/insert";
			$("#search_form").attr('action', act).submit();
		}
	});

	// 회원 아이디 중복 체크
	$("#mIdId").blur(function() {
		var sInputId = $(this).attr("id");
		if ($('#' + sInputId + "Error").html() == '&nbsp;') {
			$.ajax({
				type:"post",
				url: sCurrentClass + "/chkDuplicateId",
				dataType: "json",
				data: {"sMId" : $(this).val()},
				success:function(data){
					if (data['nDuplNum'] != 0){
						$('#' + sInputId + 'Error').html('동일한 아이디가 존재합니다.');
					}
					else
						$('#' + sInputId + 'Error').html('&nbsp;');
				}
			});
		}
	});
});