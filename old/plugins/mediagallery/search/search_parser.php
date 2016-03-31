<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: search_parser.php                                |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/../defines.php");

include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_search_parser.php");

$advanced_where = "";
if (isset($_GET['cat']) && is_numeric($_GET['cat'])){
	$advanced_where .= " i.img_category='".$_GET['cat']."' AND";
}
if (isset($_GET['time']) && is_numeric($_GET['time'])){
	$advanced_where .= " i.img_datestamp ".($_GET['on'] == "new" ? ">=" : "<=")." '".(time()-$_GET['time'])."' AND";
}
if (isset($_GET['author']) && $_GET['author'] != ""){
	$advanced_where .= " i.img_author REGEXP '^[0-9]+\.".$tp->toDB($_GET['author'])."$' AND";
}
if (isset($_GET['match']) && $_GET['match'] == 1){
	$search_fields = array('i.img_name');
}elseif (isset($_GET['match']) && $_GET['match'] == 2){
	$search_fields = array('i.img_description');
}elseif (isset($_GET['match']) && $_GET['match'] == 3){
	$search_fields = array('i.img_author');
}else{
	$search_fields = array("i.img_name", "i.img_description", "i.img_author");
}

$return_fields = "i.img_id, i.img_name, i.img_description, i.img_datestamp, i.img_author, c.cat_name";
$weights = array("1.2", "0.6", "1.2");
$no_results = LAN_198;
$where = "c.cat_class_view IN (".USERCLASS_LIST.") AND".$advanced_where;
$order = "";
$table = "mg_images i LEFT JOIN #mg_categories c ON (i.img_category = c.cat_id)";

$ps = $sch->parsesearch($table, $return_fields, $search_fields, $weights, "search_mgal", $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_mgal($Row){
	$con = new convert;
	$Res['link'] = e_GALLERY."view.php?".$Row['img_id'];
	$Res['pre_title'] = $Row['cat_name']." - ";
	$Res['title'] = $Row['img_name'];
	$Res['summary'] = $Row['img_description'] ? $Row['img_description'] : MG_SEARCH_PARSER_1;
	$User = explode(".", $Row['img_author'], 2);
	$Res['detail'] = LAN_SEARCH_7."<a href='user.php?id.".$User[0]."'>".$User[1]."</a>".LAN_SEARCH_8.$con->convert_date($Row['img_datestamp'], "long");
	return $Res;
}

?>