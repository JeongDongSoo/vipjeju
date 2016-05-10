<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '자차보험 할인율관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='update') {
	for($i=1; $i<=$dc_no_max; $i++) {
		$dc_name=${"dc_name_".$i};
		$dc_color=${"dc_color_".$i};
		$dc_sort=${"dc_sort_".$i};
		
		$uque="update rc_insure_dc_rate set dc_name='$dc_name', dc_color='$dc_color', dc_sort='$dc_sort'";
		for($j=1; $j<=$kind_max; $j++) {
			$uque.=", dc_".$j."='".${'dc_'.$i."_".$j}."'";
		}
		$uque.=" where dc_no='$i'";
		if(!sql_query($uque)) { echo"저장오류: $uque"; exit; }		
	}
	echo"<script>self.location='$PHP_SELF'</script>";
}

if($mode=='insert') {
	$ique="insert into rc_insure_dc_rate values ('$dc_no','$dc_name','$dc_color','$dc_sort'";
	for($i=1; $i<=$kind_max; $i++) {
		$ique.=",'".${'dc_'.$i}."'";
	}
	$ique.=")";
	if(!sql_query($ique)) { echo"저장오류: $ique"; exit; }
	echo"<script>self.location='$PHP_SELF'</script>";
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<div class="tbl_basic">
    <table style="width:800px">
		<tr>
			<th><b>순서</b></th>
			<th><b>code</b></th>
			<th><b>명칭</b></th>
			<th><b>색상</b></th>
<?
	$kind_max=0;
	$kind_code_arr=array();
	$kque="select * from rc_kind_code where kind_state=1 order by kind_sort";
	$ksql=sql_query($kque);
	while($karr=sql_fetch_array($ksql)) {
		$kind_code_arr[$karr[kind_no]]=$karr[kind_name];
		if($karr[kind_no]>$kind_max) $kind_max=$karr[kind_no];
?>
			<th><?=$karr[kind_name]?></th>
<?
	}
?>
		</tr>
<form name=kind_form method=post action="<?=$PHP_SELF?>">
<input type=hidden name=mode value='update'>
<input type=hidden name=kind_max value='<?=$kind_max?>'>
<?
$tab=0;
$que="select * from rc_insure_dc_rate order by dc_sort";
$sql=sql_query($que);
while($arr=sql_fetch_array($sql)) {
	$tab++;
	$dc_no=$arr[dc_no];
	if($dc_no>$dc_no_max) $dc_no_max=$dc_no;
?>
				<tr align=center>
					<td><input type=text name=dc_sort_<?=$dc_no?> value='<?=$arr[dc_sort]?>' size=2 tabindex="<?=$tab?>"></font></td>
					<td><?=$dc_no?></font></td>
					<td><input type=text name=dc_name_<?=$dc_no?> value='<?=$arr[dc_name]?>' size=10 tabindex="<?=($tab+100)?>"></td>
					<td><input type=text name=dc_color_<?=$dc_no?> value='<?=$arr[dc_color]?>' style="color:<?=$arr[dc_color]?>" size=10 tabindex="<?=($tab+200)?>"></td>
	<?	foreach($kind_code_arr as $key => $val) { ?>
					<td><input type=text name=dc_<?=$dc_no?>_<?=$key?> value='<?=$arr['dc_'.$key]?>' size=3 tabindex="<?=($tab+100*($key+2))?>">%</td>
	<?	} ?>
				</tr>
<?
}
?>
			</table>

		<div class="btn_confirm01 btn_confirm" style="width:800px">
			<input type="submit" class="btn_submit" accesskey="s" value="저장하기">
		</div>
<input type=hidden name=dc_no_max value='<?=$dc_no_max?>'>
</form>

<? $dc_no2=$dc_no+1; ?>
<form name=kind_form method=post action="<?=$PHP_SELF?>">
<input type=hidden name=mode value='insert'>
<input type=hidden name=dc_no value='<?=$dc_no2?>'>
<input type=hidden name=kind_max value='<?=$kind_max?>'>
    <table style="width:800px">
		<tr>
			<th><b>순서</b></th>
			<th><b>code</b></th>
			<th><b>명칭</b></th>
			<th><b>색상</b></th>
	<?	foreach($kind_code_arr as $key => $val) { ?>
			<th><?=$val?></th>
	<?	} ?>
		</tr>
		<tr align=center>
			<td><input type=text name=dc_sort size=2></font></td>
			<td><?=$dc_no2?></font></td>
			<td><input type=text name=dc_name size=10></td>
			<td><input type=text name=dc_color size=10></td>
	<?	foreach($kind_code_arr as $key => $val) { ?>
			<td><input type=text name=dc_<?=$key?> size=3>%</td>
	<?	} ?>
		</tr>
	</table>

		<div class="btn_confirm01 btn_confirm" style="width:800px">
			<input type="submit" class="btn_submit" value='추가등록'>
		</div>
</form>

<? include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>