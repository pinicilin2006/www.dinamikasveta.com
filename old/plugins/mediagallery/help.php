<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: help.php                                         |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

// Âêëþ÷àåì ÿçûêîâûå ôàéëû
include_lan(dirname(__FILE__)."/languages/".e_LANGUAGE."/lan_help.php");

switch (e_PAGE){
	case "admin_browse.php":
		$text = MG_HELP_1;
		break;
	case "admin_image.php":
		$text = MG_HELP_2;
		break;
	case "admin_media.php":
		$text = sprintf(MG_HELP_3, "<i>".wordwrap(substr(e_MEDIA, 6), 30, "<br />")."</i>");
		break;
	case "admin_category.php":
		$text = MG_HELP_4;
		break;
	case "admin_fmanager.php":
		$text = MG_HELP_5;
		break;
	case "admin_mmanager.php":
		$text = MG_HELP_6;
		break;
	case "admin_dmanager.php":
		$text = sprintf(MG_HELP_7, "<a href='http://en.wikipedia.org/wiki/Chmod' title='http://en.wikipedia.org/wiki/Chmod'>".MG_HELP_8."</a>");
		break;
	case "admin_config.php":
		$text = MG_HELP_9;
		break;
	case "admin_readme.php":
		$text = MG_HELP_10;
		break;
	case "admin_delete.php":
		$text = MG_HELP_11;
		break;
	case "admin_view.php":
		$text = MG_HELP_12;
		break;
}
$ns->tablerender(MG_HELP_13, $text);

?>