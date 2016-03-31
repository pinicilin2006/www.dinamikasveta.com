<?php
/*
+---------------------------------------------------------------+
|        e107 website system
|        /classes/upload_class.php
|
|        �Steve Dunstan 2001-2002
|        http://e107.org
|        jalist@e107.org
|
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
|   $Source: /cvsroot/e107/e107_0.7/e107_handlers/upload_handler.php,v $
|   $Revision: 1.22 $
|   $Date: 2006/11/28 23:41:23 $
|   $Author: mcfly_e107 $
+---------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

@include_once(e_LANGUAGEDIR.e_LANGUAGE."/lan_upload_handler.php");
@include_once(e_LANGUAGEDIR."English/lan_upload_handler.php");
function file_upload($uploaddir, $avatar = FALSE, $fileinfo = "", $overwrite = "")
{

	global $pref, $sql, $tp;

	if (!$uploaddir) {$uploaddir = e_FILE."public/";}
	if($uploaddir == e_THEME) {$pref['upload_storagetype'] = 1;}

	if (is_readable(e_ADMIN.'filetypes.php')) {
		$a_filetypes = trim(file_get_contents(e_ADMIN.'filetypes.php'));
		$a_filetypes = explode(',', $a_filetypes);
		foreach ($a_filetypes as $ftype) {
			$allowed_filetypes[] = '.'.trim(str_replace('.', '', $ftype));
		}
	}

	if ($pref['upload_storagetype'] == "2" && $avatar == FALSE)
	{
		extract($_FILES);
		for($c = 0; $c <= 1; $c++)
		{
			if ($file_userfile['tmp_name'][$c])
			{
				$fileext1 = substr(strrchr($file_userfile['name'][$c], "."), 1);
				$fileext2 = substr(strrchr($file_userfile['name'][$c], "."), 0); // in case user has left off the . in allowed_filetypes
				if (!in_array($fileext1, $allowed_filetypes) && !in_array(strtolower($fileext1), $allowed_filetypes) && !in_array(strtolower($file_userfile['type'][$c]), $allowed_filetypes))
				{
					if (!in_array($fileext2, $allowed_filetypes) && !in_array(strtolower($fileext2), $allowed_filetypes) && !in_array(strtolower($file_userfile['type'][$c]), $allowed_filetypes))
					{
						require_once(e_HANDLER."message_handler.php");
						message_handler("MESSAGE", "".LANUPLOAD_1." '".$file_userfile['type'][$c]."' ".LANUPLOAD_2."");
						return FALSE;
						require_once(FOOTERF);
						exit;
					}
				}
				set_magic_quotes_runtime(0);
				$data = mysql_escape_string(fread(fopen($file_userfile['tmp_name'][$c], "rb"), filesize($file_userfile['tmp_name'][$c])));
				set_magic_quotes_runtime(get_magic_quotes_gpc());
				$file_name = preg_replace("/[^a-z0-9._]/", "", str_replace(" ", "_", str_replace("%20", "_", strtolower($file_userfile['name'][$c]))));
				$sql->db_Insert("rbinary", "0, '".$tp -> toDB($file_name, true)."', '".$tp -> toDB($file_userfile['type'][$c], true)."', '$data' ");
				$uploaded[$c]['name'] = "Binary ".mysql_insert_id()."/".$file_name;
				$uploaded[$c]['type'] = $file_userfile['type'][$c];
				$uploaded[$c]['size'] = $file_userfile['size'][$c];
			}
		}
		return $uploaded;
	}
	/*
	if (ini_get('open_basedir') != ''){
	require_once(e_HANDLER."message_handler.php");
	message_handler("MESSAGE", "'open_basedir' restriction is in effect, unable to move uploaded file, deleting ...", __LINE__, __FILE__);
	return FALSE;
	}
	*/

	//	echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;

	$files = $_FILES['file_userfile'];
	if (!is_array($files))
	{
		return FALSE;
	}

	$c = 0;
	foreach($files['name'] as $key => $name)
	{

		if ($files['size'][$key])
		{
			$filesize[] = $files['size'][$key];
			$name = preg_replace("/[^a-z0-9._-]/", "", str_replace(" ", "_", str_replace("%20", "_", strtolower($name))));
			if ($avatar == "attachment") {
				$name = time()."_".USERID."_".$fileinfo.$name;
			}

			$destination_file = getcwd()."/".$uploaddir."/".$name;
			if ($avatar == "unique" && file_exists($destination_file))
			{
				$name = time()."_".$name;
				$destination_file = getcwd()."/".$uploaddir."/".$name;
			}
			if (file_exists($destination_file) && !$overwrite)
			{
				require_once(e_HANDLER."message_handler.php");
				message_handler("MESSAGE", LANUPLOAD_10, __LINE__, __FILE__); // duplicate file
				$f_message .= LANUPLOAD_10 . __LINE__ .  __FILE__;
				$dupe_found = TRUE;
			}
			else
			{
				$uploadfile = $files['tmp_name'][$key];
				$fileext1 = substr(strrchr($files['name'][$key], "."), 1);
				$fileext2 = substr(strrchr($files['name'][$key], "."), 0);
				if (!in_array($fileext1, $allowed_filetypes) && !in_array(strtolower($fileext1), $allowed_filetypes) && !in_array(strtolower($files['type'][$c]), $allowed_filetypes))
				{
					if (!in_array($fileext2, $allowed_filetypes) && !in_array(strtolower($fileext2), $allowed_filetypes) && !in_array(strtolower($files['type'][$c]), $allowed_filetypes))
					{
						require_once(e_HANDLER."message_handler.php");
						message_handler("MESSAGE", LANUPLOAD_1." ".$files['type'][$key]." ".LANUPLOAD_2.".", __LINE__, __FILE__);
						$f_message .= LANUPLOAD_1." ".$files['type'][$key]." ".LANUPLOAD_2."." . __LINE__ .  __FILE__;
						return FALSE;
						require_once(FOOTERF);
						exit;
					}
				}

				$uploaded[$c]['name'] = $name;
				$uploaded[$c]['type'] = $files['type'][$key];
				$uploaded[$c]['size'] = 0;

				$method = (OPEN_BASEDIR == FALSE ? "copy" : "move_uploaded_file");

				if (@$method($uploadfile, $destination_file))
				{
					@chmod($destination_file, 0644);
					$_tmp = explode('.', $name);
					$fext = array_pop($_tmp);
					$fname = basename($name, '.'.$fext);
					$tmp = pathinfo($name);
					$rename = substr($fname, 0, 15).".".time().".".$fext;
					if (@rename(e_FILE."public/avatars/".$name, e_FILE."public/avatars/".$rename))
					{
						$uploaded[$c]['name'] = $rename;
					}

					if ($method == "copy")
					{
						@unlink($uploadfile);
					}

					if(!$dupe_found)
					{   // don't display 'success message' when duplicate file found.
						require_once(e_HANDLER."message_handler.php");
						message_handler("MESSAGE", "".LANUPLOAD_3." '".$files['name'][$key]."'", __LINE__, __FILE__);
						$f_message .= "".LANUPLOAD_3." '".$files['name'][$key]."'.<br />";
					}
					$uploaded[$c]['size'] = $files['size'][$key];

				}
				else
				{
					$uploaded[$c]['error'] = $files['error'][$key];
					switch ($files['error'][$key])
					{
						case 0:
						$error = LANUPLOAD_4." [".str_replace("../", "", $uploaddir)."]";
						break;
						case 1:
						$error = LANUPLOAD_5;
						break;
						case 2:
						$error = LANUPLOAD_6;
						break;
						case 3:
						$error = LANUPLOAD_7;
						break;
						case 4:
						$error = LANUPLOAD_8;
						break;
						case 5:
						$error = LANUPLOAD_9;
						break;
					}
					require_once(e_HANDLER."message_handler.php");
					message_handler("MESSAGE", LANUPLOAD_11." '".$files['name'][$key]."' <br />".LANUPLOAD_12.": ".$error, __LINE__, __FILE__);
					$f_message .= LANUPLOAD_11." '".$files['name'][$key]."' <br />".LANUPLOAD_12.": ".$error . __LINE__ . __FILE__;

				}
			}
		}
		$c++;
	}
	define("F_MESSAGE", "<br />".$f_message);

	return $uploaded;
}
?>