<?php
/* $Id: avg_first.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("avgfirst",$_POST['options'])) {
  $sql  = "SELECT AVG(g.first_response - i.opened) AS average ";
  $sql .= "FROM issues i, issue_groups g ";
  $sql .= $_GET['tech'] == "true" ? "WHERE g.assigned_to = '$userid' " : "WHERE g.gid = '$gid' ";
  $sql .= "AND g.issueid=i.issueid ";
  $sql .= "AND g.first_response != 0";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
  $average = $dbi->fetch_one($sql);
  if (!is_null($average)) {
    $smarty->assign('avgfirst',time_format($average));
  } else {
    $smarty->assign('avgfirst',"No Data Available");
  }
}
?>
