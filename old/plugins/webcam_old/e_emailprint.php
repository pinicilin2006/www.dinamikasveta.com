<?php

if (!defined('e107_INIT'))
{
    exit;
}

function email_item($id)
{
    global $sql, $tp;
    include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");

    $wcam_arg = "select * from #webcams where webcam_id='$id'";
    $sql->db_Select_gen($wcam_arg, false);
    $row = $sql->db_Fetch();
    $message .= WCAM_49 . " <a href='" . SITEURL . e_PLUGIN . "webcam/webcam.php?0.view." . $id . "'>" . $row['webcam_name'] . "</a><br /><br />";
    $wcam_author = explode(".", $row['webcam_poster']);
    $message .= WCAM_50 . " " . $row['webcam_provider'] . "<br /><br />" . WCAM_51 . " " . $wcam_author[1] . "<br />";
    return $message;
}

?>