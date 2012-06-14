<?php
/* $Id: search.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if ($_GET['advanced'] != "true"){
  $links[] = array(
    "img" => $_ENV['imgs']['search'],
    "txt" => "Advanced Search",
    "url" => "?module=issues&action=search&advanced=true"
  );
} else {
  $links[] = array(
    "img" => $_ENV['imgs']['search'],
    "txt" => "Simple Search",
    "url" => "?module=issues&action=search"
  );
}

// Only show the other options if we are doing an advanced search
if ($_GET['advanced'] == "true") {
  if (is_employee()) {
    $sql  = "SELECT gid ";
    $sql .= "FROM groups ";
    $sql .= "ORDER BY name";
    $ugroups = $dbi->fetch_all($sql);

    $sql  = "SELECT userid,username ";
    $sql .= "FROM users ";
    $sql .= "ORDER BY username";
    $u = $dbi->fetch_all($sql,"array");
    foreach ($u as $user) {
      $users[$user['userid']] = $user['username'];
    }

    $sql  = "SELECT sid,status ";
    $sql .= "FROM statuses ";
    $sql .= "ORDER BY status";
    $s = $dbi->fetch_all($sql,"array");
    foreach ($s as $status) {
      $statuses[$status['sid']] = $status['status'];
    }
    
    $sql  = "SELECT cid,category ";
    $sql .= "FROM categories ";
    $sql .= "ORDER BY category";
    $c = $dbi->fetch_all($sql,"array");
    foreach ($c as $category) {
      $categories[$category['cid']] = $category['category'];
    }
    
    $sql  = "SELECT pid,product ";
    $sql .= "FROM products ";
    $sql .= "ORDER BY product";
    $p = $dbi->fetch_all($sql,"array");
    foreach ($p as $product) {
      $products[$product['pid']] = $product['product'];
    }
  } else {
    $ugroups = $_SESSION['groups'];

    foreach ($_SESSION['groups'] as $gid) {
      $members = group_members($gid);

      foreach ($members as $uid => $username) {
        if (!in_array($uid,$users)) {
          $users[$uid] = $username;
        }
      }
   
      $group_statuses = group_statuses($gid);

      foreach ($group_statuses as $sid => $status) {
        if (!array_key_exists($sid,$statuses)) {
          $statuses[$sid] = $status;
        }
      }

      $group_categories = group_categories($gid);

      foreach ($group_categories as $cid => $category) {
        if (!array_key_exists($cid,$categories)) {
          $categories[$cid] = $category;
        }
      }
      
      $group_products = group_products($gid);

      foreach ($group_products as $pid => $product) {
        if (!array_key_exists($pid,$products)) {
          $products[$pid] = $product;
        }
      }
    }
  }
  
  $smarty->assign('ugroups',$ugroups);
  $smarty->assign('users',$users);
  $smarty->assign('statuses',$statuses);
  $smarty->assign('categories',$categories);
  $smarty->assign('products',$products);
}

$smarty->display("issues/search.tpl");
?>
