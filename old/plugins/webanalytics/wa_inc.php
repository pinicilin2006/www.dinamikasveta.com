<?php
/*
 * e107 website system
 *
 * Copyright (C) 2001-2008 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Plugin Include File - Web Analytics
 *
 * $Source: 
 * $Revision: 1.2 $
 * $Date: 2009/11/09 09:52:05 $
 * $Author: arunshekher $
 *
*/


//Default WA Preferences
if (!function_exists('getDefault_WAPrefs')) {	
  function getDefault_WAPrefs(){
		  $wa_pref['wa_active'] = '1';
		  $wa_pref['wa_code'] = '';
					  
	  return $wa_pref;
  }
}

//Get WA Preferences
if (!function_exists('get_WAPrefs')) {
  function get_WAPrefs(){
	  global $sql, $eArrayStorage;
  
	  if(!is_object($sql)){ $sql = new db; }
	  $num_rows = $sql -> db_Select("core", "*", "e107_name='webanalytics_prefs' ");
	  if($num_rows == 0){
		  $tmp = getDefault_WAPrefs();
		  $tmp2 = $eArrayStorage->WriteArray($tmp);
		  $sql -> db_Insert("core", "'webanalytics_prefs', '".$tmp2."' ");
		  $sql -> db_Select("core", "*", "e107_name='webanalytics_prefs' ");
	  }
	  $row = $sql -> db_Fetch();
	  $wa_pref = $eArrayStorage->ReadArray($row['e107_value']);
	  return $wa_pref;
  }
}
?>