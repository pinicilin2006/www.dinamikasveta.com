<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/readme.php                          |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : ReadMe file                                     |
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
          .bluewhite {background-color: #FFFFFF;
                      color: #000000;
                      font-family: Lucida Console, Courier, Courier New, monospace;
                      font-size: 8pt;
                      display: block;
                      border: 1px solid #AAAAAA;
                      padding: 3px;
                     }
          </style>";
   }

define(PAGE_HEADER,"Q Tree Menu readme");

require_once("../../class2.php");

if (file_exists(e_PLUGIN."q_tree_menu/language/".e_LANGUAGE.".php"))
	  @require_once(e_PLUGIN."q_tree_menu/language/".e_LANGUAGE.".php");
else
   @require_once(e_PLUGIN."q_tree_menu/language/Russian.php");

if(!getperms("P")){ header("location:".e_BASE."index.php"); exit; }
@include_once((file_exists("languages/".e_LANGUAGE.".php") ? "languages/".e_LANGUAGE.".php" : "languages/English.php"));
require_once(e_ADMIN."auth.php");

// Update checker :::::::::::::::::::::::::::::::::::::::::::::::
$sql -> db_Select("plugin","plugin_version","plugin_name='Q Tree Menu'");
$version = $sql -> db_Fetch();
$currentversion = $version[0];
$latestversion = file_get_contents( 'http://rijkvanwel.nl/updatecheck.php?script=1' ) ;
if ($latestversion > $currentversion)
   $updateavailable = 1;


require_once(e_ADMIN."/header.php");
?>

<table>
<tr>
  <td style="text-align:center; font-size: 13pt; background-color: #C0C0C0; padding: 3px; border: 1px solid #808080">
    <b>Q Tree Menu</b>
  </td>
</tr>
<tr>
  <td style="border: 1px solid #808080; padding: 4px">
    <table>
    <tr>
      <td>
       Версия:
      </td>
      <td>
        <?php 
          echo $currentversion;
          
          if ($updateavailable)
             {echo "&nbsp;&nbsp;&nbsp;<a style='color: #FF0000;' href='http://www.rijkvanwel.nl/updatecheck.php?script=1&redir=1' target='_blank'>Update available</a>";
             }
        ?>
      </td>
      <td rowspan="6">
        <img src="images/q_tree_logo.jpg">
      </td>
    </tr>
    <tr>
      <td>
        Дата создания:
      </td>
      <td>
        <?php echo $pref['Q_Tree_date']; ?>
      </td>
    </tr>
    <tr>
      <td>
        Все вопросы:
      </td>
      <td>
        <a href="mailto:e107@rijkvanwel.nl">e107@rijkvanwel.nl</a>
      </td>
    </tr>
    <tr>
      <td>
        Помощь разработчикам:
      </td>
      <td>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" border="0" name="submit" alt="Делать выплаты с PayPal - быстро, бесплатно и безопасно!">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
        ">
        </form>
      </td>
    </tr>
    <tr>
      <td colspan="2">
         Основан на Меню Ger Versluis (<a href="http://www.burmees.nl/menu" target=\"_blank\">www.burmees.nl/menu</a>)<br />
         Этот скрипт предназначен НЕ для комерческих сайтов!.
      </td>
    </tr>
    </table>
  </td>
</tr>
</table>
<br />
<span style="font-family: Trebuchet MS, Trebuchet, sans-serif; font-size: 13pt;"><?php echo Q_TREE_RM_L1; ?></span><br />
<?php echo Q_TREE_RM_L2; ?><br />
<span style="font-family: Trebuchet MS, Trebuchet, sans-serif; font-size: 13pt;"><?php echo Q_TREE_RM_L3; ?></span><br />
<?php echo Q_TREE_RM_L4; ?><br />
<span style="font-family: Trebuchet MS, Trebuchet, sans-serif; font-size: 13pt;"><?php echo Q_TREE_RM_L5; ?></span><br />
<?php echo Q_TREE_RM_L6; ?><br />
<span style="font-family: Trebuchet MS, Trebuchet, sans-serif; font-size: 13pt;"><?php echo Q_TREE_RM_L7; ?></span><br />
<?php echo Q_TREE_RM_L8; ?>
<div style="margin-left: 25px">
<?php echo Q_TREE_RM_L9; ?>
<div class="bluewhite">&lt;div id='HideDiv1'  style="position:relative;"&gt; element(s) &lt;/div&gt;</div>
<?php echo Q_TREE_RM_L10; ?>
<div class="bluewhite">&lt;script type='text/javascript'&gt;<br />
&nbsp;&nbsp;var HideArray=['HideDiv1','HideDiv2',...............];<br />
&lt;/script&gt;</div>
<?php echo Q_TREE_RM_L11; ?>
<div class="bluewhite" nowrap>function BeforeFirstOpen()
   <br>&nbsp;&nbsp;&nbsp;{if (ScLoc.HideArray)
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{var H_A,H_Al,H_El,i;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H_A=ScLoc.HideArray;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H_Al=H_A.length;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for (i=0;i&lt;H_Al;i++)
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{H_El=ScLoc.document.getElementById(H_A[i]).style;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H_El.visibility=M_Hide
   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
   <br>&nbsp;&nbsp;&nbsp;}
			<br>&nbsp;<br>function AfterCloseAll()
   <br>&nbsp;&nbsp;&nbsp;&nbsp;{
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (ScLoc.HideArray)
   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{var H_A,H_Al,H_El,i;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H_A=ScLoc.HideArray;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H_Al=H_A.length;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for (i=0;i&lt;H_Al;i++)
   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{H_El=ScLoc.document.getElementById(H_A[i]).style;
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H_El.visibility=M_Show
   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
   <br>&nbsp;&nbsp;&nbsp;&nbsp;}
</div>

<?php
require_once(e_ADMIN."/footer.php");
?>