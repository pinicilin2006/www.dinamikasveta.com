<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: browse.php                                       |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включение заголовка пользователя
require(dirname(__FILE__)."/user.php");

// Получение параметров по ссылке
$MgId = intval($Tmp[0]) ? intval($Tmp[0]) : 1;
$MgFrom = intval($Tmp[1]);
$MgSortField = isset($Tmp[2]) ? intval($Tmp[2]) : $pref['mg_thumb_sortfield'];
$MgSortOrder = isset($Tmp[3]) ? intval($Tmp[3]) : $pref['mg_thumb_sortorder'];
$MgCatFrom = intval($Tmp[4]);
unset($Tmp);

// Проверяем состояние директорий
$user->CheckDirPerms(e_MEDIA, e_IMAGES, e_CTHUMBS, e_MTHUMBS);

// Проверка состояния библиотеки GD
$user->CheckGD();

// Проверка возможности работы с URL-файлами
$user->CheckURL();

// Передаём параметры сортировки
if (isset($_POST['sort'])){
	header("Location: ".e_SELF."?".$_POST['id'].".".$_POST['from'].".".$_POST['sortfield'].".".$_POST['sortorder'].".".$_POST['catfrom']);
	exit;
}

// Получаем информацию о галерее
$Parent = $sql->db_Select_gen("SELECT c.*, c2.cat_name AS parent_name, c2.cat_id AS parent_id, COUNT(DISTINCT c3.cat_id) AS cat_categories, COUNT(DISTINCT i.img_id) AS cat_images, COUNT(DISTINCT c4.cat_id) AS cat_user_cats
FROM #mg_categories c
LEFT JOIN #mg_categories c2 ON (c.cat_category = c2.cat_id AND c.cat_category != 1)
LEFT JOIN #mg_categories c3 ON (c.cat_id = c3.cat_category AND c3.cat_class_view IN (".USERCLASS_LIST."))
LEFT JOIN #mg_images i ON c.cat_id = i.img_category
LEFT JOIN #mg_categories c4 ON (c.cat_id = c4.cat_category AND c4.cat_user_cat = 1 AND c4.cat_author = '".USERID.".".USERNAME."')
WHERE c.cat_id = '".$MgId."' AND c.cat_class_view IN (".USERCLASS_LIST.")
GROUP BY c.cat_id");
if (!$Parent){
	$user->RenderAlert(MG_BROWSE_1);
}
$row = $sql->db_Fetch();
if ($MgId != 1){
	define(e_PAGETITLE, $pref['mg_general_galname'].($row['parent_name'] ? " / ".$row['parent_name'] : "")." / ".$row['cat_name']);
}else{
	define(e_PAGETITLE, $pref['mg_general_galname']);
}
$MgParentMode = $row['cat_submode'];
$MgTotalCategories = $row['cat_categories'];
$MgTotalImages = $row['cat_images'];
$MgParentId = $row['parent_id'];
$MgClassSubmit = $row['cat_class_submit'];
$MgClassCreate = $row['cat_class_create'];
$MgAuthor = $row['cat_author'];
$MgUserCat = $row['cat_user_cat'];
$MgUserCats = $row['cat_user_cats'];

// Выводим собранную информацию на экран
require_once(HEADERF);
if (file_exists(THEME."browse_template.php")){
	require(THEME."browse_template.php");
}else{
	require(e_GALLERY."templates/browse_template.php");
}
$text = $TABLE_START;
$Items = $pref['mg_thumb_rows']*$pref['mg_thumb_columns'];
$COLUMNS = $pref['mg_thumb_columns'];
if ($MgTotalCategories){
	if (!USER){
		define("USERLV", time());
	}
	$Categories = $sql->db_Select_gen("SELECT c.*, IFNULL(SUM(i.img_size) * COUNT(DISTINCT i.img_id) / IF(COUNT(DISTINCT i.img_id) = 0, 1, COUNT(i.img_id)), 0) + IFNULL(SUM(i2.img_size) * COUNT(DISTINCT i2.img_id) / IF(COUNT(DISTINCT i2.img_id) = 0, 1, COUNT(i2.img_id)), 0) AS cat_size, COUNT(DISTINCT i.img_id) + COUNT(DISTINCT i2.img_id) AS cat_images, IF(c.cat_thumb = 'default', IFNULL(MAX(i.img_id), '".e_GALLERY."images/errors/no_files.png'), CONCAT('".e_CTHUMBS."', c.cat_thumb)) AS cat_thumb, MAX(i.img_datestamp) AS cat_last, COUNT(DISTINCT i3.img_id) AS cat_new
	FROM #mg_categories c
	LEFT JOIN #mg_images i ON c.cat_id = i.img_category
	LEFT JOIN #mg_categories c2 ON (c.cat_id = c2.cat_category AND c2.cat_class_view IN (".USERCLASS_LIST."))
	LEFT JOIN #mg_images i2 ON c2.cat_id = i2.img_category
	LEFT JOIN #mg_images i3 ON (i3.img_datestamp > ".USERLV." AND i3.img_category = c.cat_id)
	WHERE c.cat_category = '".$MgId."' AND c.cat_class_view IN (".USERCLASS_LIST.") 
	GROUP BY c.cat_id
	ORDER BY c.cat_order ASC
	LIMIT ".$MgCatFrom.", ".$Items);
	if ($pref['mg_general_catname']){
		$NAME = $pref['mg_general_catname'];
		$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_NAME);
	}
	$NewImage = "<img src='".e_GALLERY."images/icons/new_icon.png' title='".MG_BROWSE_2."' align='absmiddle' alt='' />";
	switch ($MgParentMode){
		case 0:
			$text .= "<tr>";
			$Item = 0;
			$WIDTH = floor(100 / $pref['mg_thumb_columns'])."%";
			for ($I = 0; $I < $Categories; $I++){
				$row = $sql->db_Fetch();
				if ($Item >= $pref['mg_thumb_columns']){
					$text .= "</tr><tr>";
					$Item = 0;
				}
				$LINK = e_SELF."?".$row['cat_id'];
				$IMAGE = e_GALLERY."showthumb.php?".rawurlencode($row['cat_thumb']);
				$TITLE = $user->RenderCategoryInfo($row);
				$NAME = $row['cat_name'];
				$IMAGES = $row['cat_images'];
				$NEWIMAGES = $row['cat_new'] && $pref['mg_thumb_shownew'] ? $NewImage : "";
				$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_TABLET);
				$Item++;
			}
			while ($Item < $pref['mg_thumb_columns']){ // Доводим плитку до конца, чтобы не нарушать дизайн
				$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_TABLET_EMPTY);
				$Item++;
			}
			$text .= "</tr>";
			break;
		case 1:
			$con = new convert;
			$text .= "<tr>";
			$Item = 0;
			$WIDTH = floor(100 / $pref['mg_thumb_columns'])."%";
			for ($I = 0; $I < $Categories; $I++){
				$row = $sql->db_Fetch();
				if ($Item >= $pref['mg_thumb_columns']){
					$text .= "</tr><tr>";
					$Item = 0;
				}
				$LINK = e_SELF."?".$row['cat_id'];
				$SIZE = $user->ReturnSize($row['cat_size']);
				$AUTHOR = preg_replace("/^[0-9]+\./", "", $row['cat_author']);
				$DATE = $con->convert_date($row['cat_datestamp'], "short");
				$LAST = ($row['cat_last'] ? $con->convert_date($row['cat_last'], "short") : MG_BROWSE_8);
				$NAME = $row['cat_name'];
				$IMAGES = $row['cat_images'];
				$NEWIMAGES = $row['cat_new'] && $pref['mg_thumb_shownew'] ? $NewImage : "";
				$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_TABLET_NOTHUMB);
				$Item++;
			}
			while ($Item < $pref['mg_thumb_columns']){ // Доводим плитку до конца, чтобы не нарушать дизайн
				$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_TABLET_EMPTY);
				$Item++;
			}
			$text .= "</tr>";
			break;
		case 2:
			$WIDTH = $pref['mg_thumb_columns'] - 1;
			while ($row = $sql->db_Fetch()){
				$LINK = e_SELF."?".$row['cat_id'];
				$IMAGE = e_GALLERY."showthumb.php?".rawurlencode($row['cat_thumb']);
				$TITLE = $user->RenderCategoryInfo($row);
				$NAME = $row['cat_name'];
				$IMAGES = $row['cat_images'];
				$NEWIMAGES = $row['cat_new'] && $pref['mg_thumb_shownew'] ? $NewImage : "";
				$DESCRIPTION = $row['cat_description'] ? $tp->toHTML($row['cat_description'], TRUE) : MG_BROWSE_9;
				$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_ROW);
			}
			break;
	}
	$SHOWING = sprintf(MG_BROWSE_10, ($MgCatFrom + 1), (($MgTotalCategories - $MgCatFrom) >= $Items ? ($MgCatFrom + $Items) : $MgTotalCategories), $MgTotalCategories);
	if ($MgCatFrom > 0){
		$From = $MgCatFrom - $Items;
		if ($From < 0){
			$From = 0;
		}
		$PREVBUTTON = "<input class='button' type='button' name='prev' value='&lsaquo; ".MG_BROWSE_11."' title='".MG_BROWSE_12."' onclick='".$user->RenderRedirectOnClick(e_SELF."?".$MgId.".".$MgFrom.".".$MgSortField.".".$MgSortOrder.".".$From)."' />";
	}else{
		$PREVBUTTON = "<input class='button' type='button' name='prev' value='&lsaquo; ".MG_BROWSE_11."' disabled />";
	}
