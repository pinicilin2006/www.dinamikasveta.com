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
|     $Source: /cvsroot/e107/e107_0.7/e107_languages/English/admin/help/content.php,v $
|     $Revision: 1.3 $
|     $Date: 2006/08/27 02:24:44 $
|     $Author: mcfly_e107 $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "You can add a normal page to your site using this feature. A link to the new page will be created in your main site navigation box. For example, if you create a new page with the Link Name 'Test', a link called 'Test' will appear in your links box after submitting the new page.<br />
If you want your content page to have a caption, enter it in the Page Heading box.";
$ns -> tablerender("Content Help", $text);
?>