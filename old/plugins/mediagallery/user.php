<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: user.php                                         |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Увеличиваем время обработки для работы с большими объёмами файлов
ini_set("max_execution_time", 90);

// Включаем файл с системными функциями
require(dirname(__FILE__)."/../../class2.php");

// Включение конфигурационного файла галереи
require(dirname(__FILE__)."/defines.php");

// Включаем языковые файлы
include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_".e_PAGE, TRUE);

// Включаем необходимый JavaScript
$eplug_js = e_GALLERY."javascript/mediagallery.js";

// Включение файла с функциями пользователя
require(e_GALLERY."classes/user.class.php");

// Инициализация необходимых классов
$user = new User;

// Получаем информацию, переданную по ссылке
$Tmp = explode(".", e_QUERY);

?>