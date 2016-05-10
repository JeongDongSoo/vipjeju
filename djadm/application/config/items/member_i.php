<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['aMemberItems'] = array(
	'aRoleItems' => array(
		"ROLE_ST_DEVELOPER"	=> "개발자",
		"ROLE_ST_EMPLOYEE"	=> "<font color='#0033ff'>직원</font>",
		"ROLE_ST_MEMBER"	=> "회원"
	),
	'aSexItems' => array(
		"1"	=> "남",
		"2"	=> "여"
	),
	'aMailingItems' => array(
		"1"	=> "<font color='#0033ff'>수신</font>",
		"0"	=> "<font color='#ff0000'>미수신</font>"
	),
	'aBadItems' => array(
		"0"	=> "일반고객",
		"1"	=> "<font color='#ff0000'>불량고객</font>"
	)
);