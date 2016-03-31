<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: classes/admin.class.php                          |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/main.class.php");

if (function_exists("include_lan")){
	include_lan(dirname(__FILE__)."/../languages/".e_LANGUAGE."/lan_admin.class.php");
}

class Admin extends Main{

	function GetFilesList($Directory, $Types){
		$Files = array();
		$Dir = @opendir(realpath($Directory));
		while ($File = @readdir($Dir)){
			$Ext = $this->GetExtension($File);
			if (in_array($Ext, $Types)){
				$Files[] = $File;
			}
		}
		@closedir($Dir);
		natcasesort($Files);
		return $Files;
	}

	function RenderFileInfo($File){
		$con = new convert;
		$Name = preg_replace("/.+\/(.+)\.[a-z0-9]{2,4}$/i", "\\1", $File);
		$Size = $this->ReturnSize($this->GetFileSize($File));
		$Time = $con->convert_date(filemtime($File), "long");
		$Type = $this->GetExtension($File);
		if ($this->IsSupported($File, "MgImageList")){
			list($Width, $Height) = @getimagesize($File);
			$Text = "<b>".MG_ADMIN_CLASS_1."</b> ".$Name."<br /><b>".MG_ADMIN_CLASS_2."</b> ".$Type."<br /><b>".MG_ADMIN_CLASS_3."</b> ".$Width."x".$Height." ".MG_ADMIN_CLASS_4."<br /><b>".MG_ADMIN_CLASS_5."</b> ".$Size."<br /><b>".MG_ADMIN_CLASS_6."</b> ".$Time;
		}else{
			$Text = "<b>".MG_ADMIN_CLASS_1."</b> ".$Name."<br /><b>".MG_ADMIN_CLASS_2."</b> ".$Type."<br /><b>".MG_ADMIN_CLASS_5."</b> ".$Size."<br /><b>".MG_ADMIN_CLASS_6."</b> ".$Time;
			$File = e_GALLERY."images/thumbs/".$Type."_thumb.png";
		}
		return array($File, $Text);
	}

	function RenderOptionBar($Mode, $Id){
		switch ($Mode){
			case "image":
				$Text = "<a href='".e_GALLERY."admin_view.php?".$Id."'><img src='".e_GALLERY."images/actions/view.png' title='".MG_ADMIN_CLASS_7."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_image.php?edit.".$Id."'><img src='".e_GALLERY."images/actions/edit.png' title='".MG_ADMIN_CLASS_8."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_image.php?delete.".$Id."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_ADMIN_CLASS_9."' alt='' style='border:0px;' /></a>";
				break;
			case "category":
				$Text = "<a href='".e_GALLERY."admin_category.php?edit.".$Id."'><img src='".e_GALLERY."images/actions/edit.png' title='".MG_ADMIN_CLASS_8."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_category.php?delete.".$Id."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_ADMIN_CLASS_9."' alt='' style='border:0px;' /></a>";
				break;
			case "subimage":
				$Text = "<a href='".e_GALLERY."admin_view.php?".$Id."'><img src='".e_GALLERY."images/actions/view.png' title='".MG_ADMIN_CLASS_7."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_image.php?approve.".$Id."'><img src='".e_GALLERY."images/actions/approve.png' title='".MG_ADMIN_CLASS_10."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_image.php?delete.".$Id."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_ADMIN_CLASS_9."' alt='' style='border:0px;' /></a>";
				break;
			case "submedia":
				$Text = "<a href='".e_GALLERY."admin_view.php?".$Id."'><img src='".e_GALLERY."images/actions/view.png' title='".MG_ADMIN_CLASS_7."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_media.php?approve.".$Id."'><img src='".e_GALLERY."images/actions/approve.png' title='".MG_ADMIN_CLASS_10."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_media.php?delete.".$Id."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_ADMIN_CLASS_9."' alt='' style='border:0px;' /></a>";
				break;
			case "media":
				$Text = "<a href='".e_GALLERY."admin_view.php?".$Id."'><img src='".e_GALLERY."images/actions/view.png' title='".MG_ADMIN_CLASS_7."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_media.php?edit.".$Id."'><img src='".e_GALLERY."images/actions/edit.png' title='".MG_ADMIN_CLASS_8."' alt='' style='border:0px;' /></a> 
				<a href='".e_GALLERY."admin_media.php?delete.".$Id."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_ADMIN_CLASS_9."' alt='' style='border:0px;' /></a>";
				break;
		}
		return $Text;
	}
	
	function RenderColorChooser(){
		$Text = "<div id='colorchooser' style='position:absolute; visibility:hidden; left:-1000px;'>
		<table style='width:199px; height:133px; background-color:#000000; padding:0px; border:1px solid #000000; border-collapse:collapse;'>";
		for ($R = 0; $R < 6; $R++){
			$Text .= "<tr>";
			if ($R == 0) $ColorR = "00";
			if ($R == 1) $ColorR = "33";
			if ($R == 2) $ColorR = "66";
			if ($R == 3) $ColorR = "99";
			if ($R == 4) $ColorR = "CC";
			if ($R == 5) $ColorR = "FF";
			for ($G = 0; $G < 6; $G++){
				if ($G == 0) $ColorG = "00";
				if ($G == 1) $ColorG = "33";
				if ($G == 2) $ColorG = "66";
				if ($G == 3){
					$ColorG = "99";
					$Text .= "<tr>";
				}
				if ($G == 4) $ColorG = "CC";
				if ($G == 5) $ColorG = "FF";
				for ($B = 0; $B < 6; $B++){
					if ($B == 0) $ColorB = "00";
					if ($B == 1) $ColorB = "33";
					if ($B == 2) $ColorB = "66";
					if ($B == 3) $ColorB = "99";
					if ($B == 4) $ColorB = "CC";
					if ($B == 5) $ColorB = "FF";
					$Text .= "<td style='background-color:#".$ColorR.$ColorG.$ColorB."; width:10px; height:10px; cursor:pointer; padding:0px; border:1px solid #000000;' onclick='SelectColor(\"#".$ColorR.$ColorG.$ColorB."\")'></td>\n";
				}
			}
			$Text .= "</tr>";
		}
		$Text .= "</table>
		</div>";
		return $Text;
	}

}

?>