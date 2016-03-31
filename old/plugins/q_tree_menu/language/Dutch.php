<?php
/*
+- Q Tree Menu -------------------------------------------------+
|                                                               |
| File        : q_tree_menu/language/English.php                |
| Coding      : Rijk van Wel, aka Ridge                         |
| Description : English language file                           |
|                                                               |
| ************************************************************* |
| For the e107 website system © Steve Dunstan 2001-2005         |
| http://e107.org - jalist@e107.org                             |
|                                                               |
| Released under the terms and conditions of the                |
| GNU General Public License (http://gnu.org).                  |
+---------------------------------------------------------------+
*/

define("Q_TREE_L1","Hoofdmenu");
define("Q_TREE_L2","Q Tree Menu - Instellingen");
define("Q_TREE_L3","Opslaan");

define("Q_TREE_HELP_L1","Informatie");
define("Q_TREE_HELP_L2","<b>Instellingen</b><br />U kunt zien dat er aan dit menu een hoop in te stellen is. Hoewel het niet nodig is de standaard-instellingen te wijzigen, kunt u hiermee wel het menu geheel op maat maken. Voor een uitgebreide uitleg van een instelling kunt u de muisaanwijzer op het vakje met de naam ervan plaatsen.");
define("Q_TREE_HELP_L3","<b>Bijdragen</b><br />De ontwikkeling van Q Tree Menu kost veel tijd en moeite. Het is een gratis plugin, maar als u er plezier van heeft, overweeg dan om een bedrag te doneren via PayPal.");

define("Q_TREE_RM_L1","Wat is dit?");
define("Q_TREE_RM_L2","Dit is een menu met meerdere subniveau's voor het e107 CMS. Het is een voor dit doel aangepaste versie van Menu 13.20, van Ger Versluis. Het menu wordt ondersteund door Firefox, Netscape 5+ en Internet Explorer 5+, en biedt een veelvoud aan opties, waaronder transparantie en een horizontale indeling. Het aantal submenu's is in theorie onbeperkt, maar helaas staat de huidige code van e107 niet toe dat er meer dan 3 worden gevormd.<br />");
define("Q_TREE_RM_L3","Wat is nieuw?");
define("Q_TREE_RM_L4","- Bug opgelost waardoor het venster niet om het menu werd gevormd bij gebruik van de horizontale weergave<br />- Fout weggehaald in de Build Pause instelling<br />- Optie toegevoegd om ook de items met submenu's gelinkt te kunnen maken<br />- Optie toegevoegd om hoofd/subniveau items apart vetgedrukt te maken<br />- Update checker toegevoegd (kijk af en toe naar deze readme en je ziet hem vanzelf verschijnen :) )<br />");
define("Q_TREE_RM_L5","Tevreden?");
define("Q_TREE_RM_L6","De ontwikkeling van Q Tree Menu kost veel tijd en moeite. Het is een gratis plugin, maar als u er plezier van heeft, overweeg dan om een bedrag te doneren via PayPal.<br />");
define("Q_TREE_RM_L7","Flash-probleem");
define("Q_TREE_RM_L8","Sommige formulier-elementen en objecten als Flash, zijn altijd op de voorgrond. Als gevolg hiervan verdwijnt het menu soms gedeeltelijk achter een gedeelte van de pagina. Dit is gedrag van de browser en dus niet te beïnvloeden. Dit probleem is op te lossen door de betreffende elementen te verbergen op het moment dat het menu uitklapt.<br /><br />");
define("Q_TREE_RM_L9","1. Plaats formulier(en) en object(en) in een benoemde div:");
define("Q_TREE_RM_L10","2. Maak een array aan, met de namen van de div's erin. Plaats dit in bijvoorbeeld e107_files/user.js, zodat het in de header van het document komt te staan:");
define("Q_TREE_RM_L11","3. Vervang de ongebruikte functies BeforeFirstOpen en AfterCloseAll (in het bestand menu_var.php) met:");