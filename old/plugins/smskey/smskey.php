<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©smscoin
|     http://smscoin.com
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/smskey/smskey.php,v $
|     $Revision: 0.1b $
|     $Date: 2008/02/14 21:02:23 $
|     $Author: smscoin $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }


class e_smskey
{

	//c-tor
	function e_smskey()
	{}


	function smskey($text,$area = 'olddefault')
	{
		########### SMSCoin key ##########
		$key_id = 111111; //sms:key ID number from site smscoin.com
		$s_enc = 'UTF-8';      //Script encoding windows-1251,UTF-8,..
		$tag_name = 'sms';//Tag name
		$s_lang = 'english';     //Default interface language
		// Supported laguages:
		//{"russian", "belarusian", "english", "estonian", "french", "german", "hebrew", "latvian", "lithuanian", "romanian", "spanish", "ukrainian"}
		##################################
		$content=$text;

		# Check if exists open an close tags of hidden content
			if (preg_match('/\\['.$tag_name.'\\](.*?)\\[\\/'.$tag_name.'\\]/is', $content, $matches)) {
				################################################################################
				### SMS:Key v1.0.6 ###
				if (intval($key_id) > 200000) {
					if($s_lang == "") {
						$s_lang = "english";
					}
					if($s_enc == "") {
						$s_enc="UTF-8";
					}
					$old_ua = @ini_set('user_agent', 'smscoin_key_1.0.6');
					$response = @file("http://service.smscoin.com/language/".$s_lang."/key/?s_pure=1&s_enc=".$s_enc."&s_key=".$key_id
					."&s_pair=".urlencode(substr($_GET["s_pair"],0,10))
					."&s_language=".urlencode(substr($_GET["s_language"],0,10))
					."&s_ip=".$_SERVER["REMOTE_ADDR"]
					."&s_url=".$_SERVER["SERVER_NAME"].htmlentities(urlencode($_SERVER["REQUEST_URI"])));
					@ini_set('user_agent', $old_ua);
					if ($response !== false) {
						if (count($response)>1 || $response[0] != 'true') {
							$rpl_hidd = implode("", $response);
						} else {
							$rpl_hidd= $matches[1];
						}
					} else { die('Could not request external server');}
				} else {
					$rpl_hidd = '<div style="text-align: left ;"> Hidden Text </div>';
				}
				# Replase hidden part of the content with relevant text
				$content = preg_replace('/\\['.$tag_name.'\\].*?\\[\\/'.$tag_name.'\\]/is', $rpl_hidd, $content);
				### SMS:Key end ###
				################################################################################
			}

	  return $content;
	}

}

?>
