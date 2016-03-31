<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/admin_prefs.php                     |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : Admin page for preferences                      |
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

function headerjs()
   {echo "<style type=\"text/css\">
          #dhtmltooltip
            {position: absolute;
             width: 190px;
             border: 1px solid black;
             padding: 2px;
             background-color: #FFFFDD;
             visibility: hidden;
             z-index: 100;
            }
          </style>";
   }

require_once("../../class2.php");

if (file_exists(e_PLUGIN."q_tree_menu/language/".e_LANGUAGE.".php"))
	  @require_once(e_PLUGIN."q_tree_menu/language/".e_LANGUAGE.".php");
else
   @require_once(e_PLUGIN."q_tree_menu/language/English.php");

//---------------------------------------------------------------
//              BEGIN CONFIGURATION AREA
//---------------------------------------------------------------

/*

$preftitle: The caption shown in the admin preferences page.

$prefcapt: The label or caption to be displayed for the field.
$prefname: the name of the preference you wish to save.
$preftype: the input type - choose from either: text,radio,checkbox, dropdown, date or table
$prefvalu: the default values of the above- format changes depending on type.
            text: default-text
            textarea: default-text
            radio: option1,option2,option3
            checkbox: value
            dropdown: option1,option2,option3
            table: tablename,value,name
            accesstable: (no value required)
            date: (no value required)

Simply duplicate the 4 "pref..." values as many times as needed.
You must use all 4 "prefxxxx" options for every prefernce you wish to create.
*/

$pageid = "prefs";

$prefcapt[] = "Ширина главного пункта меню";
$prefname[] = "Q_Tree_mainwidth";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Ширина первого уровня меню";
$prefcapt[] = "Высота главного пунка меню";
$prefname[] = "Q_Tree_mainheight";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Высота первого уровня меню";
$prefcapt[] = "Ширина подменю";
$prefname[] = "Q_Tree_subwidth";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Ширина подменю";
$prefcapt[] = "Высота подменю";
$prefname[] = "Q_Tree_subheight";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Высота подменю";

$prefcapt[] = "Main items font";
$prefname[] = "Q_Tree_mainfontfamily";
$preftype[] = "text";
$prefinfo[] = "<b>Текстовое поле</b><br />Шрифт главного пункта меню. Например: <i>Technic, Verdana, sans-serif</i>";
$prefcapt[] = "Размер шрифта главного пункта меню";
$prefname[] = "Q_Tree_mainfontsize";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Размер шрифта меню первого уровня";
$prefcapt[] = "Шрифт подменю";
$prefname[] = "Q_Tree_subfontfamily";
$preftype[] = "text";
$prefinfo[] = "<b>Текстовое поле</b><br />Шрифт подменю. Например: <i>Technic, Verdana, sans-serif</i>";
$prefcapt[] = "Размер шрифта подменю";
$prefname[] = "Q_Tree_subfontsize";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Размер шрифта подменю";

$prefcapt[] = "Картинка фона главного пункта меню";
$prefname[] = "Q_Tree_mainbgimage";
$preftype[] = "text";
$prefinfo[] = "<b>Укажите путь</b><br />Картинка фона главного пункта меню. Для автоматической смены изображения (картинка будет меняться, когда кусор мышки на меню), используйте: rollover?image1.jpg?image2.jpg";
$prefcapt[] = "Картинка фона подменю";
$prefname[] = "Q_Tree_subbgimage";
$preftype[] = "text";
$prefinfo[] = "<b>Укажите путь</b><br />Фон подменю. Для автоматической смены изображения (картинка будет меняться, когда кусор мышки на меню), используйте: rollover?image1.jpg?image2.jpg";

