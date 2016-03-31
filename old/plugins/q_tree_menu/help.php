<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/help.php                            |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : Help menu (extra info, logo and PayPal button)  |
| Перевод :  -Tommi-                        |
|                                                               |
| ************************************************************* |
| For the e107 website system © Steve Dunstan 2001-2005         |
| http://e107.org - jalist@e107.org                             |
|                                                               |
| Released under the terms and conditions of the                |
| GNU General Public License (http://gnu.org).                  |
+---------------------------------------------------------------+
*/

$text = "<br /><center><a href=\"readme.php\" title=\"Щёлкните для просмотра Описания плагина\"><img style=\"border: 1px solid black\" src=\"images/q_tree_logo.jpg\"></a></center><br />";

$text .= Q_TREE_HELP_L2 . "<br /><br />";

$text .= Q_TREE_HELP_L3 . "<br /><br /><center><form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_blank\">
                           <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">
                           <input type=\"image\" src=\"https://www.paypal.com/en_US/i/btn/x-click-but04.gif\" border=\"0\" name=\"submit\" alt=\"Делать выплаты с PayPal - быстро, бесплатно и безопасно!\">
                           <input type=\"hidden\" name=\"encrypted\" value=\"-----BEGIN PKCS7-----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-----END PKCS7-----\">
                           </form></center>
<br /><br /><b>Перевод на русский: <a href='http://www.club-mitsubishi.ru' target='blank'>-Tommi-</a></b>
";

if (e_PAGE == "admin_config.php")
   $ns -> tablerender(Q_TREE_HELP_L1, $text);
?>