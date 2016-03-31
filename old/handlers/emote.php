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
|     $Source: /cvsroot/e107/e107_0.7/e107_handlers/emote.php,v $
|     $Revision: 1.16 $
|     $Date: 2006/12/19 20:25:23 $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

function r_emote()
{
	global $sysprefs, $pref, $tp;

	if (!is_object($tp->e_emote))
	{
		require_once(e_HANDLER.'emote_filter.php');
		$tp->e_emote = new e_emoteFilter;
	}
	
	foreach($tp->e_emote->emotes as $key => $value)
	{
		$key = str_replace("!", "_", $key);
		$key = preg_replace("#_(\w{3})$#", ".\\1", $key);
		$key = e_IMAGE."emotes/" . $pref['emotepack'] . "/" .$key;

		$value2 = substr($value, 0, strpos($value, " "));
		$value = ($value2 ? $value2 : $value);
		$value = ($value == '&|') ? ':((' : $value;
		$str .= "\n<a href=\"javascript:addtext('$value',true)\"><img src='$key' style='border:0; padding-top:2px;' alt='' /></a> ";
	}

	return "<div class='spacer'>".$str."</div>";
}

?>