<?php
/*
+---------------------------------------------------------------+
|	e107 website system
| http://e107.org
|	/dtree_menu/dtree_menu.php
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
echo "<link rel='StyleSheet' href='".e_PLUGIN."/dtree_menu/dtree.css' type='text/css' />";
echo "<script type='text/javascript' src='".e_PLUGIN."dtree_menu/dtree.js'></script>\n\n";

unset($text);
$text.='<div class="dtree">';
$text.='<p><a href="javascript: d.openAll();">open all</a> | <a href="javascript: d.closeAll();">close all</a></p><br>';
$text.='<script type="text/javascript">';
$text.='d = new dTree("d");';
// configuration
$tmpvar = $menu_pref["dt_folderlinks"]?'true':'false';
$text.='d.config.folderLinks='.$tmpvar.';';
$tmpvar = $menu_pref["dt_useSelection"]?'true':'false';
$text.='d.config.useSelection='.$tmpvar.';';
$tmpvar = $menu_pref["dt_useCookies"]?'true':'false';
$text.='d.config.useCookies='.$tmpvar.';';
$tmpvar = $menu_pref["dt_useLines"]?'true':'false';
$text.='d.config.useLines='.$tmpvar.';';
$tmpvar = $menu_pref["dt_useIcons"]?'true':'false';
$text.='d.config.useIcons='.$tmpvar.';';
$tmpvar = $menu_pref["dt_useStatusText"]?'true':'false';
$text.='d.config.useStatusText='.$tmpvar.';';
$tmpvar = $menu_pref["dt_closeSameLevel"]?'true':'false';
$text.='d.config.closeSameLevel='.$tmpvar.';';
// nodes

if($results=$sql -> db_Select_gen("SELECT * FROM ".MPREFIX."dtree ORDER BY dt_level")){
  while($row = $sql -> db_Fetch()){
    extract($row);
    $tmpicon = $dt_icon? e_PLUGIN.'dtree_menu/images/'.$dt_icon:'';
    $tmpiconOpen = $dt_iconOpen? e_PLUGIN.'dtree_menu/images/'.$dt_iconOpen:'';
    if(!$dt_class || check_class($dt_class) || ($dt_class==254 && USER)){
      $text.='d.add('.$dt_id.','.$dt_pid.',"'.$dt_name.'","'.$dt_url.'","'.$dt_title.'","'.
             $dt_target.'","'.$tmpicon.'","'.$tmpiconOpen.'",'.$dt_open.');';
    }         
  }
}  
else {
$text.='d.add(0,-1,"SQL connect error");';
$text.='d.add(1,0,"Node 1","example01.html");';
$text.='d.add(2,0,"Node 2","example01.html");';
$text.='d.add(3,1,"Node 1.1","example01.html");';
$text.='d.add(4,0,"Node 3","example01.html");';
$text.='d.add(5,3,"Node 1.1.1","example01.html");';
$text.='d.add(6,5,"Node 1.1.1.1","example01.html");';
$text.='d.add(7,0,"Node 4","example01.html");';
$text.='d.add(8,1,"Node 1.2","example01.html");';
$text.='d.add(9,0,"My Pictures","example01.html","Pictures I\"ve taken over the years","","","'.e_PLUGIN.'dtree_menu/images/imgfolder.gif");';
$text.='d.add(10,9,"The trip to Iceland","example01.html","Pictures of Gullfoss and Geysir");';
$text.='d.add(11,9,"Mom\"s birthday","example01.html");';
$text.='d.add(12,0,"Recycle Bin","example01.html","","","'.e_PLUGIN.'dtree_menu/images/trash.gif");';
}
$text.='document.write(d);';

$text.='</script></div>';
$title = $menu_pref["dt_caption"];

$ns -> tablerender($title, $text); 
?>