<?
if(!$mode) {
	echo"잘못된 접근입니다."; exit;
}

if ($mode=='insert') {
	include "./inc/config.php";
	include "../include/common.php";

	if(!$cus_name || !$cus_email1 || !$cus_email2 || !$cus_phone2 || !$cus_phone3 || !$car_no || !$car_cnt) {
		echo"필수값이 없습니다. 관리자에게 문의하세요"; exit;
	}
	$cus_email=$cus_email1."@".$cus_email2;
	$cus_phone=$cus_phone1."-".$cus_phone2."-".$cus_phone3;

	$s_time=mktime($s_hour,$s_min,0,substr($s_date,5,2),substr($s_date,8,2),substr($s_date,0,4));
	$e_time=mktime($e_hour,$e_min,0,substr($e_date,5,2),substr($e_date,8,2),substr($e_date,0,4));

	$car_fee=str_replace(',','',$car_fee);
	$out_fee=str_replace(',','',$out_fee);
	$insure_fee=str_replace(',','',$insure_fee);
	$add_goods_fee=str_replace(',','',$add_goods_fee);
	$total_fee=str_replace(',','',$total_fee);
	$w_time=time();
	
	//30초 이내 중복 예약 차단
	$chk_time=time()-30;
	$cque="select rsv_no from rc_reserve where cus_name='$cus_name' and cus_phone='$cus_phone' and s_time='$s_time' and e_time='$e_time' and car_no='$car_no' and w_time>='$chk_time'";
	$carr=sql_fetch($cque);
	if($carr[rsv_no]) {
		alert("중복 예약 차단!! 관리자에게 문의하세요."); 
		echo"<sripct>history.back()</script>";
		exit; 
	}

	$reserve_no=$cus_phone2.$cus_phone3-1;
	do {
		$reserve_no++;
		$rque="select rsv_no from rc_reserve where reserve_no='$reserve_no'";
		$rarr=sql_fetch_array(sql_query($rque));
	} while($rarr[rsv_no]);
	
	$aque="select * from rc_add_goods where add_state=1 order by add_no";
	$asql=sql_query($aque);
	while($aarr=sql_fetch_array($asql)) {
		$add_goods_val=${"add_goods_".$aarr[add_no]};
		if($insure_val) $goods_fee=$aarr[add_fee2];
		else  $goods_fee=$aarr[add_fee1];
		if($add_goods_val>0) {
			$gque="insert into rc_rsv_add_goods values ('','$reserve_no','$aarr[add_no]','$add_goods_val','$goods_fee')";
			if(!sql_query($gque)) {
				alert("예약 전송 오류! 관리자에게 문의하세요."); 
				echo"<sripct>history.back()</script>";
				exit; 
			}
		}
	}

	$que = "insert into rc_reserve values ('','$reserve_no','$cus_name','$cus_email','$cus_phone','$comment','$s_time','$e_time','$car_no','$car_name','$car_cnt','$s_place','$e_place','$rsv_insure','$car_fee','$out_fee','$insure_fee','$add_goods_fee','$total_fee','1','$rsv_memo','$w_time','','')";
	if(!sql_query($que)) {
		alert("예약 전송 오류! 관리자에게 문의하세요."); 
		echo"<sripct>history.back()</script>";
		exit; 
	}

	goto_url("car_result.php?reserve_no=$reserve_no&cus_name=$cus_name");
	//alert("예약이 전송되었습니다.","/");
	exit;
}
?>