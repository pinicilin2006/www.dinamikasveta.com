<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: classes/main.class.php                           |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

if (function_exists("include_lan")){
	include_lan(dirname(__FILE__)."/../languages/".e_LANGUAGE."/lan_main.class.php");
}

class Main{

	function RenderAlert($Text, $Location){
		if (!$Location){
			$Action = "window.history.go(-1)";
		}elseif ($Location == "close"){
			$Action = "window.close()";
		}else{
			$Action = "window.location.href=\"".$Location."\"";
		}
		$Text = strtr($Text, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));
		echo "<noscript>".MG_MAIN_CLASS_1."</noscript><script type='text/javascript'>alert(\"".$Text."\");".$Action.";</script>";
		exit;
	}

	function RenderRedirect($Location){
		echo "<noscript>".MG_MAIN_CLASS_1."</noscript><script type='text/javascript'>window.location.href=\"".$Location."\";</script>";
		exit;
	}

	function RenderRedirectOnClick($Location){
		return "window.location.href=\"".$Location."\"";
	}

	function RenderConfirmOnClick($Text){
		$Text = strtr($Text, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));
		return "return confirm(\"".$Text."\")";
	}

	function IsSupported($File, $Type = "MgFilesList"){
		global $MgImageList, $MgVideoList, $MgAudioList, $MgFilesList;
		$Ext = $this->GetExtension($File);
		return in_array($Ext, $$Type);
	}
	
	function IsValidURL($URL){
		if (preg_match("/^http[s]?:\/\/.+\/.+$/", $URL)){
			return $URL;
		}elseif (preg_match("/^ftp:\/\/.+\/.+$/", $URL)){
			return $this->FixFtpURL($URL);
		}
		return FALSE;
	}
	
	function IsValidName($File){
		return !preg_match("/[".chr(127)."-".chr(255)."]/", $File);
	}

	function GetExtension($File){
		return substr(strrchr(strtolower($File), "."), 1);
	}

	function CheckGD(){
		global $pref;
		if ($pref['mg_check_gd']){
			if (strpos(e_PAGE, "admin_") !== FALSE){
				if (!extension_loaded("gd")){
					$this->RenderAlert(MG_MAIN_CLASS_2, e_GALLERY."admin_browse.php");
				}elseif (!(imagetypes() & IMG_GIF)){
					$this->RenderAlert(sprintf(MG_MAIN_CLASS_3, "GIF"), e_GALLERY."admin_browse.php");
				}elseif (!(imagetypes() & IMG_JPG)){
					$this->RenderAlert(sprintf(MG_MAIN_CLASS_3, "JPG"), e_GALLERY."admin_browse.php");
				}elseif (!(imagetypes() & IMG_PNG)){
					$this->RenderAlert(sprintf(MG_MAIN_CLASS_3, "PNG"), e_GALLERY."admin_browse.php");
				}
			}else{
				if (!extension_loaded("gd") || !(imagetypes() & IMG_GIF) || !(imagetypes() & IMG_JPG) || !(imagetypes() & IMG_PNG)){
					$this->RenderAlert(MG_MAIN_CLASS_4);
				}
			}
		}
	}

	function CheckDirPerms(){
		global $pref;
		if ($pref['mg_check_dirs']){
			clearstatcache();
			for ($I = 0; $I < func_num_args(); $I++){
				$Dir = func_get_arg($I);
				if (!is_readable($Dir) || !is_writable($Dir)){
					if (strpos(e_PAGE, "admin_") !== FALSE){
						$this->RenderRedirect(e_GALLERY."admin_dmanager.php");
					}else{
						$this->RenderAlert(MG_MAIN_CLASS_5);
					}
				}
			}
		}
	}

	function CheckURL(){
		global $pref;
		if ($pref['mg_check_url']){
			if (!ini_get("allow_url_fopen")){
				if (strpos(e_PAGE, "admin_") !== FALSE){
					$this->RenderAlert(MG_MAIN_CLASS_20, e_GALLERY."admin_browse.php");
				}else{
					$this->RenderAlert(MG_MAIN_CLASS_21);
				}
			}
		}
	}

	function FixFtpURL($URL){
		global $pref, $tp;
		if ($pref['mg_ftp_login'] && !preg_match("/^ftp:\/\/.+:.+@.+$/", $URL)){
			$URL = str_replace("ftp://", "ftp://".rawurlencode($tp->toText($pref['mg_ftp_login'])).":".rawurlencode($tp->toText($pref['mg_ftp_password']))."@", $URL);
		}
		return $URL;
	}
	
	function GetThumbName($Name){
		return preg_replace("/^(.+)(\.[a-z]{2,4})$/i", "\\1_thumb\\2", $Name);
	}

	function GetImagePath($Row){
		if ($this->IsValidURL($Row['img_image']) || file_exists(realpath(e_IMAGES.$Row['img_image']))){
			return e_GALLERY."showimage.php?".$Row['img_id'];
		}
		return FALSE;
	}
	
	function GetMediaPath($Row){
		if ($this->IsValidName($Row['img_image'])){
			if ($URL = $this->IsValidURL($Row['img_image'])){
				return $URL;
			}elseif (file_exists(realpath(e_MEDIA.$Row['img_image']))){
				return e_MEDIA.$Row['img_image'];
			}
		}else{
			if ($this->IsValidURL($Row['img_image']) || file_exists(realpath(e_MEDIA.$Row['img_image']))){
				return e_GALLERY."showimage.php?".$Row['img_id'];
			}
		}
		return FALSE;
	}
	
	function GetFilePath($File, $Dir, $Mode = "abs"){
		global $MgFilesList;
		if ($URL = $this->IsValidURL($File)){
			return $URL;
		}elseif (in_array($File, $MgFilesList)){
			return e_GALLERY."images/thumbs/".$File."_thumb.png";
		}elseif (file_exists(realpath($Dir.$File))){
			if ($Mode == "abs"){
				return str_replace(array("\\\\", "\\"), "/", realpath($Dir.$File));
			}else{
				return $Dir.$File;
			}
		}else{
			return e_GALLERY."images/errors/no_image.png";
		}
	}
	
	function GetMimeType($File){
		$Ext = $this->GetExtension($File);
		switch ($Ext){
			case "png":  return "image/png";
			case "gif":  return "image/gif";
			case "jpg":  return "image/jpeg";
			case "jpeg": return "image/jpeg";
			case "bmp":  return "image/bmp";
			case "mp3":  return "audio/mpeg";
			case "wav":  return "audio/x-wav";
			case "wma":  return "audio/x-ms-wma";
			case "m4a":  return "audio/x-m4a";
			case "ra":   return "audio/x-pn-realaudio";
			case "avi":  return "video/x-msvideo";
			case "wmv":  return "video/x-ms-wmv";
			case "mov":  return "video/quicktime";
			case "swf":  return "application/x-shockwave-flash";
			case "mpg":  return "video/mpeg";
			case "mpeg": return "video/mpeg";
			case "divx": return "video/divx";
			case "asx":  return "video/x-ms-asf";
			case "rv":   return "audio/x-pn-realaudio";
		}
	}

	function RenderImageInfo($Row){
		$con = new convert;
		$Type = $this->GetExtension($Row['img_image']);
		$Datestamp = $con->convert_date($Row['img_datestamp'], "short");
		$Size = $Row['img_size'] == 0 ? MG_MAIN_CLASS_6 : $this->ReturnSize($Row['img_size']);
		$Author = preg_replace("/^[0-9]+\./", "", $Row['img_author']);
		return sprintf(MG_MAIN_CLASS_7, $Type)."\n".sprintf(MG_MAIN_CLASS_8, $Author)."\n".sprintf(MG_MAIN_CLASS_9, $Datestamp)."\n".sprintf(MG_MAIN_CLASS_10, $Row['img_width'], $Row['img_height'])."\n".sprintf(MG_MAIN_CLASS_11, $Size);
	}

	function RenderMediaInfo($Row){
		$con = new convert;
		$Type = $this->GetExtension($Row['img_image']);
		$Datestamp = $con->convert_date($Row['img_datestamp'], "short");
		$Size = $Row['img_size'] == 0 ? MG_MAIN_CLASS_6 : $this->ReturnSize($Row['img_size']);
		$Author = preg_replace("/^[0-9]+\./", "", $Row['img_author']);
		return sprintf(MG_MAIN_CLASS_7, $Type)."\n".sprintf(MG_MAIN_CLASS_8, $Author)."\n".sprintf(MG_MAIN_CLASS_9, $Datestamp)."\n".sprintf(MG_MAIN_CLASS_11, $Size);
	}

	function RenderCategoryInfo($Row){
		$con = new convert;
		$Datestamp = $con->convert_date($Row['cat_datestamp'], "short");
		$LastFile = ($Row['cat_last'] ? $con->convert_date($Row['cat_last'], "short") : MG_MAIN_CLASS_12);
		$Size = $this->ReturnSize($Row['cat_size']);
		$Author = preg_replace("/^[0-9]+\./", "", $Row['cat_author']);
		return sprintf(MG_MAIN_CLASS_11, $Size)."\n".sprintf(MG_MAIN_CLASS_8, $Author)."\n".sprintf(MG_MAIN_CLASS_13, $Datestamp)."\n".sprintf(MG_MAIN_CLASS_14, $LastFile);
	}

	function GetFileSize($File){
		return sprintf("%u", filesize($File)); // Для корректной обработки файлов размером от 2 до 4 гб
	}

	function GetDirSize($Directory){
		$Size = 0;
		$Dir = @opendir(realpath($Directory));
		while ($File = @readdir($Dir)){
			$Path = $Directory.$File;
			if ($File != "." && $File != ".." && is_dir($Path)){
				$Size += $this->GetDirSize($Path."/");
				continue;
			}elseif ($this->IsSupported($File)){
				$Size += $this->GetFileSize($Path);
			}
		}
		@closedir($Dir);
		return $Size;
	}

	function ReturnSize($Bytes, $Field = FALSE){
		$SizeNames = array(" ".MG_MAIN_CLASS_15, " ".MG_MAIN_CLASS_16, " ".MG_MAIN_CLASS_17, " ".MG_MAIN_CLASS_18, " ".MG_MAIN_CLASS_19);
		$SizeFieldNames = array("", "K", "M", "G", "T");
		return round($Bytes/pow(1024, ($I = floor(log($Bytes, 1024)))), 2).($Field ? $SizeFieldNames[$I] : $SizeNames[$I]);
	}

	function ReturnBytes($Size){
		$Size = trim($Size);
		$Modifier = strtolower($Size{strlen($Size)-1});
		switch ($Modifier){
			case "t": $Size *= 1024;
			case "g": $Size *= 1024;
			case "m": $Size *= 1024;
			case "k": $Size *= 1024;
		}
		return $Size;
	}

}

?>