<?php
/*
+ ----------------------------------------------------------------------------+
|     Russian Language Pack for e107 0.7
|     $Revision: 1.2 $
|     $Date: 2007/07/05 09:52:02 $
|     $Author: verant $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "Если вы делаете апгрейд e107 или вам просто необходимо, чтобы сайт был в оффлайне на некоторое время, просто отметьте галочкой свойство технического обслуживания и ваши посетители будут направляться на страницу, объясняющую, что сайт закрыт на ремонт. После того, как вы закончите, снимите галочку, чтобы вернуть сайт в нормальный режим работы.";

$ns -> tablerender("Техническое обслуживание: Справка", $text);
?>