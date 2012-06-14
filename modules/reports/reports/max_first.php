<?php
/* $Id: max_first.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("maxfirst",$_POST['options'])) {
  $sql  = "SELECT MAX(g.first_response - i.opened) AS maximum ";
  $sql .= "FROM issues i, issue_groups g ";
  $sql .= $_GET['tech'] == "true" ? "WHERE g.assigned_to = '$userid' " : "WHERE g.gid = '$gid' ";
  $sql .= "AND g.issueid=i.issueid ";
  $sql .= "AND g.first_response != 0";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
  $maximum = $dbi->fetch_one($sql);
  if (!empty($maximum)) {
    $smarty->assign('maxfirst',time_format($maximum));
  } else {
    $smarty->assign('maxfirst',"No Data Available");
  }
}
?>
