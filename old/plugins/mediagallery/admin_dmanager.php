<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_dmanager.php                               |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем администраторский заголовок
require(dirname(__FILE__)."/admin.php");

require_once(e_ADMIN."auth.php");

// Поверяем права на директорию /e107_files/
clearstatcache();
$ScriptOwner = fileowner(__FILE__);
$RootPerms = substr(decoct(fileperms(realpath(e_FILE))), -3);
$RootOwner = fileowner(realpath(e_FILE));
if ($RootPerms != 777 && ($RootPerms != 755 || ($RootPerms == 755 && $ScriptOwner != $RootOwner))){
	$text = "<div style='text-align:center;'>".sprintf(MG_ADMIN_DMANAGER_1, "CHMOD ".($ScriptOwner == $RootOwner ? "755" : "777"), "<b>".substr(e_FILE, 6)."</b>")."</div>";
	$ns->tablerender(MG_ADMIN_DMANAGER_2, $text);
	require_once(e_ADMIN."footer.php");
	exit;
}

// Создаём отсутствующие директории и устанавливаем права
if (!file_exists(e_FILEDIR)){
	array_unshift($MgDirsList, e_FILEDIR);
}else{
	if (!is_writable(e_FILEDIR) || !is_readable(e_FILEDIR)){
		$OwnerId = fileowner(e_FILEDIR);
		@chmod(e_FILEDIR, octdec($OwnerId == $ScriptOwner ? 755 : 777));
	}
}
foreach ($MgDirsList as $Dir){
	if (!file_exists($Dir)){
		umask(0000);
		@mkdir($Dir);
		@touch($Dir."index.html");
		$OwnerId = fileowner($Dir);
		if ($OwnerId == $ScriptOwner){
			@chmod($Dir, octdec(755));
		}
		continue;
	}elseif (!is_writable($Dir) || !is_readable($Dir)){
		$OwnerId = fileowner($Dir);
		@chmod($Dir, octdec($OwnerId == $ScriptOwner ? 755 : 777));
	}else{
		$OwnerId = fileowner($Dir);
		if ($OwnerId == $ScriptOwner){
			@chmod($Dir, octdec(755));
		}
	}
}

// Выводим информацию о директориях
$text = "<div style='text-align:center;'>
<table style='width:95%;' class='fborder'>
<tr>
<td class='forumheader' style='text-align:center; width:5%;'>&nbsp;</td>
<td class='forumheader' style='text-align:center; width:60%;'>".MG_ADMIN_DMANAGER_3."</td>
<td class='forumheader' style='text-align:center; width:20%;'>".MG_ADMIN_DMANAGER_4."</td>
<td class='forumheader' style='text-align:center; width:15%; white-space:nowrap;'>".MG_ADMIN_DMANAGER_5."</td>
</tr>";
clearstatcache();
foreach ($MgDirsList as $Dir){
	$OwnerId = fileowner($Dir);
	$Path = realpath($Dir);
	$Perms = substr(decoct(fileperms($Path)), -3);
	$text .= "<tr>";
	if (file_exists($Path) && is_dir($Path) && ($Perms == 777 || ($Perms == 755 && $ScriptOwner == $OwnerId))){
		$text .= "<td class='forumheader3'><img src='".e_GALLERY."images/icons/passed_icon.png' title='".MG_ADMIN_DMANAGER_6."' alt='' /></td>
		<td class='forumheader3'>".substr($Dir, 6)."</td>";
		if (!SAFE_MODE && extension_loaded("posix")){
			$Owner = posix_getpwuid($OwnerId);
			$Owner = $Owner['name'];
		}else{
			$Owner = MG_ADMIN_DMANAGER_7." (ID: ".$OwnerId.")";
		}
		$text .= "<td class='forumheader3' style='text-align:center; white-space:nowrap;'>".$Owner."</td>
		<td class='forumheader3' style='text-align:center;'>".$Perms."</td>";
	}elseif (file_exists($Path) && is_dir($Path) && ($Perms != 777 && ($Perms != 755 || ($Perms == 755 && $ScriptOwner != $OwnerId)))){
		$text .= "<td class='forumheader3'><img src='".e_GALLERY."images/icons/failed_icon.png' title='".MG_ADMIN_DMANAGER_8."' alt='' /></td>
		<td class='forumheader3'>".substr($Dir, 6)."</td>
		<td class='forumheader3' style='text-align:center; white-space:nowrap;'>".$Owner."</td>
		<td class='forumheader3' style='text-align:center;'><font color='#ff0000'>".$Perms."</font></td>";
		$Failed[0] = TRUE;
	}else{
		@unlink($Path);
		$text .= "<td class='forumheader3'><img src='".e_GALLERY."images/icons/failed_icon.png' title='".MG_ADMIN_DMANAGER_8."' alt='' /></td>
		<td class='forumheader3'>".substr($Dir, 6)."</td>
		<td class='forumheader3' colspan='2' style='text-align:center;'><font color='#ff0000'>".MG_ADMIN_DMANAGER_9."</font></td>";
		$Failed[1] = TRUE;
	}
	$text .= "</tr>";
}
if (count($Failed)){
	$text .= "<tr>
	<td class='forumheader2' colspan='4'>".MG_ADMIN_DMANAGER_10."<ul>".($Failed[1] ? "<li>".sprintf(MG_ADMIN_DMANAGER_11, "CHMOD 777") : "").($Failed[0] ? "<li>".sprintf(MG_ADMIN_DMANAGER_12, "CHMOD 777") : "")."</ul></td>
	</tr>";
}
$text .= "</table>
</div>";
$ns->tablerender(MG_ADMIN_DMANAGER_2, $text);
require_once(e_ADMIN."footer.php");

?>