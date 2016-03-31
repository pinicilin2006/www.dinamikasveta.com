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
|     $Source: /cvsroot/e107/e107_0.7/e107_admin/emoticon.php,v $
|     $Revision: 1.37 $
|     $Date: 2006/12/18 22:24:29 $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

require_once("../class2.php");
if (!getperms("F")) {
	header("location:".e_BASE."index.php");
	exit;
}
$e_sub_cat = 'emoticon';

require_once("auth.php");

if(!$sql->db_Count("core", "(*)", "WHERE e107_name = 'emote_default'"))
{
	$tmp = 'a:28:{s:9:"alien!png";s:6:"!alien";s:10:"amazed!png";s:7:"!amazed";s:9:"angry!png";s:11:"!grr !angry";s:12:"biglaugh!png";s:4:"!lol";s:11:"cheesey!png";s:10:":D :oD :-D";s:12:"confused!png";s:10:":? :o? :-?";s:7:"cry!png";s:19:"&| &-| &o| :(( !cry";s:8:"dead!png";s:21:"x) xo) x-) x( xo( x-(";s:9:"dodge!png";s:6:"!dodge";s:9:"frown!png";s:10:":( :o( :-(";s:7:"gah!png";s:10:":@ :o@ :o@";s:8:"grin!png";s:10:":D :oD :-D";s:9:"heart!png";s:6:"!heart";s:8:"idea!png";s:10:":! :o! :-!";s:7:"ill!png";s:4:"!ill";s:7:"mad!png";s:13:"~:( ~:o( ~:-(";s:12:"mistrust!png";s:9:"!mistrust";s:11:"neutral!png";s:10:":| :o| :-|";s:12:"question!png";s:2:"?!";s:12:"rolleyes!png";s:10:"B) Bo) B-)";s:7:"sad!png";s:4:"!sad";s:10:"shades!png";s:10:"8) 8o) 8-)";s:7:"shy!png";s:4:"!shy";s:9:"smile!png";s:10:":) :o) :-)";s:11:"special!png";s:3:"%-6";s:12:"suprised!png";s:10:":O :oO :-O";s:10:"tongue!png";s:21:":p :op :-p :P :oP :-P";s:8:"wink!png";s:10:";) ;o) ;-)";}';
	$sql->db_Insert("core", "'emote_default', '$tmp' ");
}

if (isset($_POST['active']))
{
	if ($pref['smiley_activate'] != $_POST['smiley_activate']) {
		$pref['smiley_activate'] = $_POST['smiley_activate'];
		save_prefs();
		$update = true;
	}
	admin_update($update);
}

/* get packs */

require_once(e_HANDLER."file_class.php");
$fl = new e_file;
$emote = new emotec;
foreach($_POST as $key => $value)
{
	if(strstr($key, "subPack_"))
	{
		$subpack = str_replace("subPack_", "", $key);
		$emote -> emoteConf($subpack);
		break;
	}

	if(strstr($key, "defPack_"))
	{
		$pref['emotepack'] = str_replace("defPack_", "", $key);
		save_prefs();
		break;
	}
}

$check = TRUE;
$check = $emote -> installCheck();
if($check!==FALSE){
	$emote -> listPacks();
}

class emotec
{

	var $packArray;

	function emotec()
	{
		/* constructor */
		global $fl;
		$this -> packArray = $fl -> get_dirs(e_IMAGE."emotes");

		if(isset($_POST['sub_conf']))
		{
			$this -> saveConf();
		}
	}

