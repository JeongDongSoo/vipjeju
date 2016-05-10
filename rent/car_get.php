<?
if ($mode=="car_get" && $kind_code) {
	include "../include/common.php";
	include "./inc/config.php";

	$ajax_json="";
	$que = "select * from rc_car where kind_code='$kind_code' order by car_sort, car_no";
	$sql = sql_query($que);
	while($arr = sql_fetch_array($sql)) {
		if($ajax_json) $ajax_json.=",";
		$ajax_json .= "{\"car_no\":\"".$arr[car_no]."\"";
		$ajax_json .= ",\"car_name\":\"".$arr[car_name]."\"";
		$ajax_json .= ",\"car_gear\":\"".$a_gear_type[$arr[gear_type]]."\"";
		$ajax_json .= "}";
	}

	header("Content-type: text/json; charset=UTF-8");
	echo "[".$ajax_json."]";
	exit;
}

if ($mode=="car_fee_cal" && $car_no) {
	include "../include/common.php";
	include "./inc/config.php";
	include "./inc/function.php";
	
	$que="select * from rc_car where car_no='$car_no'";
	$arr=sql_fetch($que);

	$s_time=mktime($s_hour,$s_min,0,substr($s_date,5,2),substr($s_date,8,2),substr($s_date,0,4));
	$e_time=mktime($e_hour,$e_min,0,substr($e_date,5,2),substr($e_date,8,2),substr($e_date,0,4));

	$car_no_arr=array($car_no);
	$car_fee_arr=car_fee_cal($s_time,$e_time,$car_no_arr,$rsv_insure);
	if($car_fee_arr==false) {
		$error_msg=1;
	}
	$car_fee=$car_fee_arr[2][$car_no]*$car_cnt;
	$insure_fee=$car_fee_arr[3][$car_no]*$car_cnt;

	$oque="select * from rc_out_fee where out_state=1 order by out_sort, out_no";
	$osql=sql_query($oque);
	while($oarr=sql_fetch_array($osql)) {
		if($rsv_insure>0) {
			$a_place_fee[$oarr[out_no]]=$oarr[out_fee2];
		} else {
			$a_place_fee[$oarr[out_no]]=$oarr[out_fee1];
		}
	}
	$out_fee=($a_place_fee[$s_place]+$a_place_fee[$e_place])*$car_cnt;
	
	$add_goods_fee=0;
	$aque="select * from rc_add_goods where add_state=1 order by add_no";
	$asql=sql_query($aque);
	while($aarr=sql_fetch_array($asql)) {
		if($rsv_insure>0) $add_fee=$aarr[add_fee2];
		else $add_fee=$aarr[add_fee1];
		$add_goods_fee+=$add_fee*${"add_goods_".$aarr[add_no]};
	}

	$total_fee=$car_fee+$insure_fee+$out_fee+$add_goods_fee;

	header('cache-control: no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');
	header("Content-type: text/json; charset=UTF-8");

	$ajax_json = "{\"car_photo\":\"".$arr[car_photo]."\"";
	$ajax_json .= ",\"car_name\":\"".$arr[car_name]."\"";
	$ajax_json .= ",\"car_fee\":\"".number_format($car_fee)."\"";
	$ajax_json .= ",\"insure_fee\":\"".number_format($insure_fee)."\"";
	$ajax_json .= ",\"out_fee\":\"".number_format($out_fee)."\"";
	$ajax_json .= ",\"add_goods_fee\":\"".number_format($add_goods_fee)."\"";
	$ajax_json .= ",\"total_fee\":\"".number_format($total_fee)."\"";
	$ajax_json .= ",\"error_msg\":\"".$error_msg."\"";
	$ajax_json .= "}";

	echo "[".$ajax_json."]";
	exit;
}
?>