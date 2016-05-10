<?
include_once('../include/common.php');
include_once("../include/head.php");
include_once("./inc/config.php");

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
if($car_no) {
	$que="select * from rc_car where car_no='$car_no'";
	$arr=sql_fetch($que);
}

$add_no_tmp=0;
$aque="select * from rc_add_goods where add_state=1 order by add_no";
$asql=sql_query($aque);
while($aarr=sql_fetch_array($asql)) {
	$add_no_arr[$add_no_tmp]=$aarr[add_no];
	$add_no_tmp++;
}

$oque="select * from rc_out_fee where out_state=1 order by out_sort, out_no";
$osql=sql_query($oque);
while($oarr=sql_fetch_array($osql)) {
	$a_place[$oarr[out_no]]=$oarr[out_name];
	$a_place_fee1[$oarr[out_no]]=$oarr[out_fee1];
	$a_place_fee2[$oarr[out_no]]=$oarr[out_fee2];
}
?>
<link rel="stylesheet" type="text/css" href="/css/form/form.css" />
<link rel="stylesheet" type="text/css" href="/css/form/common.css">
<link rel="stylesheet" type="text/css" href="/css/default.css"/>

<link rel="stylesheet" type="text/css" href="/css/jquery-ui/jquery-ui.css">

<script type="text/javascript" src="/js/form/common.js"></script>

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

