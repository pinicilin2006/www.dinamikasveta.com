<?php
/*
*******************************************************************
	Deep Blue II v1.0
	a theme for e107 0.700+

	by Mattias Ahlvin (2Tall)
	http://www.ahlvin.net
	2tallthemes@gmail.com

	Released under Creative Commons	Attribution-ShareAlike 3.0
	http://creativecommons.org/licenses/by-sa/3.0/

	Background photo:
	Sourcelink: http://commons.wikimedia.org/wiki/Image:LightningVolt_Deep_Blue_Sea.jpg
	Photo Title: LightningVolt Deep Blue Sea.jpg by Lars Lentz (http://www.lightningvolt.com)
	Used under the Creative Commons Attribution ShareAlike 1.0 License

********************************************************************
*/
$themename = " Deep Blue II ";
$themeversion = "1.0";
$themeauthor = " 2Tall ";
$themeemail = "2tallthemes@gmail.com";
$themewebsite = "http://www.ahlvin.net";
$themedate = " 5/14/2007 ";
$themeinfo = " Deep Blue II is the three column verison of the theme Deep Blue. ";
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;
define("THEME_DISCLAIMER", "<br /><b>Theme name: Deep Blue II</b> - <i><b>Created</b></i> by <a href='http://www.ahlvin.net'>2Tall</a><br />");
define("IMODE", "dark");
define("BULLET", "burst.gif");
define("STANDARDS_MODE", TRUE);

// [layout]

$layout = "_default";

$HEADER = "
<div style='text-align:center'>
<table style='width:990px' border='0' cellpadding='0' cellspacing='0'>
<tr><td colspan='3'>
{SITELINKS_ALT=no_icons+noclick}
</td>
</tr>
<tr>
	<td colspan='3' class='logo'></td>
</tr>
<tr>
	<td colspan='3' class='logo-bottom'></td>
</tr>
<tr>
  	<td class='menu-fill-left'>
		<table style='width:210px' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='leftmenu'>
  			{SETSTYLE=left}
			{MENU=1}
			</td></tr>
		</table>
	</td>
	<td class='news-fill'>
		<table style='width:570px' border='0' cellpadding='0' cellspacing='0'>
			<tr><td class='news-body'>
			{SETSTYLE=wide} 
";
$FOOTER = "
		</td>
		</tr></table>
		</td>
		<td class='menu-fill-right'>
		<table style='width:210px' border='0' cellpadding='0' cellspacing='0'>
		  	<tr><td class='rightmenu'>
  			{SETSTYLE=left}
			{MENU=2}
			</td></tr>
		</table>
	</td>
      </tr>
	  <tr><td class='menu-fill-left'></td>
	  	<td class='footer'>
		{SITEDISCLAIMER}
		</td>
		<td class='menu-fill-right'></td>
		</tr>
		<tr><td></td></tr>
    </table>
	</div>

";

$CUSTOMHEADER = "
<div style='text-align:center'>
<table style='width:990px' border='0' cellpadding='0' cellspacing='0'>
<tr><td colspan='2'>
{SITELINKS_ALT=no_icons+noclick}
</td>
<tr>
  <tr>
    <td colspan='2' class='logo'></td>
  </tr>
  <tr>
	<td colspan='3' class='logo-bottom-wide'></td>
</tr>
  <tr>
  	<td class='menu-fill-left'>
		<table style='width:210px' border='0' cellpadding='0' cellspacing='0'>
		  	<tr><td class='leftmenu'>
  			{SETSTYLE=left}
			{MENU=1}
			{MENU=2}
			</td></tr>
		</table>
	</td>
	<td class='news-fill'>
		<table style='width:780px' border='0' cellpadding='0' cellspacing='0'>
  		 	<tr><td class='news-body-wide'>
			{SETSTYLE=wide} 
			
";
$CUSTOMFOOTER = "
		</td>
		</tr></table>
		</td>
      </tr>
	  <tr><td class='menu-fill-left'></td>
	  	<td class='footer'>
		{SITEDISCLAIMER}
		</td>
		</tr>
		<tr><td></td></tr>
    </table>
	</div>

";

$CUSTOMPAGES = "forum.php stats.php comment.php forum_viewtopic.php links.php download.php page.php content.php user.php";
	
//  [newsstyle]
$NEWSSTYLE = "
<div class='spacer'>
<table style='width:100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td class='menucaptionleft'></td>
		<td class='menucaption' style='white-space:nowrap'>
		{NEWSTITLE}
		</td>
		<td class='menucaptionright'></td>
	</tr>
