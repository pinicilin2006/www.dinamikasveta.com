<?php

/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_handlers/arraystorage_class.php,v $
|     $Revision: 1.12 $
|     $Date: 2005/12/14 17:37:34 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

/**
* Allows Storage of arrays without use of serialize functions
*
*/
class ArrayData {

	/**
	* Return a string containg exported array data.
	*
	* @param array $ArrayData array to be stored
	* @param bool $AddSlashes default true, add slashes for db storage, else false
	* @return string
	*/
	function WriteArray($ArrayData, $AddSlashes = true) {
		if (!is_array($ArrayData)) {
			return false;
		}
		$Array = var_export($ArrayData, true);
		if ($AddSlashes == true) {
			$Array = addslashes($Array);
		}
		return $Array;
	}

	/**
	* Returns an array from stored array data.
	*
	* @param string $ArrayData
	* @return array stored data
	*/
	function ReadArray($ArrayData) {
		if ($ArrayData == ""){
			return false;
		}
		$data = "";
		$ArrayData = '$data = '.trim($ArrayData).';';
		@eval($ArrayData);
		if (!isset($data) || !is_array($data)) {
			trigger_error("Bad stored array data - <br /><br />".htmlentities($ArrayData), E_USER_ERROR);
			return false;
		}
		return $data;
	}
}

?>