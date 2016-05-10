<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '예약관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

$que="select * from rc_reserve where rsv_no='$rsv_no'";
$arr=sql_fetch_array(sql_query($que)); 

$use_hour = round(($arr[e_date]-$arr[s_date])/3600);

$gque="select * from rc_rsv_add_goods where reserve_no='$arr[reserve_no]' order by goods_no";
$gsql=sql_query($gque);
while($garr=sql_fetch_array($gsql)) {
	$goods_cnt_arr[$garr[goods_no]]=$garr[goods_cnt];
	$goods_fee_arr[$garr[goods_no]]=$garr[goods_fee];
}

$add_no_tmp=0;
$aque="select * from rc_add_goods where add_state=1 order by add_no";
$asql=sql_query($aque);
while($aarr=sql_fetch_array($asql)) {
	$add_no_arr[$add_no_tmp]=$aarr[add_no];
	$add_no_tmp++;
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

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

function get_fee_cal()
{
	s_date = document.getElementById('s_date').value;
	s_hour = document.getElementById('s_hour').value;
	s_min = document.getElementById('s_min').value;
	e_date = document.getElementById('e_date').value;
	e_hour = document.getElementById('e_hour').value;
	e_min = document.getElementById('e_min').value;

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
				url: "../car_get.php",
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
	document.getElementById('car_fee').value = data[0].car_fee;  
	document.getElementById('car_name').value = data[0].car_name;
	document.getElementById('insure_fee').value = data[0].insure_fee;
	document.getElementById('add_goods_fee').value = data[0].add_goods_fee;
	document.getElementById('out_fee').value = data[0].out_fee;
	document.getElementById('total_fee').value = data[0].total_fee;
}
function form_submit(f) {
	f.submit();
}
function del(car_no) {
	if(confirm('정말 삭제하시겠습니까?\n\n삭제된 예약은 복구되지 않습니다.'))
	{
		if (car_no != 'all') document.location.href = "<?=$_SERVER['PHP_SELF']?>?mode=del&car_no=" + car_no;			
		else
		{
			f=document.fee_form;
			f.mode.value='del';
			f.submit();
		}
	} 
	return false;
}
</script>

<form name=rsv_form method=POST enctype='multipart/form-data' action='reserve_update.php'>
<input type=hidden name=mode value='<?if($rsv_no) { echo"update"; } else { echo"insert"; }?>'>
<input type=hidden name=rsv_no value='<?=$rsv_no?>'>
<input type=hidden name=car_name id=car_name value='<?=$arr[car_name]?>'>

<div class="tbl_basic">
    <table>
	<colgroup>
		<col width="15%"/>
		<col width="40%"/>
		<col width="15%"/>
		<col width="30%"/>
	</colgroup>
	  <tr>
		<th>예약번호</th>
		<td><?=$arr[reserve_no]?></td>
		<th>이용시간</td>
		<td><input type="text" name="use_hour" id="use_hour" value="<?=$use_hour?>" readonly style="width:30px; text-align:center"/>시간</td>
	  </tr>
	  <tr>
		<th>인수일시</th>
		<td><input type=text name=s_date id=s_date value='<?=date('Y-m-d',$arr[s_date])?>' size=12 readonly onchange="get_fee_cal()">
			<select name="s_hour" id="s_hour" style="width:60px;" onchange="get_fee_cal()">
				<option value="">시</option>
				<? for($i=8; $i<=22; $i++) { ?>
				<option value="<?=$i?>" <?if(date(H,$arr[s_date])==$i) echo"selected"; ?>><?=$i?>시</option>
				<? } ?>
			</select>
			<select name="s_min" id="s_min" style="width:60px;" onchange="get_fee_cal()">
				<option value="">분</option>
				<? for($i=0; $i<60; $i+=30) { ?>
				<option value="<?=$i?>" <?if(date(i,$arr[s_date])==$i) echo"selected"; ?>><?=$i?>분</option>
				<? } ?>
			</select></td>
		<th>반납일시</th>
		<td><input type=text name=e_date id=e_date value='<?=date('Y-m-d',$arr[e_date])?>' size=12 readonly onchange="get_fee_cal()">
			<select name="e_hour" id="e_hour" style="width:60px;" onchange="get_fee_cal()">
				<option value="">시</option>
				<? for($i=8; $i<=22; $i++) { ?>
				<option value="<?=$i?>" <?if(date(H,$arr[e_date])==$i) echo"selected"; ?>><?=$i?>시</option>
				<? } ?>
			</select>
			<select name="e_min" id="e_min" style="width:60px;" onchange="get_fee_cal()">
				<option value="">분</option>
				<? for($i=0; $i<60; $i+=30) { ?>
				<option value="<?=$i?>" <?if(date(i,$arr[e_date])==$i) echo"selected"; ?>><?=$i?>분</option>
				<? } ?>
			</select></td>
	  </tr>
	  <tr>
		<th>차종</th>
		<td><select name="car_no" id="car_no" style="width:240px;" onchange="get_fee_cal()">
			<option value="">선택하세요.</option>
		<?
			$rque="select * from rc_car order by car_sort, car_no";
			$rsql=sql_query($rque);
			while($rarr=sql_fetch_array($rsql)) {
		?>
			<option value="<?=$rarr[car_no]?>" <?if($arr[car_no]==$rarr[car_no]) echo"selected"; ?>><?=$rarr[car_name]?> [<?=$a_fuel_type[$rarr[fuel_type]]?>]</option>
		<? 	} ?>
		</select></td>
		<th>대수</td>
		<td><input type="text" name="car_cnt" id="car_cnt" value="<?=$arr[car_cnt]?>" readonly style="width:30px; text-align:center"/> 대</td>
	  </tr>
		<th>인수장소</th>
		<td><select title="인수장소" name="s_place" id="s_place" style="width:150px;" onchange="get_fee_cal()">
			<? foreach($a_place as $key => $val) { ?>
			<option value="<?=$key?>"<?if($key==$arr[s_place]) echo" selected"; ?>><?=$val?> (<?=number_format($a_place_fee[$key])?>원)</option>
			<? } ?>
		  </select></td>
		<th>차량요금</th>
		<td><input type=text name="car_fee" id="car_fee" style="width:60px; text-align:right;" value="<?=$arr[car_fee]?>"> 원</td>
	  </tr>
	  <tr>
		<th>반납장소</th>
		<td><select title="인수장소" name="e_place" id="e_place" style="width:150px;" onchange="get_fee_cal()">
			<? foreach($a_place as $key => $val) { ?>
			<option value="<?=$key?>"<?if($key==$arr[e_place]) echo" selected"; ?>><?=$val?> (<?=number_format($a_place_fee[$key])?>원)</option>
			<? } ?>
		  </select></td>
		<th>배반차요금</th>
		<td><input type=text name="out_fee" id="out_fee" style="width:60px; text-align:right;" value="<?=$arr[out_fee]?>"> 원</td>
	  </tr>
	  <tr>
		<th>자차보험</th>
		<td><select name="rsv_insure" id="rsv_insure" style="width:100px;" onchange="get_fee_cal()">
			<? foreach($a_insure as $key => $val) { ?>
			<option value="<?=$key?>"<?if($key==$arr[rsv_insure]) echo" selected"; ?>><?=$val?></option>
			<? } ?>
		  </select></td>
		<th>자차보험료</th>
		<td><input type=text name="insure_fee" id="insure_fee" style="width:60px; text-align:right;" value="<?=$arr[insure_fee]?>"> 원</td>
	  </tr>
	  <tr>
		<th>총요금</th>
		<td><input type=text name="total_fee" id="total_fee" style="width:60px; text-align:right;" value="<?=$arr[total_fee]?>"> 원</td>
		<th>부가서비스료</th>
		<td><input type=text name="add_goods_fee" id="add_goods_fee" style="width:60px; text-align:right;" value="<?=$arr[add_goods_fee]?>"> 원</td>
	  </tr>
	  <tr>
		<th>부가서비스</th>
		<td colspan=3><table>
			<tr>
			<?
				$aque="select * from rc_add_goods where add_state=1 order by add_no";
				$asql=sql_query($aque);
				while($aarr=sql_fetch_array($asql)) {
					if($arr[rsv_insure]) $add_fee=$aarr[add_fee2];
					else $add_fee=$aarr[add_fee1];
			?>
				<td><label id="lab_add_goods_<?=$aarr[add_no]?>"><?=$aarr[add_name]?>(<?=number_format($add_fee)?>원) 
				<select name="add_goods_<?=$aarr[add_no]?>" id="add_goods_<?=$aarr[add_no]?>" onchange="get_fee_cal()">
					<? for($i=0; $i<=5; $i++) { ?>
					<option value="<?=$i?>"<?if($goods_cnt_arr[$aarr[add_no]]==$i) echo" selected";?>><?=$i?></option>
					<? } ?>
				</select></td>
			<? } //while() ?>
			</tr></table>
		</td>
	  </tr>
	  <tr>
		<th>이름</th>
		<td><input type=text name="cus_name" id="cus_name" value="<?=$arr[cus_name]?>"></td>
		<th></th>
		<td></td>
	  </tr>
	  <tr>
		<th>연락처</th>
		<td><input type=text name="cus_phone" id="cus_phone" value="<?=$arr[cus_phone]?>"></td>
		<th>이메일</th>
		<td><input type=text name="cus_email" id="cus_email" value="<?=$arr[cus_email]?>" style="width:95%;"></td>
	  </tr>
	  <tr>
		<th>신청일시</th>
		<td><?=date('Y-m-d H:i',$arr[w_time])?></td>
		<th>예약상태</th>
		<td><select name="rsv_state" id="rsv_state" style="width:60px;">
			<? while(list($key,$val)=each($a_state)) { ?>
			<option value="<?=$key?>" <?if($arr[rsv_state]==$key) echo"selected"; ?>><?=$val?></option>
			<? } ?>
		  </select></td>
	  </tr>
	  <tr>
		<th>고객요청사항</th>
		<td colspan=3><textarea name="comment" rows=5 cols=80><?=$arr[comment]?></textarea></td>
	  </tr>
	  <tr>
		<th>수정일시</th>
		<td><?=date('Y-m-d H:i',$arr[m_time])?></td>
		<th>수정직원</th>
		<td><?=$arr[m_staff]?></td>
	  </tr>
	  <tr>
		<th>직원메모</th>
		<td colspan=3><textarea name="rsv_memo" rows=5 cols=80><?=$arr[rsv_memo]?></textarea></td>
	  </tr>
	</table>
</div>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="저장하기" class="btn_submit" accesskey="s" onclick="return form_submit(this.form)">
		<? if($rsv_no) { ?> <input type=button class="btn_submit" value='삭제하기' style=cursor:hand onclick='return del(<?=$rsv_no?>)'><? } ?>
		<a href="reserve_list.php?page=<?=$page?>">목록보기</a>
	</div>
</form>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>