</table>
<table style='width:100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td colspan='5' class='menucolor'>
		<small>by
		{NEWSAUTHOR}
		on 
		{NEWSDATE}
		<br /></small><br /> 
		{NEWSBODY}
		{EXTENDED}
		<br /><br /><small>
		{NEWSCOMMENTS}{TRACKBACK}
		</small>
		</td>
	</tr>
</table>
</div>
";


define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", "Read/Post Comment: ");
define("COMMENTOFFSTRING", "Comments are turned off for this item");
define("PRE_EXTENDEDSTRING", "[");
define("EXTENDEDSTRING", "Read the rest ...");
define("POST_EXTENDEDSTRING", "]");
define("TRACKBACKSTRING", "Trackbacks: ");
define("TRACKBACKBEFORESTRING", " | ");

//  [linkstyle]

define(PRELINK, "| ");
define(POSTLINK, "");
define(LINKSTART, "");
define(LINKEND, " | ");
define(LINKDISPLAY, "1");
define(LINKALIGN, "left");

//  [tablestyle]
function tablestyle($caption, $text, $mode){
	global $style;
		if($caption == ""){	
		echo "
<table style='width:570px' cellpadding='0' cellspacing='0' border='0'>
<tr>
	<td class='menucaptionleft'>
	</td>
	<td class='menucaption' style='white-space:nowrap'>
		<img src='".THEME."images/blank.gif' alt='' width='1' height='24' style='display: block;' />
	</td>
	<td class='menucaptionright'>
	</td>
</tr>
</table>
<table style='width:570px' cellpadding='0' cellspacing='0' border='0'>
<tr> 
	<td colspan='5' class='menucolor'>
	$text
	</td>
</tr>
</table>
	  
";

} else {
	if($style == "left"){
		echo "
<table style='width:195px' border='0' cellspacing='0' cellpadding='0'>
	<tr style='width:210px'>
    	<td class='menu-background'>
			<table style='width:195px' cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td class='menucaptionleft' style='white-space:nowrap'>
					</td>
					<td class='menucaption' style='white-space:nowrap'>
						$caption
					</td>
					<td class='menucaptionright' style='white-space:nowrap'>
					</td>
				</tr>
			</table>
			<table style='width:195px' cellspacing='0' cellpadding='0'>
				<tr> 
					<td colspan='5' class='menucolor'>
					$text
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
		
		  
";
} else if($style == "right"){
	echo "
<table style='width:195px' border='0' cellspacing='0' cellpadding='0'>
	<tr style='width:210px'>
    	<td class='menu-background'>
			<table style='width:195px' cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td class='menucaptionleft' style='white-space:nowrap'>
					</td>
					<td class='menucaption' style='white-space:nowrap'>
						$caption
					</td>
					<td class='menucaptionright' style='white-space:nowrap'>
					</td>
				</tr>
			</table>
			<table style='width:195px' cellspacing='0' cellpadding='0'>
				<tr> 
					<td colspan='5' class='menucolor'>
						$text
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
		

";
} else if($style == "wide"){
	echo "
<table style='width:100%' cellspacing='0' cellpadding='0' border='0'>
	<tr> 
		<td class='menucaptionleft' style='white-space:nowrap'>
		</td>
		<td class='menucaption' style='white-space:nowrap'>
			$caption
		</td>
		<td class='menucaptionright' style='white-space:nowrap'>
		</td>
	</tr>
</table>
<table style='width:100%' cellspacing='0' cellpadding='0'>
<tr> 
	<td colspan='5' class='menucolor'>
		$text
	</td>
</tr>
</table>
";
} else {
	echo "
<table style='width:100%' cellspacing='0' cellpadding='0' border='0'>
	<tr> 
		<td class='menucaptionleft' style='white-space:nowrap'>
		</td>
		<td class='menucaption' style='white-space:nowrap'>
			$caption
		</td>
		<td class='menucaptionright' style='white-space:nowrap'>
		</td>
	</tr>
</table>
<table style='width:100%' cellspacing='0' cellpadding='0'>
<tr> 
	<td colspan='5' class='menucolor'>
		$text
	</td>
</tr>
</table>
";
}
}
}

//  [chatboxstyle]
$CHATBOXSTYLE = "
<div class='spacer'>
<div class='chatheader'>
<b>{USERNAME}</b> - {TIMEDATE}<br />
</div>
<div class='chatmessage'>
{MESSAGE}
</div>
</div>";

$POLLSTYLE = "
<b>Poll:</b> {QUESTION}
<br /><br />
{OPTIONS=<div class='alttd8'>OPTION</div>BAR<br /><span class='smalltext'>PERCENTAGE VOTES</span><br />\n}
<br /><div style='text-align:center' class='smalltext'>{AUTHOR}<br />{VOTE_TOTAL} {COMMENTS}
<br />
{OLDPOLLS}
</div>
";

?>