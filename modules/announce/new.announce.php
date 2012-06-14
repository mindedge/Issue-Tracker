<?php
/* $Id: new.announce.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (!permission_check("create_announcments")) {
	redirect("?module=announce");
}

if (!empty($_POST['new_title'])) {
  if (empty($_POST['new_title'])) {
    push_error("Please enter a title");
  } else if (empty($_POST['new_text'])) {
    push_error("Please enter an announcement.");
  } else if (count($_POST['groups']) < 1) {
    push_error("Please choose at least one group.");
  }

  if (!errors()) {
    $insert['title']      = $_POST['new_title'];
    $insert['message']    = $_POST['new_text'];
    $insert['is_global']  = in_array("GLOBAL",$_POST['groups']) ? "t" : "f";
    $insert['posted']     = time();
    $insert['userid']     = $_SESSION['userid'];

    if ($aid = $dbi->insert("announcements",$insert,"announcements_aid_seq")) {
      unset($insert);
     
      if (!in_array("GLOBAL",$_POST['groups']) and count($_POST['groups']) > 0) {
        for ($x = 0;$x < count($_POST['groups']);$x++) {
          $insert['aid'] = $aid;
          $insert['gid'] = $_POST['groups'][$x];
        
          $dbi->insert("announce_permissions",$insert);
          unset($insert);
        }
      }
    }

    redirect("?module=announce");
  }
}

$smarty->display("announce/new.tpl");
?>
