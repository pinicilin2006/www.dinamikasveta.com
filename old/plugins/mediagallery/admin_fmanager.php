<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_fmanager.php                               |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем администраторский заголовок
require(dirname(__FILE__)."/admin.php");

// Выделяем из временных необходимые переменные
$MgMode = intval($Tmp[0]);
$MgPage = intval($Tmp[1]);
unset($Tmp);

// Проверяем состояние директорий
$admin->CheckDirPerms(e_UPLOAD, e_TEMP, e_IMAGES, e_MEDIA, e_CTHUMBS, e_MTHUMBS, e_WMARKS);

// Проверка состояния библиотеки GD
$admin->CheckGD();

// Проверка возможности работы с URL-файлами
$admin->CheckURL();

// Переходим по разделам
if (isset($_POST['change_page'])){
	header("Location: ".e_SELF."?".$_POST['mode'].".".$_POST['dir']);
	exit;
}

// Загружаем файлы
if (isset($_POST['upload'])){
	$UploadError = array();
	$ResizeError = array();
	require(e_GALLERY."classes/upload.class.php");
	$upl = new Uploader;
	require(e_GALLERY."classes/resize.class.php");
	$res = new Resizer;
	ob_start();
	foreach ($_FILES as $File){
		if ($File['name']){
			if ($admin->IsSupported($File['name'])){
				$Uploaded = $upl->UploadFile($File, $_POST['directory']);
				$Error = ob_get_contents();
				if ($Error){
					$UploadError[] = $File['name']." (".$Error.")";
					ob_clean();
				}
			}else{
				$UploadError[] = $File['name']." (".MG_ADMIN_FMANAGER_2.")";
			}
		}
	}
	foreach ($_POST['img_url'] as $URL){
		if ($URL){
			if ($admin->IsValidURL($URL)){
				if ($admin->IsSupported($URL)){
					if ($Stats = @getimagesize($URL)){
						$Image = strtolower(basename($Url));
						if (file_exists($_POST['directory'].$Image)){
							$Image = substr(time(), 6).$Image;
						}
						$Resized = $res->ResizeImage($Url, $_POST['directory'].$Image, $Stats[0], $Stats[1]);
						$Error = ob_get_contents();
						if ($Error){
							$ResizeError[] = $URL." (".$Error.")";
							ob_clean();
						}
					}else{
						$ResizeError[] = $URL." (".MG_ADMIN_FMANAGER_1.")";
					}
				}else{
					$ResizeError[] = $URL." (".MG_ADMIN_FMANAGER_2.")";
				}
			}else{
				$ResizeError[] = $URL." (".MG_ADMIN_FMANAGER_3.")";
			}
		}
	}
	ob_end_clean();
	$ResizeError = count($ResizeError) ? implode(",\\n", $ResizeError) : "";
	$UploadError = count($UploadError) ? implode(",\\n", $UploadError) : "";
	if ($ResizeError || $UploadError){
		$admin->RenderAlert(MG_ADMIN_FMANAGER_4."\\n".$UploadError."\\n".$ResizeError);
	}
}

// Перемещаем файлы
if (isset($_POST['move'])){
	extract($_POST);
	foreach ($Files as $File){
		if ($File['move']){
			if (file_exists($Destination.$File['file'])){
				$File['newfile'] = substr(time(), 6).$File['file'];
			}else{
				$File['newfile'] = $File['file'];
			}
			@rename($Directory.$File['file'], $Destination.$File['newfile']);
		}
	}
}

// Удаляем файлы
if (isset($_POST['delete'])){
	extract($_POST);
	foreach ($Files as $File){
		if ($File['delete']){
			@unlink($Directory.$File['file']);
		}
	}
}

