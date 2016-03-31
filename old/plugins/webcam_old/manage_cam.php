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
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
require_once(HEADERF);
$webcam_admin = (check_class($pref['webcam_adminclass'])?true:false);
if (!$webcam_admin && !check_class($pref['webcam_ownclass']))
{
    // if not
    $wcam_text .= "
    	<table class='fborder' style='width:100%;'>
		<tr>
			<td class='fcaption' >" . WCAM_A01 . "</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' style='text-align:left;'>
				<a href='" . e_PLUGIN . "webcam/webcam.php' >
					<img src='" . e_PLUGIN . "webcam/images/updir.png' alt='" . WCAM_A92 . "' title='" . WCAM_A92 . "' style='border:0;' />
				</a>
			</td>
		</tr>
		<tr>
			<td class='forumheader3' >" . WCAM_A97 . "</td>
		</tr>
		<tr>
			<td class='fcaption' >&nbsp;</td>
		</tr>
		</table>";
}
else
{
    $wcam_action = $_REQUEST['wcam_action'];

    $wcam_edit = false;
    // * If we are updating then update or insert the record
    if (isset($_POST['wcam_submit']))
    {
        if (!check_class($pref['webcam_adminclass']) || !check_class($pref['webcam_autoapp']))
        {
            // if not an admin or not in auto approve class then unapprove the webcam
            $_REQUEST['webcam_approved'] = 0;
        }
        if (check_class($pref['webcam_autoapp']))
        {
            $_REQUEST['webcam_approved'] = 1;
        }
        $webcam_id = $_REQUEST['webcam_id'];

        if ($webcam_id == 0)
        {
            // New record so add it
            $wcam_args = "'0',
		'" . $tp->toDB($_REQUEST['webcam_name']) . "',
		'" . intval($_REQUEST['webcam_refresh']) . "',
		'" . intval($_REQUEST['webcam_approved']) . "',
		'" . $tp->toDB($_REQUEST['webcam_url']) . "',
		'" . $tp->toDB($_REQUEST['webcam_description']) . "',
		'" . $tp->toDB($_REQUEST['webcam_poster']) . "',
		'" . $tp->toDB($_REQUEST['webcam_provider']) . "',
		'" . $tp->toDB($_REQUEST['webcam_providerurl']) . "',
		'" . $tp->toDB($_REQUEST['webcam_location']) . "',
		'" . time() . "',0,
		'" . intval($_REQUEST['webcam_views']) . "',
		'" . intval($_REQUEST['webcam_menu']) . "'
		";
            if ($wcam_id = $sql->db_Insert("webcams", $wcam_args, false))
            {
                $wcam_msg .= "<b>" . WCAM_A32 . "</b>";
                if ($wcam_id > 0)
                {
                    $edata_sn = array("user" => USERNAME, "itemtitle" => $tp->toDB($_REQUEST['webcam_name']), "catid" => intval($wcam_id));
                    $e_event->trigger("camnew", $edata_sn);
                }
            }
            else
            {
                $wcam_msg .= "<b>" . WCAM_A33 . "</b>";
            }
        }
        else
        {
            // Update existing
            $wcam_args = "
		webcam_name='" . $tp->toDB($_REQUEST['webcam_name']) . "',
		webcam_refresh='" . intval($_REQUEST['webcam_refresh']) . "',
		webcam_approved='" . intval($_REQUEST['webcam_approved']) . "',
		webcam_url='" . $tp->toDB($_REQUEST['webcam_url']) . "',
		webcam_description='" . $tp->toDB($_REQUEST['webcam_description']) . "',
		webcam_poster='" . $tp->toDB($_REQUEST['webcam_poster']) . "',
		webcam_provider='" . $tp->toDB($_REQUEST['webcam_provider']) . "',
		webcam_providerurl='" . $tp->toDB($_REQUEST['webcam_providerurl']) . "',
		webcam_location='" . $tp->toDB($_REQUEST['webcam_location']) . "',
		webcam_menu='" . intval($_REQUEST['webcam_menu']) . "',
		webcam_views='" . intval($_REQUEST['webcam_views']) . "',
		webcam_updated='" . time() . "'
		where webcam_id='$webcam_id'";

            if ($sql->db_Update("webcams", $wcam_args))
            {
                // Changes saved
                $wcam_msg .= "<b>" . WCAM_A32 . "</b>";
                $edata_sn = array("user" => USERNAME, "itemtitle" => $tp->toDB($_REQUEST['webcam_name']), "catid" => intval($webcam_id));
                $e_event->trigger("camupdate", $edata_sn);
            }
            else
            {
                $wcam_msg .= "<b>" . WCAM_A33 . "</b>";
            }
        }
        $e107cache->clear("nq_webcams");
    }
    // We are creating, editing or deleting a record
    if ($wcam_action == 'dothings')
    {
        $webcam_id = $_REQUEST['wcam_selcat'];
        $wcam_do = $_REQUEST['wcam_recdel'];
        $wcam_dodel = false;

        switch ($wcam_do)
        {
            case '1': // Edit existing record
                {
                    // We edit the record
                    $sql->db_Select("webcams", "*", "webcam_id='$webcam_id'");
                    $wcam_row = $sql->db_Fetch() ;
                    extract($wcam_row);
                    $wcam_cap1 = WCAM_A22;
                    $wcam_edit = true;
                    break;
                }
            case '2': // New category
                {
                    // Create new record
                    $webcam_id = 0;
                    $wcam_cap1 = WCAM_A23;
                    $wcam_edit = true;
                    $webcam_id = 0;
                    break;
                }
            case '3':
                {
                    // delete the record
                    if ($_REQUEST['wcam_okdel'] == '1')
                    {
                        if ($sql->db_Delete("webcams", " webcam_id='$webcam_id'"))
                        {
                            $wcam_msg .= "<tr><td class='forumheader3' colspan='2'><strong>" . WCAM_A58 . "</strong></td></tr>";
                            $sql->db_Delete("rate", " rate_table='webcams' and rate_itemid='$webcam_id'");
                            $sql->db_Delete("comments", " comment_type='webcams' and comment_item_id='$webcam_id'");
                        }
                        else
                        {
                            $wcam_msg .= "<tr><td class='forumheader3' colspan='2'><strong>" . WCAM_A57 . "</strong></td></tr>";
                        }
                    }
                    else
                    {
                        $wcam_msg .= "<tr><td class='forumheader3' colspan='2'><strong>" . WCAM_A31 . "</strong></td></tr>";
                    }
                    $wcam_dodel = true;
                    $wcam_edit = false;
                }
        }

        if (!$wcam_dodel)
        {
            $wcam_poster = explode(".", $webcam_poster, 2);
            $wcam_posterid = $wcam_poster[0];
            $wcam_postername = $wcam_poster[1];
            $wcam_text .= "
            <script type=\"text/javascript\">
			function wcamcheckform(thisform)
			{
				var testresults=true;
				if (thisform.webcam_name.value=='' || thisform.webcam_url.value=='' || thisform.webcam_refresh.value=='' || thisform.webcam_description.value=='' )
				{
					alert('" . WCAM_46 . "');
					testresults=false;
				}
				if (testresults)
				{
					if (thisform.subbed.value=='no')
	  				{
						thisform.subbed.value='yes';
				   		testresults=true;
					}
					else
					{
		   				alert('" . WCAM_47 . "');
				   		return false;
			   		}
				}
				return testresults;
			}
		</script>
<form id='wcam_form' name='dataform' action='" . e_SELF . "' method='post' onsubmit='return wcamcheckform(this)' >
    <div>
	<input type='hidden' value='no' name='subbed'>";
            if (!$webcam_admin)
            {
                // if not an admin then save these values as there are no onscreen entries
                if (USERID > 0)
                {
                    $webcam_poster = USERID . "." . USERNAME;
                }
                else
                {
                    $webcam_poster = "0." . WCAM_A85 ;
                }
                $wcam_text .= "
        <input type='hidden' value='$webcam_views' name='webcam_views'>
        <input type='hidden' value='$webcam_approved' name='webcam_approved'>
        <input type='hidden' value='$webcam_menu' name='webcam_menu'>
        <input type='hidden' value='$webcam_poster' name='webcam_poster'>
		";
            }
            $wcam_text .= "<input type='hidden' value='$webcam_id' name='webcam_id'>
	</div>
	<table class='fborder' style='width:100%;'>
		<tr>
			<td class='fcaption' colspan='2'>" . $wcam_cap1 . "</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' style='text-align:left;'>
				<a href='" . e_PLUGIN . "webcam/manage_cam.php' ><img src='" . e_PLUGIN . "webcam/images/updir.png' alt='" . WCAM_A93 . "' title='" . WCAM_A93 . "' style='border:0;' /></a> $wcam_msg &nbsp;
			</td>
		</tr>
    	<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A24 . "<span class='smalltext' ><br />" . WCAM_45 . "</span></td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'>
				<input type='text' size='50' class='tbox' name='webcam_name' value='" . $tp->toFORM($webcam_name) . "' />
			</td>
		</tr>
    	<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A25 . "<span class='smalltext' ><br />" . WCAM_45 . "</span></td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='10' class='tbox' name='webcam_refresh' value='" . $webcam_refresh . "' /></td>
		</tr>
   		<tr>
		   	<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A26 . "<span class='smalltext' ><br />" . WCAM_45 . "</span></td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='80%' class='tbox' name='webcam_url' value='" . $tp->toFORM($webcam_url) . "' /></td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A43 . "</td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='50%' class='tbox' name='webcam_provider' value='" . $tp->toFORM($webcam_provider) . "' /></td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A77 . "</td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='50%' class='tbox' name='webcam_providerurl' value='" . $tp->toFORM($webcam_providerurl) . "' /></td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A62 . "</td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='50%' class='tbox' name='webcam_location' value='" . $tp->toFORM($webcam_location) . "' /></td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A44 . "<span class='smalltext' ><br />" . WCAM_45 . "</span></td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'>
				<textarea style='width:85%' cols='50' rows='7' class='tbox' name='webcam_description' >" . $tp->toFORM($webcam_description) . "</textarea></td>
		</tr>";
            if ($webcam_admin)
            {
                $wcam_text .= "
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A61 . "</td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='20%' class='tbox' name='webcam_views' value='" . $tp->toFORM($webcam_views) . "' /></td>
		</tr>
	 	<tr>
		 	<td class='forumheader3' style='width:30%;'>" . WCAM_A27 . "</td>
			<td class='forumheader3' style='width:70%;'><input type='checkbox' class='tbox' value='1' name='webcam_approved' " .
                ($webcam_approved > 0?" checked='checked' ":"") . " />
			</td>
		</tr>";
                $wcam_text .= "
		<tr>
			<td class='forumheader3' style='width:30%;'>" . WCAM_A59 . "</td>
			<td class='forumheader3' style='width:70%;'><input type='checkbox' class='tbox' value='1' name='webcam_menu' " .
                ($webcam_menu > 0?" checked='checked' ":"") . " />
			</td>
		</tr>";
                // Get list of users
                $wcam_thumbsel = "<select class='tbox' name='webcam_poster' >
		<option value='0." . WCAM_A85 . "'>" . WCAM_A85 . "</option>";
                $sql->db_Select("user", "user_id,user_name", "order by user_name", "nowhere", false);
                while ($wcam_row = $sql->db_Fetch())
                {
                    $wcam_thumbsel .= "<option " . ($wcam_row['user_id'] == $wcam_posterid?"selected='selected'":"") . " value='" . $wcam_row['user_id'] . "." . $tp->toFORM($wcam_row['user_name']) . "'>" . $tp->toFORM($wcam_row['user_name']) . "</option>";
                }
                $wcam_thumbsel .= "</select>";
                // users
                $wcam_text .= "
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A28 . "</td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'>$wcam_thumbsel</td>
		</tr>";
            }
            if ($webcam_admin || check_class($pref['webcam_autoapp']))
            {
            }
            else
            {
                $wcam_text .= "
		<tr>
			<td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_A95 . "</td>
			<td class='forumheader3' style='width:70%;vertical-align:top;'>" . ($webcam_approved == 0 ?WCAM_A96:WCAM_A94) . "</td>
		</tr>";
            }
            $wcam_text .= "
		<tr>
			<td class='fcaption' colspan='2'><input type='submit' class='tbox' name='wcam_submit' value='" . WCAM_A21 . "' /></td>
		</tr>
	</table>
</form>";
        }
    }
    if (!$wcam_edit)
    {
        // Get the web cams to display in combo box
        // then display actions available
        if (!$webcam_admin)
        {
            $webcam_where = "where SUBSTRING_INDEX(webcam_poster,'.',1)='" . USERID . "'";
        }
        $wcam_yes = false;
        if ($sql->db_Select("webcams", "*", "$webcam_where order by webcam_name", "nowhere", false))
        {
            while ($wcam_row = $sql->db_Fetch())
            {
                $wcam_yes = true;
                extract($wcam_row);
                $wcam_catopt .= "<option value='$webcam_id'" .
                ($wcam_id == $webcam_id?" selected='selected'":"") . ">" . $tp->toFORM($webcam_name) . "</option>";
            }
        }
        else
        {
            $wcam_catopt .= "<option value='0'>" . WCAM_A15 . "</option>";
        }

        $wcam_text .= "
<form id='wcamform' method='post' action='" . e_SELF . "'>
	<div>
		<input type='hidden' value='dothings' name='wcam_action' />
	</div>
	<table style='width:100%;' class='fborder'>
		<tr>
			<td colspan='2' class='fcaption'>" . WCAM_A02 . "</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' style='text-align:left;'>
				<a href='" . e_PLUGIN . "webcam/webcam.php' >
					<img src='" . e_PLUGIN . "webcam/images/updir.png' alt='" . WCAM_A92 . "' title='" . WCAM_A92 . "' style='border:0;' />
				</a>&nbsp;&nbsp;&nbsp; $wcam_msg
			</td>
		</tr>
		<tr>
			<td style='width:20%;' class='forumheader3'>" . WCAM_A04 . "</td>
			<td  class='forumheader3'><select name='wcam_selcat' class='tbox'>$wcam_catopt</select></td>
		</tr>
		<tr>
			<td style='width:20%;' class='forumheader3'>" . WCAM_A20 . "</td><td  class='forumheader3'>
				<input type='radio' name='wcam_recdel' value='1'  " . ($wcam_yes?"checked='checked'":"disabled='disabled'") . "  /> " . WCAM_A16 . "<br />
				<input type='radio' name='wcam_recdel' value='2' " . (!$wcam_yes?"checked='checked'":"") . "  /> " . WCAM_A17 . "<br />
				<input type='radio' name='wcam_recdel' value='3' /> " . WCAM_A18 . "
				<input type='checkbox' name='wcam_okdel' value='1' />" . WCAM_A19 . "
			</td>
		</tr>
		<tr>
			<td colspan='2' class='fcaption'><input type='submit' name='submits' value='" . WCAM_A21 . "' class='tbox' /></td>
		</tr>
	</table>
</form>";
    }
}
$ns->tablerender(WCAM_A14, $wcam_text);
require_once(FOOTERF);

?>