<?
include_once('./include/common.php');
include_once("./include/head.php");
include_once("./rent/inc/config.php");
include_once("./rent/inc/function.php");

if($s_date && $s_hour && $e_date && $e_hour) {
	$fyear=substr($s_date,0,4);
	$fmonth=substr($s_date,5,2);
	$fday=substr($s_date,8,2);
	$fhour=$s_hour;
	$fmin=$s_min;

	$lyear=substr($e_date,0,4);
	$lmonth=substr($e_date,5,2);
	$lday=substr($e_date,8,2);
	$lhour=$e_hour;
	$lmin=$e_min;
} else {
	$fyear=date("Y");
	$fmonth=date("m");
	$fday=date("d");
	$fhour=date("H")+1;
	if($fhour<8) $fhour=8;
	elseif($fhour>22) $fhour=22;
	$fmin="00";

	$tomorrow = time()+60*60*24;
	$lyear=date("Y",$tomorrow);
	$lmonth=date("m",$tomorrow);
	$lday=date("d",$tomorrow);
	$lhour=date("H",$tomorrow)+1;
	if($lhour<8) $lhour=8;
	elseif($lhour>22) $lhour=22;
	$lmin="00";
}

$s_time=mktime($fhour,$fmin,0,$fmonth,$fday,$fyear);
$e_time=mktime($lhour,$lmin,0,$lmonth,$lday,$lyear);

$total_term = round(($e_time-$s_time)/3600); // 총 사용 시간

$oque="select * from rc_out_fee where out_state=1 order by out_sort, out_no";
$osql=sql_query($oque);
while($oarr=sql_fetch_array($osql)) {
	$a_place[$oarr[out_no]]=$oarr[out_name];
}
?>
	<div class="colgroup1 clearfix">
		<div class="visual">
			<h2 class="skip">VIP제주여행</h2>
			<ul class="visual_list clearfix">
			<li>
				<img src="/images/m_banner1.jpg" alt="VIP제주여행"/>
				<a href="#" target="_self">
					<strong class="ti"></strong>
					<span class="txt"></span>
				</a>
			</li>
		
			<li>
				<img src="/images/m_banner1.jpg" alt="VIP제주여행"/>
				<a href="#" target="_self">
					<strong class="ti"></strong>
					<span class="txt"></span>
				</a>
			</li>
		
			<li>
				<img src="/images/m_banner1.jpg" alt="VIP제주여행"/>
				<a href="#" target="_self">
					<strong class="ti"></strong>
					<span class="txt"></span>
				</a>
			</li>
		
			</ul>
			<div class="visual_ctrl">
				<span class="visual_count"></span>
				<button class="visual_play"><img src="/images/m_banner_btn_stop.png" alt="재생"/></button>
				<button class="visual_prev"><img src="/images/m_banner_btn_prev.png" alt="이전"/></button>
				<button class="visual_next"><img src="/images/m_banner_btn_next.png" alt="다음"/></button>
			</div>
		</div><!-- //메인 비주얼-->


 <!--달력스크립트-->
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.datePicker2.js"></script>		
<script type="text/javascript" src="/js/date2.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="/css/datePicker2.css">        


<script type="text/javascript" charset="utf-8">

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
					$('#cal3').dpSetSelected(selectedDate.addDays(1).asString());
				}
			);
		$('#cal3')
			.datePicker({inline:true,startDate:"<?=date('Y-m-d'),time()+60*60*24?>"})
			.dpSetSelected(k_date_e)	
			.bind(
				'dateSelected',
				function(e, selectedDate, $td)
				{
					$('#e_date').val(selectedDate.asString());
					$('#e_date2').val(selectedDate.asString());
					cal_term();
				}
			);
			
   });	

