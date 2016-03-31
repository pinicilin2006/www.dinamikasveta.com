<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/admin_prefs.php                     |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : Admin page for preferences                      |
| ������� :  -Tommi-                        |
|                                                               |
| ************************************************************* |
| For the e107 website system � Steve Dunstan 2001-2005         |
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

$prefcapt[] = "������ �������� ������ ����";
$prefname[] = "Q_Tree_mainwidth";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ ������� ������ ����";
$prefcapt[] = "������ �������� ����� ����";
$prefname[] = "Q_Tree_mainheight";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ ������� ������ ����";
$prefcapt[] = "������ �������";
$prefname[] = "Q_Tree_subwidth";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ �������";
$prefcapt[] = "������ �������";
$prefname[] = "Q_Tree_subheight";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ �������";

$prefcapt[] = "Main items font";
$prefname[] = "Q_Tree_mainfontfamily";
$preftype[] = "text";
$prefinfo[] = "<b>��������� ����</b><br />����� �������� ������ ����. ��������: <i>Technic, Verdana, sans-serif</i>";
$prefcapt[] = "������ ������ �������� ������ ����";
$prefname[] = "Q_Tree_mainfontsize";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ ������ ���� ������� ������";
$prefcapt[] = "����� �������";
$prefname[] = "Q_Tree_subfontfamily";
$preftype[] = "text";
$prefinfo[] = "<b>��������� ����</b><br />����� �������. ��������: <i>Technic, Verdana, sans-serif</i>";
$prefcapt[] = "������ ������ �������";
$prefname[] = "Q_Tree_subfontsize";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ ������ �������";

$prefcapt[] = "�������� ���� �������� ������ ����";
$prefname[] = "Q_Tree_mainbgimage";
$preftype[] = "text";
$prefinfo[] = "<b>������� ����</b><br />�������� ���� �������� ������ ����. ��� �������������� ����� ����������� (�������� ����� ��������, ����� ����� ����� �� ����), �����������: rollover?image1.jpg?image2.jpg";
$prefcapt[] = "�������� ���� �������";
$prefname[] = "Q_Tree_subbgimage";
$preftype[] = "text";
$prefinfo[] = "<b>������� ����</b><br />��� �������. ��� �������������� ����� ����������� (�������� ����� ��������, ����� ����� ����� �� ����), �����������: rollover?image1.jpg?image2.jpg";

$prefcapt[] = "���� �� ���������<br /> ������ ����";
$prefname[] = "Q_Tree_lowbgcolor";
$preftype[] = "color";
$prefinfo[] = "<b>����</b><br />���� ������ ����, ����� ������ ����� ��� ����.<br />������� �� ���� ����� ���� <i>TTTTTT</i> ��� ��������� ����������� ����.";
$prefcapt[] = "���� ���������<br /> ������ ����";
$prefname[] = "Q_Tree_highbgcolor";
$preftype[] = "color";
$prefinfo[] = "<b>����</b><br />���� ������ ����, ����� ������ ����� �� ����.<br />������� �� ���� ����� ���� <i>TTTTTT</i> ��� ��������� ����������� ����.";
$prefcapt[] = "���� ������<br /> �� ��������� ������ ����";
$prefname[] = "Q_Tree_fontlowcolor";
$preftype[] = "color";
$prefinfo[] = "<b>����</b><br />���� ������ ������ ����, ����� ������ ����� ��� ����.<br />������� �� ���� ����� ���� <i>TTTTTT</i> ��� ��������� ����������� ����.";
$prefcapt[] = "���� ������ <br /> ��������� ������ ����";
$prefname[] = "Q_Tree_fonthighcolor";
$preftype[] = "color";
$prefinfo[] = "<b>����</b><br />���� ������ ������ ����, ����� ������ ����� �� ����.<br />������� �� ���� ����� ���� <i>TTTTTT</i> ��� ��������� ����������� ����.";
$prefcapt[] = "���� �����";
$prefname[] = "Q_Tree_bordercolor";
$preftype[] = "color";
$prefinfo[] = "<b>����</b><br />���� ����� ������ ������� ����.<br />������� �� ���� ����� ���� <i>TTTTTT</i> ��� ��������� ����������� ����.";

