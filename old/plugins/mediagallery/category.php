<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: category.php                                     |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

require(dirname(__FILE__)."/user.php");

// Получаем переменные по ссылке
$MgId = intval($Tmp[0]);
unset($Tmp);

// Проверяем состояние директорий
$user->CheckDirPerms(e_CTHUMBS);

// Проверка состояния библиотеки GD
$user->CheckGD();

// Проверяем, может ли пользователь создавать галереи
if (!$sql->db_Count("mg_categories", "(*)", "WHERE cat_class_create IN (".USERCLASS_LIST.")")){
	$user->RenderAlert(MG_CATEGORY_8);
}
if (is_numeric($pref['mg_create_limit']) && $sql->db_Count("mg_categories", "(*)", "WHERE cat_user_cat = 1 AND cat_author = '".USERID.".".USERNAME."'") >= $pref['mg_create_limit']){
	$user->RenderAlert(MG_CATEGORY_15);
}

// Добавляем галерею в базу
if (isset($_POST['add'])){
	if ($_FILES['cat_thumb']['name']){
		if (!$user->IsSupported($_FILES['cat_thumb']['name'], "MgImageList")){
			$user->RenderAlert(MG_CATEGORY_1);
		}
		require(e_GALLERY."/classes/upload.class.php");
		$upl = new Uploader;
		ob_start();
		$Uploaded = $upl->UploadFile($_FILES['cat_thumb'], e_CTHUMBS);
		$Error = ob_get_clean();
		if ($Error){
			$user->RenderAlert($Error);
		}
		require(e_GALLERY."/classes/resize.class.php");
		$res = new Resizer;
		$Size = explode("*", $pref['mg_thumb_size']);
		ob_start();
		$Resized = $res->ResizeImage(e_CTHUMBS.$Uploaded['name'], e_CTHUMBS.$Uploaded['name'], $Size[0], $Size[1]);
		$Error = ob_get_clean();
		if (!$Error){
			$_POST['cat_thumb'] = $Uploaded['name'];
		}else{
			unlink(e_CTHUMBS.$Uploaded['name']);
			$user->RenderAlert($Error);
		}
	}else{
		$_POST['cat_thumb'] = "default";
	}
	if ($pref['mg_create_forcename']){
		$_POST['cat_name'] = USERNAME;
	}else{
		if (!$_POST['cat_name']){
			$user->RenderAlert(MG_CATEGORY_2);
		}else{
			$_POST['cat_name'] = $tp->toDB($_POST['cat_name']);
		}
	}
	$_POST['cat_description'] = $tp->toDB($_POST['category_description']);
	$sql->db_Select("mg_categories", "MAX(cat_order) AS Position", "cat_category = '".$_POST['cat_category']."'");
	extract($sql->db_Fetch());
	if ($sql->db_Count("mg_categories", "(*)", "WHERE cat_name = '".$_POST['cat_name']."' AND cat_category = '".$_POST['cat_category']."'")){
		$user->RenderAlert(MG_CATEGORY_3);
	}
	if ($sql->db_Insert("mg_categories", "0, '".$_POST['cat_name']."', '".$_POST['cat_description']."', '".$_POST['cat_thumb']."', '".USERID.".".USERNAME."', '".$_POST['cat_category']."', 0, 255, 255, 1, 0, 0, '".time()."', '".($Position+1)."'")){
		$Data = array("name" => $_POST['cat_name'], "ip" => USERIP);
		$e_event->trigger("mg_category", $Data);
		header("Location: ".e_GALLERY."browse.php".($_POST['cat_category'] == 1 ? "" : "?".$_POST['cat_category']));
		exit;
	}else{
		$user->RenderAlert(MG_CATEGORY_4);
	}
}

// Выводим информацию на экран
define("e_PAGETITLE", $pref['mg_general_galname']." / ".MG_CATEGORY_5);
require_once(HEADERF);
require_once(e_HANDLER."ren_help.php");
$text = "<div style='text-align:center;'>
<form method='post' action='".e_SELF."?".e_QUERY."' enctype='multipart/form-data'>
<table style='width:97%;' class='fborder'>
<tr>
<td class='forumheader' colspan='2' style='text-align:center;'>".MG_CATEGORY_5."</td>
</tr>";
if ($pref['mg_create_agreement']){
	$text .= "<tr>
	<td class='forumheader3' colspan='2' style='text-align:center;'><b>".MG_CATEGORY_6."</b><br />".$tp->toHTML($pref['mg_create_agreement'], TRUE)."</td>
	</tr>";
}
$text .= "<tr>
<td class='forumheader3'>".MG_CATEGORY_7."</td>
<td class='forumheader3'><select name='cat_category' class='tbox' style='width:100%;'>";
$sql->db_Select("mg_categories", "cat_id, cat_name", "cat_class_create IN (".USERCLASS_LIST.")");
while ($row = $sql->db_Fetch()){
	$text .= "<option value='".$row['cat_id']."'".($row['cat_id'] == $MgId ? " selected" : "").">".$row['cat_name']."</option>";
}
$text .= "</select></td>
</tr>";
if (!$pref['mg_create_forcename']){
	$text .= "<tr>
	<td class='forumheader3' style='width:40%;'>".MG_CATEGORY_9." *</td>
	<td class='forumheader3' style='width:60%;'><input class='tbox' name='cat_name' value='' maxlength='100' style='width:100%;'></td>
	</tr>";
}
$text .= "<tr>
<td class='forumheader3' style='width:40%;'>".MG_CATEGORY_10."</td>
<td class='forumheader3' style='width:60%;'><textarea class='tbox' name='cat_description' rows='4' style='width:100%;' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'></textarea><div style='text-align:center; padding-top:2px;'>".display_help("", 2)."</div></td>
</tr><tr>
<td class='forumheader3'>".MG_CATEGORY_11."<br /><font class='smalltext'>".MG_CATEGORY_12."</font></td>
<td class='forumheader3'><input type='file' class='tbox' name='cat_thumb' style='width:100%;' size='40' /></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader3'><font class='smalltext'>".sprintf(MG_CATEGORY_13, "*")."</font></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader2'><input type='submit' class='button' name='add' value='".MG_CATEGORY_14."' /> 
<input type='button' class='button' name='cancel' value='".MG_CATEGORY_16."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."browse.php".($MgId == 1 ? "" : "?".$MgId))."' /></td>
</tr>
</table>
</form>
</div>";
$ns->tablerender($pref['mg_general_galname'], $text);
require_once(FOOTERF);

?>