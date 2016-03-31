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
|     $Source: /cvsroot/e107/e107_0.7/e107_files/shortcode/batch/bbcode_shortcodes.php,v $
|     $Revision: 1.11 $
|     $Date: 2007/02/11 10:40:16 $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

include_once(e_HANDLER.'shortcode_handler.php');
include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_ren_help.php");
global $register_bb;
$bbcode_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);

/*
SC_BEGIN BB

global $pref, $eplug_bb, $bbcode_func, $bbcode_help, $bbcode_filedir, $bbcode_imagedir, $bbcode_helpactive, $bbcode_helptag, $register_bb;

if(e_WYSIWYG){ return; }

$bbcode_func = ($bbcode_func) ? $bbcode_func : "addtext";
$bbcode_help  = ($bbcode_help) ? $bbcode_help : "help";
$bbcode_tag  = ($bbcode_helptag != 'helpb') ? ",'$bbcode_helptag'" : "";

$rand = rand(1000,9999);
$imagedir_display = str_replace("../","",$bbcode_imagedir);

if($parm == "emotes" && $pref['comments_emoticons'] && $pref['smiley_activate'] && !e_WYSIWYG)
{
	$bbcode['emotes'] = array("expandit","emoticon_selector_".$rand, LANHELP_44, "emotes.png", "Emoticon_Select", "emoticon_selector_".$rand);
}

// Format: $bbcode['UNIQUE_NAME'] = array(ONCLICK_FUNC, ONCLICK_VAR, HELPTEXT, ICON, INCLUDE_FUNC, INCLUDE_FUNCTION_VAR);

$bbcode['newpage'] = array($bbcode_func,"[newpage]", LANHELP_34, "newpage.png");
$bbcode['link'] = array($bbcode_func,"[link=".LANHELP_35."][/link]", LANHELP_23,"link.png");
$bbcode['b'] = array($bbcode_func,"[b][/b]", LANHELP_24,"bold.png");
$bbcode['i'] = array($bbcode_func,"[i][/i]", LANHELP_25,"italic.png");
$bbcode['u'] = array($bbcode_func,"[u][/u]", LANHELP_26,"underline.png");
$bbcode['center'] = array($bbcode_func,"[center][/center]", LANHELP_28,"center.png");
$bbcode['left'] = array($bbcode_func,"[left][/left]", LANHELP_29,"left.png");
$bbcode['right'] = array($bbcode_func,"[right][/right]", LANHELP_30,"right.png");
$bbcode['bq'] = array($bbcode_func,"[blockquote][/blockquote]", LANHELP_31,"blockquote.png");
$bbcode['code'] = array($bbcode_func,"[code][/code]", LANHELP_32,"code.png");
$bbcode['list'] = array($bbcode_func,"[list][/list]", LANHELP_36,"list.png");
$bbcode['img'] = array($bbcode_func,"[img][/img]", LANHELP_27,"image.png");
$bbcode['flash'] = array($bbcode_func,"[flash=width,height][/flash]", LANHELP_47,"flash.png");

$bbcode['fontsize'] = array("expandit","size_selector_".$rand, LANHELP_22,"fontsize.png","Size_Select",'size_selector_'.$rand);
$bbcode['fontcol'] = array("expandit","col_selector_".$rand, LANHELP_21,"fontcol.png","Color_Select",'col_selector_'.$rand);
$bbcode['preimage'] = array("expandit","preimage_selector_".$rand, LANHELP_45.$imagedir_display,"preimage.png","PreImage_Select","preimage_selector_".$rand);
$bbcode['prefile'] = array("expandit","prefile_selector_".$rand, LANHELP_39,"prefile.png","PreFile_Select",'prefile_selector_'.$rand);

if(!isset($iconpath[$parm]))
{
	$iconpath[$parm] =  (file_exists(THEME."bbcode/bold.png") ? THEME."bbcode/" : e_IMAGE."generic/bbcode/");
    $iconpath[$parm] .= $bbcode[$parm][3];
}


foreach($register_bb as $key=>$val) // allow themes to plug in to it.
{
	if($val[0]=="")
	{
    	$val[0] = $bbcode_func;
	}
	$bbcode[$key] = $val;
	$iconpath[$key] = $val[3];
}


foreach($eplug_bb as $key=>$val)  // allow plugins to plug into it.
{
	extract($val);
   //	echo "$onclick $onclick_var $helptext $icon <br />";
    $bbcode[$name] = array($onclick,$onclick_var,$helptext,$icon,$function,$function_var);
	$iconpath[$name] = $icon;
}


$_onclick_func = ($bbcode[$parm][0]) ? $bbcode[$parm][0] : $bbcode_func;
$_onclick_var = $bbcode[$parm][1];
$_helptxt = $bbcode[$parm][2];
$_function = $bbcode[$parm][4];
$_function_var = $bbcode[$parm][5];


if($bbcode[$parm])  // default - insert text.
{
	$text = "\n<img class='bbcode bbcode_buttons' style='cursor:pointer' src='".$iconpath[$parm]."' alt='' title='".$_helptxt."' onclick=\"{$_onclick_func}('".$_onclick_var."')\" ".($bbcode_helpactive ? "onmouseout=\"{$bbcode_help}(''{$bbcode_tag})\" onmouseover=\"{$bbcode_help}('".$_helptxt."'{$bbcode_tag})\"" : "" )." />\n";
}

if($_function)
{

	$text .= ($bbcode_helpactive && $_helptxt && !$iconpath[$parm]) ? "<span onmouseout=\"{$bbcode_help}(''{$bbcode_tag})\" onmouseover=\"{$bbcode_help}('".$_helptxt."'{$bbcode_tag})\" >" : "";
	$text .= $_function($_function_var);
	$text .= ($bbcode_helpactive && $_helptxt && !$iconpath[$parm]) ? "</span>" : "";
}

return $text;




SC_END




SC_BEGIN BB_HELP
	if(e_WYSIWYG){	return;	}
	global $bbcode_helpactive,$bbcode_helptag;
	$bbcode_helptag = ($parm) ? $parm : "helpb";
	$bbcode_helpactive = TRUE;
	return "<input id='{$bbcode_helptag}' class='helpbox' type='text' name='{$bbcode_helptag}' size='100'  />\n";
SC_END



SC_BEGIN BB_PREIMAGEDIR
	if(e_WYSIWYG){	return;	}
	global $bbcode_imagedir;
	$bbcode_imagedir = $parm;
	return;
SC_END


*/
?>