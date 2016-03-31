<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/content/e_notify.php,v $
|     $Revision: 1.1 $
|     $Date: 2006/06/07 13:37:21 $
|     $Author: lisa_ $
+----------------------------------------------------------------------------+
*/

$lan_file = e_PLUGIN."content/languages/".e_LANGUAGE."/lan_content.php";
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."content/languages/English/lan_content.php");

$config_category = CONTENT_NOTIFY_LAN_1;
$config_events = array('content' => CONTENT_NOTIFY_LAN_2);

if (!function_exists('notify_content')) {
	function notify_content($data) {
		global $nt;
		foreach ($data as $key => $value) {
			$message .= $key.': '.$value.'<br />';
		}
		$nt -> send('content', CONTENT_NOTIFY_LAN_3, $message);
	}
}

?>