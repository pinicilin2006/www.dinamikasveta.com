<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/plugin.php                          |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : Install menu                                    |
| Перевод :  -Tommi-                        |
|                                                               |
| ************************************************************* |
| For the e107 website system © Steve Dunstan 2001-2005         |
| http://e107.org - jalist@e107.org                             |
|                                                               |
| Released under the terms and conditions of the                |
| GNU General Public License (http://gnu.org).                  |
+---------------------------------------------------------------+
*/

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "Q Tree Menu";
$eplug_version = "3.2";
$eplug_date = "20-01-2006";
$eplug_author = "Rijk van Wel (Ridge)";
$eplug_logo = "images/q_tree_logo.jpg";
$eplug_url = "http://www.rijkvanwel.nl";
$eplug_email = "e107@rijkvanwel.nl";
$eplug_description = "Динамическое навигационное меню с неограниченным колличеством подменю.";
$eplug_compatible = "e107 v0.7";
$eplug_readme = "readme.php";    
$eplug_compliant = TRUE;
// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "q_tree_menu";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "q_tree_menu";  // _menu is no longer required in 0.7.

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";  // use admin_ for all admin files.

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/icon_32.gif";
$eplug_icon_small = $eplug_folder."/images/icon_16.gif";
$eplug_caption =  "Q Tree Menu настройки";

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array(
   "Q_Tree_date" => $eplug_date,

	 	"Q_Tree_mainwidth"  => 150,
   "Q_Tree_mainheight" => 20,
   "Q_Tree_subwidth"   => 150,
   "Q_Tree_subheight"  => 20,
   
   "Q_Tree_mainfontfamily" => "Verdana,Arial,sans-serif",
   "Q_Tree_mainfontsize"   => 11,
   "Q_Tree_subfontfamily"  => "Verdana,Arial,sans-serif",
   "Q_Tree_subfontsize"    => 10,

   "Q_Tree_mainbgimage" => "",
   "Q_Tree_subbgimage"  => "",

   "Q_Tree_lowbgcolor"    => "FFFFFF",
   "Q_Tree_highbgcolor"   => "888888",
   "Q_Tree_fontlowcolor"  => "000000",
   "Q_Tree_fonthighcolor" => "FFFFFF",
   "Q_Tree_bordercolor"   => "FF9900",

   "Q_Tree_borderwidthmain" => 1,
   "Q_Tree_borderwidthsub"  => 1,
   "Q_Tree_borderbtwnmain"  => 1,
   "Q_Tree_borderbtwnsub"   => 1,

   "Q_Tree_mainbold"   => 0,
   "Q_Tree_subbold"    => 0,
   "Q_Tree_fontitalic" => 0,
   "Q_Tree_textalign"  => "left",

   "Q_Tree_am"  => 1,
   "Q_Tree_uoc" => 0,
   "Q_Tree_flh" => 0,
   "Q_Tree_co"  => .2,
   "Q_Tree_cvo" => .2,
   "Q_Tree_st"  => 0,
   "Q_Tree_sl"  => 0,
   "Q_Tree_lp"  => 10,
   "Q_Tree_tp"  => 3,
   "Q_Tree_dd"  => 1000,
   "Q_Tree_ud"  => 200,
   "Q_Tree_rtl" => 0,
   "Q_Tree_bu"  => 0,
   "Q_Tree_hb"  => 0,
   "Q_Tree_hi"  => 0,
   "Q_Tree_hul" => 0,
   "Q_Tree_hts" => 0,
   "Q_Tree_hv"  => 0,
   "Q_Tree_mvc" => "top",
   "Q_Tree_bod" => 0,
   "Q_Tree_bp"  => 0,
   "Q_Tree_pl"  => 1,

   "Q_Tree_slide"   => 0,
   "Q_Tree_shadow"  => 0,
   "Q_Tree_opacity" => 1,
);

$eplug_link = FALSE;
$eplug_done = "Q Tree Menu успешно установлено! <b>Для того, чтобы его включить, перейдите в раздел <i>Menus (Меню)</i>, который находится в Админцентре.</b><br /><br />
               <br />
               Если у вас возникнут вопросы, пожалуйста прочтите Описание плагина или вы можете связаться с раздработчиком через электронную почту: <a href=\"mailto:e107@rijkvanwel.nl\">e107@rijkvanwel.nl</a>.<br /><br />";

$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$eplug_upgrade_done = "";

?>