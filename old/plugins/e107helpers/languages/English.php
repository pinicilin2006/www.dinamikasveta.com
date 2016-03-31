<?php
/**
 * e107 Helper English language file
 * <b>CVS Details:</b>
 * <ul>
 * <li>$Source: e:\_repository\e107_plugins/e107helpers/languages/English.php,v $</li>
 * <li>$Date: 2007/07/31 21:03:55 $</li>
 * </ul>
 * @author     $Author: Neil $
 * @version    $Revision: 1.8.2.8 $
 * @copyright  Released under the terms and conditions of the GNU General Public License (http://gnu.org).
 * @package e107Helper
 */

// **********************************************************************
// Some of these should not be in here as they are constants not language
// **********************************************************************


/**
 * English Language defines
 */

// prevent defines from appearing in phpDocs
/**#@+
 * @access private
 */

/**
 * General defines - DO NOT CHANGE text in {...}
 */
define("HELPER_LAN_01", "e107 Helper Project");
define("HELPER_LAN_02", "Helper classes and methods for plugin writers.");
define("HELPER_LAN_03", "Preferences have been saved");
define("HELPER_LAN_04", "Choose...");
define("HELPER_LAN_05", "Save Preferences");
define("HELPER_LAN_06", "Update successfull");
define("HELPER_LAN_07", "Upgrade successfull");
define("HELPER_LAN_08", "Documentation for this plugin can be found in the e107 wiki");
define("HELPER_LAN_09", "Database insert successfull");
define("HELPER_LAN_10", "Database update successfull");
define("HELPER_LAN_11", "Database delete successfull");
define("HELPER_LAN_12", "Database insert failed");
define("HELPER_LAN_13", "Database update failed");
define("HELPER_LAN_14", "Database delete failed");
define("HELPER_LAN_15", "Are you sure you want to delete this item");
define("HELPER_LAN_16", "Batch Item {ITEMNO}");
define("HELPER_LAN_17", "Database insert(s) successfull - {ITEMS} record(s) inserted");
define("HELPER_LAN_18", "Click to edit");

// Batch processing
define("HELPER_LAN_BATCH_1", "Number of batch groups");
define("HELPER_LAN_BATCH_2", "Tick each fields below that should appear in the repeating group");
define("HELPER_LAN_BATCH_3", "Setting the value to 1 turns off batch processing.");

define("HELPER_LAN_CREATE",         "Create");
define("HELPER_LAN_UPDATE",         "Update");
define("HELPER_LAN_EDIT",           "Edit");
define("HELPER_LAN_DELETE",         "Delete");
define("HELPER_LAN_PRINT",          "Print");
define("HELPER_LAN_EMPTY",          "There are no entries");
define("HELPER_LAN_EXISTING",       "Existing entries");
define("HELPER_LAN_DELETE_CONFIRM", "Are you sure you want to delete this entry?");

// Admin menu
define("HELPER_LAN_ADMIN_MENU_TITLE", "Preferences");

define("HELPER_LAN_ADMIN_PAGE_0_NAME", "Read Me");
define("HELPER_LAN_ADMIN_PAGE_0_LINK", "admin_readme.php");
define("HELPER_LAN_ADMIN_PAGE_0_ID",   "readme");

define("HELPER_LAN_ADMIN_PAGE_1_NAME", "Logger");
define("HELPER_LAN_ADMIN_PAGE_1_LINK", "admin_logger_prefs.php");
define("HELPER_LAN_ADMIN_PAGE_1_ID",   "loggerprefs");

define("HELPER_LAN_ADMIN_PAGE_2_NAME", "CSS Styles");
define("HELPER_LAN_ADMIN_PAGE_2_LINK", "admin_style_prefs.php");
define("HELPER_LAN_ADMIN_PAGE_2_ID",   "styleprefs");

/**
 * Validation messages
 */
// general
define("HELPER_LAN_ERR_VAL_01", "The following errors were detected:");
define("HELPER_LAN_ERR_VAL_02", "this field is mandatory and must be entered");
define("HELPER_LAN_ERR_VAL_03", "the field must have at least <min> characters");
define("HELPER_LAN_ERR_VAL_04", "the field must have no more than <max> characters");
define("HELPER_LAN_ERR_VAL_05", "the field must be equal to or greater than <min>");
define("HELPER_LAN_ERR_VAL_06", "the field must be equal to or less than <max>");
// color tags
define("HELPER_LAN_ERR_VAL_COLOR_01", "invalid colour code");
// decimal tags
define("HELPER_LAN_ERR_VAL_DECIMAL_01", "invalid decimal value");
// integer tags
define("HELPER_LAN_ERR_VAL_INTEGER_01", "invalid integer value");
// numeric tags
define("HELPER_LAN_ERR_VAL_NUMERIC_01", "invalid numeric value");
// custom fields
define("HELPER_LAN_ERR_VAL_CUSTOM_01", "The name field is mandatory and must be entered");
// upload tags
define("HELPER_LAN_ERR_VAL_UPLOAD_01", "Failed to find upload file");
define("HELPER_LAN_ERR_VAL_UPLOAD_02", "Failed to move uploaded file");
define("HELPER_LAN_ERR_VAL_UPLOAD_03", "No file selected");
define("HELPER_LAN_ERR_VAL_UPLOAD_04", "Invalid (empty) file selected");
define("HELPER_LAN_ERR_VAL_UPLOAD_05", "The filetype");
define("HELPER_LAN_ERR_VAL_UPLOAD_06", "is not allowed - the file has been deleted");
define("HELPER_LAN_ERR_VAL_UPLOAD_07", "File exceeds specified maximum size limit of {SIZELIMIT} - the file has been deleted.");

