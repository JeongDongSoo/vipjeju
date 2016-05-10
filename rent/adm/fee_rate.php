<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
$g5['title'] = '차종코드관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once "../inc/config.php";

if($mode=='modify') {
	$kque="select * from rc_kind_code where state=1 order by kno";
	$ksql=mysql_query($kque);
	while($karr=mysql_fetch_array($ksql)) {
		$season_str="";
		for($s=1; $s<=$season_max; $s++) {
			if($season_str) { $season_str.=","; }
			/*if($s==18) {
				$frate=-2.5*${"frate_".$karr[kno]."_".$s};
			} else {
				$frate=150-2.5*${"frate_".$karr[kno]."_".$s};
			}*/
			$frate=${"frate_".$karr[kno]."_".$s};
			$season_str.="s$s='$frate'";
		}
		$uque="update rc_fee_rate set $season_str where kind=$karr[kno]";
		if(!mysql_query($uque)) {	echo"저장 오류<br>$uque"; exit;	}
		if($once_save==1) {
			$uque="update rc_fee_rate_tour set $season_str where kind=$karr[kno]";
			if(!mysql_query($uque)) {	echo"투어 저장 오류<br>$uque"; exit;	}
		}
	}
	$to_time=time(); $save_term=time()-60*10;
	$sque="select lno from rc_fee_rate_save where lname='$ss_name' and ltime>='$save_term' and ltour=1";
	$sarr=mysql_fetch_array(mysql_query($sque));
	if($sarr[lno]) {
		$ique="update rc_fee_rate_save set lname='$ss_name', ltime='$to_time' where lno='$sarr[lno]'";
	} else {
		$ique="insert into rc_fee_rate_save values ('','$ss_name','$to_time','1')";
	}
	if(!mysql_query($ique)) {	echo"수정자 저장 오류<br>$ique"; exit; }	

	$kque="select * from rc_kind_code where state=1 order by kno";
	$ksql=mysql_query($kque);
	while($karr=mysql_fetch_array($ksql)) {
		if($sarr[lno]) {
			$season_str="";
			for($s=1; $s<=$season_max; $s++) {
				if($season_str) { $season_str.=","; }
				/*if($s==18) {
					$frate=-2.5*${"frate_".$karr[kno]."_".$s};
				} else {
					$frate=150-2.5*${"frate_".$karr[kno]."_".$s};
				}*/
				$frate=${"frate_".$karr[kno]."_".$s};
				$season_str.="s$s='$frate'";
			}
			$uque="update rc_fee_rate_log set $season_str where kind=$karr[kno] and lcode='$sarr[lno]'";
		} else {
			$mque="select max(lno) from rc_fee_rate_save where ltour=1";
			$marr=mysql_fetch_array(mysql_query($mque));
			$season_str="";
			for($s=1; $s<=40; $s++) {
				if($season_str) { $season_str.=","; }
				/*if($s==18) {
					$frate=-2.5*${"frate_".$karr[kno]."_".$s};
				} else {
					$frate=150-2.5*${"frate_".$karr[kno]."_".$s};
				}*/
				$frate=${"frate_".$karr[kno]."_".$s};
				$season_str.="'$frate'";
			}
			$uque="insert into rc_fee_rate_log values ('$marr[0]','$karr[kno]',$season_str)";
		}
		//echo $uque."<br>";
		if(!mysql_query($uque)) {	echo"저장 오류<br>$uque"; exit;	}
	}
	if($once_save==1) {
		$sque="select lno from rc_fee_rate_save where lname='$ss_name' and ltime>='$save_term' and ltour=2";
		$sarr=mysql_fetch_array(mysql_query($sque));
		if($sarr[lno]) {
			$ique="update rc_fee_rate_save set lname='$ss_name', ltime='$to_time' where lno='$sarr[lno]'";
		} else {
			$ique="insert into rc_fee_rate_save values ('','$ss_name','$to_time','2')";
		}
		if(!mysql_query($ique)) {	echo"수정자 저장 오류<br>$ique"; exit; }
		
		$kque="select * from rc_kind_code where state=1 order by kno";
		$ksql=mysql_query($kque);
		while($karr=mysql_fetch_array($ksql)) {
			if($sarr[lno]) {
				$season_str="";
				for($s=1; $s<=$season_max; $s++) {
					if($season_str) { $season_str.=","; }
					/*if($s==18) {
						$frate=-2.5*${"frate_".$karr[kno]."_".$s};
					} else {
						$frate=150-2.5*${"frate_".$karr[kno]."_".$s};
					}*/
					$frate=${"frate_".$karr[kno]."_".$s};
					$season_str.="s$s='$frate'";
				}
				$uque="update rc_fee_rate_log set $season_str where kind=$karr[kno] and lcode='$sarr[lno]'";
			} else {
				$mque="select max(lno) from rc_fee_rate_save where ltour=2";
				$marr=mysql_fetch_array(mysql_query($mque));
				$season_str="";
				for($s=1; $s<=40; $s++) {
					if($season_str) { $season_str.=","; }
					/*if($s==18) {
						$frate=-2.5*${"frate_".$karr[kno]."_".$s};
					} else {
						$frate=150-2.5*${"frate_".$karr[kno]."_".$s};
					}*/
					$frate=${"frate_".$karr[kno]."_".$s};
					$season_str.="'$frate'";
				}
				$uque="insert into rc_fee_rate_log values ('$marr[0]','$karr[kno]',$season_str)";
			}
			if(!mysql_query($uque)) {	echo"저장 오류<br>$uque"; exit;	}
		}
	}
	location($PHP_SELF);
}