	function listPacks()
	{

		global $ns, $fl, $pref;

		$text = "<div style='text-align:center'>
		<form method='post' action='".e_SELF."'>
		<table style='".ADMIN_WIDTH."' class='fborder'>
		<tr>
		<td style='width:30%' class='forumheader3'>".EMOLAN_4.": </td>
		<td style='width:70%' class='forumheader3'>".($pref['smiley_activate'] ? "<input type='checkbox' name='smiley_activate' value='1'  checked='checked' />" : "<input type='checkbox' name='smiley_activate' value='1' />")."</td>
		</tr>

		<tr>
		<td colspan='2' style='text-align:center' class='forumheader'>
		<input class='button' type='submit' name='active' value='".LAN_UPDATE."' />
		</td>
		</tr>
		</table>
		</form>
		</div>
		";

		$ns -> tablerender(EMOLAN_1, $text);


		$text = "
		<form method='post' action='".e_SELF."'>
		<table style='".ADMIN_WIDTH."' class='fborder'>
		<tr>
		<td class='forumheader' style='width: 20%;'>".EMOLAN_2."</td>
		<td class='forumheader' style='width: 50%;'>".EMOLAN_3."</td>
		<td class='forumheader' style='width: 10%; text-align: center;'>".EMOLAN_8."</td>
		<td class='forumheader' style='width: 20%;'>".EMOLAN_9."</td>
		";

		$reject = array('^\.$','^\.\.$','^\/$','^CVS$','thumbs\.db','.*\._$', 'emoteconf*');
		foreach($this -> packArray as $pack)
		{
			$emoteArray = $fl -> get_files(e_IMAGE."emotes/".$pack, "", $reject);

			$text .= "
			<tr>
			<td class='forumheader' style='width: 20%;'>$pack</td>
			<td class='forumheader' style='width: 20%;'>
			";

			foreach($emoteArray as $emote)
			{
				$text .= "<img src='".$emote['path'].$emote['fname']."' alt='' /> ";
			}

			$text .= "</td>
			<td class='forumheader3' style='width: 10%; text-align: center;'>".($pref['emotepack'] == $pack ? EMOLAN_10 : "<input class='button' type='submit' name='defPack_".$pack."' value=\"".EMOLAN_11."\" />")."</td>
			<td class='forumheader3' style='width: 20%; text-align: center;'><input class='button' type='submit' name='subPack_".$pack."' value=\"".EMOLAN_12."\" /></td>
			</tr>
			";
		}

