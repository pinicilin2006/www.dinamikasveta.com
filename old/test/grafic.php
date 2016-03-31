<?
include("func.php");
include("config.php");
connect_to_base();
//Задаём сдвиг в сторону минуса иначе отрицательные значения не будут отображаться на графике
$sdvig=60;
if ($_GET['period']) {
$period=$_GET['period'];
}
$display_number=$_GET['display_number']; 
//Пoлучаем значения температуры из базы данных
$query_for_rows = mysql_query("select * from temperature where display_number = $display_number");
$row = mysql_num_rows($query_for_rows);
if ($period) {
$limit = $row-$period;
$query = mysql_query("select * from temperature where display_number = $display_number limit $limit,$period");
}
else
{
$query = mysql_query("select * from temperature where display_number = $display_number");
}
$rows = mysql_num_rows($query);
// Задаем входные данные ############################################
// Входные данные - три ряда, содержащие случайные данные.
// Деление на 2 и 3 взято для того чтобы передние ряды не 
// пересекались

// Массив $DATA["x"] содержит подписи по оси "X"

$DATA=Array();
for ($i=0;$i<$rows;$i++) {
    $massive = mysql_fetch_array($query);
    $DATA[0][]= $massive[temperature]+$sdvig;
    $DATA["x"][]= substr($massive[date],11,5);
    }

// Задаем изменяемые значения #######################################

// Размер изображения

$W=1024;
$H=400;

// Отступы
$MB=20;  // Нижний
$ML=8;   // Левый 
$M=50;    // Верхний и правый отступы.
         // Они меньше, так как там нет текста

// Ширина одного символа
$LW=imagefontwidth(2);

// Подсчитаем количество элементов (точек) на графике
$count=count($DATA[0]);
//if (count($DATA[1])>$count) $count=count($DATA[1]);
//if (count($DATA[2])>$count) $count=count($DATA[2]);

if ($count==0) $count=1;

// Сглаживаем графики ###############################################
if ($_GET["smooth"]==1) {

    // Добавим по две точки справа и слева от графиков. Значения в
    // этих точках примем равными крайним. Например, точка если
    // y[0]=16 и y[n]=17, то y[1]=16 и y[-2]=16 и y[n+1]=17 и y[n+2]=17

    // Такое добавление точек необходимо для сглаживания точек
    // в краях графика

    for ($j=0;$j<3;$j++) {
        $DATA[$j][-1]=$DATA[$j][-2]=$DATA[$j][0];
        $DATA[$j][$count]=$DATA[$j][$count+1]=$DATA[$j][$count-1];
        }

    // Сглаживание графики методом усреднения соседних значений

    for ($i=0;$i<$count;$i++) {
        for ($j=0;$j<3;$j++) {
            $DATA[$j][$i]=($DATA[$j][$i-1]+$DATA[$j][$i-2]+
                           $DATA[$j][$i]+$DATA[$j][$i+1]+
                           $DATA[$j][$i+2])/5;
            }
        }
    }


// Подсчитаем максимальное значение
$max=$sdvig*2;

//for ($i=0;$i<$count;$i++) {
//    $max=$max<$DATA[0][$i]?$DATA[0][$i]:$max;
//    $max=$max<$DATA[1][$i]?$DATA[1][$i]:$max;
//    $max=$max<$DATA[2][$i]?$DATA[2][$i]:$max;
//    }

// Увеличим максимальное значение на 10% (для того, чтобы столбик
// соответствующий максимальному значение не упирался в в границу
// графика
//$max=intval($max+($max/10));

// Количество подписей и горизонтальных линий
// сетки по оси Y.
$county=20;

// Работа с изображением ############################################

// Создадим изображение
$im=imagecreate($W,$H);

// Цвет фона (белый)
$bg[0]=imagecolorallocate($im,255,255,255);

// Цвет задней грани графика (светло-серый)
$bg[1]=imagecolorallocate($im,231,231,231);

// Цвет левой грани графика (серый)
$bg[2]=imagecolorallocate($im,212,212,212);

