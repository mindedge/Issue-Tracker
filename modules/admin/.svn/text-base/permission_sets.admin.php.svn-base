<?php
/* $Id: permission_sets.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

$perms = array();
$sql  = "SELECT permission ";
$sql .= "FROM permissions ";
$sql .= "WHERE group_perm != 't' ";
$sql .= "AND user_perm != 't'";
$perms = $dbi->fetch_all($sql);
$smarty->assign('perms',$perms);

if ($_GET['subaction'] == "delete") {
  $sql  = "SELECT system ";
  $sql .= "FROM permission_sets ";
  $sql .= "WHERE permsetid='".$_GET['id']."'";
  $system = $dbi->fetch_one($sql);
  if ($system == "t") {
    push_error("This is a system permission set, it can not be deleted.");
    redirect("?module=admin&action=permission_sets");
  }
    
	if ($_POST['confirm'] == "true") {
		$sql  = "DELETE FROM permission_sets ";
		$sql .= "WHERE permsetid='".$_GET['setid']."'";
		$dbi->query($sql);
    redirect("?module=admin&action=permission_sets");
	} else {
    $smarty->display("admin/permission_sets/delete.tpl");
	}
} else if ($_GET['subaction'] == "edit") {
	if ($_POST['update'] == "true") {
    if (!is_array($_POST['permissions'])) {
      push_error("Permission sets must contain at least 1 permission.");
    } else {
      $sql  = "SELECT permsetid ";
      $sql .= "FROM permission_sets ";
      $sql .= "WHERE LOWER(name) = LOWER('".trim($_POST['name'])."')";
      $psetid = $dbi->fetch_one($sql);
      if (empty($psetid) or $psetid == $_GET['setid']) {
        $update['name']					= addslashes($_POST['name']);
        $update['description']	= addslashes($_POST['description']);
        $update['permissions']	= addslashes(implode(",",$_POST['permissions']));
        $dbi->update("permission_sets",$update,"WHERE permsetid = '".$_GET['setid']."'");
        redirect("?module=admin&action=permission_sets");
      } else {
        push_error("A permission set with that name already exists.");
      }
    }
	}

	$sql  = "SELECT name,description,permissions ";
	$sql .= "FROM permission_sets ";
	$sql .= "WHERE permsetid = '".$_GET['setid']."'";
  $pset = $dbi->fetch_row($sql,"array");
  $pset['name'] = stripslashes($pset['name']);
  $pset['description'] = stripslashes($pset['description']);
  $pset['permissions'] = explode(",",stripslashes($pset['permissions']));
  $smarty->assign('pset',$pset);
  $smarty->display("admin/permission_sets/edit.tpl");
}	else if ($_GET['subaction'] == "new") {
	if (!empty($_POST['name'])) {
    if (!is_array($_POST['permissions'])) {
      push_error("Permission sets must include at least 1 permission.");
    } else {
      $sql  = "SELECT permsetid ";
      $sql .= "FROM permission_sets ";
      $sql .= "WHERE LOWER(name) = LOWER('".trim($_POST['name'])."')";
      $psetid = $dbi->fetch_one($sql);
      if (!empty($psetid)) {
        push_error("A permission set with that name already exists.");
      } else {
        $insert['name'] 				= addslashes($_POST['name']);
        $insert['description']	= addslashes($_POST['description']);
        $insert['permissions']	= addslashes(implode(",",$_POST['permissions']));
        $dbi->insert("permission_sets",$insert);
        redirect("?module=admin&action=permission_sets");
      }
    }
	}

  $smarty->display("admin/permission_sets/new.tpl");
} else {
  $links[] = array(
    "txt" => "Back to Administration",
    "url" => "?module=admin",
    "img" => $_ENV['imgs']['back']
  );
  $links[] = array(
    "txt" => "New Permission Set",
    "url" => "?module=admin&action=permission_sets&subaction=new",
    "img" => $_ENV['imgs']['permission']
  );

  $sql  = "SELECT * ";
  $sql .= "FROM permission_sets ";
  $psets = $dbi->fetch_all($sql,"array");
  $num_sets = count($psets);
  for ($x = 0;$x < $num_sets;$x++) {
    $psets[$x]['name'] = stripslashes($psets[$x]['name']);
    $psets[$x]['description'] = stripslashes($psets[$x]['description']);
    $psets[$x]['permissions'] = explode(",",stripslashes($psets[$x]['permissions']));
  }
  $smarty->assign('rowspan',count($perms));
  $smarty->assign('psets',$psets);
  $smarty->display("admin/permission_sets.tpl");
}
?>
