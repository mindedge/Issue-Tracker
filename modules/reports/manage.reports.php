<?php
/* $Id: manage.reports.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if ($_GET['subaction'] == "delete" and !empty($_GET['rid'])) {
  if ($_GET['confirm'] == "true") {
    $sql  = "DELETE FROM reports ";
    $sql .= "WHERE rid='".$_GET['rid']."' ";
    $sql .= "AND userid='".$_SESSION['userid']."'";
    $dbi->query($sql);
    redirect("?module=reports&action=manage");
  } 
} else if ($_GET['subaction'] == "rename" and !empty($_GET['rid'])) {
  if ($_GET['confirm'] == "true") {
    if (empty($_POST['reportname'])) {
      push_error("You must enter a name for this report.");
    } else {
      $update['name'] = $_POST['reportname'];
      $dbi->update("reports",$update,"WHERE rid='".$_GET['rid']."'");
      redirect("?module=reports&action=manage");
    }
  } else {
    $sql  = "SELECT name ";
    $sql .= "FROM reports ";
    $sql .= "WHERE rid='".$_GET['rid']."'";
    $name = $dbi->fetch_one($sql);
    if (!empty($name)) {
      $smarty->assign('name',$name);
    }
  }
} else {
  $sql  = "SELECT rid,name ";
  $sql .= "FROM reports ";
  $sql .= "WHERE userid='".$_SESSION['userid']."'";
  $reports = $dbi->fetch_all($sql,"array");
  if (is_array($reports)) {
    $smarty->assign('reports',$reports);
  }
}

$smarty->display("reports/manage.tpl");
?>
