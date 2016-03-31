<?
function connect_to_base() {
global $dbhost, $dbuser, $dbpass, $dbbase;
mysql_connect($dbhost, $dbuser, $dbpass) OR DIE("Не удалось установить соединение с базой данных");
mysql_select_db($dbbase) OR DIE("Не найдена база $dbbbase");
}
?>