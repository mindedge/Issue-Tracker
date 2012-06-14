<?php
/* $Id: admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

// Build array for administration buttons
if (is_employee()) {
  $buttons = array(
    array(
      "img" => $_ENV['imgs']['user'],
      "txt" => "User Management",
      "url" => "?module=users",
      "sub" => array(
        "New User" => "?module=users&action=new"
      )
    ),
    array(
      "img" => $_ENV['imgs']['group'],
      "txt" => "Group Management",
      "url" => "?module=groups",
      "sub" => array(
        "New Group" => "?module=groups&action=new",
        "Status Reports" => "?module=groups&action=status"
      )
    )
  );
}

if (is_manager($_SESSION['userid'])) {
  $buttons[] = array(
    "img" => $_ENV['imgs']['motd'],
    "txt" => "Message of the Day",
    "url" => "?module=admin&action=edit_motd"
  );
}

if (is_admin($_SESSION['userid'])) {
  $buttons[] = array(
    "img" => $_ENV['imgs']['debug'],
    "txt" => "Debugging",
    "sub" => array(
      "Query Tool" => "?module=admin&action=query",
      "Switch Users" => "?module=admin&action=switch_users",
      "Toggle Debugger" => $_SESSION['debugger'] == "on" ? "?debug=off" : "?debug=on"
    )
  );

  $buttons[] = array(
    "img" => $_ENV['imgs']['permission'],
    "txt" => "Permissions Management",
    "url" => "?module=admin&action=permissions",
    "sub" => array(
      "Create Permission" => "?module=admin&action=permissions&subaction=new",
      "Permission Sets" => "?module=admin&action=permission_sets",
      "New Permission Set" => "?module=admin&action=permission_sets&subaction=new"
    )
  );
  /*
  $buttons[] = array(
    "img" => $_ENV['imgs']['system'],
    "txt" => "System Configuration",
    "url" => "?module=admin&action=sysconfig"
  );
  */
}

if (permission_check("status_manager")) {
  $buttons[] = array(
    "img" => $_ENV['imgs']['status'],
    "txt" => "Status Management",
    "url" => "?module=admin&action=statuses",
    "sub" => array(
      "New Status" => "?module=admin&action=statuses&subaction=new"
    )
  );
}

if (permission_check("category_manager")) {
  $buttons[] = array(
    "img" => $_ENV['imgs']['category'],
    "txt" => "Category Management",
    "url" => "?module=admin&action=categories",
    "sub" => array(
      "New Category" => "?module=admin&action=categories&subaction=new"
    )
  );
}

if (permission_check("product_manager")) {
  $buttons[] = array(
    "img" => $_ENV['imgs']['product'],
    "txt" => "Product Management",
    "url" => "?module=admin&action=products",
    "sub" => array(
      "New Product" => "?module=admin&action=products&subaction=new"
    )
  );
}

$smarty->assign('buttons',$buttons);
$smarty->display("admin/admin.tpl");
?>
