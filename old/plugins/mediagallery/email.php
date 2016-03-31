<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: email.php                                        |
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

// Проверяем, может ли пользователь посылать изображение
if (!$sql->db_Select_gen("SELECT i.img_id FROM #mg_images i LEFT JOIN #mg_categories c ON i.img_category = c.cat_id WHERE i.img_id = '".$MgId."' AND i.img_email_print = 1 AND (i.img_type = 'image' OR i.img_type = 'wallpaper') AND c.cat_class_view IN (".USERCLASS_LIST.")")){
	$user->RenderAlert(MG_EMAIL_1);
}

// Отправляем письмо
if (isset($_POST['send'])){
	if (!check_email($_POST['mail_adress'])){
		$user->RenderAlert(MG_EMAIL_9);
	}
	$_POST['mail_comment'] = $tp->toHTML($_POST['mail_comment'], TRUE, "emotes_off");
	if (!$user->TempFreeSpace()){
		$user->RenderAler(MG_EMAIL_10);
	}
	$sql->db_Select("mg_images", "img_thumb, img_id, img_name", "img_id = '".$MgId."'");
	$row = $sql->db_Fetch();
	$File = $user->GetFilePath($row['img_thumb'], e_IMAGES);
	$Ext = $user->GetExtension($File);
	$EmailFile = e_TEMP."Thumb_".$row['img_id'].".".$Ext;
	require(e_GALLERY."classes/resize.class.php");
	$res = new Resizer;
	$Size = explode("*", $pref['mg_thumb_size']);
	$res->ResizeImage($File, $EmailFile, $Size[0], $Size[1]);
	if (strpos($File, "no_image.png") !== FALSE){
		$user->RenderAlert(MG_EMAIL_11);
	}
	require_once(e_HANDLER."mail.php");
	if (sendemail($_POST['mail_adress'], $row['img_name'], $_POST['mail_comment'], "", "", (USER ? USERNAME : $_POST['mail_author']), $EmailFile)){
		@unlink($EmailFile);
		$user->RenderAlert(MG_EMAIL_12, e_GALLERY."view.php?".$MgId);
	}else{
		@unlink($EmailFile);
		$user->RenderAlert(sprintf(MG_EMAIL_13, $_POST['mail_adress']));
	}
}

// Выводим информацию на экран
define("e_PAGETITLE", $pref['mg_general_galname']." / ".MG_EMAIL_2);
require_once(HEADERF);
require_once(e_HANDLER."ren_help.php");
$sql->db_Select("mg_images", "img_name, img_thumb", "img_id = '".$MgId."'");
$row = $sql->db_Fetch();
$text = "<div style='text-align:center'>
<form method='post' action='".e_SELF."?".e_QUERY."'>
<table class='fborder' style='width:97%'>
<tr>
<td class='forumheader' colspan='2' style='text-align:center;'>".MG_EMAIL_2."</td>
</tr>";
if (!USER){
	$text .= "<tr>
	<td style='width:40%' class='forumheader3'>".MG_EMAIL_3."</td>
	<td style='width:60%' class='forumheader3'><input class='tbox' type='text' name='mail_author' style='width:100%;' maxlength='100' value='' /></td>
	</tr>";
}
$text .= "<tr>
<td style='width:40%' class='forumheader3'>".MG_EMAIL_4." *<br /><font class='smalltext'>".MG_EMAIL_8."</font></td>
<td style='width:60%' class='forumheader3'><textarea class='tbox' name='mail_comment' style='width:100%;' rows='4' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'></textarea><div style='text-align: center; padding-top: 2px;'>".display_help("", 2)."</div></td>
</tr><tr>
<td class='forumheader3'>".MG_EMAIL_5." *</td>
<td class='forumheader3'><input class='tbox' type='text' name='mail_adress' style='width:100%;' value='' maxlength='150' /></td>
</tr><tr>
<td colspan='2' style='text-align:center' class='forumheader3'><font class='smalltext'>".MG_EMAIL_6."</font></td>
</tr><tr>
<td colspan='2' style='text-align:center' class='forumheader2'><input class='button' type='submit' name='send' value='".MG_EMAIL_7."' /></td>
</tr>
</table>
</form>
</div>";
$ns->tablerender($pref['mg_general_galname'], $text);
require_once(FOOTERF);

?>