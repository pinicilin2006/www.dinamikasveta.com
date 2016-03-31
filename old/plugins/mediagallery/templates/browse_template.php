<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: templates/browse_template.php                    |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Начало таблицы
$TABLE_START = "<div style='text-align:center;'>
<table class='fborder' style='width:97%'>";

// Галереи
$CAT_TABLE_NAME = "<tr>
<td style='text-align:center;' colspan='{COLUMNS}' class='forumheader'>{NAME}</td>
</tr>";

$CAT_TABLE_TABLET = "<td style='vertical-align:middle; text-align:center; width:{WIDTH};' class='forumheader3'>
<a href='{LINK}'><img style='border:0px;' src='{IMAGE}' title='{TITLE}' alt='' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' /></a><br />{NAME} ({IMAGES}) {NEWIMAGES}
</td>";

$CAT_TABLE_TABLET_NOTHUMB = "<td style='vertical-align:top; width:{WIDTH};' class='forumheader3'>
<div style='width:100%; text-align:center;'><a href='{LINK}'><b>{NAME}</b></a> {NEWIMAGES}</div>
<div style='width:100%;' text-align:left;'>
<b>".MG_BROWSE_3."</b> {IMAGES}<br />
<b>".MG_BROWSE_4."</b> {SIZE}<br />
<b>".MG_BROWSE_5."</b> {AUTHOR}<br />
<b>".MG_BROWSE_6."</b> {DATE}<br />
<b>".MG_BROWSE_7."</b> {LAST}
</div>
</td>";

$CAT_TABLE_TABLET_EMPTY = "<td style='vertical-align:middle; text-align:center; width:{WIDTH};' class='forumheader3'>&nbsp</td>";

$CAT_TABLE_ROW = "<tr>
<td class='forumheader3' rowspan='2' style='width:5%; vertical-align:middle; text-align:center;'><a href='{LINK}'><img style='border:0px;' src='{IMAGE}' title='{TITLE}' alt='' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' /></a></td>
<td class='forumheader3' colspan='{WIDTH}'><a href='{LINK}'>{NAME}</a> ({IMAGES}) {NEWIMAGES}</td>
</tr><tr>
<td class='forumheader3' colspan='{WIDTH}'><font class='mediumtext'>{DESCRIPTION}</span></td>
</tr>";

$CAT_TABLE_INFO = "<tr>
<td class='forumheader3' colspan='{COLUMNS}' style='text-align:center;'>{SHOWING}</td>
</tr><tr>
<td class='forumheader2' colspan='{COLUMNS}'>
<table style='width:100%;'>
<tr>
<td style='width:33%; text-align:left;'>{PREVBUTTON}</td>
<td style='width:34%; text-align:center;'>{BACKBUTTON}</td>
<td style='width:33%; text-align:right;'>{NEXTBUTTON}</td>
</tr>
</table>
</td>
</tr>";

// Изображения
$IMG_TABLE_NAME = "<tr>
<td style='text-align:center;' colspan='{COLUMNS}' class='forumheader'>{NAME}</td>
</tr>";

$IMG_TABLE_SORT = "<tr>
<td class='forumheader3' style='text-align:center;' colspan='{COLUMNS}'>
<form method='post' action='{ACTION}'>".MG_BROWSE_22." {FIELD} ".MG_BROWSE_23." {ORDER} {SORTBUTTON}</form>
</td>
</tr>";

$IMG_TABLE_TABLET = "<td style='vertical-align:middle; text-align:center; width:{WIDTH};' class='forumheader3'>
<a href='{LINK}'><img style='border:0px;' src='{IMAGE}' title='{TITLE}' alt='' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' /></a><br />{NAME}
</td>";

$IMG_TABLE_TABLET_EMPTY = "<td style='vertical-align:middle; text-align:center; width:{WIDTH};' class='forumheader3'>&nbsp</td>";

$IMG_TABLE_INFO = "<tr>
<td class='forumheader3' colspan='{COLUMNS}' style='text-align:center;'>{SHOWING}</td>
</tr><tr>
<td class='forumheader2' colspan='{COLUMNS}'>
<table style='width:100%;'>
<tr>
<td style='width:33%; text-align:left;'>{PREVBUTTON}</td>
<td style='width:34%; text-align:center;'>{BACKBUTTON}</td>
<td style='width:33%; text-align:right;'>{NEXTBUTTON}</td>
</tr>
</table>
</td>
</tr>";

// Конец таблицы
$TABLE_EMPTY = "<tr>
<td class='forumheader3' style='text-align:center;' colspan='{COLUMNS}'>".MG_BROWSE_28."</td>
</tr><tr>
<td class='forumheader2' style='text-align:center;'>{BACKBUTTON}</td>
</tr>";

$TABLE_ACTION = "<tr>
<td class='forumheader2' colspan='{COLUMNS}' style='text-align:center;'>{SUBMITIMAGE} {SUBMITMEDIA} {CREATECATEGORY}</td>
</tr>";

$TABLE_END = "</table>
</div>";

?>