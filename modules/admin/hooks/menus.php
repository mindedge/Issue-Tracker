<?php
/* $Id: menus.php 2 2004-08-05 21:42:03Z eroberts $ */
/** 
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (!empty($_SESSION['ADMIN_UID']) and is_admin($_SESSION['ADMIN_UID'])) {
  $leftnav_menu["Administration"] = array(
  	"sub"		=> array(
	  	"Switch Back"	=> "?module=admin&action=switch_users&return=true"
  	)
  );
}
?>
