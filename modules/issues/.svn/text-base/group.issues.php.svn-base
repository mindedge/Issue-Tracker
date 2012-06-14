<?php
/* $Id: group.issues.php 3 2004-08-09 23:22:56Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

// make sure gid is not empty, if it is then make the user go back and
// choose which groups issues they want to see
if(empty($_GET['gid']) or !user_in_group($_GET['gid'])){
	redirect("?module=groups");
} else {
	if (permission_check("create_issues",$_GET['gid'])) {
    $links[] = array(
      "img" => $_ENV['imgs']['new_issue'],
      "txt" => " Create Issue ",
      "url" => "?module=issues&action=new&gid=".$_GET['gid']
    );
  }

  if($_GET['showall'] != "true"){
    $links[] = array(
      "img" => $_ENV['imgs']['show_closed'],
      "txt" => " Show Closed ",
      "url" => "?module=issues&action=group&showall=true&gid=".$_GET['gid']
    );
  } else {
    $links[] = array(
      "img" => $_ENV['imgs']['hide_closed'],
      "txt" => " Hide Closed ",
      "url" => "?module=issues&action=group&showall=false&gid=".$_GET['gid']
    );
  }

  // Make sure we have something to sort by
	if (empty($_GET['sort'])) {
		$_GET['sort'] = $_SESSION['sort'];
	}

  $rows = group_issues($_GET['gid']);
  $show_private = permission_check("view_private",$_GET['gid']);
  foreach ($rows as $key => $val) {
    $rows[$key]['unread'] = unread_events($key,$_SESSION['userid'],$show_private);
    $rows[$key]['escto'] = issue_escalated_to($key,$_GET['gid']);
    $rows[$key]['escfrom'] = issue_escalated_from($key,$_GET['gid']);
  }
  $num_rows = count($rows);
	$colspan = count($_SESSION['prefs']['show_fields']) + 3;//change to +3 (was +2), as due_date now displayed MWarner 3/23/2010
  $title = "Issues :: ".group_name($_GET['gid'])." (Displaying $num_rows Issues)";
  $smarty->assign('colspan',$colspan);
  $smarty->assign('title',$title);
  $smarty->assign('rows',$rows);
  $smarty->assign('num_rows',$num_rows);

	$url  = "?module=issues&action=group&gid=".$_GET['gid'];
  $url .= $_GET['showall'] == "true" ? "&showall=true" : "";
  $smarty->assign('url',$url);

  $smarty->display("issues/group.tpl");
}
?>
