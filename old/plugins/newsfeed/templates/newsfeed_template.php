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
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/newsfeed/templates/newsfeed_template.php,v $
|     $Revision: 1.7 $
|     $Date: 2006/11/13 12:25:00 $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$NEWSFEED_MAIN_CAPTION = NFLAN_38;

$NEWSFEED_LIST_START = "
<table style='width: 100%;' class='fborder'>\n";

$NEWSFEED_LIST = "
<tr>
<td style='width: 30%;' class='forumheader3'>{FEEDNAME}</td>
<td style='width: 70%;' class='forumheader3'>{FEEDDESCRIPTION}</td>
</tr>\n";

$NEWSFEED_LIST_END = "
</table>\n";

$NEWSFEED_MAIN_START = "
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader'>{FEEDIMAGE} {FEEDTITLE}</td>
</tr>
<tr>
<td class='forumheader3'>
<ul>\n";

$NEWSFEED_MAIN = "
<li><b>{FEEDITEMLINK}</b> <span class='smalltext'>{FEEDITEMCREATOR}</span><br />{FEEDITEMTEXT}<br /><br /></li>\n";


$NEWSFEED_MAIN_END = "
</ul>
</td>
</tr>

<tr>
<td class='forumheader3' style='text-align: right;'><span class='smalltext'>{FEEDCOPYRIGHT} | {FEEDLASTBUILDDATE}</td>
</tr>

<tr>
<td class='forumheader3' style='text-align: center;'><span class='smalltext'>{BACKLINK}</td>
</tr>
</table>\n";


?>
