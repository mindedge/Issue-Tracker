<?php
/* $Id: menus.php 5 2004-08-10 01:30:40Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if ($_SESSION['group_count'] > 0) {
  $leftnav_menu["Announcements"] = array(
	  "url"		=> "?module=announce",
    "sub"   => array()
  );
  if (permission_check("create_announcements")) {
    $leftnav_menu["Announcements"]["sub"]["New Announcement"] = "?module=announce&action=new";
  }
}
?>
