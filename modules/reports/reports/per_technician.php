<?php
/* $Id: per_technician.php 2 2004-08-05 21:42:03Z eroberts $ */

if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("pertech",$_POST['options'])) {
  unset($data);
  
  $sql  = "SELECT COUNT(issueid) as count,assigned_to ";
  $sql .= "FROM issue_groups ";
  $sql .= "WHERE gid='$gid' ";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate' " : "";
  $sql .= "GROUP BY assigned_to";
  $techs = $dbi->fetch_all($sql,"array");
  if (!is_null($techs)) {
    foreach ($techs as $tech) {
      $data[username($tech['assigned_to'])] = $tech['count'];
    }
  }

  if ($_POST['use_graphs'] == "on") {
    $title  = group_name($gid)."\nIssues Per Technician";
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

    $buffer .= "<img src=\"$image\" width=\"128\" height=\"128\" border=\"0\" alt=\"Issues Per Technician\"></a>";
    $smarty->assign('tech_data',$buffer);
  } else {
    $smarty->assign('tech_data',$data);
  }
}
?>
