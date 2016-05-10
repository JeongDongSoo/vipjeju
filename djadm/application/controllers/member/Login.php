<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
	//	$this->output->enable_profiler(TRUE);
		$this->load->helper("form");

		$this->layout('member/login', $this->data);
	}

	public function loginAction()
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
			$aResult = $this->member_m->get_login_info($aSearchInfo);

			if ($aResult)
			{
				$aResult['bLoginFlag'] = TRUE;

				$this->session->set_userdata($aResult);

				redirect($this->data['sBaseUrl'] . "main");
			}
			else
				alert("아이디와 비밀번호를 확인 하세요.", $this->data['sBaseUrl'] . "member/login");
		}
		else
			alert("아이디와 비밀번호를 확인 하세요.", $this->data['sBaseUrl'] . "member/login");
	}

	public function logout()
	{
		$this->session->sess_destroy();

		alert("로그 아웃 되었습니다.", $this->data['sBaseUrl'] . "member/login");
	}
}
