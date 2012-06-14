<?php
/* $Id: permissions.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if(is_admin()){
  if ($_GET['subaction'] == "delete"
  and !empty($_GET['id'])) {
    $sql  = "SELECT system ";
    $sql .= "FROM permissions ";
    $sql .= "WHERE permid='".$_GET['id']."'";
    $system = $dbi->fetch_one($sql);
    if ($system == "t") {
      push_error("This is a system permission, it can not be deleted.");
      redirect("?module=admin&action=permissions");
    }
    
    if ($_POST['confirm'] == "true") {
	  	$sql  = "DELETE FROM permissions ";
  	  $sql .= "WHERE permid='".$_GET['id']."'";
 	  	$dbi->query($sql);
      redirect("?module=admin&action=permissions");
    } else {
      $smarty->display("admin/permissions/delete.tpl");
    }
  } else if ($_GET['subaction'] == "new") {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['permission'])) {
        push_error("Permission can not be empty.");
      } else {
        $sql  = "SELECT permid ";
        $sql .= "FROM permissions ";
        $sql .= "WHERE LOWER(permission) = LOWER('".trim($_POST['permission'])."')";
        $permid = $dbi->fetch_one($sql);
        if (!empty($permid)) {
          push_error("That permission already exists.");
        } else {
          $insert['permission'] = $_POST['permission'];
          $insert['group_perm'] = $_POST['group'] == "on" ? "t" : "f";
          $insert['user_perm'] = $_POST['user'] == "on" ? "t" : "f";
          $dbi->insert("permissions",$insert);
          unset($insert);
          redirect("?module=admin&action=permissions");
        }
      }
    }
    
    if (empty($_POST['commit']) or errors()) {
      $smarty->display("admin/permissions/new.tpl");
    }
  } else if ($_GET['subaction'] == "edit" and !empty($_GET['id'])) {
    $sql  = "SELECT system ";
    $sql .= "FROM permissions ";
    $sql .= "WHERE permid='".$_GET['id']."'";
    $system = $dbi->fetch_one($sql);
    if ($system == "t") {
      push_error("This is a system permission, it can not be editted.");
      redirect("?module=admin&action=permissions");
    }
    
    if ($_POST['commit'] == "true") {
      if (empty($_POST['permission'])) {
        push_error("Permission can not be empty.");
      } else {
        $sql  = "SELECT permid ";
        $sql .= "FROM permissions ";
        $sql .= "WHERE LOWER(permission) = LOWER('".trim($_POST['permission'])."')";
        $permid = $dbi->fetch_one($sql);
        if (empty($permid) or $permid == $_GET['id']) {
          $update['permission'] = $_POST['permission'];
          $update['group_perm'] = $_POST['group'] == "on" ? "t" : "f";
          $update['user_perm'] = $_POST['user'] == "on" ? "t" : "f";
          $dbi->update("permissions",$update,"WHERE permid='".$_GET['id']."'");
          unset($update);
          redirect("?module=admin&action=permissions");
        } else {
          push_error("That permission already exists.");
        }
      }
    } 

    if (empty($_POST['commit']) or errors()) {
      $sql  = "SELECT permission,user_perm,group_perm ";
      $sql .= "FROM permissions ";
      $sql .= "WHERE permid='".$_GET['id']."'";
      $permission = $dbi->fetch_row($sql,"array");
      $smarty->assign('permission',$permission);
      $smarty->display("admin/permissions/edit.tpl");
    }
  } else {
    $links[] = array(
      "txt" => "Back to Administration",
      "url" => "?module=admin",
      "img" => $_ENV['imgs']['back']
    );
    $links[] = array(
      "txt"	=> "New Permission",
      "url"	=> "?module=admin&action=permissions&subaction=new",
      "img" => $_ENV['imgs']['permission']
    );
    $links[] = array(
      "txt" => "Permission Sets",
      "url" => "?module=admin&action=permission_sets",
      "img" => $_ENV['imgs']['permission']
    );

    $sql  = "SELECT permid,permission,group_perm,user_perm,system ";
    $sql .= "FROM permissions ";
    $sql .= "ORDER BY permission";
    $permissions = $dbi->fetch_all($sql,"array");
    $smarty->assign('permissions',$permissions);
    $smarty->display("admin/permissions.tpl");
  }
} else {
  redirect();
}
?>
