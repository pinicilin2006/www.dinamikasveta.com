<?php
/*
+---------------------------------------------------------------+
|	e107 website system
| http://e107.org
|	/dtree_menu/dtree_config.php
|
| Revision: 1.0 
| Date: 2005/01/24
| Author: Izydor 2005
|	http://cennik.net
|	Izydor@cennik.net
|
| Based on javascript by Geir Landrö (evdwal@xs4all.nl)
| dTree 2.05 | http://www.destroydrop.com/javascripts/tree/ 
|
|	Released under the terms and conditions of the	
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/
echo "<!-- point 1 -->";
require_once("../../class2.php");
if(!getperms("1")){ header("location:".e_BASE."index.php"); exit ;}
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."userclass_class.php");
echo "<!-- point 2 -->";
$lan_file = e_PLUGIN."dtree_menu/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."dtree_menu/languages/English.php");

require_once(e_HANDLER."textparse/basic.php");
$etp = new e107_basicparse;

echo "<!-- point 3 -->";
$dtree = new dtree;
require_once(e_HANDLER."form_handler.php");
$rs = new form;
$aj = new textparse;

echo "<!-- e_Query :: $e_QUERY -->";
if(e_QUERY){
        $tmp = explode(".", e_QUERY);
        $action = $tmp[0];
        $sub_action = $tmp[1];
        $id = $tmp[2];
        $from = ($tmp[3] ? $tmp[3] : 0);
        unset($tmp);
}

$from = ($from ? $from : 0);
$amount = 50;

if(IsSet($_POST['update_options'])){
	$menu_pref["dt_folderlinks"] = $_POST["dt_folderlinks"];
	$menu_pref["dt_useSelection"] = $_POST["dt_useSelection"];
	$menu_pref["dt_useCookies"] = $_POST["dt_useCookies"];
	$menu_pref["dt_useLines"] = $_POST["dt_useLines"];
	$menu_pref["dt_useIcons"] = $_POST["dt_useIcons"];
	$menu_pref["dt_useStatusText"] = $_POST["dt_useStatusText"];
	$menu_pref["dt_closeSameLevel"] = $_POST["dt_closeSameLevel"];
	$menu_pref["dt_caption"] = $_POST["dt_caption"];
	$menu_pref["dt_captionstyle"] = $_POST["dt_captionstyle"];
  $tmp = addslashes(serialize($menu_pref));
	$sql -> db_Update("core", "e107_value='$tmp' WHERE e107_name='menu_pref' ");	
  $dtree -> show_message(DT_LAN_18);
//  $dtree -> show_message(USRLAN_1);
}

if(!e_QUERY || $action == "main"){
        $dtree -> show_prefs();
}

if(IsSet($_POST['add_tree'])){
  if (isset($_POST['upd_id'])) {
  	$dtree -> submit_tree($sub_action, $_POST['upd_id']);
  }
  else {
    $dtree -> submit_tree($sub_action, $id);
  }  
  unset($upd_id);
}

if($action == "create"){
        $dtree -> create_tree($sub_action, $id);
}

if($action == "delete"){
  if ($sub_action == 1) {
  	$dtree -> show_message(DT_LAN_42);
  } 
  else {
    if($sql -> db_Delete("dtree", "dt_id=$sub_action"))
	  {
		  $dtree -> show_message(DT_LAN_41);
	  }
  }
}

if($action == "edidel"){
        $dtree -> edidel_tree();
}

if($action == "prune"){
    if($sql -> db_Delete("dtree"))
	  {
	    $sql -> db_Insert("dtree", "0,-1,0,'Default Tree','','','','','',0,0");
	    $sql -> db_Insert("dtree", "0,1,1,'Node 1','forum.php','Forum','','','',0,0");	
	    $sql -> db_Insert("dtree", "0,1,1,'Node 2','news.php','News','','','',0,0");		
	    $sql -> db_Insert("dtree", "0,2,2,'Node 1.1','user.php','Members','','','',0,0");		
	    $sql -> db_Insert("dtree", "0,4,3,'Node 1.1.1','stats.php','Stats','','','',0,0");			
	    
      $tmp_menu_prefs =
        array(
	       "dt_folderlinks" => true,
	       "dt_useSelection" => true,
	       "dt_useCookies" => true,
	       "dt_useLines" => true,
	       "dt_useIcons" => true,
	       "dt_useStatusText" => false,
	       "dt_closeSameLevel" => false,
	       "dt_caption" => "dTree Menu",
	       "dt_captionstyle" => "caption",
	     );

	   if(is_array($tmp_menu_prefs)){
		   while(list($key, $e_pref) = each($tmp_menu_prefs)){
			   if(!in_array($pref, $e_pref)){
				 $menu_pref[$key] = $e_pref;
			   }
		   }
	     $tmp = addslashes(serialize($menu_pref));
	     $sql -> db_Update("core", "e107_value='$tmp' WHERE e107_name='menu_pref' ");
    }
	    
		  $dtree -> show_message(DT_LAN_43);
	  }
}

if($action == "copy"){
        $dtree -> copy_tree();
}


require_once(e_ADMIN."footer.php");
function headerjs(){
global $etp;
$headerjs  = "<script type=\"text/javascript\">
function addtext(sc){
        document.getElementById('treeform').dt_icon.value = sc;
}
function addtext2(sc){
        document.getElementById('treeform').dt_iconOpen.value = sc;
}
function addtext3(sc){
        document.getElementById('treeform').link_category_icon.value = sc;
}
</script>\n";
/*
$headerjs .= "<script type=\"text/javascript\">
function confirm_(mode, link_id){
        if(mode == 'cat'){
                return confirm(\"".$etp->unentity(LCLAN_56)." [ID: \" + dt_id + \"]\");
        }else if(mode == 'sn'){
                return confirm(\"".$etp->unentity(LCLAN_57)." [ID: \" + dt_id + \"]\");
        }else{
                return confirm(\"".$etp->unentity(LCLAN_58)." [ID: \" + dt_id + \"]\");
        }
}
</script>";
*/
return $headerjs;
}

