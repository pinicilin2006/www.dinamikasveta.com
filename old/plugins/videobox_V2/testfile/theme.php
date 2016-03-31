
<?php

require_once (THEME . "gc_custom_login.php");
// Protect the file from direct access
if (!defined('e107_INIT'))
{
    exit;
}
// [multilanguage]
@include_once (e_THEME . "Hupsis/languages/" . e_LANGUAGE . ".php");
@include_once (e_THEME . "Hupsis/languages/English.php");
// Set theme info
$themename = "Hupsis";
$themeversion = "1.0";
$themeauthor = "hups";
$themedate = "27/08/07";
$themeinfo = "";
$xhtmlcompliant = true; // If set to TRUE will display an XHTML compliant logo in theme manager
$csscompliant = true; // If set to TRUE will display a CSS compliant logo in theme manager

function theme_head()
{
    return "
  <script type=\"text/javascript\" src=\"".THEME."swfobject.js\"></script>

<script type=\"text/javascript\" src=\"".THEME."js/prototype.js\"></script>
<script type=\"text/javascript\" src=\"".THEME."js/scriptaculous.js?load=effects\"></script>
<script type=\"text/javascript\" src=\"".THEME."js/lightwindow.js\"></script>
<link rel=\"stylesheet\" href=\"".THEME."css/lightwindow.css\" type=\"text/css\" media=\"screen\" />
";
}
// [login box]
$register_sc[] = 'LOGINSC';
$register_sc[] = 'RATENEWS';
//[layout]
$layout = "_default";

// if the following pages then use the header and footer that follow
if(

        eregi(e_PAGE, "forum.php")
    ||eregi(e_PAGE, "forum_viewforum.php")
    ||eregi(e_PAGE, "forum_viewtopic.php")
	||eregi(e_PAGE, "forum_post.php")
	||eregi(e_PAGE, "e107_themes/media/video/gallery.php")
	||eregi(e_PAGE, "e107_themes/media/photogalleryb.php")	
	||eregi(e_PAGE, "e107_themes/media/expose/manager/manager.php")
	
  )
 