$prefcapt[] = "Цвет не активного<br /> пункта меню";
$prefname[] = "Q_Tree_lowbgcolor";
$preftype[] = "color";
$prefinfo[] = "<b>Цвет</b><br />Цвет пункта меню, когда курсор мышки вне меню.<br />Введите во всех полях цвет <i>TTTTTT</i> для полностью прозрачного фона.";
$prefcapt[] = "Цвет активного<br /> пункта меню";
$prefname[] = "Q_Tree_highbgcolor";
$preftype[] = "color";
$prefinfo[] = "<b>Цвет</b><br />Цвет пункта меню, когда курсор мышки на меню.<br />Введите во всех полях цвет <i>TTTTTT</i> для полностью прозрачного фона.";
$prefcapt[] = "Цвет шрифта<br /> не активного пункта меню";
$prefname[] = "Q_Tree_fontlowcolor";
$preftype[] = "color";
$prefinfo[] = "<b>Цвет</b><br />Цвет шрифта пункта меню, когда курсор мышки вне меню.<br />Введите во всех полях цвет <i>TTTTTT</i> для полностью прозрачного фона.";
$prefcapt[] = "Цвет шрифта <br /> активного пункта меню";
$prefname[] = "Q_Tree_fonthighcolor";
$preftype[] = "color";
$prefinfo[] = "<b>Цвет</b><br />Цвет шрифта пункта меню, когда курсор мышки на меню.<br />Введите во всех полях цвет <i>TTTTTT</i> для полностью прозрачного фона.";
$prefcapt[] = "Цвет рамки";
$prefname[] = "Q_Tree_bordercolor";
$preftype[] = "color";
$prefinfo[] = "<b>Цвет</b><br />Цвет рамки вокруг пунктов меню.<br />Введите во всех полях цвет <i>TTTTTT</i> для полностью прозрачного фона.";

$prefcapt[] = "Ширина рамки<br /> главного пункта меню";
$prefname[] = "Q_Tree_borderwidthmain";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Толщина рамки вокруг (снаружи) главного пункта меню.";
$prefcapt[] = "Ширина рамки <br /> подменю";
$prefname[] = "Q_Tree_borderwidthsub";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Толщина рамки вокруг (снаружи) подменю.";
$prefcapt[] = "Ширина рамки <br />внутри главного пункта меню";
$prefname[] = "Q_Tree_borderbtwnmain";
$preftype[] = "text";
$prefinfo[] = "<b>Ширина</b><br />Толщина рамки внутри главного пункта меню.";
$prefcapt[] = "Ширина рамки<br /> внутри подменю";
$prefname[] = "Q_Tree_borderbtwnsub";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Толщина рамки внутри подменю.";

$prefcapt[] = "Жирный шрифт главного меню";
$prefname[] = "Q_Tree_mainbold";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Пометь, чтобы сделать (или убрать) жирный шриф в главном пункте меню.";
$prefcapt[] = "Жирный шрифт в подменю";
$prefname[] = "Q_Tree_subbold";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Пометь, чтобы сделать (или убрать) жирный шриф в главном пункте меню.";
$prefcapt[] = "Курсив";
$prefname[] = "Q_Tree_fontitalic";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Отметьте, чтобы сделать шрифт курсивом";
$prefcapt[] = "Расположение текста";
$prefname[] = "Q_Tree_textalign";
$preftype[] = "text";
$prefinfo[] = "<b><i>left</i>, <i>center</i>, <i>right</i></b><br />Выравнивание текста во всем меню (слево, по центру, справо).";