exit;



class dtree{
  
        function show_prefs(){
                global $ns, $menu_pref;
                $text = "<div style='text-align:center'>
                <form method='post' action='".e_SELF."?".e_QUERY."'>
                <table style='width:85%' class='fborder'>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_6.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_folderlinks'] ? 
                  "<input name='dt_folderlinks' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_folderlinks' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_folderlinks' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_folderlinks' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_7.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_useSelection'] ? 
                  "<input name='dt_useSelection' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useSelection' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_useSelection' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useSelection' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_8.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_useCookies'] ? 
                  "<input name='dt_useCookies' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useCookies' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_useCookies' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useCookies' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>
                  
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_9.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_useLines'] ? 
                  "<input name='dt_useLines' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useLines' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_useLines' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useLines' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_17.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_useIcons'] ? 
                  "<input name='dt_useIcons' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useIcons' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_useIcons' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useIcons' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_10.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_useStatusText'] ? 
                  "<input name='dt_useStatusText' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useStatusText' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_useStatusText' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_useStatusText' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>
                  
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_11.":</td>
                <td style='width:50%' class='forumheader3'>".
                ($menu_pref['dt_closeSameLevel'] ? 
                  "<input name='dt_closeSameLevel' type='radio' value='1' checked='checked' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_closeSameLevel' type='radio' value='0' />".
                  DT_LAN_15 
                  : "<input name='dt_closeSameLevel' type='radio' value='1' />".
                  DT_LAN_14."&nbsp;&nbsp;<input name='dt_closeSameLevel' type='radio' value='0' checked='checked' />".
                  DT_LAN_15)."
                </td>
                </tr>
                  
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_12.":</td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_caption' size='20' value='".$menu_pref['dt_caption']."' />
                </td></tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_13.":</td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_captionstyle' size='20' value='".$menu_pref['dt_captionstyle']."' />
               </td></tr>

                <tr>
                <td colspan='2' style='text-align:center' class='forumheader'>
                <input class='button' type='submit' name='update_options' value='".DT_LAN_16."' />
                </td></tr>

                </table></form></div>";
                $ns -> tablerender(DT_LAN_1, $text);
        }
                   
                   
        function show_message($message){
                global $ns;
                $ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
        }          
            
