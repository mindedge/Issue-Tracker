<?php
/* $Id: edit_sub_groups.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Groups
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_GET['gid'])) {
  redirect("?modules=groups");
}

if (!is_employee()
or !permission_check("update_group",$_GET['gid'])) {
  redirect();
}

$links[] = array(
  "txt" => "Back to Group Information",
  "url" => "?module=groups&action=view&gid=".$_GET['gid'],
  "img" => $_ENV['imgs']['back']
);

$props = array(
  "prop_user",
  "prop_category",
  "prop_product",
  "prop_status",
  "prop_announce",
  "prop_issue"
);
$sql_props = implode(",",$props);
$smarty->assign('props',$props);

if ($_GET['do'] == "remove" and !empty($_GET['child'])) {
  if ($_POST['confirm'] == "true") {
    $sql  = "DELETE FROM sub_groups ";
    $sql .= "WHERE parent_gid='".$_GET['gid']."' ";
    $sql .= "AND child_gid='".$_GET['child']."'";
    $dbi->query($sql);
  } else {
    $smarty->display("groups/sub_groups/remove.tpl");
  }
} else if ($_GET['do'] == "toggle_parent" and !empty($_GET['prop'])) {
  $sql  = "SELECT ".$_GET['prop']." ";
  $sql .= "FROM groups ";
  $sql .= "WHERE gid='".$_GET['gid']."'";
  $prop = $dbi->fetch_one($sql);
  $update[$_GET['prop']] = $prop == "t" ? "f" : "t";
  $dbi->update("groups",$update,"WHERE gid='".$_GET['gid']."'");
  unset($update);
} else if ($_GET['do'] == "toggle_child"
and !empty($_GET['child']) and !empty($_GET['prop'])) {
  $sql  = "SELECT ".$_GET['prop']." ";
  $sql .= "FROM sub_groups ";
  $sql .= "WHERE parent_gid='".$_GET['gid']."' ";
  $sql .= "AND child_gid='".$_GET['child']."'";
  $prop = $dbi->fetch_one($sql);
  $update[$_GET['prop']] = $prop == "t" ? "f" : "t";
  $dbi->update("sub_groups",$update,"WHERE parent_gid='".$_GET['gid']."' AND child_gid='".$_GET['child']."'");
  unset($update);
}

if (is_array($_POST['add_groups'])
and @count($_POST['add_groups']) > 0) {
  foreach ($_POST['add_groups'] as $child) {
    $insert['parent_gid'] = $_GET['gid'];
    $insert['child_gid']  = $child;
    $dbi->insert("sub_groups",$insert);
    unset($insert);
  }
}

$sql  = "SELECT parent_gid,$sql_props ";
$sql .= "FROM sub_groups ";
$sql .= "WHERE child_gid='".$_GET['gid']."'";
$parent = $dbi->fetch_row($sql,"array");
if (!is_null($parent)) {
  $smarty->assign('parent',$parent);
  $smarty->assign('name',"Parent Group Propagation (Not Editable): ".group_name($parent['parent_gid']));
  $smarty->display("groups/sub_groups/parent.tpl"); 
}

$sql  = "SELECT $sql_props ";
$sql .= "FROM groups ";
$sql .= "WHERE gid='".$_GET['gid']."'";
$current = $dbi->fetch_row($sql,"array");
if (!is_null($current)) {
  $smarty->assign('current',$current);
  $smarty->assign('name',group_name($_GET['gid'])." Propagation");
  $smarty->display("groups/sub_groups/group.tpl");
}

$sql  = "SELECT g.name,s.child_gid,s.prop_user,s.prop_category,s.prop_product,s.prop_status,s.prop_announce,s.prop_issue ";
$sql .= "FROM groups g, sub_groups s ";
$sql .= "WHERE s.parent_gid='".$_GET['gid']."' ";
$sql .= "AND g.gid = s.child_gid ";
$sql .= "ORDER BY g.name";
$children = $dbi->fetch_all($sql,"array");

$smarty->assign('children',$children);
$smarty->display("groups/sub_groups/children.tpl");

$smarty->assign('possible',possible_children($_GET['gid']));
$smarty->display("groups/sub_groups/add.tpl");
?>
