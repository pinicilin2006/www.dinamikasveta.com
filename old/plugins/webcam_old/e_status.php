<?php

if (!defined('e107_INIT')) { exit; }
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
$wcam_posts = $sql->db_Count("webcams", "(*)");
if (empty($wcam_posts))
{
    $wcam_posts = 0;
}
$text .= "<div style='padding-bottom: 2px;'><img src='" . e_PLUGIN . "webcam/images/webcam_16.png' style='width: 16px; height: 16px; vertical-align: bottom;border:0;' alt='' /> " . WCAM_A47 . ": " . $wcam_posts . "</div>";

?>