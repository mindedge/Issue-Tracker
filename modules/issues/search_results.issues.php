<?php
/* $Id: search_results.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if(empty($_POST['criteria'])){
  $_POST['criteria'] = "%";
}

if (@count($_POST['groups']) < 1
or empty($_POST['groups'])) {
  $_POST['groups'] = $_SESSION['groups'];
}

$issues = array();

$links[] = array(
  "img" => $_ENV['imgs']['search'],
  "txt" => "Search Again",
  "url" => "?module=issues&action=search"
);
//pull status, too MWarner 3/10/2010
$sql  = "SELECT DISTINCT i.issueid,i.gid,i.summary,i.status ";
$sql .= "FROM issues i ";
$sql .= "LEFT JOIN issue_groups g USING (issueid) ";
$sql .= "LEFT JOIN events e USING (issueid) ";
$sql .= "WHERE (LOWER(i.problem) LIKE LOWER('%".$_POST['criteria']."%') ";
$sql .= "OR LOWER(i.summary) LIKE LOWER('%".$_POST['criteria']."%') ";
$sql .= "OR LOWER(e.action) LIKE LOWER('%".$_POST['criteria']."%')) ";
$sql .= is_array($_POST['groups']) ? "AND g.gid IN (".implode(",",$_POST['groups']).") " : "";
$sql .= is_array($_POST['opened']) ? "AND i.opened_by IN (".implode(",",$_POST['opened']).") " : "";
$sql .= is_array($_POST['assigned']) ? "AND g.assigned_to IN (".implode(",",$_POST['assigned']).") " : "";
$sql .= is_array($_POST['status']) ? "AND i.status IN (".implode(",",$_POST['status']).") " : "";
$sql .= is_array($_POST['category']) ? "AND i.category IN (".implode(",",$_POST['category']).") " : "";
$sql .= is_array($_POST['product']) ? "AND i.product IN (".implode(",",$_POST['product']).") " : "";
$sql .= "ORDER BY i.issueid ASC";
$issues = $dbi->fetch_all($sql,"array");

$smarty->assign('issues',$issues);
$smarty->display("issues/search_results.tpl");
?>
