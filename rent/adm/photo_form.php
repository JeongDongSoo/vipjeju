<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '차량요금관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

// firewall
//$check_url = '/rentcar/admin/fee_list';
//if (!auth_action('access', $check_url)) error('접근권한이 없습니다.');

if($mode=='insert' || $mode=='modify') {
	$gstate=1;
	$gque="select * from rc_gap where gno=$gstate";
	$garr=mysql_fetch_array(mysql_query($gque));
	$gap_name="day";

	$tover=goodFloor($t24*$garr[over]/100/100)*100;
	for($i=0; $i<count($term_arr); $i++) {
		$select_hour=$term_arr[$i];
		if($select_hour<=24) {
			//${"t".$select_hour}=${"t".$select_hour};
			${"t".$select_hour}=$t24;
		} else {
			$gap_rate=$garr[$gap_name.$select_hour%24]/100;
			$stn_pay=$t24*(goodFloor($select_hour/24)+$gap_rate);
			${"t".$select_hour}=goodFloor($stn_pay/100)*100;
		}
	}
	
	$car_color="";
	for($i=0; $i<count($a_car_color); $i++) {
		if(${"car_color_$i"}) { 
			if($car_color) { $car_color.="|"; }
			$car_color.=${"car_color_$i"}; 
		}
	}
	for($i=0; $i<20; $i++) {
		if(${"see_car_$i"} || ${"old_see_car_$i"}) {
			if($see_car) { $see_car.="|"; $see_car_name.="|"; }
			$see_car_name.=${"see_car_name_$i"};

			if(${"see_car_$i"}) {
				$see_car.=img_upload(${"see_car_$i"},"../img/see_car");
				unlink("../img/see_car/".${"old_see_car_$i"});
			} else {
				$see_car.=${"old_see_car_$i"};
			}
		}
	}

	if($filename) {
		$filename=img_upload($filename,"../img/car");
		unlink("../img/car/".$old_filename);
	} else {
		$filename=$old_filename;
	}

	$car_option_val= count($car_option) ? implode('|',$car_option) : '';
}

