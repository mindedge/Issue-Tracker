<?php
/* $Id: max_close.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("maxclose",$_POST['options'])) {
  $sql  = "SELECT MAX(i.closed - i.opened) AS maximum ";
  $sql .= "FROM issues i, issue_groups g ";
  $sql .= $_GET['tech'] == "true" ? "WHERE g.assigned_to = '$userid' " : "WHERE g.gid = '$gid' ";
  $sql .= "AND g.issueid=i.issueid ";
  $sql .= "AND i.closed != 0 ";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
  $maximum = $dbi->fetch_one($sql);
  if (!is_null($maximum)) {
    $smarty->assign('maxclose',time_format($maximum));
  } else {
    $smarty->assign('maxclose','No Data Available');
  }
}

