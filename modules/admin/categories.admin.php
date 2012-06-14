<?php
/* $Id: categories.admin.php 7 2004-12-06 22:06:36Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if(is_admin() or permission_check('category_manager')){
  if ($_GET['subaction'] == "delete"
  and !empty($_GET['id'])) {
    if ($_POST['confirm'] == "true") {
	  	$sql  = "DELETE FROM categories ";
  	  $sql .= "WHERE cid='".$_GET['id']."'";
 	  	$dbi->query($sql);
      redirect("?module=admin&action=categories");
    } else {
      $smarty->display("admin/categories/delete.tpl");
    }
  } else if ($_GET['subaction'] == "new") {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['category'])) {
        push_error("Category can not be empty.");
      } else {
        $sql  = "SELECT cid ";
        $sql .= "FROM categories ";
        $sql .= "WHERE LOWER(category) = LOWER('".trim($_POST['category'])."')";
        $cid = $dbi->fetch_one($sql);
        if (!empty($cid)) {
          push_error("That category already exists.");
        } else {
          $insert['category'] = $_POST['category'];
          $dbi->insert("categories",$insert);
          redirect("?module=admin&action=categories");
        }
      }
    }
    
    if (empty($_POST['commit']) or errors()) {
      $smarty->display("admin/categories/new.tpl");
    }
  } else if ($_GET['subaction'] == "edit" and !empty($_GET['id'])) {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['category'])) {
        push_error("Category can not be empty.");
      } else {
        $sql  = "SELECT cid ";
        $sql .= "FROM categories ";
        $sql .= "WHERE LOWER(category) = LOWER('".trim($_POST['category'])."')";
        $cid = $dbi->fetch_one($sql);
        if (empty($cid) or $cid == $_GET['id']) {
          $update['category'] = $_POST['category'];
          $dbi->update("categories",$update,"WHERE cid='".$_GET['id']."'");
          redirect("?module=admin&action=categories");
        } else {
          push_error("That category already exists.");
        }
      }
    } 

    if (empty($_POST['commit']) or errors()) {
      $category = category($_GET['id']);
      $smarty->assign('category',$category);
      $smarty->display("admin/categories/edit.tpl");
    }
  } else {
    $links[] = array(
      "txt" => "Back to Administration",
      "url" => "?module=admin",
      "img" => $_ENV['imgs']['back']
    );
    $links[] = array(
      "txt"	=> "New Category",
      "url" => "?module=admin&action=categories&subaction=new",
      "img" => $_ENV['imgs']['category']
    );

    $sql  = "SELECT cid,category ";
    $sql .= "FROM categories ";
    $sql .= "ORDER BY category";
    $categories = $dbi->fetch_all($sql,"array");
    $smarty->assign('categories',$categories);
    $smarty->display("admin/categories.tpl");
  }
} else {
  redirect();
}
?>
