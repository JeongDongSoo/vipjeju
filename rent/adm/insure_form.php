<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '자차보험관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

// firewall
//$check_url = '/rentcar/admin/fee_list';
//if (!auth_action('access', $check_url)) error('접근권한이 없습니다.');

if($insure_no) {
	$mode="update";
	$que="select * from rc_insure where insure_no='$insure_no'";
	$arr=sql_fetch_array(sql_query($que)); 
} else {
	$mode="insert";
	$arr[insure_state]=1;
}
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<script language=JavaScript>
function form_submit(f) {
	if(!f.insure_name.value) {
		alert("보험명칭을 입력하세요."); f.insure_name.focus();	return false;
	}
	if(!f.basis_fee.value) {
		alert("기준보험료를 입력하세요."); f.basis_fee.focus();	return false;
	}
	f.submit();
}
function del(car_no) {
	if(confirm('정말 삭제하시겠습니까?\n\n삭제된 차량은 복구되지 않습니다.'))
	{
		if (car_no != 'all') document.location.href = "<?=$_SERVER['PHP_SELF']?>?mode=del&car_no=" + car_no;			
		else
		{
			f=document.fee_form;
			f.mode.value='del';
			f.submit();
		}
	} 
	return false;
}
function see_del(nn) {
	f=document.fee_form;
	if(confirm(nn+'번 실사진을 삭제하시겠습니까?')) {
		f.mode.value='see_del';
		f.del_no.value=nn;
		f.submit();
	}
}

function see_all_del() {
	if(confirm('[<?=$arr[name]?>] 차량의 실사진을 전부 삭제하시겠습니까?')) {
		document.location.href = "<?=$_SERVER['PHP_SELF']?>?mode=see_all_del&car_no=<?=$car_no?>&car_cnt=<?=$car_cnt?>";
	}
}
function spec_search() {
	window.open('spec_code_in.php?car_name='+document.all.car_name.value,'spec_code','top=80,left=520,width=500,height=500,scrollbars=1');
}
</script>

<form name=insure_form method=POST enctype='multipart/form-data' action='insure_update.php'>
<input type=hidden name=mode value='<?=$mode?>'>
<input type=hidden name=insure_no value=<?=$insure_no?>>

<div class="tbl_basic">
    <table>
	  <tr>
		<th>보험명</td>
		<td><input type=text name=insure_name value='<?=$arr[insure_name]?>' size=25></td>
	  </tr>
	  <tr>
		<th>보험종류</td>
		<td><select name=insure_type>
		<? foreach($a_insure as $key => $val) { ?>
		<option value=<?=$key?> <? if($arr[insure_type]==$key) { echo"selected"; } ?>><?=$val?></option>
		<? } ?>
		</select></td>
	  </tr>
	  <tr>
		<th>보험료계산법</td>
		<td><select name=cal_type>
		<? foreach($a_insure_cal as $key => $val) { ?>
		<option value=<?=$key?> <? if($arr[cal_type]==$key) { echo"selected"; } ?>><?=$val?></option>
		<? } ?>
		</select></td>
	  </tr>
	  <tr>
		<th>계산법 설명</td>
		<td>기준보험료에 사용일 단위로 곱하여 계산</td>
	  </tr>
	  <tr>
		<th>기준보험료</td>
		<td><input type=text name=basis_fee value='<?=$arr[basis_fee]?>' size=7>원/1일</td>
	  </tr>
	  <tr>
		<th>연휴보험료</td>
		<td><input type=text name=season_fee value='<?=$arr[season_fee]?>' size=7>원/1일</td>
	  </tr>
	  <tr>
		<th>휴차보상료</td>
		<td><select name=break_fee>
		<option value='1' <? if($arr[break_fee]==1) { echo"selected"; } ?>>있음</option>
		<option value='0' <? if($arr[break_fee]==0) { echo"selected"; } ?>>없음</option>
		</select></td>
	  </tr>
	  <tr>
		<th>면책금</td>
		<td><input type=text name=exempt_fee value='<?=$arr[exempt_fee]?>' size=7>만원</td>
	  </tr>
	  <tr>
		<th>자차한도</td>
		<td><input type=text name=insure_limit value='<?=$arr[insure_limit]?>' size=7>만원</td>
	  </tr>
	  <tr>
		<th>운영사</td>
		<td><select name=insure_company>
		<? while(list($key,$val)=each($a_insure_company)) { ?>
		<option value='1' <? if($arr[insure_company]==$key) { echo"selected"; } ?>><?=$val?></option>
		<? } ?>
		</select></td>
	  </tr>
	  <tr>
		<th>사용여부</td>
		<td><select name=insure_state>
		<option value='1' <? if($arr[insure_state]==1) { echo"selected"; } ?>>사용함</option>
		<option value='0' <? if($arr[insure_state]==0) { echo"selected"; } ?>>사용안함</option>
		</select></td>
	  </tr>
	  <tr>
		<th>비 고</td>
		<td><textarea rows=5 name=insure_memo><?=$arr[insure_memo]?></textarea></td>
	  </tr>
	</table>

<div class="btn_confirm01 btn_confirm">
    <input type="button" class="btn_submit" accesskey="s" value="저장하기" onclick="return form_submit(this.form)">
    <a href="./insure_list.php">목록보기</a>
</div>

</div>
</form>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>