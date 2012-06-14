<?php
/* $Id: choose.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

$ugroups = implode(",",$_SESSION['groups']);

$sql  = "SELECT gid,name ";
$sql .= "FROM groups ";
$sql .= "WHERE active='t' ";

if (!empty($_GET['start'])) {
	$sql .= $_GET['start'] != "ALL" ? "AND UPPER(name) LIKE '".$_GET['start']."%' " : "";

	if (!is_employee()) {
		$sql .= "AND gid IN ($ugroups) ";
	}
} else {
	$sql .= "AND gid IN ($ugroups) ";
}
	
$sql .= "ORDER BY name";
$groups = $dbi->fetch_all($sql,"array");
$count = count($groups);

for ($x = 0;$x < $count;$x++) {
  $groups[$x]['new'] = num_new_issues($groups[$x]['gid']);
  $groups[$x]['open'] = num_open_issues($groups[$x]['gid']);
	$last	= last_activity($groups[$x]['gid']);
  $groups[$x]['date'] = $last['date'];
  $groups[$x]['user'] = $last['user'];
}

$smarty->assign('groups',$groups);
$smarty->display("issues/choose.tpl");
?>
