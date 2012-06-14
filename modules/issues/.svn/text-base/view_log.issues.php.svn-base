<?php
/* $Id: view_log.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_GET['issueid'])) {
  redirect();
}

if(can_view_issue($_GET['issueid'])){
  $links[] = array(
    "txt" => "Back to Issue",
    "url" => "?module=issues&action=view&issueid=".$_GET['issueid'],
    "img" => $_ENV['imgs']['back']
  );

  $sql  = "SELECT userid,logged,message,private ";
	$sql .= "FROM issue_log ";
	$sql .= "WHERE issueid='".$_GET['issueid']."' ";
  $sql .= !is_employee($_SESSION['userid']) ? "AND private != 't' " : "";
	$sql .= "ORDER BY logged";
  $messages = $dbi->fetch_all($sql,"array");
  $smarty->assign('messages',$messages);

  //modified SQL to get formatted date so the template would work right MWarner 2/23/2010
  $sql  = "SELECT *,date_format(from_unixtime(due_date),'%m/%d/%Y') as due_date ";
  $sql .= "FROM issues ";
  $sql .= "WHERE issueid='".$_GET['issueid']."'";
  $issue = $dbi->fetch_row($sql,"array");
  $smarty->assign('issue',$issue);
  $smarty->assign('assigned',issue_assigned($_GET['issueid']));
  $smarty->display("issues/view.tpl");
  $smarty->display("issues/view_log.tpl");
} else {
  redirect();
}
?>
