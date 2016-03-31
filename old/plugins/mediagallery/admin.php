<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        �Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: admin.php                                        |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

// ����������� ����� ��������� ��� ������ � �������� �������� ������
ini_set("max_execution_time", 180);

// �������� ���� � ���������� ���������
require(dirname(__FILE__)."/../../class2.php");

// ��������� �����������
if(!getperms("P")){
	header("Location: ".e_BASE."index.php");
	exit;
}

// ��������� ����������������� ����� �������
require(dirname(__FILE__)."/defines.php");

// �������� �������� �����
include_lan(e_GALLERY."languages/".e_LANGUAGE."/lan_".e_PAGE, TRUE);

// �������� ����������� JavaScript
$eplug_js = e_GALLERY."javascript/mediagallery.js";

// ��������� ����� � ��������� ��������������
require(e_GALLERY."classes/admin.class.php");

// ������������� ����������� �������
$admin = new Admin;

// �������� ����������, ���������� �� ������
$Tmp = explode(".", e_QUERY);

?>