<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: showthumb.php                                    |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

error_reporting(E_ERROR | E_PARSE);
require(dirname(__FILE__)."/../../e107_config.php");
isset($mySQLserver) or exit;
define("e107_INIT", TRUE);
@mysql_connect($mySQLserver, $mySQLuser, $mySQLpassword);
@mysql_select_db($mySQLdefaultdb);
$Result = mysql_query("SELECT e107_value FROM ".$mySQLprefix."core WHERE e107_name = 'SitePrefs'");
$ArrayData = mysql_fetch_row($Result);
$ArrayData = '$pref = '.trim($ArrayData[0]).';';
@eval($ArrayData);
unset($ArrayData);
is_array($pref) or exit;
$Image = strip_tags(rawurldecode($_SERVER['QUERY_STRING']));
$Res = explode("*", $pref['mg_thumb_size']);
define("e_PLUGIN", "../../".$PLUGINS_DIRECTORY);
define("e_FILE", "../../".$FILES_DIRECTORY);
define("e_LANGUAGE", ($pref['sitelanguage'] ? $pref['sitelanguage'] : "English"));
require(dirname(__FILE__)."/defines.php");
require(e_GALLERY."classes/main.class.php");
$main = new Main;
require(e_GALLERY."classes/resize.class.php");
$res = new Resizer;
if (is_numeric($Image)){
	$Result = mysql_query("SELECT img_thumb, img_type, IF((img_type = 'image' OR img_type = 'wallpaper'), '".e_IMAGES."', '".e_MTHUMBS."') AS img_path FROM ".$mySQLprefix."mg_images WHERE img_id = '".intval($Image)."'");
	if (mysql_num_rows($Result)){
		$row = mysql_fetch_assoc($Result);
		$Thumb = $main->GetFilePath($row['img_thumb'], $row['img_path']);
		$res->ResizeImage($Thumb, "stdout", $Res[0], $Res[1]);
	}else{
		$res->ResizeImage(e_GALLERY."images/no_image.php", "stdout", 100, 100);
	}
}else{
	$Image = str_replace(array("\\\\", "\\"), "/", realpath($Image));
	$res->ResizeImage($Image, "stdout", $Res[0], $Res[1]);
}
mysql_close();

?>