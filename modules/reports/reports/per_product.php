<?php
/* $Id: per_product.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("perprod",$_POST['options'])) {
  if ($_GET['tech'] == "true") {
    $sql  = "SELECT pid,product ";
    $sql .= "FROM products ";
    $sql .= "ORDER BY product";
    $p = $dbi->fetch_all($sql,"array");
    if (is_array($p)) {
      foreach ($p as $product) {
        $products[$product['pid']] = $product['product'];
      }
    }
  } else {
    $products = group_products($gid);
  }
  unset($data);

  foreach ($products as $key => $val) {
    $sql  = "SELECT COUNT(i.issueid) ";
    $sql .= "FROM issues i, issue_groups g ";
    $sql .= "WHERE i.issueid=g.issueid ";
    $sql .= $_GET['tech'] == "true" ? "AND g.assigned_to='$userid'" : "AND g.gid='$gid' ";
    $sql .= "AND i.product='$key'";
    $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
    $count = $dbi->fetch_one($sql); 
    if ($count > 0) {
      $data[$val] = $count;
    }
  }

  if ($_POST['use_graphs'] == "on") {
    if ($_GET['tech'] == "true") {
      $title = username($userid);
    } else {
      $title = group_name($gid);
    }
    $title .= "\nIssues Per Product";
    $title .= $_POST['use_date'] == "on" ? "\n".date("m/d/Y",$sdate)." - ".date("m/d/Y",$edate) : "";
    $image = hbar_graph($title,$data);

    if ($_SESSION['javascript']) {
      $options  = "width=660,height=500";
      $options .= ",menubar=no,toolbar=no,status=no,location=no";
      $javascript = "window.open('$image','Graph','$options'); return false;";
      $buffer = "<a href=\"#\" onClick=\"$javascript\">";
    } else {
      $buffer = "<a href=\"$image\" target=\"_blank\">";
    }

    $buffer .= "<img src=\"$image\" width=\"128\" height=\"128\" border=\"0\" alt=\"Issues Per Product\"></a>";
    $smarty->assign('product_data',$buffer);
  } else {
    $smarty->assign('product_data',$data);
  }
}
?>
