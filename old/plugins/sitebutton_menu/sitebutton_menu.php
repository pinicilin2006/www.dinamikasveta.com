<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/sitebutton_menu/sitebutton_menu.php,v $
|     $Revision: 1.5 $
|     $Date: 2005/12/14 19:28:52 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

$ns->tablerender(SITEBUTTON_MENU_L1, "<div style='text-align:center'>\n<a href='".SITEURL."'><img src='".(strstr(SITEBUTTON, "http:") ? SITEBUTTON : e_IMAGE.SITEBUTTON)."' alt='".SITEBUTTON_MENU_L1."' style='border: 0px; width: 88px; height: 31px' /></a>\n</div>", 'sitebutton');
?>