<?
//include "$path/rentcar/inc/config_basic$url_tag.php"; //부가용품가격설정
include "/home/jejustarcokr/www/rentcar/inc/config_goods.php"; //야간배반차료
include "/home/jejustarcokr/www/rentcar/inc/config_rate.php";
include "/home/jejustarcokr/www/rentcar/inc/discount_set.php";
include "/home/jejustarcokr/www/rentcar/inc/insure_discount_set.php";

//$table_name = "rentcar_db";
//$rsv_table = "rentcar_rsv";
//$basic_table = "rentcar_basic";
//$dcrate_table = "rentcar_dcratio";

$w_name=array("일","월","화","수","목","금","토");
$permis_arr=array("1종대형","1종보통","2종보통","2종오토");	//면허종별
$licence_kind_arr=array('11'=>"1종보통",'12'=>"1종대형",'21'=>"2종면허");	//면허종별
$arrive1_arr=array("","없음","제주거주","전날도착","항공편미정","김포","인천","김해","대구","청주","광주","군산","순천","원주","울산","포항","여수","진주","부산항","목포항","녹동항","완도항");
$arrive2_arr=array("","없음","제주거주","다음날출발","항공편미정","김포","인천","김해","대구","청주","광주","군산","순천","원주","울산","포항","여수","진주","부산항","목포항","녹동항","완도항");

$a_kind=array("순서","소형1","소형2","중형1","중형2","고급1","고급2","승합1","승합2","승합3","SUV1","전연령","소형3","경유승용","소형4","중형3","중형4","중형5","중형6","중형7","중형8","중형9","오픈1","오픈2","고급3","고급4","승합4","승합5","승합6","승합7","SUV2","SUV3","수입1","SUV4","고급5","수입2","SUV5","소형5","경차1","경차2","경차3","출고예정");
$a_kind_arr=array(0,38,39,40,1,2,12,14,37,3,4,15,16,17,18,5,6,24,25,34,23,22,32,35,10,30,31,33,36,7,8,9,26,27,28); //보여지는 순서
$kind_title_arr=array('','경','소','중','고','SU','승','수','오','대'); //차량목록에 타이틀
$bgcolor_arr=array('F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD','F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD','F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD','F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD','F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD','F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD','F4FCEB','FDF1EA','ECF9F2','FBEAFD','FDFCEA','FFF7EE','EEFFFD');
$a_kia_type=array("스틱","오토");
$a_fuel_type=array("휘발유","LPG","경유", "휘발유/LPG");
$a_fuel_type_initial=array("휘","L","경");

$term_arr=array(24,30,36,48,54,60,72,78,84,96,102,108,120,126,132,144,150,156,168,174,180,192); //실제 계산되는 시간
$term_dp_arr=array(24,30,36,48,54,60,72,78,84,96); //표에 보여지는 시간
$state_color=array('gray','blue','green','black','red','red','red','red','blue','ff6600','gray','blue','red','green','gray','black'); //상태색상
$state_arr=array('','신청','접수','완료','취소','마감','오류','중복','부재','보류','','결제신청','결제취소','결제대기','','결제완료'); //예약상태
$rebate_state_arr=array('철회','취소요청','환불요청','접수','환불완료'); //환불신청 상태
$tax_state_arr=array('','대기','접수','발급','취소','오류'); //세금계산서 상태

$insure_time_arr=array('','1일'); //자차보험 계산일 
//$insure_time_arr=array('','1일','2일','3일','4일','5일','6일','7일','8일','9일','10일'); //자차보험 계산일 
$insure_season_arr=array("","전기간","","","","","","","","",""); 
//$insure_season_arr=array("","주중","","","주말","","","연휴","","성수기",""); 
$insure_season_color_arr=array("","666666","","","blue","","666666","blue","ff6600","red","");
$insure_super_arr=array("일반","비예약","완전");
//$fee_super_arr=array(0.7,0.8,1); //기간별 성절으로 대체
$insure_super_color_arr=array("green","red","blue");
//$insure_state_arr=array("주중","주말","연휴"); //자차보험 기간명(예전)

$a_goods_season=array("","주중","주말","연휴","준성수기","성수기","극성수기","준주중","준주말");
$a_goods_rsv_rate=array("50","70","90");
$a_goods_car_kind=array("경차/소형/중형","고급/수입","SUV/승합");
$a_outside_fuel_type=array("","LPG","경유/휘발유");

$show_room_arr=array(50); //Show Room
$driver_fee_arr=array('','50000','100000','150000','200000','250000'); //기사건예약 요금
$list_kind_arr=array("","경차","소형","중형","고급","","SUV","승합","수입","오픈"); //차종
$list_kind_name_arr=array("","경차","소형","중형","고급","","RV/SUV","승합","수입세단","수입오픈"); //차종(고객용)
$list_kind2_arr=array("","경차/소형/중형","고급/수입","SUV/승합"); //
$list_kind3_arr=array("","경차", "소형", "중형", "고급/수입", "SUV/승합"); //2011-08-30, By JDongS

