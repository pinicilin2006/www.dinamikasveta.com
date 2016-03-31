<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        �Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: plugin.php                                       |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

// ��������� ����������������� ����� �������
require_once(dirname(__FILE__)."/defines.php");

// �������� �������� �����
include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_plugin.php");

// ���������� � �������
$eplug_name = MG_PLUGIN_1;
$eplug_version = "1.4";
$eplug_author = "soulhunter";
$eplug_url = "http://weblife-support.ru";
$eplug_email = "darksport@users.mns.ru";
$eplug_description = MG_PLUGIN_2;
$eplug_compatible = "e107v7+";
$eplug_readme = "admin_readme.php";
$eplug_latest = TRUE;
$eplug_status = TRUE;
$eplug_compliant = TRUE;

// �������� ���������� �������
$eplug_folder = basename(e_GALLERY);

// ������ �������
$eplug_icon = $eplug_folder."/images/logo_32.png";
$eplug_icon_small = $eplug_folder."/images/logo_16.png";

// ���� ���� �������
$eplug_menu_name = "mediagallery_menu";

// ������� ���������������� ����
$eplug_conffile = "admin_browse.php";

// �������� ������
$eplug_caption = MG_PLUGIN_3;

// ��� �������� ������������
$eplug_comment_ids = array("mgal");

// �������� ���������
$eplug_prefs = array(
	// ����� ���������
	"mg_general_galname" => MG_PLUGIN_1,
	"mg_general_catname" => MG_PLUGIN_4,
	"mg_general_imgname" => MG_PLUGIN_5,
	// ��������� ���������
	"mg_view_size" => "500*375",
	"mg_view_autoplay" => 1,
	"mg_view_download" => 1,
	"mg_view_bgcolor" => "#000000",
	// ��������� ������
	"mg_thumb_size" => "110*110",
	"mg_thumb_columns" => 4,
	"mg_thumb_rows" => 4,
	"mg_thumb_namelength" => 20,
	"mg_thumb_urlthumbs" => 1,
	"mg_thumb_shownew" => 1,
	"mg_thumb_sortfield" => 0,
	"mg_thumb_sortorder" => 0,
	// ������ �����������
	"mg_resize_quality" => 80,
	// ��������� ��������
	"mg_upload_fileinfo" => 1,
	"mg_upload_agreement" => "",
	"mg_upload_limit" => 20,
	"mg_upload_filesize" => "",
	// ���������������� �������
	"mg_create_limit" => "",
	"mg_create_agreement" => "",
	"mg_create_forcename" => 0,
	// ��������� �����
	"mg_wallpapers_reslist" => "800*600\n1024*768\n1280*960\n1600*1200",
	"mg_wallpapers_tempsize" => "104857600",
	// ��������� ���������� � ���
	"mg_ftp_login" => "",
	"mg_ftp_password" => "",
	// ��������� ����� ����
	"mg_menu_randname" => MG_PLUGIN_6,
	"mg_menu_newname" => MG_PLUGIN_7,
	"mg_menu_ratename" => MG_PLUGIN_8,
	"mg_menu_random" => 2,
	"mg_menu_new" => 2,
	"mg_menu_rating" => 2,
	"mg_menu_types" => "image.wallpaper.video.audio",
	// �������� �����������������
	"mg_check_gd" => 1,
	"mg_check_dirs" => 1,
	"mg_check_url" => 1,
	// ��������� ������
	"mg_mode_prof" => 0,
	// ��������� ������ �����������
	"mg_protect_files" => 0,
	"mg_protect_type" => 0,
	"mg_protect_image" => "",
	"mg_protect_text" => "",
	"mg_protect_font" => "../".e_GALLERY."fonts/Advergothic.ttf",
	"mg_protect_fontsize" => 24,
	"mg_protect_fontcolor" => "#000000",
	"mg_protect_fontangle" => 0,
	"mg_protect_pos" => 9,
	"mg_protect_offset" => 10
);

