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
$text = "Обзоры похожи на статьи, но они находятся в отдельном пункте меню.<br />
 Для создания многостраничных обзоров отделите каждую страницу текстом [newpage], т.е. <br /><code>Тест1 [newpage] Тест2</code><br /> создаст двухстраничный обзор с 'Тест1' на странице 1 и 'Тест2' на странице 2.";

$ns -> tablerender("Обзоры: Справка", $text);
?>