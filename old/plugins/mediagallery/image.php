<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: image.php                                        |
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
$MgMode = $Tmp[0] == "edit" || $Tmp[0] == "delete" ? $Tmp[0] : "new";
$MgId = intval($Tmp[1]);
unset($Tmp);

// Проверяем состояние директорий
$user->CheckDirPerms(e_IMAGES);

// Проверка состояния библиотеки GD
$user->CheckGD();

// Проверка возможности работы с URL-файлами
$user->CheckURL();

// Проверяем, может ли пользователь закачивать свои изображения
if (!$sql->db_Count("mg_categories", "(*)", "WHERE cat_class_submit IN (".USERCLASS_LIST.") OR (cat_user_cat = 1 AND cat_author = '".USERID.".".USERNAME."')")){
	$user->RenderAlert(MG_IMAGE_18);
}

// Начинаем действовать при нажатии кнопок "Добавить", "Обновить"
if (isset($_POST['add']) || isset($_POST['update'])){
	if ($tp->toDB($_POST['img_oldname']) == $tp->toDB($_POST['img_name'])){
		if ($_POST['img_category'] == $_POST['img_oldcategory']){
			$_POST['img_oldname'] = "";
		}else{
			$_POST['img_oldname'] = $tp->toDB($_POST['img_name']);
		}
	}else{
		$_POST['img_oldname'] = $tp->toDB($_POST['img_name']);
	}
	if ($MgMode == "new"){
		if ((!$_FILES['img_file']['name'] && !$_POST['img_url']) || ($_FILES['img_file']['name'] && $_POST['img_url'])){
			$user->RenderAlert(MG_IMAGE_1);
		}elseif (!$_FILES['img_file']['name'] && $_POST['img_url']){
			$_POST['img_image'] = $_POST['img_url'];
			if (!$URL = $user->IsValidURL($_POST['img_image'])){
				$user->RenderAlert(MG_IMAGE_2);
			}
			if (!$_POST['img_res'] = @getimagesize($URL)){
				$user->RenderAlert(MG_IMAGE_4);
			}
			if ($pref['mg_thumb_urlthumbs']){
				$DoURLThumb = TRUE;
			}else{
				$_POST['img_thumb'] = $_POST['img_image'];
			}
			$_POST['img_size'] = 0;
		}elseif ($_FILES['img_file']['name'] && !$_POST['img_url']){
			$_POST['img_image'] = $_FILES['img_file']['name'];
			$DoUpload = TRUE;
		}
		if (!$user->IsSupported($_POST['img_image'], "MgImageList")){
			$user->RenderAlert(MG_IMAGE_3);
		}
	}
	if (!$_POST['img_name']){
		$user->RenderAlert(MG_IMAGE_5);
	}else{
		$_POST['img_name'] = $tp->toDB($_POST['img_name']);
	}
	if (!USER){
		if ($_POST['img_author_email'] && !check_email($_POST['img_author_email'])){
			$user->RenderAlert(MG_IMAGE_33);
		}
	}
	$_POST['img_description'] = $tp->toDB($_POST['img_description']);
	$_POST['img_type'] = $_POST['img_type'] == 0 ? "image" : "wallpaper";
	$sql->db_Select("mg_categories", "*", "cat_id = '".$_POST['img_category']."'");
	$row = $sql->db_Fetch();
	if ($row['cat_conf_submit'] || ($row['cat_user_cat'] && $row['cat_author'] == USERID.".".USERNAME)){
		$Direct = TRUE;
	}

	// Добавление изображения в базу
	if (isset($_POST['add'])){
		if ($sql->db_Count("mg_images", "(*)", "WHERE img_category = '".$_POST['img_category']."' AND img_name = '".$_POST['img_name']."'")){
			$user->RenderAlert(MG_IMAGE_6);
		}
		if (!$Direct && is_numeric($pref['mg_upload_limit']) && $sql->db_Count("mg_images", "(*)", "WHERE img_category = 0") >= $pref['mg_upload_limit']){
			$user->RenderAlert(MG_MEDIA_6);
		}
		require(e_GALLERY."classes/resize.class.php");
		$res = new Resizer;
		$Size = explode("*", $pref['mg_thumb_size']);
		if ($DoUpload){
			require(e_GALLERY."classes/upload.class.php");
			$upl = new Uploader;
			ob_start();
			$Uploaded = $upl->UploadFile($_FILES['img_file'], e_IMAGES);
			$Error = ob_get_clean();
			if (!$Error){
				$_POST['img_image'] = $Uploaded['name'];
				$_POST['img_size'] = $Uploaded['size'];
				$_POST['img_res'] = @getimagesize(e_IMAGES.$_POST['img_image']);
			}else{
				$user->RenderAlert($Error);
			}
			$_POST['img_thumb'] = $user->GetThumbName($_POST['img_image']);
			ob_start();
			$Resized = $res->ResizeImage(e_IMAGES.$_POST['img_image'], e_IMAGES.$_POST['img_thumb'], $Size[0], $Size[1]);
			$Error = ob_get_clean();
			if ($Error){
				@unlink(e_IMAGES.$_POST['img_image']);
				$user->RenderAlert($Error);
			}
		}
		if ($DoURLThumb){
			$_POST['img_thumb'] = $user->GetThumbName(basename(strtolower($_POST['img_image'])));
			ob_start();
			$Resized = $res->ResizeImage($URL, e_IMAGES.$_POST['img_thumb'], $Size[0], $Size[1]);
			$Error = ob_get_clean();
			if ($Error){
				$user->RenderAlert($Error);
			}
		}
		if ($sql->db_Insert("mg_images", "0, '".$_POST['img_name']."', '".$_POST['img_description']."', '".$_POST['img_thumb']."', '".$_POST['img_image']."', '".time()."', '".($Direct ? $_POST['img_category'] : 0)."', '".$_POST['img_comments']."', '".(USER ? USERID.".".USERNAME : "0.".($_POST['img_author'] ? $_POST['img_author'] : MG_IMAGE_7))."', '".$_POST['img_author_email']."', '".$_POST['img_author_homepage']."', '".($Direct ? 0 : $_POST['img_category'])."', '".$_POST['img_type']."', '".$_POST['img_size']."', '".$_POST['img_res'][0]."', '".$_POST['img_res'][1]."', '".$_POST['img_email_print']."'")){
			$Data = array("name" => $_POST['img_name'], "user" => (USER ? USERNAME : ($_POST['img_author'] ? $_POST['img_author'] : MG_IMAGE_7)), "ip" => USERIP);
			$e_event->trigger("mg_file", $Data);
			if ($Direct){
				header("Location: ".e_GALLERY."browse.php".($_POST['img_category'] == 1 ? "" : "?".$_POST['img_category']));
				exit;
			}else{
				$user->RenderAlert(MG_IMAGE_8, e_GALLERY."browse.php".($_POST['img_category'] == 1 ? "" : "?".$_POST['img_category']));
			}
		}else{
			@unlink(e_IMAGES.$_POST['img_image']);
			@unlink(e_IMAGES.$_POST['img_thumb']);
			$user->RenderAlert(MG_IMAGE_9);
		}
	}

	// Редактируем изображение
	if (isset($_POST['update'])){
		if ($sql->db_Count("mg_images", "(*)", "WHERE img_category = '".$_POST['img_category']."' AND img_name = '".$_POST['img_oldname']."'")){
			$user->RenderAlert(MG_IMAGE_5);
		}
		if ($sql->db_Update("mg_images", "img_name = '".$_POST['img_name']."', img_description = '".$_POST['img_description']."', img_category = '".$_POST['img_category']."', img_comments = '".$_POST['img_comments']."', img_type = '".$_POST['img_type']."', img_email_print = '".$_POST['img_email_print']."' WHERE img_id = '".$MgId."'")){
			header("Location: ".e_GALLERY."browse.php".($_POST['img_category'] == 1 ? "" : "?".$_POST['img_category']));
			exit;
		}else{
			$user->RenderAlert(MG_IMAGE_10);
		}
	}
}