if($mode=='insert') {
	// firewall
	if (!auth_action('insert', $check_url)) error('접근권한이 없습니다.');

	$sque="select max(car_no) from rc_car";
	$sarr=mysql_fetch_array(mysql_query($sque));
	$car_no=$sarr[0]+1;
	/*for($k=0; $k<count($okcash_season_arr); $k++) {
	  if ($k==0) $yn_okcash = ${"yn_okcash_$k"}; else $yn_okcash = $yn_okcash . ":" . ${"yn_okcash_$k"}; 
	}*/
	$que="insert into rc_car values ('$car_no','$kind','$car_code','$name','$kia_type','$fuel_type','$corp_no','$tbasic','$t24','$tover','$filename','$insure_limit','$insure_limit2','$etc02','$etc03','$etc04','$etc05','$etc06','$car_option_val','$recom','$sunroof','$buy_sel','$drive_km','$car_color','$car_company','$person','$sort','$today','$total','$new_car','$memo','$car_year','$show_room','$see_car','$see_car_name','$no_charge','$blackbox','$spec_code','$etc08','$survey','$keep','$kml','$etc09','$etc10','$etc11','$fuel_fee','$car_num','$golf_bag','$plus_fee1','$plus_name2','$plus_fee2','$plus_name3','$plus_fee3','$plus_name4','$plus_fee4','$plus_name5','$plus_fee5','$plus_name6','$plus_fee6','$plus_name7','$plus_fee7','$plus_name8','$plus_fee8','$plus_name9','$plus_fee9','$plus_name10','$plus_fee10','$yn_okcash','$navi','$no_su_charge')";
	if(!mysql_query($que)) { echo"저장 오류<br>$que"; exit; }
	location('fee_list.php');
	exit;
}
if($mode=='modify') {
	// firewall
	if (!auth_action('modify', $check_url)) error('접근권한이 없습니다.');

	/*for($k=0; $k<count($okcash_season_arr); $k++) {
	  if ($k==0) $yn_okcash = ${"yn_okcash_$k"}; else $yn_okcash = $yn_okcash . ":" . ${"yn_okcash_$k"}; 
	}*/
	$que_str="name='$name', kind='$kind', kia_type='$kia_type', tbasic='$tbasic', sunroof='$sunroof', buy_sel='$buy_sel', insure_limit='$insure_limit', insure_limit2='$insure_limit2', recom='$recom', car_color='$car_color', car_company='$car_company', person='$person', sort='$sort', car_year='$car_year', no_charge='$no_charge', no_su_charge='$no_su_charge', t24='$t24', tover='$tover', filename='$filename', car_option='$car_option_val', memo='$memo', see_car='$see_car', see_car_name='$see_car_name', new_car='$new_car', spec_code='$spec_code', ";

	$que="update rc_car set $que_str car_code='$car_code', corp_no='$corp_no', fuel_type='$fuel_type', fuel_fee='$fuel_fee', drive_km='$drive_km', kml='$kml', keep='$keep', car_num='$car_num', golf_bag='$golf_bag' where car_no='$car_no'";
	if(!mysql_query($que)) { echo"저장 오류<br>$que"; exit; }
	
	$href_str = "&car_no=" . $car_no;
	for($i=2; $i<=$_POST['car_cnt']; $i++)
	{
		if($_POST["car_no" . $i] && ($_POST["car_no" . $i] != 'not'))
		{
			$que2="update rc_car set $que_str car_code='".${"car_code$i"}."', corp_no='".${"corp_no$i"}."', fuel_type='".${"fuel_type$i"}."', new_car='".${"new_car$i"}."', fuel_fee='".${"fuel_fee$i"}."', drive_km='".${"drive_km$i"}."', kml='".${"kml$i"}."', keep='".${"keep$i"}."', car_num='".${"car_num$i"}."', see_car='$see_car', see_car_name='$see_car_name' where car_no='".${"car_no$i"}."'";
			$href_str .= "&car_no" . $i . "=" . $_POST["car_no" . $i];
			if(!mysql_query($que2)) { echo"저장 오류<br>$que2"; exit; }
		}
		else if ($_POST["car_no" . $i] == 'not')
		{
			$i_sql = "INSERT INTO rc_car (name, kind, kia_type, tbasic, sunroof, buy_sel, insure_limit, recom, car_color, car_company, person, sort, car_year, no_charge, no_su_charge, t24, tover, filename, car_option, memo, see_car, see_car_name, new_car, spec_code, car_code, corp_no, fuel_type, fuel_fee, drive_km, kml, keep, car_num) VALUES('$name', '$kind', '$kia_type', '$tbasic', '$sunroof', '$buy_sel', '$insure_limit', '$recom', '$car_color', '$car_company', '$person', '$sort', '$car_year', '$no_charge', '$no_su_charge', '$t24', '$tover', '$filename', '$car_option_val', '$memo', '$see_car', '$see_car_name', '$new_car', '$spec_code', '".${"car_code$i"}."', '".${"corp_no$i"}."', '".${"fuel_type$i"}."', '".${"fuel_fee$i"}."', '".${"drive_km$i"}."', '".${"kml$i"}."', '".${"keep$i"}."', '".${"car_num$i"}."')";
			if(mysql_query($i_sql)) $href_str .= "&car_no" . $i . "=" . mysql_insert_id();
			else { echo "저장 오류<br><br>$i_sql"; exit; }
		}
	}
	alert('수정되었습니다.');
	location("$PHP_SELF?car_cnt=" . $_POST['car_cnt'] . $href_str); exit;
}
if($mode=='del' || $mode=='del2') {
	// firewall
	if (!auth_action('delete', $check_url)) error('접근권한이 없습니다.');

//	if($mode=='del2') { $car_no=$id2; }
	if (isset($_GET['car_no']))
	{
		$dque="delete from rc_car where car_no='" . $_GET['car_no'] . "'";
		if(!mysql_query($dque)) { echo"렌트카 삭제 오류<br>$dque"; exit; }

		$dque="delete from rentcar_insure where car_id='" . $_GET['car_no'] . "'";
		if(!mysql_query($dque)) { echo"보험료 삭제 오류<br>$dque"; exit; }
	}
	else
	{
		for ($i=1; $i<=$_GET['car_cnt']; $i++)
		{
			$id_num = ($i==1) ? $_POST['car_no'] : $_POST['car_no' . $i];
			$dque="delete from rc_car where car_no='" . $id_num . "'";
			if(!mysql_query($dque)) { echo"렌트카 삭제 오류<br>$dque"; exit; }

			$dque="delete from rentcar_insure where car_id='" . $id_num . "'";
			if(!mysql_query($dque)) { echo"보험료 삭제 오류<br>$dque"; exit; }
		}
	}

	alert('삭제되었습니다.');
	location('fee_list.php');	exit;
}

