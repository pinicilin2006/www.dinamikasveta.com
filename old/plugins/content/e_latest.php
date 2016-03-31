<?php
if (!defined('e107_INIT')) { exit; }

$lan_file = $plugindir.'languages/'.e_LANGUAGE.'/lan_content_admin.php';
include_once(file_exists($lan_file) ? $lan_file : $plugindir.'languages/English/lan_content_admin.php');

$plugintable = "pcontent";
$reported_content = $sql -> db_Count($plugintable, '(*)', "WHERE content_refer='sa' ");
$text .= "
<div style='padding-bottom: 2px;'>
<img src='".e_PLUGIN."content/images/content_16.png' style='width: 16px; height: 16px; vertical-align: bottom' alt='' />
";
if($reported_content) {
	$text .= " <a href='".e_PLUGIN."content/admin_content_config.php?submitted'>".CONTENT_LATEST_LAN_1." $reported_content</a>";
} else {
	$text .= CONTENT_LATEST_LAN_1." ".$reported_content;
}
$text .= "</div>";

?>