function cal_term() {
	var f=document.search_form;
	var s_date=f.s_date.value;
	var e_date=f.e_date.value;
	var s_date_arr=s_date.split("-");
	var e_date_arr=e_date.split("-");

	y1=eval(s_date_arr[0]);
	m1=eval(s_date_arr[1]-1);
	d1=eval(s_date_arr[2]);
	h1=eval(f.s_hour.value);
	i1=eval(f.s_min.value);
	y2=eval(e_date_arr[0]);
	m2=eval(e_date_arr[1]-1);
	d2=eval(e_date_arr[2]);
	h2=eval(f.e_hour.value);
	i2=eval(f.e_min.value);

	today=new Date();
	day1=new Date(y1,m1,d1,h1,i1,0,0);
	day2=new Date(y2,m2,d2,h2,i2,0,0);

	todate=today.getTime()-60*60*24*1000;
	date1=day1.getTime();
	date2=day2.getTime();
	term=Math.round((date2-date1)/60/60/1000);

	f.s_hour2.value=f.s_hour.value;
	f.s_min2.value=f.s_min.value;
	f.e_hour2.value=f.e_hour.value;
	f.e_min2.value=f.e_min.value;
	f.place1_2.value=f.place1.value;
	f.place2_2.value=f.place2.value;
	for(i=0; i<f.insure.length; i++) {
		if(f.insure[i].checked==true) {
			f.insure_txt.value=eval("f.insure_txt"+(i+1)+".value");
			break;
		}
	}

	f.total_term.value=term;
	//f.total_term2.value=term;
}

function Chk_sear(){
	$("#chajong").show().delay(2000);
	$('#chajong').fadeOut('slow', function() {
	// Animation complete
	});
}

function search_submit(val) {
	var f=document.search_form;
	if(val) f.k_code.value=val;
	f.action="./rent/car_list.php";
	f.submit();
}

</script>
   
	  <table width="1200" align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
<form name="search_form" id="search_form" method="post">
<input type=hidden name="k_code" value="<?=$k_code?>">
              <tr>
                <td width="25%" height="331" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="45" bgcolor="#dd3616" style="border-left:1px solid #dd3616;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" height="45" align="center"><font class="s_list3">대여일시</font></td>
                      <td width="1" bgcolor="#FFFFFF"></td>
                      <td width="10"></td>
                      <td><input type="text" name="s_date" id="s_date" size="11" STYLE="border:0px; height:26px; background-color:#dd3616; color:#ffffff; font-size:16px; padding:0 5px 5px 0;" class="s_list4" readonly>
				  <select name="s_hour" id="s_hour" style="border:0px; height:28px; background-color:#bf2612; color:#ffffff;" class="s_list4" onChange="cal_term()">
<?
	for($i=8; $i<=22; $i++) {
		echo"<option value='".$i."'"; if($fhour==$i) echo"selected"; echo">".$i."</option>";
	}
?>
				  </select><font color="#ffffff">:</font><select name="s_min" id="s_min" style="border:0px; height:28px; background-color:#bf2612; color:#ffffff;" class="s_list4" onChange="cal_term()">
					<option value='00'<? if($fmin==0) echo" selected"; ?>>00</option>
					<option value='30'<? if($fmin==30) echo" selected"; ?>>30</option>
				  </select></td>
                    </tr>
                  </table></td></tr>
                <tr><td height="0" bgcolor="#ffffff"></td></tr>
                <tr><td height="286" valign="top" style="border-bottom:2px solid #dd3616;border-left:1px solid #7f7f7f;"><div id="cal2"></div></td></tr>
                <tr><td style="padding:0 0 0 15px"></td></tr>
           	    </table></td>
                <td width="0"></td>
                <td width="25%" height="331" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td height="45" bgcolor="#588d2d" style="border-right:1px solid #588d2d;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" height="45" align="center"><font class="s_list3">반납일시</font></td>
                      <td width="1" bgcolor="#FFFFFF"></td>
                      <td width="10"></td>
                      <td><input type="text" name="e_date" id="e_date" size="11" STYLE="border:0px; height:26px; background-color:#588d2d; color:#ffffff; font-size:16px; padding:0 5px 5px 0;" class="s_list4" readonly>
				  <select name="e_hour" id="e_hour" style="border:0px; height:28px; background-color:#3b621c; color:#ffffff;" class="s_list4" onChange="cal_term()">
<?
	for($i=8; $i<=20; $i++) {
		echo"<option value='".$i."'"; if($lhour==$i) echo"selected"; echo">".$i."</option>";
	}
