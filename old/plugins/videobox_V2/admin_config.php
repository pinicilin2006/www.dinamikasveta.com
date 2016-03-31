<?php
/*
+ ----------------------------------------------------------------------------------------------------+
|        e107 website system 
|        Plugin Admin File :  e107_plugins/videobox_V2/admin_config.php
|        Email: 
|        $Revision    1.0b$
|        $Date        12.2.2007$
|        $Author      Hups$
|        Support Sites : http://film-tutorial.com/news.php$
+----------------------------------------------------------------------------------------------------+
*/
require_once("../../class2.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit; } 


require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");

$qs = e_QUERY ? explode('.', e_QUERY) : array('', '');
$pageid = varset($qs[0], 'config', true);

//Actions

//Show Admin pages
if($pageid == 'help') {
	$text = '
	<h1><font color="#0033CC">Videobox V2 Plugin</font></h1>
	
	<center><a href="anleitung.html" title="Infos" class="option" rel="shadowbox;width=1000;height=1300"><h2><font color="#0033CC">Anleitung und infos</font></h2></a></center>



</p>
	';

	$ns->tablerender("help", $text);

} else {
	$ns->tablerender("Du bist in Videobox V2", show_options());
}

require_once(e_ADMIN."footer.php"); 
exit;

function show_options()
{
	global $pref;
	$txt = "
	<form method='post' action='".e_SELF."'>
	<table class='fborder' style='width:95%'>
	
	<tr><table class='fborder' style='width:95%' >
	
	<tr>
		
		<td class='forumheader3' style='width:75%'> <br>
		  <br>
		<table >
		  <tr>
		       <td ><strong><h1><font color='#0033CC'>Die Videobox V2 !!</font></h1></strong><br />
<br />
  <h3><strong>Da der erforderliche Code f&uuml;r das einblenden der Bilder (und zwar nur f&uuml;r die  Bilder) ein Html Code sein muss, <br>
      ist die Voraussetzung das es funktioniert, die Aktivierung des Html Codes in  den Voreinstellungen. <br /><br />

Um dieses Einzustellen gehe in den : <br/><br />

      Admin Bereich &gt;&gt;&gt;&gt;Voreinstellungen  &gt;&gt;&gt;&gt;Textverarbeitung&gt;&gt;&gt;&gt;dort unter den Punkt Erlaube  HTML Eintr&auml;ge: Dies erlaubt Benutzern &uuml;berall auf Ihrer Seite HTML Code zu  schreiben. Bitte w&auml;hlen Sie die Benutzerklasse f&uuml;r dieses Feature. aus  Sicherheitsgr&uuml;nden reicht es vorab dies nur f&uuml;r den Admin zu erlauben</strong></h3><br />
<br />  
          </td>
	      <tr><td></td><tr>
		      <td colspan=\"2\"><strong><a href='http://film-tutorial.com/news.php' rel=external'target='_blank'>Der Download ist von der Homepage:</a></strong><a href='http://film-tutorial.com/news.php'><br> 
		        www.film-tutorial.de
		        <br>
		        www.film-tutorial.com
		        <br>
		        www.film-anleitung.de
		        <br>
		        www.film-anleitung.com 
		        <br>
		          </a><br>
		        <strong>ausdr&uuml;cklich Erlaubt</strong></td>
		    </tr>
  </table>
</td>
	
	  </tr>
	</table>
	
	";
	return $txt;
}
function show_message($message, $caption='', $error=false) {
	global $ns;
	$ns->tablerender($caption, "<div style='text-align:center; font-weight: bold'>".($error ? "<span style='color: ".varset($pref['e107wiki_err_color'], '#8B0000', true)."'>".$message."</span>" : $message)."</div>");
}
?>