<?php
/*
+ ----------------------------------------------------------------------------+
|     Russian Language Pack for e107 0.7
|     $Revision: 1.1 $
|     $Date: 2007/02/24 18:30:25 $
|     $Author: yarodin $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "На этой странице включается система ведения статистики посещения сайта. Если места на вашем сервере не так уж много  - можно включить опцию 'только домены', соответственно в лог будет писаться только домен, а не полный url, т.e. 'jalist.com' вместо 'http://jalist.com/links.php' ";
$ns -> tablerender("Логи: Справка", $text);
?>