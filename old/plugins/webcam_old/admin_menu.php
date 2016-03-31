<?php
//**************************************************************************
//*
//*  Webcam Menu for e107 v7
//*
//**************************************************************************
if (!defined('e107_INIT'))
{
    exit;
}
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");

$action = basename($_SERVER['PHP_SELF'], ".php");

$var['admin_config']['text'] = WCAM_A03;
$var['admin_config']['link'] = "admin_config.php";

$var['admin_submit']['text'] = WCAM_A05;
$var['admin_submit']['link'] = "admin_submit.php";

$var['admin_report']['text'] = WCAM_A63;
$var['admin_report']['link'] = "admin_report.php";

$var['admin_vupdate']['text'] = WCAM_A06;
$var['admin_vupdate']['link'] = "admin_vupdate.php";

show_admin_menu(WCAM_A02, $action, $var);
?>
