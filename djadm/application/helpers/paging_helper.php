<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/************************************************************************************************
 * 페이지네이션을 이용한 페이징 출력
 * Since : 2016-05-06
 * Version : 1.0.0
 * Param : int nUriSegment (페이지 번호가 위치한 세그먼트)
 	      int nTotalRow (게시물의 전체 개수)
 	      int nPerPage ( 한 페이지에 표시할 게시물 수)
 	      int nUseFixedPage (항상 고정된 수만큼 페이지 링크 출력)
 	      String sClassName (링크에 적용되는 class)
 * Return : aPagingInfo (페이지네이션 정보 배열) => array(페이지, 검색 시작 offset, limit 값, 페이징 링크)
 * Note :
 ************************************************************************************************/
function getPagingList($nUriSegment=6, $nTotalRow=1, $nPerPage=10, $nUseFixedPage=10, $sClassName='')
{
	// CI 객체의 리소스를 얻음
	$CI =& get_instance();

	// 페이지네이션 lib
	$CI->load->library('pagination');

	// 페이지네이션 설정
	$config['use_fixed_page'] = $nUseFixedPage;
	$config['total_rows'] = $nTotalRow;
	$config['per_page'] = $nPerPage;
	$config['uri_segment'] = $nUriSegment;
	if (trim($sClassName) !== '')
		$config['attributes'] = array('class' => $sClassName);

	// 페이지네이션 초기화
	$CI->pagination->initialize($config);

	// offset, limit 값 가져오기
	$nPage = $CI->uri->segment($config['uri_segment'], 1);
	if ($nPage > 1)
		$nStart = ($nPage / $config['per_page']) * $config['per_page'];
	else
		$nStart = ($nPage - 1) * $config['per_page'];

	$aPagingInfo = array(
		'nPage' 	=> $nPage,
		'nStart'		=> $nStart,
		'nLimit'		=> $config['per_page'],
		'oPagination'	=> $CI->pagination->create_links()	// 페이징 링크를 생성하여 view에서 사용할 변수에 할당
	);

	return $aPagingInfo;
}
/* End of file */