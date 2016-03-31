<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_config.php                                 |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем администраторский заголовок
require(dirname(__FILE__)."/admin.php");

// Загружаем водяной знак
if (isset($_POST['upload'])){
	if ($_FILES['wm_file']['name']){
		if (!$admin->IsSupported($_FILES['wm_file']['name'], "MgImageList")){
			$admin->RenderAlert(MG_ADMIN_CONFIG_1);
		}
		require(e_GALLERY."classes/upload.class.php");
		$upl = new Uploader;
		ob_start();
		$Uploaded = $upl->UploadFile($_FILES['wm_file'], e_WMARKS);
		$Error = ob_get_clean();
		if ($Error){
			$admin->RenderAlert($Error);
		}
	}else{
		$admin->RenderAlert(MG_ADMIN_CONFIG_2);
	}
}

// Сохраняем изменённые параметры
if (isset($_POST['save'])){
	if (!$_POST['mg_general_galname']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_4));
	}
	if (!$_POST['mg_menu_randname']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_5));
	}
	if (!$_POST['mg_menu_newname']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_6));
	}
	if (!$_POST['mg_menu_ratename']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_7));
	}
	if (!is_numeric($_POST['mg_thumb_size'][0]) || !is_numeric($_POST['mg_thumb_size'][1])){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_8));
	}
	if (!is_numeric($_POST['mg_thumb_namelength']) && $_POST['mg_thumb_namelength']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_9));
	}
	if (!is_numeric($_POST['mg_view_size'][0]) || !is_numeric($_POST['mg_view_size'][1])){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_10));
	}
	if (!is_numeric($_POST['mg_upload_limit']) && $_POST['mg_upload_limit']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_11));
	}
	if (!is_numeric($_POST['mg_create_limit']) && $_POST['mg_create_limit']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_120));
	}
	if ((!preg_match("/^[0-9]+(K|M|G|T)?$/", $_POST['mg_upload_filesize']) && $_POST['mg_upload_filesize']) || ($admin->ReturnBytes($_POST['mg_upload_filesize']) > $admin->ReturnBytes(ini_get("upload_max_filesize")))){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_12));
	}
	if (!preg_match("/^([0-9]+\*[0-9]+(\\r?\\n|$))+$/", $_POST['mg_wallpapers_reslist'])){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_13));
	}
	if (!preg_match("/^[0-9]+(K|M|G|T)?$/", $_POST['mg_wallpapers_tempsize']) && $_POST['mg_wallpapers_tempsize']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_14));
	}
	if ($_POST['mg_mode_prof'] && $_POST['mg_protect_files']){
		if ($_POST['mg_protect_type'] == 0 && $_POST['mg_protect_image'] == "no"){
			$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_15, MG_ADMIN_CONFIG_16));
		}
		if ($_POST['mg_protect_type'] == 1 && !$_POST['mg_protect_text']){
			$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_15, MG_ADMIN_CONFIG_17));
		}
		if (!is_numeric($_POST['mg_protect_offset'])){
			$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_18));
		}
		if (!is_numeric($_POST['mg_protect_fontangle']) || $_POST['mg_protect_fontangle'] < 0 || $_POST['mg_protect_fontangle'] > 90){
			$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_19));
		}
		if (!preg_match("/^#?[a-f0-9]{6}$/i", $_POST['mg_protect_fontcolor'])){
			$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_21));
		}
	}
	if (!is_numeric($_POST['mg_resize_quality']) || $_POST['mg_resize_quality'] < 1 || $_POST['mg_resize_quality'] > 100){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_48));
	}
	if (!preg_match("/^#?[a-f0-9]{6}$/i", $_POST['mg_view_bgcolor'])){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_3, MG_ADMIN_CONFIG_20));
	}
	if ($_POST['mg_ftp_login'] && !$_POST['mg_ftp_password']){
		$admin->RenderAlert(sprintf(MG_ADMIN_CONFIG_15, MG_ADMIN_CONFIG_22));
	}
	$pref['mg_general_galname'] = $_POST['mg_general_galname'];
	$pref['mg_general_catname'] = $_POST['mg_general_catname'];
	$pref['mg_general_imgname'] = $_POST['mg_general_imgname'];
	$pref['mg_view_size'] = implode("*", $_POST['mg_view_size']);
	$pref['mg_view_autoplay'] = $_POST['mg_view_autoplay'];
	$pref['mg_view_download'] = $_POST['mg_view_download'];
	$pref['mg_view_bgcolor'] = $_POST['mg_view_bgcolor'];
	$pref['mg_thumb_size'] = implode("*", $_POST['mg_thumb_size']);
	$pref['mg_thumb_columns'] = $_POST['mg_thumb_columns'];
	$pref['mg_thumb_rows'] = $_POST['mg_thumb_rows'];
	$pref['mg_thumb_urlthumbs'] = $_POST['mg_thumb_urlthumbs'];
	$pref['mg_thumb_namelength'] = $_POST['mg_thumb_namelength'];
	$pref['mg_thumb_shownew'] = $_POST['mg_thumb_shownew'];
	$pref['mg_thumb_sortfield'] = $_POST['mg_thumb_sortfield'];
	$pref['mg_thumb_sortorder'] = $_POST['mg_thumb_sortorder'];
	$pref['mg_resize_quality'] = $_POST['mg_resize_quality'];
	$pref['mg_upload_fileinfo'] = $_POST['mg_upload_fileinfo'];
	$pref['mg_upload_agreement'] = $_POST['mg_upload_agreement'];
	$pref['mg_upload_filesize'] = $admin->ReturnBytes($_POST['mg_upload_filesize']);
	$pref['mg_upload_limit'] = $_POST['mg_upload_limit'];
	$pref['mg_create_limit'] = $_POST['mg_create_limit'];
	$pref['mg_create_agreement'] = $_POST['mg_create_agreement'];
	$pref['mg_create_forcename'] = $_POST['mg_create_forcename'];
	$pref['mg_wallpapers_reslist'] = $_POST['mg_wallpapers_reslist'];
	$pref['mg_wallpapers_tempsize'] = $admin->ReturnBytes($_POST['mg_wallpapers_tempsize']);
	$pref['mg_ftp_login'] = $_POST['mg_ftp_login'];
	$pref['mg_ftp_password'] = $_POST['mg_ftp_password'];
	$pref['mg_menu_randname'] = $_POST['mg_menu_randname'];
	$pref['mg_menu_newname'] = $_POST['mg_menu_newname'];
	$pref['mg_menu_ratename'] = $_POST['mg_menu_ratename'];
	$pref['mg_menu_random'] = $_POST['mg_menu_random'];
	$pref['mg_menu_new'] = $_POST['mg_menu_new'];
	$pref['mg_menu_rating'] = $_POST['mg_menu_rating'];
	$pref['mg_menu_types'] = implode(".", $_POST['mg_menu_types']);
	$pref['mg_check_gd'] = $_POST['mg_check_gd'];
	$pref['mg_check_dirs'] = $_POST['mg_check_dirs'];
	$pref['mg_check_url'] = $_POST['mg_check_url'];
	$pref['mg_mode_prof'] = $_POST['mg_mode_prof'];
	$pref['mg_protect_files'] = $_POST['mg_protect_files'];
	$pref['mg_protect_type'] = $_POST['mg_protect_type'];
	$pref['mg_protect_image'] = $_POST['mg_protect_image'];
	$pref['mg_protect_text'] = $_POST['mg_protect_text'];
	$pref['mg_protect_font'] = $_POST['mg_protect_font'];
	$pref['mg_protect_fontsize'] = $_POST['mg_protect_fontsize'];
	$pref['mg_protect_fontcolor'] = $_POST['mg_protect_fontcolor'];
	$pref['mg_protect_fontangle'] = $_POST['mg_protect_fontangle'];
	$pref['mg_protect_pos'] = $_POST['mg_protect_pos'];
	$pref['mg_protect_offset'] = $_POST['mg_protect_offset'];
	save_prefs();
	$admin->RenderAlert(MG_ADMIN_CONFIG_23, e_SELF);
}

