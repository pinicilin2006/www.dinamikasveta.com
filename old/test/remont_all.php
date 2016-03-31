<?
include("func.php");
include("config.php");
connect_to_base();
$query = mysql_query("select * from main") or die(mysql_error());
$row = mysql_num_rows($query);
$display = array("1" => "Ленина 37", "2" => "Ленина 55", "3" => "Энергетиков 22", "4" => "Фёдорова 69", "5" => "Сибирская 2(строитель)");
#$rashod_query = mysql_query("select sum(rashod) from main_rashod where id_user = '$user_id'") or die(mysql_error());
#$rashod_array = mysql_fetch_array($rashod_query);
#$rashod_all = $rashod_array["sum(rashod)"];
if (empty($row)) {
print <<<HERE
<br><br><body><center><h4>Данные о поломках отсутствуют. Вы будете возвращенны на <a href="index.php">главную</a> страницу</h4></center></body>
<meta http-equiv="refresh" content="3 url=index.php">
HERE;
exit;
}
print <<<HERE
<center>
<body>
<table style="text-align: left;" border="1"
cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td colspan="9" rowspan="1"
style="vertical-align: top; text-align: center;"><big><big><span
style="font-weight: bold;">Общий отчёт о произведённых ремонтных работах на экранах</span></big></big><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">№ поломки</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Экран</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Дата и время поломки</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Дата и время ремонта</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Описание неисправности</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Причина неисправности</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Израсходованные детали</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Ф.И.О. мастера</span><br>
</td>
<td style="vertical-align: top; text-align: center;"><span
style="font-weight: bold;">Время простоя</span><br>
</td>
</tr>
HERE;
for ($c; $c<$row; $c++)  {
$massive = mysql_fetch_array($query);
$dis = $massive[display_number];
print <<<HERE
<tr>
<td style="vertical-align: top;"><center>$massive[id]</center></td>
<td style="vertical-align: top;"><center>$display[$dis]</center></td>
<td style="vertical-align: top;"><center>$massive[polomka_date]</center><br></td>
<td style="vertical-align: top;"><center>$massive[remont_date]</center></td>
<td style="vertical-align: top;"><center>$massive[polomka]</center></td>
<td style="vertical-align: top;"><center>$massive[prichina]</center></td>
<td style="vertical-align: top;"><center>$massive[detali]</center></td>
<td style="vertical-align: top;"><center>$massive[name_master]</center></td>
<td style="vertical-align: top;"><center>$massive[time_prostoy]</center></td>
</tr>
HERE;
}
print <<<HERE
</table></body></center>
<center><a href="index.html">На главную</a></center>
HERE;
?>