<?php
/*
+ ----------------------------------------------------------------------------+
|     Russian Language Pack for e107 0.7
|     $Revision: 1.1 $
|     $Date: 2007/02/24 18:30:26 $
|     $Author: yarodin $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$caption = "Классы пользователей: Справка";
$text = "Вы можете создавать или редактировать/удалять существующие классы на этой странице.<br />Это полезно для того, чтобы запрещать пользователям определенные части вашего сайта. Например, вы можете создать класс под названием 'TEST', затем создать форум, который будет доступен только пользователям класса TEST.";
$ns -> tablerender($caption, $text);
?>