?>
				  </select><font color="#ffffff">:</font><select name="e_min" id="e_min" style="border:0px; height:28px; background-color:#3b621c; color:#ffffff;" class="s_list4" onChange="cal_term()">
					<option value='00'<? if($lmin==0) echo" selected"; ?>>00</option>
					<option value='30'<? if($lmin==30) echo" selected"; ?>>30</option>
				  </select></td>
                    </tr>
                  </table></td></tr>
                <tr><td height="0" bgcolor="#ffffff"></td></tr>
                <tr><td height="286" valign="top" style="border-bottom:2px solid #588d2d;border-left:1px solid #7f7f7f;"><div id="cal3"></div></td></tr>
                <tr><td style="padding:0 0 0 15px"></td></tr>
           	    </table></td>
                <td width="0"></td>
                <td width="25%" height="331" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="45" bgcolor="#3a8bde"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="120" height="45" align="left" style="padding:0 0 0 15px;"><font class="s_list3">인수/반납지점 및 보험 선택</font></td>
                    </tr>
                  </table></td>
                  </tr>
                  <tr>
                    <td height="0" bgcolor="#ffffff"></td>
                  </tr>
                  <tr>
                    <td height="271" align="center" valign="top" style="padding:15px 0 0 0; border-left:1px solid #7f7f7f; border-bottom:2px solid #3a8bde;""><table width="270" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"><font class="s_list1">인수장소 선택 : <select name="place1" id="place1" style="border:1px solid #c1c1c1; height:25px; background-color:#f2f2f2; color:#444444; width:170px;" class="s_list1" onChange="cal_term()">
							<? foreach($a_place as $key => $val) { ?>
								<option value="<?=$val?>"><?=$val?></option>
							<? } ?>
							</select></font></td>
                          </tr>
                          <tr>
                            <td height="4" align="left"></td>
                          </tr>
                          <tr>
                            <td align="left"><font class="s_list1">반납장소 선택 : <select name="place2" id="place2" style="border:1px solid #c1c1c1; height:25px; background-color:#f2f2f2; color:#444444; width:170px;" class="s_list1" onChange="cal_term()">
							<? foreach($a_place as $key => $val) { ?>
								<option value="<?=$val?>"><?=$val?></option>
							<? } ?>
							</select></font></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="22"></td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
						<? foreach($a_insure_info as $key => $val) { ?>
                          <tr>
                            <td height="24" align="left"><input type="radio" name="insure" id="insure<?=$key+1?>" value="<?=$key?>" <? if($insure==$key) echo"checked"; ?> style="position:relative; top:2" onChange="cal_term()"> <input type=text name="insure_txt<?=$key+1?>" value="<?=$val?>" style="border:0px; width:250px;"></td>
                          </tr>
						<? } ?>
                          <tr>
                            <td height="24" align="center" style="padding:15px 0 0 0;">
							<table width="238" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><a href="#" class="pop_wrap" data-pop-wrap-id="insurance1"><img src="/images/btn_insurance1.gif"></a></td>
                                <td width="6"></td>
                                <td><a href="#" class="pop_wrap" data-pop-wrap-id="insurance2"><img src="/images/btn_insurance2.gif"></a></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="25"></td>
                      </tr>
                      <tr>
                        <td align="center"><table width="96%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="18" align="left"><font class="s_list5">※사고로 인해 차량 운행이 불가능한 경우에는 사</font></td>
                          </tr>
                          <tr>
                            <td height="18" align="left"><font class="s_list5">고지점에서 계약이 종료됩니다.</font></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                <div id="scooter_list" style="line-height:150%;"></div>
                <div id="total_fee" class="charge"></div></td>
                <td width="0"></td>
                <td width="25%" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="45" bgcolor="#e77529"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" height="45" align="center"><font class="s_list3">요금확인</font></td>
                      <td width="1" bgcolor="#FFFFFF"></td>
                      <td width="18"></td>
                      <td><font class="s_list3">총 <input type="text" name="total_term" id="total_term" value="<?=$total_term?>" width="10px" size="3" STYLE="border:0px; height:26px; background-color:#e77529; text-align:center; color:#ffffff; font-size:16px; padding:2px 0px 0px 0; width:30px;" class="s_list4" readonly>시간</font></td>
                    </tr>
                  </table></td>
                  </tr>
                  <tr>
                    <td height="0" bgcolor="#ffffff"></td>
                  </tr>
                  <tr>
                    <td height="286" valign="top" style="padding:0px 0 0 0;border-right:1px solid #7f7f7f; border-bottom:2px solid #e77529; border-left:1px solid #7f7f7f;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="padding:15px 0 0 10px"><table width="96%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="22" align="left"><font class="s_list1">대여일시 : <input type="text" name="s_date2" id="s_date2" width="10px" size="11" STYLE="border:0px; height:15px; background-color:#ffffff; color:#444444; font-size:13px; padding:0 0px 7px 0;" class="s_list1" readonly> <input type="text" name="s_hour2" id="s_hour2" value="<?=$fhour?>" STYLE="border:0px; height:15px; background-color:#ffffff; text-align:right; color:#444444; font-size:13px; padding:0 0px 7px 0; width:22px;" class="s_list1" readonly>:<input type="text" name="s_min2" id="s_min2" value="<?=$fmin?>" STYLE="border:0px; height:15px; background-color:#ffffff; color:#444444; font-size:13px; padding:0 0px 7px 0; width:22px;" class="s_list1" readonly> 부터</font></td>
                          </tr>
                          <tr>
                            <td height="22" align="left"><font class="s_list1">반납일시 : <input type="text" name="e_date2" id="e_date2" width="10px" size="11" STYLE="border:0px; height:15px; background-color:#ffffff; color:#444444; font-size:13px; padding:0 0px 7px 0;" class="s_list1" readonly> <input type="text" name="e_hour2" id="e_hour2" value="<?=$lhour?>" size="2" STYLE="border:0px; height:15px; background-color:#ffffff; text-align:right; color:#444444; font-size:13px; padding:0 0px 7px 0; width:22px;" class="s_list1" readonly>:<input type="text" name="e_min2" id="e_min2" value="<?=$lmin?>" STYLE="border:0px; height:15px; background-color:#ffffff; color:#444444; font-size:13px; padding:0 0px 7px 0; width:22px;" class="s_list1" readonly> 까지</font></td>
                          </tr>
                          <tr>
                            <td height="6" align="left"></td>
                          </tr>
                          <tr>
                            <td height="22" align="left"><font class="s_list1">인수장소 : <input type=text name=place1_2 value="<?=$a_place[1]?>" style="width:100px"></font></td>
                          </tr>
                          <tr>
                            <td height="22" align="left"><font class="s_list1">반납장소 : <input type=text name=place2_2 value="<?=$a_place[1]?>" style="width:100px"></font></td>
                          </tr>
                          <tr>
                            <td height="6" align="left"></td>
                          </tr>
                          <tr>
                            <td height="22" align="left"><font class="s_list1">보험가입 : </font></td>
                          </tr>
                          <tr>
                            <td height="22" align="left"><input type=text name="insure_txt" style="border:0px; width:250px;"></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="60" align="center"><img src="/images/fin_btn.png" onclick="search_submit()" style="cursor:pointer"></td>
                      </tr>
                      <tr>
                        <td align="center" style="padding:0 0 0 10px;"><table width="96%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="18" align="left"><font class="s_list5">※예약변경/취소시 반드시 사전에 연락바랍니다.</font></td>
                          </tr>
                          <tr>
                            <td height="18" align="left"><font class="s_list5">※비예약 접수시 대여요금이 변동될 수 있습니다.</font></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
