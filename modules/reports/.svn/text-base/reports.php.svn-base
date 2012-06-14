<?php
/* $Id: reports.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
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
  "pertech"     => "Issues Per Technician",
  "opened"      => "Number of Issues Opened",
  "resolved"    => "Number of Issues Resolved",
  "numevents"   => "Number of Events Entered"
);
  
if (is_employee()) {
  $options['escto'] = "Issues Escalated To Group";
  $options['escfrom'] = "Issues Escalated From Group";
  $options['numhours'] = "Number of Hours Logged";
  
  if (is_manager()) {
    $sql  = "SELECT gid ";
    $sql .= "FROM groups ";
    $sql .= "ORDER BY name";
    $groups = $dbi->fetch_all($sql);
    $smarty->assign('groups',$groups);
  } else {
    $smarty->assign('groups',$_SESSION['groups']);
  }

  $template = "reports/employee.tpl";
} else {
  if (empty($_POST['gid']) and $_SESSION['group_count'] == 1) {
    $_POST['gid'] = $_SESSION['groups'][0];
  }

  $template = "reports/client.tpl";
}

$saved = array();
$sql  = "SELECT rid,name ";
$sql .= "FROM reports ";
$sql .= "WHERE userid='".$_SESSION['userid']."' ";
$sql .= "ORDER BY name";
$reports = $dbi->fetch_all($sql,"array");
if (is_array($reports)) {
  foreach ($reports as $report) {
    $saved[$report['rid']] = $report['name'];
  }
}
$smarty->assign('saved',$saved);
$smarty->assign('options',$options);
$smarty->assign('fields',$fields);
$smarty->display($template);
?>
