<?php
/* $Id: edit_users.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
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

if ($_GET['submit'] == "true") {
  if (is_array($_POST['addmem'])) {
    foreach ($_POST['addmem'] as $key => $val) {
      group_useradd($val,$_GET['gid']);
    }
  }

  if (is_array($_POST['delmem'])) {
    foreach ($_POST['delmem'] as $key => $val) {
      group_userdel($val,$_GET['gid']);
    }
  }

	redirect("?module=groups&action=edit_users&gid=".$_GET['gid']);
}

$links[] = array(
  "txt" => "Back to Group Information",
  "url" => "?module=groups&action=view&gid=".$_GET['gid'],
  "img" => $_ENV['imgs']['back']
);

$members = group_members($_GET['gid']);
$smarty->assign('members',$members);

$sql  = "SELECT userid,username ";
$sql .= "FROM users ";
$sql .= "ORDER BY username";
$users = $dbi->fetch_all($sql,"array");
$smarty->assign('users',$users);

$smarty->display("groups/edit_users.tpl");
?>