if($mode=='see_del') {
	// firewall
	if (!auth_action('delete', $check_url)) error('접근권한이 없습니다.');

	$see_car=""; $see_car_name="";
	for($i=0; $i<20; $i++) {
		if($i!=$del_no-1 && ${"old_see_car_$i"}) {
			if($see_car) { $see_car.="|"; $see_car_name.="|"; }
			$see_car.=${"old_see_car_$i"};
			$see_car_name.=${"see_car_name_$i"};
		}
	}
	$uque="update rc_car set see_car='$see_car', see_car_name='$see_car_name' where car_no='$car_no'";
	if(!mysql_query($uque)) {
		echo"오류! => $uque";
	}
}
else if ($mode == 'see_all_del')
{
	// firewall
	if (!auth_action('delete', $check_url)) error('접근권한이 없습니다.');

	// 실사진 리스트
	$s_sql = "SELECT see_car FROM rc_car WHERE car_no='{$car_no}'";
	$s_f = mysql_fetch_array(mysql_query($s_sql));

	$file_array= split('\|', $s_f[see_car]);
	// 파일 삭제 처리 
	foreach ($file_array as $v)
		unlink($_SERVER['DOCUMENT_ROOT'] . "/rentcar/img/see_car/" . $v);

	$u_sql = "UPDATE rc_car SET see_car='', see_car_name='' WHERE car_no='{$car_no}'";
	if (mysql_query($u_sql)) { location($_SERVER['PHP_SELF'] . "?car_no={$car_no}&car_cnt={$car_cnt}", "실사진이 전부 삭제되었습니다."); exit; }
	else { echo "오류!! => " . $u_sql; exit; }
}

//렌트카 요금 가져오기
$que="select * from rc_car where car_no='$car_no'";
$arr=mysql_fetch_array(mysql_query($que)); 
$car_option_arr=explode('|',$arr[car_option]);

if($car_no && !$id2 && auth_action('delete', $check_url)) {
	$del_button_str="<input type=button value='삭제하기' class=bt0 onclick='return del(\"all\")' style='color:red'>";
}

/*보험료 가져오기
$ique="select * from rentcar_insure where car_id='$car_no' order by place, season";
$isql=mysql_query($ique);
while($iarr=mysql_fetch_array($isql)) {
	for($t=1; $t<sizeof($insure_time_arr); $t++) {
		$idata[$iarr[place]][$iarr[season]][$t]=$iarr["i".$t];
	}
}*/

