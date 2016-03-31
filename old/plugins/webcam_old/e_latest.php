<?php

if (!defined('e107_INIT'))
{
    exit;
}
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
$wcam_approve = $sql->db_Count('webcams', '(*)', "WHERE webcam_approved='0'");
$text .= "<div style='padding-bottom: 2px;'>
<img src='" . e_PLUGIN . "webcam/images/webcam_16.png' style='width: 16px; height: 16px; vertical-align: bottom;border:0;' alt='' /> ";
if (empty($wcam_approve))
{
    $wcam_approve = 0;
}

$text .= "<a href='" . e_PLUGIN . "webcam/admin_submit.php'>" . WCAM_A45 . ": " . $wcam_approve . "</a>";

$text .= '</div>';
// Reported
$wcam_approve = $sql->db_Count('generic', '(*)', "WHERE gen_type='reported_webcam'");
$text .= "<div style='padding-bottom: 2px;'>";
if ($wcam_approve > 0)
{
    $text .= "<br /><strong><a href='" . e_PLUGIN . "webcam/admin_report.php'>" . WCAM_A58 . ": [$wcam_approve] </a></strong>";
}
$text .= '</div>';

?>