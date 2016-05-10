<?
include_once('../include/common.php');
include_once("../include/head.php");
include_once("./inc/config.php");
include_once("./inc/function.php");

if(!$reserve_no) {
	echo"잘못된 접근입니다."; exit;
}
//$que="select * from rc_reserve where reserve_no='$reserve_no' and cus_name='$cus_name'";
$que="select * from rc_reserve where reserve_no='$reserve_no'";
$arr=sql_fetch($que);
$use_hour = round(($arr[e_date]-$arr[s_date])/3600);

if(!$arr[rsv_no]) {
	echo"예약자정보와 일치하는 예약이 없습니다."; exit;
}
?>
<link rel="stylesheet" type="text/css" href="/css/form/result.css" />
<link rel="stylesheet" type="text/css" href="/css/form/common.css">
<link rel="stylesheet" type="text/css" href="/css/default.css"/>

 <div id="section-wrap">
		<div class="recruit-step-wrap reservation-wrap">                        
			<div class="reservation-cont">
<!-- -->
		<div class="rowgroup">
			<div class="sub_title">
				<div class="navigation">
					<span class="home">홈</span>  &gt; 렌터카 &gt; <strong>예약완료</strong>
				</div>
				<h1>예약완료</h1>
                <h2>할인된 가격으로 렌터카를 이용하세요!</h2>
			</div>
       </div>
<!-- -->
				<div class="reservation-comp">
                <div class="cont">
                    <h2>예약 내용을 확인하세요.</h2>
                    <div class="input-area">
                        <div class="bottom-table border-table">
                            <table summary="예약 확인 및 완료" width="100%">
                                <caption>예약 확인</caption>
                                <colgroup>
                                    <col width="160px;" />
                                    <col width="440px;" />
                                    <col width="160px;" />
                                    <col width="440px;" />
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th scope="row">예약번호</th>
                                        <td><?=$reserve_no?></td>
                                        <th scope="row">이용시간</th>
                                        <td><?=$use_hour?>시간</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">대여일시</th>
                                        <td><?=date('Y-m-d H:i',$arr[s_date])?></td>
                                        <th scope="row">반납일시</th>
                                        <td><?=date('Y-m-d H:i',$arr[e_date])?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">대여차종</th>
                                        <td><?=$arr[car_name]?></td>
                                        <th scope="row">대여댓수</th>
                                        <td><?=$arr[car_cnt]?>대</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">인수장소</th>
                                        <td><?=$a_place[$arr[s_place]]?> (<?=number_format($a_place_fee[$arr[s_place]])?>원)</td>
                                        <th scope="row">차량요금</th>
                                        <td><?=number_format($arr[car_fee])?>원</td>
                                    </tr>
                                    <tr>
										<th scope="row">반납장소</th>
                                        <td><?=$a_place[$arr[e_place]]?> (<?=number_format($a_place_fee[$arr[e_place]])?>원)</td>
                                        <th scope="row">배/반차요금</th>
                                        <td><?=number_format($arr[out_fee])?>원</td>
                                    </tr>
                                    <tr>
										<th scope="row">자차보험</th>
                                        <td><?=$a_insure_info[$arr[rsv_insure]]?></td>
                                        <th scope="row">자차보험료</th>
                                        <td><?=number_format($arr[insure_fee])?>원</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">부가서비스</th>
                                        <td><?
										$aque="select * from rc_rsv_add_goods A left join rc_add_goods B on A.goods_no=B.add_no where reserve_no='$reserve_no' order by rsv_add_no";
										$asql=sql_query($aque);
										while($aarr=sql_fetch_array($asql)) { 
											echo $aarr[add_name]." ".$aarr[goods_cnt]."개, ";
										} ?></td>
                                        <th scope="row">부가서비스요금</th>
                                        <td><?=number_format($arr[add_goods_fee])?>원</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">이름</th>
                                        <td><?=$arr[cus_name]?></td>
                                        <th scope="row">이메일</th>
                                        <td><?=$arr[cus_email]?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">연락처</th>
                                        <td><?=$arr[cus_phone]?></td>
                                        <th scope="row"></th>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="total-comp">
                        <p class="tit">총 요금<span class="txt-orange"><?=number_format($arr[total_fee])?></span>원</p>
                        <span class="sub-txt"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-center">
            <a href="/"><img  src="/images/home_btn.gif"/></a> &nbsp; &nbsp; 
            <span class="print"><a href="javascript:window.print();"><img  src="/images/print_btn.gif"/></a></span>
        </div>

       </div>
    </div>
<?
include_once("../include/tail.php");
?>    