<?php
/*
+---------------------------------------------------------------+
|	e107 website system
|
|	©Steve Dunstan 2001-2005
|	http://e107.org
|	jalist@e107.org
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
|
|   $Revision: 1.21 $
|   $Date: 2006/01/08 02:30:59 $
|   $Author: from the qnome original $
+---------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [multilanguage]

@include_once(e_THEME."lazydays/languages/".e_LANGUAGE.".php");
@include_once(e_THEME."lazydays/languages/English.php");

// [theme]
$themename = "lazydays";
$themeversion = "1.0";
$themeauthor = "eelay";
$themeemail = "eelay@e107norway.org";
$themewebsite = "http://e107norway.org";
$themedate = "18/01/2007";
$themeinfo = "This is a  <a href='http://fullahead.org'>FullaHead</a> design, that is ported to e107 by <a href='http://e107norway.org'>eelay</a><br /> Ps. Almost css compliant. It uses a litte javascript sniplet so it will work in (stinkin)IE. If you want i compliant, take out the javascript. This vil ruin the theme in IE.";
define("STANDARDS_MODE", TRUE);	 // for stupid IE
$xhtmlcompliant = TRUE;	 // Hopefully it still is!
$csscompliant = FALSE;	 // Ditto
define("IMODE", "lite");	//use the default 'lite' image set
define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");	 
define("USER_WIDTH","width:97%");	 //make the forums 100% of the space available or any width you define

if(!defined("e_THEME")){ exit; }
$page=substr(strrchr($_SERVER['PHP_SELF'], "/"), 1);
define("e_PAGE", $page);

// [layout]

$layout = "_default";

$HEADER = "
<!-- CONTENT: Holds all site content except for the footer.  This is what causes the footer to stick to the bottom -->
<div id='content'>

	<!-- HEADER: Holds title, subtitle and header images -->
	<div id='header'>

		<div id='title'>
			<h1>{SITENAME}</h1>
			<h2>{SITETAG}</h2>
		</div>

		<img src='".THEME."images/balloons.gif' alt='balloons' class='balloons' />
		<img src='".THEME."images/header_left.jpg' alt='left slice' class='left' />
		<img src='".THEME."images/header_right.jpg' alt='right slice' class='right' />

	</div>

	<!-- MAIN MENU: Top horizontal menu of the site.  Use class='here' to turn the current page tab on -->
	<div id='mainMenu'>
		{SITELINKS}
	</div>

	<!-- PAGE CONTENT BEGINS: This is where you would define the columns (number, width and alignment) -->
	<div id='page'>


		<!-- 25 percent width column, aligned to the left -->
		<div class='width25 floatLeft leftColumn'>
			{SETSTYLE=top_left_menu}
			{MENU=1}
			{SETSTYLE=bottom_left_menu}
			{MENU=2}
		</div>
			{SETSTYLE=default}
		<!-- 75 percent width column, aligned to the right -->
		<div class='width75 floatRight'>
";

$FOOTER = "
		</div>
	</div>
</div>
<div id='footer'>

	<div id='width'>
		<span class='floatLeft'>
			{SITEDISCLAIMER}
			</span>
		<span class='floatRight'>
			
		</span>
	</div>
</div>
";

$CUSTOMHEADER = "
<!-- CONTENT: Holds all site content except for the footer.  This is what causes the footer to stick to the bottom -->
<div id='content'>

	<!-- HEADER: Holds title, subtitle and header images -->
	<div id='header'>

		<div id='title'>
			<h1>{SITENAME}</h1>
			<h2>{SITETAG}</h2>
		</div>

		<img src='".THEME."images/balloons.gif' alt='balloons' class='balloons' />
		<img src='".THEME."images/header_left.jpg' alt='left slice' class='left' />
		<img src='".THEME."images/header_right.jpg' alt='right slice' class='right' />

	</div>

	<!-- MAIN MENU: Top horizontal menu of the site.  Use class='here' to turn the current page tab on -->
	<div id='mainMenu'>
		{SITELINKS}
	</div>

	<!-- PAGE CONTENT BEGINS: This is where you would define the columns (number, width and alignment) -->
	<div id='page'>

		<!-- 75 percent width column, aligned to the right -->
		<div class='width100'>
";


$CUSTOMFOOTER = "
		</div>
	</div>
</div>
<div id='footer'>

	<div id='width'>
		<span class='floatLeft'>
			{SITEDISCLAIMER}
			</span>
		<span class='floatRight'>
			
		</span>
	</div>
</div>
";

$CUSTOMPAGES = "forum.php forum_post.php forum_viewforum.php forum_viewtopic.php links.php stats.php";

$NEWSSTYLE = "
<!-- Gives the gradient block -->
<div class='gradient'>
	<h1>{NEWSTITLE}</h1>
	<h2><small>".LAN_THEME_6." {NEWSDATE} | ".LAN_THEME_7." {NEWSAUTHOR}</small></h2>
	<p>
		{NEWSBODY}
		{EXTENDED}
	</p>
	<div style='text-align:right' class='smalltext'>
			{NEWSCOMMENTS}{TRACKBACK} {EMAILICON}{PDFICON}{ADMINOPTIONS}
	</div>
</div>
<br />
";

define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", LAN_THEME_3);
define("COMMENTOFFSTRING", LAN_THEME_2);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " | ");


// [linkstyle]

define('PRELINK', "<ul class='floatRight'>");
define('POSTLINK', "</ul>");
define('LINKSTART', "<li>");
define('LINKEND', "</li>");
define('LINKSTART_HILITE', "<li class='here'>");
define('LINKDISPLAY', 1);
define('LINKALIGN', "");
define('LINKCLASS', "");
define('LINKCLASS_HILITE', "");

//	[tablestyle]

function tablestyle($caption, $text, $mode){
	global $style;
if ($style == 'top_left_menu') 
	{
		echo "
	<h1>$caption</h1><div class='sideMenu'><div class='here'>$text</div></div>\n
	<br />";
}
else if ($style == 'bottom_left_menu') 
{
	echo "
	<h1>$caption</h1><div class='sideMenu'>$text</div>\n
	<br />";
} else {
	echo "
	<div class='gradient'>\n
	<h1>$caption</h1><div>$text</div>\n
	</div><br />";
}
}
$COMMENTSTYLE = "
<table style='width: 450px;'>
<tr>
<td style='width: 30%; vertical-align: top;'><span class='mediumtext'>{USERNAME}</span><br /><span class='smalltext'>{TIMEDATE}</span><br />{AVATAR}{REPLY}</td>
<td style='width: 70%; vertical-align: top;'><span class='mediumtext'>{COMMENT} {COMMENTEDIT}</span></td>
</tr>
</table>";


$CHATBOXSTYLE = "
<b>{USERNAME}</b>
<div class='smalltext'>
{MESSAGE}
</div>
<br />";

?>
