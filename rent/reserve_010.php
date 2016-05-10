<?
include_once('../include/common.php');
include_once('../include/head.php');
include_once('./inc/config.php');

$fyear=date("Y");
$fmonth=date("m");
$fday=date("d");
$fhour=date("H")+1;

$tomorrow = time()+60*60*24;
$lyear=date("Y",$tomorrow);
$lmonth=date("m",$tomorrow);
$lday=date("d",$tomorrow);
$lhour=date("H",$tomorrow)+1;

$s_time=mktime($fhour,0,0,$fmonth,$fday,$fyear);
$e_time=mktime($lhour,0,0,$lmonth,$lday,$lyear);
$total_term = floor(($e_time-$s_time)/3600); // 총 사용 시간
$total_day = floor($total_term/24);
?>
<!--달력스크립트-->

<script type="text/javascript" src="/js/calendar/jquery.datePicker2.js"></script>		
<script type="text/javascript" src="/js/calendar/date2.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="/css/calendar/datePicker2.css">
	
<script type="text/javascript" charset="utf-8">

function get_fee_cal()
{
	s_date = document.getElementById('s_date').value;
	e_date = document.getElementById('e_date').value;

	if(s_date>='<?=date('Y-m-d',$b_rsv_limit)?>' || e_date>'<?=date('Y-m-d',$b_rsv_limit)?>') {
		alert("<?=date('Y-m-d',$b_rsv_limit)?> 이전까지만 예약이 가능합니다.");
		return false;
	}

	room_no = document.getElementById('room_no').value;
	room_cnt = document.getElementById('room_cnt').value;
	add_adult = document.getElementById('add_adult').value;
	add_child = document.getElementById('add_child').value;
	breakfast_adult = document.getElementById('breakfast_adult').value;
	breakfast_child = document.getElementById('breakfast_child').value;
	bed_cnt = document.getElementById('bed_cnt').value;
	breakfast_chk=0;
	if(document.getElementById('breakfast_chk').checked==true) breakfast_chk=1;

	document.getElementById('room_cnt2').value = room_cnt;
	document.getElementById('add_adult2').value = add_adult;
	document.getElementById('add_child2').value = add_child;
	document.getElementById('breakfast_adult2').value = breakfast_adult;
	document.getElementById('breakfast_child2').value = breakfast_child;
	document.getElementById('bed_cnt2').value = bed_cnt;

	var rURL = "reserve_get.php?mode=get_fee_cal&s_date="+s_date+"&e_date="+e_date+"&room_no="+room_no+"&room_cnt="+room_cnt+"&add_adult="+add_adult+"&add_child="+add_child+"&breakfast_adult="+breakfast_adult+"&breakfast_child="+breakfast_child+"&bed_cnt="+bed_cnt+"&breakfast_chk="+breakfast_chk;
	//document.write(pars);
	$.ajax({
		url: rURL,
		type: 'get',
		datatype: 'text',
		success: function(data) {
			var xmlDoc = data;
			if (!xmlDoc) return;

			var xmlList = xmlDoc.getElementsByTagName("room_list")
			if (xmlList)
			{
				for (i=0; i<xmlList.length; i++)
				{
					var varr = new Array();
					for(j=1; j<=13; j++) {
						varr[j] = xmlList[i].childNodes[j].firstChild.nodeValue;
					}

					document.getElementById("basis_num").value = varr[3]+"인 1실 기준 (최대 "+varr[4]+"인)";
					document.getElementById("room_name2").value = varr[1]+" ["+varr[2]+"]";
					document.getElementById("room_fee").value = varr[5];
					document.getElementById("add_fee").value = varr[6];
					document.getElementById("breakfast_fee").value = varr[7];
					document.getElementById("bed_fee").value = varr[8];
					document.getElementById("total_fee").value = varr[9];
					if(varr[10]==1) document.getElementById("breakfast_chk").checked = true;
					if(varr[11]==1) alert("마운틴뷰 타입은 조식포함 대여만 가능합니다.");
					document.getElementById("add_adult").value = varr[12];
					if(varr[13]==1) alert("최대가능 인원을 초과하였습니다.");
				}
			}
		}
	});
}

