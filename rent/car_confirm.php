<?
include_once('../include/common.php');
include_once("../include/head.php");
include_once("./inc/config.php");
include_once("./inc/function.php");
?>
<link rel="stylesheet" type="text/css" href="/css/form/form.css" />
<link rel="stylesheet" type="text/css" href="/css/form/common.css">
<link rel="stylesheet" type="text/css" href="/css/default.css"/>

 <div id="section-wrap">
	<h1>예약확인</h1>
		<div class="recruit-step-wrap reservation-wrap">                        
			<div class="reservation-cont">
				<div class="reservation-comp">
                <div class="cont">
                    <h2>예약 내용을 확인하세요.</h2>
                    <div class="input-area">
                        <div class="bottom-table border-table">
                            <table summary="예약 확인 및 완료">
                                <caption>예약 확인</caption>
                                <colgroup>
                                    <col width="200px;" />
                                    <col width="290px;" />
                                    <col width="200px;" />
                                    <col width="290px;" />
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th bgcolor="#eeeeee" scope="row">대여일시</th>
                                        <td>2016-04-15/19시/00분</td>
                                        <th scope="row">반납일시</th>
                                        <td>2016-04-16/19시/00분</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">대여차종</th>
                                        <td>중형/YF소나타[오토]</td>
                                        <th scope="row">대여댓수</th>
                                        <td>1대</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">인수장소</th>
                                        <td>제주공항(0원)</td>
										<th scope="row">반납장소</th>
										<td>제주공항(0원)</td>
                                    </tr>
                                    <tr>
										<th scope="row">보험가입</th>
                                        <td>일반면책 : 면책금 + 휴차보상료 부담</td>
                                        <th scope="row">부가서비스</th>
                                        <td>유모차1 + 카시트(1세용)</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">차량요금</th>
                                        <td>18,000원</td>
                                        <th scope="row">배/반차요금</th>
                                        <td>0원</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">보험가입요금</th>
                                        <td>24,000원</td>
                                        <th scope="row">부가서비스요금</th>
                                        <td>14,000원</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">이름</th>
                                        <td>홍길동</td>
                                        <th scope="row">이메일</th>
                                        <td>djeju@naver.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">휴대폰번호</th>
                                        <td>010-1111-2222</td>
                                        <th scope="row"></th>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="total-comp">
                        <p class="tit">총 요금<span class="txt-orange">56,000</span>원</p>
                        <span class="sub-txt"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-center">
            <a href="/"><img  src="/images/confirm-btn.gif"/></a>
            <span class="print"><a href="#" onclick="resPrint(); return false;"><img  src="/images/print-btn.gif"/></a></span>
        </div>

       </div>
    </div>
<?
include_once("../include/tail.php");
?>    