function select_car_kind(val) {

	var param = "mode=car_get";
		param +="&kind_code="+val;
		//param +="&carkindname="+carkindname;
	
	$.ajax({
			type: "GET",
			url: "car_get.php",
			data: param,
			dataType: "json",
			success: function(data){
				search_car_info(data);
			},
			error:function(request,status,error){
				$("#error_box").html("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		   }

	});
} //calc() end

function search_car_info(data) {

	var car_no = '<?=$arr[car_no]?>';

	htmls = "<select name='car_no' id='car_no' style='width:250px;' onchange='get_fee_cal()'><option value=''>차종을 선택하세요.</option>";

	for(var i=0 ; i< data.length ; i++) {	
		htmls += " <option value='" + data[i].car_no + "'";
		if(data[i].car_no==car_no) htmls += " selected";
		htmls += ">" + data[i].car_name + " ["+data[i].car_gear + "]</option>";
	}
	htmls += "</select>";	
		
	$('#car_select').html(htmls);
}

function get_fee_cal()
{
	s_date = document.getElementById('s_date').value;
	s_hour = document.getElementById('s_hour').value;
	s_min = document.getElementById('s_min').value;
	e_date = document.getElementById('e_date').value;
	e_hour = document.getElementById('e_hour').value;
	e_min = document.getElementById('e_min').value;

	if( s_date<'<?=date('Y-m-d')?>' || (s_date=='<?=date('Y-m-d')?>' &&  s_hour<='<?=date(H)?>') ) {
		alert("이시간 이전 예약은 불가능합니다.");
		document.getElementById('s_date').value = '<?=date('Y-m-d')?>';
		document.getElementById('s_hour').value = '<?=date(H)+1?>'
		return false;
	}
	if( e_date<'<?=date('Y-m-d')?>' || (e_date=='<?=date('Y-m-d')?>' &&  e_hour<='<?=date(H)?>') ) {
		document.getElementById('e_date').value = '<?=date('Y-m-d')?>';
		document.getElementById('e_hour').value = '<?=date(H)+1?>'
		alert("이시간 이전 예약은 불가능합니다.");
		return false;
	}

	car_no = document.getElementById('car_no').value;
	car_cnt = document.getElementById('car_cnt').value;
	s_place = document.getElementById('s_place').value;
	e_place = document.getElementById('e_place').value;
	rsv_insure = document.getElementById('rsv_insure').value;

	if(car_no) {
		var param = "mode=car_fee_cal";
			param +="&s_date="+s_date+"&s_hour="+s_hour+"&s_min="+s_min;
			param +="&e_date="+e_date+"&e_hour="+e_hour+"&e_min="+e_min;
			param +="&car_no="+car_no+"&car_cnt="+car_cnt;
			param +="&s_place="+s_place+"&e_place="+e_place;
			param +="&rsv_insure="+rsv_insure;
			
		<? foreach($add_no_arr as $key => $val) { ?>
			add_goods_<?=$val?> = document.getElementById('add_goods_<?=$val?>').value;
			param +="&add_goods_<?=$val?>="+add_goods_<?=$val?>;
		<? } ?>

		//alert(param);
		$.ajax({
				type: "GET",
				url: "car_get.php",
				data: param,
				dataType: "json",
				success: function(data){
					fee_cal_info(data);
				},
				error:function(request,status,error){
					$("#error_box").html("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			   }
		});
	}
}
function fee_cal_info(data) 
{
	if(data[0].error_msg) {
		alert("예약이 불가한 기간입니다."); location.reload(); return false;
	}
	document.getElementById('car_photo').src = "./photo/"+data[0].car_photo;  
	document.getElementById('car_name').value = data[0].car_name;
	document.getElementById('car_fee').value = data[0].car_fee;
	document.getElementById('insure_fee').value = data[0].insure_fee;
	document.getElementById('add_goods_fee').value = data[0].add_goods_fee;
	document.getElementById('out_fee').value = data[0].out_fee;
	document.getElementById('total_fee').value = data[0].total_fee;
}

function domain_select() {
	document.getElementById('cus_email2').value = document.getElementById('domain').value;
}

function form_submit() {
	f=document.rsv_form;
	if(!f.car_no.value) {
		alert("차종을 선택하세요."); f.car_no.focus(); return false;
	}
	if(!f.cus_name.value) {
		alert("이름을 입력하세요."); f.cus_name.focus(); return false;
	}
	if(!f.cus_email1.value) {
		alert("이메일을 입력하세요."); f.cus_email1.focus(); return false;
	}
	if(!f.cus_email2.value) {
		alert("이메일을 입력하세요."); f.cus_email2.focus(); return false;
	}
	if(f.cus_phone2.value.length<3) {
		alert("휴대전화번호를 입력하세요."); f.cus_phone2.focus(); return false;
	}
	if(f.cus_phone3.value.length<4) {
		alert("휴대전화번호를 입력하세요."); f.cus_phone3.focus(); return false;
	}
	if(f.agree_chk.checked==false) {
		alert("개인정보수집에 동의하세요."); f.agree_chk.focus(); return false;
	}
	f.submit();
}

<? if(!$arr[kind_code]) $arr[kind_code]=1; ?>
select_car_kind(<?=$arr[kind_code]?>);
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

<form name="rsv_form" id="rsv_form" method="post" enctype='multipart/form-data' action="car_update.php">
<input type=hidden name="mode" value="insert">
<input type=hidden name="car_name" id="car_name">
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
                                        	<div class="thumb"><img id="car_photo" src="/images/car_img1.jpg" width="268" height="183"></div>
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
													<td><input type="text" name="s_date" id="s_date" value="<?=$s_date?>" title="" readonly style="width:100px;" onchange="get_fee_cal()" />
													<select name="s_hour" id="s_hour" title="" style="width:80px;" onchange="get_fee_cal()">
														<? for($i=8; $i<=22; $i++) { ?>
														<option value="<?=$i?>" <?if($i==$s_hour) echo"selected";?>><?=$i?>시</option>
														<? } ?>
													</select>
													<select name="s_min" id="s_min" title="" style="width:80px;" onchange="get_fee_cal()">
														<option value="00" <?if($s_min==00) echo"selected";?>>00분</option>
														<option value="30" <?if($s_min==30) echo"selected";?>>30분</option>
													</select> &nbsp; ~ &nbsp; 
													<input type="text" name="e_date" id="e_date" value="<?=$e_date?>" title="" readonly style="width:100px;" onchange="get_fee_cal()" />
													<select name="e_hour" id="e_hour" title="" style="width:80px;" onchange="get_fee_cal()">
														<? for($i=8; $i<=22; $i++) { ?>
														<option value="<?=$i?>" <?if($i==$e_hour) echo"selected";?>><?=$i?>시</option>
														<? } ?>
													</select>
													<select name="e_min" id="e_min" title="" style="width:80px;" onchange="get_fee_cal()">
														<option value="00" <?if($e_min==00) echo"selected";?>>00분</option>
														<option value="30" <?if($e_min==30) echo"selected";?>>30분</option>
													</select>
													</td>
                                                </tr>
                                                <tr>
                                                  <th scope="row"><em class="mustIco">*</em> 대여차종</th>
                                                  <td>
                                                  <select name="kind_code" id="kind_code" title="" style="width:80px;" onchange="select_car_kind(this.value)">
													<?
													$kque="select * from rc_kind_code where kind_state=1 order by kind_sort, kind_no";
													$ksql=sql_query($kque);
													while($karr=sql_fetch_array($ksql)) {
													?>
                                                            <option value="<?=$karr[kind_no]?>"<? if($karr[kind_no]==$arr[kind_code]) echo" selected"; ?>><?=$karr[kind_name]?></option>
													<?}?>
                                                        </select> &nbsp;
													   <div id="car_select" style="width:250px; display:inline-block;">
													   <select id='car_no' name='car_no' style='width:250px;'>
															<option value="">차종을 선택하세요.</option>
													   </select>
													   </div>
													</td>
                                                </tr>
                                                <tr>
                                                  <th scope="row"><em class="mustIco">*</em> 대여댓수</th>
                                                  <td><select id='car_cnt' name='car_cnt' style='width:60px;' onchange="get_fee_cal()">
														<? for($i=1; $i<=5; $i++) { ?>
														<option value="<?=$i?>"><?=$i?> 대</option>
														<? } ?>
													  </select></td>
                                                </tr>
                                                <tr>
                                                  <th scope="row"><em class="mustIco">*</em> 인수/반납장소</th>
                                                  <td><div id="s_place_div" style="float:left"><select title="인수장소" name="s_place" id="s_place" style="width:150px;" onchange="get_fee_cal()">
														<? foreach($a_place as $key => $val) { ?>
														<option value="<?=$key?>"><?=$val?> (<?=number_format($a_place_fee1[$key])?>원)</option>
														<? } ?>
                                                      </select></div>
                                                      <div id="e_place_div"> &nbsp; <select title="반납장소" name="e_place" id="e_place" style="width:150px;" onchange="get_fee_cal()">
														<? foreach($a_place as $key => $val) { ?>
														<option value="<?=$key?>"><?=$val?> (<?=number_format($a_place_fee1[$key])?>원)</option>
														<? } ?>
                                                      </select></div></td>
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
                                        <select title="자차보험선택" name="rsv_insure" id="rsv_insure" style="width:400px;" onchange="get_fee_cal()">
										<? foreach($a_insure_info as $key => $val) { ?>
                                       	  <option value="<?=$key?>"<?if($rsv_insure==$key) echo" selected";?>><?=$val?></option>
										<? } ?>
                                        </select> &nbsp; 
                                        <a href="#" class="pop_wrap" data-pop-wrap-id="insurance1"><img src="/images/btn_insurance1.gif" style="padding:0 0 0px 0;"></a> &nbsp; 
                                        <a href="#" class="pop_wrap" data-pop-wrap-id="insurance2"><img src="/images/btn_insurance2.gif" style="padding:0 0 0px 0;"></a>
                                        </td>
									</tr>
									<tr>
									 	<td colspan=2><ul class="txt-brown" style="margin-top:10px;">- 사고 시 차량수리비가 면책한도액을 초과하는 경우 : 초과하는 수리비 및 휴차보상료는 고객이 전액 부담</ul>
                                        <ul class="txt-brown" style=" margin-bottom:10px;">- 사고로 인해 차량 운행이 불가능한 경우(폐차,대파로 인하여 수리 후에도 영업차량으로 이용이 어려운 경우)에 휴차보상료의 기간 결정은 해당차량 차령의 잔존 기간으로 정한다.</ul></td>
									</tr>
								</tbody>
							</table>
						</div>
                        <p class="txt-right" style="margin-top:15px;"><input type="checkbox" name="agree" id="agree" title="개인정보 수집 동의"/><label for="agree">차량손해면책제도 안내에 동의합니다. </label></p>
					</div> 
                                <div class="table-tit">
						<h2>부가서비스 선택</h2>
					</div>                 
				  <div class="input-area mb40">
						<div class="bottom-table border-table">
						  <table width="100%" summary="부가서비스">
								<caption>부가서비스 선택</caption>
								<colgroup>
									<col width="20%"/>
									<col width="30%"/>
                                    <col width="20%"/>
									<col width="30%"/>
								</colgroup>
								<tbody>
									<tr>
									<?
										$tmp=0;
										$aque="select * from rc_add_goods where add_state=1 order by add_no";
										$asql=sql_query($aque);
										while($aarr=sql_fetch_array($asql)) {
											$tmp++;
											if($tmp>2 && $tmp%2==1) echo"</tr><tr>";
									?>
										<th scope="row"><label id="lab_add_goods_<?=$aarr[add_no]?>"><?=$aarr[add_name]?> (<?=number_format($aarr[add_fee1])?>원)</label></th>
										<td><select title="" style="width:60px;" name="add_goods_<?=$aarr[add_no]?>" id="add_goods_<?=$aarr[add_no]?>" onchange="get_fee_cal()">
											<? for($i=0; $i<=5; $i++) { ?>
                                            <option value="<?=$i?>"><?=$i?></option>
											<? } ?>
											</select></td>
									<? } //while() ?>
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
									  <td><input type=text name="car_fee" id="car_fee" readonly style="text-align:right;"> 원</td>
									  <th scope="row">배/반차 요금</th>
									  <td><input type=text name="out_fee" id="out_fee" readonly style="text-align:right;"> 원</td>
									</tr>
									<tr>
									  <th scope="row">보험가입 요금</th>
									  <td><input type=text name="insure_fee" id="insure_fee" readonly style="text-align:right;"> 원</td>
									  <th scope="row">부가서비스 요금</th>
									  <td><input type=text name="add_goods_fee" id="add_goods_fee" readonly style="text-align:right;"> 원</td>
									</tr>
									<tr>
									  <th scope="row" class="txt-red-s">총요금</th>
									  <td colspan=3><input type=text name="total_fee" id="total_fee" readonly class="txt-red" style="text-align:right;"> 원</td>
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
										<td><input type="text" name="cus_name" id="cus_name" title="예약 고객정보 성명(한글)" maxlength="30" style="width:150px;"/>
                                            </td>
									</tr>
									<tr>
										<th scope="row"><em class="mustIco">*</em> <label for="rescEmail1">이메일</label></th>
										<td><input type="text" name="cus_email1" id="cus_email1" title="예약 고객정보 이메일 아이디" maxlength="18" style="width:120px;ime-mode:disabled;"/>
											<em class="dash">@</em>
											<input type="text" name="cus_email2" id="cus_email2" title="예약 고객정보 이메일 도메인" maxlength="20" style="width:120px;ime-mode:disabled;"/>
											<select title="이메일 도메인 선택" style="width:125px;" id="domain" onchange="domain_select()">
												<option value="">직접입력</option>
												<option value="naver.com">naver.com</option>
												<option value="hanmail.net">hanmail.net</option>
												<option value="gmail.com">gmail.com</option>
												<option value="hotmail.com">hotmail.com</option>
												<option value="nate.com">nate.com</option>
												<option value="chol.com">chol.com</option>
												<option value="dreamwiz.com">dreamwiz.com</option>
												<option value="empal.com">empal.com</option>
												<option value="hanafos.com">hanafos.com</option>
												<option value="hitel.net">hitel.net</option>
												<option value="korea.com">korea.com</option>
												<option value="netian.com">netian.com</option>
												<option value="paran.com">paran.com</option>
												<option value="yahoo.com">yahoo.com</option>
												<option value="yahoo.co.kr">yahoo.co.kr</option>
											</select>
										</td>
									</tr>
									<tr>
									  <th scope="row"><em class="mustIco">*</em> <label for="rescHandphone1">휴대폰 번호</label></th>
									  <td><select name="cus_phone1" id="cus_phone1" title="" style="width:60px;">
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<em class="dash">-</em>
										<input type="text" name="cus_phone2" id="cus_phone2" title="" maxlength="4" class="numOnly" style="width:55px;"/>
										<em class="dash">-</em>
										<input type="text" name="cus_phone3" id="cus_phone3" title="" maxlength="4" class="numOnly" style="width:55px;"/></td>
								  </tr>
									<tr>
									  <th scope="row"><em class="mustIco"></em><label for="">기타</label></th>
									  <td> <textarea name="comment" id="comment" cols="70" rows="10" title="" style="width:1013px; margin-top:10px; margin-bottom:10px;"></textarea><ul class="txt-orange"></td>
								  </tr>
								</tbody>
							</table>
						</div>
					</div> 
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
						<p class="txt-right"><input type="checkbox" name="agree_chk" id="agree_chk" title="개인정보 수집 동의"/><label for="agree">개인정보 수집 및 이용에 동의합니다.</label></p>
					</div>
				</div><!-- select-side -->
			</div>
		  <div class="btn-center">
				<a href="#" onClick="form_submit(); return false;" id="member-login"><img src="/images/choice-btn.gif"></a>
		  </div>
</form>
	</div><!-- //container -->
<?
include_once("../include/tail.php");
?>
 
 <div class="dim-layer">
    <div class="dimBg"></div>
      <div id="pop_limit_age" class="pop-layer">
        <div class="layer_popUp">
            <div class="pop-conts"></div>
        </div>
    </div>
 </div>

<script type="text/javascript">
$(window).load(function(){
	get_fee_cal();
});
</script>
