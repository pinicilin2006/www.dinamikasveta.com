<?php
/*
+ ----------------------------------------------------------------------------+
|     Russian Language Pack for e107 0.7
|     $Revision: 1.3 $
|     $Date: 2007/05/20 16:27:19 $
|     $Author: verant $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$caption = "Список запрещенных: Справка";
$text = "Вы можете запрещать определенным пользователям посещать ваш сайт в этом окне.<br />
Вы можете ввести полный IP-адрес, или же использовать шаблон, чтобы запрещать диапазон IP-адресов. Так же Вы можете ввести адрес электронной почты, чтобы предотвратить его регистрацию в качестве пользователя на вашем сайте.<br /><br />
<b>Запрет по IP адресам:</b><br />
Введя IP-адрес вида 123.123.123.123 вы запретите доступ к вашему сайту пользователю с таким IP.<br />
Введя IP-адрес вида 123.123.123.* вы запретите доступ к вашему сайту всем, у кого IP-адрес попадает под данную маску.<br /><br />
<b>Запрет по email-адресу</b><br />
Введя email-адрес вида foo@bar.com вы запретите любому, кто укажет этот email-адрес, пройти регистрацию на вашем сайте.<br />
Введя email-адрес вида *@bar.com вы запретите всем пользователям, использующим email данного домена пройти регистрацию на вашем сайте.<br /><br />
<b>Запрет по имени пользователя</b><br />
Это делается на странице управления пользователями.";
$ns -> tablerender($caption, $text);
?>