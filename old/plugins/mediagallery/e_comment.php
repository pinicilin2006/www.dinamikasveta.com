<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: e_comment.php                                    |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/defines.php");

$e_plug_table = "mgal";
$reply_location = e_GALLERY."view.php?".$nid;
$db_table = "mg_images";
$link_name = "img_name";
$db_id = "img_id";
$plugin_name = $pref['mg_general_galname'];

?>