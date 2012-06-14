<?php
/* $Id: move_issue.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_GET['issueid'])) {
  redirect();
}

if (!issue_priv($_GET['issueid'],"move_issues")) {
  redirect();
}

if ($_POST['confirm'] == "true" and !empty($_POST['gid'])) {
  $sql  = "SELECT g.name ";
  $sql .= "FROM issues i, groups g ";
  $sql .= "WHERE i.issueid='".$_GET['issueid']."' ";
  $sql .= "AND i.gid = g.gid";
  $name = $dbi->fetch_one($sql);

  $sql  = "DELETE FROM issue_groups ";
  $sql .= "WHERE issueid='".$_GET['issueid']."'";
  $dbi->query($sql);
  $insert['issueid'] = $_GET['issueid'];
  $insert['gid'] = $_POST['gid'];
  $insert['opened'] = time();
  $insert['show_issue'] = "t";
  $dbi->insert("issue_groups",$insert);
  unset($insert);
  $update['gid'] = $_POST['gid'];
  $dbi->update("issues",$update,"WHERE issueid='".$_GET['issueid']."'");
  unset($update);
  issue_log($_GET['issueid'],"Issue moved to ".group_name($_POST['gid'])." from $name.");
  redirect("?module=issues&action=view&issueid=".$_GET['issueid']);
}

$smarty->display("issues/move.tpl");
?> 
