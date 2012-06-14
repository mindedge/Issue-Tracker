<?php
/* $Id: num_resolved.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("resolved",$_POST['options'])) {
  $closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));
  
  $sql  = "SELECT COUNT(i.issueid) ";
  $sql .= "FROM issues i, issue_groups g ";
  $sql .= $_GET['tech'] == "true" ? "WHERE g.assigned_to = '$userid' " : "WHERE g.gid='$gid' ";
  $sql .= "AND g.issueid=i.issueid ";
  $sql .= "AND i.status IN ($closed) ";
  $sql .= $_POST['use_date'] == "on" ? "AND i.closed BETWEEN '$sdate' AND '$edate'" : "";
  $closed = $dbi->fetch_one($sql);
  $smarty->assign('numresolved',$closed);
}
?>
