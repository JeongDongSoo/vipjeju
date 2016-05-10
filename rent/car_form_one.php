<?
include_once('../include/common.php');
include_once("../include/head.php");

if(!$s_date || !$e_date) {
	if(!$s_time || !$e_time) {
		$s_time=time()+60*60;
		$e_time=time()+60*60*25;
	}
	$s_date=date('Y-m-d',$s_time);
	$s_hour=date(H,$s_time);
	$e_date=date('Y-m-d',$e_time);
	$e_hour=date(H,$e_time);
}
?>
<link rel="stylesheet" type="text/css" href="/css/form/form.css" />
<link rel="stylesheet" type="text/css" href="/css/form/common.css">
<link rel="stylesheet" type="text/css" href="/css/form/car.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">

<link rel="stylesheet" type="text/css" href="/css/default.css"/>
<link rel="stylesheet" type="text/css" href="/css/common_top.css"/>
<link rel="stylesheet" type="text/css" href="/css/common_layout.css"/>
<link rel="stylesheet" type="text/css" href="/css/common_bottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/common.css"/>
<link rel="stylesheet" type="text/css" href="/css/main_layout.css"/>

<script type="text/javascript" src="/js/jquery.easing.js"></script>
<script type="text/javascript" src="/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/js/common2.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/map.js"></script>

<?php include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php'); ?> 

<script type="text/javascript">
$(function(){ 
	$("#s_date, #e_date").datepicker({ 
		changeMonth: true, 
		changeYear: true, 
		dateFormat: "yy-mm-dd", 
		showButtonPanel: true, 
		yearRange: "c-99:c+99", 
		maxDate: "+365d" 
	}); 
}); 
</script>

<!-- // 휴차보상료란 -->
<div id="insurance2" class="pop-layer"><!-- id -->
	<div class="layer_popUp">
		<div class="pop-target-conts">
			<div class="pop01">
				<!--<div class="lv_close"><a href="#" class="btn_close btn-layerClose" alt="닫기"> <span>닫기</span></a></div>-->

				<h3 class=""><span>휴차보상료란</span></h3>
				<p class="pop01_txt">
					차량손해면책제도(자차보험) 가입 유무와 관계없이 사고로 인하여 영업손실이 야기 되었을 경우에는 발생한 수리기간동안 1일 대여요금의 50%에 해당하는 휴차보상료가 청구되며, 이는 임차인이 배상하여야 합니다.
				</p>
				<div class="btnArea">
					<a href="javascript:;" class="btn_01 btn-layerClose"><span>닫기</span></a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 휴차보상료란 //-->

<!-- // 차량손해면책제도란 -->
<div id="insurance1" class="pop-layer"><!-- id -->
	<div class="layer_popUp">
		<div class="pop-target-conts">
			<div class="pop01">
				<!--<div class="lv_close"><a href="#" class="btn_close btn-layerClose" alt="닫기"> <span>닫기</span></a></div>-->

				<h3 class=""><span>차량손해면책제도란</span></h3>
				<p class="pop01_txt">
					운전자의 과실에 의한 대여차량 손해 시 발생하는 비용을 면책(보장) 받을 수 있는 제도로 자차 한도가 없으며 면책특약(완전면책 vs 일반면책)을 선택할 수 있습니다.
				</p>
				<div class="btnArea">
					<a href="javascript:;" class="btn_01 btn-layerClose"><span>닫기</span></a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 차량손해면책제도란 //-->

<div id="container">
	<div class="colgroup1 clearfix">
	</div><!-- //colgroup1 -->

<div id="wrap">
    <div id="container">
    <div class="recruit-step-wrap reservation-wrap">

<!-- -->
		<div class="rowgroup">
			<div class="sub_title">
				<div class="navigation">
					<span class="home">홈</span>  &gt; 렌터카 &gt; <strong>예약하기</strong>
				</div>

				
				<h1>예약하기</h1>
                <h2>할인된 가격으로 렌터카를 이용하세요!</h2>
			</div>
       </div>
