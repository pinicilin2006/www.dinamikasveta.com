//USAGE:  {EXTENDED=<field_name>.[text|value|icon|text_value].<user_id>}
//EXAMPLE: {EXTENDED=gender.value.5}  will show the value of the extended field user_gender for user #5
include(e_LANGUAGEDIR.e_LANGUAGE."/lan_user_extended.php");
$parms = explode(".", $parm);
global $currentUser, $sql, $tp, $loop_uid, $e107, $sc_style;
if(isset($loop_uid) && intval($loop_uid) == 0) { return ""; }
$key = $parms[0].".".$parms[1];
$sc_style['USER_EXTENDED']['pre'] = (isset($sc_style['USER_EXTENDED'][$key]['pre']) ? $sc_style['USER_EXTENDED'][$key]['pre'] : "");
$sc_style['USER_EXTENDED']['post'] = (isset($sc_style['USER_EXTENDED'][$key]['post']) ? $sc_style['USER_EXTENDED'][$key]['post'] : "");
include_once(e_HANDLER."user_extended_class.php");
$ueStruct = e107_user_extended::user_extended_getStruct();

$uid = intval($parms[2]);
if($uid == 0)
{
	if(isset($loop_uid) && intval($loop_uid) > 0)
	{
		$uid = $loop_uid;
	}
	else
	{
		$uid = USERID;
	}
}

$udata = get_user_data($uid);

$udata['user_class'] .= ($udata['user_class'] == "" ? "" : ",");
$udata['user_class'] .= e_UC_PUBLIC.",".e_UC_MEMBER;
if($udata['user_admin'] == 1)
{
	$udata['user_class'].= ",".e_UC_ADMIN;
}

if (
!check_class($ueStruct["user_".$parms[0]]['user_extended_struct_applicable'], $udata['user_class'])
|| !check_class($ueStruct["user_".$parms[0]]['user_extended_struct_read'])
|| ($ueStruct["user_".$parms[0]]['user_extended_struct_read'] == e_UC_READONLY && (!ADMIN && $udata['user_id'] != USERID))
|| (!ADMIN && substr($ueStruct["user_".$parms[0]]['user_extended_struct_parms'], -1) == 1 
&& strpos($udata['user_hidden_fields'], "^user_".$parms[0]."^") !== FALSE && $uid != USERID)
)
{
	return FALSE;
}

if($parms[1] == 'text_value')
{
	$_value = $tp->parseTemplate("{USER_EXTENDED={$parms[0]}.value}");
	if($_value)
	{
		$__pre = (isset($sc_style['USER_EXTENDED'][$key]['pre']) ? $sc_style['USER_EXTENDED'][$key]['pre'] : "");
		$__post = (isset($sc_style['USER_EXTENDED'][$key]['post']) ? $sc_style['USER_EXTENDED'][$key]['post'] : "");
		$_text = $tp->parseTemplate("{USER_EXTENDED={$parms[0]}.text}");
		$_mid = (isset($sc_style['USER_EXTENDED'][$key]['mid']) ? $sc_style['USER_EXTENDED'][$key]['mid'] : "");
		return $__pre.$_text.$_mid.$_value.$__post;
	}
	return false;
}

if ($parms[1] == 'text')
{
	$text_val = $ueStruct["user_".$parms[0]]['user_extended_struct_text'];
	if($text_val)
	{
		return (defined($text_val) ? constant($text_val) : $text_val);
	}
	else
	{
		return TRUE;
	}
}

if ($parms[1] == 'icon')
{
	if(defined(strtoupper($parms[0])."_ICON"))
	{
		return constant(strtoupper($parms[0])."_ICON");
	}
	elseif(file_exists(e_IMAGE."user_icons/{$parms[0]}.png"))
	{
		return "<img src='".e_IMAGE."user_icons/{$parms[0]}.png' style='width:16px; height:16px' alt='' />";
	}
	return "";
}

if ($parms[1] == 'value')
{
	$uVal = str_replace(chr(1), "", $udata['user_'.$parms[0]]);
	// check for db_lookup type
	if($ueStruct["user_".$parms[0]]['user_extended_struct_type'] == '4')
	{
		$tmp = explode(",",$ueStruct["user_".$parms[0]]['user_extended_struct_values']);
		if($sql->db_Select($tmp[0],"{$tmp[1]}, {$tmp[2]}","{$tmp[1]} = '{$uVal}'"))
		{
			$row = $sql->db_Fetch();
			$ret_data = $row[$tmp[2]];
		}
		else
		{
			$ret_data = FALSE;
		}
	}
	else
	{
		//check for 0000-00-00 in date field
		if($ueStruct["user_".$parms[0]]['user_extended_struct_type'] == '7')
		{
			if($uVal == "0000-00-00") { $uVal = ""; }
		}
		$ret_data = $uVal;
	}
	if($ret_data != "")
	{
		return $tp->toHTML($ret_data, TRUE, "no_make_clickable", "class:{$udata['user_class']}");
	}
	return FALSE;
}
return FALSE;
