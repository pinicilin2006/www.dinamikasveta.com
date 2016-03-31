if (ADMIN) {
	global $ns, $pref;
	if (!($handle=opendir(e_LANGUAGEDIR.e_LANGUAGE."/admin/help/"))) {
		$handle=opendir(e_LANGUAGEDIR."English/admin/help/");
	}
	ob_start();
	$text = "";
	while(false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && $file != "CVS") {
			if (strpos(e_SELF, $file) !== FALSE) {
				if (is_readable(e_LANGUAGEDIR.e_LANGUAGE."/admin/help/".$file)) {
					include_once(e_LANGUAGEDIR.e_LANGUAGE."/admin/help/".$file);
				} else if (is_readable(e_LANGUAGEDIR."English/admin/help/".$file)) {
					include_once(e_LANGUAGEDIR."English/admin/help/".$file);
				}
			}
		}
	}
	closedir($handle);
   $plugpath = getcwd()."/help.php";
	if(file_exists($plugpath))
	{
		@require_once($plugpath);
	}
	$help_text = ob_get_contents();
	ob_end_clean();
	return $help_text;
}


