<?php
/* $Id: menus.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if ($_SESSION['group_count'] > 0
or is_manager()) {
  $leftnav_menu["Reports"] = array(
    "url"   => "?module=reports",
    "sub"   => array(
      "Stored Reports" => "?module=reports&action=manage"
    )
  );
  
  if (is_manager()) {
    $leftnav_menu["Reports"]["sub"]["Technician Reports"] = "?module=reports&action=tech";
  }
}
?>
