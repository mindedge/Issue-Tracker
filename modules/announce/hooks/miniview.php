<?php
/* $Id: miniview.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

$sql  = "SELECT a.aid,a.title,a.message,a.posted,u.username ";
$sql .= "FROM announcements a,users u ";
$sql .= "WHERE a.is_global='t' ";
$sql .= "AND u.userid=a.userid ";
$sql .= "ORDER BY a.aid DESC LIMIT 1";
$result = $dbi->query($sql);
if($dbi->num_rows($result) > 0){
  $system = $dbi->fetch($result,"array");
  $smarty->assign('system',$system);
}

$groups = implode(",",$_SESSION['groups']);
$sql  = "SELECT aid ";
$sql .= "FROM announce_permissions ";
$sql .= "WHERE gid IN ($groups)";
$a = $dbi->fetch_all($sql);
if (!is_null($a)) {
  $a = implode(",",$a);
  $sql  = "SELECT aid,title ";
  $sql .= "FROM announcements ";
  $sql .= "WHERE aid IN ($a) ";
  $sql .= "AND posted > '".(time() - _WEEK_)."' ";
  $sql .= "ORDER BY aid DESC";
  $a = $dbi->fetch_all($sql,"array");
  $smarty->assign('announcements',$a);
}

$smarty->display("announce/miniview.tpl");
?>
