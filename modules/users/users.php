<?php
/* $Id: users.php 2 2004-08-05 21:42:03Z eroberts $ */
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

// Update a user's active status
if(!empty($_GET['uid']) and !empty($_GET['active'])){
	$update['active'] = $_GET['active'];
	$dbi->update("users",$update,"WHERE userid='".$_GET['uid']."'");
	unset($update);
}

// new user buttons
$links[] = array(
  "txt" => "Back to Administration",
  "url" => "?module=admin",
  "img" => $_ENV['imgs']['back']
);
$links[] = array(
	"txt" => "Create Users",
	"url" => "?module=users&action=new",
  "img" => $_ENV['imgs']['new_user']
);

// make sure start has a value
if($_GET['start'] == ""){
	$_GET['start'] = "A";
}

// pull users
$sql  = "SELECT userid,username,email,first_name,last_name,active ";
$sql .= "FROM users ";

if ($_GET['search'] == "true" and !empty($_POST['criteria'])) {
  $search = "WHERE (";
  if ($_POST['username'] == "on") {
    $search .= $search != "WHERE (" ? "OR " : "";
    $search .= "LOWER(username) LIKE LOWER('".$_POST['criteria']."') ";
  }
  if ($_POST['firstname'] == "on") {
    $search .= $search != "WHERE (" ? "OR " : "";
    $search .= "LOWER(first_name) LIKE LOWER('".$_POST['criteria']."') ";
  }
  if ($_POST['lastname'] == "on") {
    $search .= $search != "WHERE (" ? "OR " : "";
    $search .= "LOWER(last_name) LIKE LOWER('".$_POST['criteria']."') ";
  }
  if ($_POST['email'] == "on") {
    $search .= $search != "WHERE (" ? "OR " : "";
    $search .= "LOWER(email) LIKE LOWER('".$_POST['criteria']."') ";
  }
  $sql .= $search.") ";
} else {
  if($_GET['start'] != "ALL"){
	  $sql .= "WHERE UPPER(username) LIKE '".$_GET['start']."%' ";
  }
}

$sql .= "ORDER BY username";
$users = $dbi->fetch_all($sql,"array");
$smarty->assign('users',$users);
$smarty->display("users/users.tpl");
?>
