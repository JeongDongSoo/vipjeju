<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '배반차요금설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='insert') {
	$ique="insert into rc_out_fee values ('$out_no','$out_name','$out_fee1','$out_fee2','$out_sort','$out_state')";
	if(!sql_query($ique)) { echo"저장오류: $ique"; exit; }

	echo"<script>self.location='$PHP_SELF'</script>";
}

if($mode=='update') {
	for($i=1; $i<=$out_no_max; $i++) {
		$out_name=${"out_name_".$i};
		$out_fee1=${"out_fee1_".$i};
		$out_fee2=${"out_fee2_".$i};
		$out_sort=${"out_sort_".$i};
		$out_state=${"out_state_".$i};

		$uque="update rc_out_fee set out_name='$out_name', out_fee1='$out_fee1', out_fee2='$out_fee2', out_sort='$out_sort', out_state='$out_state' where out_no='$i'";
		if(!sql_query($uque)) { echo"저장오류: $uque"; exit; }		
	}
	echo"<script>self.location='$PHP_SELF'</script>";
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<div class="tbl_basic">
    <table style="width:600px">
		<tr>
			<th width=15%><b>정렬</b></th>
			<th width=15%><b>code</b></th>
			<th><b>장소</b></th>
			<th><b>자차미가입</b></th>
			<th><b>자차가입</b></th>
			<th width=20%><b>사용여부</b></th>
		</tr>
<form name=out_form method=post action="<?=$_SERVER[PHP_SELF]?>">
<input type=hidden name=mode value='update'>
<?
$tab=0;
$que="select * from rc_out_fee order by out_sort";
$sql=sql_query($que);
while($arr=sql_fetch_array($sql)) {
	$tab++;
	$out_no=$arr[out_no];
	echo"
				<tr align=center>
					<td><input type=text name=out_sort_$out_no value='".$arr[out_sort]."' size=2 tabindex=".$tab."></font></td>
					<td>$out_no</font></td>
					<td><input type=text name=out_name_$out_no value='".$arr[out_name]."' size=20 tabindex=".($tab+100)."></td>
					<td><input type=text name=out_fee1_$out_no value='".$arr[out_fee1]."' size=8 tabindex=".($tab+200)."></td>
					<td><input type=text name=out_fee2_$out_no value='".$arr[out_fee2]."' size=8 tabindex=".($tab+300)."></td>
					<td><select name=out_state_$out_no tabindex=".($tab+300).">
						<option value=1"; if($arr[out_state]==1) { echo" selected"; } echo" style=color:blue>사용함</option>
						<option value=0"; if($arr[out_state]==0) { echo" selected"; } echo" style=color:red>사용안함</option></td>
				</tr>";
}
?>
			</table>

		<div class="btn_confirm01 btn_confirm" style="width:600px; padding:10px;">
			<input type="submit" class="btn_submit" accesskey="s" value="저장하기">
		</div>
<input type=hidden name=out_no_max value='<?=$out_no?>'>
</form>

<? $new_out_no=$out_no+1; ?>
<form name=out_form method=post action="<?=$_SERVER[PHP_SELF]?>">
<input type=hidden name=mode value='insert'>
<input type=hidden name=out_no value='<?=$new_out_no?>'>
	<table style="width:600px">
		<tr>
			<th width=15%><b>정렬</b></th>
			<th width=15%><b>code</b></th>
			<th><b>장소</b></th>
			<th><b>자차미가입</b></th>
			<th><b>자차가입</b></th>
			<th width=20%><b>사용여부</b></th>
		</tr>
		<tr align=center>
			<td><input type=text name=out_sort value='<?=$arr[out_sort]?>' size=2></font></td>
			<td><?=$out_no2?></font></td>
			<td><input type=text name=out_name value='<?=$arr[out_name]?>' size=20></td>
			<td><input type=text name=out_fee1 value='<?=$arr[out_fee1]?>' size=8></td>
			<td><input type=text name=out_fee2 value='<?=$arr[out_fee2]?>' size=8></td>
			<td><select name=out_state>
				<option value=1<? if($arr[out_state]==1) { echo" selected"; } ?> style="color:blue">사용함</option>
				<option value=0<? if($arr[out_state]==0) { echo" selected"; } ?> style="color:red">사용안함</option></td>
			<!-- <td><input type=text name=add_dc_rate value='$arr[add_dc_rate]' size=2>%</td> -->
		</tr>
	</table>

		<div class="btn_confirm01 btn_confirm" style="width:600px; padding:10px;">
			<input type="submit" class="btn_submit" value='추가등록'>
		</div>
</form>

<? include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>