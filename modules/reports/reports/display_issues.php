<?php
if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if ($_POST['display_issues'] == "on") {
  foreach ($_POST['fields'] as $key => $val) {
    if ($val == "assigned_to") {
      continue;
    }
    $select_fields .= ",i.".$val;
  }

  $sql  = "SELECT i.issueid,i.summary$select_fields ";
  $sql .= "FROM issues i, issue_groups g ";
  if ($_GET['tech'] == "true") {
    $sql .= "WHERE (g.assigned_to = '$userid' ";
    $sql .= "OR i.opened_by = '$userid') ";
  } else {
    $sql .= "WHERE g.gid='$gid' ";
  }
  $sql .= "AND i.issueid = g.issueid ";
  $sql .= $_POST['use_date'] == "on" ? "AND i.opened BETWEEN '$sdate' AND '$edate' " : "";

  if (!permission_check("view_private",$gid)
  or $_POST['hidepriv'] == "on") {
    $sql .= "AND i.private != 't' ";
  }

  $issues = $dbi->fetch_all($sql,"array");
  if (!is_null($issues)) {
    $count = count($issues);
    for ($x = 0;$x < $count;$x++) {
      $issues[$x]['assigned'] = issue_assigned($issues[$x]['issueid']);

      if ($_POST['show_events'] == "on") {
        $sql  = "SELECT userid,performed_on,duration,action,private ";
        $sql .= "FROM events ";
        $sql .= "WHERE issueid='".$issues[$x]['issueid']."' ";
      
        if (!permission_check("view_private",$gid)
        or $_POST['hidepriv'] == "on") {
          $sql .= "AND private != 't' ";
        }

        $sql .= "ORDER BY eid ASC";
        $issues[$x]['events'] = $dbi->fetch_all($sql,"array");
      }
    }
  }

  $smarty->assign('issues',$issues);
}
?>
