<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_category.php                               |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем администраторский заголовок
require(dirname(__FILE__)."/admin.php");

// Выделяем из временных необходимые переменные
$MgMode = $Tmp[0] == "edit" || $Tmp[0] == "delete" ? $Tmp[0] : "new";
$MgId = intval($Tmp[1]);
unset($Tmp);

// Проверяем состояние директорий
$admin->CheckDirPerms(e_UPLOAD, e_CTHUMBS);

// Проверка состояния библиотеки GD
$admin->CheckGD();

// Загружаем иконку в папку "category_thumbs"
if (isset($_POST['upload'])){
	if ($_FILES['icon_file']['name']){
		if (!$admin->IsSupported($_FILES['icon_file']['name'], "MgImageList")){
			$admin->RenderAlert(MG_ADMIN_CATEGORY_1);
		}
		require(e_GALLERY."classes/upload.class.php");
		$upl = new Uploader;
		ob_start();
		$Uploaded = $upl->UploadFile($_FILES['icon_file'], e_CTHUMBS);
		$Error = ob_get_clean();
		if (!$Error){
			require(e_GALLERY."classes/resize.class.php");
			$res = new Resizer;
			$Size = explode("*", $pref['mg_thumb_size']);
			ob_start();
			$Resized = $res->ResizeImage(e_CTHUMBS.$Uploaded['name'], e_CTHUMBS.$Uploaded['name'], $Size[0], $Size[1]);
			$Error = ob_get_clean();
			if (!$Error){
				$admin->RenderAlert(MG_ADMIN_CATEGORY_2, e_SELF.(e_QUERY ? "?".e_QUERY : ""));
			}else{
				@unlink(e_CTHUMBS.$Uploaded['name']);
				$admin->RenderAlert($Error);
			}
		}else{
			$admin->RenderAlert($Error);
		}
	}else{
		$admin->RenderAlert(MG_ADMIN_CATEGORY_3);
	}
}

// Передаём параметры из формы при нажатии "Обновить" или "Добавить"
if (isset($_POST['add']) || isset($_POST['update'])){
	$_POST['cat_oldname'] = $_POST['cat_oldname'] == $_POST['cat_name'] ? "" : $tp->toDB($_POST['cat_name']);
	if (!$_POST['cat_name']){
		$admin->RenderAlert(MG_ADMIN_CATEGORY_4);
	}else{
		$_POST['cat_name'] = $tp->toDB($_POST['cat_name']);
	}
	$_POST['cat_description'] = $tp->toDB($_POST['cat_description']);
	if ($_POST['cat_category'] != 0 && $_POST['cat_category'] != 1){
		$_POST['cat_class_create'] = 255;
	}

	// Добавляем галерею в базу
	if (isset($_POST['add'])){
		$sql->db_Select("mg_categories", "MAX(cat_order) AS Position", "cat_category = '".$_POST['cat_category']."'");
		extract($sql->db_Fetch());
		if ($sql->db_Count("mg_categories", "(*)", "WHERE cat_name = '".$_POST['cat_name']."' AND cat_category = '".$_POST['cat_category']."'")){
			$admin->RenderAlert(MG_ADMIN_CATEGORY_5);
		}
		if ($sql->db_Insert("mg_categories", "0, '".$_POST['cat_name']."', '".$_POST['cat_description']."', '".$_POST['cat_thumb']."', '".USERID.".".USERNAME."', '".$_POST['cat_category']."', '".$_POST['cat_class_view']."', '".$_POST['cat_class_submit']."', '".$_POST['cat_class_create']."', '0', '".$_POST['cat_submode']."', '".$_POST['cat_conf_submit']."', '".time()."', '".($Position+1)."'")){
			header("Location: ".e_GALLERY."admin_browse.php".($_POST['cat_category'] == 1 ? "" : "?".$_POST['cat_category']));
			exit;
		}else{
			$admin->RenderAlert(MG_ADMIN_CATEGORY_6);
		}
	}

	// Редактируем галерею
	if (isset($_POST['update'])){
		if ($sql->db_Count("mg_categories", "(*)", "WHERE cat_name = '".$_POST['cat_oldname']."' AND cat_category = '".$_POST['cat_category']."'")){
			$admin->RenderAlert(MG_ADMIN_CATEGORY_5);
		}
		if ($sql->db_Update("mg_categories", "cat_name = '".$_POST['cat_name']."', cat_description = '".$_POST['cat_description']."', cat_thumb = '".$_POST['cat_thumb']."', cat_class_view = '".$_POST['cat_class_view']."', cat_class_submit = '".$_POST['cat_class_submit']."', cat_class_create = '".$_POST['cat_class_create']."', cat_submode = '".$_POST['cat_submode']."', cat_conf_submit = '".$_POST['cat_conf_submit']."' WHERE cat_id = '".$MgId."'")){
			header("Location: ".e_GALLERY."admin_browse.php".($_POST['cat_category'] == 1 || $_POST['cat_category'] == 0 ? "" : "?".$_POST['cat_category']));
			exit;
		}else{
			$admin->RenderAlert(MG_ADMIN_CATEGORY_7);
		}
	}
}