$(function()
	{
	   var monthNames = ['년 1 월','년 2 월','년 3 월','년 4 월','년 5 월','년 6 월','년 7 월','년 8 월','년 9 월','년 10 월','년 11 월','년 12 월']; 
		Date.monthNames = monthNames;
	   var dayNames = ['일', '월', '화', '수', '목', '금', '토'];
		Date.dayNames = dayNames;
		k_date = "<?=date('Y-m-d',$s_time)?>";
		k_date_e = "<?=date('Y-m-d',$e_time)?>";
		if($('#s_date').val()==""){
			$('#s_date').val(k_date);
			$('#s_date2').val(k_date);
		}
		if($('#e_date').val()==""){
			$('#e_date').val(k_date_e);
			$('#e_date2').val(k_date_e);
		}
		
		$('#cal2')
			.datePicker({inline:true})
			.dpSetSelected(k_date)
			.bind(
				'dateSelected',
				function(e, selectedDate, $td)
				{
					$('#s_date').val(selectedDate.asString());
					$('#s_date2').val(selectedDate.asString());
					cal_term();
					get_fee_cal();
					$('#cal3').dpSetSelected(selectedDate.addDays(1).asString());
				}
			);

		$('#cal3')
			.datePicker({inline:true})
			.dpSetSelected(k_date_e)	
			.bind(
				'dateSelected',
				function(e, selectedDate, $td)
				{
					$('#e_date').val(selectedDate.asString());
					$('#e_date2').val(selectedDate.asString());
					cal_term();
					get_fee_cal();
				}
			);
			
   });	

function cal_term() {
	var f=document.rsv_form;
	var s_date=f.s_date.value;
	var e_date=f.e_date.value;
	var s_date_arr=s_date.split("-");
	var e_date_arr=e_date.split("-");

	y1=eval(s_date_arr[0]);
	m1=eval(s_date_arr[1]-1);
	d1=eval(s_date_arr[2]);
	y2=eval(e_date_arr[0]);
	m2=eval(e_date_arr[1]-1);
	d2=eval(e_date_arr[2]);

	today=new Date();
	day1=new Date(y1,m1,d1,0,0,0,0);
	day2=new Date(y2,m2,d2,0,0,0,0);

	todate=today.getTime()-60*60*24*1000;
	date1=day1.getTime();
	date2=day2.getTime();
	term=Math.ceil((date2-date1)/24/60/60/1000);

	f.total_day.value=term;
	f.total_day2.value=term;
}

function Chk_sear(){
	$("#chajong").show().delay(2000);
	$('#chajong').fadeOut('slow', function() {
	// Animation complete
	});
}

function form_submit() {
	f=document.rsv_form;
	
	s_date = document.getElementById('s_date').value;
	e_date = document.getElementById('e_date').value;

	if(s_date>='<?=date('Y-m-d',$b_rsv_limit)?>' || e_date>'<?=date('Y-m-d',$b_rsv_limit)?>') {
		alert("<?=date('Y-m-d',$b_rsv_limit)?> 이전까지만 예약이 가능합니다.");
		return false;
	}

	if(!f.room_no.value) {
		alert("객실타입을 선택하세요.");
		f.room_no.focus();
		return false;
	}
	f.submit();
}
</script>

<?php include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php'); ?> 

<script>
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

            <!-- CONTENT -->
 <div id="section-wrap">
	<h1>
		<img src="/images/step1.gif"/>
	</h1>

