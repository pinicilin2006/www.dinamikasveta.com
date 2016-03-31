<?php
if (!defined('e107_INIT'))
{
    exit;
}
$e_event->register("postuserset", "webcam_postuserset");

function webcam_postuserset($data)
{
    if (!empty($data['username']))
    {
    // make sure we have a user name
        global $tp, $sql;
        if ($sql->db_Select("user", "user_id", "where user_name = '" . $tp->toDB($data['username']) . "'", "nowhere", false))
        {
        // if we find the user in the user table then get their details
            $row = $sql->db_Fetch();
            if ($row['user_id'] > 0)
            {
            // if the user id is greater than 0 then update the posters details
                $newname = $row['user_id'] . "." . $data['username'];
                $sql->db_Update("webcams", "webcam_poster ='" . $tp->toDB($newname) . "' where SUBSTRING_INDEX(webcam_poster,'.',1)='" . $row['user_id'] . "'", false);
            }
        }
    }
}

?>