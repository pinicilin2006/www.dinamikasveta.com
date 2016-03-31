<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: mediagallery_menu.php                            |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

// Объявляем глобальные переменные
global $pref, $sql, $tp, $ns, $user;

// Включение конфигурационного файла галереи
require_once(dirname(__FILE__)."/defines.php");

// Включаем языковые файлы
include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_mediagallery_menu.php");

// Включаем необходимые классы
require_once(e_GALLERY."classes/user.class.php");

// Инициализируем необходимые классы
if (!is_object($user)){
	$user = new User;
}
if (!is_object($tp)){// Этот класс довольно часто теряется, так что его лучше создать заново :)
	$tp = new e_parse;
}

// Выводим информацию на экран
$Types = preg_replace(array("/(image|wallpaper|audio|video)/", "/'\.i/"), array("i.img_type = '\\1'", "' OR i"), $pref['mg_menu_types']);
$Caption = file_exists(THEME."images/mediagallery_menu.png") ? "<img src='".THEME_ABS."images/mediagallery_menu.png' alt='' /> " : "";
echo "\n<!-- Меню Медиа галереи -->\n";

// Новое в галерее
if ($pref['mg_menu_new'] && $Types){
	if ($sql->db_Select_gen("SELECT i.*, c.cat_name FROM #mg_images i LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id) WHERE (".$Types.") AND c.cat_class_view IN (".USERCLASS_LIST.") ORDER BY i.img_datestamp DESC LIMIT 0, ".$pref['mg_menu_new'])){
		$text = "<div style='text-align:center;'>
		<table style='width:95%;'>";
		while ($row = $sql->db_Fetch()){
			$Title = ($row['img_type'] == "image" || $row['img_type'] == "wallpaper") ? $user->RenderImageInfo($row) : $user->RenderMediaInfo($row);
			$Name = is_numeric($pref['mg_thumb_namelength']) ? $tp->text_truncate($row['img_name'], $pref['mg_thumb_namelength'], "...") : $row['img_name'];
			$text .= "<tr>
			<td style='text-align:center;'><a href='".e_GALLERY."view.php?".$row['img_id']."'><img style='border:0px;' src='".e_GALLERY."showthumb.php?".$row['img_id']."' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' title='".$Title."' alt='' /></a></td>
			</tr><tr>
			<td style='text-align:center;'>".$Name."</td>
			</tr>";
		}
		$text .= "</table>
		</div>";
	}else{
		$text = "<div style='text-align:center;'>".MG_MEDIAGALLERY_MENU_1."</div>";
	}
	$ns->tablerender($Caption.$pref['mg_menu_newname'], $text, "mediagallery_menu");
}
// Случайные файлы
if ($pref['mg_menu_random']){
	if ($Types && $sql->db_Select_gen("SELECT i.*, c.cat_name FROM #mg_images i LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id) WHERE (".$Types.") AND c.cat_class_view IN (".USERCLASS_LIST.") ORDER BY RAND() LIMIT 0, ".$pref['mg_menu_random'])){
		$text = "<div style='text-align:center;'>
		<table style='width:95%;'>";
		while ($row = $sql->db_Fetch()){
			$Title = ($row['img_type'] == "image" || $row['img_type'] == "wallpaper") ? $user->RenderImageInfo($row) : $user->RenderMediaInfo($row);
			$Name = is_numeric($pref['mg_thumb_namelength']) ? $tp->text_truncate($row['img_name'], $pref['mg_thumb_namelength'], "...") : $row['img_name'];
			$text .= "<tr>
			<td style='text-align:center;'><a href='".e_GALLERY."view.php?".$row['img_id']."'><img style='border:0px;' src='".e_GALLERY."showthumb.php?".$row['img_id']."' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' title='".$Title."' alt='' /></a></td>
			</tr><tr>
			<td style='text-align:center;'>".$Name."</td>
			</tr>";
		}
		$text .= "</table>
		</div>";
	}else{
		$text = "<div style='text-align:center;'>".MG_MEDIAGALLERY_MENU_1."</div>";
	}
	$ns->tablerender($Caption.$pref['mg_menu_randname'], $text, "mediagallery_menu");
}
// Лучшие по рейтингу
if ($pref['mg_menu_rating']){
	if ($Types && $sql->db_Select_gen("SELECT i.*, c.cat_name, IFNULL(ROUND(r.rate_rating/r.rate_votes, 1), 0) AS img_rating FROM #mg_images i LEFT JOIN #rate r ON (i.img_id = r.rate_itemid AND r.rate_table = 'mgal') LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id) WHERE (".$Types.") AND c.cat_class_view IN (".USERCLASS_LIST.") ORDER BY img_rating DESC LIMIT 0, ".$pref['mg_menu_rating'])){
		$text = "<div style='text-align:center;'>
		<table style='width:95%;'>";
		while ($row = $sql->db_Fetch()){
			$Title = ($row['img_type'] == "image" || $row['img_type'] == "wallpaper") ? $user->RenderImageInfo($row) : $user->RenderMediaInfo($row);
			$Name = is_numeric($pref['mg_thumb_namelength']) ? $tp->text_truncate($row['img_name'], $pref['mg_thumb_namelength'], "...") : $row['img_name'];
			$text .= "<tr>
			<td style='text-align:center;'><a href='".e_GALLERY."view.php?".$row['img_id']."'><img style='border:0px;' src='".e_GALLERY."showthumb.php?".$row['img_id']."' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' title='".$Title."' alt='' /></a></td>
			</tr><tr>
			<td style='text-align:center;'>".$Name."</td>
			</tr>";
		}
		$text .= "</table>
		</div>";
	}else{
		$text = "<div style='text-align:center;'>".MG_MEDIAGALLERY_MENU_1."</div>";
	}
	$ns->tablerender($Caption.$pref['mg_menu_ratename'], $text, "mediagallery_menu");
}
echo "\n<!-- Конец меню Медиа галереи -->\n";
// Удаляем текст, созданный меню
unset($text);

?>