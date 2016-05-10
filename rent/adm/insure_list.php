<?
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '자차보험관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";
?>
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">

<div style="margin-left:10px; margin-bottom:10px; float:left; width:20%;"><a href="insure_form.php"><button>보험추가</button></a></div>
<div style="margin:10px; text-align:right;">※ 차량명이 <font color=green>녹색은 출시예정</font>, <font color=blue>파란색은 보유</font>, <font color=red>빨간색은 비보유</font>, <font color=gray>회색은 미등재</font></div>

<div class="tbl_list">
<table>
	<tr>
		<th>보험명</td>
		<th>보험종류</td>
		<th>계산방법</td>
		<th>기준보험료</td>
		<th>연휴보험료</td>
		<th>휴차보상료</td>
		<th>면책금</td>
		<th>자차한도</td>
		<th>운영사</td>
		<th>사용여부</td>
	</tr>
<?
	$que="select * from rc_insure order by insure_no";
	$sql=sql_query($que);
	while($arr=sql_fetch_array($sql)) {
		$link_str="<a href='insure_form.php?insure_no=$arr[insure_no]'>";
		if($arr[break_fee]==1) { 
			$break_str="있음";
		} else { 
			$break_str="없음";
		}
		if($arr[insure_state]==1) { 
			$state_str="사용함";
		} else { 
			$state_str="사용안함";
		}
?>
		<tr>
			<td><?=$link_str?><?=$arr[insure_name]?></a></td>
			<td><?=$a_insure[$arr[insure_type]]?></td>
			<td><?=$a_insure_cal[$arr[cal_type]]?></td>
			<td><?=number_format($arr[basis_fee])?>원</td>
			<td><?=number_format($arr[season_fee])?>원</td>
			<td><?=$break_str?></td>
			<td><?=$arr[exempt_fee]?>만원</td>
			<td><?=$arr[insure_limit]?>만원</td>
			<td><?=$a_insure_company[$arr[insure_company]]?></td>
			<td><?=$state_str?></td>
		</tr>
<?
	} 
?>
</table>

<?	
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>