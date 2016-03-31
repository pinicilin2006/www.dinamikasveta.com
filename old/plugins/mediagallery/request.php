<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: request.php                                      |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем необходимые файлы
require(dirname(__FILE__)."/user.php");

// Получаем информацию по ссылке
$MgMode = strip_tags($Tmp[0]);
$MgId = intval($Tmp[1]);
$MgRes = @unserialize(rawurldecode($Tmp[2]));
unset($Tmp);

// Проверяем состояние директорий
$user->CheckDirPerms(e_MEDIA, e_IMAGES, e_TEMP);

// Проверка состояния библиотеки GD
$user->CheckGD();

// Проверка возможности работы с URL-файлами
$user->CheckURL();

// Обрабатываем файл
if ($sql->db_Select_gen("SELECT i.* FROM #mg_images i LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id) WHERE i.img_id = '".$MgId."' AND c.cat_class_view IN (".USERCLASS_LIST.")")){
	$row = $sql->db_Fetch();
	if ($MgMode == "download"){
		if (!$pref['mg_view_download']){
			$user->RenderAlert(MG_REQUEST_1, "close");
		}
		if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
			if (!$user->TempFreeSpace()){
				$user->RenderAlert(MG_REQUEST_9);
			}
			$File = $user->GetFilePath($row['img_image'], e_IMAGES);
			if (strpos($File, "no_image.png") !== FALSE){
				$user->RenderAlert(MG_REQUEST_2, "close");
			}
			$Ext = $user->GetExtension($File);
			$TempFile = e_TEMP."Image_".$row['img_id'].".".$Ext;
			if ($pref['mg_protect_files'] && $pref['mg_mode_prof']){
				require(e_GALLERY."classes/protect.class.php");
				$res = new Protector;
				$Protect = TRUE;
			}else{
				require(e_GALLERY."classes/resize.class.php");
				$res = new Resizer;
				$Protect = FALSE;
			}
			$res->ResizeImage($File, $TempFile, $row['img_width'], $row['img_height'], $Protect);
			$user->SendFile($TempFile);
			@unlink($TempFile);
		}else{
			$File = $user->GetFilePath($row['img_image'], e_MEDIA);
			if (strpos($File, "no_image.png") !== FALSE){
				$user->RenderAlert(MG_REQUEST_2, "close");
			}
			if ($user->IsValidURL($File)){
				header("Location: ".$File);
			}else{
				$user->SendFile($File);
			}
		}
	}elseif ($MgMode == "external"){
		if (!$row['img_email_print'] || ($row['img_type'] != "video" && $row['img_type'] != "audio")){
			$user->RenderAlert(MG_REQUEST_3, "close");
		}
		$File = $user->GetFilePath($row['img_image'], e_MEDIA, "url");
		if (strpos($File, "no_image.png") !== FALSE){
			$user->RenderAlert(MG_REQUEST_2, "close");
		}
		header("Location: ".$File);
	}elseif ($MgMode == "full"){
		if ($row['img_type'] != "image"){
			$user->RenderAlert(MG_REQUEST_4, "close");
		}
		echo "<html>
		<head>
		<title>".$pref['mg_general_galname'].": ".sprintf(MG_REQUEST_5, $row['img_name'])."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=".CHARSET."' />
		<meta http-equiv='content-style-type' content='text/css' />
		</head>
		<body style='padding:0px; margin:0px;'>
		<a href='#' onclick='window.close()'><img src='".e_GALLERY."showimage.php?".rawurlencode($row['img_id']."+".serialize(array($row['img_width'], $row['img_height'])))."' title='".MG_REQUEST_6."' alt='' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' style='border:0px;' /></a>
		</body>
		</html>";
	}elseif ($MgMode == "wallpaper"){
		if ($row['img_type'] != "wallpaper"){
			$user->RenderAlert(MG_REQUEST_11, "close");
		}
		if (!is_array($MgRes)){
			header("Location: ".e_BASE."index.php");
			exit;
		}
		$Resolutions = array_map("trim", preg_split("/\\r?\\n/", $pref['mg_wallpapers_reslist']));
		$Resolution = trim(intval($MgRes[0]))."*".trim(intval($MgRes[1]));
		if (!in_array($Resolution, $Resolutions)){
			$user->RenderAlert(MG_REQUEST_8, "close");
		}
		if ($row['img_width'] >= $MgRes[0] && $row['img_height'] >= $MgRes[1]){
			$File = $user->GetFilePath($row['img_image'], e_IMAGES);
			if (strpos($File, "no_image.png") !== FALSE){
				$user->RenderAlert(MG_REQUEST_2, "close");
			}
			$Ext = $user->GetExtension($File);
			$TempFile = e_TEMP."Wallpaper_".$row['img_id']."_".$MgRes[0]."x".$MgRes[1].".".$Ext;
			if (!file_exists($TempFile) || !is_file($TempFile)){
				if (!$user->TempFreeSpace()){
					$user->RenderAlert(MG_REQUEST_9);
				}
				if ($pref['mg_protect_files'] && $pref['mg_mode_prof']){
					require(e_GALLERY."classes/protect.class.php");
					$res = new Protector;
					$Protect = TRUE;
				}else{
					require(e_GALLERY."classes/resize.class.php");
					$res = new Resizer;
					$Protect = FALSE;
				}
				$res->ResizeImage($File, $TempFile, $MgRes[0], $MgRes[1], $Protect);
			}
			$user->SendFile($TempFile);
		}else{
			$user->RenderAlert(MG_REQUEST_10, "close");
		}
	}else{
		header("Location: ".e_BASE."index.php");
		exit;
	}
}else{
	$user->RenderAlert(MG_REQUEST_7, "close");
}

$sql->db_Close();

?>