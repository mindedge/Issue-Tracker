<?php
/* $Id: view.issues.php 7 2004-12-06 22:06:36Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_GET['issueid'])) {
  redirect();
}

if (empty($_GET['gid']) and !empty($_POST['gid'])) {
	$_GET['gid'] = $_POST['gid'];
}

if (!empty($_POST['duedate']) and is_employee($_SESSION['userid'])
and issue_priv($_GET['issueid'],"technician")) {
  $parts = explode("/",$_POST['duedate']);
  $update['due_date'] = mktime(0,0,0,$parts[0],$parts[1],$parts[2]);
  $dbi->update("issues",$update,"WHERE issueid='".$_GET['issueid']."'");
  unset($update);
}

if (!empty($_GET['eid'])) {
	$update["private"] = $_GET['type'] == "private" ? "t" : "f";
  logger("Event ".$_GET['eid']." for issue ".$_GET['issueid']." set to ".$_GET['type'],"privacy"); 
  $dbi->update("events",$update,"WHERE eid='".$_GET['eid']."'");
	unset($update);
}

if ($_GET['update_summary'] == "true" and issue_priv($_GET['issueid'],"technician")
and !empty($_POST['summary'])) {
  $update['summary'] = str_replace("\"","'",$_POST['summary']);
  $dbi->update("issues",$update,"WHERE issueid='".$_GET['issueid']."'");
  issue_log($_GET['issueid'],"Issue Summary Modified");
  unset($update);
}

if ($_GET['reopen'] == "true"){
	reopen_issue($_GET['issueid']);
}

if (!empty($_GET['gid']) and $_GET['deescalate'] == "true") {
	deescalate_issue($_GET['issueid'],$_GET['gid']);
}

if (!empty($_GET['toggle_subscribe'])) {
  toggle_subscribe($_GET['issueid']);
}

if (can_view_issue($_GET['issueid'])) {
	//modified SQL to get formatted date so the template would work right MWarner 6/19/2009
	$sql  = "SELECT *,date_format(from_unixtime(due_date),'%m/%d/%Y') as due_date ";
	$sql .= "FROM issues ";
	$sql .= "WHERE issueid='".$_GET['issueid']."'";
  $issue = $dbi->fetch_row($sql,"array");
  $issue['problem'] = htmlspecialchars($issue['problem']);
  $smarty->assign('issue',$issue);

  $sql  = "SELECT requester ";
  $sql .= "FROM issue_requesters ";
  $sql .= "WHERE issueid='{$_GET['issueid']}'";
  $requester = $dbi->fetch_one($sql);
  if (!empty($requester)) {
    $smarty->assign('requester',$requester);
  }

	$groups = issue_groups($_GET['issueid']);
  $smarty->assign('groups',$groups);

  $ugroups = array();
	foreach ($groups as $group) {
    if (in_array($group['gid'],$_SESSION['groups'])) {
      array_push($ugroups,$group);
		}
	}
  $smarty->assign('ugroups',$ugroups);

  if (count($ugroups) > 1 and is_null($_GET['gid'])) {
    $smarty->display("issues/choose_view_group.tpl");
  } else {
    update_view_tracking($_GET['issueid']);

    if (empty($_GET['gid'])) {
      if (count($ugroups) < 1) {
        $group = $groups[0]['gid'];
      } else {
        $group = $ugroups[0]['gid'];
      }
    } else {
      $group = $_GET['gid'];
    }

    if (issue_priv($_GET['issueid'],"technician")) {
      $links[] = array(
        "txt" => "Email Issue",
        "url" => "?module=issues&action=email&issueid=".$_GET['issueid']."&gid=$group",
        "img" => $_ENV['imgs']['email']
      );
    }
  
    if (closed($_GET['issueid'])) {
      $links[] = array(
        "txt" => "Reopen Issue",
        "url" => "?module=issues&action=view&issueid=".$_GET['issueid']."&reopen=true",
        "img" => $_ENV['imgs']['show_closed']
      );
    }

    if (show_issue($_GET['issueid'],$group)
    and permission_check("technician",$group)
    and $group != $issue['gid']) {
      $links[] = array(
        "txt" => "De-Escalate Issue",
        "url" => "?module=issues&action=view&deescalate=true&issueid=".$_GET['issueid']."&gid=".$_GET['gid'],
        "img" => $_ENV['imgs']['deescalate']
      );
    }

    $links[] = array(
      "txt"	=> !is_subscribed($_SESSION['userid'],$_GET['issueid']) ? "Subscribe" : "Unsubscribe",
      "url"	=> "?module=issues&action=view&issueid=".$_GET['issueid']."&gid=$group&toggle_subscribe=true",
      "img"	=> !is_subscribed($_SESSION['userid'],$_GET['issueid']) ? $_ENV['imgs']['subscribe'] : $_ENV['imgs']['unsubscribe']
    );

    //pull file count for this issue to let viewer know that files are available MWarner 3/2/2010
	$sql  = "SELECT count(fid) as numFiles ";
	$sql .= "FROM files ";
	$sql .= "WHERE typeid='".$_GET['issueid']."'";
	$sql .= "AND file_type='issues' ";
	$numFiles = $dbi->fetch_one($sql);
	$numFiles=($numFiles)?" (".$numFiles.")":"";
	
	$links[] = array(
      "txt"	=> "Issue Files".$numFiles,
      "url"	=> "?module=issues&action=files&issueid=".$_GET['issueid'],
      "img"	=> $_ENV['imgs']['file']
    );
	
    $links[] = array(
      "txt" => "Issue Log",
      "url" => "?module=issues&action=view_log&issueid=".$_GET['issueid'],
      "img" => $_ENV['imgs']['issue_log']
    );

    if (issue_priv($_GET['issueid'],"move_issues")) {
      $links[] = array(
        "txt" => "Move Issue",
        "url" => "?module=issues&action=move_issue&issueid=".$_GET['issueid'],
        "img" => $_ENV['imgs']['move']
      );
    }

    $links[] = array(
      "txt" => "Copy Issue",
      "url" => "?module=issues&action=new&icopy=".$_GET['issueid'],
      "img" => $_ENV['imgs']['copy']
    );

    $assigned = issue_assigned($_GET['issueid']);
    $smarty->assign('assigned',$assigned);
 
  	$sql  = "SELECT eid,performed_on,action,userid,duration,fid,private ";
  	$sql .= "FROM events ";
	  $sql .= "WHERE issueid='".$_GET['issueid']."' "; 
    $sql .= !issue_priv($_GET['issueid'],"view_private") ? "AND private != 't' " : "";
	  $sql .= "ORDER By performed_on ASC";
    $events = $dbi->fetch_all($sql,"array");
    $num_events = count($events);
    for ($x = 0;$x < $num_events;$x++) {
      if (!empty($events[$x]['fid'])) {
        $events[$x]['links'][] = array(
          'img' => $_ENV['imgs']['file'],
          'alt' => 'Download File',
          'url' => '?module=download&fid='.$events[$x]['fid']
        );
      }
      
      if ($events[$x]['userid'] == $_SESSION['userid']
      or issue_priv($_GET['issueid'],"edit_events")) {
        if (!$disable_edit 
        or ($disable_edit and is_admin($_SESSION['userid']))) {
          $events[$x]['links'][] = array(
            'img' => $_ENV['imgs']['edit'],
            'alt' => 'Edit Event',
            'url' => '?module=issues&action=edit&issueid='.$_GET['issueid'].'&gid='.$issue['gid'].'&eid='.$events[$x]['eid']
          );
        }
      }

      if (is_employee() and issue_priv($_GET['issueid'],"view_private")) {
        $url = "?module=issues&action=view&issueid=".$_GET['issueid']."&eid=".$events[$x]['eid'];

        $events[$x]['links'][] = array(
          'img' => $events[$x]['private'] == "t" ? $_ENV['imgs']['private'] : $_ENV['imgs']['public'],
          'alt' => $events[$x]['private'] == "t" ? 'Make Event Public' : 'Make Event Private',
          'url' => $events[$x]['private'] == "t" ? $url."&type=public" : $url."&type=private"
        );
      }
     
      $events[$x]['class'] = $events[$x]['private'] == "t" ? "private" : "data";
    }
    $smarty->assign('events',$events);

    $smarty->display("issues/view.tpl");
    $smarty->display("issues/show_events.tpl");
    
    if (!closed($_GET['issueid']) and issue_priv($_GET['issueid'],"create_issues")) {
      $statuses = issue_statuses($_GET['issueid']);
      $smarty->assign('group',$group);
      $smarty->assign('statuses',issue_statuses($_GET['issueid']));
      $smarty->assign('istatuses',issue_istatuses($_GET['issueid']));
      $smarty->assign('categories',issue_categories($_GET['issueid']));
      $smarty->assign('products',issue_products($_GET['issueid']));
      $imembers = issue_members($_GET['issueid']);
      $gmembers = group_members($group);
      $smarty->assign('members',$imembers);
      $smarty->assign('gmembers',$gmembers);
      $smarty->assign('notifylist',is_employee($_SESSION['userid']) ? $imembers : $gmembers);
      $smarty->assign('assigned',issue_assigned($_GET['issueid'],$group));
      $smarty->assign('egroups',escalation_groups($group));
      
      $smarty->display("issues/new_event.tpl");
    }
  }
} else {
	push_error("Could not find that issue in the database.");
	redirect("?module=issues");
}
?>
