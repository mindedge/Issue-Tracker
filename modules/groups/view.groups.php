<?php
/* $Id: view.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Groups
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (!is_employee()
or !group_exists($_GET['gid'])) {
  redirect();
}

// Make sure to clean the wizard session variable
// or it could cause a nasty loop
unset($_SESSION['GROUP_WIZARD']);

// check to make sure at least one product is defined
$sql  = "SELECT pid ";
$sql .= "FROM group_products ";
$sql .= "WHERE gid='".$_GET['gid']."'";
$count = $dbi->fetch_one($sql);
if ($count < 1) {
  push_error("Must have at least one product defined.");
  redirect("?module=groups&action=edit&type=products&gid=".$_GET['gid']);
}

// check to make sure at least one status is defined
$sql  = "SELECT sid ";
$sql .= "FROM group_statuses ";
$sql .= "WHERE gid='".$_GET['gid']."'";
$count = $dbi->fetch_one($sql);
if ($count < 1) {
  push_error("Must have at least one status defined.");
  redirect("?module=groups&action=edit&type=statuses&gid=".$_GET['gid']);
}

// from query to pull group info
$sql  = "SELECT * ";
$sql .= "FROM groups ";
$sql .= "WHERE gid='".$_GET['gid']."'";
$group = $dbi->fetch_row($sql,"array");
if (is_null($group)) {
  redirect();
}
$smarty->assign('group',$group);

$links[] = array(
  "txt" => "Back to Groups",
  "url" => "?module=groups",
  "img" => $_ENV['imgs']['back']
);
      
if (permission_check("update_group",$_GET['gid'])) {
  $links[] = array(
    "txt"	=> "Edit Information",
    "url"	=> "?module=groups&action=edit_info&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['edit']
  );

  $links[] = array(
    "txt"	=> "Add/Remove Users",
    "url"	=> "?module=groups&action=edit_users&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['user']
  );

  $links[] = array(
    "txt" => "Sub Groups",
    "url" => "?module=groups&action=edit_sub_groups&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['group']
  );

  $links[] = array(
    "txt"	=> "Permissions",
    "url"	=> "?module=groups&action=edit_permissions&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['permission']
  );

  $links[] = array(
    "txt"	=> "Notifications",
    "url"	=> "?module=groups&action=edit_notify&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['email']
  );
  
  $links[] = array(
    "txt"	=> "Escalations",
    "url"	=> "?module=groups&action=edit&type=escalation&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['escalate']
  );

  $links[] = array(
    "txt"	=> "Statuses",
    "url"	=> "?module=groups&action=edit&type=statuses&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['status']
  );

  $links[] = array(
    "txt" => "Internal Statuses",
    "url" => "?module=groups&action=edit&type=istatuses&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['status']
  );

  $links[] = array(
    "txt"	=> "Categories",
    "url"	=> "?module=groups&action=edit&type=categories&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['category']
  );

  $links[] = array(
    "txt"	=> "Products",
    "url"	=> "?module=groups&action=edit&type=products&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['product']
  );
}

$members = group_members($_GET['gid']);
$smarty->assign('members',$members);
$smarty->display("groups/view.tpl");
?>
