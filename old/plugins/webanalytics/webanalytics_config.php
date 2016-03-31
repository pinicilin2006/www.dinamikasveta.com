<?php
/*
 * e107 website system
 *
 * Copyright (C) 2001-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Plugin Administration - WebAnalytics
 *
 * $Source: 
 * $Revision: 1.2 $
 * $Date: 2009/11/08 11:00:41 $
 * $Author: arunshekher $
 *
*/
$eplug_admin = true;
require_once("../../class2.php");
if (!getperms("P")) {
header("location:".e_HTTP."index.php");
exit;
}
require_once(e_ADMIN."auth.php");
e107_require_once(e_HANDLER.'arraystorage_class.php');
$eArrayStorage = new ArrayData();
require_once(e_HANDLER."form_handler.php");
$rs = new form;
unset($text);

include_lan(e_PLUGIN."webanalytics/languages/".e_LANGUAGE."/lan_wa_admin.php");

if(isset($_POST['update_wa_prefs'])){
	$message = update_WAPrefs();
}

function update_WAPrefs(){
	global $sql, $eArrayStorage, $tp; 
		
		$wa_pref['wa_active'] = $tp->toDB($_POST['wa_active']);
		$wa_pref['wa_code'] = $tp->post_toForm($_POST['wa_code']);
			
	$tmp = $eArrayStorage->WriteArray($wa_pref);
	$sql -> db_Update("core", "e107_value='$tmp' WHERE e107_name='webanalytics_prefs' ");
	
	if($wa_pref['wa_active'] == 1){$div_style="wa_message_on";}else if($wa_pref['wa_active'] == 0){$div_style="wa_message_off";}
		
		$message = "<div id='".$div_style."'><h2><img src='images/info.png' alt='' style='margin:0 5px -2px 0'/>".WEBA_PLUGIN_ALAN_5."</h2>";
	if($wa_pref['wa_active'] == 1){
		$message .= "<p><img src='images/tick.png' alt='' style='margin:0 10px -3px 20px'/>".WEBA_PLUGIN_ALAN_1." ".WEBA_PLUGIN_ALAN_6."</p></div>";
	}else if($wa_pref['wa_active'] == 0){
		$message .= "<p><img src='images/cancel.png' alt='' style='margin:0 10px -3px 20px'/>".WEBA_PLUGIN_ALAN_1." ".WEBA_PLUGIN_ALAN_7."</p></div>";
		}
	if(empty($wa_pref['wa_code'])){
		$message .= "<p><img src='images/error.png' alt='' style='margin:0 10px -3px 20px'/>".WEBA_PLUGIN_ALAN_17."</p>";
	}else if(!empty($wa_pref['wa_code'])){
		$message .= "<p><img src='images/tick.png' alt='' style='margin:0 10px -3px 20px'/>".WEBA_PLUGIN_ALAN_18."</p>";
		}
	return $message;

}

function getDefault_WAPrefs(){
            $wa_pref['wa_active'] = '1';
            $wa_pref['wa_code'] = '';
                        
		return $wa_pref;
}

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

if(isset($message)){
	$caption = WEBA_PLUGIN_ALAN_1;
	$ns -> tablerender($caption, $message);
}

$wa_pref = get_WAPrefs();

if(!is_object($sql)){ $sql = new db; }


$text = "<div style='text-align:center'>
	".$rs -> form_open("post", e_SELF, "webanalyticsform", "", "enctype='multipart/form-data'")."
	<table style='".ADMIN_WIDTH."' class='fborder'>

      	<tr>
	<td class='forumheader3' style='width:40%'><h4>".WEBA_PLUGIN_ALAN_8."</h4></td>
	<td class='forumheader3' style='width:60%'>
	".$rs -> form_radio("wa_active", "1", ($wa_pref['wa_active'] ? "1" : "0"), "", "")." ".WEBA_PLUGIN_ALAN_9." 
	".$rs -> form_radio("wa_active", "0", ($wa_pref['wa_active'] ? "0" : "1"), "", "")." ".WEBA_PLUGIN_ALAN_10." 
	</td>
	</tr>
      
            <tr>
	<td class='forumheader3' style='width:40%'><h4>".WEBA_PLUGIN_ALAN_11."</h4><p>".WEBA_PLUGIN_ALAN_19."<br />".WEBA_PLUGIN_ALAN_12."</p><br /><p>".WEBA_PLUGIN_ALAN_13."</p>	
	</td>
	<td class='forumheader3' style='width:60%'>
	<textarea class='tbox' id='wa_code' name='wa_code' cols='59' rows='6'>".$wa_pref['wa_code']."</textarea>
	</td>
	</tr>   

		<tr>
	<td  class='forumheader' colspan='2' style='text-align:center'>
	".$rs -> form_button("submit", "update_wa_prefs", WEBA_PLUGIN_ALAN_15)."	
	</td>
	</tr>
    </table>
	".$rs -> form_close()."
	<img src='".e_PLUGIN_ABS."webanalytics/images/gplv3-88x31.png' alt='GPLv3' style='margin:50px'/></div>";

$ns -> tablerender(WEBA_PLUGIN_ALAN_16, $text);

require_once(e_ADMIN."footer.php");

?>