<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_browse.php                                 |
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
$MgId = intval($Tmp[0]) ? intval($Tmp[0]) : 1;
unset($Tmp);

// Проверяем состояние директорий
$admin->CheckDirPerms(e_TEMP);

// Изменяем порядок отображения категорий
if (isset($_POST['up_x'])){
	$Tmp = explode(".", $_POST['id']);
	if ($sql->db_Select("mg_categories", "MAX(cat_order) AS Position", "cat_order < '".$Tmp[2]."' AND cat_category = '".$Tmp[0]."'")){
		extract($sql->db_Fetch());
		$sql->db_Update("mg_categories", "cat_order = '".$Tmp[2]."' WHERE cat_order = '".$Position."' AND cat_category = '".$Tmp[0]."'");
		$sql->db_Update("mg_categories", "cat_order = '".$Position."' WHERE cat_id = '".$Tmp[1]."' AND cat_category = '".$Tmp[0]."'");
	}
	unset($Tmp);
}

if (isset($_POST['down_x'])){
	$Tmp = explode(".", $_POST['id']);
	if ($sql->db_Select("mg_categories", "MIN(cat_order) AS Position", "cat_order > '".$Tmp[2]."' AND cat_category = '".$Tmp[0]."'")){
		extract($sql->db_Fetch());
		$sql->db_Update("mg_categories", "cat_order = '".$Tmp[2]."' WHERE cat_order = '".$Position."' AND cat_category = '".$Tmp[0]."'");
		$sql->db_Update("mg_categories", "cat_order = '".$Position."' WHERE cat_id = '".$Tmp[1]."' AND cat_category = '".$Tmp[0]."'");
	}
	unset($Tmp);
}

