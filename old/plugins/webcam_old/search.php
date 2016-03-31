<?php
if (!defined('e107_INIT'))
{
    exit;
}
if (check_class($pref['webcam_readclass']))
{
    include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");

    $return_fields = 't.webcam_name,t.webcam_id,t.webcam_provider,t.webcam_description,t.webcam_poster,t.webcam_updated,t.webcam_location';
    $search_fields = array("t.webcam_name", "t.webcam_description","t.webcam_provider", "t.webcam_poster", "t.webcam_location");
    $weights = array('2.0', '1.5', '1.0', '0.5','1.5');
    $no_results = LAN_198;
    $where = "";
    $order = array('t.webcam_name' => DESC);
    $table = "webcams as t ";

    $ps = $sch->parsesearch($table, $return_fields, $search_fields, $weights, 'search_webcam', $no_results, $where, $order);
    $text .= $ps['text'];
    $results = $ps['results'];
}
function search_webcam($row)
{
    global $con, $tp;
    $datestamp = $con->convert_date($row['webcam_updated'], "long");
    $title = $tp->toHTML($row['webcam_name'], false);
    $link_id = $row['webcam_id'];
    $res['link'] = e_PLUGIN . "webcam/webcam.php?0.view." . $link_id . "";
    $res['pre_title'] = $title ?WCAM_37 . " " : "";
    $res['title'] = $title ? $title : LAN_SEARCH_9;
    $res['summary'] = WCAM_34 . ": " . substr($row['webcam_description'], 0, 30) . ". &nbsp;" . WCAM_35 . ": " . substr($row['webcam_provider'], 0, 30);
    $tmp = explode(".", $row['webcam_poster']);
    $res['detail'] = WCAM_36 . " " . $datestamp . " " . WCAM_03 . $tmp[1];
    return $res;
}

?>