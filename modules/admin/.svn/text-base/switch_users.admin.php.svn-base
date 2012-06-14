<?php
/* $Id: switch_users.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if ($_GET['return'] == "true" and is_admin($_SESSION['ADMIN_UID'])) {
	$_SESSION['userid'] = $_SESSION['ADMIN_UID'];
  unset($_SESSION['ADMIN_UID']);
  redirect();
}

if (empty($_SESSION['ADMIN_UID'])) {
  $links[] = array(
    "txt" => "Back to Administration",
    "url" => "?module=admin",
    "img" => $_ENV['imgs']['back']
  );

	if (!empty($_POST['userid'])) {
		$_SESSION['ADMIN_UID'] = $_SESSION['userid'];
		$_SESSION['userid'] = $_POST['userid'];
    redirect();
	}

	$sql  = "SELECT userid,username ";
	$sql .= "FROM users ";
	$sql .= "WHERE userid != '".$_SESSION['userid']."' ";
	$sql .= "AND active != 'f' ";
	$sql .= "ORDER BY username";
  $users = $dbi->fetch_all($sql,"array");
  $smarty->assign('users',$users);
  $smarty->display("admin/switch_users.tpl");
} else {
  redirect();
}
?>
