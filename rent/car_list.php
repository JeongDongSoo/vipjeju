<?
include_once('../include/common.php');
include_once("../include/head.php");
include_once("./inc/config.php");
include_once("./inc/function.php");

if(!$k_code) $k_code=1;
if(!$insure) $insure=0;

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
//$total_day = floor($total_term/24);

$car_no_arr=array();
$insure_arr=array();
$where_str="where 1";
if($k_code!="all") { $where_str.=" and kind_code='$k_code'"; }
$que="select * from rc_car $where_str order by car_sort, car_no";
$sql=sql_query($que);
$n=0;
while($arr=sql_fetch_array($sql)) {
	$car_no_arr[$n]=$arr[car_no];
	$n++;
}
$car_fee_arr=car_fee_cal($s_time,$e_time,$car_no_arr,$insure);
if($car_fee_arr==false) alert("예약이 불가한 기간입니다.");

$oque="select * from rc_out_fee where out_state=1 order by out_sort, out_no";
$osql=sql_query($oque);
while($oarr=sql_fetch_array($osql)) {
	$a_place[$oarr[out_no]]=$oarr[out_name];
}
?>
 <!--달력스크립트-->
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
	f.action="car_list.php";
	f.submit();
}

</script>

<!-- -->
		<div class="rowgroup">
			<div class="sub_title2">
				<div class="navigation">
					<span class="home">홈</span>  &gt; 렌터카 &gt; <strong>예약하기</strong>
				</div>

				
				<h1>예약하기</h1>
                <h2>할인된 가격으로 렌터카를 이용하세요!</h2>
			</div>
       </div>
<!-- -->  
	<div class="colgroup1 clearfix" style="padding:20px 0 0 0;">   
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
                            <td height="22" align="left"><font class="s_list1">인수장소 : <input type=text name=place1_2 value="<?=$a_place[1]?>"></font></td>
                          </tr>
                          <tr>
                            <td height="22" align="left"><font class="s_list1">반납장소 : <input type=text name=place2_2 value="<?=$a_place[1]?>"></font></td>
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
 
<link type="text/css" rel="stylesheet" href="/css/list/style.css">
<link type="text/css" rel="stylesheet" href="/css/list/default.css">
<link type="text/css" rel="stylesheet" href="/css/list/submenu.css">
<link type="text/css" rel="stylesheet" href="/css/list/tsc_lists.css">
<link type="text/css" rel="stylesheet" href="/css/list/cssmenu369.css">
<link type="text/css" rel="stylesheet" href="/css/list/tsc_pagination.css">
<link type="text/css" rel="stylesheet" href="/css/list/imageCaption.css">

<link rel="stylesheet" type="text/css" href="/css/list/style_common.css">
<link rel="stylesheet" type="text/css" href="/css/list/style_common2.css">
<link rel="stylesheet" type="text/css" href="/css/list/style10.css">

<div id="wrap">
        <div id="container">
                <div id="content">

<div id="rental_category">
	<ul>
<? 
	$kque="select * from rc_kind_code where kind_state=1 order by kind_sort, kind_no";
	$ksql=sql_query($kque);
	while($karr=sql_fetch_array($ksql)) {
		$on_str="";
		if($karr[kind_no]==$k_code) $on_str=" style='background-color:#0063c6'";
?>
		<li<?=$on_str?>><p><a href="javascript:search_submit('<?=$karr[kind_no]?>')"><?=$karr[kind_name]?></a></p></li>
<?	} ?>
		<!-- <li><p><a href="car_list.php?k_code=all">전체</a></p></li>-->
	</ul>
</div>
<div style="clear:both;"></div>
<!--list-->
<div class="rent_car_list" style="margin-top:10px;">
	<ul><!--car list-->
<?
$no=0;
$sql=sql_query($que);
while($arr=sql_fetch_array($sql)) {
	$no++;
	$class="";
	if($no%5==0) $class="last";
?>
	<li class="<?=$class?>">
		<div class="view view-tenth">
			<img src="/rent/photo/<?=$arr[car_photo]?>" width="216" height="147">
			<div class="mask">
				<h2><?=$arr[car_name]?></h2>
				<p style="font-size:14px; font-weight:600">총요금<br /><?=number_format($car_fee_arr[2][$arr[car_no]]+$car_fee_arr[3][$arr[car_no]])?>원</p>
				<a href="car_form.php?car_no=<?=$arr[car_no]?>&rsv_insure=<?=$insure?>" class="info">예약하기</a>
			</div>
		</div>
		<ul class="carinfo"><a href="#" class="info">
		<li class="name"><?=$arr[car_name]?></li>
        	<li class="info"><?=$a_fuel_type[$arr[fuel_type]]?> / <?=$a_gear_type[$arr[gear_type]]?> / <?=$arr[seater]?>인승 / <?=$arr[made_year]?>년식</li>
        	<li><span class="tsc_buttons big">정상요금</span><span style="text-decoration:line-through"><?=number_format($car_fee_arr[1][$arr[car_no]])?>원</span></li>
        	<li><span class="tsc_buttons big">할인요금</span><span class="price"><?=number_format($car_fee_arr[2][$arr[car_no]])?>원</span></li></a>
            <li><?=$a_insure[$insure]?> : <?=number_format($car_fee_arr[3][$arr[car_no]])?>원</li></a>
		</ul>
	</li>
<?}?>
	</ul>
</div>
<!--//end list-->

</div>
<!-- //colgroup2 --><!-- //colgroup3 -->
<script type="text/javascript">	
	var f=document.search_form;
	for(i=0; i<f.insure.length; i++) {
		if(f.insure[i].checked==true) {
			f.insure_txt.value=eval("f.insure_txt"+(i+1)+".value");
			break;
		}
	}
</script>

<?
include_once("../include/tail.php");
?>

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
 <div class="dim-layer">
    <div class="dimBg"></div>
      <div id="pop_limit_age" class="pop-layer">
        <div class="layer_popUp">
            <div class="pop-conts"></div>
        </div>
    </div>
 </div>
 <script type="text/javascript" src="/js/form/common.js"></script>
 <link rel="stylesheet" type="text/css" href="/css/form/common.css">
 <link rel="stylesheet" type="text/css" href="/css/form/form.css" />