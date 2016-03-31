<?php
/*
 * e107 website system
 *
 * Copyright (C) 2001-2008 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Plugin Administration - WebAnalytics
 *
 * $Source: 
 * $Revision: 1.2 $
 * $Date: 2009/11/09 09:50:06 $
 * $Author: arunshekher $
 *
*/

if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."webanalytics/languages/".e_LANGUAGE."/lan_wa_admin.php");

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = 'Web Analytics';
$eplug_version = "0.3";
$eplug_author = "Arun S. Sekhar (Arun, Physioblast)";
$eplug_url = "http://e107themes.net";
$eplug_email = "arun@e107themes.net";
$eplug_description = WEBA_PLUGIN_ALAN_2;
$eplug_compatible = "e107v0.7+";
$eplug_readme = "";

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "webanalytics";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "webanalytics_config.php";


// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/webanalytics_32.png";
$eplug_icon_small = $eplug_folder."/images/webanalytics_16.png";
$eplug_caption = WEBA_PLUGIN_ALAN_1;

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = "";


// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = "";

// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = "";

// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = WEBA_PLUGIN_ALAN_3;

// Upgrading -----------------------------------------------------------------------------------
$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done = WEBA_PLUGIN_ALAN_4;

//WebAnalytics Uninstall
if(!function_exists("webanalytics_uninstall")) {
	//Remove prefs entries during uninstall
	function webanalytics_uninstall() {
		global $sql;
		$sql->db_Delete("core", "e107_name = 'webanalytics_prefs'");		
	}
}


?>