$prefcapt[] = "Загружать альтернативные меню";
$prefname[] = "Q_Tree_am";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Загружать стандартное Главное Меню, для тех у кого отключён JavaScript . Выключите данную опцию, для того чтобы страница грузилась быстрее.";
$prefcapt[] = "Развёртывать по нажатию";
$prefname[] = "Q_Tree_uoc";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то меню раскрывается только при нажатии на неё мышкой. Если функция выключена, подменю раскрываются при наведении мышкой автоматически.";
$prefcapt[] = "Родительские ссылки";
$prefname[] = "Q_Tree_pl";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Когда вы кликаете на меню, открываются только подменю, но не страница.";
$prefcapt[] = "Горизонтальное позицирование";
$prefname[] = "Q_Tree_flh";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если функция включена, то всё меню отображается горизонтально, а подменю раскрываются вниз.";
$prefcapt[] = "Развёртывание подменю <br />по горизонтали";
$prefname[] = "Q_Tree_co";
$preftype[] = "text";
$prefinfo[] = "<b>Значение между 0 и 1</b><br />Какая чать подменю накрывает главный пункт меню при развёртывании по горизонтали.<br />Значение 0.25, значит что 25% подменю будет накрывать главный пункт меню. Отрицательные значения возможны (подменю будут раскрываться с отступом от главного пункта меню).";
$prefcapt[] = "Развёртывание подменю <br />по вертикали";
$prefname[] = "Q_Tree_cvo";
$preftype[] = "text";
$prefinfo[] = "<b>Значение между 0 и 1</b><br />Какая чать подменю накрывает главный пункт меню при развёртывании по вертикали.<br />Значение 0.25, значит что 25% подменю будет накрывать главный пункт меню. Отрицательные значения возможны (подменю будут раскрываться с отступом от главного пункта меню).";
$prefcapt[] = "Start top";
$prefname[] = "Q_Tree_st";
$preftype[] = "text";
$prefinfo[] = "<b>Number</b><br />When the menu is positioned absolute StartTop defines the vertical position of the menu in the document. When StartTop is between 0 and 1 it is calculated as part of window height.<br />Is used as offset when MenuVerticalCentered is not <i>top</i> or when the menu is positioned relative.";
$prefcapt[] = "Start left";
$prefname[] = "Q_Tree_sl";
$preftype[] = "text";
$prefinfo[] = "<b>Number</b><br />When the menu is positioned absolute StartLeft defines the horizontal position of the menu in the document. When StartLeft is between 0 and 1 it is calculated as part of window width.<br />Is used as offset when MenuCentered is not <i>left</i> or when the menu is positioned relative.";
$prefcapt[] = "Отступ слево";
$prefname[] = "Q_Tree_lp";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Отступ между левой границей меню и текстом.";
$prefcapt[] = "Отступ сверху";
$prefname[] = "Q_Tree_tp";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Отступ между верхней границей меню и текстом. Если указано -1, то текст выравнен по вертикали.";
$prefcapt[] = "Время видимости подменю";
$prefname[] = "Q_Tree_dd";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Время (в миллисекундах), которое подменю будет отображаться, после того как курсор мышки отведён от него.";
$prefcapt[] = "Задержка раскрытия";
$prefname[] = "Q_Tree_ud";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Время (в миллисекундах), после которого будет расскрываться подменю, при наведении (или нажатии) на него.";
$prefcapt[] = "Справо налево";
$prefname[] = "Q_Tree_rtl";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то подменю будут раскрываться налево. Полезно для тех, у кого меню будет находиться справо.";
$prefcapt[] = "Развёртывание наверх";
$prefname[] = "Q_Tree_bu";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если отмечено, то подменю расскрывается наверх. Полезно для тех, у кого меню будет располагаться горизонтально.";
$prefcapt[] = "Авто жирение";
$prefname[] = "Q_Tree_hb";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то при наведении курсора мышки на меню, текст будет становиться жирным.";
$prefcapt[] = "Авто курсив";
$prefname[] = "Q_Tree_hb";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то при наведении курсора мышки на меню, текст будет становиться курсивом.";
$prefcapt[] = "Авто подчёркивание";
$prefname[] = "Q_Tree_hul";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то при наведении курсора мышки на меню, текст будет подчёркиваться.";
$prefcapt[] = "Авто размер шрифта";
$prefname[] = "Q_Tree_hts";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Укажите размер шрифта. Текст, при наведении на меню мышкой, будет увеличиваться (или уменьшаться). <br />Например: нормальный размер текста 12, если укажите 14, то при наведении на меню курсора мышки, текст будет увеличиваться.";
$prefcapt[] = "Авто шрифт";
$prefname[] = "Q_Tree_hv";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то при наведении курсора мышки на меню, шрифт будет изменяться.";
$prefcapt[] = "Расположение меню";
$prefname[] = "Q_Tree_mvc";
$preftype[] = "text";
$prefinfo[] = "<b>top, middle, bottom или static</b><br /> Если указано static, меню будет ездить (скользить) относительно окна браузера.<br /> Функция StartTop вычисляет позицию.";
$prefcapt[] = "Загрузка меню";
$prefname[] = "Q_Tree_bod";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная опция включена, то первоначально будут грузиться только главные пункты меню. Подменю будут грузиться после наведения на меню мышкой. Сранца грузится быстрее.";
$prefcapt[] = "Пауза";
$prefname[] = "Q_Tree_bp";
$preftype[] = "text";
$prefinfo[] = "<b>Число</b><br />Время в миллисекундах. Если включите данную опцию, меню будет грузиться после того, как загрузится вся страница. Поставьте 0, если не нуждаетесь в данной опции."; 

$prefcapt[] = "Скользящий эффект";
$prefname[] = "Q_Tree_slide";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то подменю раскрываются со скользящим эффектом. Работает только в Internet Explorer 6 (и выше).";
$prefcapt[] = "Тень";
$prefname[] = "Q_Tree_shadow";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то у всего меню появляется тень. Работает в Internet Explorer 6 и Firefox.";
$prefcapt[] = "Прозрачность";
$prefname[] = "Q_Tree_opacity";
$preftype[] = "checkbox";
$prefinfo[] = "<b>ВКЛ./ВЫКЛ.</b><br />Если данная функция включена, то меню и подменю становится прозрачным. Работает в Internet Explorer 6 и Firefox.";

