<?php
/* $Id: groups.php 2 2004-08-05 21:42:03Z eroberts $ */
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

if (!empty($_GET['active']) and permission_check("update_group",$_GET['gid'])) {
	$update['active'] = $_GET['active'];
	$dbi->update("groups",$update,"WHERE gid='".$_GET['gid']."'");
	unset($update);
}

$links[] = array(
  "txt" => "Back to Administration",
  "url" => "?module=admin",
  "img" => $_ENV['imgs']['back']
);

$links[] = array(
	"txt" => "Create Group",
	"url" => "?module=groups&action=new",
  "img" => $_ENV['imgs']['new_group']
);

// set type to show in titlebar
if ($_GET['start'] == "") {
	$type = "Default";
} else {
	$type = $_GET['start'];
}

$sql  = "SELECT gid,name,active ";
$sql .= "FROM groups ";

if ($_GET['search'] == "true" and !empty($_POST['criteria'])) {
  $sql .= "WHERE LOWER(name) LIKE LOWER('".$_POST['criteria']."') ";
} else if ($_GET['start'] != "") {
  if ($_GET['start'] != "ALL") {
	  $sql .= "WHERE UPPER(name) LIKE '".$_GET['start']."%' ";
  }
} else {
  $sql_groups = user_groups($_SESSION['userid'],TRUE);
  $sql .= "WHERE gid IN ($sql_groups) ";
}

$sql .= "ORDER BY name";
$groups = $dbi->fetch_all($sql,"array");
$smarty->assign('groups',$groups);
$smarty->display("groups/groups.tpl");
?>
