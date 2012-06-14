<?php
/* $Id: issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

// if the user belongs to multiple groups make them select
// which groups issues they want to view
if($_SESSION['group_count'] > 1 or is_manager()){
	redirect("?module=issues&action=choose");
} else {
	// otherwise assign gid as the only group and include
	// the group issues file
	$gid = $_SESSION['groups'][0];
	redirect("?module=issues&action=group&gid=$gid");
}
?>
