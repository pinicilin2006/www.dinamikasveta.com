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
|     $Source: /cvsroot/e107/e107_0.7/e107_languages/English/admin/help/search.php,v $
|     $Revision: 1.6 $
|     $Date: 2006/08/27 02:24:45 $
|     $Author: mcfly_e107 $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "If your MySQL server version supports it you can switch 
to the MySQL sort method which is faster than the PHP sort method. See preferences.<br /><br />
If your site includes Ideographic languages such as Chinese and Japanese you must 
use the PHP sort method and switch whole word matching off.";
$ns -> tablerender("Search Help", $text);
?>