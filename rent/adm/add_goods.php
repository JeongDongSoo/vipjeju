<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '부가용품관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='update') {
	for($i=1; $i<=$add_no_max; $i++) {
		$add_name=${"add_name_".$i};
		$add_fee1=${"add_fee1_".$i};
		$add_fee2=${"add_fee2_".$i};
		$add_state=${"add_state_".$i};

		$uque="update rc_add_goods set add_name='$add_name', add_fee1='$add_fee1', add_fee2='$add_fee2', add_state='$add_state' where add_no='$i'";
		if(!sql_query($uque)) { echo"저장오류: $uque"; exit; }		
	}
	echo"<script>self.location='$PHP_SELF'</script>";
}

if($mode=='insert') {
	$ique="insert into rc_add_goods values ('$add_no','$add_name','$add_fee1','$add_fee2','$add_state')";
	if(!sql_query($ique)) { echo"저장오류: $ique"; exit; }

	echo"<script>self.location='$PHP_SELF'</script>";
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<div class="tbl_basic">
    <table style="width:500px">
		<tr>
			<th width=10%><b>No.</b></th>
			<th><b>부가용품</b></th>
			<th><b>자차미가입</b></th>
			<th><b>자차가입</b></th>
			<th width=25%><b>사용여부</b></th>
		</tr>
<form name=add_form method=post action="<?=$PHP_SELF?>">
<input type=hidden name=mode value='update'>
<?
$tab=0;
$que="select * from rc_add_goods order by add_no";
$sql=sql_query($que);
while($arr=sql_fetch_array($sql)) {
	$tab++;
	$add_no=$arr[add_no];
?>
				<tr align=center>
					<td><?=$add_no?></font></td>
					<td><input type=text name=add_name_<?=$add_no?> value='<?=$arr[add_name]?>' size=12></td>
					<td><input type=text name=add_fee1_<?=$add_no?> value='<?=$arr[add_fee1]?>' size=6>원</td>
					<td><input type=text name=add_fee2_<?=$add_no?> value='<?=$arr[add_fee2]?>' size=6>원</td>
					<td><select name=add_state_<?=$add_no?> style='color:<?=$a_use_color[$arr[add_state]]?>'>
						<option value=1 <? if($arr[add_state]==1) { echo" selected"; } ?> style=color:blue>사용함</option>
						<option value=0 <? if($arr[add_state]==0) { echo" selected"; } ?> style=color:red>사용안함</option></td>
				</tr>
<?
}
?>
			</table>

		<div class="btn_confirm01 btn_confirm" style="width:400px">
			<input type="submit" class="btn_submit" accesskey="s" value="저장하기">
		</div>
<input type=hidden name=add_no_max value='<?=$add_no?>'>
</form>

<? $add_no2=$add_no+1; ?>
<form name=add_form method=post action="<?=$PHP_SELF?>">
<input type=hidden name=mode value='insert'>
<input type=hidden name=add_no value='<?=$add_no2?>'>
	<table style="width:500px">
		<tr>
			<th width=10%><b>No.</b></th>
			<th><b>부가용품</b></th>
			<th><b>자차미가입</b></th>
			<th><b>자차가입</b></th>
			<th width=25%><b>사용여부</b></th>
		</tr>
		<tr align=center>
			<td><?=$add_no2?></font></td>
			<td><input type=text name=add_name value='<?=$arr[add_name]?>' size=12></td>
			<td><input type=text name=add_fee1 value='<?=$arr[add_fee1]?>' size=6>원</td>
			<td><input type=text name=add_fee2 value='<?=$arr[add_fee2]?>' size=6>원</td>
			<td><select name=add_state>
				<option value=1<? if($arr[add_state]==1) { echo" selected"; } ?> style="color:blue">사용함</option>
				<option value=0<? if($arr[add_state]==0) { echo" selected"; } ?> style="color:red">사용안함</option></td>
		</tr>
	</table>

		<div class="btn_confirm01 btn_confirm" style="width:400px">
			<input type="submit" class="btn_submit" value='추가등록'>
		</div>
</form>

<? include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>