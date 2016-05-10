<?
include_once('../include/common.php');
include_once("../include/head.php");
include_once("./inc/config.php");
?>
<script type="text/javascript">
function form_submit() {
	f=document.confirm_form;
	if(!f.reserve_no.value) {
		alert("예약번호를 입력하세요."); f.reserve_no.focus(); return false;
	}
	if(!f.cus_name.value) {
		alert("예약자명을 입력하세요."); f.cus_name.focus(); return false;
	}
	f.submit();
}
</script>
<link rel="stylesheet" type="text/css" href="/css/form/result.css" />
<link rel="stylesheet" type="text/css" href="/rent/css/style.css">
<div id="section-wrap">
<!-- -->
		<div class="rowgroup">
			<div class="sub_title2">
				<div class="navigation">
					<span class="home">홈</span>  &gt; 렌터카 &gt; <strong>예약확인</strong>
				</div>
				<h1>예약확인</h1>
                <h2>할인된 가격으로 렌터카를 이용하세요!</h2>
			</div>
       </div>
<!-- -->
                     
			<div class="reservation-cont">
				<div class="reservation-comp">
                <div class="cont">
                    <h2>예약 내용을 확인하세요.</h2>
                        <h3>예약확인을 위해 예약번호와 이름을 입력하세요.</h3>
<form name="confirm_form" action="confirm_02.php" onsubmit="return form_submit();" method="post">
<input type="hidden" name="url" value="<?php echo $login_url ?>">

    <fieldset id="login_fs">
        <label for="login_id" class="login_id">예약번호<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="reserve_no" id="reserve_no" required class="frm_input required" size="20" maxLength="20">
        <label for="login_pw" class="login_pw">예약자명<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="cus_name" id="cus_name" required class="frm_input required" size="20" maxLength="20"><br>
        <input type="submit" value="확인" class="btn_submit">
    </fieldset>
</form>
</div></div></div></div>

<?
include_once("../include/tail.php");
?>     