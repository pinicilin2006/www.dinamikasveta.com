<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin_readme.php                                 |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// Включаем администраторский заголовок
require(dirname(__FILE__)."/admin.php");

// Выводим информацию на экран
require_once(e_ADMIN."auth.php");
$text = "<div style='text-align:left;'>
<a href='#1'><strong>".strtoupper(MG_ADMIN_README_1)."</strong></a><br />
<a href='#2'><strong>".strtoupper(MG_ADMIN_README_2)."</strong></a><br />
<a href='#3'><strong>".strtoupper(MG_ADMIN_README_3)."</strong></a><br />
<a href='#4'><strong>".strtoupper(MG_ADMIN_README_26)."</strong></a><br />
<br /><br />
<div name='1' id='1'><strong>1. ".strtoupper(MG_ADMIN_README_1)."</strong></div>
<br />
<div style='margin-left:15px;'>
<strong>1.1 ".MG_ADMIN_README_5."</strong>
<br /><br />
<ul type='square'>
<li>".MG_ADMIN_README_6."</li>
<li>".sprintf(MG_ADMIN_README_7, "<i>".implode("</i>, <i>", $MgVideoList)."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_8, "<i>".implode("</i>, <i>", $MgAudioList)."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_9, "<i>".implode("</i>, <i>", $MgImageList)."</i>")."</li>
<li>".MG_ADMIN_README_10."</li>
<li>".MG_ADMIN_README_11."</li>
<li>".MG_ADMIN_README_12."</li>
<li>".MG_ADMIN_README_13."</li>
<li>".MG_ADMIN_README_14."</li>
<li>".MG_ADMIN_README_15."</li>
<li>".MG_ADMIN_README_16."</li>
<li>".MG_ADMIN_README_172."</li>
<li>".MG_ADMIN_README_17."</li>
<li>".MG_ADMIN_README_18."</li>
<li>".MG_ADMIN_README_19."</li>
<li>".MG_ADMIN_README_20."</li>
<li>".MG_ADMIN_README_21."</li>
<li>".MG_ADMIN_README_22."</li>
<li>".MG_ADMIN_README_23."</li>
<li>".sprintf(MG_ADMIN_README_24, "<i>http</i>", "<i>ftp</i>")."</li>
<li>".MG_ADMIN_README_25."</li>
<li>".MG_ADMIN_README_58."</li>
<li>".MG_ADMIN_README_59."</li>
<li>".MG_ADMIN_README_63."</li>
</ul>
<br /><br />
<strong>1.2 ".MG_ADMIN_README_27."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_28, "1.1 (07.11.05)")."</li>
<br /><br />
<ol>
<li>".MG_ADMIN_README_29."</li>
</ol><br />
<li>".sprintf(MG_ADMIN_README_28, "1.2 (20.11.05)")."</li>
<br /><br />
<ol>
<li>".MG_ADMIN_README_30."</li>
<li>".MG_ADMIN_README_31."</li>
<li>".MG_ADMIN_README_32."</li>
<li>".MG_ADMIN_README_33."</li>
<li>".MG_ADMIN_README_34."</li>
<li>".MG_ADMIN_README_35."</li>
<li>".MG_ADMIN_README_36."</li>
<li>".MG_ADMIN_README_37."</li>
<li>".MG_ADMIN_README_38."</li>
<li>".MG_ADMIN_README_39."</li>
<li>".MG_ADMIN_README_40."</li>
</ol><br />
<li>".sprintf(MG_ADMIN_README_28, "1.3 (10.06.06)")."</li>
<br /><br />
<ol>
<li>".MG_ADMIN_README_51."</li>
<li>".MG_ADMIN_README_53."</li>
<li>".sprintf(MG_ADMIN_README_41, "<i>.rv</i>, <i>.divx</i>", "<i>.ra</i>, <i>.m4a</i>", "<i>.bmp</i>")."</li>
<li>".MG_ADMIN_README_42."</li>
<li>".MG_ADMIN_README_43."</li>
<li>".MG_ADMIN_README_44."</li>
<li>".MG_ADMIN_README_45."</li>
<li>".MG_ADMIN_README_46."</li>
<li>".MG_ADMIN_README_47."</li>
<li>".MG_ADMIN_README_48."</li>
<li>".sprintf(MG_ADMIN_README_49, "<i>http</i>", "<i>ftp</i>")."</li>
<li>".MG_ADMIN_README_50."</li>
<li>".MG_ADMIN_README_52."</li>
<li>".MG_ADMIN_README_54."</li>
<li>".MG_ADMIN_README_55."</li>
<li>".MG_ADMIN_README_56."</li>
<li>".MG_ADMIN_README_57."</li>
<li>".MG_ADMIN_README_60."</li>
<li>".MG_ADMIN_README_61."</li>
<li>".MG_ADMIN_README_62."</li>
</ol><br />
<li>".sprintf(MG_ADMIN_README_28, "1.4 (14.07.06)")."</li>
<br /><br />
<ol>
<li>".MG_ADMIN_README_167."</li>
<li>".MG_ADMIN_README_168."</li>
<li>".MG_ADMIN_README_169."</li>
<li>".MG_ADMIN_README_170."</li>
<li>".MG_ADMIN_README_171."</li>
<li>".MG_ADMIN_README_173."</li>
</ol>
</ul>
<br /><br />
<strong>1.3 ".MG_ADMIN_README_64."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_65, "<i>PHP 4.3.6</i>", "<i>GD</i>", "<i>gif</i>, <i>jpg</i>, <i>png</i>", "<i>MySQL 4.0.26</i>", "<i>iconv</i>", "<i>posix</i>")."</li>
<li>".sprintf(MG_ADMIN_README_66, "<i>Windows</i>", "<i>Linux</i>", "<i>Unix</i>", "<i>FreeBSD</i>")."</li>
<li>".sprintf(MG_ADMIN_README_67, "<i>Interner Explorer</i>", "<i>MyIE</i>", "<i>Opera</i>", "<i>Netscape Browser</i>", "<i>Mozilla Firefox</i>")."</li>
<br /><br />
<span class='smalltext'>".MG_ADMIN_README_68." ".MG_ADMIN_README_69."</span>
</ul>
<br /><br />
<strong>1.4 ".MG_ADMIN_README_70."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_71, "<i>".basename(e_GALLERY)."</i>", "<i>".substr(e_PLUGIN, 6, -1)."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_72, "<i>".MG_ADMIN_README_78."</i>", "<i>".MG_ADMIN_README_79."</i>", "<i>".MG_ADMIN_README_80."</i>")."</li>
</ul>
<br /><br />
<strong>1.5 ".MG_ADMIN_README_73."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_74, "<i>".basename(e_GALLERY)."</i>", "<i>".substr(e_PLUGIN, 6, -1)."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_75, "<i>".MG_ADMIN_README_78."</i>", "<i>".MG_ADMIN_README_79."</i>", "<i>".MG_ADMIN_README_81."</i>")."</li>
<br /><br />
<span class='smalltext'>".MG_ADMIN_README_68." ".MG_ADMIN_README_76."</span>
</ul>
</div>
<br /><br />
<div name='2' id='2'><strong>2. ".strtoupper(MG_ADMIN_README_77)."</strong></div>
<br />
<div style='margin-left:15px;'>
<strong>2.1 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_83."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".MG_ADMIN_README_84."<table style='border:0px; width:100%;'>
<tr>
<td style='text-align:left; width:50%;'>
<img src='".e_GALLERY."images/icons/parent_icon.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_85."<br />
<img src='".e_GALLERY."images/icons/category_icon.png' alt='' align='absmiddle' style='margin-bottom:1px;' /> - ".MG_ADMIN_README_86."<br />
<img src='".e_GALLERY."images/icons/category_user_icon.png' alt='' align='absmiddle' style='margin-bottom:1px;' /> - ".MG_ADMIN_README_87."<br />
<img src='".e_GALLERY."images/icons/audio_icon.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_88."<br />
<img src='".e_GALLERY."images/icons/video_icon.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_89."<br />
<img src='".e_GALLERY."images/icons/image_icon.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_90."<br />
<img src='".e_GALLERY."images/icons/wallpaper_icon.png' alt='' align='absmiddle' style='margin-bottom:1px;' /> - ".MG_ADMIN_README_91."<br />
</td><td style='text-align:left; width:50%;'>
<img src='".e_GALLERY."images/actions/edit.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_92."<br />
<img src='".e_GALLERY."images/actions/delete.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_93."<br />
<img src='".e_GALLERY."images/actions/view.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_94."<br />
<img src='".e_GALLERY."images/actions/approve.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_95."<br />
<img src='".e_GALLERY."images/actions/up.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_96."<br />
<img src='".e_GALLERY."images/actions/down.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_97."<br />
<img src='".e_GALLERY."images/actions/updir.png' alt='' align='absmiddle' style='margin-bottom:1px;' /> - ".MG_ADMIN_README_98."<br />
</td>
</tr>
</table></li>
<li>".MG_ADMIN_README_99."</li>
<li>".MG_ADMIN_README_100."</li>
<li>".MG_ADMIN_README_101."</li>
</ul>
<br /><br />
<strong>2.2 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_102."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_103, "<i>".MG_ADMIN_README_104."</i>", "<i>".MG_ADMIN_README_105."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_106, "<i>".MG_ADMIN_README_105."</i>", "<i>http:// (https://)</i>", "<i>ftp://</i>")."</li>
<li>".sprintf(MG_ADMIN_README_107, "<i>ftp</i>", "<i>".MG_ADMIN_README_105."</i>", "<i>ftp://server.com/image.jpg</i>", "<i>ftp://login:password@server.com/image.jpg</i>", "<i>login</i>", "<i>password</i>")."</li>
<li>".sprintf(MG_ADMIN_README_108, "<i>URL</i>")."</li>
<li>".sprintf(MG_ADMIN_README_109, "<i>".MG_ADMIN_README_110."</i>")."</li>
<li>".MG_ADMIN_README_111."</li>
</ul>
<br /><br />
<strong>2.3 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_112."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_113, "<i>".substr(e_MEDIA, 6, -1)."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_114, "<i>".MG_ADMIN_README_104."</i>", "<i>".MG_ADMIN_README_105."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_106, "<i>".MG_ADMIN_README_105."</i>", "<i>http:// (https://)</i>", "<i>ftp://</i>")."</li>
<li>".sprintf(MG_ADMIN_README_115, "<i>ftp</i>", "<i>".MG_ADMIN_README_105."</i>", "<i>ftp://server.com/film.avi</i>", "<i>ftp://login:password@server.com/film.avi</i>", "<i>login</i>", "<i>password</i>")."</li>
<li>".sprintf(MG_ADMIN_README_108, "<i>URL</i>")."</li>
<li>".sprintf(MG_ADMIN_README_116, "<i>".MG_ADMIN_README_117."</i>", "<i>".MG_ADMIN_README_118."</i>", "<i>".MG_ADMIN_README_119."</i>")."</li>
</ul>
<br /><br />
<strong>2.4 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_120."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".MG_ADMIN_README_121."</li>
<li>".sprintf(MG_ADMIN_README_122, "<i>".MG_ADMIN_README_123."</i>")."</li>
<li>".MG_ADMIN_README_124."</li>
<li>".sprintf(MG_ADMIN_README_125, "<i>".MG_ADMIN_README_127."</i>", "<i>".MG_ADMIN_README_128."</i>", "<i>".MG_ADMIN_README_129."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_126, "<i>".MG_ADMIN_README_130."</i>")."</li>
</ul>
<br /><br />
<strong>2.5 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_131."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_132, "<i>".MG_ADMIN_README_133."</i>", "<i>".substr(e_UPLOAD, 6, -1)."</i>", "<i>ftp</i>", "<i>".MG_ADMIN_README_134."</i>", "<i>".MG_ADMIN_README_135."</i>")."</li>
</ul>
<br /><br />
<strong>2.6 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_136."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_137, "<i>".MG_ADMIN_README_138."</i>", "<i>".substr(e_GALLERY, 6, -1)."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_139, "<i>".MG_ADMIN_README_140."</i>", "<i>".substr(e_TEMP, 6, -1)."</i>")."</li>
</ul>
<br /><br />
<strong>2.7 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_141."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".MG_ADMIN_README_84."<table style='border:0px; width:100%;'>
<tr>
<td style='text-align:left; width:50%;'>
<img src='".e_GALLERY."images/icons/passed_icon.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_143."<br />
<img src='".e_GALLERY."images/icons/failed_icon.png' alt='' align='absmiddle' style='margin-bottom:2px;' /> - ".MG_ADMIN_README_144."
</td>
</tr>
</table></li>
<li>".MG_ADMIN_README_142."</li>
<li>".MG_ADMIN_README_145."</li>
</ul>
<br /><br />
<strong>2.8 ".sprintf(MG_ADMIN_README_82, "<i>".MG_ADMIN_README_146."</i>")."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_147, "<i>".MG_ADMIN_README_148."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_149, "<i>".MG_ADMIN_README_150."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_151, "<i>".MG_ADMIN_README_152."</i>", "<i>".MG_ADMIN_README_153."</i>")."</li>
</ul>
</div>
<br /><br />
<div name='3' id='3'><strong>3. ".strtoupper(MG_ADMIN_README_154)."</strong></div>
<br />
<div style='margin-left: 15px'>
<strong>3.1 ".MG_ADMIN_README_155."</strong>
<br /><br />
<ul type='square'>
<li>".MG_ADMIN_README_156."</li>
</ul>
<br /><br />
<strong>3.2 ".MG_ADMIN_README_157."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_158, "<i>".MG_ADMIN_README_146."</i>")."</li>
<li>".sprintf(MG_ADMIN_README_159, "<i>".MG_ADMIN_README_102."</i>", "<i>".MG_ADMIN_README_160."</i>")."</li>
</ul>
<br /><br />
<strong>3.3 ".MG_ADMIN_README_161."</strong>
<br /><br />
<ul type='square'>
<li>".MG_ADMIN_README_162."</li>
</ul>
</div>
<br /><br />
<div name='4' id='4'><strong>4. ".strtoupper(MG_ADMIN_README_26)."</strong></div>
<br />
<div style='margin-left: 15px'>
<strong>4.1 ".MG_ADMIN_README_155."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_163, "<i>".MG_ADMIN_README_26."</i>")."</li>
</ul>
<br /><br />
<strong>4.2 ".MG_ADMIN_README_164."</strong>
<br /><br />
<ul type='square'>
<li>".sprintf(MG_ADMIN_README_165, "<i>html</i>", "<i>".substr(e_GALLERY, 6)."templates</i>", "<i>".substr(THEME, 6)."</i>")."</li>
</ul>
</div>
<br /><br />
<div style='text-align:center'><a href='#top'><strong>".strtoupper(MG_ADMIN_README_4)."</strong></a></div>
</div>";
$ns->tablerender(MG_ADMIN_README_166, $text);
require_once(e_ADMIN."footer.php");

?>