// ������ ����������� ������
$eplug_table_names = array("mg_categories", "mg_images");
$eplug_tables = array(
	// ������� �������
	"CREATE TABLE ".MPREFIX."mg_categories (
		cat_id				int(10)		unsigned	NOT NULL auto_increment,
		cat_name			varchar(100)			NOT NULL,
		cat_description		text					NOT NULL,
		cat_thumb			varchar(100)			NOT NULL,
		cat_author			varchar(100)			NOT NULL,
		cat_category		int(10)		unsigned	NOT NULL,
		cat_class_view		smallint(3)	unsigned	NOT NULL,
		cat_class_submit	smallint(3)	unsigned	NOT NULL,
		cat_class_create	smallint(3)	unsigned	NOT NULL,
		cat_user_cat		tinyint(1)	unsigned	NOT NULL,
		cat_submode			tinyint(1)	unsigned	NOT NULL,
		cat_conf_submit		tinyint(1)	unsigned	NOT NULL,
		cat_datestamp		int(10)		unsigned	NOT NULL,
		cat_order			int(10)		unsigned	NOT NULL,
		PRIMARY KEY (cat_id)
	) TYPE=MyISAM;",
	// ������� ������
	"CREATE TABLE ".MPREFIX."mg_images (
		img_id				int(10)		unsigned	NOT NULL auto_increment,
		img_name			varchar(100) 			NOT NULL,
		img_description 	text					NOT NULL,
		img_thumb			varchar(255)			NOT NULL,
		img_image			varchar(255)			NOT NULL,
		img_datestamp		int(10)		unsigned	NOT NULL,
		img_category		int(10)		unsigned	NOT NULL,
		img_comments		tinyint(1)	unsigned	NOT NULL,
		img_author			varchar(100)			NOT NULL,
		img_author_email	varchar(150)			NOT NULL,
		img_author_homepage	varchar(150)			NOT NULL,
		img_views			int(10)		unsigned	NOT NULL,
		img_type			varchar(9)				NOT NULL,
		img_size			int(10)		unsigned	NOT NULL,
		img_width			int(5)		unsigned	NOT NULL,
		img_height			int(5)		unsigned	NOT NULL,
		img_email_print		tinyint(1)	unsigned	NOT NULL,
		PRIMARY KEY (img_id)
	) TYPE=MyISAM;",
	// �������� �������� ��������
	"INSERT INTO ".MPREFIX."mg_categories (cat_id, cat_name, cat_description, cat_datestamp, cat_author) VALUES ( 1, '".MG_PLUGIN_9."', '".MG_PLUGIN_10."', '".time()."', '".USERID.".".USERNAME."');"
);

// �������� ������ � ������� ����
$eplug_link = TRUE;
$eplug_link_name = MG_PLUGIN_1;
$eplug_link_url = e_GALLERY."browse.php";

// ����� ��� ����������� ��� �������� ��������� �������
$eplug_done = sprintf(MG_PLUGIN_11, $eplug_version);

// ��������� ��� ���������� ����� �������
$upgrade_add_prefs = array(
	"mg_create_forcename" => 0,
	"mg_thumb_sortfield" => 0,
	"mg_thumb_sortorder" => 0
);
$upgrade_remove_prefs = "";
$upgrade_alter_tables = array(
	"ALTER TABLE ".MPREFIX."mg_categories CHANGE cat_class_view cat_class_view smallint(3) unsigned NOT NULL",
	"ALTER TABLE ".MPREFIX."mg_categories CHANGE cat_class_submit cat_class_submit smallint(3) unsigned NOT NULL",
	"ALTER TABLE ".MPREFIX."mg_categories CHANGE cat_class_create cat_class_create smallint(3) unsigned NOT NULL",
	"ALTER TABLE ".MPREFIX."mg_images CHANGE img_thumb img_thumb varchar(255) NOT NULL",
	"ALTER TABLE ".MPREFIX."mg_images CHANGE img_image img_image varchar(255) NOT NULL"
);

// ����� ��� �������� ����������
$eplug_upgrade_done = sprintf(MG_PLUGIN_12, $eplug_version);

// �������������� �������
if (!function_exists("mediagallery_uninstall")){
	function mediagallery_uninstall(){
		global $sql;
		$sql->db_Delete("rate", "rate_table = 'mgal'");
	}
}

?>