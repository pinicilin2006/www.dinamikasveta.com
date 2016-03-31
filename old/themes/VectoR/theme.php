<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_themes/crahan/theme.php,v $
|     $Revision: 1.10 $
|     $Date: 2005/12/14 19:28:52 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [multilanguage]
@include_once(e_THEME."VectoR/languages/".e_LANGUAGE.".php");
@include_once(e_THEME."VectoR/languages/English.php");

// [theme]
$themename = "VectoR";
$themeversion = "1.0";
$themeauthor = "Samir Kahvedzic [AkIrA]";
$themeemail = "akira_tim@hotmail.com";
$themewebsite = "http://www.akira.knows.it";
$themedate = "26/06/2006";
$themeinfo = "More info, help and support on my site www.akira.knows.it.";
define("STANDARDS_MODE", TRUE);
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;
define("IMODE", "lite");
define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");



// [layout]

$layout = "_default";

$HEADER = "
<div id='wrapper'>
<div id='topleft'>
<div id='topright'>
</div>
</div>
<div id='headb'>
<div id='head'>
<div id='nav'>
<div id='logo'>
</div>
{SITELINKS}
</div>
</div>
</div>
<div id='content'>
<div id='left'>
{MENU=1}
</div>
<div class='news'>
";

$NEWSSTYLE = "
    
	<div class='title'>{NEWSTITLE}</div>
	<div class='date'>{NEWSDATE}</div>
     
	 <div class='story'>
	 <br />
    {NEWSBODY}
    {EXTENDED}
	</div>
    
	<div class='postby'>
      {EMAILICON}
      {PRINTICON}
      {ADMINOPTIONS}
      <br />
      Posted by 
      {NEWSAUTHOR}
      &nbsp;::&nbsp;
      {NEWSCOMMENTS}
	  </div>
	  
	  ";

$FOOTER = "
</div>
<div id='right'>
{MENU=2}
</div>
<div class='clear'>
</div>
<div id='footer'> 
{SITEDISCLAIMER}
</div>
</div>
<div id='footerc'>
<div id='footerl'>
<div id='footerr'>
</div>
</div>
</div>
</div>
 ";

define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", LAN_THEME_3);
define("COMMENTOFFSTRING", LAN_THEME_2);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " :: ");


// [linkstyle]

define(PRELINK, "<ul>");
define(POSTLINK, "</ul>");
define(LINKSTART, "<li>");
define(LINKEND, "</li>");
define(LINKDISPLAY, 1);			// 1 - along top, 2 - in left or right column
define(LINKALIGN, "center");


//	[tablestyle]

function tablestyle($caption, $text){
	global $style;
	if($style == "leftmenu"){
		if($caption != ""){
			echo "<h3>".$caption."</h3>";
			if($text != ""){
				echo "<div class='menuleft'>".$text."</div><br />";
			}
		}else{
			echo $text."<br />";
		}
	}else if($style == "rightmenu"){
		if($caption != ""){
			echo "<h3>".$caption."</h3>".$text;
		}else{
			echo "<div id='menuright'>".$text."</div>";
		}
	}else if($style == "default"){
		if($caption != ""){
			echo "<h3>".$caption."</h3>".$text."<br />";
		}else{
			echo $text."<br />";
		}
	}else if($style == "message"){
		if($caption = ""){
			echo $text;
		}
	}else{
		if($caption != ""){
			echo "<h3>".$caption."</h3>".$text."<br />";
		}else{
			echo $text."<br />";
		}
	}
}

// [commentstyle]

$COMMENTSTYLE = "{USERNAME} @ <span class='smalltext'>{TIMEDATE}</span><br />
{AVATAR}<span class='smalltext'>{REPLY}</span><br />
{COMMENT}
<div style='text-align: right;' class='smallext'>{IPADDRESS}</div>"; 

// [chatboxstyle]


$CHATBOXSTYLE = "
<div class='spacer'>
<div class='indentchat'>
<img src='".THEME."images/bulletc.gif' />
<b>{USERNAME}</b><div style='text-align:left; padding:0px;'><span class='small' >{TIMEDATE}</span></div>
<span class='smalltext'><br />{MESSAGE}
</span><br><br />
</div>
</div>";

?>
