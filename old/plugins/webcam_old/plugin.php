<?php
// Plugin info -------------------------------------------------------------------------------------------------------
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
$eplug_name = "Web Cam";
$eplug_version = "1.8";
$eplug_author = "Barry";
$eplug_url = "http://www.keal.me.uk";
$eplug_email = "";
$eplug_description = WCAM_A81;
$eplug_compatible = "e107v7";
$eplug_readme = "readme.pdf"; // leave blank if no readme file
$eplug_compliant = true;
$eplug_status = true;
$eplug_latest = true;
// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "webcam";
// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "WebCam";
// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";
// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder . "/images/webcam_32.png";
$eplug_icon_small = $eplug_folder . "/images/webcam_16.png";
$eplug_caption = WCAM_A83;
// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array(
	"webcam_menutitle" => WCAM_A83,
    "webcam_readclass" => 0,
    "webcam_submitclass" => 0,
    "webcam_adminclass" => 255,
    "webcam_ownclass" => 255,
    "webcam_autoapp" => 0,
    "webcam_perpage" => 5,
    "webcam_inmenu" => 5,
    "webcam_report" => 1,
    "webcam_cols" => 3,
    "webcam_comment" => 1,
    "webcam_rate" => 1,
    "webcam_rand" => 1,
    "webcam_defref" => 60,
    "webcam_opennew"=>1,
	"webcam_mh"=>"120",
    "webcam_mw"=>"120",
    "webcam_desc" => "Father Barry e107 web cam plugin",
    "webcam_key" => "father barry,barry,keal,e107plugin,web cam,webcam,keal"

    );
// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = array("webcams");
// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = array("
CREATE TABLE " . MPREFIX . "webcams (
  webcam_id int(10) unsigned not null AUTO_INCREMENT,
  webcam_name varchar(50) not null default '',
  webcam_refresh int(10) unsigned not null default 0,
  webcam_approved int(10) unsigned not null default 0,
  webcam_url text not null ,
  webcam_description text not null ,
  webcam_poster varchar(100) not null default '0.Anon',
  webcam_provider varchar(100) not null default '',
  webcam_providerurl varchar(100) not null default '',
  webcam_location varchar(100) not null default '',
  webcam_updated int(10) unsigned not null default 0,
  webcam_order int(10) unsigned not null default 1,
  webcam_views int(10) unsigned not null default 0,
  webcam_menu int(10) unsigned not null default 0,
    PRIMARY KEY (webcam_id)
  ) TYPE=MyISAM;");
// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = true;
$eplug_link_name = WCAM_A83;
$eplug_link_url = e_PLUGIN . "webcam/webcam.php";
// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = WCAM_A84;
// upgrading ... //
$upgrade_add_prefs = "";

$upgrade_remove_prefs = "";

$upgrade_alter_tables = "";
$eplug_upgrade_done = "";
if (!function_exists("webcam_uninstall"))
{
    function webcam_uninstall()
    {
        global $sql;
        $sql->db_Delete("rate", " rate_table='webcams' ");
        $sql->db_Delete("comments", " comment_type='webcams' ");
    }
}

?>