include"../inc/config_rate.php";

$cque="select * from rentcar_db where keep=1 order by kind, name";
$csql=mysql_query($cque);
while($carr=mysql_fetch_array($csql)) {
	if($car_name_arr[$carr[kind]]) { $car_name_arr[$carr[kind]].="<br>"; }
	$car_name_arr[$carr[kind]].=text_cut($carr[name],20);
}

$tque="select count(sno) from rc_season_code where state=1";
$tarr=mysql_fetch_array(mysql_query($tque));
$season_num=$tarr[0];
?>
<tr><td>
	<table width=600 border=0 cellspacing=0 cellpadding=0>
<form action='<?=$PHP_SELF?>' method=POST>	 
<input type=hidden name=mode value=modify>
		<tr height=30>
			<td style=padding-left:10pt><b><font size=3 color=0066CC>◈ 렌트카 요금 할인율</font></td>
			<td><input type=button value='엑셀다운로드' onclick="window.open('fee_rate_excel.php','','')" style=cursor:hand></td>
		</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td><table width=<?=200+$season_num*40?> border=0 cellspacing=1 cellpadding=1 bgcolor=cccccc>
			<tr height=24 align=center bgcolor=dddddd>
				<td width=40>구분</td>
				<td width=160>차량명</td>
<?
$sque="select * from rc_season_code where state=1 order by sno";
$ssql=mysql_query($sque);
while($sarr=mysql_fetch_array($ssql)) {
	$insure1_arr[$sarr[sno]]=$sarr[insure1];
}
for($n=0; $n<count($season_code_arr); $n++) {
	$val=$season_code_arr[$n];
	echo"<td width=40>$season_name_arr[$val]</td>";
}
echo"</tr>";

$data=array();
$fque="select * from rc_fee_rate order by kind";
$fsql=mysql_query($fque);
while($farr=mysql_fetch_array($fsql)) {
	for($n=0; $n<count($season_code_arr); $n++) {
		$k=$season_code_arr[$n];
		$data[$farr[kind]][$k]=$farr["s".$k];
		/*if($k==18) {
			$data[$farr[kind]][$k]=-$farr["s".$k]/2.5;
		} else {
			$data[$farr[kind]][$k]=(150-$farr["s".$k])/2.5;
		}*/
	}
}
if($lcode) {
	$ldata=array();
	$fque="select * from rc_fee_rate_log where lcode='$lcode' order by kind";
	$fsql=mysql_query($fque);
	while($farr=mysql_fetch_array($fsql)) {
		if($car_name_arr[$farr[kind]]) {
			for($n=0; $n<count($season_code_arr); $n++) {
				$k=$season_code_arr[$n];
				$ldata[$farr[kind]][$k]=$farr["s".$k];
				/*if($k==18) {
					$ldata[$farr[kind]][$k]=-$farr["s".$k]/2.5;
				} else {
					$ldata[$farr[kind]][$k]=(150-$farr["s".$k])/2.5;
				}*/
			}
		}
	}
}
$bold_car_kind_arr=array('소형2','중형3','고급3','SUV3','승합2');
$tmp=0; $kind_max=0; 
$kque="select * from rc_kind_code where state=1 order by sort, kno";
$ksql=mysql_query($kque);
while($karr=mysql_fetch_array($ksql)) {
	$tmp++;
	$kind_str=$karr[kname];
	if(in_array($kind_str,$bold_car_kind_arr)) {
		$kind_str="<font color=blue><b>$kind_str</b></font>";
	}
	echo"
		<tr align=center bgcolor=ffffff onMouseOver=this.style.backgroundColor='#DDEEFF' onMouseOut=this.style.backgroundColor=''>
			<td>".$kind_str."</td>
			<td align=left>".$car_name_arr[$karr[kno]]."</td>";
	for($n=0; $n<count($season_code_arr); $n++) {
		$k=$season_code_arr[$n];
		$tabindex=($n+1)*100+$tmp;
		$lcode_str="";
		if($lcode) {
			if($ldata[$karr[kno]][$k]!=$data[$karr[kno]][$k]) { $lcode_str.="<font color=red><b>"; } 
			$lcode_str.=$ldata[$karr[kno]][$k]."</b></font><br>";
		}
		echo"<td $bg_color_str>$lcode_str<input type=text name='frate_".$karr[kno]."_".$k."' value='".$data[$karr[kno]][$k]."' size=3 style='text-align:center; color:$season_color_arr[$k];' tabindex=$tabindex></td>";
	}
	echo"</tr>";
}
?>
	</table>
	</td>
	<td style='padding:0 0 0 10' valign=top>
	<table width=200 border=0 cellspacing=1 cellpadding=2 bgcolor=aaaaaa>
