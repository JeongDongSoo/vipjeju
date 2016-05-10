<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '예약관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='save') {
	$sque="select id from rentcar_db order by id";
	$ssql=mysql_query($sque);
	while($sarr=mysql_fetch_array($ssql,MYSQL_ASSOC)) {
		$i=$sarr[id];
		$sort=${"sort_$i"};
		if($sort>0) {
			$new_car=${"new_car_$i"};
			$kind=${"kind_$i"};
			$no_charge=${"no_charge_$i"};
			$no_su_charge=${"no_su_charge_$i"}; //슈퍼면책
			$insure_limit=${"insure_limit_$i"}; //자차한도
			$tbasic=${"tbasic_$i"};	//비교기준요금
			$t24=${"t24_$i"};

			$uque="update rentcar_db set sort='$sort', new_car='$new_car', kind='$kind', no_charge='$no_charge', no_su_charge='$no_su_charge', insure_limit='$insure_limit', tbasic='$tbasic', t24='$t24' where id=$i";
			if(!mysql_query($uque)) {	echo"오류! => $uque<br>";	}
			if(${"id2_$i"}) {
				$uque="update rentcar_db set sort='$sort', new_car='$new_car', kind='$kind', no_charge='$no_charge', no_su_charge='$no_su_charge', insure_limit='$insure_limit', tbasic='$tbasic', t24='$t24' where id=".${"id2_$i"};
				if(!mysql_query($uque)) {	echo"오류! => $uque<br>";	}
			}
			if(${"id3_$i"}) {
				$uque="update rentcar_db set sort='$sort', new_car='$new_car', kind='$kind', no_charge='$no_charge', no_su_charge='$no_su_charge', insure_limit='$insure_limit', tbasic='$tbasic', t24='$t24' where id=".${"id3_$i"};
				if(!mysql_query($uque)) {	echo"오류! => $uque<br>";	}
			}
		}
	}
	location($PHP_SELF);
}

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "rsv_no";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt rc_reserve {$sql_search} {$sql_order}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<script type="text/javascript">
$(document).ready(function(){
    $('table tr').click(function(){
        window.location = $(this).attr('href');
        return false;
    });
});
</script>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="cus_name"<?php echo get_selected($_GET['sfl'], "cus_name"); ?>>예약자명</option>
    <option value="reserve_no"<?php echo get_selected($_GET['sfl'], "reserve_no"); ?>>예약번호</option>
    <option value="cus_phone"<?php echo get_selected($_GET['sfl'], "cus_phone"); ?>>연락처</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<div class="tbl_list">
<table style="width:100%">
<form name=list_form method=get action='<?=$PHP_SELF?>'>
	<tr>
		<th>No.</td>
		<th>예약번호</td>
		<th>예약자명</td>
		<th>연락처</td>
		<th>인수일시</td>
		<th>반납일시</td>
		<th>이용시간</td>
		<th>차종</td>
		<th>대수</td>
		<th>인수장소</td>
		<th>반납장소</td>
		<th>자차보험</td>	
		<th>대여료</td>
		<th>배반차료</td>
		<th>자차보험료</td>
		<th>부가서비스</td>
		<th>총요금</td>
		<th>예약상태</td>
		<th>신청일시</td>
	</tr>
</form>
<!-- <form name=list_form method=post action=$PHP_SELF>
<input type=hidden name=mode value='save'> -->
<?
	$que="select * from rc_reserve {$sql_search} {$sql_order} limit {$from_record}, {$rows}";
	$sql=sql_query($que);
	while($arr=sql_fetch_array($sql)) {
		$link_str="<a href='reserve_form.php?rsv_no=$arr[rsv_no]'>";
		$use_hour=round($arr[e_date]-$arr[s_date])/(60*60);
?>
	<tr href='reserve_form.php?rsv_no=<?=$arr[rsv_no]?>&page=<?=$page?>' style="cursor:pointer" onmouseover="style.backgroundColor='#b9dcff'" onmouseout="style.backgroundColor='#ffffff'">
		<td><?=$arr[rsv_no]?></td>
		<td><?=$arr[reserve_no]?></td>
		<td><?=$arr[cus_name]?></td>
		<td><?=$arr[cus_phone]?></td>
		<td><?=date('m.d H:i',$arr[s_date])?></td>
		<td><?=date('m.d H:i',$arr[e_date])?></td>
		<td><?=$use_hour?></td>
		<td><?=$arr[car_name]?></td>
		<td><?=$arr[car_cnt]?></td>
		<td><?=$a_place[$arr[s_place]]?></td>
		<td><?=$a_place[$arr[e_place]]?></td>
		<td><?=$a_insure[$arr[rsv_insure]]?></td>
		<td><?=number_format($arr[car_fee])?></td>
		<td><?=number_format($arr[out_fee])?></td>
		<td><?=number_format($arr[insure_fee])?></td>
		<td><?=number_format($arr[add_goods_fee])?></td>
		<td><?=number_format($arr[total_fee])?></td>
		<td><?=$a_state[$arr[rsv_state]]?></td>
		<td><?=date('m.d H:i',$arr[w_time])?></td>
	</tr>
<?
	}
?>
</table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<?
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>