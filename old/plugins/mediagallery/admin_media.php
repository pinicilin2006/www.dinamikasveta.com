<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_media.php                                  |
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
$MgMode = $Tmp[0] == "edit" || $Tmp[0] == "approve" || $Tmp[0] == "delete" ? $Tmp[0] : "new";
$MgId = intval($Tmp[1]);
unset($Tmp);

// Проверяем состояние директорий
$admin->CheckDirPerms(e_MEDIA, e_MTHUMBS);

// Проверка состояния библиотеки GD
$admin->CheckGD();

// Проверка возможности работы с URL-файлами
$admin->CheckURL();

// Загружаем иконку в папку "video_thumbs"
if (isset($_POST['upload'])){
	if ($_FILES['icon_file']['name']){
		if (!$admin->IsSupported($_FILES['icon_file']['name'], "MgImageList")){
			$admin->RenderAlert(MG_ADMIN_MEDIA_1);
		}
		require(e_GALLERY."classes/upload.class.php");
		$upl = new Uploader;
		ob_start();
		$Uploaded = $upl->UploadFile($_FILES['icon_file'], e_MTHUMBS);
		$Error = ob_get_clean();
		if (!$Error){
			require(e_GALLERY."classes/resize.class.php");
			$res = new Resizer;
			$Size = explode("*", $pref['mg_thumb_size']);
			ob_start();
			$Resized = $res->ResizeImage(e_MTHUMBS.$Uploaded['name'], e_MTHUMBS.$Uploaded['name'], $Size[0], $Size[1]);
			$Error = ob_get_clean();
			if (!$Error){
				$admin->RenderAlert(MG_ADMIN_MEDIA_36, e_SELF.(e_QUERY ? "?".e_QUERY : ""));
			}else{
				@unlink(e_MTHUMBS.$Uploaded['name']);
				$admin->RenderAlert($Error);
			}
		}else{
			$admin->RenderAlert($Error);
		}
	}else{
		$admin->RenderAlert(MG_ADMIN_MEDIA_2);
	}
}

// Обрабатываем введённую информацию
if (isset($_POST['add']) || isset($_POST['update']) || isset($_POST['approve'])){
	if ($tp->toDB($_POST['img_oldname']) == $tp->toDB($_POST['img_name'])){
		if ($_POST['img_category'] == $_POST['img_oldcategory']){
			$_POST['img_oldname'] = "";
		}else{
			$_POST['img_oldname'] = $tp->toDB($_POST['img_name']);
		}
	}else{
		$_POST['img_oldname'] = $tp->toDB($_POST['img_name']);
	}
	if ((!$_POST['img_image'] && !$_POST['img_url']) || ($_POST['img_image'] && $_POST['img_url'])){
		$admin->RenderAlert(MG_ADMIN_MEDIA_3);
	}elseif (!$_POST['img_image'] && $_POST['img_url']){
		$_POST['img_image'] = $_POST['img_url'];
		if (!$URL = $admin->IsValidURL($_POST['img_image'])){
			$admin->RenderAlert(MG_ADMIN_MEDIA_4);
		}
		if (!$Res = @fopen($URL, "rb")){
			$admin->RenderAlert(MG_ADMIN_MEDIA_37);
		}
		// Сюда будет добавлено получение информации и файле (видео, звук, дорожки, длительность и т.д.)
		@fclose($Res);
		$_POST['img_size'] = 0;
	}else{
		$_POST['img_size'] = $admin->GetFileSize(e_MEDIA.$_POST['img_image']);
	}
	if ($admin->IsSupported($_POST['img_image'], "MgVideoList")){
		$_POST['img_type'] = "video";
	}elseif ($admin->IsSupported($_POST['img_image'], "MgAudioList")){
		$_POST['img_type'] = "audio";
	}else{
		$admin->RenderAlert(MG_ADMIN_MEDIA_5);
	}
	if (!$_POST['img_name']){
		$admin->RenderAlert(MG_ADMIN_MEDIA_6);
	}else{
		$_POST['img_name'] = $tp->toDB($_POST['img_name']);
	}
	$_POST['img_description'] = $tp->toDB($_POST['img_description']);
	$_POST['img_thumb'] = $_POST['img_thumb'] == "default" ? $admin->GetExtension($_POST['img_image']) : $_POST['img_thumb'];

// Добавляем файл в базу
	if (isset($_POST['add'])){
		if ($sql->db_Count("mg_images", "(*)", "WHERE img_category = '".$_POST['img_category']."' AND img_name = '".$_POST['img_name']."'")){
			$admin->RenderAlert(MG_ADMIN_MEDIA_7);
		}
		if ($sql->db_Insert("mg_images", "0, '".$_POST['img_name']."', '".$_POST['img_description']."', '".$_POST['img_thumb']."', '".$_POST['img_image']."', '".time()."', '".$_POST['img_category']."', '".$_POST['img_comments']."', '".USERID.".".USERNAME."', '', '', 0, '".$_POST['img_type']."', '".$_POST['img_size']."', 0, 0, '".$_POST['img_email_print']."'")){
			header("Location: ".e_GALLERY."admin_browse.php".($_POST['img_category'] == 1 ? "" : "?".$_POST['img_category']));
			exit;
		}else{
			$admin->RenderAlert(MG_ADMIN_MEDIA_8);
		}
	}

// Обновляем файл в базе
	if (isset($_POST['update'])){
		if ($sql->db_Count("mg_images", "(*)", "WHERE img_category = '".$_POST['img_category']."' AND img_name = '".$_POST['img_oldname']."'")){
			$admin->RenderAlert(MG_ADMIN_MEDIA_7);
		}
		if ($sql->db_Update("mg_images", "img_image = '".$_POST['img_image']."', img_name = '".$_POST['img_name']."', img_description = '".$_POST['img_description']."', img_category = '".$_POST['img_category']."', img_thumb = '".$_POST['img_thumb']."', img_comments = '".$_POST['img_comments']."', img_size = '".$_POST['img_size']."', img_email_print = '".$_POST['img_email_print']."' WHERE img_id = '".$MgId."'")){
			header("Location: ".e_GALLERY."admin_browse.php".($_POST['img_category'] == 1 ? "" : "?".$_POST['img_category']));
			exit;
		}else{
			$admin->RenderAlert(MG_ADMIN_MEDIA_9);
		}
	}
	
// Подтверждаем файл
	if (isset($_POST['approve'])){
		if ($sql->db_Count("mg_images", "(*)", "WHERE img_category = '".$_POST['img_category']."' AND img_name = '".$_POST['img_oldname']."'")){
			$admin->RenderAlert(MG_ADMIN_MEDIA_7);
		}
		if ($sql->db_Update("mg_images", "img_image = '".$_POST['img_image']."', img_name = '".$_POST['img_name']."', img_description = '".$_POST['img_description']."', img_category = '".$_POST['img_category']."', img_comments = '".$_POST['img_comments']."', img_email_print = '".$_POST['img_email_print']."', img_views = 0 WHERE img_id = '".$MgId."'")){
			header("Location: ".e_GALLERY."admin_browse.php".($_POST['img_category'] == 1 ? "" : "?".$_POST['img_category']));
			exit;
		}else{
			$admin->RenderAlert(MG_ADMIN_MEDIA_9);
		}
	}
}

