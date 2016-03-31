<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: comment.php                                      |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включение пользовательского заголовка
require(dirname(__FILE__)."/user.php");

// Получение параметров по ссылке
$MgId = intval($Tmp[0]);
unset($Tmp);

// Проверяем, может ли пользователь модерировать комментарии
if (!$sql->db_Select_gen("SELECT i.* FROM #mg_images i LEFT JOIN #mg_categories c ON i.img_category = c.cat_id WHERE i.img_id = '".$MgId."' AND c.cat_user_cat = 1 AND c.cat_author = '".USERID.".".USERNAME."'")){
	$user->RenderAlert(MG_COMMENT_1);
}

if (isset($_POST['moderate'])){
	extract($_POST);
	if (is_array($Block)){
		foreach ($Block as $Id){
			$sql->db_Update("comments", "comment_blocked = 1 WHERE comment_id = '".$Id."'");
		}
	}
	if (is_array($Unblock)){
		foreach ($Unblock as $Id){
			$sql->db_Update("comments", "comment_blocked = 0 WHERE comment_id = '".$Id."'");
		}
	}
	if (is_array($Delete)){
		foreach ($Delete as $Id){
			$sql->db_Delete("comments", "comment_id = '".$Id."'");
		}
	}
}

// Выводим собранную информацию на экран
define("e_PAGETITLE", $pref['mg_general_galname']." / ".MG_COMMENT_2);
require_once(HEADERF);
$con = new convert;
$text = "<div style='text-align:center;'>
<form method='post' action='".e_SELF."?".e_QUERY."'>
<table style='width:97%;' class='fborder'>
<tr>
<td style='text-align:center;' colspan='4' class='forumheader'>".MG_COMMENT_2."</td>
</tr><tr>
<td style='width:5%;' class='forumheader2'>&nbsp;</td>
<td style='width:20%; text-align:center;' class='forumheader2'>".MG_COMMENT_3."</td>
<td style='width:50%; text-align:center;' class='forumheader2'>".MG_COMMENT_4."</td>
<td style='width:25%; text-align:center;' class='forumheader2'>".MG_COMMENT_5."</td>";
if ($sql->db_Select("comments", "*", "comment_type = 'mgal' AND comment_item_id = '".$MgId."'")){
	while ($row = $sql->db_Fetch()){
		$Author = explode(".", $row['comment_author'], 2);
		if ($Author[0] != 0){
			$Author[1] = "<a href='".e_BASE."user.php?id.".$Author[0]."'>".$Author[1]."</a>";
		}
		$text .= "<tr>
		<td class='forumheader3'><img src='".e_GALLERY."images/icons/".($row['comment_blocked'] ? "blocked" : "unblocked")."_icon.png' /></td>
		<td class='forumheader3' style='text-align:center;'>".$Author[1]."<br />".$con->convert_date($row['comment_datestamp'], "short")."</td>
		<td class='forumheader3'>".$tp->toHTML($row['comment_comment'], TRUE)."</td>
		<td class='forumheader3' style='text-align:center;'>".($row['comment_blocked'] ? "<input type='checkbox' class='tbox' name='Unblock[]' value='".$row['comment_id']."' /> ".MG_COMMENT_7 : "<input type='checkbox' class='tbox' name='Block[]' value='".$row['comment_id']."' /> ".MG_COMMENT_6)."<br /><input type='checkbox' class='tbox' name='Delete[]' value='".$row['comment_id']."' /> ".MG_COMMENT_8."</td>
		</tr>";
	}
}else{
	$text .= "<tr>
	<td class='forumheader3' colspan='4' style='text-align:center;'>".MG_COMMENT_9."</td>
	</tr>";
}
$text .= "<tr>
<td colspan='4' class='forumheader2' style='text-align:center;'>
<input type='submit' class='button' name='moderate' value='".MG_COMMENT_10."' /> 
<input type='button' class='button' name='cancel' value='".MG_COMMENT_11."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."view.php?".$MgId)."' />
</td>
</tr>
</table>
</form>
</div>";
$ns->tablerender($pref['mg_general_galname'], $text);
require_once(FOOTERF);

?>