<!-- -->      
                        
                        <div class="reservation-cont">
                            <div class="select-side">
                                <div class="table-tit">
                                    <h2>대여선택 정보</h2>
                                    <!--<p class="txt-right posi-right"><em class="mustIco red">표기된 항목은 필수입력 항목입니다.</em></p>-->
                                </div>
                                <!-- s : 예약고객정보 -->
                              <div class="input-area mb40">
                                    <div class="bottom-table border-table">
                                    
                                       <div class="car_img">
                                        	<div class="thumb"><img id="car_img_e" src="/images/car_img1.jpg" width="268" height="183"></div>
                                        <!--<div class="price"><span id="sum_hr">0</span>시간, 차량 대여료 <span id="sum_e" >0</span> 원</div>-->
                                      </div>
                                      
                                      <table summary="대여선택 정보">
                                      
                                            <caption>대여선택 정보</caption>
                                            <colgroup>
                                                <col width="160px;"/>
                                                <col width="760px;"/>
                                            </colgroup>
                                            <tbody>
                                                <tr>
													<th scope="row"><em class="mustIco">*</em> 대여일시</th>
													<td><input type="text" name="s_date" id="s_date" value="<?=$s_date?>" title="" readonly style="width:100px;"/>
													<select name="s_hour" id="s_hour" title="" style="width:80px;">
														<? for($i=8; $i<=22; $i++) { ?>
														<option value="<?=$i?>" <?if($i==$s_hour) echo"selected";?>><?=$i?>시</option>
														<? } ?>
													</select>
													<select name="s_min" id="s_min" title="" style="width:80px;">
														<option value="00" <?if($s_min==00) echo"selected";?>>00분</option>
														<option value="30" <?if($s_min==30) echo"selected";?>>30분</option>
													</select> &nbsp; ~ &nbsp; 
													<input type="text" name="e_date" id="e_date" value="<?=$e_date?>" title="" readonly style="width:100px;"/>
													<select name="e_hour" id="e_hour" title="" style="width:80px;">
														<? for($i=8; $i<=22; $i++) { ?>
														<option value="<?=$i?>" <?if($i==$e_hour) echo"selected";?>><?=$i?>시</option>
														<? } ?>
													</select>
													<select name="e_min" id="e_min" title="" style="width:80px;">
														<option value="00" <?if($e_min==00) echo"selected";?>>00분</option>
														<option value="30" <?if($e_min==30) echo"selected";?>>30분</option>
													</select>
													</td>
                                                </tr>
                                                <tr>
                                                  <th scope="row"><em class="mustIco">*</em> 대여차종</th>
                                                  <td>
                                                  <select name="" id="" title="" style="width:80px;">
                                                            <option value="경차">경차</option>
                                                            <option value="소형">소형</option>
                                                            <option value="중형">중형</option>
                                                            <option value="고급">고급</option>
                                                            <option value="SUV">SUV</option>
                                                            <option value="승합">승합</option>
                                                            <option value="수입">수입</option>
                                                            <option value="특가">특가</option>
                                                        </select> &nbsp;
                                                  <select title="대여차종" name="" id="" style="width:250px;">
                                                            <option value="">뉴 k5 MX LPG</option>
                                                      </select></td>
                                                </tr>
                                                <tr>
                                                  <th scope="row"><em class="mustIco">*</em> 차량 인수/반납장소</th>
                                                  <td><select title="인수장소" name="resArrhh" id="resArrhh" style="width:150px;">
                                                            <option value="">제주공항(0원)</option>
                                                      </select> &nbsp; 
                                                      <select title="반납장소" name="resArrhh" id="resArrhh" style="width:150px;">
                                                            <option value="">제주공항(0원)</option>
                                                      </select></td>
                                                </tr>
                                                <tr>
									 			 <td colspan=2><ul class="txt-orange"></ul></td>
												</tr>
                                                <!--<tr>
                                                    <th scope="row"><em class="mustIco"></em> 성명(영문)</th>
                                                    <td><label for="rescLastEname">Last Name(성)&nbsp;</label><input type="text" name="rescLastEname" id="rescLastEname" maxlength="28" title="예약 고객정보 성명(영문) 성" style="width:177px;ime-mode:disabled;"/>&nbsp;&nbsp;<label for="rescFirstEname">First Name(이름)&nbsp;</label><input type="text" name="rescFirstEname" id="rescFirstEname" maxlength="30" title="예약 고객정보 성명(영문) 이름" style="width:170px;ime-mode:disabled;"/></td>
                                                </tr>-->
                                            </tbody>
                                        </table>                                        
                                    </div>
                                </div>
                                <div class="table-tit">
						<h2>보험 선택(차량손해 면책제도)</h2>
					</div>                 
				  <div class="input-area mb40">
						<div class="bottom-table border-table">
						  <table summary="보험 선택(차량손해 면책제도)">
								<caption>보험 선택(차량손해 면책제도)</caption>
								<colgroup>
									<col width="160px;"/>
									<col width="1040px;"/>
								</colgroup>
								<tbody>
									<tr>
										<th scope="row"><em class="mustIco">*</em> <label for="rescKname">보험선택</label></th>
										<td>
                                        <select title="보험미가입 : 수리비전액 + 휴차보상료 부담" name="" id="" style="width:400px;">
                                       	  <option value="">보험미가입 : 수리비전액 + 휴차보상료 부담</option>
                                          <option value="">일반면책 : 면책금 + 휴차보상료 부담</option>
                                          <option value="">완전면책 : 면책한도금액(400만원)까지 고객부담금 없음</option>
                                        </select> &nbsp; 
                                        <a href="#" class="pop_wrap" data-pop-wrap-id="insurance1"><img src="/images/btn_insurance1.gif" style="padding:0 0 0px 0;"></a> &nbsp; 
                                        <a href="#" class="pop_wrap" data-pop-wrap-id="insurance2"><img src="/images/btn_insurance2.gif" style="padding:0 0 0px 0;"></a>
                                            </td>
									</tr>
									<tr>
									 	<td colspan=2><ul class="txt-brown" style="margin-top:10px;">- 사고 시 차량수리비가 면책한도액을 초과하는 경우 : 초과하는 수리비 및 휴차보상료는 고객이 전액 부담</ul>
                                        <ul class="txt-brown" style=" margin-bottom:10px;">- 사고로 인해 차량 운행이 불가능한 경우(폐차,대파로 인하여 수리 후에도 영업차량으로 이용이 어려운 경우)에
 휴차보상료의 기간 결정은 해당차량 차령의 잔존 기간으로 정한다.</ul></td>
									</tr>
								</tbody>
							</table>
						</div>
                        <p class="txt-right" style="margin-top:15px;"><input type="checkbox" name="agree" id="agree" title="개인정보 수집 동의"/><label for="agree">차량손해면책제도 안내에 동의합니다. </label></p>
					</div> 
                                <div class="table-tit">
						<h2>운전자 정보입력</h2>
					</div>                 
				  <div class="input-area mb40">
						<div class="bottom-table border-table">
						  <table summary="운전자 정보입력">
								<caption>운전자 정보입력</caption>
								<colgroup>
									<col width="160px;"/>
									<col width="1040px;"/>
								</colgroup>
								<tbody>
									<tr>
										<th scope="row"><em class="mustIco">*</em> <label for="rescKname">이름</label></th>
										<td><input type="text" name="rescKname" id="rescKname" title="예약 고객정보 성명(한글)" maxlength="30" style="width:150px;"/>
                                            </td>
									</tr>
									<tr>
										<th scope="row"><em class="mustIco">*</em> <label for="rescEmail1">이메일</label></th>
										<td><input type="text" name="rescEmail1" id="rescEmail1" title="예약 고객정보 이메일 아이디" maxlength="18" style="width:120px;ime-mode:disabled;"/>
                                                        <em class="dash">@</em>
                                                        <input type="text" name="rescEmail2" id="rescEmail2" title="예약 고객정보 이메일 도메인" maxlength="20" style="width:120px;ime-mode:disabled;"/>
                                                        <select title="이메일 도메인 선택" style="width:125px;" id="rescEmail3">
                                                            <option value="">직접입력</option>
                                                            <option value="naver.com">naver.com</option>
                                                            <option value="chol.com">chol.com</option>
                                                            <option value="dreamwiz.com">dreamwiz.com</option>
                                                            <option value="empal.com">empal.com</option>
                                                            <option value="freechal.com">freechal.com</option>
                                                            <option value="gmail.com">gmail.com</option>
                                                            <option value="hanafos.com">hanafos.com</option>
                                                            <option value="hanmail.net">hanmail.net</option>
                                                            <option value="hanmir.com">hanmir.com</option>
                                                            <option value="hitel.net">hitel.net</option>
                                                            <option value="hotmail.com">hotmail.com</option>
                                                            <option value="korea.com">korea.com</option>
                                                            <option value="lycos.co.kr">lycos.co.kr</option>
                                                            <option value="nate.com">nate.com</option>
                                                            <option value="netian.com">netian.com</option>
                                                            <option value="paran.com">paran.com</option>
                                                            <option value="yahoo.com">yahoo.com</option>
                                                            <option value="yahoo.co.kr">yahoo.co.kr</option>
                                                        </select>
										</td>
									</tr>
									<tr>
									  <th scope="row"><em class="mustIco">*</em> <label for="rescHandphone1">휴대폰 번호</label></th>
									  <td><select name="" id="" title="" style="width:60px;">
                                                            <option value="010">010</option>
                                                            <option value="011">011</option>
                                                            <option value="016">016</option>
                                                            <option value="017">017</option>
                                                            <option value="018">018</option>
                                                            <option value="019">019</option>
                                                        </select>
                                                        <em class="dash">-</em>
                                                        <input type="text" name="" id="" title="" maxlength="4" class="numOnly" style="width:55px;"/>
                                                        <em class="dash">-</em>
                                                        <input type="text" name="" id="" title="" maxlength="4" class="numOnly" style="width:55px;"/></td>
								  </tr>
									<tr>
									  <th scope="row"><em class="mustIco"></em><label for="">기타</label></th>
									  <td> <textarea name="" id="" cols="70" rows="10" title="" style="width:1013px; margin-top:10px; margin-bottom:10px;"></textarea><ul class="txt-orange"></td>
								  </tr>
								</tbody>
							</table>
						</div>
					</div> 
                                <div class="table-tit">
						<h2>부가서비스 선택</h2>
					</div>                 
				  <div class="input-area mb40">
						<div class="bottom-table border-table">
						  <table summary="부가서비스">
								<caption>부가서비스 선택</caption>
								<colgroup>
									<col width="160px;"/>
									<col width="1040px;"/>
								</colgroup>
								<tbody>
									<tr>
										<th scope="row"><label for="rescCardType">유모차</label></th>
										<td><select title="유모차" style="width:180px;" name="" id="">
											<option value="">선택</option>
											<option value="">유모차</option>

											</select> &nbsp; 
                                            <select title="" style="width:60px;" name="" id="">
                                            <option value="">0</option>
											<option value="">1</option>
											<option value="">2</option>
											</select>
                                            </td>
									</tr>
									<tr>
										<th scope="row"><label for="rescCardType">카시트</label></th>
										<td><select title="카시트" style="width:180px;" name="" id="">
											<option value="">선택</option>
											<option value="">가시트</option>

											</select> &nbsp; 
                                            <select title="" style="width:60px;" name="" id="">
                                            <option value="">0</option>
											<option value="">1</option>
											<option value="">2</option>
											</select>
										</td>
									</tr>
									<!--<tr>
									  <td colspan=2><ul class="txt-orange">
									</ul></td>
									</tr>-->
								</tbody>
							</table>
						</div>
					</div> 
                                <div class="table-tit">
						<h2>요금내역</h2>
					</div>
                    <div class="input-area mb40">
                                    <div class="bottom-table border-table">
                                      <table summary="요금내역">
                                            <caption>요금내역</caption>
                                            <colgroup>
                                                <col width="160px;"/>
                                                <col width="440px;"/>
                                                <col width="160px;"/>
                                                <col width="440px;"/>
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                  <th scope="row">차량요금</th>
                                                  <td align="right">20,000원</td>
                                                  <th scope="row">부가서비스 요금</th>
                                                  <td align="right">0원</td>
                                                </tr>
                                                <tr>
                                                  <th scope="row">배/반차 요금</th>
                                                  <td align="right">0원</td>
                                                  <th scope="row">보험가입 요금</th>
                                                  <td align="right">0원</td>
                                                </tr>
                                                <tr>
									 			  <td colspan=4>
                                                  <div class="price"> 
                                                      <li class="txt-blue">
                                                      차량요금(싼타페 더 프라임) 20,000원 + 보험가입(일반면책) 20,000원 + 부가서비스 요금(유모차) 0원 + 배/반차 요금 0원 = 
                                                         <ul class="txt-red-s">총 요금
                                                         <ul class="txt-red">40,000</ul>원</ul>
                                                      </li>
                                                  </div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                              </div>
                    

                              
                              <!--<div class="table-tit">
                                <h2>취소 환불 정책</h2>
                              </div>
                                <div class="input-area mb40">
                                    <div class="cancel-order">
                                        <h2 class="txt-blue">비수기 취소 수수료</h2>
                                        <ul class="dot">
                                            <li><span>입실일로부터 7일전 취소 : 수수료 없음 / 6 ~ 2일전 취소 : 50% 수수료 부과 / 1일전 ~ 당일 취소 : 100% 수수료 부과</span></li>
                                        </ul>
                                        <h2 class="txt-orange">성수기 취소 수수료</h2>
                                        <ul class="dot">
                                            <li><span>입실일로부터 15일전 취소 : 수수료 없음 / 14 ~ 8일전 취소 : 50% 수수료 부과 / 7일전 ~ 당일 취소 : 100% 수수료 부과</span></li>
                                        </ul>
                                    </div>
                                </div>-->
                                <div class="table-tit">
                                    <h2>개인정보 수집 및 이용에 대한 동의</h2>
                                </div>
                                <div class="input-area mb40">
                                    <div class="text-area">
                                        <ul>
                                            <li>1. 개인정보 수집항목
                                                <ol>
                                                    <li>① 수집항목 : 이름 , 생년월일 , 자택 전화번호 , 자택 주소 , 휴대전화번호 , 직업 , 회사명</li>
                                                    <li>② 개인정보 수집방법 : 홈페이지(회원가입)</li>
                                                </ol>
                                            </li>
                                        </ul><br />
                                        <ul>
                                            <li>2. 수집목적
                                                <ol>
                                                    <li>① 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산 콘텐츠 제공 , 구매 및 요금 결제</li>
                                                    <li>② 회원 관리 : 회원제 서비스 이용에 따른 본인확인 , 연령확인 , 불만처리 등 민원처리</li>
                                                    <li>③ 마케팅 및 광고에 활용 : 이벤트 등 광고성 정보 전달 , 접속 빈도 파악 또는 회원의 서비스 이용에 대한 통계</li>
                                                </ol>
                                            </li>
                                        </ul><br />
                                        <ul>
                                            <li>2. 보유 및 이용기간
                                                <ol>
                                                    <li>① 회사는 개인정보 수집 및 이용목적이 달성된 후에는 예외 없이 해당 정보를 지체 없이 파기합니다.</li>
                                                    <li>※ 전자상거래 등에서의 소비자보호 관한 법률 등 관계 법률에 의해 보존할 필요가 있는 경우에는 일정 기간 보존합니다.</li>
                                                </ol>
                                            </li>
                                        </ul><br />
                                        <ul>
                                            <li>2. 동의를 거부할 권리
                                                <ol>
                                                    <li>① 위 개인 개인정보의 필수적인 수집 이용에 관한 사항에 대한 동의가 없는 경우 거래관계의 설정 또는 유지가 불가능 할 수 있음을 알려드립니다.</li>
                                                </ol>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="txt-right"><input type="checkbox" name="agree" id="agree" title="개인정보 수집 동의"/><label for="agree">개인정보 수집 및 이용에 동의합니다.</label></p>
                                </div>
                            </div><!-- select-side -->
			</div>
		  <div class="btn-center">
				<a href="#" onClick="memberReservation(); return false;"
					id="member-login"><img
					src="/images/choice-btn.gif"></a>
		  </div>
        </form>
	</div><!-- //container -->