<form name="rsv_form" id="rsv_form" method="post" enctype='multipart/form-data' action="reserve_02.php">
		<div class="recruit-step-wrap reservation-wrap">
		  <div class="reservation-cont">
				<div class="select-side">
					<div class="reservation-tab tab01">
					  <div class="cont-wrap">
						  <h4>날짜 선택</h4>
							<div class="date-select">
								<div class="calendar-area">
									<div class="calendar">
										<div class="cal-head">
											
										</div>
										<div class="cal-table">
											<div id="cal2"></div>
										</div>
									</div>
									<!-- calendar -->
									<div class="calendar last">
										<div class="cal-head">
											
										</div>
										<div class="cal-table">
											<div id="cal3"></div>
										</div>
									</div>
									<!-- calendar -->
								</div>
								<!-- calendar-area -->
								<div class="inout-area">
									<dl>
										<dt>
											<label for="resArr">체크인</label>
										</dt>
										<dd>
											<input type="text" name="s_date" id="s_date" title="체크인 날짜" readonly="readonly" style="width:120px;"/>
										</dd>
										<dt>
											<label for="resDep">체크아웃</label>
										</dt>
										<dd>
											<input type="text" name="e_date" id="e_date" title="체크아웃 날짜" readonly="readonly" style="width:120px;"/>
										</dd>
									</dl>
									<dl class="nights">
										<dt>
											<label for="resNig">숙박일수</label>
										</dt>
										<dd>
											<input type="text" name="total_day" id="total_day" value="<?=$total_day?>" readonly="readonly" style="width:27px;"/>
										</dd>
									</dl>
									<!-- <button type="button" value="초기화" id="btnDateReset">
										<img src="/images/reset.gif" alt="초기화"/>
									</button> -->
								</div>
								<ul class="txt-orange">
									<li>* 스탠다드 마운틴뷰는 조식포함 상품만 판매 가능합니다.</li>								
									<li>* 풀스위트 룸의  Pool은 사전예약제로  이용료 10만원 별도 부과됩니다.	</li>							
									<li>* 금요일, 토요일 및 공휴일은 全日 주말요금 적용  //  5월5일 은 주말요금 적용됩니다.</li>								
									<li>* 조식뷔페시행 2인조식포함진행되며, 07:30 ~09:30까지 이용가능합니다.</li>
									<li>* 객실 추가 및 다른 타입의 객실 예약은 예약 완료 후, 추가 예약 접수를 하시기 바랍니다.</li>
									<li>* 기타 문의사항은 전화 문의 (064-741-5000) 바랍니다.</li>
								</ul>
							</div>
							
							<h4>객실 선택</h4>
							<div class="input-area mb40">
								<div class="bottom-table">
									<table summary="객실 정보 입력">
										<caption>객실 정보 입력</caption>
										<colgroup>
											<col width="180px;"/>
											<col width="540px;"/>
										</colgroup>
										<tbody>
											<tr>
												<th scope="row"><label for="room_name">객실 타입</label></th>
												<td><select name="room_no" id="room_no" title="객실 타입" style="width: 200px;" onchange="get_fee_cal()">
													<option value="">선택하세요.</option>
												<?
													$rque="select * from rm_room where room_state=1 order by room_sort";
													$rsql=sql_query($rque);
													while($rarr=sql_fetch_array($rsql)) {
												?>
                                                    <option value="<?=$rarr[room_no]?>"><?=$rarr[room_name]?> [<?=$a_room_type[$rarr[room_type]]?>]</option>
												<? 	} ?>
												</select>
												&nbsp;&nbsp;&nbsp;  
												<input type="checkbox" name="breakfast_chk" id="breakfast_chk" value=1 onchange="get_fee_cal()">조식포함(각 객실당 2인)</td>
												<!-- <th scope="row"><label for="resRmtype">객실 타입</label></th>
												<td><select name="resRmtype" id="resRmtype" title="객실 타입" style="width: 190px;">
                                                    <option value="마운틴 뷰">마운틴 뷰</option>
                                                    <option value="오션 뷰">오션 뷰</option>
												</select></td> -->
											</tr>
											<tr>
												<th scope="row"><label for="resRms">객실수 및 기준인원</label></th>
												<td><select name="room_cnt" id="room_cnt" title="객실수" style="width: 80px;" onchange="get_fee_cal()">
												<?	for($i=1; $i<=5; $i++) { ?>
												<option value="<?=$i?>">객실수 <?=$i?></option>
												<?	} ?>
												</select> <input type=text id="basis_num" style="width:150px" readonly>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- input-area -->
							<h4>추가옵션 선택</h4>
							<div class="input-area mb40">
								<div class="bottom-table">
									<table summary="추가 옵션 입력">
										<caption>추가 옵션 입력</caption>
										<colgroup>
											<col width="180px;"/>
											<col width="540px;"/>
										</colgroup>
										<tbody>
											<tr>
												<th scope="row">인원추가</th>
												<td><label for="resAddAdult">성인</label> 
												<select name="add_adult" id="add_adult" title="성인" style="width: 60px;" onchange="get_fee_cal()">
														<option value="0">선택</option>
														<? for($i=1; $i<=10; $i++) { ?>
														<option value="<?=$i?>"><?=$i?></option>
														<? } ?>
												</select> 명,
                                                <label for="resAddChild">소아</label> 
                                                <select name="add_child" id="add_child" title="소아" style="width: 60px;" onchange="get_fee_cal()">
														<option value="0">선택</option>
														<? for($i=1; $i<=10; $i++) { ?>
														<option value="<?=$i?>"><?=$i?></option>
														<? } ?>
												</select> 명
													<p class="txt-blue">- 14세~성인 1인당 <?=number_format($b_add_fee)?>원 추가</p></td>
											</tr>
											<tr>
												<th scope="row">조식추가</th>
												<td><label for="resAddBrkAdult">성인</label>
												<select	name="breakfast_adult" id="breakfast_adult" title="성인" style="width: 60px;" onchange="get_fee_cal()">
													<option value="0">선택</option>
													<? for($i=1; $i<=10; $i++) { ?>
													<option value="<?=$i?>"><?=$i?></option>
													<? } ?>
												</select> 명, <label for="resAddBrkChild">소아</label> 
												<select	name="breakfast_child" id="breakfast_child" title="소아" style="width: 60px;" onchange="get_fee_cal()">
													<option value="0">선택</option>
													<? for($i=1; $i<=10; $i++) { ?>
													<option value="<?=$i?>"><?=$i?></option>
													<? } ?>
												</select> 명
													<p class="txt-blue">- 유아(5세미만) 무료, 소아(5세~13세) 1인당 <span id="spanAddBrkAdultAmt"><?=number_format($a_breakfast_fee[child])?></span>원, 14세~성인 1인당 <span id="spanAddBrkChildAmt"><?=number_format($a_breakfast_fee[adult])?></span>원 추가
													</p></td>
											</tr>
											<tr>
												<th scope="row">이불세트 or <br>추가침대(접이식)</th>
												<td><select name="bed_cnt" id="bed_cnt" title="추가침대" style="width: 80px;" onchange="get_fee_cal()">
													<option value="0">선택</option>
													<?	for($i=1; $i<=5; $i++) { ?>
													<option value="<?=$i?>">추가 <?=$i?></option>
													<?	} ?>
												</select>
												<p class="txt-blue">- 이불 세트 또는 추가침대(접이식) 추가 비용 <?=number_format($b_bed_fee)?>원<br>
												- 인원+침구 추가 이용 시 <?=number_format($b_add_bed_fee)?>원<br>
												- 인원+침구 선택시 최대 인원까지만 침대 또는 이불세트가 제공됩니다.(최대인원 초과시 입실불가)<br>
												- 입실일 기준 유아베드 여유시 무료대여 (추가 침구류 제외)</p></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- input-area -->
					  </div>
				  </div>
			  </div>
				<!-- select-side -->
				<div class="result-side">
					<div class="reserved-box">
						<h4>예약정보</h4>
						<div class="cont" id="divReservationTotal" style="display:block;">
							<ul class="dot">
                                <li> <span id="spanPreComplex"></span></li>
								<li>체크인 : <input type=text id="s_date2" style="width:100px;" readonly></span></li>
								<li>체크아웃 : <input type=text id="e_date2" style="width:100px;" readonly></li>
								<li>숙박일수 : <input type="text" name="total_day2" id="total_day2" value="<?=$total_day?>" readonly style="width:27px;"/>박
								</li>
								<li>객실: <input type=text name="room_name2" id="room_name2" style="width:150px;" readonly></span></li>
								<li>객실 수 : <input type=text id="room_cnt2" value="1" style="width:30px;" readonly></li>
								<li>추가인원 : 성인 <input type=text id="add_adult2" style="width:15px;" readonly>명, 소아 <input type=text id="add_child2" style="width:15px;" readonly>명
								</li>
								<li>조식추가 : 성인 <input type=text id="breakfast_adult2" style="width:15px;" readonly>명, 소아 <input type=text id="breakfast_child2" style="width:15px;" readonly>명
								</li>
								<li>침대및침구추가 : <input type=text id="bed_cnt2" style="width:15px;" readonly>개
								</li>
							</ul>
						</div>
					</div>
					<div class="fee-box">
						<table summary="요금" id="tblReservationAmt" style="display:block;">
							<caption>요금</caption>
							<colgroup>
								<col width="125px;"/>
								<col width="115px;"/>
							</colgroup>
							<tbody>
								<tr>
									<th scope="row">객실요금</th>
									<td><input type=text name="room_fee" id="room_fee" style="width:65px; text-align:right;" readonly> 원</td>
								</tr>
								<tr>
									<th scope="row">추가인원요금</th>
									<td><input type=text name="add_fee" id="add_fee" style="width:65px; text-align:right;" readonly> 원</td>
								</tr>
								<tr>
									<th scope="row">조식추가요금</th>
									<td><input type=text name="breakfast_fee" id="breakfast_fee" style="width:65px; text-align:right;" readonly> 원</td>
								</tr>
								<tr>
									<th scope="row">보조침대추가요금</th>
									<td><input type=text name="bed_fee" id="bed_fee" style="width:65px; text-align:right;" readonly> 원</td>
								</tr>
							</tbody>
						</table>
						<table summary="총 요금">
							<caption>총 요금</caption>
							<colgroup>
								<col width="125px;"/>
								<col width="115px;"/>
							</colgroup>
							<tbody>
								<tr class="total">
									<th scope="row">총 요금</th>
									<td><input type=text name="total_fee" id="total_fee" style="width:65px; background-color:#f2f2f2; border-width:0px; text-align:right;" readonly> 원</td>
								</tr>
							</tbody>
						</table>
					</div>
					<ul class="result-txt" id="remark">
						<li>※ 상기 요금에는 10%의 세금이 포함되어 있습니다.</li>
					</ul>
				</div>
				<!-- result-side -->
			</div>
			<div class="btn-center">
				<a href="javascript:" onclick="form_submit();"><img src="/images/choice-btn.gif"></a>
			</div>
		</div>
</form>

    <!-- 객실도면 -->
<!--<div class="window modal-map">
    <div class="layer-container">
        <div class="layer-hd">
            <h3>객실도면 보기</h3>
            <button class="close"><img src="//" alt="close"/></button>
        </div>
        <div class="layer-content">
            <img src="//"/>
            </div>
    </div>
</div>-->

<!-- 위치보기 -->
<!--<div class="window modal-location">
    <div class="layer-container">
        <div class="layer-hd">
            <h3>위치 보기</h3>
            <button class="close"><img src="//"/></button>
        </div>
        <div class="layer-content">
            <div><button type="image" onclick="modalPrint(this);"><img src="//"/></button></div>
                <img class="printImage" src="//"/>
            </div>
    </div>
</div>-->


<!-- 도면보기
<div class="window map2 modal-map2">
    <div class="layer-container">
        <div class="layer-hd">
            <h3>도면보기</h3>
            <button class="close"><img src="//"/></button>
        </div>
        <div class="tab">
            <ul>
                </ul>
        </div>
        
        <div class="layer-content">
            <ul>
                </ul>
        </div>
    </div>
</div>
 -->

    </div>
</div></div>
        </div>
    </div>
<?
include_once(G5_PATH.'/tail.php');
?>     