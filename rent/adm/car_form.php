<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '차종관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($car_no) {
	$que="select * from rc_car where car_no='$car_no'";
	$arr=sql_fetch_array(sql_query($que)); 
	//$a_car_option=explode('|',$arr[car_option]);
}

if(!$arr[gear_type]) { $arr[gear_type]=2; }
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<script language=JavaScript>
function form_submit(f) {
	if(!f.car_name.value) {
		alert("차종명을 입력하세요."); f.car_name.focus(); return false;
	}
	f.submit();
}
function del(car_no) {
	if(confirm('정말 삭제하시겠습니까?\n\n삭제된 차량은 복구되지 않습니다.'))
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
function see_del(nn) {
	f=document.fee_form;
	if(confirm(nn+'번 실사진을 삭제하시겠습니까?')) {
		f.mode.value='see_del';
		f.del_no.value=nn;
		f.submit();
	}
}

function see_all_del() {
	if(confirm('[<?=$arr[name]?>] 차량의 실사진을 전부 삭제하시겠습니까?')) {
		document.location.href = "<?=$_SERVER['PHP_SELF']?>?mode=see_all_del&car_no=<?=$car_no?>&car_cnt=<?=$car_cnt?>";
	}
}
function spec_search() {
	window.open('spec_code_in.php?car_name='+document.all.car_name.value,'spec_code','top=80,left=520,width=500,height=500,scrollbars=1');
}
</script>

<form name=fee_form method=POST enctype='multipart/form-data' action='car_update.php'>
<input type=hidden name=mode value='<?if($car_no) { echo"update"; } else { echo"insert"; }?>'>
<input type=hidden name=car_no value=<?=$car_no?>>
<input type=hidden name=old_car_photo value='<?=$arr[car_photo]?>'>

<div class="tbl_basic">
    <table>
	  <tr>
		<th>차종분류</td>
		<td><select name=kind_code>
		<?php
		$kque="select * from rc_kind_code where kind_state=1 order by kind_sort, kind_no";
		$ksql=sql_query($kque);
		while($karr=sql_fetch_array($ksql)) {
			echo"<option value=$karr[kind_no]"; if($karr[kind_no]==$arr[kind_code]) { echo" selected"; } echo">$karr[kind_name]</option>";
		}
		?>
		</select></td>
		<th>법인</td>
		<td><select name=corp_code>
<? 
	foreach($a_corp as $key => $val) {
		echo"<option value='".$key."'"; if($arr[corp_no]==$key) { echo" selected"; } echo">".$val."</option>";
	}
?>
		</select></td>
	  </tr>
	  <tr>
		<th>차종명</td>
		<td><input type=text name=car_name value='<?=$arr[car_name]?>' size=25></td>
		<th>차종코드</td>
		<td><input type=text name=car_code value='<?=$arr[car_code]?>' size=6></td>
	  </tr>
	  <tr>
		<th>기 어</td>
		<td><select name=gear_type>
		<?
		while(list($key,$val)=each($a_gear_type)) { ?>
		<option value='<?=$key?>' <? if($arr[gear_type]==$key) { echo"selected"; } ?>><?=$val?></option>
		<? } ?>
		</select></td>
		<th>배기량</td>
		<td><input type=text name=displacement value='<?=$arr[displacement]?>' size=5>cc</td>
	  </tr>
	  <tr>
		<th>연 료</td>
		<td><select name=fuel_type>
		<? while(list($key,$val)=each($a_fuel_type)) { ?>
		<option value='<?=$key?>' <?php if($key==$arr[fuel_type]) { ?>selected<?php } ?>><?=$val?></option>
		<? } ?>
		</select></td>
		<th>10% 연료비</td>
		<td><input type=text name=fuel_fee value='<?=$arr[fuel_fee]?>' size=5>원</td>
	  </tr>
	  <tr>
		<th>공인연비</td>
		<td><input type=text name=fuel_rate value='<?=$arr[fuel_rate]?>' size=3> km/L</td>
		<th>구동방식</td>
		<td><select name=car_wheel>
		<? while(list($key,$val)=each($a_car_wheel)) { ?>
		<option value='<?=$key?>' <? if($arr[car_wheel]==$key) { echo"selected"; } ?>><?=$val?></option>
		<? } ?>
		</select></td>
	  </tr>
	  <tr>
		<th>구매가격</td>
		<td><input type=text name=buy_price value='<?=$arr[buy_price]?>' size=6>만원</td>
		<th>제조회사</td>
		<td><select name=car_maker>
		<? while(list($key,$val)=each($a_car_maker)) { ?>
		<option value='<?=$key?>' <? if($arr[car_maker]==$key) { echo"selected"; } ?>><?=$val?></option>
		<? } ?>
		</select></td>
	  </tr>
	  <tr>
		<th>승차정원</td>
		<td><input type=text name=seater value='<?=$arr[seater]?>' size=2>인승</td>
		<th>연식</td>
		<td><input type=text name=made_year value='<?=$arr[made_year]?>' size=5>년식</td>
	  </tr>
	  <tr>
		<th>정렬순서</td>
		<td><input type=text name=car_sort value='<?=$arr[car_sort]?>' size=3></td>
		<th>메인노출순서</td>
		<td><input type=text name=main_sort value='<?=$arr[main_sort]?>' size=3> 0 은 미노출</td>
	  </tr>
	  <tr>
		<th>연령제한</td>
		<td>만 <select name="drive_age">
		<? for($i=21; $i<=31; $i++) { ?>
			<option value="<?=$i?>" <?if($i==$arr[drive_age]) { echo"selected"; } ?>><?=$i?></option>
		<? } ?>
		</select>세 이상</td>
		<th>운전경력</td>
		<td><select name="drive_year">
		<? for($i=1; $i<=10; $i++) { ?>
			<option value="<?=$i?>" <?if($i==$arr[drive_year]) { echo"selected"; } ?>><?=$i?></option>
		<? } ?>
		</select>년 이상</td>
	  </tr>
	  <tr>
		<th>보유여부</td>
		<td><select name=keep_car style="color:<?=$a_keep_car_color[$arr[keep_car]]?>">
		<? while(list($key,$val)=each($a_keep_car)) { ?>
		<option value='<?=$key?>' <? if($arr[keep_car]==$key) { echo"selected"; } ?> style="color:<?=$a_keep_car_color[$key]?>"><?=$val?></option>
		<? } ?>
		</select></td>
		<th></td>
		<td></td>
	  </tr>
	  <tr>
		<th>기본요금</td>
		<td colspan=3><table style="width:100%">
			<tr>
				<th>1시간</th>
				<td><input type=text name=h1_fee size=7 value='<?=$arr[h1_fee]?>' style='text-align:right'></td>
				<th>6시간</th>
				<td><input type=text name=h6_fee size=7 value='<?=$arr[h6_fee]?>' style='text-align:right'></td>
				<th>12시간</th>
				<td><input type=text name=h12_fee size=7 value='<?=$arr[h12_fee]?>' style='text-align:right'></td>
				<th>24시간</th>
				<td><input type=text name=h24_fee size=7 value='<?=$arr[h24_fee]?>' style='text-align:right'></td>
			</tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<th>일반면책</td>
		<td colspan=3>
<?
	$ique="select * from rc_insure where insure_type=1 and insure_state=1 order by insure_no";
	$isql=sql_query($ique);
	while($iarr=sql_fetch_array($isql)) {
?>
		<input type=radio name="car_insure1" value="<?=$iarr[insure_no]?>" <?if($iarr[insure_no]==$arr[car_insure1]) echo"checked"; ?>> <?=$iarr[insure_name]?> &nbsp; 
<?		
	}
?>
		</td>
	  </tr>
	  <tr>
		<th>완전면책</td>
		<td colspan=3>
<?
	$ique="select * from rc_insure where insure_type=2 and insure_state=1 order by insure_no";
	$isql=sql_query($ique);
	while($iarr=sql_fetch_array($isql)) {
?>
		<input type=radio name="car_insure2" value="<?=$iarr[insure_no]?>" <?if($iarr[insure_no]==$arr[car_insure2]) echo"checked"; ?>> <?=$iarr[insure_name]?> &nbsp; 
<?		
	}
?>
		</td>
	  </tr>
	  <tr>
		<th>옵션</td>
		<td colspan=3></td>
	  </tr>
	  <tr>
		<th>사진</td>
		<td colspan=3><?php if($arr[car_photo]) { ?><img src='../photo/<?=$arr[car_photo]?>'><br><?php } ?><input type=file name=car_photo size=15></td>
	  </tr>
	</table>

	<div class="btn_confirm01 btn_confirm">
		<input type="button" class="btn_submit" accesskey="s" value="저장하기" onclick="return form_submit(this.form)">
		<? if($car_no) { ?> <input type=button class="btn_submit" value='삭제하기' onclick='return del(<?=$car_no?>)'><? } ?>
		<a href="car_list.php">목록보기</a>
	</div>
</div>
</form>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>