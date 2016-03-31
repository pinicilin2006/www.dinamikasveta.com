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
|     $Source: /cvsroot/e107/e107_0.7/e107_plugins/forum/forum_mod.php,v $
|     $Revision: 1.10 $
|     $Date: 2006/01/05 09:06:46 $
|     $Author: sweetas $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

@include_once e_PLUGIN.'forum/languages/'.e_LANGUAGE.'/lan_forum_admin.php';
@include_once e_PLUGIN.'forum/languages/English/lan_forum_admin.php';
	
function forum_thread_moderate($p)
{
	global $sql;
	foreach($p as $key => $val) {
		if (preg_match("#(.*?)_(\d+)_x#", $key, $matches))
		{
			$act = $matches[1];
			$id = intval($matches[2]);
			 
			switch($act)
			{
				case 'lock' :
				$sql->db_Update("forum_t", "thread_active='0' WHERE thread_id='$id' ");
				return FORLAN_CLOSE;
				break;
				 
				case 'unlock' :
				$sql->db_Update("forum_t", "thread_active='1' WHERE thread_id='$id' ");
				return FORLAN_OPEN;
				break;
				 
				case 'stick' :
				$sql->db_Update("forum_t", "thread_s='1' WHERE thread_id='$id' ");
				return FORLAN_STICK;
				break;
				 
				case 'unstick' :
				$sql->db_Update("forum_t", "thread_s='0' WHERE thread_id='$id' ");
				return FORLAN_UNSTICK;
				break;
				 
				case 'delete' :
				return forum_delete_thread($id);
				break;
				 
			}
		}
	}
}
	
function forum_delete_thread($thread_id)
{
	global $sql;
	@require_once(e_PLUGIN.'forum/forum_class.php');
	$f =& new e107forum;
	$sql->db_Select("forum_t", "*", "thread_id='".intval($thread_id)."' ");
	$row = $sql->db_Fetch();
	 
	if ($row['thread_parent'])
	{
		// post is a reply?
		$sql->db_Delete("forum_t", "thread_id='".intval($thread_id)."' ");
		// dec forum reply count by 1
		$sql->db_Update("forum", "forum_replies=forum_replies-1 WHERE forum_id='".$row['thread_forum_id']."'");
		// dec thread reply count by 1
		$sql->db_Update("forum_t", "thread_total_replies=thread_total_replies-1 WHERE thread_id='".$row['thread_parent']."'");
		// dec user forum post count by 1
		$tmp = explode(".", $row['thread_user']);
		$uid = intval($tmp[0]);
		if($uid > 0)
		{
			$sql->db_Update("user", "user_forums=user_forums-1 WHERE user_id='".$uid."'");
		}
		// update lastpost info
		$f->update_lastpost('thread', $row['thread_parent']);
		$f->update_lastpost('forum', $row['thread_forum_id']);
		return FORLAN_154;
	}
	else
	{
		// post is thread
		// delete poll if there is one
		$sql->db_Delete("poll", "poll_datestamp='".intval($thread_id)."'");
		//decrement user post counts
		forum_userpost_count("WHERE thread_id = '".intval($thread_id)."' OR thread_parent = '".intval($thread_id)."'", "dec");
		// delete replies and grab how many there were
		$count = $sql->db_Delete("forum_t", "thread_parent='".intval($thread_id)."'");
		// delete the post itself
		$sql->db_Delete("forum_t", "thread_id='".intval($thread_id)."'");
		// update thread/reply counts
		$sql->db_Update("forum", "forum_threads=forum_threads-1, forum_replies=forum_replies-$count WHERE forum_id='".$row['thread_forum_id']."'");
		// update lastpost info
		$f->update_lastpost('forum', $row['thread_forum_id']);
		return FORLAN_6.($count ? ", ".$count." ".FORLAN_7."." : ".");
	}
}

function forum_userpost_count($where = "", $type = "dec")
{
	global $sql;

	$qry = "
	SELECT thread_user, count(thread_user) AS cnt FROM #forum_t 
	{$where}
	GROUP BY thread_user
	";

	if($sql->db_Select_gen($qry))
	{
		$uList = $sql->db_getList();
		foreach($uList as $u)
		{
			$tmp = explode(".", $u['thread_user']);
			$uid = intval($tmp[0]);
			if($uid > 0)
			{
				if("set" == $type)
				{
					$sql->db_Update("user", "user_forums={$u['cnt']} WHERE user_id='".$uid."'");
				}
				else
				{
					$sql->db_Update("user", "user_forums=user_forums-{$u['cnt']} WHERE user_id='".$uid."'");
				}
			}
		}
	}
}
?>