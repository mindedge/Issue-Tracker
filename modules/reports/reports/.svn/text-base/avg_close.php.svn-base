<?php
/* $Id: avg_close.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("avgclose",$_POST['options'])) {
  $sql  = "SELECT AVG(i.closed - i.opened) AS average ";
  $sql .= "FROM issues i, issue_groups g ";
  $sql .= $_GET['tech'] == "true" ? "WHERE g.assigned_to = '$userid' " : "WHERE g.gid = '$gid' ";
  $sql .= "AND g.issueid=i.issueid ";
  $sql .= "AND i.closed != 0 ";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
  $average = $dbi->fetch_one($sql);
  if (!is_null($average)) {
    $smarty->assign('avgclose',time_format($average));
  } else {
    $smarty->assign('avgclose','No Data Available');
  }
}
?>
