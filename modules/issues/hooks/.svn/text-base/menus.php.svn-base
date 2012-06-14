<?php
/* $Id: menus.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if ($_SESSION['group_count'] > 0) {
  $leftnav_menu["Issues"] = array(
    "url"		=> "?module=issues",
    "sub"		=> array(
      "New Issue"	=> "?module=issues&action=new",
      "My Opened"			=> "?module=issues&action=my_open",
      "My Closed"		=> "?module=issues&action=my_closed",//new MWarner 2/3/2010
      "My Assigned"		=> "?module=issues&action=my_assigned",
      "Search"				=> "?module=issues&action=search"
    )
  );
}
?>