// Удаляем файл
if (isset($_POST['delete'])){
	$sql->db_Select("mg_images", "*", "img_id = '".$MgId."'");
	$row = $sql->db_Fetch();
	if (!$admin->IsValidURL($row['img_image'])){
		if ($_POST['delete_type'] == 0){
			@unlink(e_MEDIA.$row['img_image']);
		}else{
			@rename(e_MEDIA.$row['img_image'], e_UPLOAD.$row['img_image']);
		}
	}
	if ($_POST['delete_thumb'] && strlen($row['img_thumb']) > 4){
		@unlink(e_MTHUMBS.$row['img_thumb']);
	}
	$sql->db_Delete("mg_images", "img_id = '".$MgId."'");
	$sql->db_Delete("rate", "rate_table = 'mgal' AND rate_itemid = '".$MgId."'");
	$sql->db_Delete("comments", "comment_type = 'mgal' AND comment_item_id = '".$MgId."'");
	header("Location: ".e_GALLERY."admin_browse.php".($row['img_category'] == 1 ? "" : "?".$row['img_category']));
	exit;
}

// Выводим собранную информацию на экран
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."ren_help.php");
if ($MgMode != "new"){
	if (!$sql->db_Select("mg_images", "*", "img_id = '".$MgId."' AND (img_type = 'video' OR img_type = 'audio')")){
		$admin->RenderAlert(MG_ADMIN_MEDIA_10);
	}
	$row = $sql->db_Fetch();
}
$text = "<div style='text-align:center;'>
<form method='post' action='".e_SELF."?".e_QUERY."' enctype='multipart/form-data'>
<table style='width:95%;' class='fborder'>";
if ($MgMode == "delete"){
	$text .= "<tr>
	<td class='forumheader3' colspan='2' style='text-align:center;'>".sprintf(MG_ADMIN_MEDIA_11, "<b>".$row['img_name']."</b>")."</td>
	</tr><tr>
	<td class='forumheader3' style='width:60%;'>".MG_ADMIN_MEDIA_12."</td>
	<td class='forumheader3' style='width:40%;'><select name='delete_type' class='tbox' style='width:100%;'>
	<option value='0'>".MG_ADMIN_MEDIA_13."</option>
	<option value='1'>".MG_ADMIN_MEDIA_15."</option>
	</select></td>
	</tr><tr>
	<td class='forumheader3'>".MG_ADMIN_MEDIA_14."</td>
	<td class='forumheader3'><input type='checkbox' class='tbox' name='delete_thumb' value='1' /></td>
	</tr><tr>
	<td style='text-align:center;' class='forumheader3' colspan='2'>
	<input type='submit' class='button' name='delete' value='".MG_ADMIN_MEDIA_13."' />
	<input type='button' class='button' name='cancel' value='".MG_ADMIN_MEDIA_16."' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_browse.php".($row['img_category'] == 1 ? "" : "?".$row['img_category']))."' />
	</td>
	</tr>
	</table>
	</form>
	</div>";
	$ns->tablerender(MG_ADMIN_MEDIA_17, $text);
	require_once(e_ADMIN."footer.php");
	exit;
}
if ($MgMode == "approve"){
	$text .= "<tr>
	<td class='forumheader3'>".MG_ADMIN_MEDIA_18."</td>
	<td class='forumheader3'>".preg_replace("/^[0-9]+\./", "", $row['img_author'])."</td>
	</tr>";
}
$text .= "<tr>
<td class='forumheader3' style='width:40%;'>".MG_ADMIN_MEDIA_19."</td>
<td class='forumheader3' style='width:60%;'><select name='img_category' class='tbox' style='width:100%;'>";
$row['img_category'] = $MgMode == "approve" ? $row['img_views'] : $row['img_category'];
$sql->db_Select_gen("SELECT c.cat_name AS cat_name, c.cat_id AS cat_id, c2.cat_name AS cat_parent, c2.cat_id AS cat_parent_id
FROM #mg_categories c
LEFT JOIN #mg_categories c2 ON c.cat_category = c2.cat_id");
while ($row2 = $sql->db_Fetch()){
	$text .= "<option value='".$row2['cat_id']."'".($row2['cat_id'] == $row['img_category'] ? " selected" : "").">".($row2['cat_parent_id'] != 1 && $row2['cat_parent_id'] != 0 ? $row2['cat_parent']." &rarr; " : "").$row2['cat_name']."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_22." *</td>
<td class='forumheader3'><input type='text' class='tbox' name='img_name' value='".$row['img_name']."' maxlength='100' style='width:100%;' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_20." **</td>
<td class='forumheader3'><select name='img_image' class='tbox' style='width:100%;'>
<option value=''>".MG_ADMIN_MEDIA_26."</option>";
$Exts = array_merge($MgVideoList, $MgAudioList);
$FilesList = $admin->GetFilesList(e_MEDIA, $Exts);
foreach ($FilesList as $File){
	$text .= "<option value='".$File."'".($row['img_image'] == $File ? " selected" : "").">".$File."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_21." **</td>
<td class='forumheader3'><input type='text' class='tbox' name='img_url' value='".($admin->IsValidURL($row['img_image']) ? $row['img_image'] : "")."' maxlength='200' style='width:100%;' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_32."</td>
<td class='forumheader3'><select name='img_thumb' class='tbox' style='width:90%;'>
<option value='default'>".MG_ADMIN_MEDIA_33."</option>";
$ImageList = $admin->GetFilesList(e_MTHUMBS, $MgImageList);
foreach ($ImageList as $Image){
	$text .= "<option value='".$Image."'".($row['img_thumb'] == $Image ? " checked" : "").">".$Image."</option>";
}
$text .= "</select><img src='".e_GALLERY."images/actions/upload.png' title='".MG_ADMIN_MEDIA_34."' onclick='expandit(\"thumb_upload\")' alt='' style='border:0px; cursor:pointer; margin-left:10px;' align='absmiddle' /></td>
</tr><tr id='thumb_upload' style='display:none;'>
<td colspan='2' class='forumheader3' style='text-align:center;'>
<input type='file' class='tbox' name='icon_file' size='50' />
<input type='submit' name='upload' class='button' value='".MG_ADMIN_MEDIA_35."' />
</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_23."</td>
<td class='forumheader3'><textarea class='tbox' name='img_description' rows='4' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%;'>".$row['img_description']."</textarea><div style='text-align:center; padding-top:2px;'>".display_help("", 2)."</div></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_24."</td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='img_comments' value='1'".($MgMode == "new" ? " checked" : ($row['img_comments'] ? " checked" : ""))." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_MEDIA_25."</td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='img_email_print' value='1'".($MgMode == "new" ? " checked" : ($row['img_email_print'] ? " checked" : ""))." /></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader3'><font class='smalltext'>".sprintf(MG_ADMIN_MEDIA_27, "*")."<br />".sprintf(MG_ADMIN_MEDIA_38, "**")."</font></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader2'>";
if ($MgMode == "new"){
	$Button = "add";
	$ButText = MG_ADMIN_MEDIA_28;
}elseif ($MgMode == "edit"){
	$Button = "update";
	$ButText = MG_ADMIN_MEDIA_29;
}else{
	$Button = "approve";
	$ButText = MG_ADMIN_MEDIA_30;
}
$text .= "<input type='submit' class='button' name='".$Button."' value='".$ButText."' />";
if ($MgMode != "new"){
	$text .= " <input type='button' class='button' name='cancel' value='".MG_ADMIN_MEDIA_16."' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_browse.php".($row['img_category'] == 1 ? "" : "?".$row['img_category']))."' />
	<input type='hidden' name='img_oldname' value='".$row['img_name']."' />
	<input type='hidden' name='img_oldcategory' value='".$row['img_category']."' />";
}
$text .= "</td>
</tr>
</table>
</form>
</div>";
$ns->tablerender(MG_ADMIN_MEDIA_31, $text);
require_once(e_ADMIN."footer.php");

?>