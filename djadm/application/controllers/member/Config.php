<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->lists();
	}

	public function lists()
	{
		//$this->output->enable_profiler(TRUE);
		//$this->output->cache(1);	// 캐쉬는 분단위로 생성 함
		$this->load->helper(array("form", "date", "paging"));
		$this->load->model('member_m');
		$this->load->config("items/member_i", TRUE);	// 회원 관련 items 로드

		$aMemInfo = TRUE;

		// 검색어 초기화
		$sSearchKey = $this->input->post('sSearchKey', TRUE);
		$sSearchWord = $this->input->post('sSearchWord', TRUE);

		// 총 게시물 수
		$nTotalRow = $this->member_m->get_member_list('count', '', '', $sSearchKey, $sSearchWord);

		// 페이징 정보
		$aPagingInfo = getPagingList(6, $nTotalRow);

		//if (trim($this->uri->segment(4)) !== '')
		//	$aMemInfo = $this->member_m->get_member_info($this->uri->segment(4));

		$this->data += array(
			'pagination' 	=> $aPagingInfo['oPagination'],
			'nPage' 	=> $aPagingInfo['nPage'],
			'sSearchKey' 	=> $sSearchKey,
			'sSearchWord' => $sSearchWord,
			'aMemberItems'=> $this->config->item('aMemberItems', 'items/member_i'),
			'sCurrentClass'=> $this->router->directory . $this->router->class,
			'aMemInfo'	=> $aMemInfo,
			'list' 		=> $this->member_m->get_member_list('', $aPagingInfo['nStart'], $aPagingInfo['nLimit'], $sSearchKey, $sSearchWord)
		);

		$this->layout('member/list', $this->data);
	}

	/*public function loginAction()
	{
		// 폼 검증 라이브러리
		$this->load->library('form_validation');

		// 폼 검증
		$this->form_validation->set_rules('m_id', '아이디', 'required|alpha_numeric');
		$this->form_validation->set_rules('m_pw', '비밀번호', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$this->load->model("member_m");

			$aSearchInfo = array('sMId' => $this->input->post('m_id', TRUE), 'sMPw' => $this->input->post('m_pw', TRUE));
			$aResult = $this->member_m->get_member_info($aSearchInfo);

			if ($aResult)
			{
				$aResult['bLoginFlag'] = TRUE;

				$this->session->set_userdata($aResult);

				redirect($this->data['base_url'] . "main");
			}
			else
				alert("아이디와 비밀번호를 확인 하세요.", $this->data['base_url'] . "memberLogin");
		}
		else
			alert("아이디와 비밀번호를 확인 하세요.", $this->data['base_url'] . "memberLogin");
	}*/
}
