<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©smscoin
|     http://smscoin.com
|     
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/smskey/plugin.php,v $
|     $Revision: 0.1b $
|     $Date: 2008/02/14 21:02:23 $
|     $Author: smscoin $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

@include_once(e_PLUGIN."smskey/languages/".e_LANGUAGE.".php");
@include_once(e_PLUGIN."smskey/languages/English.php");

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "SMS_LANINS_1";
$eplug_version = "0.1";
$eplug_author = "smscoin";
$eplug_url = "http://smscoin.com";
$eplug_email = "";
$eplug_description = SMS_LANINS_2;
$eplug_compatible = "e107v7+";
$eplug_readme = "";
// leave blank if no readme file

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "smskey";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
//$eplug_conffile = "admin_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------

$eplug_caption = LWLANINS_3;

// List of preferences -----------------------------------------------------------------------------------------------

$eplug_array_pref = array(
	'tohtml_hook' => 'smskey'
	);
$eplug_prefs = array();

// List of table names -----------------------------------------------------------------------------------------------
//$eplug_table_names = array();

// List of sql requests to create tables -----------------------------------------------------------------------------
//$eplug_tables = array();


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$ec_dir = e_PLUGIN."";
$eplug_link_url = "";


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = SMS_LANINS_3;


// upgrading ... //

$upgrade_add_prefs = array();

$upgrade_remove_prefs = "";

$upgrade_alter_tables = "";

$eplug_upgrade_done = "";





?>