// Цвет сетки (серый, темнее)
$c=imagecolorallocate($im,184,184,184);

// Цвет текста (темно-серый)
$text=imagecolorallocate($im,136,136,136);

// Цвета для линий графиков
$bar[0]=imagecolorallocate($im,191,65,170);
$bar[1]=imagecolorallocate($im,161,155,0);
$bar[2]=imagecolorallocate($im,65,170,191);

$text_width=0;
// Вывод подписей по оси Y
for ($i=1;$i<=$county;$i++) {
    $strl=strlen(($max/$county)*$i)*$LW;
    if ($strl>$text_width) $text_width=30;
    }

// Подравняем левую границу с учетом ширины подписей по оси Y
$ML+=$text_width;

// Посчитаем реальные размеры графика (за вычетом подписей и
// отступов)
$RW=$W-$ML-$M;
$RH=$H-$MB-$M;

// Посчитаем координаты нуля
$X0=$ML;
$Y0=$H-$MB;

$step=$RH/$county;

// Вывод главной рамки графика
imagefilledrectangle($im, $X0, $Y0-$RH, $X0+$RW, $Y0, $bg[1]);
imagerectangle($im, $X0, $Y0, $X0+$RW, $Y0-$RH, $c);

// Вывод сетки по оси Y
for ($i=1;$i<=$county;$i++) {
    $y=$Y0-$step*$i;
    imageline($im,$X0,$y,$X0+$RW,$y,$c);
    imageline($im,$X0,$y,$X0-($ML-$text_width)/4,$y,$text);
    }

// Вывод сетки по оси X
// Вывод изменяемой сетки
//for ($i=0;$i<$count;$i++) {
//    imageline($im,$X0+$i*($RW/$count),$Y0,$X0+$i*($RW/$count),$Y0,$c);
//    imageline($im,$X0+$i*($RW/$count),$Y0,$X0+$i*($RW/$count),$Y0-$RH,$c);
//    }

// Вывод линий графика
$dx=($RW/$count)/2;

$pi=$Y0-($RH/$max*$DATA[0][0]);
$po=$Y0-($RH/$max*$DATA[1][0]);
$pu=$Y0-($RH/$max*$DATA[2][0]);
$px=intval($X0+$dx);

    for ($i=1;$i<$count;$i++) {
    $x=intval($X0+$i*($RW/$count)+$dx);
	
    $y=$Y0-($RH/$max*$DATA[0][$i]);
    imageline($im,$px,$pi,$x,$y,$bar[0]);
    $pi=$y;
		    
    $y=$Y0-($RH/$max*$DATA[1][$i]);
    imageline($im,$px,$po,$x,$y,$bar[1]);
    $po=$y;
		
    $y=$Y0-($RH/$max*$DATA[2][$i]);
    imageline($im,$px,$pu,$x,$y,$bar[2]);
    $pu=$y;
        $px=$x;
    }
    

// Уменьшение и пересчет координат
$ML-=$text_width;

// Вывод подписей по оси Y
for ($i=1;$i<=$county;$i++) {
    $str=($max/$county)*$i-$sdvig;
    imagestring($im,2, $X0-strlen($str)*$LW-$ML/4-2,$Y0-$step*$i-
                       imagefontheight(2)/2,$str,$text);
    }

// Вывод подписей по оси X
$prev=100000;
$twidth=$LW*strlen($DATA["x"][0])+6;
$i=$X0+$RW;

while ($i>$X0) {
    if ($prev-$twidth>$i) {
        $drawx=$i-($RW/$count)/2;
        if ($drawx>$X0) {
            $str=$DATA["x"][round(($i-$X0)/($RW/$count))-1];
            imageline($im,$drawx,$Y0,$i-($RW/$count)/2,$Y0+5,$text);
            imagestring($im,2, $drawx-(strlen($str)*$LW)/2, $Y0+7,$str,$text);
            }
        $prev=$i;
        }
    $i-=$RW/$count;
    }

header("Content-Type: image/png");

// Генерация изображения
ImagePNG($im);
imagedestroy($im);

?>
