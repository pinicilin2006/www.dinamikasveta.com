<?php
if (!defined('e107_INIT')) { exit; }
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
$wcam_title = WCAM_08;
$search_info[] = array('sfile' => e_PLUGIN . 'webcam/search.php', 'qtype' => $wcam_title, 'refpage' => 'webcam.php');

?>