$prefcapt[] = "������ �����<br /> �������� ������ ����";
$prefname[] = "Q_Tree_borderwidthmain";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������� ����� ������ (�������) �������� ������ ����.";
$prefcapt[] = "������ ����� <br /> �������";
$prefname[] = "Q_Tree_borderwidthsub";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������� ����� ������ (�������) �������.";
$prefcapt[] = "������ ����� <br />������ �������� ������ ����";
$prefname[] = "Q_Tree_borderbtwnmain";
$preftype[] = "text";
$prefinfo[] = "<b>������</b><br />������� ����� ������ �������� ������ ����.";
$prefcapt[] = "������ �����<br /> ������ �������";
$prefname[] = "Q_Tree_borderbtwnsub";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������� ����� ������ �������.";

$prefcapt[] = "������ ����� �������� ����";
$prefname[] = "Q_Tree_mainbold";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />������, ����� ������� (��� ������) ������ ���� � ������� ������ ����.";
$prefcapt[] = "������ ����� � �������";
$prefname[] = "Q_Tree_subbold";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />������, ����� ������� (��� ������) ������ ���� � ������� ������ ����.";
$prefcapt[] = "������";
$prefname[] = "Q_Tree_fontitalic";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />��������, ����� ������� ����� ��������";
$prefcapt[] = "������������ ������";
$prefname[] = "Q_Tree_textalign";
$preftype[] = "text";
$prefinfo[] = "<b><i>left</i>, <i>center</i>, <i>right</i></b><br />������������ ������ �� ���� ���� (�����, �� ������, ������).";

