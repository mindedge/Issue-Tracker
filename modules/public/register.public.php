<?php
/* $Id: register.public.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Public
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if ($allow_register !== TRUE) {
  redirect();
}

if ($_GET['create'] == "true") {
  if (empty($_POST['username'])) {
    push_error("You must specify a username.");
  }
  if (empty($_POST['email'])
  or !eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$",$_POST['email'])) {
    push_error("You must give a valid email address.");
  }
  
  if (!errors()) {
    $user_data = array(
      'username' => $_POST['username'],
      'email' => $_POST['email']
    );
    if (!empty($_POST['firstname'])) {
      $user_data['first'] = $_POST['firstname'];
    }
    if (!empty($_POST['lastname'])) {
      $user_data['last'] = $_POST['lastname'];
    }
    $userid = create_user($user_data);
    if (!empty($userid)) {
      if (defined("_DEFGRP_")) {
        group_useradd($userid,_DEFGRP_);
        $update['perm_set'] = PSET_CLIENT;
        $dbi->update("group_users",$update,"WHERE userid='$userid' AND gid='"._DEFGRP_."'");
        unset($update);
      }
      logger("Account registered for user: ".$_POST['username'],"registrations");
      push_error("Your account was created successfully.  You should receive an email shortly which contains your password to login.");
      redirect();
    }
  }
}

redirect();
?>     
