<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: defines.php                                      |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

define("e_GALLERY", e_PLUGIN."mediagallery/");
define("e_FILEDIR", e_FILE."mediagallery/");
define("e_IMAGES",  e_FILEDIR."images/");
define("e_MEDIA",   e_FILEDIR."media/");
define("e_UPLOAD",  e_FILEDIR."upload/");
define("e_TEMP",    e_FILEDIR."temporary_files/");
define("e_CTHUMBS", e_FILEDIR."category_thumbs/");
define("e_MTHUMBS", e_FILEDIR."media_thumbs/");
define("e_WMARKS",  e_FILEDIR."watermarks/");
define("e_FONTS",   e_FILEDIR."fonts/");
$MgDirsList  = array(e_UPLOAD, e_TEMP, e_IMAGES, e_MEDIA, e_CTHUMBS, e_MTHUMBS, e_WMARKS, e_FONTS);
$MgImageList = array("jpg", "jpeg", "png", "gif", "bmp");
$MgVideoList = array("avi", "wmv", "mov", "swf", "mpg", "mpeg", "divx", "asx", "rv");
$MgAudioList = array("mp3", "wav", "wma", "m4a", "ra");
$MgFilesList = array_merge($MgImageList, $MgVideoList, $MgAudioList);

?>