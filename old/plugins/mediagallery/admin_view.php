<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_view.php                                   |
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
if (is_numeric(e_QUERY)){
	$MgId = intval(e_QUERY);
	$MgPath = FALSE;
}else{
	$MgPath = rawurldecode(e_QUERY);
	$MgId = FALSE;
}
unset($Tmp);

// Проверяем состояние директорий
$admin->CheckDirPerms(e_UPLOAD, e_TEMP, e_IMAGES, e_MEDIA, e_CTHUMBS, e_MTHUMBS, e_WMARKS);

// Проверка состояния библиотеки GD
$admin->CheckGD();

// Проверка возможности работы с URL-файлами
$admin->CheckURL();

// Выводим собранную информацию на экран
require_once(e_ADMIN."auth.php");
require(e_GALLERY."classes/resize.class.php");
$res = new Resizer;
$NewSize = explode("*", $pref['mg_thumb_size']);
$text = "<div style='text-align:center;'>
<table class='fborder' style='width:95%;'>";
if ($MgId){
	if (!$sql->db_Select("mg_images", "*", "img_id = '".$MgId."'")){
		$admin->RenderAlert(MG_ADMIN_VIEW_6);
	}
	$row = $sql->db_Fetch();
	$text .= "<tr>
	<td class='forumheader' style='text-align:center;'>".$row['img_name']."</td>
	</tr><tr>
	<td class='forumheader3' style='text-align:center;'>";
	if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
		$text .= ViewImage($row, "db");
	}elseif ($row['img_type'] == "video"){
		$text .= ViewVideo($row, "db");
	}else{
		$text .= ViewAudio($row, "db");
	}
	$text .= "</td>
	</tr><tr>
	<td class='forumheader3' style='text-align:center;'>
	<table style='width:100%;'>
	<tr>
	<td style='text-align:left;'>";
	$Datestamp = $row['img_datestamp'];
	$Category = $row['img_category'];
	if ($sql->db_Select("mg_images", "img_id, img_type, img_thumb", "img_datestamp > '".$Datestamp."' AND img_category = '".$Category."' ORDER BY img_datestamp ASC LIMIT 0, 1")){
		$row = $sql->db_Fetch();
		$OldSize = @getimagesize($admin->GetFilePath($row['img_thumb'], ($row['img_type'] == "video" || $row['img_type'] == "audio" ? e_MTHUMBS : e_IMAGES)));
		$Size = $res->CalculateSize($OldSize[0], $OldSize[1], $NewSize[0], $NewSize[1]);
		$text .= "<input class='button' type='button' id='prevbutton' name='prevbutton' value='&lsaquo; ".MG_ADMIN_VIEW_1."' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_view.php?".$row['img_id'])."' onmouseover='ShowTooltip(\"prev\")' onmouseout='HideTooltip()' />
		<div id='prevtooltip' style='visibility:hidden; position:absolute; z-index:101; border: 1px solid #000000; width:".$Size[0]."px; height:".$Size[1]."px; left:-1000px;'><img src='".e_GALLERY."showthumb.php?".$row['img_id']."' alt='' /></div>";
	}else{
		$text .= "<input class='button' type='button' value='&lsaquo; ".MG_ADMIN_VIEW_1."' disabled />";
	}
	$text .= "</td>
	<td style='text-align:center;'><input class='button' type='button' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_browse.php".($Category == 1 ? "" : "?".$Category))."' value='".MG_ADMIN_VIEW_2."' title='".MG_ADMIN_VIEW_3."' /></td>
	<td style='text-align:right;'>";
	if ($sql->db_Select("mg_images", "img_id, img_type, img_thumb", "img_datestamp < '".$Datestamp."' AND img_category = '".$Category."' ORDER BY img_datestamp DESC LIMIT 0, 1")){
		$row = $sql->db_Fetch();
		$OldSize = @getimagesize($admin->GetFilePath($row['img_thumb'], ($row['img_type'] == "video" || $row['img_type'] == "audio" ? e_MTHUMBS : e_IMAGES)));
		$Size = $res->CalculateSize($OldSize[0], $OldSize[1], $NewSize[0], $NewSize[1]);
		$text .= "<input class='button' type='button' id='nextbutton' name='nextbutton' value='".MG_ADMIN_VIEW_4." &rsaquo;' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_view.php?".$row['img_id'])."' onmouseover='ShowTooltip(\"next\")' onmouseout='HideTooltip()' />
		<div id='nexttooltip' style='visibility:hidden; position:absolute; z-index:101; border: 1px solid #000000; width:".$Size[0]."px; height:".$Size[1]."px; left:-1000px;'><img src='".e_GALLERY."showthumb.php?".$row['img_id']."' alt='' /></div>";
	}else{
		$text .= "<input class='button' type='button' value='".MG_ADMIN_VIEW_4." &rsaquo;' disabled />";
	}
	$text .= "</td>
	</tr>
	</table>
	</td>
	</tr>";
}else{
	$File = explode("/", $MgPath);
	$FilesList = $admin->GetFilesList(e_FILEDIR.$File[0]."/", $MgFilesList);
	$Key = array_search($File[1], $FilesList);
	if ($Key === FALSE){
		$admin->RenderAlert(MG_ADMIN_VIEW_6);
	}
	$NextKey = $Key+1;
	$PrevKey = $Key-1;
	$text .= "<tr>
	<td class='forumheader' style='text-align:center;'>".preg_replace("/\.[a-z0-9]{2,4}$/i", "", $File[1])."</td>
	</tr><tr>
	<td class='forumheader3' style='text-align:center;'>";
	if ($admin->IsSupported($File[1], "MgImageList")){
		$text .= ViewImage($File, "fm");
	}elseif ($admin->IsSupported($File[1], "MgAudioList")){
		$text .= ViewAudio($File, "fm");
	}else{
		$text .= ViewVideo($File, "fm");
	}
	$text .= "</td>
	</tr><tr>
	<td class='forumheader3' style='text-align:center;'>
	<table style='width:100%;'>
	<tr>
	<td style='text-align:left;'>";
	if (array_key_exists($PrevKey, $FilesList)){
		if ($admin->IsSupported($FilesList[$PrevKey], "MgImageList")){
			$Image = e_FILEDIR.$File[0]."/".$FilesList[$PrevKey];
			$OldSize = @getimagesize($Image);
			$Size = $res->CalculateSize($OldSize[0], $OldSize[1], $NewSize[0], $NewSize[1]);
		}else{
			$Image = e_GALLERY."images/".$admin->GetExtension($FilesList[$PrevKey])."_thumb.png";
			$Size = array(54, 70);
		}
		$text .= "<input class='button' type='button' id='prevbutton' name='prevbutton' value='&lsaquo; ".MG_ADMIN_VIEW_1."' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_view.php?".rawurlencode($File[0]."/".$FilesList[$PrevKey]))."' onmouseover='ShowTooltip(\"prev\")' onmouseout='HideTooltip()' />
		<div id='prevtooltip' style='visibility:hidden; position:absolute; z-index:101; border: 1px solid #000000; width:".$Size[0]."px; height:".$Size[1]."px; left:-1000px;'><img src='".e_GALLERY."showthumb.php?".rawurlencode($Image)."' alt='' /></div>";
	}else{
		$text .= "<input class='button' type='button' value='&lsaquo; ".MG_ADMIN_VIEW_1."' disabled />";
	}
	$Dir = array_search(e_FILEDIR.$File[0]."/", $MgDirsList);
	$text .= "</td>
	<td style='text-align:center;'><input class='button' type='button' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_fmanager.php?0.".$Dir)."' value='".MG_ADMIN_VIEW_2."' title='".MG_ADMIN_VIEW_5."' /></td>
	<td style='text-align:right;'>";
	if (array_key_exists($NextKey, $FilesList)){
		if($admin->IsSupported($FilesList[$NextKey], "MgImageList")){
			$Image = e_FILEDIR.$File[0]."/".$FilesList[$NextKey];
			$OldSize = @getimagesize($Image);
			$Size = $res->CalculateSize($OldSize[0], $OldSize[1], $NewSize[0], $NewSize[1]);
		}else{
			$Image = e_GALLERY."images/".$admin->GetExtension($FilesList[$NextKey])."_thumb.png";
			$Size = array(54, 70);
		}
		$text .= "<input class='button' type='button' id='nextbutton' name='nextbutton' value='".MG_ADMIN_VIEW_4." &rsaquo;' onclick='".$admin->RenderRedirectOnClick(e_GALLERY."admin_view.php?".rawurlencode($File[0]."/".$FilesList[$NextKey]))."' onmouseover='ShowTooltip(\"next\")' onmouseout='HideTooltip()' />
		<div id='nexttooltip' style='visibility:hidden; position:absolute; z-index:101; border: 1px solid #000000; width:".$Size[0]."px; height:".$Size[1]."px; left:-1000px;'><img src='".e_GALLERY."showthumb.php?".rawurlencode($Image)."' alt='' /></div>";
	}else{
		$text .= "<input class='button' type='button' value='".MG_ADMIN_VIEW_4." &rsaquo;' disabled />";
	}
	$text .= "</td>
	</tr>
	</table>
	</td>
	</tr>";
}
$text .= "</table>
</div>";
$ns->tablerender(MG_ADMIN_VIEW_7, $text);
require_once(e_ADMIN."footer.php");

