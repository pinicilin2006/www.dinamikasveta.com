<?php
/*
+---------------------------------------------------------------+
|	e107 website system
| http://e107.org
|	/dtree_menu/readme.php
|
| Revision: 1.0 
| Date: 2005/01/24
| Author: Izydor 2005
|	http://cennik.net
|	Izydor@cennik.net
|
| Based on javascript by Geir Landrö (evdwal@xs4all.nl)
| dTree 2.05 | http://www.destroydrop.com/javascripts/tree/ 
|
|	Released under the terms and conditions of the	
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/
require_once("../../class2.php");
$ec_dir = e_PLUGIN."dtree_menu/";
$lan_file = $ec_dir."languages/".e_LANGUAGE.".php";
include(file_exists($lan_file) ? $lan_file : e_PLUGIN."dtree_menu/languages/English.php");
require_once(HEADERF);

$caption = DT_LAN_46;

$text = "
<div class='forumheader'>".DT_LAN_46."</div>
 <div class='forumheader3'>".DT_LAN_47."</div><br />
 <div class='forumheader'>".DT_LAN_48."</div>
 <div class='forumheader3'>".DT_LAN_49."</div><br />
 <div class='forumheader'>".DT_LAN_50."</div>
 <div class='forumheader3'>".DT_LAN_51."</div><br />";

$ns -> tablerender($caption, $text);
require_once(FOOTERF);

?>