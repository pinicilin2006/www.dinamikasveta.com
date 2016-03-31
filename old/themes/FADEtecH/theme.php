<?php

// Set theme info
$themename = "FADEtecH";
$themeversion = "1.0";
$themeauthor = "Infade";
$themedate = "Oct 2006";
$themeinfo = "FADEtecH blueish public theme";
$xhtmlcompliant = TRUE;	// If set to TRUE will display an XHTML compliant logo in theme manager
$csscompliant = TRUE;	// If set to TRUE will display a CSS compliant logo in theme manager

require_once(THEME."comment_template.php");

//[layout]
$layout = "_default";


$HEADER = "

<table style='width:100%' cellspacing='0' cellpadding='0' >
<tr>
<td class='THtop1'><img src='".THEME."images/blank.gif' width='384' height='93' alt='' class='ffimgfix' /></td>
<td class='THtop2' style='width:100%;white-space:nowrap'>
<td class='THtop3'><img src='".THEME."images/blank.gif' width='407' height='93' alt='' class='ffimgfix' /></td>
</tr>
</table>

<table style='width:100%' cellspacing='0' cellpadding='0' >
<tr>
<td class='THlinks1'><img src='".THEME."images/blank.gif' width='15' height='24' alt='' class='ffimgfix' /></td>
<td class='THlinks2' style='width:100%;white-space:nowrap'>
{SITELINKS=flat}
<td class='THlinks3'><img src='".THEME."images/blank.gif' width='14' height='24' alt='' class='ffimgfix' /></td>
<td class='THsearch' style='width:100%;white-space:nowrap'>
{SEARCH}
<td class='THlinks5'><img src='".THEME."images/blank.gif' width='15' height='24' alt='' class='ffimgfix' /></td>
</tr>
</table>

<table style='width:100%' cellspacing='0' cellpadding='0' >
<tr>
<td class='THlogin1'><img src='".THEME."images/blank.gif' width='15' height='31' alt='' class='ffimgfix' /></td>
<td class='THlogin2' style='width:100%;white-space:wrap'>
{CUSTOM=login}
<td class='THlogin3'><img src='".THEME."images/blank.gif' width='15' height='31' alt='' class='ffimgfix' /></td>
</tr>
</table>

<table style='width:100%' cellspacing='0' cellpadding='0' >
<tr>
<td class='clockleft'><img src='".THEME."images/blank.gif' width='15' height='18' alt='' class='ffimgfix' /></td>
<td class='clockm' style='width:100%;white-space:nowrap'>
{CUSTOM=clock}
<td class='clockright'><img src='".THEME."images/blank.gif' width='30' height='18' alt='' class='ffimgfix' /></td>
</tr>
</table>

<table style='width:100%' cellspacing='0' cellpadding='0'  bgcolor='#F8F8F8'>
<tr>
<td class='leftr5'><img src='".THEME."images/blank.gif' width='15' alt='' class='ffimgfix' />
</td>
<td class='r4c2' style='width:0%; vertical-align:top;' class='ffimgfix' />
</td>
{SETSTYLE=default}
<td style='width:100%; vertical-align:top;'>
{MENU=2}
";

$FOOTER = "
{MENU=3}
</td>
<td class='right_menu'>
{MENU=4}
</td>
<td class='rightr5'><img src='".THEME."images/blank.gif' width='15' alt='' class='ffimgfix' />
</td>
</tr>
</table>

<table style='width:100%' cellspacing='0' cellpadding='0' >
<tr>
<td class='spacer1'><img src='".THEME."images/blank.gif' width='265' height='32' alt='' class='ffimgfix' /></td>
<td class='spacer2' style='width:100%;white-space:nowrap'>
<td class='spacer3'><img src='".THEME."images/blank.gif' width='38' height='32' alt='' class='ffimgfix' /></td>
</tr>
</table>

<table style='width:100%' cellspacing='0' cellpadding='0' >
<tr>
<td class='THfooter1'><img src='".THEME."images/blank.gif' width='265' height='112' alt='' class='ffimgfix' /></td>
<td class='THfooter2' style='width:100%;white-space:wrap'>
{SITEDISCLAIMER}
<td class='THfooter3'><img src='".THEME."images/blank.gif' width='38' height='112' alt='' class='ffimgfix' /></td>
</tr>
</table>
";


//[newsstyle]

