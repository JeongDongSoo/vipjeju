$(document).ready(function() {
	/************************************************************************************************
	 * 페이지네이션에서 페이지 클릭 시
	 * Since : 2016-05-06
	 * Version : 1.0.0
	 * Param : int nPage (클릭 page)
	 * Note : 페이지네이션을 추가하는 페이지에 검색폼 아이디('search_form') 와 sSearchUrl 값이 필수 존재!!
	 ************************************************************************************************/
	$.fn.clickPage = function(nPage) {
		var act = sCurrentUrl + '/page/' + nPage;
		$("#search_form").attr('action', act).submit();
	}

	/************************************************************************************************
	 * form의 validation 체크
	 * Since : 2016-05-10
	 * Version : 1.0.0
	 * Param : String sChkGubun (선택된 객체)
	 * Note : 체크하기 위한 input 에는 "form_validate" class를 추가 해야 됨 (필수 입력)
	 *	   형식을 구분하기 위해서는 alt 에 "id | name | phone | email" 선택해서 입력해야 됨
	 ************************************************************************************************/
	$.fn.chkFormValidate = function(sChkGubun) {
		$('.form_validate').each(function() {
			if (typeof(sChkGubun) != 'undefined' && sChkGubun != $(this).attr("id")) return true;

			if ($(this).is(':visible')) {
				if ($.inArray($(this).attr("type"), ['text', 'email', 'password']) != -1) {
					$(this).val($.trim($(this).val()));	// 앞뒤 공백 제거
					if ($(this).val() == '') {
						if ($(this).attr('alt') == 'confirm') {
							var sCheId = $(this).attr("id").replace('Confirm', '');
							if ($.trim($('#' + sCheId).val()) != '')
								$('#' + sCheId + 'Error').html($('label[for=' + sCheId + ']').html() + ' 확인을 입력 바랍니다.');
							else
								$('#' + sCheId + 'Error').html('&nbsp;');
						}
						else
							$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '을(를) 입력 바랍니다.');
					}
					else {
						if ($(this).attr('alt') == 'id') {
							var checkId = /^[A-Za-z0-9]+$/;

							if ($(this).val().length < 5 || !checkId.test($(this).val()))
								$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '은(는) 영문과 숫자만 길이가 5자 이상 입력이 가능합니다.');
							else
								$('#' + $(this).attr("id") + 'Error').html('&nbsp;');
						} else if ($(this).attr('alt') == 'name') {
							var checkKor = /^[\u3131-\u314e|\u314f-\u3163|\uac00-\ud7a30-9]{2,20}$/;

							if ($(this).val().length < 2 || !checkKor.test($(this).val()))
								$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '은(는) 한글만 두글자 이상 입력이 가능합니다.');
							else
								$('#' + $(this).attr("id") + 'Error').html('&nbsp;');
						} else if ($(this).attr('alt') == 'phone') {
							var checkNum = /^[0-9]*$/;
							$(this).val($(this).val().replace(/-/gi, ''));

							if (!checkNum.test($(this).val()))
								$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '은(는) 숫자만 입력 가능합니다.');
							else if ($.inArray($(this).val().length, [10, 11]) == -1)
								$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '은(는) 확인 바랍니다.');
							else
								$('#' + $(this).attr("id") + 'Error').html('&nbsp;');

						} else if ($(this).attr('alt') == 'email') {
							var checkEmail = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

							if (!checkEmail.test($(this).val()))
								$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '은(는) 형식에 맞게 입력 바랍니다.');
							else
								$('#' + $(this).attr("id") + 'Error').html('&nbsp;');
						} else if ($(this).attr('alt') == 'confirm') {
							var sCheId = $(this).attr("id").replace('Confirm', '');
							if ($('#' + sCheId).val() != $(this).val())
								$('#' + sCheId + 'Error').html($('label[for=' + sCheId + ']').html() + '와(과) 동일하게 입력 바랍니다.');
							else
								$('#' + sCheId + 'Error').html('&nbsp;');
						}
					}
				}
				else if ($(this).attr("type") == 'radio') {
					var bChkFlag = false;
					$('input[name=' + $(this).attr('name') + ']').each(function() {
						bChkFlag = $(this).prop("checked");
						if (bChkFlag == true){
							$('#' + $(this).attr("id") + 'Error').html('&nbsp;');
							return false;
						}
					});
					if (bChkFlag == false)
						$('#' + $(this).attr("id") + 'Error').html($('label[for=' + $(this).attr("id") + ']').html() + '을(를) 선택하세요.');
				}
			}

			if (typeof(sChkGubun) != 'undefined' && sChkGubun == $(this).attr("id")) return false;
		});
	}
	$('.form_validate').blur(function() {
		$.fn.chkFormValidate($(this).attr('id'));
	});
	$('.form_validate').click(function() {
		if ($.inArray($(this).attr("type"), ['radio', 'checkbox']) != -1) {
			$.fn.chkFormValidate($(this).attr('id'));
		}
	});

	/************************************************************************************************
	 * form의 submit 클릭 시 처리
	 * Since : 2016-05-10
	 * Version : 1.0.0
	 * Param :
	 * Note : form submit 버튼에 'btnFormSubmit' class 를 추가하고 id는 폼 id의 'Form'을 제외한 부분을 입력
	 *	   ex) form 의 id => 'sendTestForm' 인 경우 버튼의 id => 'sendTest'
	 ************************************************************************************************/
	$('.btnFormSubmit').click(function() {
		var bCheckFlag = true;

		// form 체크
		$.fn.chkFormValidate();

		$('.help-block').each(function() {
			if ($(this).is(':visible') && $(this).html() != '&nbsp;') {
				bCheckFlag = false;
				return false;
			}
		});

		if (bCheckFlag == true)
			$('#' + $(this).attr('id') + 'Form').submit();
		else
			return false;
	});

	$('.btnFormCancel').click(function() {
		history.back();
	});
});