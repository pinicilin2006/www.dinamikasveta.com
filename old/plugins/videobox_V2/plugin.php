<?php
/*
+ ----------------------------------------------------------------------------------------------------+
|        e107 website system 
|        Plugin File :  e107_plugins/videobox_V2/plugin.php
|        Email: 
|        $Revision  1.0b$
|        $Date       28.5.2007$
|        $Author    Hups$
|        Support Sites :http://www.gw-world.de$ 
+----------------------------------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = videobox_V2;
$eplug_version = "1.0b";
$eplug_author = "hups";
$eplug_url = "";
$eplug_email = "";
$eplug_description = "videobox_V2";
$eplug_compatible = "e107 v0.77+";
$eplug_readme = "";       

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "videobox_V2";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/icon.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_logo = $eplug_folder."/images/icon.png";



// List of preferences -----------------------------------------------------------------------------------------------
$eplug_module = TRUE;
$eplug_conffile = "admin_config.php";


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "Installation Successful..";

$eplug_uninstall_done = "";

// upgrading ... //

$upgrade_remove_prefs = "";

$upgrade_alter_tables = "";

$eplug_upgrade_done = "";
?>