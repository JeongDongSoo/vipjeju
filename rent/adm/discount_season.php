<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '할인기간관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if ( !$year || !$month ) { $year = date('Y'); $month = date('n'); }
$year2=$year;
$month2=$month+1;
if($month2>12) {
	$month2=$month2-12; $year2++;
}

$total_days = date(t, mktime(0,0,0,$month,1,$year));
$first_week = date(w, mktime(0,0,0,$month,1,$year)); 
$total_days2 = date(t, mktime(0,0,0,$month2,1,$year2));
$first_week2 = date(w, mktime(0,0,0,$month2,1,$year2)); 

if($mode=='save') {	
	$dque = "delete from rc_dc_season where rd_year='$year' and rd_month='$month'";
	if(!sql_query($dque)) { echo"시즌 삭제 오류<br>$dque"; exit; }
	$dque = "delete from rc_dc_season where rd_year='$year2' and rd_month='$month2'";
	if(!sql_query($dque)) { echo"시즌 삭제 오류<br>$dque"; exit; }

	for($j=1; $j<=$total_days; $j++) {	
		if($d_season[$j]) {
			$time=mktime(0,0,0,$month,$j,$year);
			$ique = "insert into rc_dc_season values ('$time','$year','$month','$j','$d_season[$j]','$i_season[$j]')";
			if(!sql_query($ique)) { echo"시즌 저장 오류<br>$ique"; exit; }
		}
	}
	for($j=1; $j<=$total_days2; $j++) {	
		if($d_season[$j]) {
			$time=mktime(0,0,0,$month2,$j,$year2);
			$ique = "insert into rc_dc_season values ('$time','$year2','$month2','$j','$d_season2[$j]','$i_season2[$j]')";
			if(!sql_query($ique)) { echo"시즌 저장 오류<br>$ique"; exit; }
		}
	}
	alert("저장 완료");
	goto_url($PHP_SELF);
}

$dc_name_arr=array();
$dque="select * from rc_dc_rate order by dc_sort";
$dsql=sql_query($dque);
while($darr=sql_fetch_array($dsql)) {
	$dc_name_arr[$darr[dc_no]]=$darr[dc_name];
	$dc_color_arr[$darr[dc_no]]=$darr[dc_color];
}

