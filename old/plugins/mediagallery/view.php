<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: view.php                                         |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включение пользовательского заголовка
require(dirname(__FILE__)."/user.php");

// Получаем переменные по ссылке
$MgId = intval($Tmp[0]);
unset($Tmp);

// Проверяем состояние директорий
$user->CheckDirPerms(e_IMAGES, e_MEDIA, e_MTHUMBS, e_TEMP);

// Проверка состояния библиотеки GD
$user->CheckGD();

// Проверка возможности работы с URL-файлами
$user->CheckURL();

// Помещаем комментарий в базу
if (isset($_POST['commentsubmit'])){
	require_once(e_HANDLER."comment_class.php");
	$com = new comment;
	if ($sql->db_Select("mg_images", "img_comments", "img_id = '".$MgId."'")){
		$row = $sql->db_Fetch();
		if ($row[0] && (ANON === TRUE || USER === TRUE)){
			$com->enter_comment($_POST['author_name'], $_POST['comment'], "mgal", $MgId, 0, $_POST['subject']);
		}
	}
}

// Выводим информацию на экран
$Image = $sql->db_Select_gen("SELECT i.*, c.cat_author AS img_category_author, c.cat_user_cat AS img_category_user, IF(c.cat_id = 1, '', c.cat_name) AS img_category_name, IF(c2.cat_id = 1, '', c2.cat_name) AS img_category_category
FROM #mg_images i
LEFT JOIN #mg_categories c ON i.img_category = c.cat_id
LEFT JOIN #mg_categories c2 ON c.cat_category = c2.cat_id
WHERE i.img_id = '".$MgId."' AND c.cat_class_view IN (".USERCLASS_LIST.")");
if (!$Image){
	$user->RenderAlert(MG_VIEW_1);
}
$row = $sql->db_Fetch();
define("e_PAGETITLE", $pref['mg_general_galname']." / ".($row['img_category_category'] ? $row['img_category_category']." / " : "").($row['img_category_name'] ? $row['img_category_name']." / " : "").$row['img_name']);
$MgRow = $row;
require_once(HEADERF);
require_once(e_HANDLER."rate_class.php");
$rate = new rater;
$row = $MgRow;
unset($MgRow);
$sql->db_Update("mg_images", "img_views = img_views + 1 WHERE img_id = '".$row['img_id']."'");
if (file_exists(THEME."view_template.php")){
	require(THEME."view_template.php");
}else{
	require(e_GALLERY."templates/view_template.php");
}
$NAME = $row['img_name'];
$Size = explode("*", $pref['mg_view_size']);
switch ($row['img_type']){
	case "image":
		if (!$Path = $user->GetImagePath($row)){
			$IMAGE = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_VIEW_2."' alt='' />";
		}else{
			if ($row['img_width'] > $Size[0] || $row['img_height'] > $Size[1]){
				$IMAGE = "<a href='#' onclick='window.open(\"".e_GALLERY."request.php?full.".$row['img_id']."\", \"\", \"resizable=yes,width=\"+screen.width+\",height=\"+screen.height+\",left=0,top=0,toolbar=no,scrollbars=yes,location=no,menubar=no,status=no\")'><img src='".$Path."' onerror='this.src=\"".e_GALLERY."/images/errors/unavailable.png\"' title='".MG_VIEW_3."' style='border:0px;' alt='' /></a>";
			}else{
				$IMAGE = "<img src='".$Path."' alt='' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' />";
			}
		}
		break;
	case "video":
		$Type = $user->GetExtension($row['img_image']);
		if (!$Path = $user->GetMediaPath($row)){
			$IMAGE = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_VIEW_2."' alt='' />";
		}else{
			switch ($Type){
				case "mov":
					$IMAGE = "<object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' codebase='http://www.apple.com/qtactivex/qtplugin.cab' width='".$Size[0]."' height='".($Size[1]+16)."'>
					<param name='src' value='".$Path."' />
					<param name='autoplay' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
					<param name='controller' value='true' />
					<param name='loop' value='true' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
					<embed src='".$Path."' width='".$Size[0]."' height='".($Size[1]+16)."' type='video/quicktime' autoplay='".($pref['mg_view_autoplay'] ? "true" : "false")."' controller='true' loop='true' bgcolor='".$pref['mg_view_bgcolor']."' pluginspage='http://www.apple.com/quicktime/download/'></embed>
					</object>";
					break;
				case "rv":
					$IMAGE = "<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='".$Size[0]."' height='".$Size[1]."'>
					<param name='src' value='".$Path."' />
					<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
					<param name='controls' value='imagewindow' />
					<param name='console' value='video' />
					<param name='loop' value='true' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
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
					$IMAGE = "<object width='".$Size[0]."' height='".$Size[1]."'>
					<param name='menu' value='false' />
					<param name='scale' value='noscale' />
					<param name='movie' value='".$Path."' />
					<param name='quality' value='high' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
					<embed src='".$Path."' menu='false' scale='noscale' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='".$Size[0]."' height='".$Size[1]."' bgcolor='".$pref['mg_view_bgcolor']."'></embed>
					</object>";
					break;
				default:
					$IMAGE = "<object id='mediaPlayer' classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95' width='".$Size[0]."' height='".($Size[1]+70)."' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701' standby='".MG_VIEW_5."' type='application/x-oleobject'>
					<param name='filename' value='".$Path."' />
					<param name='animationatstart' value='true' />
					<param name='transparentatstart' value='true' />
					<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
					<param name='showcontrols' value='true' />
					<param name='loop' value='true' />
					<param name='showstatusbar' value='true' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
					<embed src='".$Path."' type='application/x-mplayer2' width='".$Size[0]."' height='".($Size[1]+70)."' pluginspage='http://microsoft.com/windows/mediaplayer/en/download/' id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' bgcolor='".$pref['mg_view_bgcolor']."' showcontrols='true' showtracker='1' showdisplay='0' showstatusbar='1' videoborder3d='-1' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."' designtimesp='5311' loop='true'></embed>
					</object>";
					break;
			}
		}
		break;
	case "wallpaper":
		if (!$Path = $user->GetImagePath($row)){
			$IMAGE = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_VIEW_2."' alt='' />";
		}else{
			$IMAGE = "<img src='".$Path."' alt='' onerror='this.src=\"".e_GALLERY."images/errors/unavailable.png\"' /><br />";
			$ResolutionList = preg_split("/\\r?\\n/", $pref['mg_wallpapers_reslist']);
			foreach ($ResolutionList as $Resolution){
				list($Width, $Height) = explode("*", trim($Resolution));
				if ($row['img_width'] >= $Width && $row['img_height'] >= $Height && $Resolution != ""){
					$IMAGE .= "<a href='".e_GALLERY."request.php?wallpaper.".$row['img_id'].".".rawurlencode(serialize(array($Width, $Height)))."'>".MG_VIEW_6." ".$Resolution."</a><br />";
				}
			}
		}
		break;
	case "audio":
		$Type = $user->GetExtension($row['img_image']);
		if (!$Path = $user->GetMediaPath($row)){
			$IMAGE = "<img src='".e_GALLERY."images/errors/no_image.png' title='".MG_VIEW_2."' alt='' />";
		}else{
			switch ($Type){
				case "ra":
					$IMAGE = "<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='300' height='30'>
					<param name='src' value='".$Path."' />
					<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
					<param name='controls' value='controlpanel' />
					<param name='console' value='audio' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
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
					$IMAGE = "<object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' codebase='http://www.apple.com/qtactivex/qtplugin.cab' width='300' height='16'>
					<param name='src' value='".$Path."' />
					<param name='autoplay' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
					<param name='controller' value='true' />
					<param name='loop' value='false' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
					<embed src='".$Path."' width='300' height='16' autoplay='".($pref['mg_view_autoplay'] ? "true" : "false")."' controller='true' loop='false' bgcolor='".$pref['mg_view_bgcolor']."' pluginspage='http://www.apple.com/quicktime/download/'></embed>
					</object>";
					break;
				default:
					$IMAGE = "<object classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95' width='300' height='67' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701' standby='".MG_VIEW_5."' type='application/x-oleobject'>
					<param name='filename' value='".$Path."' />
					<param name='animationatstart' value='true' />
					<param name='transparentatstart' value='true' />
					<param name='autostart' value='".($pref['mg_view_autoplay'] ? "true" : "false")."' />
					<param name='showcontrols' value='true' />
					<param name='loop' value='false' />
					<param name='showstatusbar' value='true' />
					<param name='bgcolor' value='".$pref['mg_view_bgcolor']."' />
					<noembed>".MG_VIEW_4."</noembed>
					<embed src='".$Path."' type='application/x-mplayer2' width='300' height='67' pluginspage='http://microsoft.com/windows/mediaplayer/en/download/' id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' bgcolor='".$pref['mg_view_bgcolor']."' showcontrols='1' showtracker='1' showdisplay='0' showstatusbar='1' videoborder3d='-1' autostart='".($pref['mg_view_autoplay'] ? "true" : "false")."' designtimesp='5311' loop='false'></embed>
					</object>";
					break;
			}
		}
		break;
}
#$con = new convert;
#$DATESTAMP = $con->convert_date($row['img_datestamp'], "long");
#$DESCRIPTION = $row['img_description'] ? $tp->toHTML($row['img_description'], TRUE) : MG_VIEW_10;
#list($row['img_author_id'], $row['img_author_name']) = explode(".", $row['img_author'], 2);
#$AUTHOR_NAME = $row['img_author_name'];
#if ($row['img_author_id'] != 0){
#	$sql->db_Select("user", "user_email AS img_author_email, user_homepage AS img_author_homepage, user_hideemail", "user_id='".$row['img_author_id']."'");
#	$AUTHOR_PROFILE = "<a href='".e_BASE."user.php?id.".$row['img_author_id']."'><img src='".(file_exists(THEME."forum/profile.png") ? THEME."forum/profile.png" : e_GALLERY."images/actions/profile.png")."' title='".sprintf(MG_VIEW_12, $row['img_author_name'])."' alt='' style='border:0px;' /></a> ";
#	list($row['img_author_email'], $row['img_author_homepage'], $row['user_hideemail']) = $sql->db_Fetch();
#}
if ($row['img_author_email'] && (!$row['user_hideemail'] || ADMIN)){
	$AUTHOR_EMAIL = "<a href='mailto:".$row['img_author_email']."'><img src='".(file_exists(THEME."forum/email.png") ? THEME."forum/email.png" : e_GALLERY."images/actions/email.png")."' title='".sprintf(MG_VIEW_13, $row['img_author_name'])."' alt='' style='border:0px;' /></a> ";
}
if ($row['img_author_homepage']){
	$AUTHOR_HOMEPAGE = "<a href='".$row['img_author_homepage']."'><img src='".(file_exists(THEME."forum/website.png") ? THEME."forum/website.png" : e_GALLERY."images/actions/website.png")."' title='".sprintf(MG_VIEW_14, $row['img_author_name'])."' alt='' style='border:0px;' /></a>";
}
$VIEWS = $row['img_views'];
if ($pref['mg_view_download']){
	$OPTION_DOWNLOAD =  "<a href='".e_GALLERY."request.php?download.".$row['img_id']."'><img src='".(file_exists(THEME."generic/download.png") ? THEME."generic/download.png" : e_GALLERY."images/actions/download.png")."' title='".MG_VIEW_6."' alt='' style='border:0px;' /></a> ";
}
if ($row['img_email_print']){
	if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
		$OPTION_EMAIL_PRINT = "<a href='".e_GALLERY."print.php?".$row['img_id']."'><img src='".(defined("ICONPRINT") && file_exists(THEME."images/".ICONPRINT) ? THEME."images/".ICONPRINT : e_GALLERY."images/actions/print.png")."' title='".MG_VIEW_17."' alt='' style='border:0px;' /></a> <a href='".e_GALLERY."email.php?".$row['img_id']."'><img src='".(defined("ICONMAIL") && file_exists(THEME."images/".ICONMAIL) ? THEME."images/".ICONMAIL : e_GALLERY."images/actions/send.png")."' title='".MG_VIEW_18."' alt='' style='border:0px;' /></a> ";
	}else{
		$OPTION_EXTERNAL = "<a href='".e_GALLERY."request.php?external.".$row['img_id']."'><img src='".e_GALLERY."images/actions/external.png' title='".MG_VIEW_19."' alt='' style='border:0px;' /></a> ";
	}
}
if ($row['img_type'] == "image" || $row['img_type'] == "wallpaper"){
	$Page = "image";
}else{
	$Page = "media";
}
if (getperms("P")){
	$OPTION_ADMIN = "<a href='".e_GALLERY."admin_".$Page.".php?edit.".$row['img_id']."'><img src='".e_GALLERY."images/actions/edit.png' title='".MG_VIEW_20."' alt='' style='border:0px;' /></a> <a href='".e_GALLERY."admin_".$Page.".php?delete.".$row['img_id']."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_VIEW_21."' alt='' style='border:0px;' /></a>";
}elseif ($row['img_category_user'] && $row['img_category_author'] == USERID.".".USERNAME){
	$OPTION_ADMIN = "<a href='".e_GALLERY.$Page.".php?edit.".$row['img_id']."'><img src='".e_GALLERY."images/actions/edit.png' title='".MG_VIEW_20."' alt='' style='border:0px;' /></a> <a href='".e_GALLERY.$Page.".php?delete.".$row['img_id']."' onclick='".$user->RenderConfirmOnClick(sprintf(MG_VIEW_22, $row['img_name']))."'><img src='".e_GALLERY."images/actions/delete.png' title='".MG_VIEW_21."' alt='' style='border:0px;' /></a>";
}
#if ($ratearray = $rate->getrating("mgal", $MgId)){
#	for ($i=1; $i<=$ratearray[1]; $i++){
#		$RATING .= "<img src='".e_IMAGE."rate/star.png' align='absmiddle' />";
#	}
#	if ($ratearray[2]){
#		$RATING .= "<img src='".e_IMAGE."rate/".$ratearray[2].".png' align='absmiddle' />";
#	}
#	if ($ratearray[2] == ""){
#		$ratearray[2] = 0;
#	}
#	$RATING .= " ".$ratearray[1].".".$ratearray[2]." - ".$ratearray[0]." ".($ratearray[0] == 1 ? MG_VIEW_23 : MG_VIEW_24);
#}else{
#	$RATING = MG_VIEW_25;
#}
#if (!$rate->checkrated("mgal", $row['img_id']) && USER){
#	$RATING .= $rate->rateselect("", "mgal", $row['img_id']);
#}
$NewSize = explode("*", $pref['mg_thumb_size']);
require(e_GALLERY."classes/resize.class.php");
$res = new Resizer;
if ($sql->db_Select("mg_images", "img_id, img_type, img_thumb", "img_datestamp > '".$row['img_datestamp']."' AND img_category = '".$row['img_category']."' ORDER BY img_datestamp ASC LIMIT 1")){
	$row2 = $sql->db_Fetch();
	$OldSize = @getimagesize($user->GetFilePath($row2['img_thumb'], ($row2['img_type'] == "video" || $row2['img_type'] == "audio" ? e_MTHUMBS : e_IMAGES)));
	$Size = $res->CalculateSize($OldSize[0], $OldSize[1], $NewSize[0], $NewSize[1]);
	$PREVBUTTON = "<input class='button' type='button' id='prevbutton' name='prevbutton' value='&lsaquo; ".MG_VIEW_27."' onclick='".$user->RenderRedirectOnClick(e_GALLERY."view.php?".$row2['img_id'])."' onmouseover='ShowTooltip(\"prev\")' onmouseout='HideTooltip()' />
	<div id='prevtooltip' style='visibility:hidden; position:absolute; z-index:101; padding:0px; border:0px; width:".$Size[0]."px; height:".$Size[1]."px; left:-1000px;'>";
	$ICON = "<img src='".e_GALLERY."showthumb.php?".$row2['img_id']."' style='width:".$Size[0]."px; height:".$Size[1]."px;' alt='' />";
	$WIDTH = $Size[0]."px";
	$HEIGHT = $Size[1]."px";
	$PREVBUTTON .= preg_replace("/\{(.*?)\}/e", '$\1', $ICONTOOLTIP);
	$PREVBUTTON .= "</div>";
}else{
	$PREVBUTTON = "<input class='button' type='button' value='&lsaquo; ".MG_VIEW_27."' disabled />";
}
#$BACKBUTTON = "<input class='button' type='button' onclick='".$user->RenderRedirectOnClick(e_GALLERY."browse.php".($row['img_category'] == 1 ? "" : "?".$row['img_category']))."' value='".MG_VIEW_28."' title='".MG_VIEW_29."' />";
if ($sql->db_Select("mg_images", "img_id, img_type, img_thumb", "img_datestamp < '".$row['img_datestamp']."' AND img_category = '".$row['img_category']."' ORDER BY img_datestamp DESC LIMIT 1")){
	$row2 = $sql->db_Fetch();
	$OldSize = @getimagesize($user->GetFilePath($row2['img_thumb'], ($row2['img_type'] == "video" || $row2['img_type'] == "audio" ? e_MTHUMBS : e_IMAGES)));
	$Size = $res->CalculateSize($OldSize[0], $OldSize[1], $NewSize[0], $NewSize[1]);
	$NEXTBUTTON = "<input class='button' type='button' id='nextbutton' name='nextbutton' value='".MG_VIEW_30." &rsaquo;' onclick='".$user->RenderRedirectOnClick(e_GALLERY."view.php?".$row2['img_id'])."' onmouseover='ShowTooltip(\"next\")' onmouseout='HideTooltip()' />
	<div id='nexttooltip' style='visibility:hidden; position:absolute; z-index:101; padding:0px; border:0px; width:".$Size[0]."px; height:".$Size[1]."px; left:-1000px;'>";
	$ICON = "<img src='".e_GALLERY."showthumb.php?".$row2['img_id']."' style='width:".$Size[0]."px; height:".$Size[1]."px;' alt='' />";
	$WIDTH = $Size[0]."px";
	$HEIGHT = $Size[1]."px";
	$NEXTBUTTON .= preg_replace("/\{(.*?)\}/e", '$\1', $ICONTOOLTIP);
	$NEXTBUTTON .= "</div>";
}else{
	$NEXTBUTTON = "<input class='button' type='button' value='".MG_VIEW_30." &rsaquo;' disabled />";
}
$text = preg_replace("/\{(.*?)\}/e", '$\1', $TABLE);
$ns->tablerender($pref['mg_general_galname'], $text);
if ($row['img_comments']){
	require_once(e_HANDLER."comment_class.php");
	$com = new comment;
	$Query = $pref['nested_comments'] ? "comment_item_id='".$row['img_id']."' AND comment_type = 'mgal' AND comment_pid = 0 ORDER BY comment_datestamp" : "comment_item_id = '".$row['img_id']."' AND comment_type = 'mgal' ORDER BY comment_datestamp";
	$TotalComments = $sql->db_Select("comments", "*",  $Query);
	if ($TotalComments){
		$text = "";
		while ($row2 = $sql->db_Fetch()){
			if ($pref['nested_comments']){
				$text .= $com->render_comment($row2, "mgal", "comment", $row['img_id'], "", $row['img_name']);
				$ns->tablerender(MG_VIEW_31, $text);
			}else{
				$text .= $com->render_comment($row2, "mgal", "comment", $row['img_id'], "", $row['img_name']);
			}
		}
		if (!$pref['nested_comments']){
			$ns->tablerender(MG_VIEW_31, $text);
		}
	}
	if (getperms("B") && $TotalComments){
		echo "<div style='text-align:right;'><a href='".e_ADMIN."modcomment.php?mgal.".$row['img_id']."'>".MG_VIEW_32."</a></div><br />";
	}elseif ($row['img_category_user'] && $row['img_category_author'] == USERID.".".USERNAME && $TotalComments){
		echo "<div style='text-align:right;'><a href='".e_GALLERY."comment.php?".$row['img_id']."'>".MG_VIEW_32."</a></div><br />";
	}
	$com->form_comment("comment", "mgal", $row['img_id'], $row['img_name'], "mgal");
}
require_once(FOOTERF);

?>
