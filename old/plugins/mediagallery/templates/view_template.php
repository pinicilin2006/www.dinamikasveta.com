<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: templates/view_template.php                      |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

$TABLE = "<div style='text-align:center;'>
<table style='width:97%;' class='fborder'>
<tr>
<td class='forumheader' style='text-align:center;' colspan='3'>{NAME}</td>
</tr><tr>
<td style='text-align:center;' colspan='3' class='forumheader3'>{IMAGE}</td>
</tr><tr>
<td class='forumheader2' colspan='2' style='text-align:center; width:50%;'>".MG_VIEW_7."</td>
<td class='forumheader2' style='text-align:center; width:50%'>".MG_VIEW_8."</td>
</tr><tr>
<td class='forumheader3'>".MG_VIEW_9."</td>
<td class='forumheader3'>{DATESTAMP}</td>
<td rowspan='4' class='forumheader3' style='vertical-align:top;'>{DESCRIPTION}</td>
</tr><tr>
<td class='forumheader3'>".MG_VIEW_11."</td>
<td class='forumheader3' style='text-align:center;'><b>{AUTHOR_NAME}</b><br />{AUTHOR_PROFILE} {AUTHOR_EMAIL} {AUTHOR_HOMEPAGE}</td>
</tr><tr>
<td class='forumheader3'>".MG_VIEW_15."</td>
<td class='forumheader3'>{VIEWS}</td>
</tr><tr>
<td class='forumheader3'>".MG_VIEW_16."</td>
<td class='forumheader3'>{OPTION_DOWNLOAD} {OPTION_EXTERNAL} {OPTION_EMAIL_PRINT} {OPTION_ADMIN}</td>
</tr><tr>
<td class='forumheader3'>".MG_VIEW_26."</td>
<td class='forumheader3' colspan='2'>{RATING}</td>
</tr><tr>
<td colspan='3' class='forumheader2'>
<table style='width:100%;'>
<tr>
<td style='text-align:left; width:33%;'>{PREVBUTTON}</td>
<td style='text-align:center; width:34%;'>{BACKBUTTON}</td>
<td style='text-align:right; width:33%;'>{NEXTBUTTON}</td>
</tr>
</table>
</td>
</tr>
</table>
</div>";

$ICONTOOLTIP = "<div style='border:1px solid #000000; width:{WIDTH}; height:{HEIGHT};'>{ICON}</div>";

?>