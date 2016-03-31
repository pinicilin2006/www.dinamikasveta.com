<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/menu_var.php                        |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : Build menu's javascript file from database      |
| Ïåðåâîä :  -Tommi-                        |
|                                                               |
| ************************************************************* |
| For the e107 website system © Steve Dunstan 2001-2005         |
| http://e107.org - jalist@e107.org                             |
|                                                               |
| Released under the terms and conditions of the                |
| GNU General Public License (http://gnu.org).                  |
+---------------------------------------------------------------+
*/

require_once("../../class2.php");

// Functions :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
   echo "
   function BeforeStart()
      {// Size div element
       document.getElementById('q_tree').style.width = DivWidth+\"px\";
       document.getElementById('q_tree').style.height = DivHeight+\"px\";
      }

   function BeforeFirstOpen(){return}
   function AfterCloseAll(){return}
   
   function AfterBuild(){return}";

// General preferences :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
   define("MAINWIDTH",$pref['Q_Tree_mainwidth']);
   define("MAINHEIGHT",$pref['Q_Tree_mainheight']);
   define("SUBWIDTH",$pref['Q_Tree_subwidth']);
   define("SUBHEIGHT",$pref['Q_Tree_subheight']);

   define("MAIN_FONTFAMILY",$pref['Q_Tree_mainfontfamily']);
   define("MAIN_FONTSIZE",$pref['Q_Tree_mainfontsize']);
   define("SUB_FONTFAMILY",$pref['Q_Tree_subfontfamily']);
   define("SUB_FONTSIZE",$pref['Q_Tree_subfontsize']);

   // For rollover background use the following syntax:
   // define("MAIN_BACKGROUNDIMAGE","rollover?image1.jpg?image2.jpg");
   define("MAIN_BACKGROUNDIMAGE",$pref['Q_Tree_mainbgimage']); 
   define("SUB_BACKGROUNDIMAGE",$pref['Q_Tree_subbgimage']);

   echo "
   var LowBgColor=\"#".$pref['Q_Tree_lowbgcolor']."\";   // Background color when mouse is not over
   var HighBgColor=\"#".$pref['Q_Tree_highbgcolor']."\";   // Background color when mouse is over
   var FontLowColor=\"#".$pref['Q_Tree_fontlowcolor']."\";   // Font color when mouse is not over
   var FontHighColor=\"#".$pref['Q_Tree_fonthighcolor']."\";   // Font color when mouse is over
   var BorderColor=\"#".$pref['Q_Tree_bordercolor']."\";   // Border color
   
   var BorderWidthMain=".$pref['Q_Tree_borderwidthmain'].";   // Border width main items
   var BorderWidthSub=".$pref['Q_Tree_borderwidthsub'].";   // Border width sub items
   var BorderBtwnMain=".$pref['Q_Tree_borderbtwnmain'].";   // Border width between elements main items
   var BorderBtwnSub=".$pref['Q_Tree_borderbtwnsub'].";   // Border width between elements sub items

   var FontBold=".($pref['Q_Tree_fontbold'] == '' ? '0' : $pref['Q_Tree_fontbold']).";    // Bold menu items 1 or 0
   var FontItalic=".($pref['Q_Tree_fontitalic'] == '' ? '0' : $pref['Q_Tree_fontitalic']).";    // Italic menu items 1 or 0
   var MenuTextCentered=\"".$pref['Q_Tree_textalign']."\";  // Item text position left, center or right
   
   var Arrws=[\"".SITEURL.$PLUGINS_DIRECTORY."q_tree_menu/images/tri.gif\",5,10,\"".SITEURL.$PLUGINS_DIRECTORY."q_tree_menu/images/tridown.gif\",10,5,\"".SITEURL.$PLUGINS_DIRECTORY."q_tree_menu/images/trileft.gif\",5,10,\"".SITEURL.$PLUGINS_DIRECTORY."q_tree_menu/images/triup.gif\",10,5];


// Advanced settings :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
   var UnfoldsOnClick=".($pref['Q_Tree_uoc'] == '' ? '0' : $pref['Q_Tree_uoc']).";           // Level 1 unfolds onclick/onmouseover
   var FirstLineHorizontal=".($pref['Q_Tree_flh'] == '' ? '0' : $pref['Q_Tree_flh']).";      // Horizontal/vertical menu 
   var ChildOverlap=".str_replace(',','.',$pref['Q_Tree_co']).";            // horizontal overlap child/ parent
   var ChildVerticalOverlap=".str_replace(',','.',$pref['Q_Tree_cvo']).";    // vertical overlap child/ parent
   var StartTop=".$pref['Q_Tree_st'].";                 // Menu offset x coordinate
   var StartLeft=".$pref['Q_Tree_sl'].";                // Menu offset y coordinate
   var LeftPaddng=".$pref['Q_Tree_lp'].";              // Left padding
   var TopPaddng=".$pref['Q_Tree_tp'].";                // Top padding. If set to -1 text is vertically centered
   var DissapearDelay=".$pref['Q_Tree_dd'].";        // Delay before menu folds in
   var UnfoldDelay=".$pref['Q_Tree_ud'].";            // Delay before sub unfolds
   var RightToLeft=".($pref['Q_Tree_rtl'] == '' ? '0' : $pref['Q_Tree_rtl']).";              // Enables/disables right to left unfold 1 or 0
   var BottomUp=".($pref['Q_Tree_bu'] == '' ? '0' : $pref['Q_Tree_bu']).";                 // Enables/disables bottom up unfold 1 or 0
   var HooverBold=".($pref['Q_Tree_hb'] == '' ? '0' : $pref['Q_Tree_hb']).";               // Text of menu item bold when mouse is over
   var HooverItalic=".($pref['Q_Tree_hi'] == '' ? '0' : $pref['Q_Tree_hi']).";             // Text of menu item italic when mouse is over
   var HooverUnderLine=".($pref['Q_Tree_hul'] == '' ? '0' : $pref['Q_Tree_hul']).";          // Text of menu item underlined when mouse is over
   var HooverTextSize=".($pref['Q_Tree_hts'] == '' ? '0' : $pref['Q_Tree_hts']).";           // 0=off, number is font size difference on mouse over
   var HooverVariant=".($pref['Q_Tree_hv'] == '' ? '0' : $pref['Q_Tree_hv']).";            // Text of menu item in caps when mouse is over
   var MenuVerticalCentered=\"".$pref['Q_Tree_mvc']."\"; // ´static´ for sliding menu
   var BuildOnDemand=".($pref['Q_Tree_bod'] == '' ? '0' : $pref['Q_Tree_bod']).";            // Submenu's are built when mouse is over
   var BuildPause=".($pref['Q_Tree_bp'] == '' || $pref['Q_Tree_bp'] == 0 ? '1' : $pref['Q_Tree_bp']).";

   ".($pref['Q_Tree_slide'] == 1 ? "
        var MenuSlide=\"progid:DXImageTransform.Microsoft.RevealTrans(duration=.5, transition=19)\"; 
        var MenuSlide=\"progid:DXImageTransform.Microsoft.GradientWipe(duration=.5, wipeStyle=1)\";
   " : "var MenuSlide=\"\";")."
   ".($pref['Q_Tree_shadow'] == 1 ? "
        var MenuShadow=\"progid:DXImageTransform.Microsoft.DropShadow(color=#888888, offX=2, offY=2, positive=1)\"; 
        var MenuShadow=\"progid:DXImageTransform.Microsoft.Shadow(color=#888888, direction=135, strength=3)\"; 
   " : "var MenuShadow=\"\";")."
   ".($pref['Q_Tree_opacity'] == 1 ? "
        var MenuOpacity=\"progid:DXImageTransform.Microsoft.Alpha(opacity=90)\";
   " : "var MenuOpacity=\"\";")."

   "; ?>

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::































