<?
include("config.php");
include("func.php");
if(empty($_POST)) {
header("Location: remont.html");
exit;
}
$display_number = $_POST['display_number'];
$polomka_date = $_POST['polomka_date'];
$remont_date = $_POST['remont_date'];
$polomka = $_POST['polomka'];
$prichina = $_POST['prichina'];
$detali = $_POST['detali'];
$name_master = $_POST['name_master'];
$time_prostoy = $_POST['time_prostoy'];
if (empty($display_number) || empty($polomka_date) || empty($remont_date) || empty($polomka) || empty($prichina) || empty($detali) || empty($name_master) || empty($time_prostoy)) {
echo "<center>Необходимо заполнить все поля!!!</center>";
echo "<center><a href=remont.html>Назад</a></center>";
exit;
}
connect_to_base();
mysql_query("insert into main(`display_number`, `polomka_date`, `remont_date`, `polomka`, `prichina`, `detali`, `name_master`, `time_prostoy`)values('$display_number', '$polomka_date', '$remont_date', '$polomka', '$prichina', '$detali', '$name_master', '$time_prostoy' )") or die(mysql_error());
echo "<center>Данные успешно добавленны!!!</center>";
echo "<center><a href=remont.html>Добавить ещё данные.</a></center>";
echo "<center><a href=index.html>Вернуться на главную.</a></center>";
mail("boss@display-city.ru", "Message from server DISPLAY-CITY", "Добавленна запись о произведённом ремонте на экране.<br>Для просмотра записи перейдите на test.display-city.ru", "Content-type: text/html; charset=utf-8");
exit;
?>