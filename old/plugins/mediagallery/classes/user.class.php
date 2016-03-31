<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: classes/user.class.php                           |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/main.class.php");

class User extends Main{

	function TempFreeSpace(){
		global $pref;
		if (is_numeric($pref['mg_wallpapers_tempsize']) && $this->GetDirSize(e_TEMP) >= $pref['mg_wallpapers_tempsize']){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function SendFile($File){
		set_time_limit(600);
		while (@ob_end_clean());
		$FileName = $File;
		$File = basename($File);
		if (is_file($FileName) && connection_status() == 0){
			if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
				$File = preg_replace("/\./", "%2e", $File, substr_count($File, ".") - 1);
			}
			if (isset($_SERVER['HTTP_RANGE'])){
				$Seek = intval(substr($_SERVER['HTTP_RANGE'], strlen("bytes=")));
			}
			$BufferSize = 2048;
			ignore_user_abort(TRUE);
			$DataLength = filesize($FileName);
			if ($Seek > ($DataLength - 1)){
				$Seek = 0;
			}
			$Res =& fopen($FileName, "rb");
			if ($Seek){
				fseek($Res, $Seek);
			}
			$DataLength -= $Seek;
			header("Expires: 0");
			header("Cache-Control: max-age=30" );
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=\"".$File."\"");
			header("Content-Length: ".$DataLength);
			header("Pragma: public");
			if ($Seek){
				header("Accept-Ranges: bytes");
				header("HTTP/1.0 206 Partial Content");
				header("status: 206 Partial Content");
				header("Content-Range: bytes ".$Seek."-".($DataLength - 1)."/".$DataLength);
			}
			while (!connection_aborted() && $DataLength > 0){
				echo fread($Res, $BufferSize);
				$DataLength -= $BufferSize;
			}
			fclose($Res);
		}else{
			header("Location: ".e_BASE."index.php");
			exit;
		}
	}

}

?>