		$text .= "
		</table>
		</form>
		";
		$ns -> tablerender(EMOLAN_13, $text);
	}

	function emoteConf($packID)
	{

		global $ns, $fl, $pref, $sysprefs, $tp;
		$corea = "emote_".$packID;

		$emotecode = $sysprefs -> getArray($corea);

		$reject = array('^\.$','^\.\.$','^\/$','^CVS$','thumbs\.db','.*\._$', 'emoteconf*', '*\.txt', '*\.html', '*\.pak', '*php*', '.cvsignore');
		$emoteArray = $fl -> get_files(e_IMAGE."emotes/".$packID, "", $reject);

		$eArray = array();
		foreach($emoteArray as $value)
		{
			if(!strstr($value['fname'], ".php") && !strstr($value['fname'], ".txt") && !strstr($value['fname'], ".pak") && !strstr($value['fname'], ".xml") && !strstr($value['fname'], "phpBB") && !strstr($value['fname'], ".html"))
			{
				$eArray[] = array('path' => $value['path'], 'fname' => $value['fname']);
			}
		}

		$text = "
		<form method='post' action='".e_SELF."'>
		<table style='".ADMIN_WIDTH."' class='fborder'>
		<tr>
		<td class='forumheader' style='width: 20%;'>".EMOLAN_2."</td>
		<td class='forumheader' style='width: 20%; text-align: center;'>".EMOLAN_5."</td>
		<td class='forumheader' style='width: 60%;'>".EMOLAN_6." <span class='smalltext'>( ".EMOLAN_7." )</a></td>
		</tr>
		";

		foreach($eArray as $emote)
		{
			$ename = $emote['fname'];
			$evalue = str_replace(".", "!", $ename);

			$text .= "
			<tr>
			<td class='forumheader3' style='width: 20%;'>".$ename."</td>
			<td class='forumheader3' style='width: 20%; text-align: center;'><img src='".$emote['path'].$ename."' alt='' /></td>
			<td class='forumheader3' style='width: 60%;'><input style='width: 80%' class='tbox' type='text' name='$evalue' value='".$tp -> toForm($emotecode[$evalue])."' maxlength='200' /></td>
			</tr>
			";
		}

		$text .= "
		<tr>
		<td style='text-align: center;' colspan='3' class='forumheader'><input class='button' type='submit' name='sub_conf' value='".EMOLAN_14."' /></td>
		</tr>

		</table>
		<input type='hidden' name='packID' value='$packID' />
		</form>";
		$ns -> tablerender(EMOLAN_15.": '".$packID."'", $text);

	}

	function saveConf()
	{
		global $ns, $sql, $tp;

		$packID = $_POST['packID'];
		unset($_POST['sub_conf'], $_POST['packID']);

		foreach($_POST as $key => $value)
		{
			$key = str_replace("_", "!", $key);
			$_POST[$key] = $value;
		}

		$encoded_emotes = $tp -> toDB($_POST);
		$tmp = addslashes(serialize($encoded_emotes));

		if ($sql->db_Select("core", "*", "e107_name='emote_".$packID."'")) {
			admin_update($sql->db_Update("core", "e107_value='$tmp' WHERE e107_name='emote_".$packID."' "), 'update', EMOLAN_16);
		} else {
			admin_update($sql->db_Insert("core", "'emote_".$packID."', '$tmp' "), 'insert', EMOLAN_16);
		}
	}

	function installCheck()
	{
		global $sql, $fl;
		foreach($this -> packArray as $value)
		{
			if(strpos($value,' ')!==FALSE){
				global $ns;
				$msg = "
				<div style='text-align:center;'><b>".EMOLAN_17."<br />".EMOLAN_18."</b><br /><br />
					<table class='fborder'>
					<tr>
						<td class='fcaption'>".EMOLAN_19."</td>
						<td class='fcaption'>".EMOLAN_20."</td>
					</tr>
					<tr>
						<td class='forumheader3'>".$value."</td>
						<td class='forumheader3'>".e_IMAGE."emotes/</td>
					</tr>
					</table>
				</div>";
				$ns->tablerender(EMOLAN_21, $msg);
				return FALSE;
			}
			if(!$sql -> db_Select("core", "*", "e107_name='emote_".$value."' "))
			{
				$fileArray = $fl -> get_files(e_IMAGE."emotes/".$value);
				foreach($fileArray as $file)
				{
					if(strstr($file['fname'], ".xml"))
					{
						$confFile = array('file' => $file['fname'], 'type' => "xml");
					}
					else if(strstr($file['fname'], ".pak"))
					{
						$confFile = array('file' => $file['fname'], 'type' => "pak");
					}
					else if(strstr($file['fname'], ".php"))
					{
						$confFile = array('file' => $file['fname'], 'type' => "php");
					}
				}

				/* .pak file ------------------------------------------------------------------------------------------------------------------------------------ */
				if($confFile['type'] == "pak")
				{
					$filename = e_IMAGE."emotes/".$value."/".$confFile['file'];
					$pakconf = file ($filename);
					$contentArray = array();
					foreach($pakconf as $line)
					{
						if(trim($line) && strstr($line, "=+") && !strstr($line, ".txt") && !strstr($line, ".html") && !strstr($line, "cvs")) $contentArray[] = $line;
					}
					$confArray = array();
					foreach($contentArray as $pakline)
					{
						$tmp = explode("=+:", $pakline);
						$confIC = str_replace(".", "!", $tmp[0]);
						$confArray[$confIC] = trim($tmp[2]);
					}
					$tmp = addslashes(serialize($confArray));
					$sql->db_Insert("core", "'emote_".$value."', '$tmp' ");
					echo "<div style='text-align: center;'><b>".EMOLAN_22." '</b> ".$value."'</div>";
				}
				/* end ----------------------------------------------------------------------------------------------------------------------------------------- */

				/* .xml file ------------------------------------------------------------------------------------------------------------------------------------ */
				if($confFile['type'] == "xml")
				{
					$filename = e_IMAGE."emotes/".$value."/".$confFile['file'];

					$handle = fopen ($filename, "r");
					$contents = fread ($handle, filesize ($filename));
					fclose ($handle);

					preg_match_all("#\<emoticon file=\"(.*?)\"\>(.*?)\<\/emoticon\>#si", $contents, $match);
					$confArray = array();

					for($a=0; $a<=(count($match[0])); $a++)
					{
						preg_match_all("#\<string\>(.*?)\<\/string\>#si", $match[0][$a], $match2);

						$codet = "";
						foreach($match2[1] as $code)
						{
							$codet .= $code." ";
						}

						foreach($fileArray as $emote)
						{
							if(strstr($emote['fname'], $match[1][$a]))
							{
								$file = str_replace(".", "!", $emote['fname']);
							}
						}
						$confArray[$file] = $codet;
					}

					$tmp = addslashes(serialize($confArray));
					$sql->db_Insert("core", "'emote_".$value."', '$tmp' ");
					echo "<div style='text-align: center;'><b>".EMOLAN_23." '</b> ".$value."'</div>";
				}

				if($confFile['type'] == "php")
				{
					echo "<b>.conf file found</b>: installing '".$value."'<br />";
					include_once(e_IMAGE."emotes/".$value."/".$confFile['file']);
					$sql->db_Insert("core", "'emote_".$value."', '$_emoteconf' ");
					echo "<div style='text-align: center;'><b>".EMOLAN_24." '</b> ".$value."'</div>";
				}
				/* end ----------------------------------------------------------------------------------------------------------------------------------------- */

			}
		}
	}
}

require_once("footer.php");

?>
