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
|     $Source: /cvsroot/e107/e107_0.7/e107_handlers/secure_img_handler.php,v $
|     $Revision: 1.9 $
|     $Date: 2006/10/16 22:46:52 $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

class secure_image {
	var $random_number;

	function secure_image() {
		list($usec, $sec) = explode(" ", microtime());
		$this->random_number = str_replace(".", "", $sec.$usec);
	}

	function create_code() {
		global $pref, $sql, $IMAGES_DIRECTORY, $HANDLERS_DIRECTORY;

		require_once('e107_class.php');
		$e107 = new e107(false, false);
		$e107->set_paths();

		$imgpy = str_replace($HANDLERS_DIRECTORY, "", $e107->file_path);

		$imgp = $imgpy.$IMAGES_DIRECTORY;
		mt_srand ((double)microtime() * 1000000);
		$maxran = 1000000;
		$rand_num = mt_rand(0, $maxran);
		$datekey = date("r");
		$rcode = hexdec(md5($_SERVER['HTTP_USER_AGENT'] . serialize($pref). $rand_num . $datekey));
		$code = substr($rcode, 2, 6);
		$recnum = $this->random_number;
		$del_time = time()+1200;
		$sql->db_Insert("tmp", "'{$recnum}',{$del_time},'{$code},{$imgp}'");
		return $recnum;
	}

	function verify_code($rec_num, $checkstr) {
		global $sql, $tp;
		if ($sql->db_Select("tmp", "tmp_info", "tmp_ip = '".$tp -> toDB($rec_num)."'")) {
			$row = $sql->db_Fetch();
			$sql->db_Delete("tmp", "tmp_ip = '".$tp -> toDB($rec_num)."'");
			list($code, $path) = explode(",", $row[0]);
			return ($checkstr == $code);
		}
		return FALSE;
	}

	function r_image() {
		global $HANDLERS_DIRECTORY;
		$code = $this->create_code();
		return "<img src='".e_BASE.$HANDLERS_DIRECTORY."secure_img_render.php?{$code}' alt='' />";
	}
}
?>