// Выводим информацию на экран
require_once(e_ADMIN."auth.php");
if (is_numeric($pref['mg_wallpapers_tempsize'])){
	$Size = $admin->GetDirSize(e_TEMP);
	$Percentage = round($Size/$pref['mg_wallpapers_tempsize']*100, 2);
	if ($Percentage > 90){
		$text = "<div style='text-align:center;'>
		<table style='width:95%;'>
		<tr>
		<td style='width:40px; vertical-align:center; text-align:center;'><img src='".e_GALLERY."images/icons/important_icon.png' alt='' /></td>
		<td style='vertical-align:center; text-align:left;'>".sprintf(MG_ADMIN_BROWSE_1, "<a href='".e_GALLERY."admin_mmanager.php'>".MG_ADMIN_BROWSE_2."</a>")."</td>
		</tr>
		</table>
		</div>";
		$ns->tablerender(MG_ADMIN_BROWSE_3, $text);
	}
}
$text = "<div style='text-align:center;'>
<table class='fborder' style='width:95%;'>
<tr>
<td class='forumheader' style='width:6%; text-align:center; vertical-align:middle;'><a href='".e_GALLERY."admin_category.php?edit.1'><img src='".e_GALLERY."images/icons/parent_icon.png' title='".MG_ADMIN_BROWSE_4."' alt='' style='border:0px;' /></a></td>
<td class='forumheader' style='width:74%; text-align:center;' colspan='2'>".MG_ADMIN_BROWSE_5."</td>
<td class='forumheader' style='width:20%; text-align:center;'>".MG_ADMIN_BROWSE_6."</td>
</tr>";
if ($MgId != 1){
	$sql->db_Select("mg_categories", "cat_category", "cat_id = '".$MgId."'");
	$row = $sql->db_Fetch();
	$text .= "<tr>
	<td class='forumheader3' style='text-align:center;'><a href='".e_GALLERY."admin_browse.php".($row['cat_category'] == 1 ? "" : "?".$row['cat_category'])."'><img src='".e_GALLERY."images/actions/updir.png' title='".MG_ADMIN_BROWSE_7."' alt='' style='border:0px;' /></a></td>
	<td class='forumheader3' colspan='3' style='vertical-align:bottom;'>...</td>
	</tr>";
}
$Categories = $sql->db_Select_gen("SELECT c.*, COUNT(DISTINCT c2.cat_id) AS cat_categories, IFNULL(SUM(i.img_size)*COUNT(DISTINCT i.img_id)/IF(COUNT(DISTINCT i.img_id)=0, 1, COUNT(i.img_id)), 0)+IFNULL(SUM(i2.img_size)*COUNT(DISTINCT i2.img_id)/IF(COUNT(DISTINCT i2.img_id)=0, 1, COUNT(i2.img_id)), 0) AS cat_size, COUNT(DISTINCT i.img_id)+COUNT(DISTINCT i2.img_id) AS cat_images, MAX(i.img_datestamp) AS cat_last
FROM #mg_categories c
LEFT JOIN #mg_images i ON (c.cat_id = i.img_category)
LEFT JOIN #mg_categories c2 ON (c.cat_id = c2.cat_category)
LEFT JOIN #mg_images i2 ON (c2.cat_id = i2.img_category)
WHERE c.cat_category = '".$MgId."'
GROUP BY c.cat_id
ORDER BY c.cat_order ASC");
while ($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td class='forumheader3' style='text-align:center;'><img src='".e_GALLERY."images/icons/category_".($row['cat_user_cat'] ? "user_" : "")."icon.png' title='".$admin->RenderCategoryInfo($row)."' alt='' /></td>
	<td class='forumheader3'><a href='".e_GALLERY."admin_browse.php?".$row['cat_id']."' title='".MG_ADMIN_BROWSE_8."'>".$row['cat_name']." (".sprintf(MG_ADMIN_BROWSE_9, $row['cat_categories'], $row['cat_images']).")</a></td>
	<td class='forumheader3' style='text-align:center; width:5%'>
	<form action='".e_SELF.($MgId == 1 ? "" : "?".$MgId)."' method='post'>
	<input type='hidden' name='id' value='".$MgId.".".$row['cat_id'].".".$row['cat_order']."' />
	<input type='image' title='".MG_ADMIN_BROWSE_10."' src='".e_GALLERY."images/actions/up.png' name='up' />
	<input type='image' title='".MG_ADMIN_BROWSE_11."' src='".e_GALLERY."images/actions/down.png' name='down' />
	</form>
	</td>
	<td class='forumheader3' style='text-align:center; width:20%;'>".$admin->RenderOptionBar("category", $row['cat_id'])."</td>
	</tr>";
}
$Files = $sql->db_Select("mg_images", "*", "img_category = '".$MgId."' ORDER BY img_datestamp DESC");
while ($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td class='forumheader3' style='text-align:center;'><img src='".e_GALLERY."images/icons/".$row['img_type']."_icon.png' title='".($row['img_type'] == "image" || $row['img_type'] == "wallpaper" ? $admin->RenderImageInfo($row) : $admin->RenderMediaInfo($row))."' alt='' /></td>
	<td class='forumheader3' colspan='2'>".$row['img_name']."</td>
	<td class='forumheader3' style='text-align:center;'>".$admin->RenderOptionBar($row['img_type'] == "image" || $row['img_type'] == "wallpaper" ? "image" : "media", $row['img_id'])."</td>
	</tr>";
}
if (!$Categories && !$Files){
	$text .= "<tr>
	<td colspan='4' class='forumheader3' style='text-align:center;'>".MG_ADMIN_BROWSE_12."</td>
	</tr>";
}
$text .= "</table>
</div>";
$ns->tablerender(MG_ADMIN_BROWSE_13, $text);
if ($sql->db_Select("mg_images", "*", "img_category = 0")){
	$text = "<div style='text-align:center;'>
	<table class='fborder' style='width:95%;'>
	<tr>
	<td class='forumheader' style='width: 6%;'>&nbsp;</td>
	<td class='forumheader' style='width: 74%; text-align: center;'>".MG_ADMIN_BROWSE_5."</td>
	<td class='forumheader' style='width: 20%; text-align: center;'>".MG_ADMIN_BROWSE_6."</td>
	</tr>";
	while ($row = $sql->db_Fetch()){
		$text .= "<tr>
		<td class='forumheader3' style='text-align:center;'><img src='".e_GALLERY."images/icons/".$row['img_type']."_icon.png' title='".($row['img_type'] == "image" || $row['img_type'] == "wallpaper" ? $admin->RenderImageInfo($row) : $admin->RenderMediaInfo($row))."' alt='' /></td>
		<td class='forumheader3'>".$row['img_name']."</td>
		<td class='forumheader3' style='text-align:center;'>".$admin->RenderOptionBar(($row['img_type'] == "image" || $row['img_type'] == "wallpaper" ? "subimage" : "submedia"), $row['img_id'])."</td>
		</tr>";
	}
	$text .= "</table>
	</div>";
	$ns->tablerender(MG_ADMIN_BROWSE_14, $text);
}
require_once(e_ADMIN."footer.php");

?>