        function submit_tree($sub_action, $id){
                // ##### Format and submit node -------------------------------------------------
                global $aj, $sql;
               
                $dt_pid = $_POST['dt_pid']?$_POST['dt_pid']:1;
                $dt_name = $aj -> formtpa($_POST['dt_name'], "admin");
                $dt_url = $aj -> formtpa($_POST['dt_url'], "admin");
                $dt_title = $aj -> formtpa($_POST['dt_title'], "admin");
                $dt_target = $aj -> formtpa($_POST['dt_target'], "admin");
                $dt_icon = $aj -> formtpa($_POST['dt_icon'], "admin");
                $dt_iconOpen = $aj -> formtpa($_POST['dt_iconOpen'], "admin");
                $dt_class = $_POST['dt_class'];
                if($results=$sql -> db_Select_gen("SELECT dt_level FROM ".MPREFIX."dtree WHERE dt_id=".$dt_pid)){
                  $row = $sql -> db_Fetch();
                  extract($row);
                  $dt_level++;
                } 

                //echo "id= $id, dt_pid= $dt_pid, dt_level= $dt_level, dt_name= $dt_name, dt_url= $dt_url , dt_title= $dt_title , dt_target= $dt_target, dt_icon= $dt_icon, dt_iconOpen= $dt_iconOpen, dt_class= $dt_class ";
                
                
                if($id){
                  if ($id <> 1) {
                    $sql -> db_Update("dtree", "dt_pid=$dt_pid, dt_level='$dt_level', dt_name='$dt_name', dt_url='$dt_url', dt_title='$dt_title', dt_target= '$dt_target', dt_icon='$dt_icon', dt_iconOpen='$dt_iconOpen', dt_class=$dt_class WHERE dt_id=$id");
                  }
                  elseif ($id==1) {
                    $sql -> db_Update("dtree", "dt_name='$dt_name', dt_title='$dt_title' WHERE dt_id=$id");
                  }
                  $this->show_message(DT_LAN_38);
                }else{
                  $results=$sql->db_Insert("dtree", "0, $dt_pid, $dt_level, '$dt_name', '$dt_url', '$dt_title', '$dt_target', '$dt_icon', '$dt_iconOpen', 0, $dt_class");
                  $this->show_message(DT_LAN_36);
                }
        }        
        
        function edidel_tree() {
          global $sql, $ns;
          
                echo "<link rel='StyleSheet' href='".e_PLUGIN."/dtree_menu/dtree.css' type='text/css' />";
                echo "<script type='text/javascript' src='".e_PLUGIN."dtree_menu/dtree_admin.js'></script>\n\n";

                $text = "<div style='text-align:center'>
                <table style='width:95%' class='fborder'>
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_34.": </td>                
                <td style='width:50%' class='forumheader3'>".DT_LAN_35.": </td></tr>";
                $text .= "<tr><td style='width:50%' class='forumheader3'>";
                $text.='<div class="dtree">';
                $text.='<p><a href="javascript: e.openAll();">open all</a> | <a href="javascript: e.closeAll();">close all</a></p><br>';
                $text.='<script type="text/javascript">';
                $text.='e = new dTree("e");';
                $text.='e.config.useSelection=true;';
                if($results=$sql -> db_Select_gen("SELECT * FROM ".MPREFIX."dtree ORDER BY dt_level")){
                //if($results=$sql -> db_Select("dtree"," ORDER BY dt_level")){  
                  while($row = $sql -> db_Fetch()){
                    extract($row);
                    $tmpicon = $dt_icon? e_PLUGIN.'dtree_menu/images/'.$dt_icon:'';
                    $tmpiconOpen = $dt_iconOpen? e_PLUGIN.'dtree_menu/images/'.$dt_iconOpen:'';
                    $tmpurl= e_PLUGIN.'dtree_menu/dtree_config.php?create.edit.'.$dt_id;
                    $text.='e.add('.$dt_id.','.$dt_pid.',"'.$dt_name.'","'.$tmpurl.'","'.$dt_title.'","","'
                    .$tmpicon.'","'.$tmpiconOpen.'",'.$dt_open.');';
                  }
                }  
                $text.='document.write(e);';
                $text.='</script></div></td>';
                $text .= "<td style='width:50%' class='forumheader3'>";
                $text.='<div class="dtree">';
                $text.='<p><a href="javascript: u.openAll();">open all</a> | <a href="javascript: u.closeAll();">close all</a></p><br>';
                $text.='<script type="text/javascript">';
                $text.='u = new dTree("u");';
                $text.='u.config.useSelection=true;';
                if($results=$sql -> db_Select_gen("SELECT * FROM ".MPREFIX."dtree ORDER BY dt_level")){
                //if($results=$sql -> db_Select("dtree"," ORDER BY dt_level")){  
                  while($row = $sql -> db_Fetch()){
                    extract($row);
                    $tmpicon = $dt_icon? e_PLUGIN.'dtree_menu/images/'.$dt_icon:'';
                    $tmpiconOpen = $dt_iconOpen? e_PLUGIN.'dtree_menu/images/'.$dt_iconOpen:'';
                    $tmpurl= e_PLUGIN.'dtree_menu/dtree_config.php?delete.'.$dt_id;
                    $text.='u.add('.$dt_id.','.$dt_pid.',"'.$dt_name.'","'.$tmpurl.'","'.$dt_title.'","","'
                    .$tmpicon.'","'.$tmpiconOpen.'",'.$dt_open.');';
                  }
                }  
                $text.='document.write(u);';
                $text.='</script></div></td></tr></table></div>';
                
                $ns -> tablerender(DT_LAN_37, $text);
        }
        
