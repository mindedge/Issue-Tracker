<?php
/* $Id: group.announce.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

$announcements = announcements($_GET['gid']);
$smarty->assign('announcements',$announcements);

if (empty($_GET['gid'])) {
  $smarty->assign('title',"System Announcements");
} else {
  $smarty->assign('title',group_name($_GET['gid'])." Announcements");
}

$smarty->display("announce/group.tpl");
?>
