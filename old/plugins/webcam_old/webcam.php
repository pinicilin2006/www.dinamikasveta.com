<?php

require_once("../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}
if (!defined(USER_WIDTH))
{
    define(USER_WIDTH, "100%");
}
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
require_once(e_HANDLER . "rate_class.php");
$rater = new rater;
require_once(e_HANDLER . "comment_class.php");
$wcam_com = new comment;
$wcam_images = SITEURL . $PLUGINS_DIRECTORY . "webcam/images/";
require_once(e_HANDLER . "emailprint_class.php");
$wcam_from = 0;
$wcam_rel = ($pref['webcam_opennew'] > 0?"rel='external'":"");
if (!check_class($pref['webcam_readclass']))
{
    $wcam_text = "<table class='fborder' style='width:" . USER_WIDTH . ";'>
			<tr>
				<td class='fcaption' >" . WCAM_07 . "</td>
			</tr>
			<tr>
				<td class='forumheader3'  style='text-align:left;'>" . WCAM_33 . "</td>
		</tr>";
    $wcam_text .= "</table>";
}
else
{
    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $wcam_from = intval($_POST['wcam_from']);
        $wcam_action = $_POST['wcam_action'];
        $wcam_id = intval($_POST['wcam_id']);
    } elseif (e_QUERY)
    {
        $tmp = explode(".", e_QUERY);
        $wcam_from = intval($tmp[0]);
        $wcam_action = $tmp[1];
        $wcam_id = intval($tmp[2]);
    }
    $wcam_upviews = true;
    if (isset($_POST['commentsubmit']))
    {
        $wcam_upviews = false;
        $tmp = explode(".", e_QUERY);
        $wcam_from = intval($tmp[0]);
        $wcam_action = "view";
        $wcam_id = intval($tmp[2]);
        $wcam_com->enter_comment($_POST['author_name'], $_POST['comment'], "webcams", $wcam_id, $pid, $_POST['subject']);
    }
    switch ($wcam_action)
    {
        case "postnew":
            // New record so add it
            if (!check_class($pref['webcam_submitclass']))
            {
                exit;
            }
            if (empty($_REQUEST['webcam_url']) || empty($_REQUEST['webcam_name']) || empty($_REQUEST['webcam_refresh']) || empty($_REQUEST['webcam_provider']))
            {
                $wcam_text = "bits missing";
            }
            else
            {
                if (!is_numeric($_REQUEST['webcam_refresh']))
                {
                    $_REQUEST['webcam_refresh'] = ($pref['webcam_defref'] > 0?$pref['webcam_defref']:120);
                }
                $wcam_approve = (check_class($pref['webcam_autoapp'])?1:0);
                $wcam_poster = (USER?USERID . "." . USERNAME:"0.Anon");
                $wcam_args = "'0',
		'" . $tp->toDB($_REQUEST['webcam_name']) . "',
		'" . intval($_REQUEST['webcam_refresh']) . "',
		'" . intval($wcam_approve) . "',
		'" . $tp->toDB($_REQUEST['webcam_url']) . "',
		'" . $tp->toDB($_REQUEST['webcam_description']) . "',
		'" . $tp->toDB($wcam_poster) . "',
		'" . $tp->toDB($_REQUEST['webcam_provider']) . "',
		'" . $tp->toDB($_REQUEST['webcam_providerurl']) . "',
		'" . $tp->toDB($_REQUEST['webcam_location']) . "',
		'" . time() . "',0,0,0";
                if ($wcam_id = $sql->db_Insert("webcams", $wcam_args, false))
                {
                    $wcam_msg .= "<tr><td class='forumheader3' colspan='2'>" . WCAM_30 . " " . (check_class($pref['webcam_autoapp'])?"":WCAM_31) . "</td></tr>";
                    $edata_sn = array("user" => USERNAME, "itemtitle" => $tp->toDB($_REQUEST['webcam_name']), "catid" => intval($wcam_id));
                    $e_event->trigger("camnew", $edata_sn);
                }
                else
                {
                    $wcam_msg .= "<tr><td class='forumheader3' colspan='2'><b>" . WCAM_A33 . "</b></td></tr>";
                }
            }
            $e107cache->clear("nq_webcams");
            $wcam_text = "<table class='fborder' style='width:" . USER_WIDTH . ";'>
			<tr>
				<td class='fcaption' >" . WCAM_07 . "</td>
			</tr>
			<tr>
				<td class='forumheader3'  style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a></td>
		</tr>";
            $wcam_text .= $wcam_msg . "</table>";
            break;
        case "subnew":
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
		<form id='wcam_form' name='wcam_form' action='" . e_SELF . "' method='post' onsubmit='return wcamcheckform(this)'>
        <div>
        <input type='hidden' value='subbed' name='no'>
        <input type='hidden' value='postnew' name='wcam_action'>
        </div>
<table class='fborder' style='width:" . USER_WIDTH . ";'>
<tr><td class='fcaption' colspan='2'>" . WCAM_07 . "</td></tr>
<tr>
			<td class='forumheader2' colspan='2' style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a></td>
		</tr>
    <tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_24 . "<br /><em>" . WCAM_45 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'>
	<input type='text' size='50' class='tbox' name='webcam_name' value='" . $tp->toFORM($webcam_name) . "' /></td></tr>";
            $wcam_text .= "

    <tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_25 . "<br /><em>" . WCAM_45 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='10' class='tbox' name='webcam_refresh' value='" . $webcam_refresh . "' /></td></tr>
    <tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_26 . "<br /><em>" . WCAM_45 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='80%' class='tbox' name='webcam_url' value='" . $tp->toFORM($webcam_url) . "' /></td></tr>
<tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_27 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='50%' class='tbox' name='webcam_provider' value='" . $tp->toFORM($webcam_provider) . "' /></td></tr>
<tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_26 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='50%' class='tbox' name='webcam_providerurl' value='" . $tp->toFORM($webcam_providerurl) . "' /></td></tr>
<tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_43 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'><input type='text' size='50%' class='tbox' name='webcam_location' value='" . $tp->toFORM($webcam_location) . "' /></td></tr>

	<tr><td class='forumheader3' style='width:30%;vertical-align:top;'>" . WCAM_28 . "<br /><em>" . WCAM_45 . "</td>
	<td class='forumheader3' style='width:70%;vertical-align:top;'><textarea size='50%' cols='50' rows='7' class='tbox' name='webcam_description' >" . $tp->toFORM($webcam_description) . "</textarea></td></tr>	";
            $wcam_text .= "<tr><td class='fcaption' colspan='2'><input type='submit' class='tbox' name='wcam_submit' value='" . WCAM_29 . "' /></td></tr>
</table></form>";
            break;
        case "report":
            $report_id = $tp->toDB($_POST['wcam_id']);
            $wcam_name = $tp->toDB($_POST['wcam_name']);
            $wcam_report = $tp->toDB($_POST['wcam_abuserep']);
            $wcam_ip = $e107->getip();
            if ($sql->db_Select("generic", "gen_id", "where gen_type='reported_webcam' and gen_user_id='" . USERID . "' and gen_ip='{$wcam_ip}' and gen_intdata='{$report_id}'", "nowhere", false))
            {
                // duplicate report
                $wcam_text = "<table class='fborder' style='width:" . USER_WIDTH . "'>
		<tr>
		<td class='fcaption' style='text-align:left;'>" . WCAM_21 . "</td></tr>
		<tr>
			<td class='forumheader2'  style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a></td>
		</tr>
		<tr>
			<td class='forumheader2' style='text-align:left;'>" . WCAM_48 . "</td>
		</tr>
		</table>";
            }
            else
            {
                $sql->db_Insert("generic", "0,'reported_webcam','" . time() . "','" . USERID . "','{$wcam_ip}','{$report_id}','" . $wcam_report . "'", false);
                $edata_sn = array("abuse" => $wcam_report, "user" => USERNAME, "itemtitle" => $wcam_name, "catid" => intval($report_id));
                $e_event->trigger("camabuse", $edata_sn);
                $wcam_text = "<table class='fborder' style='width:" . USER_WIDTH . "'>
		<tr>
		<td class='fcaption' style='text-align:left;'>" . WCAM_21 . "</td></tr>
		<tr>
			<td class='forumheader2'  style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a></td>
		</tr>
		<tr>
			<td class='forumheader2' style='text-align:left;'>" . WCAM_22 . "</td>
		</tr>
		</table>";
            }
            break;
        case "abuse":
            // $signup_imagecode = ($pref['signcode'] && extension_loaded("gd"));
            if (USER)
            {
                $sql->db_Select("webcams", "*", "where webcam_id=$wcam_id", "nowhere", false);
                $wcam_row = $sql->db_Fetch();
                extract($wcam_row);
                $wcam_text .= "<form id='wcamabuse' action='" . e_SELF . "' method='post'>
        <div>
        <input type='hidden' name='wcam_id' value='$wcam_id' />
                <input type='hidden' name='wcam_action' value='report' />
        <input type='hidden' name='wcam_name' value='$webcam_name' />
        </div>
	<table class='fborder' style='width:" . USER_WIDTH . "'>
		<tr><td class='fcaption' colspan='2' style='text-align:left;'>" . WCAM_21 . "</td></tr>
				<tr>
			<td class='forumheader2' colspan='2' style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a></td>
		</tr>
	<tr><td class='forumheader3' style='width:25%;text-align:left;'>" . WCAM_E01 . "</td><td class='forumheader3' style='width:75%;text-align:left;'>$webcam_name</td></tr>
	<tr><td class='forumheader3' style='width:25%;text-align:left;'>" . WCAM_E02 . "</td><td class='forumheader3' style='width:75%;text-align:left;'><textarea cols='50' rows='7' style='width:90%' class='tbox' name='wcam_abuserep'></textarea></td></tr>
	<tr><td class='fcaption' colspan='2' style='text-align:left;'><input type='submit' class='tbox' name='wcam_abuse' value='" . WCAM_20 . "' /></td></tr>
	</table>
	</form>
	";
            }
            else
            {
                $wcam_text .= "<table class='fborder' style='width:" . USER_WIDTH . "'>
		<tr><td class='fcaption'  style='text-align:left;'>" . WCAM_21 . "</td></tr>
				<tr>
			<td class='forumheader2' style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a></td>
		</tr>
	<tr><td class='forumheader3' style='width:25%;text-align:left;'>" . WCAM_32 . "</td></tr>
	</table>";
            }
            break;
        case "view":
            if ($sql->db_Select("webcams", "*", "where webcam_id=$wcam_id and webcam_approved>0", "nowhere", false))
            {
                if ($wcam_upviews)
                {
                    $sql2->db_Update("webcams", "webcam_views=webcam_views+1 where webcam_id=$wcam_id", false);
                }
                $wcam_row = $sql->db_Fetch();
                extract($wcam_row);
                $wcam_text .= "
	<script type=\"text/javascript\">
<!--
//
//AJAXCam v0.8b (c) 2005 Douglas Turecek http://www.ajaxcam.com
//
holdUp()
function holdUp()
{
//
// This function is first called either by an onLoad event in the <body> tag
// or some other event, like onClick.
//
// Set the value of refreshFreq to how often (in seconds)
// you want the picture to refresh
//
refreshFreq=" . $webcam_refresh . ";
//
//after the refresh time elapses, go and update the picture
//
setTimeout(\"freshPic()\", refreshFreq*1000);
}

function freshPic()
{
//
// Get the source value for the picture
// e.g. http://www.mysite.com/doug.jpg and
//
var currentPath=document.campic.src;
//
// Declare a new array to put the trimmed part of the source
// value in
//
var trimmedPath=new Array();
//
// Take everything before a question mark in the source value
// and put it in the array we created e.g. doug.jpg?0.32234 becomes
// doug.jpg (with the 0.32234 going into the second array spot
//
trimmedPath=currentPath.split(\"?\");
//
// Take the source value and tack a qustion mark followed by a random number
// This makes the browser treat it as a new image and not use the cached copy
//
document.campic.src = trimmedPath[0] + \"?\" + Math.random();
//
// Go back and wait again.
holdUp();
}

// -->
</script>
	<table class='fborder' style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='fcaption' colspan='2' style='text-align:center;'>" . $webcam_name . "</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' style='text-align:left;'><a href='" . e_SELF . "?0.list.0'><img src='{$wcam_images}updir.png' style='border:0;' alt='" . WCAM_05 . "' title='" . WCAM_05 . "' /></a>&nbsp;&nbsp;<a href='../../email.php?plugin:webcam.$webcam_id' title='" . RCPEMENU_92 . "'><img src='" . e_IMAGE . "generic/" . IMODE . "/email.png' style='border:0;' title='" . WCAM_52 . "' alt='" . WCAM_52 . "' /></a></td>
		</tr>
		<tr>";
                $wcam_tmp = explode(".", $webcam_poster);
                $wcam_poster = $wcam_tmp[1];
                $wcam_url = $tp->toFORM($webcam_url, false);
                $wcam_file = fopen($wcam_url, "r");
                if (!empty($wcam_url) && $wcam_file)
                {
                    $wcam_img = "<img name='campic' src='" . $wcam_url . "' style='border:0;width:90%' alt=\"" . WCAM_01 . "\"/>";
                }
                else
                {
                    $wcam_img = "<img src='images/offline.png' style='border:0;width:98px;' alt='" . WCAM_41 . "' />";
                }
                fclose($wcam_file);
                $wcam_refresh = ($webcam_refresh > 60?intval($webcam_refresh / 60) . " " . WCAM_13:$webcam_refresh . " " . WCAM_11);
                $webcam_showname = $tp->toFORM($webcam_name);
                $wcam_text .= "
			<td class='forumheader3' colspan='2' style='text-align:center;'>" . $wcam_img . "</td>
		</tr>
		<tr>
			<td class='forumheader3' style='vertical-align:top;text-align:center;width:50%;'>
				" . WCAM_06 . " <strong>" . $tp->toHTML($webcam_name, false, "no_make_clickable no_replace") . "</strong><br />";
                if (!empty($webcam_providerurl))
                {
                    if (strpos($webcam_providerurl, "http://") === false)
                    {
                        $webcam_providerurl = "http://" . $webcam_providerurl;
                    }
                    $wcam_text .= WCAM_04 . " <a href='" . $tp->toFORM($webcam_providerurl, false, "no_make_clickable no_replace") . "' $wcam_rel><strong>" . $tp->toHTML($webcam_provider, false, "no_make_clickable no_replace") . "</strong></a><br />";
                }
                else
                {
                   
                }
                $wcam_text .= WCAM_43 . " <strong>" . $tp->toHTML($webcam_location, false, "no_make_clickable no_replace") . "</strong><br />			                             " . WCAM_10 . " $wcam_refresh <br />
				" . ($pref['webcam_report'] > 0?"<a href='" . e_SELF . "?0.abuse.$webcam_id'>" . WCAM_12 . "</a>":"") . "
			</td>
			<td class='forumheader3' style='vertical-align:top;text-align:left;width:50%;'>" . $tp->toHTML($webcam_description, false, "no_make_clickable no_replace") . "&nbsp;";
                if ($pref['webcam_rate'] > 0)
                {
                    // rating
                    if ($ratearray = $rater->getrating("webcams", $wcam_id))
                    {
                        if (defined("IMODE"))
                        {
                            $wcam_star = e_IMAGE . "rate/" . IMODE;
                        }
                        else
                        {
                            $image = $wcam_star = e_IMAGE . "rate/lite";
                        }
                        for($c = 1;
                            $c <= $ratearray[1];
                            $c++)
                        {
                            $wcam_view_rating .= "<img src='{$wcam_star}/star.png' alt='' />";
                        }
                        if ($ratearray[2])
                        {
                            $wcam_view_rating .= "<img src='{$wcam_star}/" . $ratearray[2] . ".png'  alt='' />";
                        }
                        if ($ratearray[2] == "")
                        {
                            $ratearray[2] = 0;
                        }
                        $wcam_view_rating .= "&nbsp;<br />" . $ratearray[1] . "." . $ratearray[2] . " - " . $ratearray[0] . "&nbsp;";
                        $wcam_view_rating .= ($ratearray[0] == 1 ? WCAM_15 : WCAM_14);
                    }
                    else
                    {
                        $wcam_view_rating .= WCAM_16;
                    }

                    if (!$rater->checkrated("webcams", $wcam_id) && USER)
                    {
                        $wcam_view_rating .= $rater->rateselect("<br /><b>" . WCAM_17, "webcams", $wcam_id) . "</b>";
                    }
                    else if (!USER)
                    {
                        $wcam_view_rating .= "&nbsp;";
                    }
                    else
                    {
                        $wcam_view_rating .= "<br />" . WCAM_18;
                    }
                    $wcam_view_rating .= "&nbsp;";
                    // rating
                    $wcam_text .= "<br />" . WCAM_19 . $wcam_view_rating;
                }

                $wcam_text .= "<br />" . WCAM_39 . " $webcam_views " . WCAM_40 . "
			</td>
		</tr>
	</table>";
                $comment_to = $webcam_id;
                $comment_sub = "Re: " . $tp->toFORM($webcam_name, false);
            }
            break;
        case "list":
        default:
            $pref['webcam_perpage'] = ($pref['webcam_perpage'] < 1?5:$pref['webcam_perpage']);
            $pref['webcam_cols'] = ($pref['webcam_cols'] < 1?5:$pref['webcam_cols']);
            $wcam_colspan = $pref['webcam_cols'];
            $wcam_pos = 1;
            $wcam_text .= "
<table class='fborder' style='width:" . USER_WIDTH . "'>
	<tr>
		<td class='forumheader' colspan='$wcam_colspan' style='text-align:center;'>" . WCAM_02 . "</td>
	</tr>
	<tr>
		<td class='forumheader2' colspan='$wcam_colspan' style='text-align:center;'>&nbsp;</td>
	</tr>
	<tr>";
            if ($sql->db_Select("webcams", "*", "where webcam_approved> 0 order by webcam_name limit $wcam_from," . $pref['webcam_perpage'], "nowhere", false))
            {
                while ($wcam_row = $sql->db_Fetch())
                {
                    extract($wcam_row);
                    $wcam_tmp = explode(".", $webcam_poster);
                    $wcam_poster = $wcam_tmp[1];
                    $wcam_url = $tp->toFORM($webcam_url, false);
                    $wcam_file = fopen($wcam_url, "r");
                    if (!empty($wcam_url) && $wcam_file)
                    {
                        $wcam_img = "<img src='" . $wcam_url . "' style='border:0;height:98px;width:98px' title='" . $tp->toFORM($webcam_name) . "' alt='" . $tp->toFORM($webcam_name) . "' />";
                    }
                    else
                    {
                        $wcam_img = "<img src='images/offline.png' style='border:0;height:98px;width:98px' title='" . WCAM_41 . "' alt='" . WCAM_41 . "' />";
                    }
                    fclose($wcam_file);
                    $wcam_width = intval(100 / $wcam_colspan);
                    $wcam_text .= "
		<td class='forumheader3' style='text-align:center;width:{$wcam_width}%;'>
				" . $tp->toHTML($webcam_name, false) . "<br />";
                    if (!empty($webcam_providerurl))
                    {
                        $wcam_text .= "<a href='" . $tp->toFORM($webcam_providerurl, false, "no_make_clickable no_replace") . "' $wcam_rel > <strong>" . $tp->toHTML($webcam_provider, false, "no_make_clickable no_replace") . "</strong></a><br />";
                    }
                    else
                    {
                        $wcam_text .= " <strong>" . $tp->toHTML($webcam_provider, false, "no_make_clickable no_replace") . "</strong><br />";
                    }

                    $wcam_text .= $tp->toHTML($webcam_location, false, "no_make_clickable no_replace") . "<br />
				<a href='" . e_SELF . "?0.view.$webcam_id' >" . $wcam_img . "</a><br />
				" . $tp->toHTML($wcam_poster, false, "no_make_clickable no_replace") . "<br />" . ($pref['webcam_report'] > 0?"<a href='" . e_SELF . "?0.abuse.$webcam_id'>" . WCAM_44 . "</a><br />":"") . "
				";
                    if ($pref['webcam_rate'] > 0)
                    {
                        $wcam_view_rating = "";
                        // rating
                        if ($ratearray = $rater->getrating("webcams", $webcam_id))
                        {
                            if (defined("IMODE"))
                            {
                                $wcam_star = e_IMAGE . "rate/" . IMODE;
                            }
                            else
                            {
                                $image = $wcam_star = e_IMAGE . "rate/lite/";
                            }
                            for($c = 1;
                                $c <= $ratearray[1];
                                $c++)
                            {
                                $wcam_view_rating .= "<img src='{$wcam_star}/star.png' alt='' />";
                            }
                            if ($ratearray[2])
                            {
                                $wcam_view_rating .= "<img src='{$wcam_star}/" . $ratearray[2] . ".png'  alt='' />";
                            }
                            if ($ratearray[2] == "")
                            {
                                $ratearray[2] = 0;
                            }
                            // $wcam_view_rating .= "&nbsp;" . $ratearray[1] . "." . $ratearray[2] . " - " . $ratearray[0] . "&nbsp;";
                            // $wcam_view_rating .= ($ratearray[0] == 1 ? WCAM_15 : WCAM_14);
                            $wcam_text .= $wcam_view_rating;
                            // rating
                        }
                    }

                    $wcam_text .= "
		</td>";
                    $wcam_pos++;
                    if ($wcam_pos > $wcam_colspan)
                    {
                        $wcam_pos = 1;
                        $wcam_text .= "
	</tr>
	<tr>";
                    }
                } // while
                while ($wcam_pos <= $wcam_colspan && $wcam_pos != 1)
                {
                    // finish off blank cells
                    $wcam_text .= "
		<td class='forumheader3'></td>";
                    $wcam_pos++;
                } // while
                $wcam_text .= "
                <td></td>
	</tr>";
                $action = "list.0";
                $wcam_count = $sql->db_Count("webcams", "(*)", "where webcam_approved>0", false);
                $parms = $wcam_count . "," . $pref['webcam_perpage'] . "," . $wcam_from . "," . e_SELF . '?' . "[FROM]." . $action;
                $wcam_nextprev = $tp->parseTemplate("{NEXTPREV={$parms}}") . "";
            }
            else
            {
            $wcam_text .= "
    <tr>
		<td class='forumheader2' colspan='$wcam_colspan'>".WCAM_64."
		</td>
	</tr>";
            }
			$wcam_text .= "
	<tr>
		<td class='fcaption' colspan='$wcam_colspan'>";
            if (!empty($wcam_nextprev))
            {
                $wcam_text .= $wcam_nextprev . "";
            }
            if (check_class($pref['webcam_adminclass']) || check_class($pref['webcam_ownclass']))
            {
                $wcam_text .= "&nbsp;&nbsp;<a href='" . e_PLUGIN . "webcam/manage_cam.php'>" . WCAM_53 . "</a>";
            } elseif (check_class($pref['webcam_submitclass']))
            {
                $wcam_text .= "&nbsp;&nbsp;<a href='" . e_SELF . "?0.subnew.0'>" . WCAM_23 . "</a>";
            }
            $wcam_text .= "&nbsp;
		</td>
	</tr>
</table>";
            $webcam_showname = WCAM_42;
    } // switch
}
if (!empty($pref['webcam_menutitle']))
{
    $webcam_showname = $pref['webcam_menutitle'] . "-" . $webcam_showname;
    define("e_PAGETITLE", $webcam_showname);
}
if (!empty($pref['webcam_desc']))
{
    define("META_DESCRIPTION", $pref['webcam_desc']);
}
if (!empty($pref['webcam_key']))
{
    define("META_KEYWORDS", $pref['webcam_key']);
}
require_once(HEADERF);
$ns->tablerender(WCAM_01, $wcam_text);
if ($comment_to > 0 && $pref['webcam_comment'] > 0)
{
    $wcam_com->compose_comment("webcams", "comment", $comment_to, $width, $comment_sub, false);
}
require_once(FOOTERF);

?>
