<?php
/*
+---------------------------------------------------------------+
|	e107 website system
| http://e107.org
|	/dtree_menu/plugin.php
|
| Revision: 1.0 
| Date: 2005/01/24
| Author: Izydor 2005
|	http://cennik.net
|	Izydor@cennik.net
|
| Based on javascript by Geir Landrц (evdwal@xs4all.nl)
| dTree 2.05 | http://www.destroydrop.com/javascripts/tree/ 
|
|	Released under the terms and conditions of the	
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/
// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "dTree Menu";
$eplug_version = "1.0";
$eplug_author = "Izydor. Перевод SaM.";
$eplug_logo = "";
$eplug_url = "http://www.cennik.net";
$eplug_email = "Izydor@cennik.com";
$eplug_description = "dTree Menu - древовидное меню сделанное в стиле XP";
$eplug_compatible = "e107v617";
$eplug_readme = "readme.php";	// leave blank if no readme file

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "dtree_menu";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "dtree_menu";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "dtree_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = "";
$eplug_caption =  "Configure dTree Menu";

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs ="";

//Variable  	Type  	Default  	Description
//target 	String 	true 	Target for all the nodes.
//folderLinks 	Boolean 	true 	Should folders be links.
//useSelection 	Boolean 	true 	Nodes can be selected(highlighted).
//useCookies 	Boolean 	true 	The tree uses cookies to rember it's state.
//useLines 	Boolean 	true 	Tree is drawn with lines.
//useIcons 	Boolean 	true 	Tree is drawn with icons.
//useStatusText 	Boolean 	false 	Displays node names in the statusbar instead of the url.
//closeSameLevel 	Boolean 	false 	Only one node within a parent can be expanded at the same time. 
//                                  openAll() and closeAll() functions do not work when this is enabled.
//inOrder 	Boolean 	false 	If parent nodes are always added before children, setting this to true speeds up the tree.

$eplug_menu_prefs =
array(
	"dt_folderlinks" => true,
	"dt_useSelection" => true,
	"dt_useCookies" => true,
	"dt_useLines" => true,
	"dt_useIcons" => true,
	"dt_useStatusText" => false,
	"dt_closeSameLevel" => false,
	"dt_caption" => "dTree Menu",
	"dt_captionstyle" => "caption",
	);
if(!$menu_pref[dt_captionstyle]){
	if(is_array($eplug_menu_prefs)){
		while(list($key, $e_pref) = each($eplug_menu_prefs)){
			if(!in_array($pref, $e_pref)){
				$menu_pref[$key] = $e_pref;
			}
		}
  $sqldtreemenu = new db;
	$tmp = addslashes(serialize($menu_pref));
	$sqldtreemenu -> db_Update("core", "e107_value='$tmp' WHERE e107_name='menu_pref' ");
			
  }
}
	
	
// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = array(
	"dtree"
);

//Parameters
//Name 	Type 	Description
//id 	Number 	Unique identity number.
//pid 	Number 	Number refering to the parent node. The value for the root node has to be -1.
//name 	String 	Text label for the node.
//url 	String 	Url for the node.
//title 	String 	Title for the node.
//target 	String 	Target for the node.
//icon 	String 	Image file to use as the icon. Uses default if not specified.
//iconOpen 	String 	Image file to use as the open icon. Uses default if not specified.
//open 	Boolean 	Is the node open.

// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = array(
	"
CREATE TABLE ".MPREFIX."dtree (
  dt_id int(10) unsigned NOT NULL auto_increment,
  dt_pid int(10) NOT NULL default -1,
  dt_level int(10) NOT NULL default 1,
  dt_name varchar(100) NOT NULL default '',
  dt_url varchar(200) NOT NULL default '',
  dt_title varchar(100) NOT NULL default '',
  dt_target varchar(100) NOT NULL default '',
  dt_icon varchar(100) NOT NULL default '',
  dt_iconOpen varchar(100) NOT NULL default '',
	dt_open tinyint(1) unsigned NOT NULL default 0,
  dt_class int(10) unsigned NOT NULL default 0,	
  PRIMARY KEY  (dt_id)
) TYPE=MyISAM;");
	

    $sqldtreemenu = new db;
    if(!$sqldtreemenu -> db_Select("dtree")){    
	    $sqldtreemenu -> db_Insert("dtree", "0,-1,0,'Default Tree','','','','','',0,0");
	    $sqldtreemenu -> db_Insert("dtree", "0,1,1,'Node 1','forum.php','Forum','','','',0,0");	
	    $sqldtreemenu -> db_Insert("dtree", "0,1,1,'Node 2','news.php','News','','','',0,0");		
	    $sqldtreemenu -> db_Insert("dtree", "0,2,2,'Node 1.1','user.php','Members','','','',0,0");		
	    $sqldtreemenu -> db_Insert("dtree", "0,4,3,'Node 1.1.1','stats.php','Stats','','','',0,0");			
    }  

// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "To activate please go to your menus screen and select the dtree_menu into one of your menu areas.";
$eplug_done .= "(Русский: Для активации, пожалуйста войдите в Админцентр-Меню и расположите Dtree_menu в удобной Вам области)";

// upgrading ... //

$upgrade_add_prefs = "";

$upgrade_remove_prefs = "";

$upgrade_alter_tables = "";

$eplug_upgrade_done = "";
?>	