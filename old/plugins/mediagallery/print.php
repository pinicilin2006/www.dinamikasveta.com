<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: print.php                                        |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включение пользовательского заголовка
require(dirname(__FILE__)."/user.php");

// Получаем информацию по ссылке
$MgId = intval($Tmp[0]);
unset($Tmp);

// Проверяем, может ли пользователь распечатывать изображение
if (!$sql->db_Select_gen("SELECT i.img_id FROM #mg_images i LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id) WHERE i.img_id = '".$MgId."' AND i.img_email_print = 1 AND (i.img_type = 'image' OR i.img_type = 'wallpaper') AND c.cat_class_view IN (".USERCLASS_LIST.")")){
	$user->RenderAlert(MG_PRINT_1);
}

// Выводим информацию на экран
$sql->db_Select("mg_images", "img_name, img_id, img_width, img_height", "img_id = '".$MgId."'");
$row = $sql->db_Fetch();
echo "<html>
<head>
<title>".SITENAME.": ".$pref['mg_general_galname']." / ".MG_PRINT_2.": ".$row['img_name']."</title>
<meta http-equiv='Content-Type' content='text/html; charset=".CHARSET."' />
<meta http-equiv='content-style-type' content='text/css' />\n";
if (isset($pref['themecss']) && $pref['themecss'] && file_exists(THEME.$pref['themecss'])){
	echo "<link rel='stylesheet' href='".THEME_ABS.$pref['themecss']."' type='text/css' media='all' />\n";
}else{
	echo "<link rel='stylesheet' href='".THEME_ABS."style.css' type='text/css' media='all' />\n";
}
echo "</head>
<body style='padding: 0px; margin: 0px;'>
<div style='text-align: center'>
<img src='".e_GALLERY."showimage.php?".rawurlencode($row['img_id']."+".serialize(array($row['img_width'], $row['img_height'])))."' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' alt='' /><br /><br />
<input type='button' class='button' name='print' value='".MG_PRINT_3."' onclick='window.print()' /> <input type='button' class='button' name='back' value='".MG_PRINT_4."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."view.php?".$row['img_id'])."' />
</div>
</body>
</html>";

?>