// Выводим собранную информацию на экран
define("e_PAGETITLE", $pref['mg_general_galname']." / ".MG_IMAGE_12);
require_once(HEADERF);
require_once(e_HANDLER."ren_help.php");
if ($MgMode != "new"){
	if (!$sql->db_Select_gen("SELECT i.* FROM #mg_images i LEFT JOIN #mg_categories c ON i.img_category = c.cat_id WHERE i.img_id = '".$MgId."' AND c.cat_user_cat = 1 AND c.cat_author = '".USERID.".".USERNAME."'")){
		$user->RenderAlert(MG_IMAGE_11);
	}
	$row = $sql->db_Fetch();
}
if ($MgMode == "delete"){
	if (!$user->IsValidURL($row['img_image'])){
		@unlink(e_IMAGES.$row['img_image']);
	}
	if (!$user->IsValidURL($row['img_thumb'])){
		@unlink(e_IMAGES.$row['img_thumb']);
	}
	$sql->db_Delete("mg_images", "img_id = '".$MgId."'");
	$sql->db_Delete("rate", "rate_table = 'mgal' AND rate_itemid = '".$MgId."'");
	$sql->db_Delete("comments", "comment_type = 'mgal' AND comment_item_id = '".$MgId."'");
	header("Location: ".e_GALLERY."browse.php?".$row['img_category']);
	exit;
}
$text = "<div style='text-align:center;'>
<form method='post' action='".e_SELF."?".e_QUERY."' enctype='multipart/form-data'>
<table style='width:97%;' class='fborder'>
<tr>
<td class='forumheader' colspan='2' style='text-align:center;'>".($MgMode == "new" ? MG_IMAGE_12 : MG_IMAGE_13)."</td>
</tr>";
if ($MgMode == "new" && $pref['mg_upload_fileinfo']){
	$text .= "<tr>
	<td class='forumheader3' colspan='2' style='text-align:center;'>".MG_IMAGE_14." ".(is_numeric($pref['mg_upload_filesize']) && $pref['mg_upload_filesize'] < $user->ReturnBytes(ini_get("upload_max_filesize")) ? $user->ReturnSize($pref['mg_upload_filesize']) : ini_get("upload_max_filesize"))."<br />".MG_IMAGE_15." ".implode(", ", $MgImageList)."</td>
	</tr>";
}
if ($MgMode == "new" && $pref['mg_upload_agreement']){
	$text .= "<tr>
	<td class='forumheader3' colspan='2' style='text-align:center;'><b>".MG_IMAGE_16."</b><br />".$tp->toHTML($pref['mg_upload_agreement'], TRUE)."</td>
	</tr>";
}
$text .= "<tr>
<td class='forumheader3' style='width:40%;'>".MG_IMAGE_17."</td>
<td class='forumheader3' style='width:60%;'><select class='tbox' name='img_category' style='width:100%;'>";
$sql->db_Select_gen("SELECT c.cat_name, c.cat_id, c2.cat_name AS parent_name, c2.cat_id AS parent_id FROM #mg_categories c LEFT JOIN #mg_categories c2 ON (c.cat_category = c2.cat_id AND c.cat_category != 1) WHERE c.cat_class_submit IN (".USERCLASS_LIST.") OR (c.cat_user_cat = 1 AND c.cat_author = '".USERID.".".USERNAME."')");
while ($row2 = $sql->db_Fetch()){
	$text .= "<option value='".$row2['cat_id']."'".($row2['cat_id'] == $MgId || $row2['cat_id'] == $row['img_category'] ? " selected" : "").">".($row2['parent_name'] ? $row2['parent_name']." &rarr; " : "").$row2['cat_name']."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_IMAGE_19." *</td>
<td class='forumheader3'><input class='tbox' name='img_name' value='".$row['img_name']."' maxlength='100' style='width:100%;' /></td>
</tr>";
if ($MgMode == "new"){
	$text .= "<tr>
	<td class='forumheader3'>".MG_IMAGE_20." **</td>
	<td class='forumheader3'><input type='file' class='tbox' name='img_file' style='width:100%;' size='40' /></td>
	</tr><tr>
	<td class='forumheader3'>".MG_IMAGE_21." **</td>
	<td class='forumheader3'><input type='text' name='img_url' class='tbox' value='' style='width:100%;' maxlength='200' /></td>
	</tr>";
}
$text .= "<tr>
<td class='forumheader3'>".MG_IMAGE_22."</td>
<td class='forumheader3'><textarea class='tbox' name='img_description' rows='4' style='width:100%;' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'>".$row['img_description']."</textarea><div style='text-align:center; margin-top:2px;'>".display_help("", 2)."</div></td>
</tr><tr>
<td class='forumheader3'>".MG_IMAGE_23."</td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='img_comments' value='1'".($MgMode == "new" || $row['img_comments'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_IMAGE_24."</td>
<td class='forumheader3'><input type='checkbox' name='img_email_print' class='tbox' value='1'".($MgMode == "new" || $row['img_email_print'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_IMAGE_25."</td>
<td class='forumheader3'><input type='checkbox' name='img_type' class='tbox' value='1'".($row['img_type'] == "wallpaper" ? " checked" : "")." /></td>
</tr>";
if (!USER){
	$text .= "<tr>
	<td class='forumheader3'>".MG_IMAGE_26."</td>
	<td class='forumheader3'><input class='tbox' name='img_author' value='' maxlength='100' style='width:100%;' /></td>
	</tr><tr>
	<td class='forumheader3'>".MG_IMAGE_27."</td>
	<td class='forumheader3'><input class='tbox' name='img_author_email' value='' maxlength='100' style='width:100%;' /></td>
	</tr><tr>
	<td class='forumheader3'>".MG_IMAGE_28."</td>
	<td class='forumheader3'><input class='tbox' name='img_author_homepage' value='' maxlength='100' style='width:100%;' /></td>
	</tr>";
}
if ($MgMode == "new"){
	$ButAction = "add";
	$ButText = MG_IMAGE_29;
}else{
	$ButAction = "update";
	$ButText = MG_IMAGE_30;
	$MgId = $row['img_category'];
}
$text .= "<tr>
<td colspan='2' style='text-align:center;' class='forumheader3'><font class='smalltext'>".sprintf(MG_IMAGE_31, "*")."<br />".sprintf(MG_IMAGE_34, "**")."</font></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader2'>
<input type='hidden' name='img_oldname' value='".$row['img_name']."' />
<input type='hidden' name='img_oldcategory' value='".$row['img_category']."' />
<input type='submit' class='button' name='".$ButAction."' value='".$ButText."' />
<input type='button' class='button' name='cancel' value='".MG_IMAGE_32."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."browse.php".($MgId == 1 ? "" : "?".$MgId))."' />
</td>
</tr>
</table>
</form>
</div>";
$ns->tablerender($pref['mg_general_galname'], $text);
require_once(FOOTERF);

?>