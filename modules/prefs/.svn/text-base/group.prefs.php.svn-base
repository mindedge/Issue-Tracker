<?php
/* $Id: group.prefs.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Preferences
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if ($_GET['submit'] == "true") {
  foreach ($_SESSION['groups'] as $key => $val) {
    if ($_POST[('notemail'.$val)] == "on") {
      notify_add($_SESSION['userid'],$val,"E");
    } else {
      notify_del($_SESSION['userid'],$val,"E");
    }

    if ($_POST[('notsms'.$val)] == "on") {
      notify_add($_SESSION['userid'],$val,"S");
    } else {
      notify_del($_SESSION['userid'],$val,"S");
    }

    $update["show_group"]   = $_POST[('show'.$val)] == "on" ? "t" : "f";
    $update["severity"]     = $_POST[('pty'.$val)];
    $dbi->update("group_users",$update,"WHERE userid='".$_SESSION['userid']."' AND gid='$val'");
    unset($update);
  }
}

$ugroups = implode(",",$_SESSION['groups']);
$sql  = "SELECT g.gid,g.name,u.show_group,u.severity ";
$sql .= "FROM group_users u, groups g ";
$sql .= "WHERE u.gid IN ($ugroups) ";
$sql .= "AND u.userid='".$_SESSION['userid']."' ";
$sql .= "AND g.gid=u.gid ";
$sql .= "ORDER BY g.name";
$groups = $dbi->fetch_all($sql,"array");
$smarty->assign('groups',$groups);
$smarty->assign('severities',$severities);
$smarty->display("prefs/group.tpl");
?>
