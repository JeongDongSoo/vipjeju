<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '차종관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='save') {
	$sque="select id from rentcar_db order by id";
	$ssql=mysql_query($sque);
	while($sarr=mysql_fetch_array($ssql,MYSQL_ASSOC)) {
		$i=$sarr[id];
		$sort=${"sort_$i"};
		if($sort>0) {
			$new_car=${"new_car_$i"};
			$kind=${"kind_$i"};
			$no_charge=${"no_charge_$i"};
			$no_su_charge=${"no_su_charge_$i"}; //슈퍼면책
			$insure_limit=${"insure_limit_$i"}; //자차한도
			$tbasic=${"tbasic_$i"};	//비교기준요금
			$t24=${"t24_$i"};

			$uque="update rentcar_db set sort='$sort', new_car='$new_car', kind='$kind', no_charge='$no_charge', no_su_charge='$no_su_charge', insure_limit='$insure_limit', tbasic='$tbasic', t24='$t24' where id=$i";
			if(!mysql_query($uque)) {	echo"오류! => $uque<br>";	}
			if(${"id2_$i"}) {
				$uque="update rentcar_db set sort='$sort', new_car='$new_car', kind='$kind', no_charge='$no_charge', no_su_charge='$no_su_charge', insure_limit='$insure_limit', tbasic='$tbasic', t24='$t24' where id=".${"id2_$i"};
				if(!mysql_query($uque)) {	echo"오류! => $uque<br>";	}
			}
			if(${"id3_$i"}) {
				$uque="update rentcar_db set sort='$sort', new_car='$new_car', kind='$kind', no_charge='$no_charge', no_su_charge='$no_su_charge', insure_limit='$insure_limit', tbasic='$tbasic', t24='$t24' where id=".${"id3_$i"};
				if(!mysql_query($uque)) {	echo"오류! => $uque<br>";	}
			}
		}
	}
	location($PHP_SELF);
}

$kind_code_arr=array();
$kque="select * from rc_kind_code where kind_state=1 order by kind_sort";
$ksql=sql_query($kque);
while($karr=sql_fetch_array($ksql)) {
	$kind_code_arr[$karr[kind_no]]=$karr[kind_name];
	$kind_color_arr[$karr[kind_no]]=$karr[kind_color];
}

$insure_arr=array();
$ique="select * from rc_insure where insure_state=1 order by insure_name";
$isql=sql_query($ique);
while($iarr=sql_fetch_array($isql)) {
	$insure_arr[$iarr[insure_no]]=$iarr[insure_name];
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<script type="text/javascript">
$(document).ready(function(){
    $('table tr').click(function(){
        window.location = $(this).attr('href');
        return false;
    });
});

</script>

<div style="margin-left:10px; margin-bottom:10px; float:left; width:20%;"><a href="car_form.php"><button>차종추가</button></a></div>
<div style="margin:10px; text-align:right;">※ 차종명 색상 안내 : <? foreach($a_keep_car as $key => $val) { ?><font color=<?=$a_keep_car_color[$key]?>><?=$val?></font>, <? } ?></div>

<div class="tbl_list">
<table>
	<tr>
<form name=list_form method=get action='$PHP_SELF'>
		<th>순서</th>
		<th>차종분류</th>
		<th>차종명</th>
		<th>차종코드</th>
		<th>연료</th>
		<th>정원</th>
		<th>연식</th>
		<th>1시간요금</th>
		<th>6시간요금</th>
		<th>12시간요금</th>
		<th>24시간요금</th>
		<th>연령제한</th>
		<th>운전경력</th>	
		<th>일반면책</th>
		<th>완전면책</th>
		<th>상태</th>
	</tr>
	</form>
	<form name=list_form method=post action=<?=$PHP_SELF?>>
	<input type=hidden name=mode value='save'>
<?
	$tab_tmp=0;
	$que="select * from rc_car order by car_sort, h24_fee, car_name";
	$sql=sql_query($que);
	while($arr=sql_fetch_array($sql)) {
		$tab_tmp++;
		$keep_color=$a_keep_car_color[$arr[keep_car]];
?>
	<input type=hidden name="car_no_arr[]" value="<?=$arr[car_no]?>">
	<tr href='car_form.php?car_no=<?=$arr[car_no]?>' style="cursor:pointer" onmouseover="style.backgroundColor='#b9dcff'" onmouseout="style.backgroundColor='#ffffff'">
		<td><input type=text name=sort_<?=$arr[car_no]?> value='<?=$arr[car_sort]?>' size=3 tabindex="<?=$tab_tmp?>" style="text-align:center"></td>
		<td style="color:<?=$kind_color_arr[$arr[kind_code]]?>"><?=$kind_code_arr[$arr[kind_code]]?></td>
		<td><font color="<?=$keep_color?>"><?=$arr[car_name]?></font></td>
		<td><?=$arr[car_code]?></td>
		<td><?=$a_fuel_type[$arr[fuel_type]]?></td>
		<td><?=$arr[seater]?>인승</td>
		<td><?=$arr[made_year]?>년</td>
		<td><?=number_format($arr[h1_fee])?>원</td>
		<td><?=number_format($arr[h6_fee])?>원</td>
		<td><?=number_format($arr[h12_fee])?>원</td>
		<td><?=number_format($arr[h24_fee])?>원</td>
		<td><?=$arr[drive_age]?>세</td>
		<td><?=$arr[drive_year]?>년</td>
		<td><?=$insure_arr[$arr[car_insure1]]?></td>
		<td><?=$insure_arr[$arr[car_insure2]]?></td>
		<td><font color="<?=$keep_color?>"><?=$a_keep_car[$arr[keep_car]]?></font></td>
	</tr>
<?
	} 
?>
		</table>
	</form>
<?
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>