?>
<LINK rel=stylesheet href=../style.css type=text/css>
<SCRIPT language=JavaScript src=../script.js></script>
<script language=JavaScript>
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
	// 등록 폼
	function show_form()
	{
		var form_str = "<table border='0' cellpadding='0' cellspacing='0'><input type=hidden name='car_no<?=$_GET['car_cnt']+1?>' value='not'><tr><td style='padding:10 0 0 0'><table width=400 border=0 cellspacing=1 cellpadding=2 bgcolor=aaaaaa><tr bgcolor=ffffff><td align=center bgcolor=eeeeee>차량코드</td><td><input type=text name=car_code<?=$_GET['car_cnt']+1?> value='' size=6></td><td align=center bgcolor=eeeeee>법인</td><td><select name=corp_no<?=$_GET['car_cnt']+1?>><option value=1 selected style='color:blue'>스타렌트카</option><option value=2 style='color:green'>좋은사람들</option></select></td></tr><tr bgcolor=ffffff><td width=20% align=center bgcolor=eeeeee>연 료</td><td width=30%><select name=fuel_type<?=$_GET['car_cnt']+1?>><?php while(list($k1,$v1)=each($a_fuel_type)) { ?><option value='<?=$k1?>'><?=$v1?></option><?php } ?></selected></td><td width=20% align=center bgcolor=eeeeee>배기량</td><td width=30%><input type=text name=drive_km<?=$_GET['car_cnt']+1?> value='0' size=3>천cc</td></tr><tr bgcolor=ffffff><td align=center bgcolor=eeeeee>10% 연료비</td><td><input type=text name=fuel_fee<?=$_GET['car_cnt']+1?> value='0' size=5>원</td><td align=center bgcolor=eeeeee>보유대수</td><td><input type=text name=car_num<?=$_GET['car_cnt']+1?> value='0' size=3> 대</td></tr><tr bgcolor=ffffff><td align=center bgcolor=eeeeee>공인연비</td><td><input type=text name=kml<?=$_GET['car_cnt']+1?> value='0' size=3> km/L</td><td align=center bgcolor=eeeeee>당사보유여부</td><td><select name=keep<?=$_GET['car_cnt']+1?>><option value='1' style='color:blue'>보유</option><option value='0' selected style='color:red'>비보유</option><option value='2' style='color:green'>출시예정</option><option value='100' style='color:gray'>미등재</option></select></td></tr><tr bgcolor=dddddd align=center><td colspan=4><input type=button value='차량<?=$_GET['car_cnt']+1?> 취소' style=cursor:hand onclick='hidden_form()'></td></tr></table></td></tr></table>";
		
		document.all('fee_form').car_cnt.value = eval(document.all('fee_form').car_cnt.value) + 1;
		document.all('insert_btn').style.display = 'none';
		document.all('insert_form').innerHTML = form_str;
	}
	function hidden_form()
	{
		document.all('fee_form').car_cnt.value = document.all('fee_form').car_cnt.value - 1;
		document.all('insert_btn').style.display = 'inline';
		document.all('insert_form').innerHTML = '';
	}
</script>