// Выводим на экран изображение
function ViewImage($Row, $Mode){
	global $pref, $admin;
	switch ($Mode){
		case "db":
			if (!$Path = $admin->GetImagePath($Row)){
				$text = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_ADMIN_VIEW_8."' alt='' />";
			}else{
				$text = "<img src='".$Path."' title='".$admin->RenderImageInfo($Row)."' alt='' />";
			}
			break;
		case "fm":
			$text .= "<img src='".e_GALLERY."showimage.php?".rawurlencode(e_FILEDIR.$Row[0]."/".$Row[1])."' title='".$Row[1]."' alt='' />";
			break;
	}
	return $text;
}

// Проигрываем видео ролик
function ViewVideo($Row, $Mode){
	global $pref, $admin;
	switch ($Mode){
		case "db":
			$Path = $admin->GetMediaPath($Row);
			$Type = $admin->GetExtension($Row['img_image']);
			break;
		case "fm":
			if ($admin->IsValidName($Row[1])){
				$Path = e_FILEDIR.$Row[0]."/".$Row[1];
			}else{
				$Path = e_GALLERY."showimage.php?".rawurlencode(e_FILEDIR.$Row[0]."/".$Row[1]);
			}
			$Type = $admin->GetExtension($Row[1]);
			break;
	}
	$Size = explode("*", $pref['mg_view_size']);
	if (!$Path){
		$text = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_ADMIN_VIEW_8."' alt='' />";
	}else{
		switch ($Type){
			case "mov":
				$text = "<object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' codebase='http://www.apple.com/qtactivex/qtplugin.cab' width='".$Size[0]."' height='".($Size[1]+16)."'>
				<param name='src' value='".$Path."' />
				<param name='autoplay' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controller' value='true' />
				<param name='loop' value='true' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' width='".$Size[0]."' height='".($Size[1]+16)."' autoplay='".($pref['mg_view_autoplay'] ? "true" : "false")."' controller='true' loop='true' bgcolor='".$pref['mg_view_bgcolor']."' pluginspage='http://www.apple.com/quicktime/download/'></embed>
				</object>";
				break;
			case "rv":
				$text = "<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='".$Size[0]."' height='".$Size[1]."'>
				<param name='src' value='".$Path."' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controls' value='imagewindow' />
				<param name='console' value='video' />
				<param name='loop' value='true' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' width='".$Size[0]."' height='".$Size[1]."' loop='true' bgcolor='".$pref['mg_view_bgcolor']."' type='audio/x-pn-realaudio-plugin' controls='imagewindow' console='video' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."'></embed>
				</object>
				<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='".$Size[0]."' height='30'>
				<param name='src' value='".$Path."' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controls' value='controlpanel' />
				<param name='console' value='video' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<embed src='".$Path."' width='".$Size[0]."' height='30' controls='controlpanel' bgcolor='".$pref['mg_view_bgcolor']."' type='audio/x-pn-realaudio-plugin' console='video' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."'></embed>
				</object>
				<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='".$Size[0]."' height='30'>
				<param name='src' value='".$Path."' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controls' value='statusbar' />
				<param name='console' value='video' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<embed src='".$Path."' width='".$Size[0]."' height='30' controls='statusbar' type='audio/x-pn-realaudio-plugin' bgcolor='".$pref['mg_view_bgcolor']."' console='video' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."'></embed>
				</object>";
				break;
			case "swf":
				$text = "<object width='".$Size[0]."' height='".$Size[1]."'>
				<param name='menu' value='false' />
				<param name='scale' value='noscale' />
				<param name='movie' value='".$Path."' />
				<param name='quality' value='high' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' menu='false' scale='noscale' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='".$Size[0]."' height='".$Size[1]."' bgcolor='".$pref['mg_view_bgcolor']."'></embed>
				</object>";
				break;
			default:
				$text = "<object id='mediaPlayer' classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95' width='".$Size[0]."' height='".($Size[1]+70)."' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701' standby='".MG_ADMIN_VIEW_10."' type='application/x-oleobject'>
				<param name='filename' value='".$Path."' />
				<param name='animationatstart' value='true' />
				<param name='transparentatstart' value='true' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='showcontrols' value='true' />
				<param name='loop' value='true' />
				<param name='showstatusbar' value='true' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' type='application/x-mplayer2' width='".$Size[0]."' height='".($Size[1]+70)."' pluginspage='http://microsoft.com/windows/mediaplayer/en/download/' id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' bgcolor='".$pref['mg_view_bgcolor']."' showcontrols='true' showtracker='1' showdisplay='0' showstatusbar='1' videoborder3d='-1' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."' designtimesp='5311' loop='true'></embed>
				</object>";
				break;
		}
	}
	return $text;
}

