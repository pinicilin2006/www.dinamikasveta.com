<?php
/*
+---------------------------------------------------------------+
|	e107 website system
| http://e107.org
|	/dtree_menu/help.php
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
//require_once(HEADERF);

    $helptitle = DT_LAN_53;

    $text = DT_LAN_47;
    $text .= "<br />".DT_LAN_52;

$ns -> tablerender($helptitle, $text);
?>
