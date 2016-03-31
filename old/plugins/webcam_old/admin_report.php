<?php
// **************************************************************************
// *
// *  WebCam for e107 v6xx
// *
// **************************************************************************
require_once("../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms("P"))
{
    header("location:" . e_BASE . "index.php");
    exit;
}

include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");

require_once(e_ADMIN . "auth.php");

if (isset($_POST['submitit']))
{
    foreach($_POST['wcamabuse'] as $wcam_item)
    {
        $sql->db_Delete("generic", "gen_id='{$wcam_item}'", false);
    }
    $e107cache->clear("nq_webcams");
}
$wcam_text = "<form method='post' id='wcamab' action='" . e_SELF . "' ><table style='width:100%' class='fborder'> ";
$wcam_text .= "
<tr><td class='fcaption' colspan='5'>" . WCAM_A71 . "</td></tr>
<tr>
<td class='fcaption' style='width:20%;' >" . WCAM_A66 . "</td>
<td class='fcaption' style='width:20%;' >" . WCAM_A67 . "</td>
<td class='fcaption' style='width:20%;' >" . WCAM_A70 . "</td>
<td class='fcaption' style='width:30%;' >" . WCAM_A69 . "</td>
<td class='fcaption' style='width:10%;' >" . WCAM_A68 . "</td>
</tr>";
$wcam_arg = "select * from #generic
left join #webcams on gen_intdata=webcam_id
left join #user on gen_user_id=user_id
where gen_type='reported_webcam'";
$wcam_yes = false;
if ($sql->db_Select_gen($wcam_arg, false))
{
    $wcam_yes = true;
    while ($wcam_row = $sql->db_Fetch())
    {
        extract($wcam_row);
        $wcam_text .= "
<tr>
	<td class='forumheader3' style='width:20%;' >" . $tp->toFORM($webcam_name) . "</td>
	<td class='forumheader3' style='width:20%;' >" . $tp->toFORM($user_name) . "</td>
	<td class='forumheader3' style='width:20%;' >" . $tp->toFORM($gen_ip) . "</td>
	<td class='forumheader3' style='width:30%;' >" . $tp->toFORM($gen_chardata) . "</td>
	<td class='forumheader3' style='width:10%;' ><input type='checkbox' name='wcamabuse[]' value='$gen_id' /></td>
</tr>";
    } // while
}
else
{
    $wcam_text .= "<tr><td class='fcaption' colspan='5'>" . WCAM_A73 . "</td></tr>";
}
if ($wcam_yes)
{
    $wcam_text .= "<tr><td class='fcaption' colspan='5'><input class='tbox' type='submit' name='submitit' value='" . WCAM_A72 . "' /></td></tr>";
}
$wcam_text .= "</table></form>";
$ns->tablerender(WCAM_A14, $wcam_text);
require_once(e_ADMIN . "footer.php");

?>