$que = "select * from rc_dc_season where (rd_year=$year and rd_month=$month) or (rd_year=$year2 and rd_month=$month2) order by rd_day";
$sql = sql_query($que);
while($arr = sql_fetch_array($sql)) {
	$season_arr[$arr[rd_time]] = $arr[rd_season];
	$i_season_arr[$arr[rd_time]] = $arr[rd_insure_season];
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<div class="discount_season">
<div class="tbl_basic">
<table>
<form name=modForm action='<?=$PHP_SELF?>' method=post>
<input type=hidden name=week_check>
<input type=hidden name=mode>

	<tr align=center>
		<td style='padding:0 0 10 0'>
			<a href='javascript:preMon()'><font size=3>◁</font></a>
	<select name='year' onchange=chMon()>
<?
	for($i=date(Y)-1; $i<=date(Y)+1; $i++) {
		echo("<option value='".$i."'");	if($year==$i) echo(" selected ");	echo(">".$i."년</option>");
	}
?>
	</select>
	<select name='month' onchange=chMon()>
<?
	for($i=1; $i<=12; $i++) {
		echo("<option value='".$i."'");	if($month==$i) echo(" selected "); echo(">".$i."월</option>");
	}
?>
	</select>
	<a href='javascript:nexMon()'><font size=3>▷</font></a>
	</td></tr>
</table>

<TABLE> 
<TR align=center height=30> 
	<th>일</th> 
	<th>월</th> 
	<th>화</th> 
	<th>수</th> 
	<th>목</th> 
	<th>금</th> 
	<th>토</th> 
</TR> 
<TR align=center bgcolor='#ffffff' height=30>
<?
	$col=0; 
	for($i=0; $i<$first_week; $i++) { 
		echo "<TD>&nbsp;</TD>";       
		$col++;
	}
	for($j=1; $j<=$total_days; $j++) { 
		$time=mktime(0,0,0,$month,$j,$year);
		$week=date('w',$time);

		if($week_check==1) { $season_arr[$time]=1; }
		if($week_check==2 && ($week==5 || $week==6)) { $season_arr[$time]=2; }

		echo"<TD align=right> <b>$j</b>  &nbsp;<br>
			대여 <select name='d_season[$j]' style='color:".$dc_color_arr[$season_arr[$time]]."'>
			<option value=0 style='color:black'>불가</option>";
		foreach($dc_name_arr as $key => $val) {
			echo"<option value='$key' style='color:".$dc_color_arr[$key]."' ";
			if($season_arr[$time]==$key) echo"selected";
			echo">$val</option>";
		}
		echo"</select><br>
			자차 <select name='i_season[$j]' style='color:".$dc_color_arr[$i_season_arr[$time]]."'>
			<option value=0 style='color:black'>불가</option>";
		foreach($dc_name_arr as $key => $val) {
			echo"<option value='$key' style='color:".$dc_color_arr[$key]."' ";
			if($i_season_arr[$time]==$key) echo"selected";
			echo">$val</option>";
		}
		echo"</select></TD>";
		$col++; 

		if($col==7) { 
			echo"</TR>"; 
			if($j!=$total_days) echo"<TR align=center bgcolor='#ffffff' height=30>";
			$col=0; 
		} 
	}     
	while($col > 0 && $col < 7) { 
		echo"<TD>&nbsp;</TD>"; 
		$col++; 
	} 
?> 
</tr>
</TABLE>
</div>

<div class="tbl_basic2">
<table>
	<tr align=center>
		<td style='padding:0 0 10 0'> <?=$year2?>년 <?=$month2?>월</td>
	</tr>
</table>

<TABLE> 
<TR align=center height=30> 
	<th>일</th> 
	<th>월</th> 
	<th>화</th> 
	<th>수</th> 
	<th>목</th> 
	<th>금</th> 
	<th>토</th> 
</TR> 
<TR align=center bgcolor='#ffffff' height=30>
<?
	$col=0; 
	for($i=0; $i<$first_week2; $i++) { 
		echo "<TD>&nbsp;</TD>";       
		$col++;
	}
	for($j=1; $j<=$total_days2; $j++) { 
		$time=mktime(0,0,0,$month2,$j,$year2);
		$week=date('w',$time);

		if($week_check==1) { $season_arr[$time]=1; }
		if($week_check==2 && ($week==5 || $week==6)) { $season_arr[$time]=2; }

		echo"<TD align=right> <b>$j</b>  &nbsp;<br>
			대여 <select name='d_season2[$j]' style='color:".$dc_color_arr[$season_arr[$time]]."'>
			<option value=0 style='color:black'>불가</option>";
		foreach($dc_name_arr as $key => $val) {
			echo"<option value='$key' style='color:".$dc_color_arr[$key]."' ";
			if($season_arr[$time]==$key) echo"selected";
			echo">$val</option>";
		}
		echo"</select><br>
			자차 <select name='i_season2[$j]' style='color:".$dc_color_arr[$i_season_arr[$time]]."'>
			<option value=0 style='color:black'>불가</option>";
		foreach($dc_name_arr as $key => $val) {
			echo"<option value='$key' style='color:".$dc_color_arr[$key]."' ";
			if($i_season_arr[$time]==$key) echo"selected";
			echo">$val</option>";
		}
		echo"</select></TD>";
		$col++; 

		if($col==7) { 
			echo"</TR>"; 
			if($j!=$total_days2) echo"<TR align=center bgcolor='#ffffff' height=30>";
			$col=0; 
		} 
	}     
	while($col > 0 && $col < 7) { 
		echo"<TD>&nbsp;</TD>"; 
		$col++; 
	} 
?> 
</tr>
</TABLE>
</div>

<div class="btn_confirm01 btn_confirm">
	<a href="javascript:" onclick="week(1)">주중선택</a>
	<a href="javascript:" onclick="week(2)">주말선택</a>
	<input type=button value='저장하기' onClick='res()' class="btn_submit">
</div></div>

</form>
	<script language='javascript'>
	function chMon()
	{
		document.modForm.submit();
	}
	function week(val)
	{
		document.modForm.week_check.value=val;
		document.modForm.submit();
	}
	function preMon()
	{
		y = parseInt(document.modForm.year.value);
		m = parseInt(document.modForm.month.value);
		if(document.modForm.month.value==1)
		{
			document.modForm.year.value = y-1;
			document.modForm.month.value = 12;
		}
		else
		{
			document.modForm.month.value = m-1;
		}
		document.modForm.submit();
	}
	function nexMon()
	{
		y = parseInt(document.modForm.year.value);
		m = parseInt(document.modForm.month.value);
		if(document.modForm.month.value==12)
		{
			document.modForm.year.value = y+1;
			document.modForm.month.value = 1;
		}
		else
		{
			document.modForm.month.value = m+1;
		}
		document.modForm.submit();
	}
	function res()
	{
		document.modForm.mode.value = 'save';
		document.modForm.submit();
	}
	</script>
	

<? include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>