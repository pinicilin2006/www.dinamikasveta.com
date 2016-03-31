<?php
/*
+---------------------------------------------------------------+
|	e107 website system
| http://e107.org
|	/dtree_menu/admin_menu.php
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
    require_once(e_ADMIN."auth.php");

    if($action==""){$action="main";}    
    $var['main']['text']=DT_LAN_1;
    $var['main']['link']=e_SELF;

    $var['create']['text']=DT_LAN_2;
    $var['create']['link']=e_SELF."?create";

    $var['edidel']['text']=DT_LAN_37;
    $var['edidel']['link']=e_SELF."?edidel";
    
    $var['prune']['text']=DT_LAN_3;
    $var['prune']['link']=e_SELF."?prune";

    $var['copy']['text']=DT_LAN_4;
    $var['copy']['link']=e_SELF."?copy";
    show_admin_menu(DT_LAN_5,$action,$var);
   
?>