//---------------------------------------------------------------
//              END OF CONFIGURATION AREA
//---------------------------------------------------------------



if(!getperms("P")){ header("location:".e_BASE."index.php"); }
@include_once((file_exists("languages/".e_LANGUAGE.".php") ? "languages/".e_LANGUAGE.".php" : "languages/English.php"));
require_once(e_ADMIN."auth.php");

if (isset($_POST['updatesettings']))
   {$count = count($prefname);
    for ($i=0; $i<$count; $i++)
       {$namehere = $prefname[$i];

        if ($_POST[$namehere] == "on")
           $_POST[$namehere] = 1;
        if ($_POST[$namehere] == "off")
           $_POST[$namehere] = 0;
    
        $pref[$namehere] = $_POST[$namehere];
       };
    save_prefs();
    $message = LAN_SETSAVED;
   }

if ($message)
   $ns -> tablerender("Settings saved", "<div style='text-align:center'><b>$message</b></div>");


require_once("form_handler.php");
$rs = new form;

$text = "
    <div id=\"dhtmltooltip\"></div>

    <script type=\"text/javascript\">

    /***********************************************
    * Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
    * This notice MUST stay intact for legal use
    * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
    ***********************************************/

    var offsetxpoint=15 //Customize x offset of tooltip
    var offsetypoint=15 //Customize y offset of tooltip
    var ie=document.all
    var ns6=document.getElementById && !document.all
    var enabletip=false
    if (ie||ns6)
    var tipobj=document.all? document.all[\"dhtmltooltip\"] : document.getElementById? document.getElementById(\"dhtmltooltip\") : \"\"

    function ietruebody(){
    return (document.compatMode && document.compatMode!=\"BackCompat\")? document.documentElement : document.body
    }

    function ddrivetip(thetext, thecolor, thewidth){
    if (ns6||ie){
    if (typeof thewidth!=\"undefined\") tipobj.style.width=thewidth+\"px\"
    if (typeof thecolor!=\"undefined\" && thecolor!=\"\") tipobj.style.backgroundColor=thecolor
    tipobj.innerHTML=thetext
    enabletip=true
    return false
    }
    }

    function positiontip(e){
    if (enabletip){
    var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
    var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
    //Find out how close the mouse is to the corner of the window
    var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
    var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

    var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

    //if the horizontal distance isn't enough to accomodate the width of the context menu
    if (rightedge<tipobj.offsetWidth)
    //move the horizontal position of the menu to the left by it's width
    tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+\"px\" : window.pageXOffset+e.clientX-tipobj.offsetWidth+\"px\"
    else if (curX<leftedge)
    tipobj.style.left=\"5px\"
    else
    //position the horizontal position of the menu where the mouse is positioned
    tipobj.style.left=curX+offsetxpoint+\"px\"

    //same concept with the vertical position
    if (bottomedge<tipobj.offsetHeight)
    tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+\"px\" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+\"px\"
    else
    tipobj.style.top=curY+offsetypoint+\"px\"
    tipobj.style.visibility=\"visible\"
    }
    }

    function hideddrivetip(){
    if (ns6||ie){
    enabletip=false
    tipobj.style.visibility=\"hidden\"
    tipobj.style.left=\"-1000px\"
    tipobj.style.backgroundColor=''
    tipobj.style.width=''
    }
    }

    document.onmousemove=positiontip

    </script>

<form method='post' action='".e_SELF."' style='text-align:left'>
<table style='width:500px' class='fborder'>";

//nl2br(wordwrap($prefinfo[$i],40)

for ($i=0; $i<count($prefcapt); $i++) 
   {$name      = $prefname[$i];
    $value     = $pref[$name];
    $form_send = $name."|".$preftype[$i]."|".$value;
    $text .= "
    <tr>
      <td style=\"width:50%; vertical-align:top\" class=\"forumheader3\" onmouseover=\"ddrivetip('".$prefinfo[$i]."')\"; onmouseout=\"hideddrivetip()\">".$prefcapt[$i].":</td>
      <td style=\"width:50%\" class=\"forumheader3\">";
        $text .= $rs->user_extended_element_edit($form_send,$pref[$name],$name);
        $text .= "
      </td>
    </tr>";
   };

$text .= "
<tr style='vertical-align:top'>
  <td colspan='2' style='text-align:center' class='forumheader'>
    <input class='button' type='submit' name='updatesettings' value='".Q_TREE_L3."' />
  </td>
</tr>
</table>
</form>";

$ns->tablerender(Q_TREE_L2, $text);

require_once(e_ADMIN."footer.php");
?>