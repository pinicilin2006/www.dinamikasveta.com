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
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/newsfeed/newsfeed_menu.php,v $
|     $Revision: 1.8 $
|     $Date: 2006/04/14 14:09:53 $
|     $Author: mcfly_e107 $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

include_once(e_PLUGIN."newsfeed/newsfeed_functions.php");
$info = newsfeed_info('all', 'menu');
if($info['text'])
{
	$ns->tablerender($info['title'], $info['text']);
}
?>