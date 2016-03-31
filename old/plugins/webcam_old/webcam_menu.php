<?php
// http://www.bbc.co.uk/england/webcams/live/liverpool/tunnel/mtunnel_cam4.jpg
// $text="<img src=\"http://www.98online.com/webcam/studio1_0000000001.jpg\" width=\"95%\"  name=\"campic\" />";
if (!defined('e107_INIT'))
{
    exit;
}
global $PLUGINS_DIRECTORY, $tp, $sql, $pref, $e107cache;
$cache_tag = "nq_webcams";
if (check_class($pref['webcam_readclass']))
{
    // only display the contents of the menu if the user in the read class
    if ($pref['webcam_rand'] == 0)
    {

        if ($cacheData = $e107cache->retrieve($cache_tag,10))
        {
            // if there is cache data and not random menu (cause you can't cache that)

            echo $cacheData;
            return;
        }
    }
    include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
    if ($pref['webcam_rand'] > 0)
    {
        $wcam_rand = "order by rand()";
    }
    else
    {
        $wcam_rand = "order by webcam_updated";
    }
    if ($sql->db_Select("webcams", "*", "where webcam_approved > 0 and webcam_menu > 0 $wcam_rand limit 0," . $pref['webcam_inmenu'], "nowhere", false))
    {
        $wcam_text .= "<div style='text-align:center;'>";
        while ($wcam_row = $sql->db_Fetch())
        {
            extract($wcam_row);
            $wcam_tmp = explode(".", $webcam_poster);
            $wcam_poster = $wcam_tmp[1];
            $wcam_url = $tp->toFORM($webcam_url, false);
            $wcam_file = fopen($wcam_url, "r");
            if (!empty($wcam_url) && $wcam_file)
            {
                $wcam_img = "<img src='" . $wcam_url . "' style='border:0;height:" . $pref['webcam_mh'] . "px;width:" . $pref['webcam_mw'] . "px' title='" . $webcam_name . "' alt='" . $webcam_name . "' />";
            }
            else
            {
                $wcam_img = "<img src='" . SITEURL . $PLUGINS_DIRECTORY . "webcam/images/offline.png' style='border:0;height:" . $pref['webcam_mh'] . "px;width:" . $pref['webcam_mw'] . "px' title='" . WCAM_41 . "' alt='" . WCAM_41 . "' />";
            }
            fclose($wcam_file);
            $wcam_text .= "
				" . $tp->toHTML($webcam_name, false) . "<br />
				" . $tp->toHTML($webcam_provider, false) . "<br />
				" . $tp->toHTML($webcam_location, false) . "<br />
				<a href='" . SITEURL . $PLUGINS_DIRECTORY . "webcam/webcam.php?0.view.$webcam_id' >" . $wcam_img . "</a><br /><br />";
            $wcam_text .= "<hr />";
        } // while
        $wcam_text .= "</div>";
    }
    else
    {
        $wcam_text .= "<div style='text-align:center;'>" . WCAM_38 . "</div>";
    }
    if ($pref['webcam_rand'] == 0)
    {

        ob_start(); // Set up a new output buffer
        $ns->tablerender(WCAM_01, $wcam_text); // Render the menu
        $cache_data = ob_get_flush(); // Get the menu content, and display it
        $e107cache->set($cache_tag, $cache_data); // Save to cache
    }
    else
    {
        $ns->tablerender(WCAM_01, $wcam_text); // Render the menu
    }
}

?>