</form>
                </table></td>
          </tr>
        </table></td>
      </tr>
        </table>       	
	</div><!-- //colgroup1 --> 

	<div class="favorite">
		<div class="wrap">
			<h2>자주찾는 서비스 모음<span></span></h2>
			<div class="fvrt_ctrl">
				<button class="fvrt_prev">이전 서비스 모음 보기</button>
				<button class="fvrt_next">다음 서비스 모음 보기</button>
			</div>
			<div class="fvrt_wrap">
				<div class="fvrt_list">
					<ul class="clearfix">
						<li style="background-image:url('/images/c_icon1.png');"><a href="#">숙소</a></li>
						<li style="background-image:url('/images/c_icon2.png');"><a href="#">골프</a></li>
						<li style="background-image:url('/images/c_icon3.png');"><a href="#">버스</a></li>
						<li style="background-image:url('/images/c_icon4.png');"><a href="#">택시</a></li>
						<li style="background-image:url('/images/c_icon5.png');"><a href="#">관광지입장권</a></li>
						<li style="background-image:url('/images/c_icon6.png');"><a href="#">단체여행</a></li>
						<li style="background-image:url('/images/c_icon7.png');"><a href="#">맛집정보</a></li>
						<li style="background-image:url('/images/c_icon8.png');"><a href="#">여행정보</a></li>
						<li style="background-image:url('/images/c_icon9.png');"><a href="#">대여안내</a></li>
						<li style="background-image:url('/images/c_icon10.png');"><a href="#">자차보험안내</a></li>
						<li style="background-image:url('/images/c_icon11.png');"><a href="#">부가용품안내</a></li>
						<li style="background-image:url('/images/c_icon12.png');"><a href="#">환불규정</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="colgroup2 clearfix">
		<div class="tour">
			<h2><a href="#"><span class="point_img"></span>여행정보<br />바로가기</a></h2>
			<ul>
				<div class="festival"><h2><a href="#">제주축제<br />바로가기</a></h2></div>
				<div class="cook"><h2><a href="#">맛집정보<br />바로가기</a></h2></div>
			</ul>
		</div>
        <!--<div class="festival">
			<h2><a href="#"><span class="point_img"></span>제주축제<br />바로가기</a></h2>
		</div>
        <div class="cook">
			<h2><a href="#"><span class="point_img"></span>제주축제<br />바로가기</a></h2>
		</div>-->
		<div class="board">
			<h2 class="skip">추천차량, 추천숙소</h2>
			<ul class="clearfix">
				<li>
					<button onclick="tabOn(1,1); return false;" id="tab1m1"><span>추천차량</span></button>
						<div id="tab1c1" class="tabcontent">
						   <div class="brd_summ no_img">
							<? 
								$dque="select * from rc_dc_rate where dc_no=1";
								$darr=sql_fetch($dque);

								$no=0;
								$cque="select * from rc_car where main_sort>0 order by main_sort, car_no limit 3";
								$csql=sql_query($cque);
								while($carr=sql_fetch_array($csql)) {
									$dc_fee=$carr[h24_fee]*(1-$darr["dc_".$carr[kind_code]]/100);
									$dc_fee=floor($dc_fee/1000)*1000;
									$no++;
							?>
							 <a href="/rent/car_form.php?car_no=<?=$carr[car_no]?>">
                                <span class='img<?=$no?>'><img src="/rent/photo/<?=$carr[car_photo]?>" alt=""/></span>
								<span class="ti<?=$no?>"><?=$carr[car_name]?></span>
								<span class="txt<?=$no?>"><?=$a_fuel_type[$carr[fuel_type]]?> / <?=$carr[seater]?>인승 / <?=$carr[made_year]?>년형</span>
                                <span class="price<?=$no?>"><s><?=number_format($carr[h24_fee])?>원</s> → <span class="price<?=$no?>_2"><?=number_format($dc_fee)?></span>원</a>
							<? } ?>		
                         </div>
					    </div>
							<a href="/rent/car_list.php" id="tab1more1" class="brd_more">추천차량 더보기</a>
						  </li><!-- //추천차량 -->
                          
				<li>
					<button onclick="tabOn(1,2); return false;" id="tab1m2"><span>추천숙소</span></button>
						<div id="tab1c2" class="tabcontent">
						   <div class="brd_summ no_img">
							 <a href="#">
                                <span class='img1'><img src="/images/lodging1.jpg" alt=""/></span>
								<span class="ti1">조은리조트</span>
								<span class="txt1"><span class="tsc_buttons small">위치</span>서귀포지역</span>
                                <span class="price1">0원 ~</span></a>
							 <a href="#">
                                <span class='img2'><img src="/images/lodging2.jpg" alt=""/></span>
								<span class="ti2">유니호텔</span>
								<span class="txt2"><span class="tsc_buttons small">위치</span>서부지역</span>
                                <span class="price2">0원 ~</span></a>
							 <a href="#">
                                <span class='img3'><img src="/images/lodging3.jpg" alt=""/></span>
								<span class="ti3">샤뜰레펜션</span>
								<span class="txt3"><span class="tsc_buttons small">위치</span>서귀포지역</span>
                                <span class="price3">0원 ~</span></a>
						</div></div>
							<a href="#" id="tab1more2" class="brd_more">추천숙소 더보기</a>
						  </li><!-- //추천숙소 -->
                          <li>
							<dt>※ 현재 추천차량에 표기된 대여금액은 24시간 적용 요금입니다.</dt>
						  </li>
								
			</ul>
			<script type="text/javascript">tabOn(1,1);</script>
		</div>
		<div class="popup">
			<!--<h2>팝업존</h2>-->
			<div class="pop_ctrl clearfix">
				<button class="pop_prev">이전 팝업 보기</button>
				<button class="pop_stop">팝업 롤링 정지</button>
				<button class="pop_next">다음 팝업 보기</button>
			</div>
			<ul class="pop_list">
			<li><a href="#"><img src="/images/banner_1.jpg" alt=""/></a></li>
			<li><a href="#"><img src="/images/banner_2.jpg" alt=""/></a></li>		
			</ul>
		</div><!-- //팝업존 -->
	</div><!-- //colgroup2 -->

	<div class="colgroup3">
		<div class="colgroup3_right"></div>
		<div class="wrap clearfix">
			<div class="sns_wrap">
				<div>

				  <div class="sns_tabcontent">
						<ul id="tab2c1" class="sns_cnt clearfix">
							


	<li class='m_sns'>
		<a href="#">
			<span class="ti"><b>골프</b>패키지</span>
            <span class="dt">제주도에서 시원한 라운딩을 즐겨보세요.</span>
				<span class='img'>
					<img src="/images/golf_img.jpg" alt=""/>
				</span>
			<span class="txt">골프 + 숙소 + 렌트카 패키지 상품</span>            
		</a>
        <span class="more1"><a href="#">바로가기</a></span>     
		<a href="#" class="retweet"></a>
	</li>
    
	<li class='m_sns'>
		<a href="">
			<span class="ti"><b>택시</b>투어</span>
            <span class="dt">친절한 택시관광과 함께하는 제주여행!</span>
				<span class='img'>
					<img src="/images/taxi_img.jpg" alt=""/>
				</span>
			<span class="txt">1일투어비 : 승합 13만원, 택시 9만원</span>
		</a>
        <span class="more2"><a href="#">바로가기</a></span>
		<a href="#" class="retweet">h</a>
	</li>
    
	<li class='m_sns'>
		<a href="#">
			<span class="ti"><font color="#ffffff"><b>단체</b>여행</font></span>
            <span class="dt"><font color="#ffffff">성공적인 비지니스를 위한 여행</font></span>
				<span class='img'>
				<img src="/images/grouptour_img.jpg" alt=""/>
				</span>
			<span class="txt">워크샵, 세미나 등 단체여행 상품</span>
		</a>
        <span class="more3"><a href="#">바로가기</a></span>
		<a href="#" class="retweet"></a>
	</li>
    
	<li class='m_sns'>
		<a href="#">
			<span class="ti"><b>버스</b>투어</span>
            <span class="dt">가족, 친구, 연인과 함께하는 제주버스여행</span>
				<span class='img'>
				<img src="/images/bus_img.jpg" alt=""/>
				</span>
			<span class="txt">혼자서도 버스여행을 즐길 수 있는 알뜰 상품</span>
		</a>
        <span class="more4"><a href="#">바로가기</a></span>
		<a href="#" class="retweet"></a>
	</li>
    
	<li class='m_sns'>
		<a href="#">
			<span class="ti"><font color="#ffffff"><b>추천</b>호텔</font></span>
            <span class="dt"><font color="#ffffff">특별하고 화려한 밤을 선사할 추천 호텔</font></span>
				<span class='img'>
					<img src="/images/hotel_img.jpg" alt=""/>
				</span>
			<span class="txt">할인가격으로 이용가능한 제주도내 호텔</span>
		</a>
        <span class="more5"><a href="#">바로가기</a></span>
		<a href="#" class="retweet"></a>
	</li>
    
	<li class='m_sns'>
		<a href="#">
			<span class="ti"><font color="#ffffff"><b>부가용품</b>안내</font></span>
            <span class="dt"><font color="#ffffff">VIP만의 특별한 편의장비 대여 서비스!</font></span>
				<span class='img'>
				<img src="/images/service_img.jpg" alt=""/>
				</span>
			<span class="txt">행복하고 안전한 여행을 위해 편의장비 대여</span>
		</a>
        <span class="more6"><a href="#">바로가기</a></span>
		<a href="#" class="retweet"></a>
	</li>

						</ul>

				  </div>
					<script type="text/javascript">tabOn(2,1);</script>
				</div>
			</div><!-- //SNS 모음-->
			<div class="issue_wrap">
				<div class="issue_cnt clearfix">
					<ul class="clearfix">
						<li>
								<img src="/images/cupon_img.jpg" alt="" usemap="#cupon" border="0"/>
                                <map name="cupon" id="cupon">
                                  <area shape="rect" coords="78,145,181,174" href="#" />
                                </map>
						</li>
					</ul>
				</div>
                    <div class="cupon_img2">
					  <img src="/images/cupon_img2.png" alt=""/>
					</div>
			</div><!-- //이슈 -->
		</div><!-- //colgroup3 wrap -->
	</div><!-- //colgroup3 -->
	
	
<?
include_once("./include/tail.php");
?>