<table border=0 cellspacing=0 cellpadding=2>
  <tr bgcolor=ffffff height=30>
	<td colspan=9 style='padding:5 0 0 10'><table width=600 border=0 cellspacing=0 cellpadding=0>
	  <form name=fee_form method=POST enctype='multipart/form-data' action='<?=$PHP_SELF?>'>
	  <input type=hidden name=mode value='<?if($car_no) { echo"modify"; } else { echo"insert"; }?>'>
	  <input type=hidden name='car_cnt' value=<?=$_GET['car_cnt']?>>
	  <input type=hidden name=car_no value=<?=$car_no?>>
	  <input type=hidden name=del_no>
	  <tr>
		<td><font size=3 color=0066CC><b>◈ 차량관리</b></font></td>			
		<!-- <td><table width=300 border=0 cellspacing=1 cellpadding=1 bgcolor=cccccc>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=dddddd>제원차량선택</td>
			<td>&nbsp;<input type=text name=spec_code value="<?=$arr[spec_code]?>" size=3>
			<input type=text name=car_name value="" size=20>
			<input type=button value="검색" class=bt0 onclick="spec_search()"></td>
		  </tr>
		</table></td> -->
	  </tr>
	</table></td>
  </tr>
  <tr>
    <td valign='top' style='padding-top:25px;'><table border=0 cellspacing=0 cellpadding=0>
	  <tr>
		<td width=30%><table border=0 cellspacing=0 cellpadding=0>
		  <tr>
			<td style='padding:0 0 0 0'><table width=400 border=0 cellspacing=1 cellpadding=2 bgcolor=aaaaaa>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>차량코드</td>
				<td><input type=text name=car_code value='<?=$arr[car_code]?>' size=6></td>
				<td align=center bgcolor=eeeeee>법인</td>
				<td><select name=corp_no>
				<option value=1 <?php if($arr[corp_no]==1) { ?>selected<?php } ?> style='color:blue'>스타렌트카</option>
				<option value=2 <?php if($arr[corp_no]==2) { ?>selected<?php } ?> style='color:green'>좋은사람들</option>
				</select></td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td width=20% align=center bgcolor=eeeeee>연 료</td>
				<td width=30%><select name=fuel_type>
				<?php reset($a_fuel_type);
				  while(list($k1,$v1)=each($a_fuel_type)) { ?>
					<option value='<?=$k1?>' <?php if($k1==$arr[fuel_type]) { ?>selected <?php } ?>><?=$v1?></option>
				<?php } ?>
				</select></td>
				<td width=20% align=center bgcolor=eeeeee>배기량</td>
				<td width=30%><input type=text name=drive_km value='<?=$arr[drive_km]?>' size=3>천cc</td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>10% 연료비</td>
				<td><input type=text name=fuel_fee value='<?=$arr[fuel_fee]?>' size=5>원</td>
				<td align=center bgcolor=eeeeee>보유대수</td>
				<td><input type=text name=car_num value='<?=$arr[car_num]?>' size=3> 대</td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>공인연비</td>
				<td><input type=text name=kml value='<?=$arr[kml]?>' size=3> km/L</td>
				<td align=center bgcolor=eeeeee>당사보유여부</td>
				<td><select name=keep>
				<option value='1' <?php if($arr[keep]==1) { ?>selected<?php } ?> style='color:blue'>보유</option>
				<option value='0' <?php if($arr[keep]==0) { ?>selected<?php } ?> style='color:red'>비보유</option>
				<option value='2' <?php if($arr[keep]==2) { ?>selected<?php } ?> style='color:green'>출시예정</option>
				<option value='100' <?php if($arr[keep]==100) { ?>selected <?php } ?> style='color:gray'>미등재</option>
				</select></td>
			  </tr>
			  <?php	if($car_no) { ?>
			  <tr bgcolor=dddddd align=center>
				<td colspan=4><input type=button value='차량1 삭제' style=cursor:hand onclick='return del(<?=$car_no?>)'></td>
			  </tr>
			  <?php	} ?>
			</table></td>
		  </tr>
		</table></td>
	  </tr>
	  <?php for($nn=2; $nn<=$_GET['car_cnt']; $nn++) {
		$id2=${"car_no$nn"};
		if($id2) {
			$que2="select * from rc_car where car_no='$id2'";
			$arr2=mysql_fetch_array(mysql_query($que2));
	  ?>
	  <input type=hidden name='car_no<?=$nn?>' value='<?=$id2?>'>
	  <tr>
		<td style='padding:10 0 0 0'><table width=400 border=0 cellspacing=1 cellpadding=2 bgcolor=aaaaaa>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>차량코드</td>
			<td><input type=text name=car_code<?=$nn?> value='<?=$arr2[car_code]?>' size=6></td>
			<td align=center bgcolor=eeeeee>법인</td>
			<td><select name=corp_no<?=$nn?>>
			<option value=1 <?php if($arr2[corp_no]==1) { ?>selected<?php } ?> style='color:blue'>스타렌트카</option>
			<option value=2 <?php if($arr2[corp_no]==2) { ?>selected<?php } ?> style='color:green'>좋은사람들</option>
			</select></td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td width=20% align=center bgcolor=eeeeee>연 료</td>
			<td width=30%><select name=fuel_type<?=$nn?>>
			<?php reset($a_fuel_type);
			while(list($k1,$v1)=each($a_fuel_type)) { ?>
			<option value='<?=$k1?>' <?php if($k1==$arr2[fuel_type]) { ?>selected<?php } ?>><?=$v1?></option>
			<?php } ?>
			</select></td>
			<td width=20% align=center bgcolor=eeeeee>배기량</td>
			<td width=30%><input type=text name=drive_km<?=$nn?> value='<?=$arr2[drive_km]?>' size=3>천cc</td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>10% 연료비</td>
			<td><input type=text name=fuel_fee<?=$nn?> value='<?=$arr2[fuel_fee]?>' size=5>원</td>
			<td align=center bgcolor=eeeeee>보유대수</td>
			<td><input type=text name=car_num<?=$nn?> value='<?=$arr2[car_num]?>' size=3> 대</td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>공인연비</td>
			<td><input type=text name=kml<?=$nn?> value='<?=$arr2[kml]?>' size=3> km/L</td>
			<td align=center bgcolor=eeeeee>당사보유여부</td>
			<td><select name=keep<?=$nn?>>
			<option value='1' <?php if($arr2[keep]==1) { ?>selected<?php } ?> style='color:blue'>보유</option>
			<option value='0' <?php if($arr2[keep]==0) { ?>selected<?php } ?> style='color:red'>비보유</option>
			<option value='2' <?php if($arr2[keep]==2) { ?>selected<?php } ?> style='color:green'>출시예정</option>
			<option value='100' <?php if($arr2[keep]==100) { ?>selected<?php } ?> style='color:gray'>미등재</option>
			</select></td>
		  </tr>
		  <tr bgcolor=dddddd align=center>
			<td colspan=4><input type=button value='차량<?=$nn?> 삭제' style=cursor:hand onclick='return del(<?=$id2?>)'></td>
		  </tr>
		</table></td>
	  </tr>
	  <?php	}
		}
	  ?>
	  <tr>
		<td id='insert_form'></td>
	  </tr>
	  <tr>
		<td style='padding:10 0 0 0'><table width=400 border=0 cellspacing=1 cellpadding=2 bgcolor=aaaaaa>
		  <tr bgcolor=ffffff>
			<td width=20% align=center bgcolor=eeeeee>정렬순서</td>
			<td width=30%><input type=text name=sort value='<?=$arr[sort]?>' size=3></td>
			<td width=20% align=center bgcolor=eeeeee>메인 출력</td>
			<td width=30%><input type=text name=new_car value='<?=$arr[new_car]?>' size=3> 0 은 미출력</td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>차 명</td>
			<td colspan=3><input type=text name=name value='<?=$arr[name]?>' size=50></td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>차 종</td>
			<td><select name=kind>
			<?php
			$kque="select * from rc_kind_code where state=1 order by sort, kno";
			$ksql=mysql_query($kque);
			while($karr=mysql_fetch_array($ksql)) {
				echo"<option value=$karr[kno]"; if($karr[kno]==$arr[kind]) { echo" selected"; } echo">$karr[kname]</option>";
			}
			?>
			</select></td>
			<td align=center bgcolor=eeeeee>기 어</td>
			<td><select name=kia_type>
			<?php
			reset($a_kia_type);
			while(list($k1,$v1)=each($a_kia_type)) { 
			echo"<option value='$k1'"; if($k1==$arr[kia_type]){ echo" selected"; } echo">$v1</option>";
			}
			?>
			</select></td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>구매가격</td>
			<td><input type=text name=buy_sel value='<?=$arr[buy_sel]?>' size=6>만원</td>
			<td align=center bgcolor=eeeeee>제조회사</td>
			<td><input type=text name=car_company value='<?=$arr[car_company]?>' size=15></td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>인승</td>
			<td><input type=text name=person value='<?=$arr[person]?>' size=2>인승</td>
			<td align=center bgcolor=eeeeee>연식</td>
			<td><input type=text name=car_year value='<?=$arr[car_year]?>' size=4>년식</td>
		  </tr>
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>비교기준요금</td>
			<td><input type=text name=tbasic size=6 value='<?=$arr[tbasic]?>' style='text-align:right'>원</td>
			<td align=center bgcolor=eeeeee>썬루프</td>
			<td><select name=sunroof>
			<option value=0>미장착</option>
			<option value=1 <?php if($arr[sunroof]==1) { ?>selected<?php } ?>>장착</option>
			</select></td>
		  </tr> 
		  <tr bgcolor=ffffff>
			<td align=center bgcolor=eeeeee>골프백</td>
			<td colspan='3'><input type=text name="golf_bag" size=6 value='<?=$arr[golf_bag]?>' style='text-align:right'>개</td>
		  </tr> 
		</table></td>
	  </tr>
	  <tr>
		<td style='padding:5 0 0 0'><table width=400 border=0 cellspacing=0 cellpadding=0>
		  <tr bgcolor=ffffff>
			<td><table width=200 border=0 cellspacing=1 cellpadding=2 bgcolor=aaaaaa>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>24시간요금</td>
				<td>&nbsp;<input type=text name=t24 size=6 value='<?=$arr[t24]?>' style='text-align:right'>원</td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>자차한도</td>
				<td>&nbsp;<input type=text name=insure_limit size=4 value='<?=$arr[insure_limit]?>' style=text-align:right>만원</td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>자차한도(24세 이상)</td>
				<td>&nbsp;<input type=text name=insure_limit2 size=4 value='<?=$arr[insure_limit2]?>' style=text-align:right>만원</td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>일반 면책금</td>
				<td>&nbsp;<input type=text name=no_charge size=4 value='<?=$arr[no_charge]?>' style=text-align:right>만원</td>
			  </tr>
			  <tr bgcolor=ffffff>
				<td align=center bgcolor=eeeeee>슈퍼 면책금</td>
				<td>&nbsp;<input type=text name=no_su_charge size=4 value='<?=$arr[no_su_charge]?>' style=text-align:right>만원</td>
			  </tr>
			</table></td>
			<td><?php if($arr[filename]) { ?><img src='../img/car/<?=$arr[filename]?>'><br><input type=hidden name=old_filename value='<?=$arr[filename]?>'><?php } ?><input type=file name=filename size=15></td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td style='padding:5 0 0 0'><table width=400 border=0 cellspacing=1 cellpadding=2 bgcolor=cccccc>
		  <tr bgcolor=ffffff align=center>
			<td width=5% bgcolor=dddddd><b>색<br>상</b></td>
			<td><table width=100% border=0 cellspacing=0 cellpadding=0>
			  <tr>
			  <?php	for($i=0; $i<count($a_car_color); $i++) {
				$font_color="000000";
				if($i==1 || $i==3 || $i==6 || $i==8 || $i==10 || $i==13) { $font_color="ffffff"; }
				if($i>0 && $i%5==0) { echo"</tr><tr>"; }
				echo"<td "; if($i%5!=3) { echo"width=19%"; } echo" bgcolor=$a_car_color[$i]><input type=checkbox name=car_color_$i value='$a_car_color[$i]'";
				if(eregi($a_car_color[$i],$arr[car_color])) { echo" checked"; }
				echo"><font color=$font_color>$a_car_color_name[$i]</font></b></td>";
			  } ?>
			  </tr>
			</table></td>
		  </tr>
		</table></td>
	  </tr>
	</table></td>
	<td valign=top style='padding:0 0 0 10'><table border=0 cellspacing=1 cellpadding=3 bgcolor=dddddd>
	  <tr bgcolor=dddddd>
		<td colspan=4 align=center><b>실사진</b>&nbsp;<input type=button value='전체 삭제' onclick="see_all_del()"></td>
	  </tr>
	  <tr bgcolor=ffffff>
	  <?php
		$see_car_arr=explode('|',$arr[see_car]);
		$see_car_name_arr=explode('|',$arr[see_car_name]);
		$see_car_max=10;
		if($see_car_max<count($see_car_arr)) { $see_car_max=count($see_car_arr); }
		for($i=0; $i<$see_car_max; $i++) {
			if($i>0 && $i%4==0) {
				echo"</tr><tr bgcolor=ffffff>";
			}
			echo "<td>".($i+1).". <input type=text name=see_car_name_$i value='$see_car_name_arr[$i]' size=30><br>";
			if($see_car_arr[$i]) {
				echo"<img src='../img/see_car/$see_car_arr[$i]' width=260><br>
					<input type=hidden name=old_see_car_$i value='$see_car_arr[$i]'>
					<input type=button value='삭제' onclick=\"see_del('".($i+1)."')\">";
			}
			echo"<input type=file name=see_car_$i size=20></td>";
		}
	  ?>
	  </tr>
	</table></td>
  </tr>
  <tr height=30 align=center>
	<td><input type=submit value='저장하기' class=bt0>&nbsp;<input type=button value='목록보기' class=bt0 onclick="location='fee_list.php'">&nbsp;<input type=button value='추가하기' id='insert_btn' class=bt0 onclick='show_form();'>&nbsp;<?=$del_button_str?></td>
  </tr>
</table>
</form>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>