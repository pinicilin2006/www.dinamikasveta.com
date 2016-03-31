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
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/comment_menu/comment_menu_shortcodes.php,v $
|     $Revision: 1.2 $
|     $Date: 2007/02/08 22:35:09 $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }
global $tp;
$comment_menu_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);

/*
SC_BEGIN CM_ICON
return (defined("BULLET") ? "<img src='".THEME_ABS."images/".BULLET."' alt='' style='border:0; vertical-align: middle;' />" : "<img src='".THEME_ABS."images/bullet2.gif' alt='bullet' style='border:0; vertical-align: middle;' />");
SC_END

SC_BEGIN CM_DATESTAMP
global $row;
$gen = new convert;
return $gen->convert_date($row['comment_datestamp'], "short");
SC_END

SC_BEGIN CM_HEADING
global $row;
return $row['comment_title'];
SC_END

SC_BEGIN CM_URL_PRE
global $row;
return ($row['comment_url'] ? "<a href='".$row['comment_url']."'>" : "");
SC_END

SC_BEGIN CM_URL_POST
global $row;
return ($row['comment_url'] ? "</a>" : "");
SC_END

SC_BEGIN CM_TYPE
global $row;
return $row['comment_type'];
SC_END

SC_BEGIN CM_AUTHOR
global $row;
return $row['comment_author'];
SC_END

SC_BEGIN CM_COMMENT
global $row, $menu_pref, $pref, $tp;
$COMMENT = '';
if($menu_pref['comment_characters']>0)
{
  $COMMENT = strip_tags($tp->toHTML($row['comment_comment'], TRUE, "emotes_off, no_make_clickable", "", $pref['menu_wordwrap']));
  if (strlen($COMMENT) > $menu_pref['comment_characters'])
  {
	$COMMENT = $tp->text_truncate($COMMENT, $menu_pref['comment_characters'],'').($row['comment_url'] ? " <a href='".$row['comment_url']."'>" : "").$menu_pref['comment_postfix'].($row['comment_url'] ? "</a>" : "");
  }
}
return $COMMENT;
SC_END

*/
?>