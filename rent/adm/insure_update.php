<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
//$g5['title'] = '자차보험관리';
//include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if(!$mode) {
	echo"잘못된 접근입니다."; exit;
}

if($mode=='insert') {
	if(!$insure_name || !$basis_fee) {
		echo"필수값을 입력하세요."; exit;
	}
	$que="insert into rc_insure values ('','$insure_name','$insure_type','$cal_type','$basis_fee','$season_fee','$break_fee','$exempt_fee','$insure_limit','$insure_company','$insure_memo','$insure_state')";
	if(!sql_query($que)) { echo"저장 오류<br>$que"; exit; }
	goto_url('insure_list.php');
}

if($mode=='update') {
	$que="update rc_insure set insure_name='$insure_name', insure_type='$insure_type', cal_type='$cal_type', basis_fee='$basis_fee', season_fee='$season_fee', break_fee='$break_fee', exempt_fee='$exempt_fee', insure_limit='$insure_limit', insure_company='$insure_company', insure_memo='$insure_memo', insure_state='$insure_state' where insure_no='$insure_no'";
	if(!sql_query($que)) { echo"저장 오류<br>$que"; exit; }
	alert('수정되었습니다.','insure_list.php');
}

if($mode=='del') {
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
?>