{
   $HEADER =" 

<table style='width:100%' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td class='r1c1'><img src='" . THEME .
        "images/blank.gif' width='7' height='148' alt='' class='ffimgfix' /></td>
<td class='r1c2' style='width:100%;white-space:nowrap'>
<td class='r1c3'><img src='" . THEME .
        "images/blank.gif' width='9' height='148' alt='' class='ffimgfix' /></td>
</tr>
</table>
<table style='width:100%' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td class='leftr5'><img src='" . THEME .
        "images/blank.gif' width='7' alt='' class='ffimgfix' />
<td class='r2c1'> 
<table width='396' height='128'>
<tr>
<td><div class='postimage'style='float:left'><img src='" . THEME .
        "icons/postfach.png' width='30' height='30' /></div></td>
  <td><div class='link'> {SITELINKS_ALT=no_icons+noclick}</div></td>
</tr>
</table></td>
<td class='r2c2' style='width:470px;white-space:nowrap'>
<div id='flashcontent1'>
 <object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0' width='470' height='78' id='bannerswf' align='middle'>
	<param name='allowScriptAccess' value='sameDomain' />
	<param name='allowFullScreen' value='false' />
	<param name='movie' value='".THEME."menu1.swf' /><param name='quality' value='high' /><param name='wmode' value='transparent' /><param name='bgcolor' value='#ffffff' />	<embed src='".THEME."menu1.swf' quality='high' wmode='transparent' bgcolor='#ffffff' width='470' height='78' name='bannerswf' align='middle' allowScriptAccess='sameDomain' allowFullScreen='false' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
	</object>

</div>

<script type=\"text/javascript\">
   var so = new SWFObject(\"".THEME."menu1.swf\", \"mymovie\", \"470\", \"78\", \"8\", \"\");
   so.addParam('wmode', 'transparent');
   so.write(\"flashcontent1\");
</script>





</td>  
<td class='r2c3'>
<div id='loginbox'>
{LOGINSC}
</div>
</td>
<td class='rightr5'><img src='" . THEME .
        "images/blank.gif' width='9' alt='' class='ffimgfix' />
</tr>
</table>
<div  align='center'> 
<a class='toggleopacity' href='http://www.gotoandlearn.com/' rel='lightbox|900|650''><img src='" .
        THEME . "nav/spezial/flashtut.png' alt='flash-Tutorial'width='174' height='29' /></a>

 <a class='toggleopacity' href='http://www.hupsis-e107.de/snippet/index.php' rel='lightbox|700|500''><img src='" .
        THEME . "nav/spezial/nextprevphp.png' alt='PHP Snippet' width='174' height='29' /></a>
 <a class='toggleopacity' href=' http://www.hupsis-e107.de/theme/logo/hupsis-banner2.html' rel='lightbox|700|500''><img src='" .
        THEME . "nav/spezial/nextprev1banner.png'alt='Banner' width='174' height='29' /></a>
</div>
<table style='width:100%' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td class='leftr5'><img src='" . THEME .
        "images/blank.gif' width='7' alt='' class='ffimgfix' />
</td>

{SETSTYLE=default}
<td style='width:100%; vertical-align:top;'>
{MENU=2}
";
    $FOOTER = "
{MENU=5}
</td>

<td class='rightr5'><img src='" . THEME .
        "images/blank.gif' width='9' alt='' class='ffimgfix' />
</td>
</tr>
</table>

<div align='center'>{SITEDISCLAIMER}<a href=\"http://e107top.org/\">
<img src=\"http://e107top.org/button.php?u=hups&style=buttons7\" alt=\"e107 toplist\" border=\"0\" />
</a></div>

";
// otherwise, use the following default header and footer
}else{
// Default Header and Footer -----------------------------------------------------------
 $HEADER =" 
<div id='flashcontent'align='center'>
 <object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0' width='1024' height='288' id='bannerswf' align='middle'>
	<param name='allowScriptAccess' value='sameDomain' />
	<param name='allowFullScreen' value='false' />
	<param name='movie' value='".THEME."bannerswf.swf' /><param name='quality' value='high' /><param name='wmode' value='transparent' /><param name='bgcolor' value='transparent' /><embed src='".THEME."bannerswf.swf' quality='high' wmode='transparent' bgcolor='#ffffff' width='1024' height='288' name='bannerswf' align='middle' allowScriptAccess='sameDomain' allowFullScreen='false' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
	</object>

</div>

<script type=\"text/javascript\">
   var so = new SWFObject(\"".THEME."bannerswf.swf\", \"mymovie\", \"1024\", \"288\", \"8\", \"\");
   so.addParam('wmode', 'transparent');
   so.write(\"flashcontent\");
</script>



<div  align='center' class='links'> 
<a class='toggleopacity' href='http://www.gotoandlearn.com/' rel='lightbox|900|650''><img src='" .
        THEME . "nav/spezial/flashtut.png' alt='flash-Tutorial'width='174' height='29' /></a>

 <a class='toggleopacity' href='http://www.hupsis-e107.de/snippet/index.php' rel='lightbox|700|500''><img src='" .
        THEME . "nav/spezial/nextprevphp.png' alt='PHP Snippet' width='174' height='29' /></a>
 <a class='toggleopacity' href=' http://www.hupsis-e107.de/theme/logo/hupsis-banner2.html' rel='lightbox|700|500''><img src='" .
        THEME . "nav/spezial/nextprev1banner.png'alt='Banner' width='174' height='29' /></a>
</div>
<table style='width:100%' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td class='leftr5'><img src='" . THEME .
        "images/blank.gif' width='7' alt='' class='ffimgfix' />
</td>
<td class='r5c2' style='width:15%; vertical-align:top;' class='ffimgfix' />
<div class='search' align='center'> {search}</div>
{SETSTYLE=leftmenu}
{MENU=1}
</td>
{SETSTYLE=default}
<td style='width:100%; vertical-align:top;'>
{MENU=2}
";
    $FOOTER = "
{MENU=5}
</td>
<td style='width:60%; vertical-align:top'>
{MENU=3}
</td>
<td style='width:60%; vertical-align:top'>
{MENU=4}
</td>
<td class='rightr5'><img src='" . THEME .
        "images/blank.gif' width='9' alt='' class='ffimgfix' />
</td>
</tr>
</table>

<div align='center'>{SITEDISCLAIMER}<a href=\"http://e107top.org/\">
<img src=\"http://e107top.org/button.php?u=hups&style=buttons7\" alt=\"e107 toplist\" border=\"0\" />
</a></div>

";

}
//[newsstyle]
$NEWSSTYLE = "
	<div style='cursor:pointer' onclick=\"expandit('exp_news_{NEWSID}')\">
    <table cellpadding='0' cellspacing='0' border='0'>
	    <tr>
	        <td class='mt1'><img src='" . THEME .
    "images/blank.gif' width='25' height='74' alt='' class='ffimgfix' /></td>
			<td class='mtm' style='width:100%;white-space:nowrap'>
			    <div class='titlenews'>{NEWSTITLE}</div>
				</td>
			<td class='mt2'><img src='" . THEME .
    "images/blank.gif' width='27' height='74' alt='' class='ffimgfix' /></td>
	    </tr>
	</table>
	</div>
	<div id='exp_news_{NEWSID}'>
	<table cellpadding='0' cellspacing='0' border='0'>
		<tr>
			<td class='mleft'><img src='" . THEME .
    "images/blank.gif' width='25' alt='' />
			</td>
			<td class='middlemiddle' style='width:100%'>
				{NEWSBODY}
				{EXTENDED}
				<br />
				<div class=' divide_news ' style='width:100%;white-space:nowrap'>
					<img src='" . THEME . "images/blank.gif' width='10' height='12' alt='' />
				</div>
				<div class='newscomments' style='text-align:center'>
					<span style='white-space:nowrap'>Posted by {NEWSAUTHOR} on </span>
					<span style='white-space:nowrap'>{NEWSDATE}</span>&nbsp;&nbsp;<img src='" .
    e_IMAGE . "admin_images/userclass_16.png' alt='' style='vertical-align: right;'/>{ADMINOPTIONS}{RATENEWS}
					<span style='white-space:nowrap'> | {NEWSCOMMENTS}</span>
				</div>
			</td>
			<td class='mright'><img src='" . THEME .
    "images/blank.gif' width='27' alt='' />
			</td>
		</tr>
	</table>
	</div>
	<table style='width:100%' cellspacing='0' cellpadding='0' align='center'>
		<tr>
			<td class='md1'><img src='" . THEME .
    "images/blank.gif' width='26' height='45' alt='' class='ffimgfix' /></td>
			<td class='mdbg' style='width:100%'>
			<td class='md2'><img src='" . THEME .
    "images/blank.gif' width='27' height='45' alt='' class='ffimgfix' /></td>
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
define(PRELINK, "<font color='#FFFFFF'>&raquo; ");
define(POSTLINK, "</div>");
define(LINKSTART, "");
//define(LINKEND, "<br /><img style='margin-top: 2px; margin-bottom: 2px;' width='190' height='1' src='".THEME."images/hr.png'><br />");
define(LINKEND, "<font color='#FFFFFF'>&raquo; ");
define(LINKALIGN, "center");
//[menustyle]
function tablestyle($caption, $text)
{
    global $expand_menu_counter;
    $expand_menu_counter += 1;
    $expand_autohide_list = array("Select Theme");
    if (in_array($caption, $expand_autohide_list))
    {
        $expand_autohide = "display:none";
    }
    else
    {
        unset($expand_autohide);
    }
    echo "
	<div style='cursor:pointer' onclick=\"expandit('exp_menu_$expand_menu_counter')\">	
	<table cellpadding='0' cellspacing='0'>
	    <tr>
	        <td class='mt1'><img src='" . THEME .
        "images/blank.gif' width='25' height='74' alt='' class='ffimgfix' /></td>
			<td class='mtm' style='width:100%;white-space:nowrap'>
 <div class='titlemenu'> " . $caption . " </div>
 </td>
			<td class='mt2'><img src='" . THEME .
        "images/blank.gif' width='27' height='74' alt='' class='ffimgfix' /></td>
	    </tr>
	</table>
	</div>
	<div id='exp_menu_$expand_menu_counter' style='$expand_autohide'>
	<table cellpadding='0' cellspacing='0'>
		<tr>
			<td class='mleft'><img src='" . THEME .
        "images/blank.gif' width='25' alt='' />
			</td>
			<td class='middlemiddle' style='width:100%'>" . $text . "</td>
			<td class='mright'><img src='" . THEME .
        "images/blank.gif' width='27' alt='' />
			</td>
		</tr>
	</table>
	</div>
	<table style='width:100%' cellspacing='0' cellpadding='0' align='center'>
		<tr>
			<td class='md1'><img src='" . THEME .
        "images/blank.gif' width='26' height='45' alt='' class='ffimgfix' /></td>
			<td class='mdbg' style='width:100%'>
			<div style='width: 100%; text-align: center;'>
            <img style='margin-top: auto; margin-bottom: auto; margin-left: auto; margin-right: auto;' src='" .
        THEME . "images/blank.gif' width='140' height='0' class='ffimgfix' />
            </div>
			<td class='md2'><img src='" . THEME .
        "images/blank.gif' width='27' height='45' alt='' class='ffimgfix' /></td>
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
<div class='spacerx'>
<div class='forumheader3a' align='center'>
  <div align='center'class='chatboxtxt'>
   <table >
     <tr>
       <td><img align='center' src='".THEME."images/bullet2.gif' alt='bullet' /></td>
       <td class='forumheader3b'>{USERNAME}</td>
     </tr>
   </table>
   <span class='smalltext'>{TIMEDATE}</span><br />
    &nbsp;{MESSAGE}&nbsp;<br/><br/>
  </div>
</div>
</div>";
 
?>
