<?
include "../inc/config.php";
include "../../include/common.php";

if(!$mode) {
	echo"잘못된 접근입니다."; exit;
}

if ($mode=='update') {
	if(!$rsv_no || !$car_no || !$car_cnt || !$cus_name || !$cus_phone) {
		echo"필수값이 없습니다. 관리자에게 문의하세요"; exit;
	}
	$s_time=mktime($s_hour,$s_min,0,substr($s_date,5,2),substr($s_date,8,2),substr($s_date,0,4));
	$e_time=mktime($e_hour,$e_min,0,substr($e_date,5,2),substr($e_date,8,2),substr($e_date,0,4));

	$car_fee=str_replace(',','',$car_fee);
	$out_fee=str_replace(',','',$out_fee);
	$insure_fee=str_replace(',','',$insure_fee);
	$add_goods_fee=str_replace(',','',$add_goods_fee);
	$total_fee=str_replace(',','',$total_fee);
	$m_time=time();
	$m_staff=$member['mb_name'];

	$que = "update rc_reserve set cus_name='$cus_name', cus_email='$cus_email', cus_phone='$cus_phone', comment='$comment', s_date='$s_time', e_date='$e_time', car_no='$car_no', car_name='$car_name', car_cnt='$car_cnt', s_place='$s_place', e_place='$e_place', rsv_insure='$rsv_insure', car_fee='$car_fee', out_fee='$out_fee', insure_fee='$insure_fee', add_goods_fee='$add_goods_fee', total_fee='$total_fee', rsv_state='$rsv_state', rsv_memo='$rsv_memo', m_staff='$m_staff', m_time='$m_time' where rsv_no='$rsv_no'";
	if(!sql_query($que)) {
		alert("예약 전송 오류! 관리자에게 문의하세요."); 
		echo"<sripct>history.back()</script>";
		exit; 
	}
	alert("저장되었습니다.");
	goto_url('reserve_form.php?rsv_no=$rsv_no');
	exit;
}
?>