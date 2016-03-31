<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/language/English.php                |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : English language file                           |
|                                                               |
| ************************************************************* |
| For the e107 website system © Steve Dunstan 2001-2005         |
| http://e107.org - jalist@e107.org                             |
|                                                               |
| Released under the terms and conditions of the                |
| GNU General Public License (http://gnu.org).                  |
+---------------------------------------------------------------+
*/

define("Q_TREE_L1","Main Menu");
define("Q_TREE_L2","Q Tree Menu - Preferences");
define("Q_TREE_L3","Save Settings");

define("Q_TREE_HELP_L1","Help Area");
define("Q_TREE_HELP_L2","<b>Preferences</b><br />As you can see, there are quite some prefs for this menu. There is no need to alter any of the default settings, but if you want, you can completely customize the menu. To find out what a pref does, just put your mouse pointer on the title of it.");
define("Q_TREE_HELP_L3","<b>Donate</b><br />Developing Q Tree Menu takes a lot of time and effort. This plugin is 100% free, but if you like it, please consider donating some money via PayPal.");

define("Q_TREE_RM_L1","What's this?");
define("Q_TREE_RM_L2","This is a multi-level menu plugin for the e107 CMS. It is a modified version of Menu 13.20 by Ger Versluis. It is supported by Firefox, Netscape 5+ and Internet Explorer 5+, and offers a lot of options, including transparency and horizontal format. The number of submenu's is virtually unlimited, but due to e107's limitations it's currently at a maximum of 3.<br />");
define("Q_TREE_RM_L3","What's new?");
define("Q_TREE_RM_L4","- Fixed bug where container wasn't properly sized in horizontal layout<br />- Fixed bug in build pause setting<br />- Added option for making parent items linked<br />- Added option for making main/sub menu bold seperately<br />- Added update checker (check this readme once in a while and you'll see it appear eventually :) )<br />");
define("Q_TREE_RM_L5","Like it?");
define("Q_TREE_RM_L6","Developing Q Tree Menu takes up a lot of time and effort. This plugin is free to use, but if you like it, please consider donating some money via PayPal.<br />");
define("Q_TREE_RM_L7","Flash problem");
define("Q_TREE_RM_L8","Some form elements and objects like Flash, are always on top. As a result the menu sometimes disappears behind an element in your page. This is browser behaviour and cannot be changed. One way to work around it is to temporarely hide the element in question when the menu drops.<br /><br />");
define("Q_TREE_RM_L9","1. Put the form(s), element(s) or object(s) inside a named div:");
define("Q_TREE_RM_L10","2. Make an array in the document with the names of the divs. Put this for instance in e107_files/user.js, so that it is filled into the header of the document:");
define("Q_TREE_RM_L11","3. Replace the empty functions BeforeFirstOpen and AfterCloseAll (found in the file menu_var.php) with:");