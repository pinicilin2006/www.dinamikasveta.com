<?php
/*
 * e107 website system
 *
 * Copyright (C) 2001-2008 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Plugin eMeta File - WebAnalytics
 *
 * $Source: 
 * $Revision: 1.2 $
 * $Date: 2009/11/09 09:48:47 $
 * $Author: arunshekher $
 *
*/
if (!defined('e107_INIT'))
{
    exit;
}

//add plugin css
$eplug_css = e_PLUGIN_ABS."webanalytics/wa.css";

//Thought to use this to output the plugin css for the moment as other methods seems failing
//This function is not used as option to output the actual analytics code as -
//it is said to be DEPRECATED! and gone in 0.8 **DOES NOT SEEM TO WORK EITHER **
/*
if(!function_exists('core_head')){	
	function core_head(){
		echo "<!-- WebAnalytics Plugin CSS -->\n";
		echo "<link rel='stylesheet' href='".e_PLUGIN_ABS."webanalytics/wa.css' type='text/css' />\n";
	}	
} 
*/

//If theme_foot function does not already exsists, define that to have the code
if (!function_exists('theme_foot')) {
	
	function theme_foot(){
		require_once("wa_inc.php");
		global $wa_pref, $tp;
		$wa_pref = get_WAPrefs();	
		$code = $tp->toHTML($wa_pref['wa_code'], "", "emotes_off, retain_nl, no_make_clickable");		
			if(isset($wa_pref['wa_active']) && $wa_pref['wa_active'] == 1){
				echo "\n<!-- WebAnalytics:START -->\n";
				echo $code;
				echo "\n<!-- WebAnalytics:END -->\n";
			}else{
				exit;
			}	
	}
}
//Else look if theme_head function does not already exsists, define that to have the code
else if(!function_exists('theme_head')){
	
	function theme_head(){
		require_once("wa_inc.php");
		global $wa_pref, $tp;
		$wa_pref = get_WAPrefs();	
		$code = $tp->toHTML($wa_pref['wa_code'], "", "emotes_off, retain_nl, no_make_clickable");
			if(isset($wa_pref['wa_active']) && $wa_pref['wa_active'] == 1){
				echo "\n<!-- WebAnalytics:START -->\n";
				echo $code;
				echo "\n<!-- WebAnalytics:END -->\n";
			}else{
				exit;
			}
	}
	
}
//Else exit
else{exit;}
?>