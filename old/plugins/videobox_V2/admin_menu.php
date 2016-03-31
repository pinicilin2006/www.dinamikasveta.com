<?php
/*
+ ----------------------------------------------------------------------------------------------------+
|        e107 website system 
|        Plugin File :  e107_plugins/videobox_V2/admin_menu.php
|        Email: support@free-source.net
|        $Revision$
|        $Date$
|        $Author$
|        Support Sites : 
+----------------------------------------------------------------------------------------------------+
*/

	$menutitle = Menu;//"videobox_V2";

	$butname[] = videobox_V2;//config
	$butlink[] = "admin_config.php";  
	$butid[] = "config"; 
	
	$butname[] = Erweiterte_Anweisungen;//help
	$butlink[] = "admin_config.php?help";  
	$butid[] = "help"; 

global $pageid;
	for ($i=0; $i<count($butname); $i++) {
        $var[$butid[$i]]['text'] = $butname[$i];
		$var[$butid[$i]]['link'] = $butlink[$i];
	};

    show_admin_menu($menutitle,$pageid, $var);

?>