<hr />

<div id="footer" class="clearfix">
  <div class="site_link">	
  	<ul class="fnavi clearfix">		
        <li><a href="#">회사소개</a></li>
        <li><a href="#"><font color="#fffc00"><b>개인정보취급방침</b></font></a></li>
        <li><a href="#">이용약관</a></li>
        <li><a href="#">고객센터</a></li>
	</ul>
	</div><!--//site_link  -->
	<div class="wrap">
		<img src="/images/copyright_logo.gif" alt="로고" class="flogo"/>

		<div class="footer_info">
			<address><font color="#0d5db7">VIP제주여행.</font> 제주특별자치도 남성로 159 302호 <span>대표전화 : 1577-7777</span><span>팩스 : 064-712-3456</span></address>
            <address>사업자등록번호 : 616-27-82973 <span>통신판매업신고번호 : 제12-345-6789</span><span>대표자 : 000</span></address>
			<p>COPYRIGHT ⓒ VIP제주여행. ALL RIGHTS RESERVED.</p>

		</div>
	</div><!-- //wrap2 -->

</div><!-- //footer -->

</body>
</html>



 


<!-- 예약 달력 css 선언 -->
<link href="https://jejustar.co.kr/assets/css/rent_calendar.css" rel="stylesheet">


<!-- 예약 공통 js 선언 -->
<script src="https://jejustar.co.kr/assets/js/rent.js"></script> 			
             <div class="dim-layer">
				<div class="dimBg"></div>
				<div id="pop_limit_age" class="pop-layer">
					<div class="layer_popUp">
						<div class="pop-conts"></div>
					</div>
				</div>
			</div>
			<div class="wing">
				<div class="start"></div>
				<div class="wingbanner"><!-- id="wingbanner" -->
					<!-- a href="https://jejustar.co.kr/customer/qna_write"><img src="https://jejustar.co.kr/assets/images/common/wing_banner.png"></a -- 클릭시 의견수렴 레이어 팝업 -->
				</div>
				<div class="end"></div>
			</div>
            
<script type="text/javascript">
var car_kind = 0;
</script>            