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
|     $Source: /cvsroot/e107/e107_0.7/subcontent.php,v $
|     $Revision: 1.6 $
|     $Date: 2005/12/21 21:55:20 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/
require_once("class2.php");

//redirection to new content management plugin if it is installed
if ($sql -> db_Select("plugin", "*", "plugin_path = 'content' AND plugin_installflag = '1' ")){ 
	header("location:".e_PLUGIN."content/content_submit.php");
} else {
	header("location:".e_BASE."index.php");
}
	
?>