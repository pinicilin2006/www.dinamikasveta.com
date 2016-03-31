<?php
if (!defined('e107_INIT')) { exit; }
/*
$e_plug_table = "links_page"; //This is set to the table name you have decided to use.
$reply_location= e_PLUGIN."links_page/links.php?comment.$nid"; //This is set to the location you'd like the user to return to after replying to a comment.
$db_table = "links_page"; //This is the name of your plugins database table.
$link_name = "link_name"; //This is the name of the field in your plugin's db table that corresponds to it's name or title.
$db_id = "link_id"; // This is the name of the field in your plugin's db table that correspond to it's unique id number.
$plugin_name = "Links"; // A name for your plugin. It will be used in links to comments, in list_new/new.php.
*/

//This is set to the table name you have decided to use.
$e_comment['eplug_comment_ids'] = "webcams";

//This is set to the location you'd like the user to return to after replying to a comment.
$e_comment['reply_location'] = e_PLUGIN."webcam/webcam.php?0.view.{NID}";

//A name for your plugin. It will be used in links to comments, in list_new/new.php.
$e_comment['plugin_name'] = "Web Cam";

//The path of the plugin folder
$e_comment['plugin_path'] = "webcam";

//This is the name of the field in your plugin's db table that corresponds to it's name or title.
$e_comment['db_title'] = "webcam_name";

//This is the name of the field in your plugin's db table that correspond to it's unique id number.
$e_comment['db_id'] = "webcam_id";

//qry must be set with a select_gen query.
//the main reason would be to check if a category from another table has a class restriction
//the id of the item should be provided as {NID}
//returned fields should at least contain the 'link_id' and 'db_id' fields set above
$e_comment['qry'] = "
SELECT *
FROM #webcams
WHERE webcam_id='{NID}' AND webcam_approved > 0 ";

?>