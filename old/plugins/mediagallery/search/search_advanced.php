<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: search_advanced.php                              |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_search_advanced.php");

$advanced['cat']['type'] = "dropdown";
$advanced['cat']['text'] = MG_SEARCH_ADVANCED_1;
$advanced['cat']['list'][] = array("id" => "all", "title" => MG_SEARCH_ADVANCED_2);
$Categories = $sql->db_Select_gen("SELECT c.cat_id, c.cat_name, c2.cat_name AS parent_name, c2.cat_id AS parent_id, COUNT(DISTINCT i.img_id) AS cat_images 
FROM #mg_categories c 
LEFT JOIN #mg_categories c2 ON (c.cat_category = c2.cat_id) 
LEFT JOIN #mg_images i ON (c.cat_id = i.img_category) 
WHERE c.cat_class_view IN (".USERCLASS_LIST.") 
GROUP BY c.cat_id HAVING cat_images > 0");
if ($Categories){
	while ($row = $sql->db_Fetch()){
		$advanced['cat']['list'][] = array("id" => $row['cat_id'], "title" => ($row['parent_id'] != 1 && $row['parent_id'] != 0 ? $row['parent_name']." &rarr; ".$row['cat_name'] : $row['cat_name']));
	}
}

$advanced['date']['type'] = "date";
$advanced['date']['text'] = LAN_SEARCH_50.":";

$advanced['author']['type'] = "author";
$advanced['author']['text'] = LAN_SEARCH_61.":";

$advanced['match']['type'] = "dropdown";
$advanced['match']['text'] = LAN_SEARCH_52.":";
$advanced['match']['list'][] = array("id" => 0, "title" => MG_SEARCH_ADVANCED_6);
$advanced['match']['list'][] = array("id" => 1, "title" => MG_SEARCH_ADVANCED_3);
$advanced['match']['list'][] = array("id" => 2, "title" => MG_SEARCH_ADVANCED_4);
$advanced['match']['list'][] = array("id" => 3, "title" => MG_SEARCH_ADVANCED_5);

?>