$prefcapt[] = "��������� �������������� ����";
$prefname[] = "Q_Tree_am";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />��������� ����������� ������� ����, ��� ��� � ���� �������� JavaScript . ��������� ������ �����, ��� ���� ����� �������� ��������� �������.";
$prefcapt[] = "����������� �� �������";
$prefname[] = "Q_Tree_uoc";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ���� ������������ ������ ��� ������� �� �� ������. ���� ������� ���������, ������� ������������ ��� ��������� ������ �������������.";
$prefcapt[] = "������������ ������";
$prefname[] = "Q_Tree_pl";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />����� �� �������� �� ����, ����������� ������ �������, �� �� ��������.";
$prefcapt[] = "�������������� �������������";
$prefname[] = "Q_Tree_flh";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������� ��������, �� �� ���� ������������ �������������, � ������� ������������ ����.";
$prefcapt[] = "������������ ������� <br />�� �����������";
$prefname[] = "Q_Tree_co";
$preftype[] = "text";
$prefinfo[] = "<b>�������� ����� 0 � 1</b><br />����� ���� ������� ��������� ������� ����� ���� ��� ������������ �� �����������.<br />�������� 0.25, ������ ��� 25% ������� ����� ��������� ������� ����� ����. ������������� �������� �������� (������� ����� ������������ � �������� �� �������� ������ ����).";
$prefcapt[] = "������������ ������� <br />�� ���������";
$prefname[] = "Q_Tree_cvo";
$preftype[] = "text";
$prefinfo[] = "<b>�������� ����� 0 � 1</b><br />����� ���� ������� ��������� ������� ����� ���� ��� ������������ �� ���������.<br />�������� 0.25, ������ ��� 25% ������� ����� ��������� ������� ����� ����. ������������� �������� �������� (������� ����� ������������ � �������� �� �������� ������ ����).";
$prefcapt[] = "Start top";
$prefname[] = "Q_Tree_st";
$preftype[] = "text";
$prefinfo[] = "<b>Number</b><br />When the menu is positioned absolute StartTop defines the vertical position of the menu in the document. When StartTop is between 0 and 1 it is calculated as part of window height.<br />Is used as offset when MenuVerticalCentered is not <i>top</i> or when the menu is positioned relative.";
$prefcapt[] = "Start left";
$prefname[] = "Q_Tree_sl";
$preftype[] = "text";
$prefinfo[] = "<b>Number</b><br />When the menu is positioned absolute StartLeft defines the horizontal position of the menu in the document. When StartLeft is between 0 and 1 it is calculated as part of window width.<br />Is used as offset when MenuCentered is not <i>left</i> or when the menu is positioned relative.";
$prefcapt[] = "������ �����";
$prefname[] = "Q_Tree_lp";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ ����� ����� �������� ���� � �������.";
$prefcapt[] = "������ ������";
$prefname[] = "Q_Tree_tp";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������ ����� ������� �������� ���� � �������. ���� ������� -1, �� ����� �������� �� ���������.";
$prefcapt[] = "����� ��������� �������";
$prefname[] = "Q_Tree_dd";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />����� (� �������������), ������� ������� ����� ������������, ����� ���� ��� ������ ����� ������ �� ����.";
$prefcapt[] = "�������� ���������";
$prefname[] = "Q_Tree_ud";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />����� (� �������������), ����� �������� ����� ������������� �������, ��� ��������� (��� �������) �� ����.";
$prefcapt[] = "������ ������";
$prefname[] = "Q_Tree_rtl";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ������� ����� ������������ ������. ������� ��� ���, � ���� ���� ����� ���������� ������.";
$prefcapt[] = "������������ ������";
$prefname[] = "Q_Tree_bu";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ��������, �� ������� ������������� ������. ������� ��� ���, � ���� ���� ����� ������������� �������������.";
$prefcapt[] = "���� �������";
$prefname[] = "Q_Tree_hb";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ��� ��������� ������� ����� �� ����, ����� ����� ����������� ������.";
$prefcapt[] = "���� ������";
$prefname[] = "Q_Tree_hb";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ��� ��������� ������� ����� �� ����, ����� ����� ����������� ��������.";
$prefcapt[] = "���� �������������";
$prefname[] = "Q_Tree_hul";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ��� ��������� ������� ����� �� ����, ����� ����� ��������������.";
$prefcapt[] = "���� ������ ������";
$prefname[] = "Q_Tree_hts";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />������� ������ ������. �����, ��� ��������� �� ���� ������, ����� ������������� (��� �����������). <br />��������: ���������� ������ ������ 12, ���� ������� 14, �� ��� ��������� �� ���� ������� �����, ����� ����� �������������.";
$prefcapt[] = "���� �����";
$prefname[] = "Q_Tree_hv";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ��� ��������� ������� ����� �� ����, ����� ����� ����������.";
$prefcapt[] = "������������ ����";
$prefname[] = "Q_Tree_mvc";
$preftype[] = "text";
$prefinfo[] = "<b>top, middle, bottom ��� static</b><br /> ���� ������� static, ���� ����� ������ (���������) ������������ ���� ��������.<br /> ������� StartTop ��������� �������.";
$prefcapt[] = "�������� ����";
$prefname[] = "Q_Tree_bod";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ����� ��������, �� ������������� ����� ��������� ������ ������� ������ ����. ������� ����� ��������� ����� ��������� �� ���� ������. ������ �������� �������.";
$prefcapt[] = "�����";
$prefname[] = "Q_Tree_bp";
$preftype[] = "text";
$prefinfo[] = "<b>�����</b><br />����� � �������������. ���� �������� ������ �����, ���� ����� ��������� ����� ����, ��� ���������� ��� ��������. ��������� 0, ���� �� ���������� � ������ �����."; 

$prefcapt[] = "���������� ������";
$prefname[] = "Q_Tree_slide";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ������� ������������ �� ���������� ��������. �������� ������ � Internet Explorer 6 (� ����).";
$prefcapt[] = "����";
$prefname[] = "Q_Tree_shadow";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� � ����� ���� ���������� ����. �������� � Internet Explorer 6 � Firefox.";
$prefcapt[] = "������������";
$prefname[] = "Q_Tree_opacity";
$preftype[] = "checkbox";
$prefinfo[] = "<b>���./����.</b><br />���� ������ ������� ��������, �� ���� � ������� ���������� ����������. �������� � Internet Explorer 6 � Firefox.";

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
    * Cool DHTML tooltip script- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
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