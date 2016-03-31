<?php
/**
 * e107 Helper
 * <p>The main include file for the e107 Helper classes and files.</p>
 * <p>This file simply includes all other required files and should be the only one that
 * a program using
 * e107Helper needs to include.</p>
 * <b>CVS Details:</b>
 * <ul>
 * <li>$Source: e:\_repository\e107_plugins/e107helpers/e107Helper.php,v $</li>
 * <li>$Date: 2007/01/10 23:35:36 $</li>
 * </ul>
 * @author     $Author: Neil $
 * @version    $Revision: 1.13.2.7 $
 * @copyright  Released under the terms and conditions of the GNU General Public License
 *             (http://gnu.org).
 * @package    e107Helper
 */

/**
 *
 */

/**
 * This file simply includes all the required files and defines some constants for the e107
 * Helper classes to function.
 * It should be inlcuded using the PHP require_once() function.
 */
   if (!defined("HELPER_INCLUDED_ALREADY")) {
      define("HELPER_INCLUDED_ALREADY",      true);

      if (!function_exists("debug")) {
         function debug($obj=false) {
            $backtrace = debug_backtrace();
            print "<pre>".$backtrace[0]["line"]." ".$backtrace[1]["function"]."() : ";
            if (false === $obj) {
               foreach($backtrace as $trace) {
                  print($trace["line"]." ".$trace["file"]." ".$trace["class"]."::".$trace["function"]."<br/>");
               }
               print("<br/>");
            } else if (is_bool($obj)) {
               print $obj ? "true" : "false";
            } else {
               print_r($obj);
            }
            print "</pre>";
         }
      }
      if (isset($pref["helper_debug"]) && $pref["helper_debug"] !== 0) {
         //set_error_handler("e107Helper_handle_error");
      }

      if (file_exists(e_PLUGIN."e107helpers/languages/".e_LANGUAGE.".php")) {
         require_once(e_PLUGIN."e107helpers/languages/".e_LANGUAGE.".php");
      } else {
         require_once(e_PLUGIN."e107helpers/languages/English.php");
      }
      require_once(e_PLUGIN."e107helpers/e107Helper_constants.php");

      // Include some e107 files used by this helper classes
      require_once(e_HANDLER."rate_class.php");
      require_once(e_HANDLER."ren_help.php");
      require_once(e_HANDLER."emote.php");

      // Include DHTML calendar class if not already defined
      $incDHTMLCalendarJS = false;
      if (!class_exists("DHTML_Calendar")) {
         if (file_exists(e_HANDLER."calendar/calendar_class.php")) {
            require_once(e_HANDLER."calendar/calendar_class.php");
            $incDHTMLCalendarJS = true;
         }
      }

      // Include the e107HelperLogger class if not already defined
      if (!class_exists("e107HelperLogger")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperLogger_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperLogger_class.php");
            $GLOBALS['e107HelperLoggerFactory'] = new e107HelperLoggerFactory();
         } else {
            print "error, cannot find e107HelperLogger class";
         }
      }

      // Include the e107HelperDB class if not already defined
      if (!class_exists("e107HelperDB")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperDB_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperDB_class.php");
         } else {
            print "error, cannot find e107HelperDB class";
         }
      }

      // Include the e107Helper class if not already defined
      if (!class_exists("e107Helper")) {
         if (file_exists(e_PLUGIN."e107helpers/e107Helper_class.php")) {
            include(e_PLUGIN."e107helpers/e107Helper_class.php");
            $GLOBALS['e107Helper'] = new e107Helper();
         } else {
            print "error, cannot find e107Helper class";
         }
      }

      // Include the e107HelperCustomField class if not already defined
      if (!class_exists("e107HelperCustomField")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperCustomField_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperCustomField_class.php");
         } else {
            print "error, cannot find e107HelperCustomField class";
         }
      }

      // Include the e107Helper private class if not already defined
      if (!class_exists("e107HelperPrivate")) {
         if (file_exists(e_PLUGIN."e107helpers/e107Helper_private_class.php")) {
            include(e_PLUGIN."e107helpers/e107Helper_private_class.php");
            $GLOBALS['e107HelperPrivate'] = new e107HelperPrivate();
         } else {
            print "error, cannot find e107HelperPrivate class";
         }
      }

      // Include the e107HelperForm class if not already defined
      if (!class_exists("e107HelperForm")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperForm_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperForm_class.php");
            $GLOBALS['e107HelperForm'] = new e107HelperForm();
         } else {
            print "error, cannot find e107HelperForm class";
         }
      }

      // Include the e107HelperTagObj class if not already defined
      if (!class_exists("e107HelperTagObj")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperTagObj_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperTagObj_class.php");
         } else {
            print "error, cannot find e107HelperTagObj class";
         }
      }

      // Include the e107HelperButtonTagObj class if not already defined
      if (!class_exists("e107HelperButtonTagObj")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperButtonTagObj_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperButtonTagObj_class.php");
         } else {
            print "error, cannot find e107HelperButtonTagObj class";
         }
      }

      // Include the e107HelperStaticTagObj class if not already defined
      if (!class_exists("e107HelperStaticTagObj")) {
         if (file_exists(e_PLUGIN."e107helpers/e107HelperStaticTagObj_class.php")) {
            include(e_PLUGIN."e107helpers/e107HelperStaticTagObj_class.php");
         } else {
            print "error, cannot find e107HelperStaticTagObj class";
         }
      }

      global $e107Helper;
      global $e107HelperForm;
      global $footer_js;

      // Include Javascript helper stuff only if required - to not include it simply define the variable $e107HelperIncludeJS and assign any value
      // There is a better way to do this now, can call $e107Helper->getHeaderFiles() from plugins headerjs function
      if (!isset($e107HelperIncludeJS) || $e107HelperIncludeJS != false) {
         if (!isset($e107HelperIncludeJS) || $e107HelperIncludeJS == 1) {
            print "\n<script type='text/javascript' src='".e_PLUGIN_ABS."e107helpers/e107helper.js'></script>\n";
            print "\n<script type='text/javascript' src='".e_PLUGIN_ABS."e107helpers/firebug/firebugx.js'></script>\n";
         }
         //print "\n<style>@import url(".e_PLUGIN_ABS."e107helpers/domTT/domTT.css);</style>\n";
         //print "\n<style>@import url(".THEME."e107helpers/domTT.css);</style>\n";
         if (strpos(e_SELF, "admin_") > 0) {
            // For admin pages
            print "\n<script type='text/javascript' src='".e_FILE_ABS."e_ajax.js'></script>\n";
         } else {
            // For main site pages
            $footer_js[] = e_FILE_ABS.'e_ajax.js';
            if (!isset($e107HelperIncludeJS) || $e107HelperIncludeJS == 2) {
               $footer_js[] = e_PLUGIN_ABS."e107helpers/e107helper.js";
            }
            // TODO, this would be better included as the 1st JS file
            $footer_js[] = e_PLUGIN_ABS."e107helpers/firebug/firebugx.js";
         }

         if (class_exists("DHTML_Calendar") && $incDHTMLCalendarJS == true) {
            $temp = new DHTML_Calendar(true);
            //$footer_js[] = $temp->load_files();
            print $temp->load_files();
         }
      }
   }

if (!function_exists("e107Helper_handle_error")) {
   function e107Helper_handle_error($type, $message, $file, $line, $context) {
      if (strpos($file, "e107_handlers") === false ) {
         $error['short'] = "Notice: {$message}, Line {$line} of {$file}<br />\n";
         $trace = debug_backtrace();
         $backtrace[0] = (isset($trace[1]) ? $trace[1] : "");
         $backtrace[1] = (isset($trace[2]) ? $trace[2] : "");
         $error['trace'] = $backtrace;
         echo $error['short']."<br>";
         //print_r($error);
      }
   }
}

?>