<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_mmanager.php                               |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем администраторский заголовок
require(dirname(__FILE__)."/admin.php");

// Проверяем состояние директорий
$admin->CheckDirPerms(e_UPLOAD, e_TEMP, e_IMAGES, e_MEDIA, e_CTHUMBS, e_MTHUMBS, e_WMARKS, e_FONTS);

// Выводим информацию на экран
require_once(e_ADMIN."auth.php");
$TempSize = $admin->GetDirSize(e_TEMP);
$TotalSize = $admin->GetDirSize(e_FILEDIR);
$Percentage = round($TempSize / $pref['mg_wallpapers_tempsize'] * 100, 2);
if ($Percentage >= 100){
	$text = "<div style='text-align:center;'>
	<table style='width:95%;'>
	<tr>
	<td style='width:40px; vertical-align:center; text-align:center;'><img src='".e_GALLERY."images/icons/important_icon.png' alt='' /></td>
	<td style='vertical-align:center; text-align:left;'>".sprintf(MG_ADMIN_MMANAGER_1, "<a href='".e_GALLERY."admin_fmanager.php?0.1'>".MG_ADMIN_MMANAGER_2."</a>", "<a href='".e_GALLERY."admin_config.php'>".MG_ADMIN_MMANAGER_3."</a>")."</td>
	</tr>
	</table>
	</div>";
	$ns->tablerender(MG_ADMIN_MMANAGER_4, $text);
}elseif ($Percentage > 90){
	$text = "<div style='text-align:center;'>
	<table style='width:95%;'>
	<tr>
	<td style='width: 40px; vertical-align:center; text-align:center;'><img src='".e_GALLERY."images/icons/important_icon.png' /></td>
	<td style='vertical-align:center; text-align:left;'>".sprintf(MG_ADMIN_MMANAGER_5, "90%", "<a href='".e_GALLERY."admin_fmanager.php?0.1'>".MG_ADMIN_MMANAGER_2."</a>")."</td>
	</tr>
	</table>
	</div>";
	$ns->tablerender(MG_ADMIN_MMANAGER_4, $text);
}
$text = "<div style='text-align:center;'>
<table class='fborder' style='width:95%;'>
<tr>
<td style='width: 50%; text-align: center;' class='forumheader'>".MG_ADMIN_MMANAGER_6."</td>
<td style='width: 50%; text-align: center;' class='forumheader'>".MG_ADMIN_MMANAGER_7."</td>
</tr><tr>
<td style='text-align:center;' class='forumheader3'>";
if (is_numeric($pref['mg_wallpapers_tempsize'])){
	$ExtraSize = $pref['mg_wallpapers_tempsize'] - $TempSize;
	if ($TempSize >= $pref['mg_wallpapers_tempsize']){
		$ExtraSize = 0;
	}
	if ($Percentage > 100){
		$Percentage = 100;
	}
	if ($Percentage < 30){
		$Color = "green";
	}elseif ($Percentage < 90){
		$Color = "yellow";
	}else{
		$Color = "red";
	}
	$text .= "<table style='width:100%;'>
	<tr>
	<td style='width:50%; text-align:center;'>
	<table style='border: 1px solid #000000; border-collapse:collapse;'>
	<tr>
	<td style='width:60px; height:100px; vertical-align:bottom; padding:0px; background-color:#ffffff;'>";
	if ($Percentage != 0){
		$text .= "<img src='".e_GALLERY."images/colors/".$Color.".png' alt='' style='width:60px; height:".intval($Percentage)."px; margin:0px;' />";
	}else{
		$text .= "&nbsp;";
	}
	$text .= "</td>
	</tr>
	</table>
	".$Percentage."%</td>
	<td style='width:50%; text-align:center; vertical-align:center;'>
	".MG_ADMIN_MMANAGER_8."<br />".$admin->ReturnSize($pref['mg_wallpapers_tempsize'])."<br /><br />
	".MG_ADMIN_MMANAGER_9."</br />".$admin->ReturnSize($TempSize)."<br /><br />
	".MG_ADMIN_MMANAGER_10."<br />".$admin->ReturnSize($ExtraSize)."
	</td>
	</tr>
	</table>";
}else{
	$text .= MG_ADMIN_MMANAGER_11."<br />".$admin->ReturnSize($TempSize);
}
$text .= "</td>
<td class='forumheader3' style='text-align:center; vertical-align:center;'>
".MG_ADMIN_MMANAGER_12."<br />".$admin->ReturnSize($TotalSize)."
</td>
</tr>
</table>
</div>";
$ns->tablerender(MG_ADMIN_MMANAGER_13, $text);
require_once(e_ADMIN."footer.php");

?>