<?php
/* $Id: num_events.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("numevents",$_POST['options'])) {
  if ($_GET['tech'] == "true") {
    $sql  = "SELECT COUNT(eid) ";
    $sql .= "FROM events ";
    $sql .= "WHERE userid='$userid' ";
    $sql .= $_POST['use_date'] == "on" ? "AND performed_on BETWEEN '$sdate' AND '$edate'" : "";
    $events = $dbi->fetch_one($sql);
  } else {
    $issues = null;

    $sql  = "SELECT i.issueid ";
    $sql .= "FROM issues i, issue_groups g ";
    $sql .= "WHERE g.gid = '$gid' ";
    $sql .= "AND g.issueid = i.issueid ";
    $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
    $issues = $dbi->fetch_all($sql);
    if (is_array($issues)) {
      foreach ($issues as $issueid) {
        $sql  = "SELECT COUNT(eid) ";
        $sql .= "FROM events ";
        $sql .= "WHERE issueid='$issueid' ";
        $sql .= $_POST['use_date'] == "on" ? "AND performed_on BETWEEN '$sdate' AND '$edate'" : "";
        $events += $dbi->fetch_one($sql);
      }
    }
  }
  $smarty->assign('numevents',$events);
}
?>
