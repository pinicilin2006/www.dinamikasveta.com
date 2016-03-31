<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_menu.php                                   |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

// Включаем языковые файлы
include_lan(dirname(__FILE__)."/languages/".e_LANGUAGE."/lan_admin_menu.php");

// Генерируем меню
$var['admin_browse']['text'] = MG_ADMIN_MENU_1;
$var['admin_browse']['link'] = "admin_browse.php";
$var['admin_image']['text'] = MG_ADMIN_MENU_2;
$var['admin_image']['link'] = "admin_image.php";
$var['admin_media']['text'] = MG_ADMIN_MENU_3;
$var['admin_media']['link'] = "admin_media.php";
$var['admin_category']['text'] = MG_ADMIN_MENU_4;
$var['admin_category']['link'] = "admin_category.php";
$var['admin_fmanager']['text'] = MG_ADMIN_MENU_5;
$var['admin_fmanager']['link'] = "admin_fmanager.php";
$var['admin_mmanager']['text'] = MG_ADMIN_MENU_6;
$var['admin_mmanager']['link'] = "admin_mmanager.php";
$var['admin_dmanager']['text'] = MG_ADMIN_MENU_7;
$var['admin_dmanager']['link'] = "admin_dmanager.php";
$var['admin_config']['text'] = MG_ADMIN_MENU_8;
$var['admin_config']['link'] = "admin_config.php";
$var['admin_readme']['text'] = MG_ADMIN_MENU_9;
$var['admin_readme']['link'] = "admin_readme.php";
show_admin_menu(MG_ADMIN_MENU_10, substr(e_PAGE, 0, -4), $var);

?>