<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends MY_Model
{
	function __contruct()
	{
		parent::__contruct();
	}

	function get_member_info($aSearchInfo)
	{
		$this->getConnectionDB();

		if (isset($aSearchInfo['sMId']) && trim($aSearchInfo['sMId']) !== '' && isset($aSearchInfo['sMPw']) && trim($aSearchInfo['sMPw']) !== '')
			$sWhere = "m_id='" . $aSearchInfo['sMId'] . "' AND m_pw='" . $aSearchInfo['sMPw'] . "'";
		else if (isset($aSearchInfo['nMNo']) && trim($aSearchInfo['nMNo']) !== '')
			$sWhere = "m_no='" . $aSearchInfo['nMNo'] . "'";
		else
			return FALSE;

		$sql = "SELECT m_no AS nMNo, m_name AS sMName, m_hp AS nMHp, m_role AS sMRole FROM member WHERE " . $sWhere;
		$query  = $this->oMainDB->query($sql);

		return $query->row_array();
	}

	function get_member_list($sType='list', $nOffset='', $nLimit='', $sSearchKey='', $sSearchWord='')
	{
		$this->getConnectionDB();

		$sWhere = '';
		$sLimitQuery = '';

		if ($sSearchWord != '')
			$sWhere = ' WHERE ' . $sSearchKey . ' LIKE "%' . $sSearchWord . '%"';

		if ($nLimit != '' OR $nOffset != '')
			$sLimitQuery = " LIMIT " . $nOffset . ", " . $nLimit;

		$sql = "SELECT * FROM member " . $sWhere . " ORDER BY m_no" . $sLimitQuery;
		$query = $this->db->query($sql);

		$result = ($sType == 'count') ? $query->num_rows() : $query->result();

		return $result;
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