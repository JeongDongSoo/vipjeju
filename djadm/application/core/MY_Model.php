<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	protected $oMainDB = false; // = $this->load->database('default', true);
	protected $oSmsDB = false; // = $this->load->database('sms', true);

	public function __construct()
	{
		parent::__construct();
	}

	public function __destruct()
	{
		if ($this->db !== false)
			$this->db->close();

		if ($this->oMainDB !== false)
			$this->oMainDB->close();

		if ($this->oSmsDB !== false)
			$this->oSmsDB->close();
	}

	protected function getConnectionDB($sType = 'default')
	{
		if ($sType == 'default')
			$conn = 'oMainDB';
		else if ($sType == 'sms')
			$conn = 'oSmsDB';

		if ($this->{$conn} === false)
		{
			$this->db = $this->load->database($sType, true);
			$this->{$conn} = $this->load->database($sType, true);
		}

		return $this->db;
	}
}