// Проигрываем аудио файлы
function ViewAudio($Row, $Mode){
	global $pref, $admin;
	switch ($Mode){
		case "db":
			$Path = $admin->GetMediaPath($Row);
			$Type = $admin->GetExtension($Row['img_image']);
			break;
		case "fm":
			if ($admin->IsValidName($Row[1])){
				$Path = e_FILEDIR.$Row[0]."/".$Row[1];
			}else{
				$Path = e_GALLERY."showimage.php?".rawurlencode(e_FILEDIR.$Row[0]."/".$Row[1]);
			}
			$Type = $admin->GetExtension($Row[1]);
			break;
	}
	if (!$Path){
		$text = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_ADMIN_VIEW_8."' alt='' />";
	}else{
		switch ($Type){
			case "ra":
				$text = "<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='300' height='30'>
				<param name='src' value='".$Path."' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controls' value='controlpanel' />
				<param name='console' value='audio' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' width='300' height='30' controls='controlpanel' bgcolor='".$pref['mg_view_bgcolor']."' type='audio/x-pn-realaudio-plugin' console='audio' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."'></embed>
				</object>
				<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='300' height='30'>
				<param name='src' value='".$Path."' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controls' value='statusbar' />
				<param name='console' value='audio' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<embed src='".$Path."' width='300' height='30' controls='statusbar' bgcolor='".$pref['mg_view_bgcolor']."' type='audio/x-pn-realaudio-plugin' console='audio' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."'></embed>
				</object>";
				break;
			case "m4a":
				$text = "<object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' codebase='http://www.apple.com/qtactivex/qtplugin.cab' width='300' height='16'>
				<param name='src' value='".$Path."' />
				<param name='autoplay' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='controller' value='true' />
				<param name='loop' value='false' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' width='300' height='16' autoplay='".($pref['mg_view_autoplay'] ? "true" : "false")."' controller='true' loop='false' bgcolor='".$pref['mg_view_bgcolor']."' pluginspage='http://www.apple.com/quicktime/download/'></embed>
				</object>";
				break;
			default:
				$text = "<object id='mediaPlayer' classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95' width='280' height='67' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701' standby='".MG_ADMIN_VIEW_10."' type='application/x-oleobject'>
				<param name='filename' value='".$Path."' />
				<param name='animationatstart' value='true' />
				<param name='transparentatstart' value='true' />
				<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
				<param name='showcontrols' value='true' />
				<param name='loop' value='false' />
				<param name='showstatusbar' value='true' />
				<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
				<noembed>".MG_ADMIN_VIEW_9."</noembed>
				<embed src='".$Path."' type='application/x-mplayer2' width='280' height='67' pluginspage='http://microsoft.com/windows/mediaplayer/en/download/' id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' bgcolor='".$pref['mg_view_bgcolor']."' showcontrols='1' showtracker='1' showdisplay='0' showstatusbar='1' videoborder3d='-1' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."' designtimesp='5311' loop='false'></embed>
				</object>";
				break;
		}
	}
	return $text;
}

?>