        function create_tree($sub_action, $id){
                global $sql, $rs, $ns;

                if($sub_action == "edit" && !$_POST['submit']){
                        if($sql -> db_Select("dtree", "*", "dt_id='$id' ")){
                                $row = $sql-> db_Fetch();
                                extract($row);
                        }
                }

                $handle=opendir(e_PLUGIN."dtree_menu/images");
                while ($file = readdir($handle)){
                        if($file != "." && $file != ".." && $file != "/"){
                                $iconlist[] = $file;
                                $iconlist2[] = $file;
                        }
                }
                closedir($handle);

                $text = "<div style='text-align:center'>
                <form method='post' action='".e_SELF."?".e_QUERY."' id='treeform'>
                <table style='width:95%' class='fborder'>
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_19;
                if ($dt_id==1) {
                	$text.="<br /><span class='smalltext'>(".DT_LAN_39.")</span>";
                }
                $text.=": </td>
                <td style='width:50%' class='forumheader3'>";

                //if(!$tree = $sql -> db_Select("dtree","*","ORDER BY dt_level")){
                if(!$tree = $sql -> db_Select_gen("SELECT * FROM ".MPREFIX."dtree ORDER BY dt_level")) {
                        $text .= DT_LAN_40."<br />";
                }else{
                        $text .= "
                        <select name='dt_pid' class='tbox' ><option></option>";
                        while(list($sdt_id, $sdt_pid, $sdt_level, $sdt_name) = $sql-> db_Fetch()){
                                 $text .= "<option value='$sdt_id'";
                                 if ($dt_pid==$sdt_id) {
                                   $text.=" selected='selected'";	
                                 }
                                 $text.=" >";
                                 for ($i=0; $i<$sdt_level; $i++) {
                                   $text .= '_';
                                 };
                                 $text.=$sdt_name."</option>";
                                }
                        }
                       $text .= "</select>&nbsp;&nbsp;";
                       
                $text .= "</td></tr><tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_20.": </td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_name' size='30' value='$dt_name' maxlength='100' />
                </td>
                </tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_21.": </td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_url' size='30' value='$dt_url' maxlength='200' />
                </td>
                </tr>

                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_22.": </td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_title' size='30' value='$dt_title' maxlength='200' />
                </td>
                </tr>
                
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_23.": </td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_icon' size='30' value='$dt_icon' maxlength='100' />

                <br />
                <input class='button' type ='button' style='cursor:hand' size='30' value='".DT_LAN_24."' onclick=\"expandit('dt_icon')\" />
                <div id='dt_icon' style='display:none;{head}'>";
                while(list($key, $icon) = each($iconlist)){
                        $text .= "<a href='javascript:addtext(\"$icon\")'><img src='".e_PLUGIN."dtree_menu/images/".$icon."' style='border:0' alt='' /></a> ";
                }
                $text .= "</div></td>
                </tr>
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_25.": </td>
                <td style='width:50%' class='forumheader3'>
                <input class='tbox' type='text' name='dt_iconOpen' size='30' value='$dt_iconOpen' maxlength='100' />

                <br />
                <input class='button' type ='button' style='cursor:hand' size='30' value='".DT_LAN_24."' onclick=\"expandit('dt_iconOpen')\" />
                <div id='dt_iconOpen' style='display:none;{head}'>";
                while(list($key, $icon) = each($iconlist2)){
                        $text .= "<a href='javascript:addtext2(\"$icon\")'><img src='".e_PLUGIN."dtree_menu/images/".$icon."' style='border:0' alt='' /></a> ";
                }

// 0 = same window
// 1 = _blank
// 2 = _parent
// 3 = _top
// 4 = miniwindow

                $text .= "</div></td>
                </tr>
                
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_26.": </td>
                <td style='width:50%' class='forumheader3'>
                <select name='dt_target' class='tbox'>".
                ($dt_target == '' ? "<option value='' selected='selected'>".DT_LAN_32."</option>" : "<option value=''>".DT_LAN_32."</option>").
                ($dt_target == '_blank' ? "<option value='_blank' selected='selected'>".DT_LAN_33."</option>" : "<option value='_blank'>".DT_LAN_33."</option>")."
                </select>
                </td>
                </tr>
                <tr>
                <td style='width:50%' class='forumheader3'>".DT_LAN_27.":</td>
                <td style='width:50%' class='forumheader3'>".r_userclass("dt_class",$dt_class,"off","public,guest,nobody,member,admin,classes")."

                </td></tr>


                <tr style='vertical-align:top'>
                <td colspan='2' style='text-align:center' class='forumheader'>";
                if($id && $sub_action == "edit"){
                        $text .= "<input class='button' type='submit' name='add_tree' value='".DT_LAN_28."' />\n<input type='hidden' name='upd_id' value='$dt_id'>";
                }else{
                        $text .= "<input class='button' type='submit' name='add_tree' value='".DT_LAN_29."' />";
                }
                $text .= "</td>
                </tr>
                </table>
                </form>
                </div>";
                $ns -> tablerender(DT_LAN_2, $text);

        }
        
