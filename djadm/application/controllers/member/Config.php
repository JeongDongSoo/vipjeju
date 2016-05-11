<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('member_m');
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
		$this->load->config("items/member_i", TRUE);	// 회원 관련 items 로드

		$aMemInfo = FALSE;

		// 검색어 초기화
		$sSearchKey = $this->input->post('sSearchKey', TRUE);
		$sSearchWord = $this->input->post('sSearchWord', TRUE);

		// 총 게시물 수
		$nTotalRow = $this->member_m->get_member_list('count', '', '', $sSearchKey, $sSearchWord);

		// 페이징 정보
		$aPagingInfo = getPagingList(5, $nTotalRow);

		if (trim($this->uri->segment(6)) !== '')
			$aMemInfo = $this->uri->segment(6) !== 'insert' ? $this->member_m->get_member_info($this->uri->segment(6)) : TRUE;

		$this->data += array(
			'pagination' 	=> $aPagingInfo['oPagination'],
			'nPage' 	=> $aPagingInfo['nPage'],
			'sSearchKey' 	=> $sSearchKey,
			'sSearchWord'=> $sSearchWord,
			'aMemberItems'=> $this->config->item('aMemberItems', 'items/member_i'),
			'sCurrentClass'=> $this->data['sBaseUrl'] . $this->router->directory . $this->router->class,
			'aMemInfo'	=> $aMemInfo,
			'list' 		=> $this->member_m->get_member_list('', $aPagingInfo['nStart'], $aPagingInfo['nLimit'], $sSearchKey, $sSearchWord)
		);

		$this->layout('member/list', $this->data);
	}

	public function action()
	{
		$this->output->enable_profiler(TRUE);

		$action_array = array(
			'm_name'	=> $this->input->post('m_name', TRUE),
			'm_sex'	=> $this->input->post('m_sex', TRUE),
			'm_phone'	=> $this->input->post('m_phone', TRUE),
			'm_hp'		=> $this->input->post('m_hp', TRUE),
			'm_email'	=> $this->input->post('m_email', TRUE),
			'm_role'	=> $this->input->post('m_role', TRUE),
			'm_etc_descr'	=> $this->input->post('m_etc_descr', TRUE)
		);

		if ($this->input->post('m_pw', TRUE) !== '')
			$action_array['m_pw'] = crypt($this->input->post('m_pw', TRUE), PASS_SALT);
		if ($this->input->post('m_second_pw', TRUE) !== '')
			$action_array['m_second_pw'] = crypt($this->input->post('m_second_pw', TRUE), PASS_SALT);
		if ($action_array['m_role'] === '9')
			$action_array['m_leave_datetime'] = date('Y-m-d H:i:s');

		if ($this->input->post('m_no', TRUE) === '')
		{
			$sActionStr = "등록";
			$action_array['m_id'] = $this->input->post('m_id', TRUE);
			$action_array['m_no'] = $this->member_m->get_max_mNo();
			$bQueryFlag = $this->member_m->insert_member($action_array);
		}
		else
		{
			$sActionStr = "수정";
			$action_array['m_no'] = $this->input->post('m_no', TRUE);
			$bQueryFlag = $this->member_m->update_member($action_array);
		}

		$sListUrl = $this->data['sBaseUrl'] . $this->router->directory . $this->router->class . '/lists/page/' . $this->input->post('nPage', TRUE);
	//echo $sActionStr;
		if ($bQueryFlag)
			alert("회원 정보를 " . $sActionStr . "했습니다.", $sListUrl);
		else
			alert("회원 정보 " . $sActionStr . "에 실패했습니다.", $sListUrl . "/" . $this->input->post('m_no', TRUE));
	}

	public function chkDuplicateId()
	{
		$chkNum = $this->member_m->chk_member_id($this->input->post('sMId', TRUE));

		$this->show_json(array('nDuplNum' => $chkNum));
		exit;
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
