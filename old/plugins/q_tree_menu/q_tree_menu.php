<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/q_tree_menu.php                     |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : Displays the menu                               |
| Перевод :  -Tommi-                        |
|                                                               |
| ************************************************************* |
|	For the e107 website system © Steve Dunstan 2001-2003         |
|	http://e107.org -	jalist@e107.org                             |
|                                                               |
|	Released under the terms and conditions of the                |
|	GNU General Public License (http://gnu.org).                  |
+---------------------------------------------------------------+
*/

if (file_exists(e_PLUGIN."q_tree_menu/language/".e_LANGUAGE.".php"))
	  @require_once(e_PLUGIN."q_tree_menu/language/".e_LANGUAGE.".php");
else
   @require_once(e_PLUGIN."q_tree_menu/language/English.php");

$text = "
<script type='text/javascript'>function Go(){return}</script>
<script type='text/javascript' src='".e_BASE.e_HTTP.e_PLUGIN."q_tree_menu/menu_var.php'></script>
<script type='text/javascript' src='".e_BASE.e_HTTP.e_PLUGIN."q_tree_menu/menu_com.js'></script>

<center><div id='q_tree'></div></center>";

if ($pref['Q_Tree_am'] == 1)
   {require_once(e_HANDLER."sitelinks_class.php");
	   $sitelinks = new sitelinks;
  		$style = "";
	   $text .= "<noscript>".$sitelinks->get(1,$style)."</noscript>";
   }

$ns -> tablerender(Q_TREE_L1, $text);
?>