<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->main();
	}

	public function main()
	{
		$this->layout('main', $this->data);
	}
}
