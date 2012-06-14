<?php
/* $Id: announce.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (permission_check("create_announcements")) {
	$links[] = array(
		"txt" => " New Announcement ",
		"url"	=> "?module=announce&action=new",
    "img" => $_ENV['imgs']['new_announce']
	);
}

$system = announcements();
$smarty->assign('system',$system);
foreach ($_SESSION['groups'] as $gid) {
  $sql  = "SELECT aid ";
  $sql .= "FROM announce_permissions ";
  $sql .= "WHERE gid='$gid'";
  $a = $dbi->fetch_all($sql);
  if (count($a) > 0) {
    $a = implode(",",$a);
    $sql  = "SELECT aid,title ";
    $sql .= "FROM announcements ";
    $sql .= "WHERE aid IN ($a) ";
    $sql .= "ORDER BY posted DESC";
    $a = $dbi->fetch_all($sql,"array");
  }
  $announcements[$gid] = $a;
}
$smarty->assign('announcements',$announcements);
$smarty->display("announce/announce.tpl");
?>