        function copy_tree() {
                global $sql;
               
                
                if($link_total = $sql -> db_Select("links", "*", "ORDER BY link_order, link_id ASC", "nowhere")){
                  $sql2 = new db; 
                  if($sql2 -> db_Delete("dtree"))
                  { $sql2 -> db_Insert("dtree", "0,-1,0,'Main Menu','','','','','',0,0");}
                  while($row = $sql -> db_Fetch()){
                    extract($row);
                    $dt_url = $link_url;
                    $dt_class = $link_class;
                    $sub=strpos($link_name,'.');
                    if ($sub === false) {$dt_pid = 1; $dt_level = 1;$dt_name = $link_name;$dt_title = $link_name;}
                      else {
                      $dot1=strpos($link_name,'.')+1;
                      $dot2=strrpos($link_name,'.');
                      $leng1=$dot2-$dot1;
                      $leng2=strlen($link_name)-$dot2;
                      $parent= substr($link_name,$dot1,$leng1);
                      $child = substr($link_name,$dot2+1,$leng2);
                      $result=$sql2 -> db_Select_gen("SELECT dt_id FROM ".MPREFIX."dtree WHERE dt_name='".$parent."'");
                      $row2 = $sql2 -> db_Fetch();
                      extract($row2);
                      $dt_pid=$dt_id;
                      $dt_level = 2;
                      $dt_name = $child;
                      $dt_title = $child;
                      //echo "dt_pid= $dt_pid, dt_level= $dt_level, dt_name= $dt_name, dt_url= $dt_url , dt_title= $dt_title , dt_class= $dt_class ";
                    }
                   $results=$sql2->db_Insert("dtree","0,$dt_pid,$dt_level,'$dt_name','$dt_url','$dt_title','','','',0, $dt_class");
                  }
                  $this->show_message(DT_LAN_44);
                }  else { $this->show_message(DT_LAN_45);}
        }
        
}

?>                   