var FontFamily="";
var FontSize=12;
var MenuCentered="left";
var MenuWrap=1;
var BaseHref="";
var TargetLoc="q_tree";
var VerCorrect=0;
var HorCorrect=0;
var TakeOverBgColor=1;
var OverFormElements=1;

var MenuUsesFrames=0;
var DistFrmFrameBrdr=0;
var MenuFramesVertical=1;
var FirstLineFrame="";
var SecLineFrame="";
var DocTargetFrame="";

var RememberStatus=0;
var BgImgLeftOffset=5;
var ScaleMenu=0;


<?php
$L1_menu = 0;
$sql2 = new db;
$L2_menu = 0;
$sql3 = new db;
$L3_menu = 0;
$sql4 = new db;
$L4_menu = 0;
$sql5 = new db;
$L5_menu = 0;

// Level 1 :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
$sql -> db_Select("links", "*", "link_category='1' AND link_parent='0' ORDER BY link_order ASC");
while($row = $sql -> db_Fetch())
   {extract($row);
    $L1_menu ++;
    $L1_link_description = menustr($link_description);
    $L1_link_name = menustr($link_name);
    $L1_link_class = $link_class;
    $L1_link_url = $link_url;

    if ($sql2 -> db_Select("links", "*", "link_parent=".$link_id." ORDER BY link_order") && q_classcheck($L1_link_class))
       {// Level 2 :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        while($row = $sql2 -> db_Fetch())
           {extract($row);
            $L2_menu ++;
            $L2_link_description = menustr($link_description);
            $L2_link_name = menustr($link_name);
            $L2_link_class = $link_class;
            $L2_link_url = $link_url;

            if ($sql3 -> db_Select("links", "*", "link_parent=".$link_id." ORDER BY link_order") && q_classcheck($L2_link_class))
               {// Level 3 :::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                while($row = $sql3 -> db_Fetch())
                   {extract($row);
                    $L3_menu ++;
                    $L3_link_description = menustr($link_description);
                    $L3_link_name = menustr($link_name);
                    $L3_link_class = $link_class;

                    if (q_classcheck($L3_link_class))
                       echo "Menu".$L1_menu."_".$L2_menu."_".$L3_menu."=new Array(\"".$L3_link_name."\",\"".q_setlink($link_url, $link_open)."\",\"".SUB_BACKGROUNDIMAGE."\",0,".SUBHEIGHT.",".SUBWIDTH.",\"\",\"\",\"\",\"\",\"\",\"".SUB_FONTFAMILY."\",".SUB_FONTSIZE.",".($pref['Q_Tree_subbold'] == 1 ? $pref['Q_Tree_subbold'] : '-1').",-1,\"\",\"".$L3_link_description."\");\n";
                    else
                       $L3_menu --;
                   }
                // End of level 3 items; build level 2 menu ::::::::::::::::::::::::
                if ($L3_menu > 0)
                   {echo "Menu".$L1_menu."_".$L2_menu."=new Array(\"".$L2_link_name."\",\"".($pref['Q_Tree_pl'] == 1 ? q_setlink($L2_link_url, $link_open) : '')."\",\"".SUB_BACKGROUNDIMAGE."\",".$L3_menu.",".SUBHEIGHT.",".SUBWIDTH.",\"\",\"\",\"\",\"\",\"\",\"".SUB_FONTFAMILY."\",".SUB_FONTSIZE.",".($pref['Q_Tree_subbold'] == 1 ? $pref['Q_Tree_subbold'] : '-1').",-1,\"\",\"".$L2_link_description."\");\n";
                   $L3_menu = 0;
                  }
                else
                  $L2_menu --;
               }
            else // No level 3 submenus
               {if (q_classcheck($L2_link_class))
                   echo "Menu".$L1_menu."_".$L2_menu."=new Array(\"".$L2_link_name."\",\"".q_setlink($link_url, $link_open)."\",\"".SUB_BACKGROUNDIMAGE."\",0,".SUBHEIGHT.",".SUBWIDTH.",\"\",\"\",\"\",\"\",\"\",\"".SUB_FONTFAMILY."\",".SUB_FONTSIZE.",".($pref['Q_Tree_subbold'] == 1 ? $pref['Q_Tree_subbold'] : '-1').",-1,\"\",\"".$L2_link_description."\");\n";
                else
                   $L2_menu --;
               }
           }
        // End of level 2 items; build level 1 menu ::::::::::::::::::::::::::::::::
        if ($L2_menu > 0)
           {echo "Menu".$L1_menu."=new Array(\"".$L1_link_name."\",\"".($pref['Q_Tree_pl'] == 1 ? q_setlink($L1_link_url, $link_open) : '')."\",\"".MAIN_BACKGROUNDIMAGE."\",".$L2_menu.",".MAINHEIGHT.",".MAINWIDTH.",\"\",\"\",\"\",\"\",\"\",\"".MAIN_FONTFAMILY."\",".MAIN_FONTSIZE.",".($pref['Q_Tree_mainbold'] == 1 ? $pref['Q_Tree_mainbold'] : '-1').",-1,\"\",\"".$L1_link_description."\"); \n";
           $L2_menu = 0;
          }
        else
          $L1_menu --;
       }
    else // No submenus
       {if (q_classcheck($L1_link_class))
           echo "Menu".$L1_menu."=new Array(\"".$L1_link_name."\",\"".q_setlink($link_url, $link_open)."\",\"".MAIN_BACKGROUNDIMAGE."\",0,".MAINHEIGHT.",".MAINWIDTH.",\"\",\"\",\"\",\"\",\"\",\"".MAIN_FONTFAMILY."\",".MAIN_FONTSIZE.",".($pref['Q_Tree_mainbold'] == 1 ? $pref['Q_Tree_mainbold'] : '-1').",-1,\"\",\"".$L1_link_description."\");\n";
        else
           $L1_menu --;
       }
   }

