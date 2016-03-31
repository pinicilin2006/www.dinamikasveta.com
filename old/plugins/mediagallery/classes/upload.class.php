<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: classes/upload.class.php                         |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

if (function_exists("include_lan")){
	include_lan(dirname(__FILE__)."/../languages/".e_LANGUAGE."/lan_upload.class.php");
}

class Uploader{

	function UploadFile($File, $Dir){
		global $pref, $user, $admin;
		if ($File['error'] == 1){
			echo sprintf(MG_UPLOAD_CLASS_1, "php.ini", ini_get("upload_max_filesize"));
			return FALSE;
		}
		if ($File['error'] == 3 || $File['error'] == 4){
			echo MG_UPLOAD_CLASS_2;
			return FALSE;
		}
		if (!is_uploaded_file($File['tmp_name'])){
			echo MG_UPLOAD_CLASS_3;
			return FALSE;
		}
		if (is_numeric($pref['mg_upload_filesize']) && is_object($user) && $File['size'] > $pref['mg_upload_filesize']){
			echo MG_UPLOAD_CLASS_4;
			return FALSE;
		}
		$Name = str_replace("%20", "", str_replace("\\", "", str_replace("'", "", strtolower($File['name']))));
		if (is_object($admin)){
			if (!$admin->IsSupported($Name)){
				echo MG_UPLOAD_CLASS_5;
				return FALSE;
			}
		}else{
			if (!$user->IsSupported($Name)){
				echo MG_UPLOAD_CLASS_5;
				return FALSE;
			}
		}
		if (file_exists(realpath($Dir.$Name)) && is_file(realpath($Dir.$Name))){
			$Name = substr(time(), 6).$Name;
		}
		$DestinationFile = $Dir.$Name;
		$Uploaded['name'] = $Name;
		$Uploaded['size'] = $File['size'];
		if (!@move_uploaded_file($File['tmp_name'], $DestinationFile)){
			echo MG_UPLOAD_CLASS_6;
			return FALSE;
		}
		chmod($DestinationFile, octdec(666));
		if (!file_exists($DestinationFile) || !is_file($DestinationFile)){
			echo MG_UPLOAD_CLASS_7;
			return FALSE;
		}
		return $Uploaded;
	}

}

?>