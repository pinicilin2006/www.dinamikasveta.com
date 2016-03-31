<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 Website System
|
|     Jariel06 2007
|     http://e107.org
|     jasalomon@estudiantes.uci.cu
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

if (file_exists(e_PLUGIN."sclock_menu/languages/".e_LANGUAGE.".php"))
{
	include_once(e_PLUGIN."sclock_menu/languages/".e_LANGUAGE.".php");
}
else
{
	include_once(e_PLUGIN."sclock_menu/languages/English.php");
}

$text = "<div style='text-align:center; margin-top:-5px'>
			<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,65,0' width='150' height='150' id='clock2001' align='middle'>
			<param name='allowScriptAccess' value='sameDomain' />
			<param name='movie' value='".e_PLUGIN."sclock_menu/clock.swf' />
			<param name='quality' value='high' />
			<param name='bgcolor' value='#ffffff' />
			<embed src='".e_PLUGIN."sclock_menu/clock.swf' quality='high' bgcolor='#ffffff' width='150' height='150' name='clock2001' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />	
			</object>
		</div>";

$ns -> tablerender(SCLOCK_LAN_1, $text);

?>