$NEWSSTYLE = "

    <table cellpadding='0' cellspacing='0' border='0'>
	    <tr>
	        <td class='mt12'><img src='".THEME."images/blank.gif' width='33' height='30' alt='' class='ffimgfix' /></td>
			<td class='mtm2' style='width:100%;white-space:nowrap'>
			    {NEWSTITLE}
				</td>
			<td class='mt22'><img src='".THEME."images/blank.gif' width='11' height='30' alt='' class='ffimgfix' /></td>
	    </tr>
	</table>
	</div>

	<div id='exp_news_{NEWSID}'>
	<table cellpadding='0' cellspacing='0' border='0'>
		<tr>
			<td class='mleft2'><img src='".THEME."images/blank.gif' width='11' alt='' />
			</td>
			<td class='middlemiddle2' style='width:100%'>
				{NEWSBODY}
				{EXTENDED}
				<div class='divide_news' style='width:100%;white-space:nowrap'>
					<img src='".THEME."images/blank.gif' width='10' height='12' alt='' />
				</div>
				<div class='newscomments' style='text-align:left'>
					<span style='white-space:nowrap'>Posted by {NEWSAUTHOR} on </span>
					<span style='white-space:nowrap'>{NEWSDATE}</span>&nbsp;&nbsp;<img src='".e_IMAGE."admin_images/userclass_16.png' alt='' style='vertical-align: right;'/>
					<span style='white-space:nowrap'> | {NEWSCOMMENTS}</span>
				</div>
			</td>
			<td class='mright2'><img src='".THEME."images/blank.gif' width='11' alt='' />
			</td>
		</tr>
	</table>
	</div>
	
	<table style='width:100%' cellspacing='0' cellpadding='0' >
		<tr>
			<td class='md12'><img src='".THEME."images/blank.gif' width='11' height='38' alt='' class='ffimgfix' /></td>
			<td class='mdbg2' style='width:100%'>
			<td class='md22'><img src='".THEME."images/blank.gif' width='11' height='38' alt='' class='ffimgfix' /></td>
		</tr>
	</table>
";


//[newsbits]

define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", "Add/Read Comments: ");
define("COMMENTOFFSTRING", "Comments are Off");
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", "Read the rest ...");
define("POST_EXTENDEDSTRING", " ]<br />");
define("ICONMAIL", "iconmail.png");
define("ICONPRINT", "iconprint.png");


//[mainlinkstyle]

define(PRELINK, "<font color='#0000FF'>&raquo; ");
define(POSTLINK, "</div>");
define(LINKSTART, "");
//define(LINKEND, "<br /><img style='margin-top: 2px; margin-bottom: 2px;' width='190' height='1' src='".THEME."images/hr.png'><br />");
define(LINKEND, "<font color='#0000FF'>&raquo; ");
define(LINKALIGN, "center");


//[menustyle]

function tablestyle($caption, $text)
{
  global $expand_menu_counter;
  $expand_menu_counter += 1;

  $expand_autohide_list = array("w000t");
  if (in_array($caption, $expand_autohide_list)) { $expand_autohide = "display:none"; } else { unset($expand_autohide); }

  echo "	
	<table style='width:100%' cellpadding='0' cellspacing='0'>
	    <tr>
	        <td class='mt1'><img src='".THEME."images/blank.gif' width='37' height='51' alt='' class='ffimgfix' /></td>
			<td class='mtm' style='width:100%;white-space:nowrap'>".$caption."</td>
			<td class='mt2'><img src='".THEME."images/blank.gif' width='21' height='51' alt='' class='ffimgfix' /></td>
	    </tr>
	</table>
	</div>
	
	<div id='exp_menu_$expand_menu_counter' style='$expand_autohide'>
	<table cellpadding='0' cellspacing='0'>
		<tr>
			<td class='mleft'><img src='".THEME."images/blank.gif' width='8' alt='' />
			</td>
			<td class='middlemiddle' style='width:100%'>".$text."</td>
			<td class='mright'><img src='".THEME."images/blank.gif' width='8' alt='' />
			</td>
		</tr>
	</table>
	</div>

	<table style='width:100%' cellspacing='0' cellpadding='0' >
		<tr>
			<td class='md1'><img src='".THEME."images/blank.gif' width='37' height='43' alt='' class='ffimgfix' /></td>
			<td class='mdbg' style='width:100%'>
			<div style='width: 100%; text-align: center;'>
            <img style='margin-top: auto; margin-bottom: auto; margin-left: auto; margin-right: auto;' src='".THEME."images/blank.gif' width='155' height='0' class='ffimgfix' />
            </div>
			<td class='md2'><img src='".THEME."images/blank.gif' width='21' height='43' alt='' class='ffimgfix' /></td>
		</tr>
	</table>
	";
}


//[pollstyle]

$POLLSTYLE = <<< EOF
<b> {QUESTION} </b>
<br /><br />
{OPTIONS=<span class='alttd'>OPTION</span><br />BAR<br /><span class='smalltext'>PERCENTAGE VOTES</span><br /><br />\n}
<div style='text-align:center' class='smalltext'>{VOTE_TOTAL} {COMMENTS}
<br />
</div>
EOF;


//	[chatboxstyle]

$CHATBOXSTYLE = "
<div class='spacer'>
<div class='forumheader3'>
<img src='".THEME."images/bullet2.gif' alt='bullet' />
<b>{USERNAME}</b><br />
<span class='smalltext'>{TIMEDATE}</span><br />
{MESSAGE}
</div>
</div>";


?>
