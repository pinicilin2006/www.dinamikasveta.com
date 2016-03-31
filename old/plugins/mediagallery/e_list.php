<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_list.php                                       |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/defines.php");

if(!$sql->db_Select("plugin", "*", "plugin_path = '".basename(e_GALLERY)."' AND plugin_installflag = 1")){
	return;
}

$LIST_CAPTION = $arr[0];
$LIST_DISPLAYSTYLE = ($arr[2] ? "" : "none");

$Results = $sql->db_Select_gen("SELECT i.*, c.cat_name, c.cat_id
FROM #mg_images i
LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id)
WHERE ".($mode == "new_page" || $mode == "new_menu" ? "i.img_datestamp > '".$this->getlvisit()."' AND " : "")."c.cat_class_view IN (".USERCLASS_LIST.")
ORDER BY i.img_datestamp DESC
LIMIT 0, ".intval($arr[7]));
if ($Results){
	while ($row = $sql -> db_Fetch()){
		$User = explode(".", $row['img_author'], 2);
		$ICON = $this->getBullet($arr[6], $mode);
		$HEADING = "<a href='".e_GALLERY."view.php?".$row['img_id']."'>".$row['img_name']."</a>";
		$AUTHOR = $User[0] == 0 ? $User[1] : "<a href='".e_BASE."user.php?id.".$User[0]."'>".$User[1]."</a>";
		$CATEGORY = $arr[4] ? "<a href='".e_GALLERY."browse.php".($row['cat_id'] == 1 ? "" : "?".$row['cat_id'])."'>".$row['cat_name']."</a>" : "";
		$DATE = $arr[5] ? $this->getListDate($row['img_datestamp'], $mode) : "";
		$INFO = "";
		$LIST_DATA[$mode][] = array($ICON, $HEADING, $AUTHOR, $CATEGORY, $DATE, $INFO);
	}
}else{
	$LIST_DATA = LIST_4;
}

?>