// Выводим собранную информацию на экран
require_once(e_ADMIN."auth.php");
$pref['mg_view_size'] = explode("*", $pref['mg_view_size']);
$pref['mg_thumb_size'] = explode("*", $pref['mg_thumb_size']);
$text = $admin->RenderColorChooser();
$text .= "<div style='text-align:center;'>
<form method='post' action='".e_SELF."' enctype='multipart/form-data'>
<table style='width:95%;' class='fborder'>
<tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_24."</td>
</tr><tr>
<td class='forumheader3' style='width:50%;'>".MG_ADMIN_CONFIG_4."</td>
<td class='forumheader3' style='width:50%;'><input type='text' name='mg_general_galname' class='tbox' value='".$pref['mg_general_galname']."' maxlength='100' style='width:100%;' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_26."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_28."</span></td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_general_catname' value='".$pref['mg_general_catname']."' maxlength='100' style='width:100%;' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_27."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_28."</span></td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_general_imgname' value='".$pref['mg_general_imgname']."' maxlength='100' style='width:100%;' /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_29."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_10."<br /><span class='smalltext'>".sprintf(MG_ADMIN_CONFIG_30, "x")."<span></td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_view_size[0]' value='".$pref['mg_view_size'][0]."' maxlength='4' size='4' /> x <input type='text' class='tbox' name='mg_view_size[1]' value='".$pref['mg_view_size'][1]."' maxlength='4' size='4' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_31."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_32."<span></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='checkbox' class='tbox' name='mg_view_autoplay' value='1'".($pref['mg_view_autoplay'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_33."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_34."<span></td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='mg_view_download' value='1'".($pref['mg_view_download'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_20."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_35."<span></td>
<td class='forumheader3'><input type='text' class='tbox' id='playerbgtext' name='mg_view_bgcolor' value='".$pref['mg_view_bgcolor']."' maxlength='7' size='9' /> <input type='button' class='button' id='playerbgbutton' value='".MG_ADMIN_CONFIG_36."' title='".MG_ADMIN_CONFIG_37."' onclick='ColorChooser(\"playerbg\")' /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_38."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_39."<br /><span class='smalltext'>".sprintf(MG_ADMIN_CONFIG_30, "x")."<span></td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_thumb_size[0]' value='".$pref['mg_thumb_size'][0]."' maxlength='4' size='4' /> x <input type='text' class='tbox' name='mg_thumb_size[1]' value='".$pref['mg_thumb_size'][1]."' maxlength='4' size='4' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_40."</td>
<td class='forumheader3'><select name='mg_thumb_columns' class='tbox'>";
for ($I=1; $I<11; $I++){
	$text .= "<option value='".$I."'".($pref['mg_thumb_columns'] == $I ? " selected" : "").">".$I."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_41."</td>
<td class='forumheader3'><select name='mg_thumb_rows' class='tbox'>";
for ($I=1; $I<16; $I++){
	$text .= "<option value='".$I."'".($pref['mg_thumb_rows'] == $I ? " selected" : "").">".$I."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_42."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_43."<span></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='checkbox' name='mg_thumb_urlthumbs' class='tbox' value='1'".($pref['mg_thumb_urlthumbs'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_9."<br /><font class='smalltext'>".MG_ADMIN_CONFIG_44."</font></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='text' name='mg_thumb_namelength' class='tbox' maxlength='4' size='4' value='".$pref['mg_thumb_namelength']."' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_45."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_46."<span></td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='mg_thumb_shownew' value='1'".($pref['mg_thumb_shownew'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_129."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_131."<span></td>
<td class='forumheader3'><select name='mg_thumb_sortfield' class='tbox' style='width: 100%;'>
<option value='0'".($pref['mg_thumb_sortfield'] == 0 ? " selected" : "").">".MG_ADMIN_CONFIG_123."</option>
<option value='1'".($pref['mg_thumb_sortfield'] == 1 ? " selected" : "").">".MG_ADMIN_CONFIG_124."</option>
<option value='2'".($pref['mg_thumb_sortfield'] == 2 ? " selected" : "").">".MG_ADMIN_CONFIG_125."</option>
<option value='3'".($pref['mg_thumb_sortfield'] == 3 ? " selected" : "").">".MG_ADMIN_CONFIG_126."</option>
</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_130."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_131."<span></td>
<td class='forumheader3'><select name='mg_thumb_sortorder' class='tbox' style='width: 100%;'>
<option value='0'".($pref['mg_thumb_sortorder'] == 0 ? " selected" : "").">".MG_ADMIN_CONFIG_127."</option>
<option value='1'".($pref['mg_thumb_sortorder'] == 1 ? " selected" : "").">".MG_ADMIN_CONFIG_128."</option>
</select></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_47."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_48."<br /><font class='smalltext'>".sprintf(MG_ADMIN_CONFIG_49, 1, 100)."</font></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='text' name='mg_resize_quality' class='tbox' maxlength='4' size='4' value='".$pref['mg_resize_quality']."' /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_50."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_51."<br /><font class='smalltext'>".MG_ADMIN_CONFIG_52."</font></td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='mg_upload_fileinfo' value='1'".($pref['mg_upload_fileinfo'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_53."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_54."</span></td>
<td class='forumheader3'><textarea class='tbox' name='mg_upload_agreement' rows='4' style='width:100%;'>".$pref['mg_upload_agreement']."</textarea></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_12."<br /><span class='smalltext'>".sprintf(MG_ADMIN_CONFIG_56, "K, M, G, T", ini_get("upload_max_filesize"), "php.ini")."<span></td>
<td class='forumheader3'><input type='text' name='mg_upload_filesize' class='tbox' maxlength='10' size='13' value='".(is_numeric($pref['mg_upload_filesize']) ? $admin->ReturnSize($pref['mg_upload_filesize'], TRUE) : "")."' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_11."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_57."<span></td>
<td class='forumheader3'><input type='text' name='mg_upload_limit' class='tbox' maxlength='4' size='4' value='".$pref['mg_upload_limit']."' /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_58."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_121."<br /><font class='smalltext'>".MG_ADMIN_CONFIG_122."</font></td>
<td class='forumheader3'><input type='checkbox' class='tbox' onclick='UserCat()' id='mg_create_forcename' name='mg_create_forcename' value='1'".($pref['mg_create_forcename'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_120."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_57."<span></td>
<td class='forumheader3'><input type='text' id='mg_create_limit' name='mg_create_limit' class='tbox' maxlength='4' size='4' value='".$pref['mg_create_limit']."' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_59."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_54."</span></td>
<td class='forumheader3'><textarea class='tbox' name='mg_create_agreement' rows='4' style='width:100%;'>".$pref['mg_create_agreement']."</textarea></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_60."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_13."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_61."</span></td>
<td class='forumheader3'><textarea class='tbox' name='mg_wallpapers_reslist' rows='5' cols='20'>".$pref['mg_wallpapers_reslist']."</textarea></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_14."<br /><span class='smalltext'>".sprintf(MG_ADMIN_CONFIG_55, "K, M, G, T")."<span></td>
<td class='forumheader3'><input type='text' name='mg_wallpapers_tempsize' class='tbox' maxlength='10' size='13' value='".(is_numeric($pref['mg_wallpapers_tempsize']) ? $admin->ReturnSize($pref['mg_wallpapers_tempsize'], TRUE) : "")."' /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_62."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_63."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_64."</span></td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_ftp_login' value='".$pref['mg_ftp_login']."' style='width:100%;' maxlength='100' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_22."<br /><span class='smalltext'>".MG_ADMIN_CONFIG_65."<span></td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_ftp_password' value='".$pref['mg_ftp_password']."' style='width:100%;' maxlength='100' /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_66."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_5."</td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_menu_randname' value='".$pref['mg_menu_randname']."' style='width:100%;' maxlength='100' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_6."</td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_menu_newname' value='".$pref['mg_menu_newname']."' style='width:100%;' maxlength='100' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_7."</td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_menu_ratename' value='".$pref['mg_menu_ratename']."' style='width:100%;' maxlength='100' /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_67."</td>
<td class='forumheader3'><select name='mg_menu_random' class='tbox'>
<option value='0'>".MG_ADMIN_CONFIG_68."</option>";
for ($I = 1; $I < 11; $I++){
	$text .= "<option value='".$I."'".($pref['mg_menu_random'] == $I ? " selected" : "").">".$I."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_69."</td>
<td class='forumheader3'><select name='mg_menu_new' class='tbox'>
<option value='0'>".MG_ADMIN_CONFIG_68."</option>";
for ($I = 1; $I < 11; $I++){
	$text .= "<option value='".$I."'".($pref['mg_menu_new'] == $I ? " selected" : "").">".$I."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_70."</td>
<td class='forumheader3'><select name='mg_menu_rating' class='tbox'>
<option value='0'>".MG_ADMIN_CONFIG_68."</option>";
for ($I = 1; $I < 11; $I++){
	$text .= "<option value='".$I."'".($pref['mg_menu_rating'] == $I ? " selected" : "").">".$I."</option>";
}
$text .= "</select></td>
</tr><tr>
<td class='forumheader3' style='vertical-align:middle;'>".MG_ADMIN_CONFIG_71."</td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='mg_menu_types[0]' value='image'".(strstr($pref['mg_menu_types'], "image") ? " checked" : "")." /> ".MG_ADMIN_CONFIG_72."<br />
<input type='checkbox' style='margin-top: 2px;' class='tbox' name='mg_menu_types[1]' value='wallpaper'".(strstr($pref['mg_menu_types'], "wallpaper") ? " checked" : "")." /> ".MG_ADMIN_CONFIG_73."<br />
<input type='checkbox' style='margin-top: 2px;' class='tbox' name='mg_menu_types[2]' value='video'".(strstr($pref['mg_menu_types'], "video") ? " checked" : "")." /> ".MG_ADMIN_CONFIG_74."<br />
<input type='checkbox' style='margin-top: 2px;' class='tbox' name='mg_menu_types[3]' value='audio'".(strstr($pref['mg_menu_types'], "audio") ? " checked" : "")." /> ".MG_ADMIN_CONFIG_75."</td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_76."</td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_77."<br /><font class='smalltext'>".MG_ADMIN_CONFIG_78."</font></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='checkbox' class='tbox' name='mg_check_gd' value='1' onclick='if(!this.checked){".$admin->RenderConfirmOnClick(MG_ADMIN_CONFIG_79)."}'".($pref['mg_check_gd'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_80."<br /><font class='smalltext'>".MG_ADMIN_CONFIG_81."</font></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='checkbox' class='tbox' name='mg_check_dirs' value='1' onclick='if(!this.checked){".$admin->RenderConfirmOnClick(MG_ADMIN_CONFIG_82)."}'".($pref['mg_check_dirs'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader3'>".MG_ADMIN_CONFIG_117."<br /><font class='smalltext'>".sprintf(MG_ADMIN_CONFIG_118, "allow_url_fopen", "php.ini")."</font></td>
<td class='forumheader3' style='vertical-align:middle;'><input type='checkbox' class='tbox' name='mg_check_url' value='1' onclick='if(!this.checked){".$admin->RenderConfirmOnClick(MG_ADMIN_CONFIG_119)."}'".($pref['mg_check_url'] ? " checked" : "")." /></td>
</tr><tr>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_83."</td>
</tr><tr>
<td class='forumheader3' style='vertical-align:middle;'>".MG_ADMIN_CONFIG_84."<br /><font class='smalltext'>".MG_ADMIN_CONFIG_100."</font></td>
<td class='forumheader3'><input type='radio' class='tbox' id='mg_mode_prof0' name='mg_mode_prof' value='0' onclick='ProfPrefs()'".($pref['mg_mode_prof'] == 0 ? " checked" : "")." /> ".MG_ADMIN_CONFIG_85."<br />
<input type='radio' class='tbox' style='margin-top: 2px;' id='mg_mode_prof1' name='mg_mode_prof' value='1' onclick='ProfPrefs()'".($pref['mg_mode_prof'] == 1 ? " checked" : "")." /> ".MG_ADMIN_CONFIG_86."</td>
</tr><tr id='profprefs_1' style='display:none;'>
<td class='forumheader' style='text-align:center;' colspan='2'>".MG_ADMIN_CONFIG_87."</td>
</tr><tr id='profprefs_2' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_88."</td>
<td class='forumheader3'><input type='checkbox' class='tbox' name='mg_protect_files' value='1'".($pref['mg_protect_files'] ? " checked" : "")." /></td>
</tr><tr id='profprefs_4' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_89."</td>
<td class='forumheader3'><select name='mg_protect_pos' class='tbox'>";
$Positions = array(MG_ADMIN_CONFIG_90, MG_ADMIN_CONFIG_91, MG_ADMIN_CONFIG_92, MG_ADMIN_CONFIG_93, MG_ADMIN_CONFIG_94, MG_ADMIN_CONFIG_95, MG_ADMIN_CONFIG_96, MG_ADMIN_CONFIG_97, MG_ADMIN_CONFIG_98, MG_ADMIN_CONFIG_99);
foreach($Positions as $Key => $Position){
	$text .= "<option value='".$Key."'".($pref['mg_protect_pos'] == $Key ? " selected" : "").">".$Position."</option>";
}
$text .= "</select></td>
</tr><tr id='profprefs_5' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_18."</td>
<td class='forumheader3'><input type='text' name='mg_protect_offset' class='tbox' value='".$pref['mg_protect_offset']."' size='4' maxlength='3' /> ".MG_ADMIN_CONFIG_101."</td>
</tr><tr id='profprefs_3' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_102."</td>
<td class='forumheader3'><input type='radio' class='tbox' id='mg_protect_type0' name='mg_protect_type' value='0' onclick='ProfPrefs()'".($pref['mg_protect_type'] == 0 ? " checked" : "")." /> ".MG_ADMIN_CONFIG_103."<br />
<input type='radio' class='tbox' style='margin-top: 2px;' id='mg_protect_type1' name='mg_protect_type' value='1' onclick='ProfPrefs()'".($pref['mg_protect_type'] == 1 ? " checked" : "")." /> ".MG_ADMIN_CONFIG_104."</td>
</tr><tr id='profprefs_6' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_105."</td>
<td class='forumheader3'><select name='mg_protect_image' class='tbox'>
<option value='no'>".MG_ADMIN_CONFIG_106."</option>";
$Wmarks = $admin->GetFilesList(e_WMARKS, $MgImageList);
foreach ($Wmarks as $Wmark){
	$text .= "<option value='".$Wmark."'".($pref['mg_protect_image'] == $Wmark ? " selected" : "").">".$Wmark."</option>";
}
$text .= "</select><img src='".e_GALLERY."images/actions/upload.png' alt='' title='".MG_ADMIN_CONFIG_107."' onclick='expandit(\"wmark_upload\")' style='border:0px; cursor:pointer; margin-left:10px;' align='absmiddle' /></td>
</tr><tr id='wmark_upload' style='display:none;'>
<td colspan='2' class='forumheader3' style='text-align:center;'><input type='file' class='tbox' name='wm_file' size='50' /> <input type='submit' name='upload' class='button' value='".MG_ADMIN_CONFIG_108."' /></td>
</tr><tr id='profprefs_7' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_109."</td>
<td class='forumheader3'><select name='mg_protect_font' class='tbox'>
<optgroup label='".MG_ADMIN_CONFIG_110."' class='tbox' style='border:0px;'>"; // Параметры class и style добавлены для совместимости стиля в браузерах Mozilla и Netscape
$Types = array("ttf");
$Fonts = $admin->GetFilesList(e_GALLERY."fonts/", $Types);
foreach ($Fonts as $Font){
	$text .= "<option value='".e_GALLERY."fonts/".$Font."'".($pref['mg_protect_font'] == e_GALLERY."fonts/".$Font ? " selected" : "").">".substr($Font, 0, -4)."</option>";
}
$text .= "</optgroup>";
$UserFonts = $admin->GetFilesList(e_FONTS, $Types);
if ($UserFonts){
	$text .= "<optgroup label='".MG_ADMIN_CONFIG_111."' class='tbox' style='border:0px;'>"; // Параметры class и style добавлены для совместимости стиля в браузерах Mozilla и Netscape
	foreach ($UserFonts as $UserFont){
		$text .= "<option value='".e_FONTS.$UserFont."'".($pref['mg_protect_font'] == e_FONTS.$UserFont ? " selected" : "").">".substr($UserFont, 0, -4)."</option>";
	}
	$text .= "</optgroup>";
}
$text .= "</select></td>
</tr><tr id='profprefs_8' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_112."</td>
<td class='forumheader3'><select name='mg_protect_fontsize' class='tbox'>";
for ($I=24; $I<45; $I++){
	$text .= "<option value='".$I."'".($pref['mg_protect_fontsize'] == $I ? " selected" : "").">".$I."</option>";
}
$text .= "</select> ".MG_ADMIN_CONFIG_101."</td>
</tr><tr id='profprefs_9' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_113."</td>
<td class='forumheader3'><input type='text' class='tbox' id='protecttexttext' name='mg_protect_fontcolor' value='".$pref['mg_protect_fontcolor']."' size='9' maxlength='7' /> <input type='button' class='button' id='protecttextbutton' name='show_color2' value='".MG_ADMIN_CONFIG_36."' title='".MG_ADMIN_CONFIG_37."' onclick=\"ColorChooser('protecttext');\" /></td>
</tr><tr id='profprefs_10' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_19."<br /><font class='smalltext'>".sprintf(MG_ADMIN_CONFIG_114, "0<sup>o</sup>", "90<sup>o</sup>")."</font></td>
<td class='forumheader3'><input class='tbox' type='text' name='mg_protect_fontangle' size='4' value='".$pref['mg_protect_fontangle']."' maxlength='3' /></td>
</tr><tr id='profprefs_11' style='display:none;'>
<td class='forumheader3'>".MG_ADMIN_CONFIG_17."</td>
<td class='forumheader3'><input type='text' class='tbox' name='mg_protect_text' value='".$pref['mg_protect_text']."' maxlength='200' style='width:100%;' /></td>
</tr><tr>
<td colspan='2' style='text-align:center;' class='forumheader3'><input type='submit' name='save' class='button' value='".MG_ADMIN_CONFIG_115."' /></td>
</tr>
</table>
</form>
<script type='text/javascript'>ProfPrefs(); UserCat()</script>
</div>";
$ns->tablerender(MG_ADMIN_CONFIG_116, $text);
require_once(e_ADMIN."footer.php");

?>