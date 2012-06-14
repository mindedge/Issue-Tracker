<?php
/* $Id: save.reports.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_POST['reportname'])) {
  push_error("Please enter a name for this report.");
}

if (!errors()) {
  $insert['name'] = $_POST['reportname'];
  $insert['options'] = $_POST['saved'];
  $insert['userid'] = $_SESSION['userid'];
  $id = $dbi->insert("reports",$insert,"reports_rid_seq");
  if (!empty($id)) {
    push_error("Report saved successfully.");
    redirect("?module=reports&action=generate&rid=$id");
  } else {
    push_error("Report could not be saved!");
    redirect("?module=reports");
  }
}

$smarty->assign('saved',$_POST['saved']);
$smarty->display("reports/save.tpl");
?>
