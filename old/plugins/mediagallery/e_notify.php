<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_notify.php                                     |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/defines.php");

include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_e_notify.php");

if (defined("ADMIN_PAGE") && ADMIN_PAGE === TRUE){
	$config_category = MG_NOTIFY_1;
	$config_events = array('mg_file' => MG_NOTIFY_2, "mg_category" => MG_NOTIFY_3);
}

if (!function_exists("notify_mg_file")){
	function notify_mg_file($data){
		global $nt;
		$message = sprintf(MG_NOTIFY_4, $data['name'])."<br />".sprintf(MG_NOTIFY_5, $data['user'], $data['ip'])."<br />";
		$nt->send("mg_file", MG_NOTIFY_6, $message);
	}
}

if (!function_exists("notify_mg_category")){
	function notify_mg_category($data){
		global $nt;
		$message = sprintf(MG_NOTIFY_7, $data['name'])."<br />".sprintf(MG_NOTIFY_8, USERNAME, $data['ip'])."<br />";
		$nt->send("mg_category", MG_NOTIFY_9, $message);
	}
}

?>