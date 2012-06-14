<?php
/* $Id: status.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Groups
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (!is_employee()) {
  redirect();
}

if (!empty($_POST['info']) and $_GET['update'] == "true") {
	if (permission_check("technician",$_GET['gid']) or is_manager()) {
    $insert['gid']          = $_GET['gid'];
    $insert['userid']       = $_SESSION['userid'];
    $insert['date_entered'] = time();
    $insert['info']         = addslashes($_POST['info']);
    $insert['standing']     = $_POST['stand'];
    $dbi->insert("status_reports",$insert);
    redirect("?module=groups&action=status");
  } else {
    redirect("?module=groups&action=status");
  }
}

if ($_GET['history'] == "true"
and (permission_check("technician",$_GET['gid']) or is_manager())) {
  $sql  = "SELECT userid,date_entered,info,standing ";
  $sql .= "FROM status_reports ";
  $sql .= "WHERE gid='".$_GET['gid']."' ";
  $sql .= "ORDER BY date_entered DESC";
  $history = $dbi->fetch_all($sql,"array");
  $smarty->assign('history',$history);

  $smarty->display("groups/status/history.tpl");
}

if (!empty($_GET['gid'])) {
  $smarty->display("groups/status/update.tpl");
	$html->form("/");
} else {
  $ugroups = implode(",",$_SESSION['groups']);
  
  $sql  = "SELECT gid,name,end_date ";
  $sql .= "FROM groups ";
  $sql .= "WHERE status_reports = 't' ";
  $sql .= !is_manager() ? "AND gid IN ($ugroups) " : "";
  $sql .= "ORDER BY name";
  $groups = $dbi->fetch_all($sql,"array");
  if (is_array($groups)) {
    foreach ($groups as $group) {
      $sql  = "SELECT userid,date_entered,info,standing ";
      $sql .= "FROM status_reports ";
      $sql .= "WHERE gid='".$group['gid']."' ";
      $sql .= "ORDER BY date_entered DESC LIMIT 1";
      $info = $dbi->fetch_row($sql,"array");
      $summary[] = array_merge($group,$info);
    }
  }

  $smarty->assign('groups',$summary);
  $smarty->display("groups/status/summary.tpl");
}