$tel_add_rate=5; //추가할인율
$driver_age_cut=21; //운전가능나이
$super_insure_age=21; //완전면책나이
$super_insure_age_season=21; //완전면책나이(성수기)
$driver_age_cut_import=24; //수입차량나이
$driver_age_cut_import_season=24; //수입차량나이(성수기)

$a_rsv_point=5000;		//최초적립포인트
$a_use_point=10000;		//포인트사용단위
$a_point_limit=array(300,300,500,1000);	//등급별 총이용액(만원)
$a_point_rate=array(6,7,8,9);	//등급별 적립포인트
$a_point_state=array('최초','적립','사용');	//포인트 상태

// 회원 권한 등급
$level_array = array(0=>'<font color=blue>책임1</font>', 1=>'<font color=blue>책임2</font>', 2=>'<font color=blue>정직원</font>', 3=>'<font color=blue>수습</font>', 7=>'회원', 8=>'<font color=red>탈퇴신청</font>', 9=>'<font color=green>가입대기</font>');

// 갤럭시 탭 보험료 (2011-11-21, By JDongS)
$galtab_insure = 3000;

// 분실물 관리 처리상태
$property_status_array = array(1=>'신규', 2=>'미발견', 3=>'미확인', 8=>'부재 중', 4=>'발송예정', 5=>'발송완료', 6=>'전달완료', 7=>'전달예정', 9=>'철회');
$property_status_colors = array(1=>'', 2=>'#FF7DFF', 3=>'red', 8=>'#6e6e6e', 4=>'#00CC00', 5=>'blue', 6=>'#006666', 7=>'#7777ff', 9=>'#999999');

// 차량 불편신고 센터
$repair_state_array = array(1=>'신규', 2=>'확인 중', 3=>'정비 중', 4=>'처리 완료');
$repair_state_colors = array(1=>'', 2=>'#FF7DFF', 3=>'red', 4=>'blue');

// 거래처 관리
$customer_part_array = array('1'=>'개발', '2'=>'총무', '3'=>'인사', '4'=>'정비');
$customer_category_array = array('1'=>'건설', '2'=>'경찰서', '3'=>'고용지원', '4'=>'공업사/부품', '5'=>'공항', '6'=>'광고', '7'=>'금융/캐피탈', '8'=>'보험', '9'=>'주유소', '10'=>'조합', '11'=>'자동차', '12'=>'부동산', '13'=>'타 업체', '14'=>'기타');

// 인사기록 관리
$personage_gubun_array = array('A'=>'A 파트', 'B'=>'B 파트', 'C'=>'C 파트', 'D'=>'D 파트');
$personage_class_array = array(1=>'수습', 2=>'정직원', 8=>'선임', 3=>'주임', 4=>'대리', 5=>'과장', 6=>'부장', 7=>'이사');
$action_category_array = array(1=>'신규', 2=>'부서이동', 3=>'승진', 4=>'급여인상', 5=>'보너스', 6=>'강등', 7=>'퇴사');
$licence_result_array = array(1=>"<font color='blue'>유효</font>", 2=>"<font color='#ff0000'>정지</font>", 3=>"<font color='#ff0000'>취소</font>");
// 대표님, 인사팀장, 김진호주임, 서영진사원, 개발팀장만 접근 가능~~!!!!
$personage_manager_array = array('1306ssas', 'hohoho8512', 'existkiller', 'ppidols', 'eyekiss', 'jdongs79');

// 업무리스트 진행상황
$state_array = array(1=>'지연', 2=>'진행', 3=>'완료', 4=>'계속', 5=>'보류');

// 과태료 관리 리스트
$status_array = array('1'=>'처리예정', '2'=>'완료');
$gubun_array = array('1'=>'속도위반', '2'=>'신호위반', '3'=>'주정차위반');

$sex_array = array('1' => '남', '2'=>'여');
$license_arr=array('','초보','보통','능숙');
$drive_year_array = array('1' => '1년미만', '2' => '1년이상');
$pay_way_arr=array('','계좌이체','','온라인카드결제');
$a_site_code=array('홈페이지','투어','제주넷','좋은','동광','일반', '모바일', '페이스북');
$a_site_code_color=array('blue','ff6600','green','9900CC','green','red', 'green', '9900CC');

$fuel_rate_type_arr = array('','주간','야간','할인');
$fuel_rate_type_arr_tour = array('','관광<br>지원','야간<br>지원','야간<br>요금');

