<?php
/* $Id: my_assigned.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if($_GET['showall'] != "true"){
  $links[] = array(
    "img" => $_ENV['imgs']['show_closed'],
    "txt" => " Show Closed ",
    "url" => "?module=issues&action=my_assigned&showall=true&gid=".$_GET['gid']
  );
} else {
  $links[] = array(
    "img" => $_ENV['imgs']['hide_closed'],
    "txt" => " Hide Closed ",
    "url" => "?module=issues&action=my_assigned&showall=false&gid=".$_GET['gid']
  );
}

// retrieve needed statuses
list($registered) = fetch_status(TYPE_REGISTERED);
$closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

// Make sure we have something to sort by
if (empty($_GET['sort'])) {
  $_GET['sort'] = "status";
}

$url  = "?module=issues&action=my_assigned$show$reverse";
$url .= $_GET['showall'] != "true" ? "&showall=true" : "";
$url .= $_GET['reverse'] != "true" ? "&reverse=true" : "";
$smarty->assign('url',$url);

// now show the rest of the issues
// pull product, too MWarner 2/2/2010
// pull due_date, doo MWarner 3/23/2010
$sql  = "SELECT i.issueid,i.summary,i.opened_by,i.status,g.gid,i.severity,i.product, i.due_date ";
$sql .= "FROM issues i,issue_groups g";
$sql .= ($_GET['sort'] == "opened_by")?",users u ":" ";
$sql .= "WHERE g.assigned_to='".$_SESSION['userid']."' ";
//show these, too MWarner 1/28/2010
//$sql .= "AND i.status != '$registered' ";
$sql .= $_GET['showall'] != "true" ? "AND i.status NOT IN ($closed) " : "";
$sql .= "AND i.issueid=g.issueid ";

switch ($_GET['sort']) {
	case "opened_by":
		$sql .= " AND u.userid=i.".$_GET['sort'];//changed t. to i. to reference correctly MWarner 3/15/2010
		$sql .= " ORDER BY u.username "." DESC ";//added a space before ORDER and moved DESC to the order by part MWarner 3/15/2010
		break;
	default:
		$sql .=  "ORDER BY i.".$_GET['sort']." DESC ";
		break;
}

$issues = $dbi->fetch_all($sql,"array");
$table_title="My Assigned Issues (Displaying ".count($issues)." Issues)";//show num assigned in table title MWarner 2/23/2010
$smarty->assign('issues',$issues);//show num assigned in table title MWarner 2/23/2010
$smarty->assign('table_title',$table_title);
$smarty->display("issues/my_assigned.tpl");
?>