#	if ($MgId != 1){
#		$BACKBUTTON = "<input type='button' class='button' name='up' value='".MG_BROWSE_13."' onclick='".$user->RenderRedirectOnClick(e_SELF.($MgParentId ? "?".$MgParentId : ""))."' />";
#	}else{
#		$BACKBUTTON = "&nbsp;";
#	}
	if (($MgCatFrom+$Items) < $MgTotalCategories){
		$From = $MgCatFrom + $Items;
		$NEXTBUTTON = "<input class='button' type='button' name='next' value='".MG_BROWSE_14." &rsaquo;' title='".MG_BROWSE_15."' onclick='".$user->RenderRedirectOnClick(e_SELF."?".$MgId.".".$MgFrom.".".$MgSortField.".".$MgSortOrder.".".$From)."' />";
	}else{
		$NEXTBUTTON = "<input class='button' type='button' name='next' value='".MG_BROWSE_14." &rsaquo;' disabled />";
	}
	$text .= preg_replace("/\{(.*?)\}/e", '$\1', $CAT_TABLE_INFO);
}
if ($MgTotalImages){
	$Fields = array(
		array("field" => "i.img_datestamp", "name" => MG_BROWSE_16),
		array("field" => "i.img_name", "name" => MG_BROWSE_17),
		array("field" => "i.img_views", "name" => MG_BROWSE_18),
		array("field" => "img_rating", "name" => MG_BROWSE_19)
	);
	$Orders = array(
		array("order" => "DESC", "name" => MG_BROWSE_20),
		array("order" => "ASC", "name" => MG_BROWSE_21)
	);
	$Images = $sql->db_Select_gen("SELECT i.*, IFNULL(ROUND(r.rate_rating/r.rate_votes, 1), 0) AS img_rating
	FROM #mg_images i
	LEFT JOIN #rate r ON (i.img_id = r.rate_itemid AND r.rate_table = 'mgal')
	WHERE i.img_category = '".$MgId."'
	ORDER BY ".$Fields[$MgSortField]['field']." ".$Orders[$MgSortOrder]['order']."
	LIMIT ".$MgFrom.", ".$Items);
	if ($pref['mg_general_imgname']){
		$NAME = $pref['mg_general_imgname'];
		$text .= preg_replace("/\{(.*?)\}/e", '$\1', $IMG_TABLE_NAME);
	}
	$ACTION = e_SELF.(e_QUERY ? "?".e_QUERY : "");
	$FIELD = "<select name='sortfield' class='tbox'>";
	foreach ($Fields as $Key => $Field){
		$FIELD .= "<option value='".$Key."'".($Key == $MgSortField ? " selected" : "").">".$Field['name']."</option>";
	}
	$FIELD .= "</select>";
	$ORDER = "<select name='sortorder' class='tbox'>";
	foreach ($Orders as $Key => $Order){
		$ORDER .= "<option value='".$Key."'".($Key == $MgSortOrder ? " selected" : "").">".$Order['name']."</option>";
	}
#	$ORDER .= "</select>";
#	$SORTBUTTON = "<input type='hidden' name='id' value='".$MgId."' />
#	<input type='hidden' name='catfrom' value='".$MgCatFrom."' />^M
#	<input type='hidden' name='from' value='".$MgFrom."' />^M
#       <input type='submit' class='button' name='sort' value='".MG_BROWSE_24."' />";
	$text .= preg_replace("/\{(.*?)\}/e", '$\1', $IMG_TABLE_SORT);
	$Item = 0;
	$WIDTH = floor(100 / $pref['mg_thumb_columns'])."%";
	$text .= "<tr>";
	for ($I = 0; $I < $Images; $I++){
		$row = $sql->db_Fetch();
		if ($Item >= $pref['mg_thumb_columns']){
			$text .= "</tr><tr>";
			$Item = 0;
		}
		$LINK = e_GALLERY."view.php?".$row['img_id'];
		$IMAGE = e_GALLERY."showthumb.php?".$row['img_id'];
		$TITLE = ($row['img_type'] == "image" || $row['img_type'] == "wallpaper") ? $user->RenderImageInfo($row) : $user->RenderMediaInfo($row);
		$NAME = is_numeric($pref['mg_thumb_namelength']) ? $tp->text_truncate($row['img_name'], $pref['mg_thumb_namelength'], "...") : $row['img_name'];
		$text .= preg_replace("/\{(.*?)\}/e", '$\1', $IMG_TABLE_TABLET);
		$Item++;
	}
	while ($Item < $pref['mg_thumb_columns']){ // Доводим плитку до конца, чтобы не нарушать дизайн
		$text .= preg_replace("/\{(.*?)\}/e", '$\1', $IMG_TABLE_TABLET_EMPTY);
		$Item++;
	}
	$text .= "</tr>";
	$SHOWING = sprintf(MG_BROWSE_25, ($MgFrom + 1), (($MgTotalImages - $MgFrom) >= $Items ? ($MgFrom + $Items) : $MgTotalImages), $MgTotalImages);
	if ($MgFrom > 0){
		$From = $MgFrom - $Items;
		if ($From < 0){
			$From = 0;
		}
		$PREVBUTTON = "<input class='button' type='button' name='prev' value='&lsaquo; ".MG_BROWSE_11."' title='".MG_BROWSE_26."' onclick='".$user->RenderRedirectOnClick(e_SELF."?".$MgId.".".$From.".".$MgSortField.".".$MgSortOrder.".".$MgCatFrom)."' />";
	}else{
		$PREVBUTTON = "<input class='button' type='button' name='prev' value='&lsaquo; ".MG_BROWSE_11."' disabled />";
	}
	if ($MgId != 1){
		$BACKBUTTON = "<input type='button' class='button' name='up' value='".MG_BROWSE_13."' onclick='".$user->RenderRedirectOnClick(e_SELF.($MgParentId ? "?".$MgParentId : ""))."' />";
	}else{
		$BACKBUTTON = "&nbsp;";
	}
	if (($MgFrom + $Items) < $MgTotalImages){
		$From = $MgFrom + $Items;
		$NEXTBUTTON = "<input class='button' type='button' name='next' value='".MG_BROWSE_14." &rsaquo;' title='".MG_BROWSE_27."' onclick='".$user->RenderRedirectOnClick(e_SELF."?".$MgId.".".$From.".".$MgSortField.".".$MgSortOrder.".".$MgCatFrom)."' />";
	}else{
		$NEXTBUTTON = "<input class='button' type='button' name='next' value='".MG_BROWSE_14." &rsaquo;' disabled />";
	}
	$text .= preg_replace("/\{(.*?)\}/e", '$\1', $IMG_TABLE_INFO);
}
if (!$MgTotalCategories && !$MgTotalImages){
	$BACKBUTTON = "<input type='button' class='button' name='up' value='".MG_BROWSE_13."' onclick='".$user->RenderRedirectOnClick(e_SELF.($MgParentId ? "?".$MgParentId : ""))."' />";
	$text .= preg_replace("/\{(.*?)\}/e", '$\1', $TABLE_EMPTY);
}
$MgClassSubmit = $MgUserCat == 0 ? check_class($MgClassSubmit) : ($MgAuthor == USERID.".".USERNAME ? TRUE : FALSE);
$MgClassCreate = $MgUserCats >= $pref['mg_create_limit'] && is_numeric($pref['mg_create_limit']) ? FALSE : check_class($MgClassCreate);
if ($MgClassCreate || $MgClassSubmit){
	if ($MgClassSubmit){
		$SUBMITIMAGE = "<input type='button' class='button' name='submit' value='".MG_BROWSE_29."' title='".MG_BROWSE_30."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."image.php?new.".$MgId)."' />";
		$SUBMITMEDIA = "<input type='button' class='button' name='submit' value='".MG_BROWSE_31."' title='".MG_BROWSE_30."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."media.php?new.".$MgId)."' />";
	}
	if ($MgClassCreate){
		$CREATECATEGORY = "<input type='button' class='button' name='create' value='".MG_BROWSE_32."' title='".MG_BROWSE_33."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."category.php?".$MgId)."' />";
	}
	$text .= preg_replace("/\{(.*?)\}/e", '$\1', $TABLE_ACTION);
}
$text .= $TABLE_END;
$ns->tablerender($pref['mg_general_galname'], $text);
require_once(FOOTERF);

?>
