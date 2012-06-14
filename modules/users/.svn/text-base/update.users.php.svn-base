<?php
/* $Id: update.users.php 2 2004-08-05 21:42:03Z eroberts $ */
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

// check for errors
if(empty($_POST['uname'])){
	push_error("Please enter a username");
} else if(empty($_POST['email'])){
	push_error("Please enter a email address");
}

if(!errors()){
	// update information
  $update["username"]     = $_POST['uname'];
  $update["first_name"]   = $_POST['first'];
  $update["last_name"]    = $_POST['last'];
  $update["email"]        = $_POST['email'];
  
  if(is_admin()){
    $update["admin"]        = $_POST['admin'] == "on" ? "t" : "f";
  }

	if(!is_admin($_GET['uid']) and $update['admin'] == "t"){
		logger("User ".username($_GET['uid'])." granted admin privileges!","admin");
		admin_notify("User ".username($_GET['uid'])." granted admin privileges");
	} else if(is_admin($_GET['uid']) and $update['admin'] == "f"){
		logger("User ".username($_GET['uid'])." admin privileges removed","admin");
	}

  $update["active"]       = $_POST['active'] == "on" ? "t" : "f";
	
	if(user_active($_GET['uid']) and $update['active'] == "f"){
		logger("User ".username($_GET['uid'])." disabled","users");
	} else if(!user_active($_GET['uid']) and $update['active'] == "t"){
		logger("User ".username($_GET['uid'])." activated","users");
	}

  $dbi->update("users",$update,"WHERE userid='".$_GET['uid']."'");

  $sql  = "DELETE FROM user_permissions ";
  $sql .= "WHERE userid='".$_GET['uid']."'";
  $dbi->query($sql);
  if (is_array($_POST['permissions'])) {
    foreach ($_POST['permissions'] as $val) {
      $insert['userid'] = $_GET['uid'];
      $insert['permid'] = $val;
      $dbi->insert("user_permissions",$insert);
      unset($insert);
    }
  }

  if($_POST['employee'] == "on"){
  	group_useradd($_GET['uid'],_EMPLOYEES_);
  } else if (is_employee()) {
    group_userdel($_GET['uid'],_EMPLOYEES_);
  }

	if(is_array($_POST['add_groups'])){
		foreach($_POST['add_groups'] as $key => $val){
			group_useradd($_GET['uid'],$val);
		}
	}

	if(is_array($_POST['del_groups'])){
		foreach($_POST['del_groups'] as $key => $val){
			group_userdel($_GET['uid'],$val);
		}
	}

  gen_cache("users","userid","username");
}

redirect("?module=users&action=view&uid=".$_GET['uid']);
?>
