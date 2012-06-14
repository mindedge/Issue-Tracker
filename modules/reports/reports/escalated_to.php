<?php
if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (in_array("escto",$_POST['options'])) {
  $count = 0;

  $sql  = "SELECT i.issueid ";
  $sql .= "FROM issues i, issue_groups g ";
  $sql .= "WHERE g.gid='$gid' ";
  $sql .= "AND i.issueid = g.issueid ";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate'" : "";
  $issues = $dbi->fetch_all($sql);
  if (!is_null($issues)) {
    foreach ($issues as $issueid) {
      $sql  = "SELECT gid ";
      $sql .= "FROM issues ";
      $sql .= "WHERE issueid='$issueid'";
      $group = $dbi->fetch_one($sql,"array");
      if ($group != $gid) {
        $count++;
      }
    }
  }
  
  $smarty->assign('escto',$count);
}
?>
