<?php
/* $Id: view.announce.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (!empty($_GET['aid']) and can_view_announcement($_GET['aid'])) {
	$sql  = "SELECT title,message,posted,userid ";
	$sql .= "FROM announcements ";
	$sql .= "WHERE aid='".$_GET['aid']."'";
  $announcement = $dbi->fetch_row($sql,"array");
  $smarty->assign('announcement',$announcement);
  $smarty->display("announce/view.tpl");
} else {
  redirect("?module=announce");
}
?>
