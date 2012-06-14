<?php
/* $Id: tech.reports.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (!is_manager()) {
  redirect();
}

$fields = array(
  "assigned_to" => "Technician Assigned",
  "opened_by"   => "Issue Owner (Opened By)",
  "opened"      => "Time Opened",
  "closed"      => "Time Closed",
  "modified"    => "Last Modified",
  "status"      => "Issue Status",
  "category"    => "Issue Category",
  "product"     => "Issue Product",
  "severity"    => "Issue Severity",
  "problem"     => "Issue Problem"
);

$options = array(
  "avgclose"    => "Average Resolution Time",
  "maxclose"    => "Maximum Resolution Time",
  "avgfirst"    => "Average Time for First Response",
  "maxfirst"    => "Maximum Time for First Response",
  "percat"      => "Issues Per Category",
  "perstat"     => "Issues Per Status",
  "perprod"     => "Issues Per Product",
  "persev"      => "Issues Per Severity",
  "opened"      => "Number of Issues Opened",
  "resolved"    => "Number of Issues Resolved",
  "numevents"   => "Number of Events Entered",
  "numhours"    => "Number of Hours Logged"
);
  
$sql  = "SELECT userid,username ";
$sql .= "FROM users ";
$sql .= "ORDER BY username";
$users = $dbi->fetch_all($sql,"array");
$smarty->assign('users',$users);
$smarty->assign('fields',$fields);
$smarty->assign('options',$options);
$smarty->display("reports/tech.tpl");
?>
