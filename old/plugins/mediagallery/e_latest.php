<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_latest.php                                     |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

// Включение конфигурационного файла галереи
require_once(dirname(__FILE__)."/defines.php");

// Включаем языковые файлы
include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_e_latest.php");

// Выводим информацию на экран
$NewMgFiles = $sql->db_Count("mg_images", "(*)", "WHERE img_datestamp > ".USERLV);
$text .= "<div style='padding-bottom:2px;'><img src='".e_GALLERY."images/logo_16.png' style='width:16px; height:16px; vertical-align:bottom;' alt='' /> ";
if ($NewMgFiles){
	$text .= "<a href='".e_GALLERY."admin_browse.php'>".sprintf(MG_LATEST_1, $NewMgFiles)."</a>";
}else{
	$text .= sprintf(MG_LATEST_1, 0);
}
$text .= "</div>";

?>