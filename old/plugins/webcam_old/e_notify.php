<?php
if (!defined('e107_INIT'))
{
    exit;
}
include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
$config_category = WCAM_A48;
$config_events = array('camabuse' => WCAM_A89,'camnew' => WCAM_A90,'camupdate'=>WCAM_A91);

if (!function_exists('notify_camabuse'))
{
    function notify_camabuse($data)
    {
        global $nt;
        $message = "<strong>" . WCAM_A49 . ': </strong>' . $data['user'] . '<br />';
        $message .= "<strong>" . WCAM_A50 . ':</strong> ' . $data['itemtitle'] . "<br />"  ;
        $message .= " " . WCAM_A51 . " " . $data['catid'] . "<br /><br />";
        $message .= " " . WCAM_A53 . " " . $data['abuse'] . "<br />";
		$nt->send('camabuse', WCAM_A52, $message);
    }
}
if (!function_exists('notify_camnew'))
{
    function notify_camnew($data)
    {
        global $nt;
        $message = "<strong>" . WCAM_A54 . ': </strong>' . $data['user'] . '<br />';
        $message .= "<strong>" . WCAM_A55 . ':</strong> ' . $data['itemtitle'] . "<br /><br />" . WCAM_A86 ;
        $message .= " " . WCAM_A56 . " " . $data['catid'] . "<br /><br />";
        $nt->send('camnew', WCAM_A57, $message);
    }
}
if (!function_exists('notify_camupdate'))
{
    function notify_camupdate($data)
    {
        global $nt;
        $message = "<strong>" . WCAM_A87 . ': </strong>' . $data['user'] . '<br />';
        $message .= "<strong>" . WCAM_A55 . ':</strong> ' . $data['itemtitle'] . "<br /><br />" . WCAM_A86 ;
        $message .= " " . WCAM_A56 . " " . $data['catid'] . "<br /><br />";
        $nt->send('camupdate', WCAM_A88, $message);

    }
}
?>