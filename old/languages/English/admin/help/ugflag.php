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
|     $Source: /cvsroot/e107/e107_0.7/e107_languages/English/admin/help/ugflag.php,v $
|     $Revision: 1.3 $
|     $Date: 2006/09/20 14:04:31 $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "If you are upgrading e107 or just need your site to be offline for a while just tick the maintenance box and your visitors will be redirected to a page explaining the site is down for repair. After you've finished un-tick the box to return site to normal.";

$ns -> tablerender("Maintenance", $text);
?>
