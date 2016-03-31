<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: showimage.php                                    |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

require(dirname(__FILE__)."/../../class2.php");
require(dirname(__FILE__)."/defines.php");
require(e_GALLERY."classes/main.class.php");
if ($pref['mg_mode_prof'] && $pref['mg_protect_files']){
	require(e_GALLERY."classes/protect.class.php");
	$res = new Protector;
	$Protect = TRUE;
}else{
	require(e_GALLERY."classes/resize.class.php");
	$res = new Resizer;
	$Protect = FALSE;
}
$main = new Main;
$Tmp = explode("+", rawurldecode(e_QUERY));
$Image = strip_tags($Tmp[0]);
$Size = $Tmp[1] ? @unserialize($Tmp[1]) : explode("*", $pref['mg_view_size']);
unset($Tmp);
header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
if (is_numeric($Image)){
	if (is_array($Size)){
		if ($sql->db_Select_gen("SELECT i.img_image, i.img_type, c.cat_class_view FROM #mg_images i LEFT JOIN #mg_categories c ON i.img_category = c.cat_id WHERE i.img_id = '".intval($Image)."'")){
			$row = $sql->db_Fetch();
			if (check_class($row['cat_class_view']) || getperms("P")){
				if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
					$Image = $main->GetFilePath($row['img_image'], e_IMAGES);
					$res->ResizeImage($Image, "stdout", intval($Size[0]), intval($Size[1]), $Protect);
				}else{
					$Image = $main->GetFilePath($row['img_image'], e_MEDIA);
					header("Content-type: ".$main->GetMimeType($Image));
					$File = fopen($Image, "rb");
					while (!feof($File)){
						$Data = fread($File, 1048576);
						echo $Data;
					}
					fclose($File);
				}
			}
		}
	}
}else{
	if (getperms("P")){
		$Image = str_replace(array("\\\\", "\\"), "/", realpath($Image));
		if ($main->IsSupported($Image, "MgImageList")){
			$res->ResizeImage($Image, "stdout", intval($Size[0]), intval($Size[1]), $Protect);
		}else{
			header("Content-type: ".$main->GetMimeType($Image));
			$File = fopen($Image, "rb");
			while (!feof($File)){
				$Data = fread($File, 1048576);
				echo $Data;
			}
			fclose($File);
		}
	}
}
$sql->db_Close();

?>