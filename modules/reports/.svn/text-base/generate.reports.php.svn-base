<?php
/* $Id: generate.reports.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_GET['rid']) and !empty($_POST['rid'])) {
  $_GET['rid'] = $_POST['rid'];
}

set_time_limit(_MINUTE_ * 10);

if (!empty($_GET['rid'])) {
  $sql  = "SELECT name,options ";
  $sql .= "FROM reports ";
  $sql .= "WHERE rid='".$_GET['rid']."' ";
  $sql .= "AND userid='".$_SESSION['userid']."'";
  list($name,$options) = $dbi->fetch_row($sql);
  if (!empty($options)) {
    $smarty->assign('save_name',$name);
    $_POST = unserialize($options);
  }
}

// If we dont have gid(s) to pull information for then we
// can't generate a report
if ($_GET['tech'] == "true" and is_manager()) {
  if (!is_array($_POST['userid'])) {
    push_error("You must select at least one user to generate a report for.");
  } 
} else {
  if (empty($_POST['gid'])) {
    push_error("You must select at least one group to generate a report for.");
  }
}

// If use_date is turned on then make sure we have
// correctly formed dates
if ($_POST['use_date'] == "on") {
  if (!preg_match("[0-9]{1,2}\/[0-9]{1,2}\/[1-2][0-9]{3}",$_POST['sdate'])) {
    push_error("Start date must be in the format mm/dd/yyyy. (ex. 08/10/1981)");
  }

  if (!preg_match("[0-9]{1,2}\/[0-9]{1,2}\/[1-2][0-9]{3}",$_POST['edate'])) {
    push_error("End date must be in the format mm/dd/yyyy. (ex. 08/10/1981)");
  }
}

if (!errors()) {
  if ($_POST['use_date'] == "on") {
    $parts = explode("/",$_POST['sdate']);
    $sdate = mktime(0,0,0,$parts[0],$parts[1],$parts[2]);
    $parts = explode("/",$_POST['edate']);
    $edate = mktime(0,0,0,$parts[0],$parts[1],$parts[2]);
  }

  $saved = serialize($_POST);
  $smarty->assign('saved',$saved);
  $smarty->display("reports/save.tpl");

  if ($_GET['tech'] == "true" and is_manager()) {
    if (is_array($_POST['userid'])) {
      foreach ($_POST['userid'] as $userid) {
        generate_tech_report($userid,$sdate,$edate);
      }
    } else {
      generate_tech_report($userid,$sdate,$edate);
    }
  } else {
    if (is_array($_POST['gid'])) {
      foreach ($_POST['gid'] as $gid) {
        generate_report($gid,$sdate,$edate);
      }
    } else {
      generate_report($_POST['gid'],$sdate,$edate);
    }
  }
} else {
  if ($_GET['tech'] == "true") {
    include_once(_REPORTS_."tech.reports.php");
  } else {
    include_once(_REPORTS_."reports.php");
  }
}
?>
