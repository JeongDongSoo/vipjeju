<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '차종분류관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='update') {
	for($i=1; $i<=$kind_no_max; $i++) {
		$kind_name=${"kind_name_".$i};
		$kind_color=${"kind_color_".$i};
		$kind_sort=${"kind_sort_".$i};
		$kind_state=${"kind_state_".$i};

		$uque="update rc_kind_code set kind_name='$kind_name', kind_color='$kind_color', kind_sort='$kind_sort', kind_state='$kind_state' where kind_no='$i'";
		if(!sql_query($uque)) { echo"저장오류: $uque"; exit; }		
	}
	echo"<script>self.location='$PHP_SELF'</script>";
}

if($mode=='insert') {
	$ique="insert into rc_kind_code values ('$kind_no','$kind_name','$kind_color','$kind_sort','$kind_state')";
	if(!sql_query($ique)) { echo"저장오류: $ique"; exit; }

	$aque="ALTER TABLE rc_dc_rate ADD dc_".$kind_no." TINYINT(2) NOT NULL DEFAULT '0'";
	if(!sql_query($aque)) { echo"저장오류: $aque"; exit; }

	$aque="ALTER TABLE rc_insure_dc_rate ADD dc_".$kind_no." TINYINT(2) NOT NULL DEFAULT '0'";
	if(!sql_query($aque)) { echo"저장오류: $aque"; exit; }

	echo"<script>self.location='$PHP_SELF'</script>";
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<div class="tbl_basic">
    <table style="width:400px">
		<tr>
			<th width=15%><b>순서</b></th>
			<th width=15%><b>code</b></th>
			<th><b>명칭</b></th>
			<th><b>색상</b></th>
			<th width=30%><b>사용여부</b></th>
		</tr>
<form name=kind_form method=post action="kind_code.php">
<input type=hidden name=mode value='update'>
<?
$tab=0;
$que="select * from rc_kind_code order by kind_sort";
$sql=sql_query($que);
while($arr=sql_fetch_array($sql)) {
	$tab++;
	$kind_no=$arr[kind_no];
	echo"
				<tr align=center>
					<td><input type=text name=kind_sort_$kind_no value='".$arr[kind_sort]."' size=2 tabindex=".$tab."></font></td>
					<td>$kind_no</font></td>
					<td><input type=text name=kind_name_$kind_no value='".$arr[kind_name]."' size=10 tabindex=".($tab+100)."></td>
					<td><input type=text name=kind_color_$kind_no value='".$arr[kind_color]."' size=10 tabindex=".($tab+200)."></td>
					<td><select name=kind_state_$kind_no tabindex=".($tab+300).">
						<option value=1"; if($arr[kind_state]==1) { echo" selected"; } echo" style=color:blue>사용함</option>
						<option value=0"; if($arr[kind_state]==0) { echo" selected"; } echo" style=color:red>사용안함</option></td>
				</tr>";
}
?>
			</table>

		<div class="btn_confirm01 btn_confirm" style="width:400px">
			<input type="submit" class="btn_submit" accesskey="s" value="저장하기">
		</div>
<input type=hidden name=kind_no_max value='<?=$kind_no?>'>
</form>

<? $kind_no2=$kind_no+1; ?>
<form name=kind_form method=post action="kind_code.php">
<input type=hidden name=mode value='insert'>
<input type=hidden name=kind_no value='<?=$kind_no2?>'>
	<table style="width:400px">
		<tr>
			<th width=15%><b>순서</b></th>
			<th width=15%><b>code</b></th>
			<th><b>명칭</b></th>
			<th><b>색상</b></th>
			<th width=30%><b>사용여부</b></th>
		</tr>
		<tr align=center>
			<td><input type=text name=kind_sort value='<?=$arr[kind_sort]?>' size=2></font></td>
			<td><?=$kind_no2?></font></td>
			<td><input type=text name=kind_name value='<?=$arr[kind_name]?>' size=10></td>
			<td><input type=text name=kind_color value='<?=$arr[kind_color]?>' size=10></td>
			<td><select name=kind_state>
				<option value=1<? if($arr[kind_state]==1) { echo" selected"; } ?> style="color:blue">사용함</option>
				<option value=0<? if($arr[kind_state]==0) { echo" selected"; } ?> style="color:red">사용안함</option></td>
			<!-- <td><input type=text name=add_dc_rate value='$arr[add_dc_rate]' size=2>%</td> -->
		</tr>
	</table>

		<div class="btn_confirm01 btn_confirm" style="width:400px">
			<input type="submit" class="btn_submit" value='추가등록'>
		</div>
</form>

<? include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>