// Processing messages
define("HELPER_LAN_ERR_PROC_01", "*** Unknown Javascript event: ");

// Access table tag constants
define("HELPER_ACCESSTABLE_EVERYONE",        "Everyone");
define("HELPER_ACCESSTABLE_GUESTS",          "Guests only");
define("HELPER_ACCESSTABLE_MEMBERS",         "Members only");
define("HELPER_ACCESSTABLE_ADMINISTRATORS",  "Administrators only");
define("HELPER_ACCESSTABLE_NOONE",           "No One (inactive)");
define("HELPER_ACCESSTABLE_MAIN_ADMIN",      "Main Admin");
define("HELPER_ACCESSTABLE_READONLY",        "Read only");

// Rating text, use already defined values (usually e107 0.7) if they are available
if (defined("RATELAN_0")) define("HELPER_RATELAN_0", RATELAN_0); else define("HELPER_RATELAN_0", "vote");
if (defined("RATELAN_1")) define("HELPER_RATELAN_1", RATELAN_1); else define("HELPER_RATELAN_1", "votes");
if (defined("RATELAN_2")) define("HELPER_RATELAN_2", RATELAN_2); else define("HELPER_RATELAN_2", "please rate this item?<br/>");
if (defined("RATELAN_3")) define("HELPER_RATELAN_3", RATELAN_3); else define("HELPER_RATELAN_3", "thank you for your vote");
if (defined("RATELAN_4")) define("HELPER_RATELAN_4", RATELAN_4); else define("HELPER_RATELAN_4", "not rated");
if (defined("RATELAN_5")) define("HELPER_RATELAN_5", RATELAN_5); else define("HELPER_RATELAN_5", "Rate");
if (defined("RATELAN_6")) define("HELPER_RATELAN_6", RATELAN_6); else define("HELPER_RATELAN_6", "You must be logged on to rate");

// Logger constants
define("HELPER_LOGGER_OFF_TEXT",       "Off");
define("HELPER_LOGGER_FATAL_TEXT",     "Fatal");
define("HELPER_LOGGER_ERROR_TEXT",     "Error");
define("HELPER_LOGGER_WARN_TEXT",      "Warning");
define("HELPER_LOGGER_INFO_TEXT",      "Info");
define("HELPER_LOGGER_DEBUG_TEXT",     "Debug");
define("HELPER_LOGGER_TRACE_TEXT",     "Trace");
define("HELPER_LOGGER_METHOD_ENTRY",   "Method entry");
define("HELPER_LOGGER_METHOD_EXIT",    "Method exit");
define("HELPER_LOGGER_METHOD_PARAM",   "Method param");
define("HELPER_LOGGER_METHOD_RETURN",  "Method return");
define("HELPER_LOGGER_VARIABLE_VALUE", "..Variable value");
define("HELPER_LOGGER_VALUE_NOT_SET",  "Value not set/supplied");

define("HELPER_LOGGER_PREFS_HDR_1",    "Set Logging Options For plugins The Use The Helper Logger Functionality");
define("HELPER_LOGGER_PREFS_01_0",     "Logger level");
define("HELPER_LOGGER_PREFS_01_1",     "Select the logger level");
define("HELPER_LOGGER_PREFS_01_2",     "Logger levels are cumulative, therefore , if Warning is selected then errors of type Fatal, Error and Warn will be reported.");

define("HELPER_STYLE_PREFS_HDR_1",     "CSS Class Names Used For Displaying Text In Forms");
define("HELPER_STYLE_PREFS_HDR_2",     "Style Names And Values For Various Form Elements");
define("HELPER_STYLE_PREFS_01_0",      "Label Text");
define("HELPER_STYLE_PREFS_01_1",      "The fields label text");
define("HELPER_STYLE_PREFS_01_2",      "e.g. forumheader3");
define("HELPER_STYLE_PREFS_02_0",      "Prompt Text");
define("HELPER_STYLE_PREFS_02_1",      "The text below the fields label");
define("HELPER_STYLE_PREFS_02_2",      "e.g. smalltext");
define("HELPER_STYLE_PREFS_03_0",      "Help Text");
define("HELPER_STYLE_PREFS_03_1",      "The text below the field");
define("HELPER_STYLE_PREFS_03_2",      "e.g. smalltext");
define("HELPER_STYLE_PREFS_04_0",      "Message Text");
define("HELPER_STYLE_PREFS_04_1",      "Text displayed at the top of the form");
define("HELPER_STYLE_PREFS_04_2",      "e.g. forumheader");
define("HELPER_STYLE_PREFS_05_0",      "Error Text");
define("HELPER_STYLE_PREFS_05_1",      "Message text for fields that are in error");
define("HELPER_STYLE_PREFS_05_2",      "e.g. searchhighlight");
define("HELPER_STYLE_PREFS_06_0",      "Submit button");
define("HELPER_STYLE_PREFS_06_1",      "Style to be used to display the 'submit' button at the bottom of the form");
define("HELPER_STYLE_PREFS_06_2",      "e.g. text-align:center;");

/**#@-*/
?>