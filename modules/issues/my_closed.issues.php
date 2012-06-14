<?php
/* $Id: my_closed.issues.php 2 2010-02-03 MWarner $ */
/** 
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}
/*
if($_GET['showall'] != "true"){
  $links[] = array(
    "img" => $_ENV['imgs']['show_clsoed'],
    "txt" => " Show Closed ",
    "url" => "?module=issues&action=my_closed&showall=true&gid=".$_GET['gid']
  );
} else {
  $links[] = array(
    "img" => $_ENV['imgs']['hide_closed'],
    "txt" => " Hide Closed ",
    "url" => "?module=issues&action=my_closed&showall=false&gid=".$_GET['gid']
  );
}
*/
// fetch needed statuses
list($registered) = fetch_status(TYPE_REGISTERED);
$closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

// Make sure we have something to sort by
if (empty($_GET['sort'])) {
  $_GET['sort'] = "status";
}

$url  = "?module=issues&action=my_closed$show$reverse";
$url .= $_GET['showall'] != "true" ? "&showall=true" : "";
$url .= $_GET['reverse'] != "true" ? "&reverse=true" : "";
$smarty->assign('url',$url);
//to format the closed date
//date_format(from_unixtime(due_date),'%m/%d/%Y') as due_date
$sql  = "SELECT i.issueid,i.summary,i.closed,i.opened_by,i.status,g.gid,i.severity,i.product ";
$sql .= "FROM issues i,issue_groups g";
$sql .= $_GET['sort'] == "opened_by" ? ",users u " : " ";
$sql .= "WHERE g.assigned_to='".$_SESSION['userid']."' ";
$sql .= "AND i.status IN ($closed) ";
$sql .= "AND i.issueid=g.issueid ";

switch ($_GET['sort']) {
	case "opened_by":
		$sql .= "AND u.userid=t.".$_GET['sort']." DESC ";
		$sql .= "ORDER BY u.username ";
		break;
	default:
		$sql .= "ORDER BY i.".$_GET['sort']." DESC ";
		break;
}

$issues = $dbi->fetch_all($sql,"array");

$smarty->assign('issues',$issues);
$smarty->display("issues/my_closed.tpl");
?>
