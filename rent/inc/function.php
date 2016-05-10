<?
function car_fee_cal ($stime, $etime, $car_arr, $insure) {
	$kque="SELECT max(kind_no) as kmax FROM rc_kind_code";
	$karr=sql_fetch_array(sql_query($kque));
	$kind_code_max=$karr[kmax];

	$dc_season_arr=array();
	$insure_basis_arr=array();
	$sdate=mktime(0,0,0,date(m,$stime),date(d,$stime),date(Y,$stime));
	$edate=mktime(0,0,0,date(m,$etime),date(d,$etime),date(Y,$etime));
	$insure_day = ($edate-$sdate)/(60*60*24)+1;

	$sque="select * from rc_dc_season where rd_time>='$sdate' and rd_time<='$edate' order by rd_time";
	$ssql=sql_query($sque);
	while($sarr=sql_fetch_array($ssql)) {
		$dc_season_arr[$sarr[rd_time]]=$sarr[rd_season];
		$dc_i_season_arr[$sarr[rd_time]]=$sarr[rd_insure_season];
	}
	for($d=$sdate; $d<=$edate; $d+=60*60*24) {
		if(!$dc_season_arr[$d]) {
			return false;
		}
		if(!$dc_rate_arr[$dc_season_arr[$d]][1] && !$dc_rate_arr[$dc_season_arr[$d]][2]) {
			$rque="select * from rc_dc_rate where dc_no='$dc_season_arr[$d]'";
			$rarr=sql_fetch_array(sql_query($rque));
			$ique="select * from rc_insure_dc_rate where dc_no='$dc_season_arr[$d]'";
			$iarr=sql_fetch_array(sql_query($ique));
			for($i=1; $i<=$kind_code_max; $i++) {
				$dc_rate_arr[$dc_season_arr[$d]][$i]=$rarr["dc_".$i];
				$dc_i_rate_arr[$dc_season_arr[$d]][$i]=$iarr["dc_".$i];
			}
		}
	}

	foreach($car_arr as $key => $val) {
		$cque="select * from rc_car where car_no='$val'";
		$csql=sql_query($cque);
		$carr=sql_fetch_array($csql);
		$insure_val=$carr["car_insure".$insure];

		$car_fee=0;
		$car_dc_fee=0;
		for($d=$stime; $d<=$etime; $d+=60*60*24) {
			$dv=mktime(0,0,0,date(m,$d),date(d,$d),date(Y,$d));
			$dc_rate=$dc_rate_arr[$dc_season_arr[$dv]][$carr[kind_code]];
			$dc_i_rate=$dc_i_rate_arr[$dc_i_season_arr[$dv]][$carr[kind_code]];

			$car_day_fee=0;
			$remain_hour=round(($etime-$d)/(60*60));
			if($remain_hour>=24) {
				$car_day_fee=$carr[h24_fee];
			} elseif($remain_hour>=12) {
				$rh=$remain_hour-12;
				if($rh<=2) { 
					$car_day_fee=$carr[h12_fee]+$rh*$carr[h1_fee];
					if($car_day_fee>$carr[h24_fee]) $car_day_fee=$carr[h24_fee];
				} else {
					$car_day_fee=$carr[h24_fee];
				}
			} elseif($remain_hour>=6) {
				$rh=$remain_hour-6;
				if($rh<=2) { 
					$car_day_fee=$carr[h6_fee]+$rh*$carr[h1_fee];
					if($car_day_fee>$carr[h12_fee]) $car_day_fee=$carr[h12_fee];
				} else {
					$car_day_fee=$carr[h12_fee];
				}
			} else {
				$rh=$remain_hour;
				if($rh<=2) { 
					$car_day_fee=$rh*$carr[h1_fee];
					if($car_day_fee>$carr[h6_fee]) $car_day_fee=$carr[h6_fee];
				} else {
					$car_day_fee=$carr[h6_fee];
				}
			}
			$car_fee+=$car_day_fee;
			$car_dc_fee+=$car_day_fee*(1-$dc_rate/100);
		}
		$car_fee_arr[1][$val]=$car_fee; //정상가
		$car_dc_fee=floor($car_dc_fee/1000)*1000;
		$car_fee_arr[2][$val]=$car_dc_fee;  //할인가

		if(!$insure_basis_arr[$insure_val]) {
			$ique="select basis_fee from rc_insure where insure_no=$insure_val";
			$iarr=sql_fetch_array(sql_query($ique));
			$insure_basis_arr[$insure_val]=$iarr[basis_fee];
		}
		$insure_dc_fee=$insure_basis_arr[$insure_val]*(1-$dc_i_rate/100);
		$insure_dc_fee=floor($insure_dc_fee/1000)*1000;
		$car_fee_arr[3][$val]=$insure_dc_fee*$insure_day; //보험료
	}
	return $car_fee_arr;
}
?>