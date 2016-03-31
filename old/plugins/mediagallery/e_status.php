<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_status.php                                     |
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
include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_e_status.php");

// Выводим информацию на экран
$MgFiles = $sql->db_Count("mg_images");
$text .= "<div style='padding-bottom:2px;'><img src='".e_GALLERY."images/logo_16.png' style='width:16px; height:16px; vertical-align:bottom;' alt='' /> ".sprintf(MG_STATUS_1, $MgFiles)."</div>";

?>