<?php
// **************************************************************************
// *
// *  WebCam for e107 v7xx
// *
// **************************************************************************
require_once("../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms("P"))
{
    header("location:" . e_HTTP . "index.php");
    exit;
}
require_once(e_ADMIN . "auth.php");
require_once(e_HANDLER . "userclass_class.php");
// require_once(e_HANDLER . "cache_handler.php");
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");

if (e_QUERY == "update")
{
    // Update rest
    $pref['webcam_menutitle'] = $tp->toDB($_POST['webcam_menutitle']);
    $pref['webcam_readclass'] = intval($_POST['webcam_readclass']);
    $pref['webcam_submitclass'] = intval($_POST['webcam_submitclass']);
    $pref['webcam_adminclass'] = intval($_POST['webcam_adminclass']);
    $pref['webcam_ownclass'] = intval($_POST['webcam_ownclass']);
    $pref['webcam_autoapp'] = intval($_POST['webcam_autoapp']);
    $pref['webcam_perpage'] = intval($_POST['webcam_perpage']);
    $pref['webcam_inmenu'] = intval($_POST['webcam_inmenu']);
    $pref['webcam_report'] = intval($_POST['webcam_report']);
    $pref['webcam_cols'] = intval($_POST['webcam_cols']);
    $pref['webcam_comment'] = intval($_POST['webcam_comment']);
    $pref['webcam_rate'] = intval($_POST['webcam_rate']);
    $pref['webcam_rand'] = intval($_POST['webcam_rand']);
    $pref['webcam_defref'] = $_POST['webcam_defref'];
    $pref['webcam_opennew'] = intval($_POST['webcam_opennew']);
    $pref['webcam_mh'] = intval($_POST['webcam_mh']);
    $pref['webcam_mw'] = intval($_POST['webcam_mw']);
    $pref['webcam_desc'] = $tp->toDB($_POST['webcam_desc']);
    $pref['webcam_key'] = $tp->toDB($_POST['webcam_key']);
    save_prefs();
    $e107cache->clear("nq_webcams");
    $wcam_msgtext =  WCAM_A34 ;
}

$wcam_text .= "
<form method='post' action='" . e_SELF . "?update' id='confwcam'>
	<table style='width: 100%;' class='fborder'>
		<tr>
			<td colspan='2' class='fcaption'>" . WCAM_A03 . "</td>
		</tr>
		<tr>
			<td class='forumheader3' colspan='2'><strong>$wcam_msgtext&nbsp;</strong></td>
		</tr>
";
// Main admin class
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A07 . "</td>
<td style='width:70%' class='forumheader3'>" . r_userclass("webcam_readclass", $pref['webcam_readclass'], "off", "guest,nobody,public,member,admin,main,classes") . "
</td></tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A08 . "</td>
<td style='width:70%' class='forumheader3'>" . r_userclass("webcam_submitclass", $pref['webcam_submitclass'], "off", "guest,nobody,public,member,admin,main,classes") . "
</td></tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A79 . "</td>
<td style='width:70%' class='forumheader3'>" . r_userclass("webcam_adminclass", $pref['webcam_adminclass'], "off", "nobody,admin,main,classes") . "
</td></tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A80 . "</td>
<td style='width:70%' class='forumheader3'>" . r_userclass("webcam_ownclass", $pref['webcam_ownclass'], "off", "nobody,member,admin,main,classes") . "
</td></tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A09 . "</td>
<td style='width:70%' class='forumheader3'>" . r_userclass("webcam_autoapp", $pref['webcam_autoapp'], "off", "guest,nobody,public,member,admin,main,classes") . "
</td></tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A10 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='30' name='webcam_menutitle' value='" . $tp->toFORM($pref['webcam_menutitle']) . "' /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A76 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='10' name='webcam_defref' value='" . $tp->toFORM($pref['webcam_defref']) . "' /></td>
</tr>";
// Number of cams to show in gallery
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A11 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='10' name='webcam_perpage' value='" . $tp->toFORM($pref['webcam_perpage']) . "' /></td>
</tr>";
// Number of cams in menu
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A12 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='10' name='webcam_inmenu' value='" . $pref['webcam_inmenu'] . "' /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A74 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='10' name='webcam_mh' value='" . $pref['webcam_mh'] . "' /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A75 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='10' name='webcam_mw' value='" . $pref['webcam_mw'] . "' /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A60 . "</td>
<td style='width:70%' class='forumheader3'>
<input class='tbox' type='checkbox' name='webcam_rand' value='1' " . ($pref['webcam_rand'] == 1?"checked='checked'":"") . " /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A29 . "</td>
<td style='width:70%' class='forumheader3'><input class='tbox' type='text'  size='10' name='webcam_cols' value='" . $pref['webcam_cols'] . "' /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A13 . "</td>
<td style='width:70%' class='forumheader3'>
<input class='tbox' type='checkbox' name='webcam_report' value='1' " . ($pref['webcam_report'] == 1?"checked='checked'":"") . " /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A30 . "</td>
<td style='width:70%' class='forumheader3'>
<input class='tbox' type='checkbox' name='webcam_comment' value='1' " . ($pref['webcam_comment'] == 1?"checked='checked'":"") . " /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A31 . "</td>
<td style='width:70%' class='forumheader3'>
<input class='tbox' type='checkbox' name='webcam_rate' value='1' " . ($pref['webcam_rate'] == 1?"checked='checked'":"") . " /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A78 . "</td>
<td style='width:70%' class='forumheader3'>
<input class='tbox' type='checkbox' name='webcam_opennew' value='1' " . ($pref['webcam_opennew'] == 1?"checked='checked'":"") . " /></td>
</tr>";
$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A64 . "</td>
<td style='width:70%' class='forumheader3'>
<textarea class='tbox' cols='50' name = 'webcam_desc' rows='6' style='width:80%'>" . $tp->toFORM($pref['webcam_desc']) . "</textarea></td>
</tr>";

$wcam_text .= "
<tr>
<td style='width:30%' class='forumheader3'>" . WCAM_A65 . "</td>
<td style='width:70%' class='forumheader3'>
<textarea class='tbox' cols='50' rows='6'  name = 'webcam_key' style='width:80%'>" . $tp->toFORM($pref['webcam_key']) . "</textarea></td>
</tr>";
// Submit button
$wcam_text .= "
<tr>
<td colspan='2' class='fcaption' style='text-align: left;'><input type='submit' name='update' value='" . WCAM_A21 . "' class='button' />\n
</td>
</tr>";
$wcam_text .= "</table></form>";
$ns->tablerender(WCAM_A01, $wcam_text);
require_once(e_ADMIN . "footer.php");

?>