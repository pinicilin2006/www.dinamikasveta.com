<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_search.php                                     |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

global $pref;

$search_info[] = array("sfile" => dirname(__FILE__)."/search/search_parser.php", "qtype" => $pref['mg_general_galname'], "refpage" => "view.php", "advanced" => dirname(__FILE__)."/search/search_advanced.php");

?>