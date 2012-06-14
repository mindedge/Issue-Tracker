<?php
/* $Id: view.users.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Users
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (!is_employee()) {
  redirect();
}

// reset user's password
if(!empty($_GET['uid']) and $_GET['newpass'] == "TRUE"){
	reset_passwd($_GET['uid']);
}

$links[] = array(
	"txt"	=> "Reset Password",
	"url"	=> "?module=users&action=view&uid=".$_GET['uid']."&newpass=TRUE"
);

$sql  = "SELECT userid,username,first_name,last_name,email,active,admin ";
$sql .= "FROM users ";
$sql .= "WHERE userid='".$_GET['uid']."'";
$user = $dbi->fetch_row($sql,"array");
$smarty->assign('user',$user);

$sql  = "SELECT permid,permission ";
$sql .= "FROM permissions ";
$sql .= "WHERE user_perm = 't' ";
$sql .= "ORDER BY permission";
$permissions = $dbi->fetch_all($sql,"array");
$smarty->assign('permissions',$permissions);
  
$user_groups = user_groups($_GET['uid']);
$smarty->assign('user_groups',$user_groups);
$ugroups = implode(",",$user_groups);

$sql  = "SELECT permid ";
$sql .= "FROM user_permissions ";
$sql .= "WHERE userid='".$_GET['uid']."'";
$user_perms = $dbi->fetch_all($sql);
if (!is_array($user_perms)) {
  $user_perms = array();
}
$smarty->assign('user_perms',$user_perms);

$sql  = "SELECT gid,name ";
$sql .= "FROM groups ";
if (!empty($ugroups)) {
  $sql .= "WHERE gid NOT IN ($ugroups) ";
}
$sql .= "ORDER BY name";
$groups = $dbi->fetch_all($sql,"array");
$smarty->assign('groups',$groups);

$smarty->display("users/view.tpl");
?>
