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
|     $Source: /cvsroot/e107/e107_0.7/e107_handlers/avatar_handler.php,v $
|     $Revision: 1.5 $
|     $Date: 2005/12/27 20:17:17 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

function avatar($avatar) {
	global $tp;
	if (stristr($avatar, "-upload-") !== FALSE) {
		return e_FILE."public/avatars/".str_replace("-upload-", "", $avatar);
	} else if (stristr($avatar, "Binary") !== FALSE) {
		$sqla = new db;
		preg_match("/Binary\s(.*?)\//", $avatar, $result);
		$sqla->db_Select("rbinary", "*", "binary_id='".$tp -> toDB($result[1])."' ");
		$row = $sqla->db_Fetch();
		 extract($row);
		return $binary_data;
	} else if (strpos($avatar, "http://") === FALSE) {
		return e_IMAGE."avatars/".$avatar;
	} else {
		return $avatar;
	}
}
	
?>