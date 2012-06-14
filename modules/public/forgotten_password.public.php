<?php
/* $Id: forgotten_password.public.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Public
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if ($_GET['send'] == "true"
and !empty($_POST['username'])
and !empty($_POST['email'])) {
  $sql  = "SELECT userid,email ";
  $sql .= "FROM users ";
  $sql .= "WHERE email='".$_POST['email']."' ";
  $sql .= "AND username='".$_POST['username']."'";
  list($userid,$email) = $dbi->fetch_row($sql);
  if (!empty($userid)) {
    $new_pass = gen_passwd();
    $update['password'] = md5($new_pass);
    $dbi->update("users",$update,"WHERE userid='$userid'");
    unset($update);

    $message  = "Password: $new_pass\n\n";
    $message .= "To change your password login at:\n\n"._URL_."\n\n";
    $message .= "and click the 'Preferences' link on the left hand menus.";

    // Make sure we have the mailer class and initialize it
    include_once(_CLASSES_."mail.class.php");
    if (!is_object($mailer)) {
      $mailer = new MAILER();
      $mailer->set("email_from",_EMAIL_);
    }
    $mailer->subject("Issue Tracker Forgotten Password");
    $mailer->to($email);
    $mailer->message($message);
    $mailer->send();
    push_error("A new password has been sent to your email address on file.");
  } else {
    push_error("The information given does not match any users on file.");
  }
}

redirect();
?>
