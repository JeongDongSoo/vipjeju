<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $sRequestMethod;

	var $data = array();

	public function __construct()
	{
		parent::__construct();

		$this->data['sBaseUrl'] = $this->uri->config->config['base_url'];

		if ($this->uri->segment(2) !== "login" && @$this->session->userdata['bLoginFlag'] !== TRUE)
			alert("접속 시간이 종료 되었습니다.", $this->data['sBaseUrl'] . "member/login");

		header('Content-Type: text/html; charset=utf-8');

		$this->sRequestMethod = $_SERVER["REQUEST_METHOD"];
	}

	public function layout($sContentView='') {
		//header 사용자 정보 변경 후 바로 적용
		if (@$this->session->userdata['bLoginFlag'] === TRUE)
		{
			$this->load->model('member_m');

			$aSearchInfo['nMNo'] = $this->session->userdata['nMNo'];
			$aResult = $this->member_m->get_member_info($aSearchInfo);

			$this->session->set_userdata($aResult);
		}

		$this->load->view('header_v', $this->data);

		if (trim($sContentView) === '') $sContentView = $this->router->directory . $this->router->class . '/' . $this->router->method;
		$this->load->view($sContentView . "_v", $this->data);

		$this->load->view('footer_v', $this->data);
	}
}
