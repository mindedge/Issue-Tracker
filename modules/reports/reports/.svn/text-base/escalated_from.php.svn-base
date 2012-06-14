<?php
if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("escfrom",$_POST['options'])) {
  $count = 0;

  $sql  = "SELECT issueid ";
  $sql .= "FROM issues ";
  $sql .= "WHERE gid='$gid' ";
  $sql .= $_POST['use_date'] == "on" ? "AND opened BETWEEN '$sdate' AND '$edate'" : "";
  $issues = $dbi->fetch_all($sql);
  if (!is_null($issues)) {
    foreach ($issues as $issueid) {
      $sql  = "SELECT COUNT(gid) ";
      $sql .= "FROM issue_groups ";
      $sql .= "WHERE issueid='$issueid'";
      $groups = $dbi->fetch_one($sql);
      if ($groups > 1) {
        $count++;
      }
    }
  }
  
  $smarty->assign('escfrom',$count);
}
?>
