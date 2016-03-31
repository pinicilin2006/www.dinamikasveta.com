<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_images/thumb.php,v $
|     $Revision: 1.3 $
|     $Date: 2005/08/23 09:36:30 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/
/*
 Usage: simply replace your <img src='filename.jpg'
 with
 <img src='".e_IMAGE."thumb.php?filename.jpg+size"' />
 or
 <img src='".e_IMAGE."thumb.php?<full path to file>/filename.jpg+size"' />
 eg <img src='".e_IMAGE."thumb.php?home/images/myfilename.jpg+100)"' />

*/

require_once("../class2.php");
require_once(e_HANDLER."resize_handler.php");

// var 3.
// 1= newspost images/preview
// 2= 

	if (e_QUERY){
		$tmp = explode("+",rawurldecode(e_QUERY));
		if(strpos($tmp[0], "/") === 0 || strpos($tmp[0], ":") >= 1){
			$source = $tmp[0];
		}else{
			$source = "../".str_replace("../","",$tmp[0]);
		}




		$newsize = $tmp[1];
		if(!file_exists(e_IMAGE."newspost_images/preview/preview_".basename($source))){

		  	if(!resize_image($source, e_IMAGE."newspost_images/preview/preview_".basename($source), $newsize)){
		  		echo "Couldn't find: ".$source;
		  	}
		}


		header("Content-type: image/jpg");
		$imagedata = file_get_contents(e_IMAGE."newspost_images/preview/preview_".basename($source));
		echo $imagedata;
		exit;


	}
?>