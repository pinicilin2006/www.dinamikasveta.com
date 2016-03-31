<?php
/*
+ ----------------------------------------------------------------------------------------------------+
|        e107 website system 
|        Plugin BBcode File :  e107_plugins/videobox_V2/e_bb.php
|        Email: 
|        $Revision$
|        $Date$
|        $Author$
|        Support Sites : 
+----------------------------------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }


$bb['name']		= 'videobox_V2'; 
$bb['onclick']		= ''; 
$bb['onclick_var']=" &lt;a href=&quot;http://www.Pfad zum film&quot; title=&quot;dein Titel&quot; class=&quot;option&quot; rel=&quot;shadowbox;width=320;height=240\&quot;&gt;text oder &lt;img src=&quot;dein Bild&quot; alt=&quot;&quot;&gt;&lt;/a&gt;";
$bb['icon']		= e_PLUGIN."videobox_V2/images/bb.png";
$bb['helptext']		= '';
$bb['function']		= '';   
$bb['function_var']     = '';  

 //append the bbcode to the default templates:
 
$BBCODE_TEMPLATE .= "{BB=videobox_V2}"; 
$BBCODE_TEMPLATE_NEWSPOST .= "{BB=videobox_V2}";
$BBCODE_TEMPLATE_ADMIN .= "{BB=videobox_V2}";
$BBCODE_TEMPLATE_CPAGE .= "{BB=videobox_V2}"; 

$eplug_bb[] = $bb;  // add to the global list - Very Important!    

?>