$a_car_color_name=array('흰색','검정','은색','다크그레이','진주','빨강','파랑','하늘','진녹색','연두','남색','오렌지','노랑','자주','핑크');
$a_car_color=array('ffffff','000000','aaaaaa','787878','fafaaa','ff0000','0000ff','5accff','006400','80e12a','3c5a91','ff8200','ffdc3c','a52a2a','FF80FF');

$a_option_cate=array('','편의사항','기본옵션','안전장치','영상음향','추가옵션'); 
$a_pay_way=array('','계좌이체','인수시 카드결제','이체후 카드결제','현장 현금결제');

$rentcar_insure_all_date=mktime(0,0,0,6,1,2010); //반납일 기준일(이전까지)
$rentcar_insure_all_fee_arr=array('','4000','5000','6000'); //렌트카 자차보험료 일괄적용

// 야간 추가 할인 적용 차량
$night_dis_rentcar = array('NF', 'NF8');

//보험료 적용율 색상
$a_color_rate=array('10','20','30','50','300');
$a_rate_color=array('gray','black','#FF00CC','ff6600','red');
$a_color_info=array('매우낮음','낮음','보통','높음','매우높음');

//자차적용율 색상
$a_pre_rate=array('','100','80','60'); //기준요금대비
$a_pre_rate_color=array('','999999','black','ff6600','red');
$a_pre_rate_info=array('','적절','보통','위험','부적절(접수불가)');
$a_rate_season=array("","주중","주말","놀토","연휴");

//접수차단기간
$a_break_season=array('연휴1','연휴2','주말3','주말4','주말5');

//성수기날짜설정
$busy_season_date1=mktime(0,0,0,7,22,2011);
$busy_season_date2=mktime(23,59,59,8,31,2011);

// 팝업 위치
$popup_positions = array('main' => '메인', 'reserve_list'=>'요금조회', 'reserve_form' => '예약단계', 'reserve_result' => '예약완료', 'wish_confirm' => '스타에게 바란다', 'malaise_confirm' => '불편신고센터');

// 할인기간 시즌 (max_key => 15)
$season_array = array('0'=>'비수기', '15'=>'비수기2', '1'=>'준비수기', '2'=>'시즌1', '3'=>'시즌2', '14'=>'시즌3', '4'=>'준성수기1', '5'=>'준성수기2', '11'=>'준성수기3', '6'=>'성수기1', '8'=>'성수기2', '12'=>'성수기3', '9'=>'극성수기1', '10'=>'극성수기2', '13'=>'극성수기3', '7'=>'자차무료');
$season_pre_array = array('price', 'semi', 'sea1', 'sea2', 'semi1_peak', 'semi2_peak', 'peak1', 'free', 'peak2', 'crowd1_peak', 'crowd2_peak', 'semi3_peak', 'peak3', 'crowd3_peak', 'sea3', 'slack2');
$season_color_array = array('#CEFFDB', '#D2D2FF', '#F9D1B7', '#F9D1B7', '#F9ACBA', '#F9ACBA', '#F9808E', '#6A6AFF', '#F9808E', '#FD6477', '#FD6477', '#F9ACBA', '#F9808E', '#FD6477', '#F9D1B7', '#CEFFDB');

//-- 사용안함 ---------------------------------------------------------------------------------------------//
//요금할인 적용 기간&시간
$fee_dc_time1=mktime(19,0,0,12,31,2009);
$fee_dc_time2=mktime(8,0,0,1,4,2010);
$fee_dc_hour1=0;
$fee_dc_hour2=0;
//특별요금
$term_sp_arr2=array(12,24,30,36); //특별요금시간(DB설정)
$term_sp_arr=array(12,24); //특별요금시간(적용)
$state_sp_arr=array("","주중","주말","연휴","성수기"); //특별요금 기간명
$sp_end_date=mktime(23,59,59,6,30,2008); //특별요금 계산기한 : 2007-11-15 적용

$a_poll_question = array(
'스타투어에서 예약시 렌터카 최대 30% 할인해주기 때문에',
'완전자차보험 가입 후 사고 발생시 수리비가 면제 되니까',
'보험료를 무료로 가입해 주니까',
'본사 시설이 잘 되어 있어서',
'연료를 가득 채워서 인수해 주기 때문에',
'최신형 네비게이션(파인 드라이브 7인치)을 무료로 주니까',
'취소시 수수료가 부과되지 않으니까',
'최신차량이 많아서',
'금연차량 이라서',
'전차량 MP3 CD 플레이어, 후방센서가 장착되어 있어서',
'포인트 최대 6% 적립을 해주기 때문에');

$okcash_season_arr = array("주중1","주중2","주말1","주말2","연휴1/성수기1","연휴2/성수기2");
//$okcash_season_arr = array("주중","주말","연휴/성수기"); //2008-11-18


?>