// Добавляем файлы
if (isset($_POST['add'])){
	extract($_POST);
	require(e_GALLERY."classes/resize.class.php");
	$res = new Resizer;
	foreach ($Files as $File){
		if ($File['add']){
			if (!$File['name']){
				$Failed[] = "??? (".MG_ADMIN_FMANAGER_42.")";
				continue;
			}
			$File['name'] = $tp->toDB($File['name']);
			$File['description'] = $tp->toDB($File['description']);
			if ($sql->db_Count("mg_images", "(*)", "WHERE img_category='".$Category."' AND img_name='".$File['name']."'")){
				$Failed[] = $File['name']." (".MG_ADMIN_FMANAGER_5.")";
				continue;
			}
			$File['size'] = $admin->GetFileSize($Directory.$File['file']);
			if ($admin->IsSupported($File['file'], "MgImageList")){
				$Destination = e_IMAGES;
				if (file_exists($Destination.$File['file'])){
					$File['newfile'] = substr(time(), 6).$File['file'];
				}else{
					$File['newfile'] = $File['file'];
				}
				$Type = "image";
				$File['thumb'] = $admin->GetThumbName($File['newfile']);
				$Tmp = getimagesize($Directory.$File['file']);
				$File['width'] = $Tmp[0];
				$File['height'] = $Tmp[1];
				$Size = explode("*", $pref['mg_thumb_size']);
				ob_start();
				$Resized = $res->ResizeImage($Directory.$File['file'], $Destination.$File['thumb'], $Size[0], $Size[1]);
				$Error = ob_get_clean();
				if ($Error){
					@unlink($Destination.$File['thumb']);
					$Failed[] = $File['name']." (".$Error.")";
					continue;
				}
			}else{
				$Destination = e_MEDIA;
				if (file_exists($Destination.$File['file'])){
					$File['newfile'] = substr(time(), 6).$File['file'];
				}else{
					$File['newfile'] = $File['file'];
				}
				if ($admin->IsSupported($File['file'], "MgVideoList")){
					$Type = "video";
				}else{
					$Type = "audio";
				}
				$File['thumb'] = $admin->GetExtension($File['file']);
			}
			if (!rename($Directory.$File['file'], $Destination.$File['newfile'])){
				@unlink($Destination.$File['thumb']);
				$Failed[] = $File['name']." (".MG_ADMIN_FMANAGER_6.")";
				continue;
			}
			if (!$sql->db_Insert("mg_images", "0, '".$File['name']."', '".$File['description']."', '".$File['thumb']."', '".$File['newfile']."', '".time()."', '".$Category."', 1, '".USERID.".".USERNAME."', '', '', 0, '".$Type."', '".$File['size']."', '".$File['width']."', '".$File['height']."', 1")){
				@rename($Destination.$File['newfile'], $Directory.$File['file']);
				@unlink($Destination.$File['thumb']);
			}
		}
	}
	if (count($Failed)){
		$admin->RenderAlert(MG_ADMIN_FMANAGER_7."\\n".implode(",\\n", $Failed));
	}
}

