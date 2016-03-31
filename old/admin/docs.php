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
|     $Source: /cvsroot/e107/e107_0.7/e107_admin/docs.php,v $
|     $Revision: 1.7 $
|     $Date: 2005/11/12 04:18:01 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/
require_once("../class2.php");
if (!ADMIN) {
	header("location:".e_BASE."index.php");
	exit;
}
$e_sub_cat = 'docs';
require_once("auth.php");
	
$i = 1;
$lang = e_LANGUAGE;
if (!$handle = opendir(e_DOCS.e_LANGUAGE."/")) {
	$lang = "English";
	$handle = opendir(e_DOCS."English/");
}
	
while ($file = readdir($handle)) {
	if ($file != "." && $file != ".." && $file != "CVS") {
		$helplist[$i] = $file;
		$i++;
	}
}
closedir($handle);
	
	
if (e_QUERY) {
	$filename = e_DOCS.$lang."/".$helplist[e_QUERY];
	$fd = fopen ($filename, "r");
	$text .= fread ($fd, filesize ($filename));
	fclose ($fd);
	 
	$text = $tp->toHTML($text, TRUE);
	$text = preg_replace("/Q\>(.*?)A>/si", "<img src='".e_IMAGE."generic/".IMODE."/question.png' style='vertical-align: middle' /><b>\\1</b>A>", $text);
	$text = str_replace("A>", "<img src='".e_IMAGE."generic/".IMODE."/answer.png' style='vertical-align: middle' />", $text);
	 
	$ns->tablerender(str_replace("_", " ", $helplist[e_QUERY]), $text."<br />");
	unset($text);
}
	
require_once("footer.php");
?>