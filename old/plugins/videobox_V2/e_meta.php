<?php

/*
+ ----------------------------------------------------------------------------------------------------+
|        e107 website system 
|        Plugin Meta File :  e107_plugins/videobox_V2/e_meta.php
|        Email: 
|        $Revision  1.0b$
|        $Date      28.5.2007$
|        $Author    Hups$
|        Support Sites : http://www.gw-world.de$
+----------------------------------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')){ exit; }
$lb_path = e_PLUGIN.'videobox_V2/';
echo '<script type="text/javascript" src="'.$lb_path.'src/js/adapter/shadowbox-prototype.js"></script>
<script type="text/javascript" src="'.$lb_path.'src/js/lib/yui-utilities.js"></script>

<script type="text/javascript" src="'.$lb_path.'src/js/adapter/shadowbox-yui.js"></script>
<script type="text/javascript" src="'.$lb_path.'src/js/shadowbox.js"></script>

<link rel="stylesheet" type="text/css" href="'.$lb_path.'src/css/shadowbox.css">




<script type="text/javascript">

window.onload = Shadowbox.init;

</script>
<script type="text/javascript">

YAHOO.util.Event.onDOMReady(Shadowbox.init);

</script>
';
?>
