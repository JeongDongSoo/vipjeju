<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends MY_Model
{
	function __contruct()
	{
		parent::__contruct();
	}

	function chk_member_id($sMId)
	{
		$this->getConnectionDB();

		$query = $this->db->where("m_id='" . $sMId . "'")
					->get('member');

		return $query->num_rows();
	}

	function get_login_info($aSearchInfo)
	{
		$this->getConnectionDB();

		if (isset($aSearchInfo['sMId']) && trim($aSearchInfo['sMId']) !== '' && isset($aSearchInfo['sMPw']) && trim($aSearchInfo['sMPw']) !== '')
			$sWhere = " AND m_id='" . $aSearchInfo['sMId'] . "' AND m_pw='" . $aSearchInfo['sMPw'] . "'";
		else if (isset($aSearchInfo['nMNo']) && trim($aSearchInfo['nMNo']) !== '')
			$sWhere = " AND m_no='" . $aSearchInfo['nMNo'] . "'";
		else
			return FALSE;

		$query = $this->db->select("m_no AS nMNo, m_name AS sMName, m_hp AS nMHp, m_role AS sMRole")
					->where("m_role < 9 " . $sWhere)
					->get('member');

		return $query->row_array();
	}

	function get_member_info($nMNo)
	{
		$this->getConnectionDB();

		$query = $this->db->where("m_no=" . $nMNo)
					->get('member');

		return $query->row_array();
	}

	function get_max_mNo()
	{
		$this->getConnectionDB();

		$query = $this->db->select_max('m_no', 'nMaxMNo')
					->where("LEFT(m_no, 8)=" . date('Ymd'))
					->get('member');
		$fetch = $query->row_array();

		$nMNo = ($fetch['nMaxMNo'] !== FALSE) ? substr($fetch['nMaxMNo'], -4) + 1 : 1;

		return date('Ymd') . str_repeat('0', 4 - strlen($nMNo)) . $nMNo;
	}

	function get_member_list($sType='list', $nOffset='', $nLimit='', $sSearchKey='', $sSearchWord='')
	{
		$this->getConnectionDB();

		$sWhere = '';
		$sLimitQuery = '';

		if ($sSearchWord != '')
			$sWhere = ' AND ' . $sSearchKey . ' LIKE "%' . $sSearchWord . '%"';

		$query = $this->db->where("m_role=2 " . $sWhere)
					->get('member', $nLimit, $nOffset);

		$result = ($sType == 'count') ? $query->num_rows() : $query->result();

		return $result;
	}

	function insert_member($arrays)
	{
		return $this->db->insert('member', $arrays);
	}

	function update_member($arrays)
	{
		return $this->db->update('member', $arrays, array('m_no' => $arrays['m_no']));
	}

	/*function get_view($table, $id)
	{
		// 조회수 증가
		$sql0 = "UPDATE " . $table . " SET hits=hits+1 WHERE board_id='" . $id . "'";
		$this->db->query($sql0);

		$sql = "SELECT * FROM " . $table . " WHERE board_id='" . $id . "'";
		$query = $this->db->query($sql);

		$result = $query->row();

		return $result;
	}

	function insert_board($arrays)
	{
		$insert_arary = array(
			'board_pid'	=> 0,
			'user_id'	=> 'advisor',
			'user_name'	=> '답부',
			'subject'	=> $arrays['subject'],
			'contents'	=> $arrays['contents'],
			'reg_date'	=> date('Y-m-d H:i:s')
		);

		return $this->db->insert($arrays['table'], $insert_arary);
	}

	function modify_board($arrays)
	{
		$modify_arary = array(
			'subject'	=> $arrays['subject'],
			'contents'	=> $arrays['contents']
		);

		$where_array = array(
			'board_id'	=> $arrays['board_id']
		);

		return $this->db->update($arrays['table'], $modify_arary, $where_array);
	}

	function delete_content($table, $board_id)
	{
		$where_array = array(
			'board_id'	=> $board_id
		);

		return $this->db->delete($table, $where_array);
	}*/
}