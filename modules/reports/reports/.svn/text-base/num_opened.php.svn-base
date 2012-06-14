<?php
/* $Id: num_opened.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("opened",$_POST['options'])) {
  $sql  = "SELECT COUNT(issueid) ";
  $sql .= "FROM issues ";
  $sql .= $_GET['tech'] == "true" ? "WHERE opened_by = '$userid' " : "WHERE gid='$gid' ";
  $sql .= $_POST['use_date'] == "on" ? "AND opened BETWEEN '$sdate' AND '$edate'" : "";
  $opened = $dbi->fetch_one($sql);
  $smarty->assign('numopened',$opened);
}
?>
