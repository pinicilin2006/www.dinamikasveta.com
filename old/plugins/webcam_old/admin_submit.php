<?php
// **************************************************************************
// *
// *  UKGigs Menu for e107 v7xx
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
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
require_once(e_ADMIN . "auth.php");

if ($_POST['wcam_action'] == "wcam_app")
{
    $wcam_apparray = $_POST['wcam_app'];

    foreach($wcam_apparray as $wcam_element)
    {
        $sql->db_Update("webcams", "webcam_approved='1' where webcam_id='$wcam_element' ", false);
    }
    $wcam_delarray = $_POST['wcam_del'];
    foreach($wcam_delarray as $wcam_element)
    {
    //delete the webcam and any rating or comments
        $sql->db_Delete("webcams", "webcam_id='$wcam_element' ", false);
        $sql->db_Delete("rate", " rate_table='webcams' and rate_itemid='$wcam_element'");
        $sql->db_Delete("comments", " comment_type='webcams' and comment_item_id='$wcam_element'");
    }

    $wcam_text .= "<table class='fborder' style='width:97%;'>
<tr><td class='fcaption'>" . WCAM_A36 . "</td></tr>
<tr><td class='forumheader3'><strong>" . WCAM_A42 . "</strong></td></tr>
</table>";
    $e107cache->clear("nq_webcams");
}

$wcam_text .= "
<form id='wcam_qap' action='" . e_SELF . "' method='post'>
<div>
<input type='hidden' name='wcam_action' value='wcam_app' />
</div>
<table class='fborder' style='width:97%;'>
<tr><td class='fcaption' colspan='5'>" . WCAM_A36 . "</td></tr>";

$wcam_text .= "
<tr>
<td class='forumheader2' style='width:35%;'><span class='smalltext'>" . WCAM_A24 . "</span></td>
<td class='forumheader2' style='width:35%;'><span class='smalltext'>" . WCAM_A26 . "</span></td>
<td class='forumheader2' style='width:35%;'><span class='smalltext'>" . WCAM_A28 . "</span></td>
<td class='forumheader2' style='width:10%;text-align:center;'><img src='./images/approve.gif' alt='" . WCAM_A37 . "' title='" . WCAM_A37 . "' /></td>
<td class='forumheader2' style='width:10%;text-align:center;'><img src='./images/delete.gif' alt='" . WCAM_A38 . "' title='" . WCAM_A38 . "' /></td>
</tr>";
if ($sql->db_Select("webcams", "*", "where webcam_approved=0 order by webcam_name", "nowhere", false))
{
    while ($wcam_row = $sql->db_Fetch())
    {
        extract($wcam_row);
        $wcam_post = explode(".", $webcam_poster);
        $wcam_postname = $wcam_post[1];
        $wcam_text .= "<tr>
			<td class='forumheader3'>$webcam_name</td>
			<td class='forumheader3'>$webcam_url</td>
			<td class='forumheader3'>$wcam_postname&nbsp;</td>
			<td class='forumheader3' style='text-align:center;'><input type='checkbox' class='tbox' style='border:0;' name='wcam_app[]' id='app' value='$webcam_id' /></td>
			<td class='forumheader3' style='text-align:center;'><input type='checkbox' class='tbox' style='border:0;' name='wcam_del[]' id='delit' value='$webcam_id' /></td>
			</tr>";
    } // while
    $wcam_text .= "<tr><td class='forumheader3' colspan='3' style='text-align:center;'>&nbsp;</td>
		<td class='forumheader3' style='text-align:center;'>
				<input class='button' type='button' name='CheckAlls' value='" . WCAM_A40 . "'
onclick=\"setCheckboxes('wcam_qap', true, 'wcam_app[]'); return false;\"  /><br />
				<input class='button' type='button' name='CheckAlls' value='" . WCAM_A41 . "'
onclick=\"setCheckboxes('wcam_qap', false, 'wcam_app[]'); return false;\"  />

</td>
<td class='forumheader3' style='text-align:center;'>
				<input class='button' type='button' name='CheckAlls' value='" . WCAM_A40 . "'
onclick=\"setCheckboxes('wcam_qap', true, 'wcam_del[]'); return false;\"  /><br />
				<input class='button' type='button' name='CheckAlls' value='" . WCAM_A41 . "'
onclick=\"setCheckboxes('wcam_qap', false, 'wcam_del[]'); return false;\"  />
</td>
</tr>
<tr><td class='fcaption' colspan='5'><input class='button' type='submit' name='ukgigub_app' value='" . WCAM_A21 . "' /></td></tr>";
}

else
{
    $wcam_text .= "<tr><td class='forumheader3' colspan='5'>" . WCAM_A39 . "</td></tr>";
}
$wcam_text .= "</table></form>";

$ns->tablerender(WCAM_A35, $wcam_text);
require_once(e_ADMIN . "footer.php");

?>