<?
	$no=0;
	$sque="select * from rc_fee_rate_save where ltour=1 order by ltime desc limit 35";
	$ssql=mysql_query($sque);
	while($sarr=mysql_fetch_array($ssql)) {
		$no++;
		$tr_bgcolor="#ffffff";
		if($sarr[lno]==$lcode) { $tr_bgcolor="#B9DCFF"; }
		echo"
			<tr bgcolor=$tr_bgcolor align=center onclick=\"location='$PHP_SELF?lcode=$sarr[lno]'\" style=cursor:hand onMouseOver=this.style.backgroundColor='#DDEEFF' onMouseOut=this.style.backgroundColor=''>
				<td>$no</td>
				<td>$sarr[lname]</td>
				<td>".date('Y.m.d H:i',$sarr[ltime])."</td>
			</tr>";
	}
?>
	</table></td>
	</tr>
	</table>
	</td></tr>
<?if($ss_level<=0) {?>
	<tr align=center>
		<td><input type=checkbox name=once_save value=1 checked>투어 동시 저장 &nbsp;
		<input type=submit value=' 저장하기 ' style='cursor:hand'></td>
	</tr>
<?}?>
	<tr height=10><td></td></tr>
<input type=hidden name='season_max' value='<?=$season_max?>'>
</form>
	</TABLE>
<!--------------- 제목 -------------------------->
<script language="JavaScript">
<!--
	var isDOM = (document.getElementById ? true : false); 
	var isIE4 = ((document.all && !isDOM) ? true : false);
	var isNS4 = (document.layers ? true : false);
	var isNS = navigator.appName == "Netscape";

	function getRef2(id) {
		if (isDOM) return document.getElementById(id);
		if (isIE4) return document.all[id];
		if (isNS4) return document.layers[id];
	}

	var scrollerHeight = 88;
	var puaseBetweenImages = 3000;
	var imageIdx = 0;
	var scrollerInit = 563; //위쪽 위치

	function moveRightEdge2() {
		var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck;
		if(document.body.scrollTop>scrollerInit)
		{
			if (isDOM) {
				yMenuFrom   = parseInt (div_title.style.top, 10);
				yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop) + 0; 
			}
			timeoutNextCheck = 5;

			if (yMenuFrom != yMenuTo) {
				yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom));
				if (yMenuTo < yMenuFrom)
					yOffset = -yOffset;
				if (isNS4)
					div_title.top += yOffset;
				else if (isDOM)
					div_title.style.top = parseInt (div_title.style.top, 10) + yOffset;
					timeoutNextCheck = 10;
			}		
		}
		else div_title.style.top = scrollerInit;
		setTimeout ('moveRightEdge2()', timeoutNextCheck);		
	}
	function open_price(val, name, color)
	{
		var open_price = window.open("/rentcar/admin/pop_price.php?val=" + val + "&name=" + name + "&color=" + color, "pop_price", "width=620, height=900, scrollbars=yes");

		open_price.focus();
	}
//-->
</script>

<div id="div_title" style="position:absolute; width:500px; height:20px; z-index:9; display:"> 
<SCRIPT language=javascript>
<!--	
	if (isDOM) {
			var div_title = getRef2('div_title');
			div_title.style.visibility = "visible";
			moveRightEdge2();		
	}	
	div_title.style.left = 135; //왼쪽위치
	div_title.style.top = scrollerInit;
//-->
</script>
	<table width=<?=200+$season_num*40?> border=0 cellspacing=1 cellpadding=1 bgcolor=cccccc>
		<tr height=24 align=center bgcolor=dddddd>
			<td rowspan=2 width=40>구분</td>
			<td rowspan=2 width=148>차량명</td>
<?
for($n=0; $n<count($season_code_arr); $n++) {
	$val=$season_code_arr[$n];
	echo"<td width=40 onclick='open_price($val, \"" . base64_encode($season_name_arr[$val]) . "\", \"" . base64_encode($season_color_arr[$val]) . "\")' style='cursor:hand; color:$season_color_arr[$val]' style='color:$season_color_arr[$val]'>".substr($season_name_arr[$val],0,6)."</td>";
	//<br>$insure1_arr[$val] //일반자차 적용율
}
?>
		</tr>
	</table>
</div>
	</td></tr>
<? include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>