// Выводим собранную информацию на экран
require_once(e_ADMIN."auth.php");
$Dirs = array(
	array("dir" => e_UPLOAD, "name" => MG_ADMIN_FMANAGER_11),
	array("dir" => e_TEMP, "name" => MG_ADMIN_FMANAGER_12),
	array("dir" => e_IMAGES, "name" => MG_ADMIN_FMANAGER_13),
	array("dir" => e_MEDIA, "name" => MG_ADMIN_FMANAGER_14),
	array("dir" => e_CTHUMBS, "name" => MG_ADMIN_FMANAGER_15),
	array("dir" => e_MTHUMBS, "name" => MG_ADMIN_FMANAGER_16),
	array("dir" => e_WMARKS, "name" => MG_ADMIN_FMANAGER_17)
);
$text = "<div style='text-align:center;'>
<table class='fborder' style='width:95%;'>
<tr>
<form method='post' action='".e_SELF."?".e_QUERY."'>
<td class='forumheader3' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_8." <select id='mode' name='mode' class='tbox' onchange='RestrictDir()'>
<option value='0'".($MgMode == 0 ? " selected" : "").">".MG_ADMIN_FMANAGER_38."</option>
<option value='1'".($MgMode == 1 ? " selected" : "").">".MG_ADMIN_FMANAGER_39."</option>
<option value='2'".($MgMode == 2 ? " selected" : "").">".MG_ADMIN_FMANAGER_40."</option>
<option value='3'".($MgMode == 3 ? " selected" : "").">".MG_ADMIN_FMANAGER_41."</option>
</select> ".MG_ADMIN_FMANAGER_9." <select id='dir' name='dir' class='tbox'>";
for ($I = 0; $I < 7; $I++){
	$text .= "<option value='".$I."'".($MgPage == $I ? " selected" : "").">".$Dirs[$I]['name']."</option>";
}
$text .= "</select> <input type='submit' name='change_page' class='button' value='".MG_ADMIN_FMANAGER_10."' /></td>
</form>
<script type='text/javascript'>RestrictDir()</script>
</tr>";
switch ($MgMode){
	case 0:
		if ($MgPage < 0 || $MgPage > 6){
			$admin->RenderAlert(MG_ADMIN_FMANAGER_18, e_GALLERY."admin_browse.php");
		}
		$Files = $admin->GetFilesList($Dirs[$MgPage]['dir'], $MgFilesList);
		$text .= "<tr>
		<td class='forumheader' style='text-align:center;' colspan='3'>".sprintf(MG_ADMIN_FMANAGER_19, "<b>".$Dirs[$MgPage]['name']."</b>")."</td>
		</tr>";
		if ($Files){
			$text .= "<form method='post' action='".e_SELF."?".e_QUERY."'>";
			for ($I=0; $I<count($Files); $I++){
				list($File, $Description) = $admin->RenderFileInfo($Dirs[$MgPage]['dir'].$Files[$I]);
				$text .= "<tr>
				<td class='forumheader3' style='text-align:center; vertical-align:center; width:5%;'>
				<input type='checkbox' id='action".$I."' name='Files[".$I."][delete]' class='tbox' value='1' />
				<input type='hidden' name='Files[".$I."][file]' value='".$Files[$I]."' />
				</td>
				<td class='forumheader3' style='width:80%;'>".$Description."</td>
				<td class='forumheader3' style='width:15%; text-align:center; vertical-align:center;'>
				<a href='".e_GALLERY."admin_view.php?".rawurlencode(substr($Dirs[$MgPage]['dir'], strlen(e_FILEDIR)).$Files[$I])."'>
				<img src='".e_GALLERY."showthumb.php?".rawurlencode($File)."' title='".MG_ADMIN_FMANAGER_20."' alt='' style='border:0px;' />
				</a>
				</td>
				</tr>";
			}
			$text .= "<tr>
			<td colspan='3' class='forumheader3' style='text-align:center;'><input type='button' class='button' name='check' value='".MG_ADMIN_FMANAGER_21."' onclick='CheckBox(".count($Files).", 1)' />
			<input type='button' class='button' name='uncheck' value='".MG_ADMIN_FMANAGER_22."' onclick='CheckBox(".count($Files).", 0)' /></td>
			</tr><tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'><input type='hidden' name='Directory' value='".$Dirs[$MgPage]['dir']."' />
			<input type='submit' name='delete' class='button' value='".MG_ADMIN_FMANAGER_23."' /></td>
			</tr>
			</form>";
		}else{
			$text .= "<tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_24."</td>
			</tr>";
		}
		break;
	case 1:
		if ($MgPage < 0 || $MgPage > 6){
			$admin->RenderAlert(MG_ADMIN_FMANAGER_18, e_GALLERY."admin_browse.php");
		}
		$text .= "<tr>
		<td class='forumheader' style='text-align:center;' colspan='3'>".sprintf(MG_ADMIN_FMANAGER_25, "<b>".$Dirs[$MgPage]['name']."</b>")."</td>
		</tr><tr>
		<td class='forumheader2' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_26."</td>
		</tr>
		<form method='post' action='".e_SELF."?".e_QUERY."' enctype='multipart/form-data'>";
		for ($I=0; $I<10; $I++){
			$text .= "<tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'>
			<input type='file' class='tbox' name='file_file".$I."' size='57' style='width:70%;' />
			</td>
			</tr>";
		}
		$text .= "<tr>
		<td class='forumheader2' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_27."</td>
		</tr>";
		for ($I=0; $I<10; $I++){
			$text .= "<tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'>
			<input type='text' class='tbox' name='file_url[]' value='' maxlength='200' style='width:70%;' />
			</td>
			</tr>";
		}
		$text .= "<tr>
		<td class='forumheader3' style='text-align:center;' colspan='3'><input type='hidden' name='directory' value='".$Dirs[$MgPage]['dir']."' />
		<input type='submit' name='upload' class='button' value='".MG_ADMIN_FMANAGER_28."' /></td>
		</tr>
		</form>";
		break;
	case 2:
		if ($MgPage < 0 || $MgPage > 6){
			$admin->RenderAlert(MG_ADMIN_FMANAGER_18, e_GALLERY."admin_browse.php");
		}
		$Files = $admin->GetFilesList($Dirs[$MgPage]['dir'], $MgFilesList);
		$text .= "<tr>
		<td class='forumheader' style='text-align:center;' colspan='3'>".sprintf(MG_ADMIN_FMANAGER_29, "<b>".$Dirs[$MgPage]['name']."</b>")."</td>
		</tr>";
		if ($Files){
			$text .= "<form method='post' action='".e_SELF."?".e_QUERY."'>
			<tr>
			<td class='forumheader2' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_31." <select name='Destination' class='tbox'>";
			$TTFDir = array_pop($MgDirsList);
			foreach ($MgDirsList as $Key => $Dir){
					if ($Dir != $Dirs[$MgPage]['dir']){
						$text .= "<option value='".$Dir."'>".$Dirs[$Key]['name']."</option>";
					}
			}
			$text .= "</td>
			</tr>";
			for ($I=0; $I<count($Files); $I++){
				list($File, $Description) = $admin->RenderFileInfo($Dirs[$MgPage]['dir'].$Files[$I]);
				$text .= "<tr>
				<td class='forumheader3' style='text-align:center; vertical-align:center; width:5%;'><input type='checkbox' id='action".$I."' name='Files[".$I."][move]' class='tbox' value='1' />
				<input type='hidden' name='Files[".$I."][file]' value='".$Files[$I]."' /></td>
				<td class='forumheader3' style='width:80%;'>".$Description."</td>
				<td class='forumheader3' style='width:15%; text-align:center; vertical-align:center;'><a href='".e_GALLERY."admin_view.php?".rawurlencode(substr($Dirs[$MgPage]['dir'], strlen(e_FILEDIR)).$Files[$I])."'>
				<img src='".e_GALLERY."showthumb.php?".rawurlencode($File)."' title='".MG_ADMIN_FMANAGER_20."' alt='' style='border:0px;' /></a></td>
				</tr>";
			}
			$text .= "<tr>
			<td colspan='3' class='forumheader3' style='text-align:center;'><input type='button' class='button' name='check' value='".MG_ADMIN_FMANAGER_21."' onclick='CheckBox(".count($Files).", 1)' />
			<input type='button' class='button' name='uncheck' value='".MG_ADMIN_FMANAGER_22."' onclick='CheckBox(".count($Files).", 0)' /></td>
			</tr><tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'><input type='hidden' name='Directory' value='".$Dirs[$MgPage]['dir']."' />
			<input type='submit' name='move' class='button' value='".MG_ADMIN_FMANAGER_30."' /></td>
			</tr>
			</form>";
		}else{
			$text .= "<tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_24."</td>
			</tr>";
		}
		break;
	case 3:
		if ($MgPage != 0){
			$admin->RenderAlert(MG_ADMIN_FMANAGER_18, e_GALLERY."admin_browse.php");
		}
		$Files = $admin->GetFilesList($Dirs[$MgPage]['dir'], $MgFilesList);
		$text .= "<tr>
		<td class='forumheader' style='text-align:center;' colspan='3'>".sprintf(MG_ADMIN_FMANAGER_32, "<b>".$Dirs[$MgPage]['name']."</b>")."</b></td>
		</tr>";
		if ($Files){
			$text .= "<form method='post' action='".e_SELF."?".e_QUERY."'>
			<tr>
			<td class='forumheader2' style='text-align:center' colspan='3'>".MG_ADMIN_FMANAGER_33." <select name='Category' class='tbox'>";
			$sql->db_Select_gen("SELECT c.cat_name AS cat_name, c.cat_id AS cat_id, c2.cat_name AS cat_parent, c2.cat_id AS cat_parent_id FROM #mg_categories c LEFT JOIN #mg_categories c2 ON (c.cat_category=c2.cat_id)");
			while ($row = $sql->db_Fetch()){
				$text .= "<option value='".$row['cat_id']."'>".($row['cat_parent_id'] != 1 && $row['cat_parent_id'] != 0 ? $row['cat_parent']." &rarr; " : "").$row['cat_name']."</option>";
			}
			$text .= "</select></td>
			</tr>";
			for ($I=0; $I<count($Files); $I++){
				list($File) = $admin->RenderFileInfo($Dirs[$MgPage]['dir'].$Files[$I]);
				$text .= "<tr>
				<td class='forumheader3' style='width:5%'><input type='checkbox' id='action".$I."' name='Files[".$I."][add]' class='tbox' value='1' />
				<input type='hidden' name='Files[".$I."][file]' value='".$Files[$I]."' /></td>
				<td class='forumheader3' style='width:80%;'><table style='width:100%;'>
				<tr>
				<td style='text-align:left; vertical-align:top; width:20%;'>".MG_ADMIN_FMANAGER_34."</td>
				<td style='width:80%;'><input type='text' class='tbox' name='Files[".$I."][name]' value='".preg_replace("/\.[a-z0-9]{2,4}$/i", "", $Files[$I])."' maxlength='100' style='width:100%;' /></td>
				</tr><tr>
				<td style='text-align:left; vertical-align:top;'>".MG_ADMIN_FMANAGER_35."</td>
				<td><textarea name='Files[".$I."][description]' class='tbox' rows='3' style='width:100%;'></textarea></td>
				</tr>
				</table></td>
				<td class='forumheader3' style='width:15%; text-align:center;'>
				<a href='".e_GALLERY."admin_view.php?".rawurlencode(substr($Dirs[$MgPage]['dir'], strlen(e_FILEDIR)).$Files[$I])."'>
				<img src='".e_GALLERY."showthumb.php?".rawurlencode($File)."' title='".MG_ADMIN_FMANAGER_20."' alt='' style='border:0px;' />
				</a>
				</td>
				</tr>";
			}
			$text .= "<td colspan='3' class='forumheader3' style='text-align:center;'>
			<input type='button' class='button' name='check' value='".MG_ADMIN_FMANAGER_21."' onclick='CheckBox(".count($Files).", 1)' />
			<input type='button' class='button' name='uncheck' value='".MG_ADMIN_FMANAGER_22."' onclick='CheckBox(".count($Files).", 0)' />
			</td>
			</tr><tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'>
			<input type='hidden' name='Directory' value='".$Dirs[$MgPage]['dir']."' />
			<input type='submit' name='add' class='button' value='".MG_ADMIN_FMANAGER_36."' />
			</td>
			</tr>
			</form>";
		}else{
			$text .= "<tr>
			<td class='forumheader3' style='text-align:center;' colspan='3'>".MG_ADMIN_FMANAGER_24."</td>
			</tr>";
		}
		break;
}
$text .= "</table>
</div>";
$ns->tablerender(MG_ADMIN_FMANAGER_37, $text);
require_once(e_ADMIN."footer.php");

?>