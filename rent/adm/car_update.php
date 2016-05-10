<? 
define('G5_IS_ADMIN', true);
include_once ('../../include/common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once "../inc/config.php";

//사진업로드
if($mode=='insert' || $mode=='update') {

	$upload_file_size=300; //업로드 파일용량 제한(단위:MB)
	$upload_file_size_byte=$upload_file_size*1024;
		
	$tmp_file  = $_FILES[car_photo][tmp_name];
	$filename  = $_FILES[car_photo][name];
	$filesize  = $_FILES[car_photo][size];

	$file_upload_msg="";

	// 서버에 설정된 값보다 큰파일을 업로드 한다면
	if ($filename) {
		if ($_FILES[car_photo][error] == 1) {
			$file_upload_msg .= "\'{$filename}\' 파일의 용량이 서버에 설정($upload_max_filesize)된 값보다 크므로 업로드 할 수 없습니다.\\n";
		} else if ($_FILES[car_photo][error] != 0) {
			$file_upload_msg .= "\'{$filename}\' 파일이 정상적으로 업로드 되지 않았습니다.\\n";
		}
	}

	if (is_uploaded_file($tmp_file)) {
		if ($filesize > $upload_file_size_byte) {
			$file_upload_msg .= "\'{$filename}\' 파일의 용량(".number_format($filesize)." Byte)이 설정(".number_format($upload_file_size_byte)." Byte)된 값보다 크므로 업로드 하지 않습니다.\\n";
		}

		$timg = @getimagesize($tmp_file);
		// image type
		if ( preg_match("/\.($config[cf_image_extension])$/i", $filename) ||
			 preg_match("/\.($config[cf_flash_extension])$/i", $filename) ) 
		{
			if ($timg[2] < 1 || $timg[2] > 16)
			{
				$file_upload_msg .= "\'{$filename}\' 파일이 이미지나 플래시 파일이 아닙니다.\\n";
			}
		}
		if ($file_upload_msg) {
			alert($file_upload_msg, "car_form.php"); 
			exit;
		}
		//=================================================================

		$upload[image] = $timg;

		// 프로그램 원래 파일명
		$upload[source] = $filename;
		$upload[filesize] = $filesize;

		// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
		$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

		shuffle($chars_array);
		$shuffle = implode("", $chars_array);

		// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다.
		//$filename = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));
		$filename = str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));
		$dest_file = "../photo/".$filename;

		$tmp_no=0;
		do {
			if($tmp_no>0) { 
				$filename_arr=explode(".",$filename);
				$filename_tmp="";
				for($i=0; $i<sizeof($filename_arr); $i++) {
					if($i==sizeof($filename_arr)-1) $filename_tmp.="_".$tmp_no;
					if($i>0) $filename_tmp.=".";
					$filename_tmp.=$filename_arr[$i];
				}
				$dest_file = "../photo/".$filename_tmp;
			}
			$tmp_no++;
		} while(file_exists($dest_file));
		if($filename_tmp) { $filename=$filename_tmp; }

		// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
		$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES[car_photo][error]);

		// 올라간 파일의 퍼미션을 변경합니다.
		chmod($dest_file, 0606);
	}

	if($filename && $old_car_photo) {
		unlink("../photo/".$old_car_photo);
	}
	if($filename) {
		$sql_str.=", car_photo='$filename'";
	}
	
	$car_option_val=implode("|",$car_option);
	$w_staff=$member['mb_name'];
	$w_time=time();
}

if($mode=='insert') {

	$que="insert into rc_car values ('','$kind_code','$corp_code','$car_name','$car_code','$gear_type','$displacement','$fuel_type','$fuel_fee','$fuel_rate','$car_wheel','$buy_price','$car_maker','$seater','$made_year','$car_sort','$main_sort','$h1_fee','$h6_fee','$h12_fee','$h24_fee','$keep_car','$drive_age','$drive_year','$car_insure1','$car_insure2','$car_insure3','$car_option_val','$filename','$car_state','$w_staff','$w_time')";
	if(!sql_query($que)) { echo"저장 오류<br>$que"; exit; }
	goto_url('car_list.php');
}

if($mode=='update') {

	$que="update rc_car set kind_code='$kind_code', corp_code='$corp_code', car_name='$car_name', car_code='$car_code', gear_type='$gear_type', displacement='$displacement', fuel_type='$fuel_type', fuel_fee='$fuel_fee', fuel_rate='$fuel_rate', car_wheel='$car_wheel', buy_price='$buy_price', car_maker='$car_maker', seater='$seater', made_year='$made_year', car_sort='$car_sort', main_sort='$main_sort', h1_fee='$h1_fee', h6_fee='$h6_fee', h12_fee='$h12_fee', h24_fee='$h24_fee', keep_car='$keep_car', drive_age='$drive_age', drive_year='$drive_year', car_insure1='$car_insure1', car_insure2='$car_insure2', car_insure3='$car_insure3', car_option='$car_option_val', car_state='$car_state', w_staff='$w_staff', w_time='$w_time' $sql_str where car_no='$car_no'";
	if(!sql_query($que)) { echo"저장 오류<br>$que"; exit; }
	
	alert('수정되었습니다.','car_list.php');
}

if($mode=='del' || $mode=='del2') {

	if (isset($_GET['car_no']))
	{
		$dque="delete from rc_car where car_no='" . $_GET['car_no'] . "'";
		if(!mysql_query($dque)) { echo"렌트카 삭제 오류<br>$dque"; exit; }

		$dque="delete from rentcar_insure where car_id='" . $_GET['car_no'] . "'";
		if(!mysql_query($dque)) { echo"보험료 삭제 오류<br>$dque"; exit; }
	}

	alert('삭제되었습니다.','car_list.php');
}
