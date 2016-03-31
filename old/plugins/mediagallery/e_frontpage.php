<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_frontpage.php                                  |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/defines.php");

$front_page['mediagallery'] = array("page" => e_GALLERY."browse.php", "title" => $pref['mg_general_galname']);

?>