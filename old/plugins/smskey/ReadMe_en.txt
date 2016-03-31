SmsCoin  - product sms:key.

Every visitor of your resource is given an opportunity to vote for it. 
User votes by sending a certain message to the specified number by the means of sms;
a percent of the message's cost gets added to your account in our system. 
At the beginning of each month all your earnings will be transferred to you via WebMoney.

For using this module you have to be registered at smscoin.net .
	http://smscoin.net/account/register/
 
Usage: [smscoin_key] Hidden text. [/smscoin_key] 


Installation:
===============================================================================
File: smskey.php					Edit-> Save
===============================================================================
1. Open for editing, find block:

	########### SMSCoin key ##########	
		$key_id = 111111;	//sms:key ID number from site smscoin.com
		$s_enc = 'UTF-8';	//Script encoding windows-1251,UTF-8,..
		$tag_name = 'sms';	//Tag name 
		$s_lang = 'english';     //Default interface language
		// Supported laguages:
		//{"russian", "belarusian", "english", "estonian", "french", "german", "hebrew", "latvian", "lithuanian", "romanian", "spanish", "ukrainian"}
	##################################

fill the requested values.


2. Copy the folder "smskey" to ./e107_plugins/ folder.

===============================================================================		
In Admin area :

1. Plugins -> Plugin Manager ->Install