// Удаляем галерею
if (isset($_POST['delete'])){
	$Images = $sql->db_Select_gen("SELECT i.*
	FROM ".MPREFIX."mg_images i
	LEFT JOIN ".MPREFIX."mg_categories c ON c.cat_category = '".$MgId."'
	WHERE i.img_category = '".$MgId."' OR i.img_category = c.cat_id");
	if ($Images){
		$ImgIds = array();
		while ($row = $sql->db_Fetch()){
			$ImgIds[] = $row['img_id'];
			if (!$admin->IsValidURL($row['img_image'])){
				if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
					if ($_POST['delete_type'] == 0){
						@unlink(e_IMAGES.$row['img_image']);
					}else{
						@rename(e_IMAGES.$row['img_image'], e_UPLOAD.$row['img_image']);
					}
					@unlink(e_IMAGES.$row['img_thumb']);
				}else{
					if ($_POST['delete_type'] == 0){
						@unlink(e_MEDIA.$row['img_image']);
					}else{
						@rename(e_MEDIA.$row['img_image'], e_UPLOAD.$row['img_image']);
					}
					@unlink(e_MTHUMBS.$row['img_thumb']);
				}
			}else{
				if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
					@unlink(e_IMAGES.$row['img_thumb']);
				}else{
					@unlink(e_MTHUMBS.$row['img_thumb']);
				}
			}
		}
		$sql->db_Delete("mg_images", "img_id IN (".implode(",", $ImgIds).")");
		$sql->db_Delete("rate", "rate_table = 'mgal' AND rate_itemid IN (".implode(",", $ImgIds).")");
		$sql->db_Delete("comments", "comment_type = 'mgal' AND comment_item_id IN (".implode(",", $ImgIds).")");
	}
	$Categories = $sql->db_Select("mg_categories", "cat_id, cat_thumb", "cat_category = '".$MgId."'");
	if ($Categories){
		$CatIds = array();
		while ($row = $sql->db_Fetch()){
			$CatIds[] = $row['cat_id'];
			if ($_POST['delete_thumb'] && $row['cat_thumb'] != "default"){
				@unlink(e_CTHUMBS.$row['cat_thumb']);
			}
		}
		$sql->db_Delete("mg_categories", "cat_id IN (".implode(",", $CatIds).")");
	}
	$sql->db_Delete("mg_categories", "cat_id = '".$MgId."'");
	if ($_POST['delete_thumb'] && $_POST['cat_thumb'] != "default"){
		@unlink(e_CTHUMBS.$_POST['cat_thumb']);
	}
	header("Location: ".e_GALLERY."admin_browse.php".($_POST['cat_category'] == 1 ? "" : "?".$_POST['cat_category']));
	exit;
}