echo "var NoOffFirstLineMenus=".$L1_menu.";\n";

// Calculate width and height of menu's div element ::::::::::::::::::::::::::::::::
if ($pref['Q_Tree_flh'] == 1)
   {$divwidth  = $L1_menu * MAINWIDTH + 
                 ($L1_menu-1) * $pref['Q_Tree_borderbtwnmain'] +
                 2 * $pref['Q_Tree_borderwidthmain'];
    $divheight = 2 * $pref['Q_Tree_borderwidthmain'] +
                 MAINHEIGHT;
   }
else
   {$divheight = $L1_menu * MAINHEIGHT + 
                 ($L1_menu-1) * $pref['Q_Tree_borderbtwnmain'] +
                 2 * $pref['Q_Tree_borderwidthmain'];
    $divwidth  = 2 * $pref['Q_Tree_borderwidthmain'] +
                 MAINWIDTH;
   }
echo "var DivHeight=".$divheight.";\n
      var DivWidth =".$divwidth.";\n";

function q_setlink($link_url, $link_open)
   {if ($link_url != "" )
       {if (!strstr($link_url, "http:")) 
           $link_url = e_HTTP.$link_url;
        switch ($link_open)
           {case 1:
             $link = "javascript:NewWin=window.open(\'".(strstr($link_url, "http:") ? $link_url : e_HTTP.$link_url)."\');window[\\\"NewWin\\\"].focus()";
            break;
            case 4:
             $link = "javascript:open_window(\'".$link_url."\')";
            break;
            default:
             $link = $link_url;
           }
       }
    else
       $link = "";

    return $link;
   }

function menustr($string)
   {$string = preg_replace("/(\r\n|\n|\r)/", "", $string);
    $string = str_replace ( '&#039;', '\'', $string );
    $string = str_replace ( '&#39;', '\'', $string );
    $string = str_replace ( '&quot;', '\"', $string );
    $string = str_replace ( '&lt;', '<', $string );
    $string = str_replace ( '&gt;', '>', $string );
    $string = str_replace ( '&amp;', '&', $string );
    
    // Temporary for phasing out
    if (substr($string,0,8) == "submenu.")
       {$tmp = explode(".",$string);
        $no = count($tmp);
        $string = $tmp[($no-1)];
       }

    return $string;
   }

function q_classcheck($class)
   {if (!$class || check_class($class) || ($class==254 && USER))
       return TRUE;
    else
       return FALSE;
   }
?>