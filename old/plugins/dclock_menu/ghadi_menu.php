<?php
/* Author: Prateek Shukla 'Hunt'
Title: Analog Clock for Gamers
Author Site: http://www.javachip.org */

$title = "Clock";
$text = " <object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,65,0' width='130' height='130' id='analogclock' align='middle'>
<param name='allowScriptAccess' value='sameDomain' />
<param name='movie' value='http://www.javachip.org/silent/e107_plugins/dclock_menu/analogclock.swf' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' /><embed src='http://www.javachip.org/silent/e107_plugins/dclock_menu/analogclock.swf' quality='high' bgcolor='#ffffff' width='130' height='130' name='analogclock' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
</object>";

$ns -> tablerender($title, $text);


?>



