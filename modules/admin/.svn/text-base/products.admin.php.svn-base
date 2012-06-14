<?php
/* $Id: products.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if(is_admin() or permission_check('product_manager')){
  if ($_GET['subaction'] == "delete"
  and !empty($_GET['id'])) {
    if ($_POST['confirm'] == "true") {
	  	$sql  = "DELETE FROM products ";
  	  $sql .= "WHERE pid='".$_GET['id']."'";
 	  	$dbi->query($sql);
      redirect("?module=admin&action=products");
    } else {
      $smarty->display("admin/products/delete.tpl");
    }
  } else if ($_GET['subaction'] == "new") {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['product'])) {
        push_error("Product can not be empty.");
      } else {
        $sql  = "SELECT pid ";
        $sql .= "FROM products ";
        $sql .= "WHERE LOWER(product) = LOWER('".trim($_POST['product'])."')";
        $pid = $dbi->fetch_one($sql);
        if (!empty($pid)) {
          push_error("This product already exists.");
        } else {
          $insert['product'] = $_POST['product'];
          $dbi->insert("products",$insert);
          redirect("?module=admin&action=products");
        }
      }
    }
    
    if (empty($_POST['commit']) or errors()) {
      $smarty->display("admin/products/new.tpl");
    }
  } else if ($_GET['subaction'] == "edit" and !empty($_GET['id'])) {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['product'])) {
        push_error("Product can not be empty.");
      } else {
        $sql  = "SELECT pid ";
        $sql .= "FROM products ";
        $sql .= "WHERE LOWER(product) = LOWER('".trim($_POST['product'])."')";
        $pid = $dbi->fetch_one($sql);
        if (empty($pid) or $pid == $_GET['id']) {
          $update['product'] = $_POST['product'];
          $dbi->update("products",$update,"WHERE pid='".$_GET['id']."'");
          redirect("?module=admin&action=products");
        } else {
          push_error("That product already exists.");
        }
      }
    } 

    if (empty($_POST['commit']) or errors()) {
      $product = product($_GET['id']);
      $smarty->assign('product',$product);
      $smarty->display("admin/products/edit.tpl");
    }
  } else {
    $links[] = array(
      "txt" => "Back to Administration",
      "url" => "?module=admin",
      "img" => $_ENV['imgs']['back']
    );
    $links[] = array(
      "txt"	=> "New Product",
      "url" => "?module=admin&action=products&subaction=new",
      "img" => $_ENV['imgs']['product']
    );

    $sql  = "SELECT pid,product ";
    $sql .= "FROM products ";
    $sql .= "ORDER BY product";
    $products = $dbi->fetch_all($sql,"array");
    $smarty->assign('products',$products);
    $smarty->display("admin/products.tpl");
  }
} else {
  redirect();
}
?>
