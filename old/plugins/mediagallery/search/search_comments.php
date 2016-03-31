<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: search_comments.php                              |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

global $pref;

require_once(dirname(__FILE__)."/../defines.php");

include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_search_comments.php");

$comments_title = $pref['mg_general_galname'];
$comments_type_id = "mgal";
$comments_return['mediagallery'] = "i.img_id, i.img_name";
$comments_table['mediagallery'] = "LEFT JOIN #mg_images AS i ON c.comment_type='mgal' AND i.img_id = c.comment_item_id";

function com_search_mgal($Row){
	global $con;
	$Res['link'] = e_GALLERY."view.php?".$Row['img_id'];
	$Res['pre_title'] = MG_SEARCH_COMMENT_1." ";
	$Res['title'] = $Row['img_name'];
	$Res['summary'] = $Row['comment_comment'];
	$User = explode(".", $Row['comment_author'], 2);
	$Res['detail'] = LAN_SEARCH_7."<a href='".e_BASE."user.php?id.".$User[0]."'>".$User[1]."</a>".LAN_SEARCH_8.$con->convert_date($Row['comment_datestamp'], "long");
	return $Res;
}

?>