// Выводим собранную информацию на экран
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."ren_help.php");
require_once(e_HANDLER."userclass_class.php");
$text = "<div style='text-align:center;'>
<form method='post' action='".e_SELF."?".e_QUERY."' enctype='multipart/form-data'>
<table style='width:95%;' class='fborder'>";
if ($MgMode == "new"){
	$text .= "<tr>
	<td class='forumheader3'>".MG_ADMIN_CATEGORY_8."</td>
	<td class='forumheader3'><select name='cat_category' class='tbox' style='width:100%;'>";
	$sql->db_Select("mg_categories", "cat_id, cat_name", "cat_category = 1 OR cat_category = 0");
	while ($row = $sql->db_Fetch()){
		$text .= "<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";
	}
	$text .= "</select></td>
	</tr>";
}else{
	if (!$sql->db_Select("mg_categories", "*", "cat_id = '".$MgId."'")){
		$admin->RenderAlert(MG_ADMIN_CATEGORY_9);
	}
	$row = $sql->db_Fetch();
}
if ($MgMode == "delete"){
	if ($MgId == 1){
		header("Location: ".e_GALLERY."admin_browse.php");
		exit;
	}
	$text .= "<tr>
	<td class='forumheader3' colspan='2' style='text-align:center;'>".sprintf(MG_ADMIN_CATEGORY_10, "<b>".$row['cat_name']."</b>")."</td>
	</tr><tr>
	<td class='forumheader3' style='width:60%;'>".MG_ADMIN_CATEGORY_11."</td>
	<td class='forumheader3' style='width:40%;'><select name='delete_type' class='tbox' style='width:100%;'>
	<option value='0'>".MG_ADMIN_CATEGORY_12."</option>
	<option value='1'>".MG_ADMIN_CATEGORY_13."</option>
	</select></td>
	</tr><tr>
	<td class='forumheader3'>".MG_ADMIN_CATEGORY_14."</td>
	<td class='forumheader3'><input type='checkbox' class='tbox' name='delete_thumb' value='1' /></td>
	</tr><tr>
	<td style='text-align:center;' class='forumheader3' colspan='2'>
	<input type='hidden' name='cat_category' value='".$row['cat_category']."' />
	<input type='hidden' name='cat_thumb' value='".$row['cat_thumb']."' />
	<input type='submit' name='delete' class='button' value='".MG_ADMIN_CATEGORY_12."' />
	<input type='button' name='cancel' class='button' value='".MG_ADMIN_CATEGORY_15."' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_browse.php".($row['cat_category'] == 1 ? "" : "?".$row['cat_category']))."' />
	</td>
	</tr>
	</table>
	</form>
	</div>";
	$ns->tablerender(MG_ADMIN_CATEGORY_16, $text);
	require_once(e_ADMIN."footer.php");
	exit;
}
$text .= "<tr>
<td class='forumheader3' style='width:40%;'>".MG_ADMIN_CATEGORY_17." *</td>
<td class='forumheader3' style='width:60%;'><input type='text' class='tbox' name='cat_name' value='".$row['cat_name']."' style='width:100%;' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CATEGORY_18."</td>
<td class='forumheader3'><textarea class='tbox' name='cat_description' style='width:100%;' rows='4' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'>".$row['cat_description']."</textarea><div style='text-align:center; margin-top:2px;'>".display_help("", 2)."</div></td>
</tr>";
if ($MgId != 1){
	$text .= "<tr>
	<td class='forumheader3'>".MG_ADMIN_CATEGORY_19."</td>
	<td class='forumheader3'><select name='cat_thumb' class='tbox' style='width:90%;'>
	<option value='default'>".MG_ADMIN_CATEGORY_20."</option>";
	$Thumbs = $admin->GetFilesList(e_CTHUMBS, $MgImageList);
	foreach ($Thumbs as $Thumb){
		$text .= "<option value='".$Thumb."'".($row['cat_thumb'] == $Thumb ? " selected" : "").">".$Thumb."</option>";
	}
	$text .= "</select><img src='".e_GALLERY."images/actions/upload.png' alt='' title='".MG_ADMIN_CATEGORY_21."' onclick='expandit(\"thumb_upload\")' style='border:0px; cursor:pointer; margin-left:10px;' align='absmiddle' /></td>
	</tr><tr id='thumb_upload' style='display:none;'>
	<td colspan='2' class='forumheader3' style='text-align:center;'>
	<input type='file' class='tbox' name='icon_file' size='50' />
	<input type='submit' name='upload' class='button' value='".MG_ADMIN_CATEGORY_22."' />
	</td>
	</tr>";
}
$text .= "<tr>
<td class='forumheader3'>".MG_ADMIN_CATEGORY_23."</td>
<td class='forumheader3'>".r_userclass("cat_class_view", $row['cat_class_view'], "off", "public,guest,nobody,member,classes,admin")."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CATEGORY_24."</td>
<td class='forumheader3'>".r_userclass("cat_class_submit", ($MgMode == "new" ? 255 : $row['cat_class_submit']), "off", "public,guest,nobody,member,classes,admin")."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CATEGORY_25."</td>
<td class='forumheader3'>".r_userclass("cat_class_create", ($MgMode == "new" ? 255 : $row['cat_class_create']), "off", "nobody,member,classes,admin")."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CATEGORY_26."</td>
<td class='forumheader3'><input type='checkbox' class='tbox' value='1' name='cat_conf_submit'".($row['cat_conf_submit'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CATEGORY_27."</td>
<td class='forumheader3'><select name='cat_submode' class='tbox' style='width:100%;'>";
$Modes = array(MG_ADMIN_CATEGORY_28, MG_ADMIN_CATEGORY_29, MG_ADMIN_CATEGORY_30);
foreach ($Modes as $Key => $Mode){
	$text .= "<option value='".$Key."'".($row['cat_submode'] == $Key ? " selected" : "").">".$Mode."</option>";
}
$text .= "</select></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader3'><font class='smalltext'>".sprintf(MG_ADMIN_CATEGORY_31, "*")."</font></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader2'>";
if ($MgMode == "new"){
	$Button = "add";
	$ButText = MG_ADMIN_CATEGORY_32;
}else{
	$Button = "update";
	$ButText = MG_ADMIN_CATEGORY_33;
}
$text .= "<input type='submit' class='button' name='".$Button."' value='".$ButText."' />";
if ($MgMode == "edit"){
	$text .= " <input type='button' class='button' name='cancel' value='".MG_ADMIN_CATEGORY_15."' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_browse.php".($row['category_category'] == 1 ? "" : "?".$row['category_category']))."' />
	<input type='hidden' name='cat_oldname' value='".$row['cat_name']."' />
	<input type='hidden' name='cat_category' value='".$row['cat_category']."' />";
}
$text .= "</td>
</tr>
</table>
</form>
</div>";
$ns->tablerender(MG_ADMIN_CATEGORY_16, $text);
require_once(e_ADMIN."footer.php");

?>