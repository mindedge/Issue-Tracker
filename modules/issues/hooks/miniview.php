<?php
/* $Id: miniview.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

list($registered) = fetch_status(TYPE_REGISTERED);
$closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

if (is_employee($_SESSION['userid'])) {
  $group_status = array();
  foreach ($_SESSION['groups'] as $gid) {
    $group_status[$gid]['new'] = num_new_issues($gid);
    $group_status[$gid]['open'] = num_open_issues($gid);
	//new count closed MWarner 2/23/2010
	$group_status[$gid]['closed'] = num_closed_issues($gid);
	
    for ($x = 1;$x < 5;$x++) {
      $sql  = "SELECT COUNT(i.issueid) ";
      $sql .= "FROM issues i, issue_groups g ";
      $sql .= "WHERE g.gid='$gid' ";
      $sql .= "AND i.issueid=g.issueid ";
      $sql .= "AND i.severity='$x' ";
      $sql .= "AND i.status NOT IN ($closed) ";
      $sql .= "AND g.show_issue='t'";
      $count = $dbi->fetch_one($sql);
      $group_status[$gid]["sev$x"] = $count;
      unset($count);
    }

    $group_status[$gid]['name'] = group_name($gid);

    $sql  = "SELECT standing ";
    $sql .= "FROM status_reports ";
    $sql .= "WHERE gid='$gid'";
    $standing = $dbi->fetch_one($sql);
    if (!empty($standing)) {
      $group_status[$gid]['rating'] = $standing;
    }

    $group_status[$gid]['rating'] += $group_status[$gid]['sev4'] * .5;
    $group_status[$gid]['rating'] += $group_status[$gid]['sev3'] * 1;
    $group_status[$gid]['rating'] += $group_status[$gid]['sev2'] * 2;
    $group_status[$gid]['rating'] += $group_status[$gid]['sev1'] * 3;

    if ($group_status[$gid]['rating'] >= 50) {
      $group_status[$gid]['standing'] = $_ENV['imgs']['urgent'];
    } else if ($group_status[$gid]['rating'] >= 25) {
      $group_status[$gid]['standing'] = $_ENV['imgs']['high'];
    } else {
      $group_status[$gid]['standing'] = $_ENV['imgs']['normal'];
    }
  }
  $smarty->assign('group_status',$group_status);
  $smarty->display("issues/group_status_miniview.tpl");
}

$ugroups = implode(",",$_SESSION['groups']);
$sql  = "SELECT issueid,summary,modified,status,gid ";
$sql .= "FROM issues ";
$sql .= "WHERE gid IN ($ugroups) ";
$sql .= "AND status NOT IN ($closed) ";
$sql .= "ORDER BY modified DESC LIMIT 5";
$issues = $dbi->fetch_all($sql,"array");
$smarty->assign('last_issues',$issues);

$sql  = "SELECT issueid,gid,summary,modified,status ";
$sql .= "FROM issues ";
$sql .= "WHERE opened_by='".$_SESSION['userid']."' ";
$sql .= "AND status NOT IN ($closed) ";
$sql .= "ORDER BY modified DESC LIMIT 5";
$issues = $dbi->fetch_all($sql,"array");
$smarty->assign('opened_issues',$issues);

$sql  = "SELECT t.issueid,g.gid,t.summary,t.modified,t.status ";
$sql .= "FROM issues t, issue_groups g ";
$sql .= "WHERE g.assigned_to='".$_SESSION['userid']."' ";
$sql .= "AND t.status NOT IN ($closed) ";
$sql .= "AND t.issueid = g.issueid ";
$sql .= "ORDER BY t.modified DESC LIMIT 5";
$issues = $dbi->fetch_all($sql,"array");
$smarty->assign('assigned_issues',$issues);

$smarty->display("issues/miniview.tpl");
?>
