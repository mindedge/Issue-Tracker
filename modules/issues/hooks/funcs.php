<?php
/* $Id: funcs.php 6 2004-12-06 21:57:06Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

/* {{{ Function: toggle_subscribe */
/**
 * Toggle a user's subscription to an issue
 *
 * @param integer $issueid ID of issue
 */
function toggle_subscribe($issueid)
{
	global $dbi;

	if (!is_subscribed($_SESSION['userid'],$issueid)) {
		$insert['issueid']= $issueid;
		$insert['userid']	= $_SESSION['userid'];
		$dbi->insert("subscriptions",$insert);
		unset($insert);
	} else {
    $sql  = "DELETE FROM subscriptions ";
    $sql .= "WHERE issueid='$issueid' ";
    $sql .= "AND userid='".$_SESSION['userid']."'";
    $dbi->query($sql);
  }
}
/* }}} */

/* {{{ Function: is_subscribed */
/**
 * Check to see if a user is already subscribed to an issue
 *
 * @param integer $userid ID of user
 * @param integer $issueid ID of issue
 * @return boolean
 */
function is_subscribed($userid,$issueid)
{
	global $dbi;

	$sql  = "SELECT issueid ";
	$sql .= "FROM subscriptions ";
	$sql .= "WHERE userid='$userid' ";
	$sql .= "AND issueid='$issueid'";
	$result = $dbi->query($sql);

	if($dbi->num_rows($result) > 0){
		return TRUE;
	}

	return FALSE;
}
/* }}} */



/* {{{ Function: get_subscriberlist */
/**
 * Check to see if a user is already subscribed to an issue
 *
 * @param integer $issueid ID of issue
 * @return array
 */
function get_subscriberlist($issueid){
	global $dbi;

	$sql  = "SELECT group_concat(a.username) ";
	$sql .= "FROM users a, subscriptions b ";
	$sql .= "WHERE a.userid=b.userid ";
	$sql .= "AND b.issueid=".$issueid." order by a.username";
	//$subscribed = $dbi->fetch_all($sql,"array");
	$subscribed = $dbi->fetch_one($sql);
	return $subscribed;
	/*
	$subscribers=array();
   // if (is_array($subscribed)) {
      foreach ($subscribed as $username) {
        $subscribers[] = $username;
      }
   // }
	return $sql .implode(", ",$subscribers);
	*/
}
/* }}} */




/* {{{ Function: issue_groups */
/**
 * Retrieve the groups that are allowed to see an issue
 *
 * @param integer $issueid ID of issue
 * @return array
 */
function issue_groups($issueid)
{
	global $dbi;

	$sql  = "SELECT i.gid,g.name ";
  $sql .= "FROM issue_groups i, groups g ";
  $sql .= "WHERE i.issueid='$issueid' ";
  $sql .= "AND i.gid=g.gid ";
  $sql .= "AND i.show_issue='t' ";
  $sql .= "ORDER BY g.name";
  $groups = $dbi->fetch_all($sql,"array");
  
	return $groups;
}
/* }}} */

/* {{{ Function: can_view_issue */
/**
 * Determine if a user can see an issue
 *
 * @param integer $issueid ID of issue
 * @param integer $userid ID of user
 * @return boolean
 */
function can_view_issue($issueid,$userid = null)
{
	global $dbi;

	if (is_manager()) {
		return TRUE;
	}

  if (is_null($userid)) {
    $user_groups = $_SESSION['groups'];
  } else {
    $user_groups = user_groups($userid);
  }

	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		if (in_array($group['gid'],$user_groups)) {
			return TRUE;
		}
	}
}
/* }}} */

/* {{{ Function: issue_priv */
/**
 * Determine if a user has a privilege on a issue
 *
 * @param integer $issueid ID of issue
 * @param string $perm Privilege to check against
 * @param integer $userid ID of user to check *BASTARDS*
 * @return boolean
 */
function issue_priv($issueid,$perm,$userid = null)
{
	global $dbi;

	if (empty($userid)) {
		$userid = $_SESSION['userid'];
	}

	if(is_manager($userid)){
		return TRUE;
	}

	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		if (permission_check($perm,$group['gid'],$userid)) {
			return TRUE;	
		}
	}

	return FALSE;
}
/* }}} */

/* {{{ Function: issue_assigned */
/**
 * Retrive user assigned to a issue for a group
 *
 * @param integer $issueid
 * @param integer $gid
 * @return integer
 */
function issue_assigned($issueid,$gid = null)
{
	global $dbi;

  if (!is_null($gid)) {
    $sql  = "SELECT assigned_to ";
    $sql .= "FROM issue_groups ";
    $sql .= "WHERE issueid='$issueid' ";
    $sql .= "AND gid='$gid' ";
    $userid = $dbi->fetch_one($sql);
    return $userid;
  } else {
    $sql  = "SELECT gid,assigned_to ";
    $sql .= "FROM issue_groups ";
    $sql .= "WHERE issueid='$issueid' ";
    $assigned = $dbi->fetch_all($sql,"array");
    if (!is_null($assigned)) {
      foreach ($assigned as $group) {
        $users[$group['gid']] = $group['assigned_to'];
      }
    }

    return $users;
  }
}
/* }}} */

/* {{{ Function: num_new_issues */
/**
 * Pull number of new issues for a group
 *
 * @param integer $gid ID of group to check
 * @return integer
 */
function num_new_issues($gid)
{
  global $dbi;

  list($registered) = fetch_status(TYPE_REGISTERED);

	$sql  = "SELECT COUNT(i.issueid) ";
	$sql .= "FROM issues i, issue_groups g ";
	$sql .= "WHERE i.issueid=g.issueid ";
	$sql .= "AND g.gid='$gid' ";
	$sql .= !permission_check("view_private",$gid) ? " AND i.private !='t'" : "";
	$sql .= "AND i.status='$registered'";
  $new = $dbi->fetch_one($sql);
  return $new;
}
/* }}} */

/* {{{ Function: num_open_issues */
/**
 * Pull number of open issues for this group
 *
 * @param integer $gid ID of group to check
 * @return integer
 */
function num_open_issues($gid)
{
  global $dbi;

  $closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

	$sql  = "SELECT COUNT(i.issueid) ";
	$sql .= "FROM issues i, issue_groups g ";
	$sql .= "WHERE i.issueid=g.issueid ";
	$sql .= "AND g.gid='$gid' ";
	$sql .= !permission_check("view_private",$gid) ? " AND i.private !='t'" : "";
  $sql .= "AND i.status NOT IN ($closed) ";
  $sql .= "AND g.show_issue='t'";
  $open = $dbi->fetch_one($sql);
  return $open;
}
/* }}} */

/* {{{ Function: num_closed_issues new 2/23/2010 MWarner */
/**
 * Pull number of closed issues for this group
 *
 * @param integer $gid ID of group to check
 * @return integer
 */
function num_closed_issues($gid)
{
  global $dbi;

  $closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

	$sql  = "SELECT COUNT(i.issueid) ";
	$sql .= "FROM issues i, issue_groups g ";
	$sql .= "WHERE i.issueid=g.issueid ";
	$sql .= "AND g.gid='$gid' ";
	$sql .= !permission_check("view_private",$gid) ? " AND i.private !='t'" : "";
  $sql .= "AND i.status in ($closed) ";
  $sql .= "AND g.show_issue='t'";
  $num = $dbi->fetch_one($sql);
  return $num;
}
/* }}} */

/* {{{ Function: last_activity */
/**
 * Find out when last action was for this group
 *
 * @param integer $gid ID of group
 * @return array
 */
function last_activity($gid)
{
  global $dbi;

  $sql  = "SELECT e.performed_on,e.userid ";
  $sql .= "FROM issues i, issue_groups g, events e ";
  $sql .= "WHERE i.issueid=g.issueid ";
  $sql .= "AND i.issueid=e.issueid ";
  $sql .= "AND g.gid='$gid' ";
  $sql .= "ORDER BY e.performed_on DESC ";
  $sql .= "LIMIT 1";
  $data = $dbi->fetch_row($sql,"array");
  if (!is_null($data)) {
    $last = array(
      "date" => date_format($data['performed_on']),
      "user" => username($data['userid'])
    );

    return $last;
  }

  return null;
}
/* }}} */

/* {{{ Function: closed */
/**
 * Determines if a issue it closed or not
 *
 * @param integer $issueid ID of issue to check
 * @return boolean
 */
function closed($issueid)
{
  global $dbi;

  $closed = fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED));

  $sql  = "SELECT status ";
  $sql .= "FROM issues ";
  $sql .= "WHERE issueid='$issueid'";
  $status = $dbi->fetch_one($sql);
  if (in_array($status,$closed)) {
    return TRUE;
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: owner */
/**
 * Get the uid of the user that opened issue
 *
 * @param integer $issueid ID of issue
 * @return integer
 */
function owner($issueid)
{
  global $dbi;

	$sql  = "SELECT opened_by ";
	$sql .= "FROM issues ";
	$sql .= "WHERE issueid='$issueid'";
  $owner = $dbi->fetch_one($sql);
  return $owner;
}
/* }}} */
  
/* {{{ Function: issue_members */
/**
 * Retrieve array of all users in issue groups
 *
 * @param integer $issueid ID of issue
 * @return array
 */ 
function issue_members($issueid)
{
  global $dbi;

	$groups = issue_groups($issueid);
	$issue_members = array();

	foreach ($groups as $group) {
	  $members = group_members($group['gid']);

		foreach ($members as $key => $val) {
      if (array_key_exists($key,$issue_members)) {
        continue;
      }
      $issue_members[$key] = $val;
	  }
	}

  return $issue_members;
}
/* }}} */

/* {{{ Function: event_modify_time */
/**
 * Get the modification time of an event
 *
 * @param integer $eid ID of event
 * @return array
 */
function event_modify_time($eid)
{
  global $dbi;

  $sql  = "SELECT modified,userid ";
  $sql .= "FROM event_modifications ";
  $sql .= "WHERE eid='$eid' ";
  $sql .= "ORDER BY modified DESC ";
  $sql .= "LIMIT 1";
  $data = $dbi->fetch_row($sql,"array");
  if (!is_null($data)) {
    $modify = array(
      "time" => date_format($data['modified']),
      "user" => username($data['userid'])
    );

    return $modify;
  }

  return null;
}
/* }}} */

/* {{{ Function: issue_summary */
/**
 * Retrive the summary of an issue
 *
 * @param integer $issueid ID of issue to get summary for
 * @return string
 */
function issue_summary($issueid)
{
  global $dbi;

	$sql  = "SELECT summary ";
	$sql .= "FROM issues ";
	$sql .= "WHERE issueid='$issueid'";
  $summary = $dbi->fetch_one($sql);
  return $summary;
}
/* }}} */

/* {{{ Function: issue_escalation_groups */
/**
 * Retrieve all escalation groups for a issue
 *
 * @param integer $issueid ID of issue
 * @return array
 */
function issue_escalation_groups($issueid)
{
	global $dbi;

	$egroups = array();
	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		$e = escalation_groups($group['gid']);

		foreach ($e as $gid => $name) {
      if (!in_array($gid,$egroups)) {
        $egroups[$gid] = $name;
			}
		}
	}

	return $egroups;
}
/* }}} */

/* {{{ Function: issue_statuses */
/**
 * Retrieve array of all statuses for a issue
 * 
 * @param integer $issueid ID of issue
 * @return array
 */
function issue_statuses($issueid)
{
	global $dbi;

	$statuses = array();
	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		$gstatuses = group_statuses($group['gid']);

		foreach ($gstatuses as $key => $val) {
      if (!array_key_exists($key,$statuses)) {
        $statuses[$key] = $val;
      }
		}
	}

	return $statuses;
}
/* }}} */

/* {{{ Function: issue_istatuses */
/**
 * Retrieve array of all internal statuses for a issue
 * 
 * @param integer $issueid ID of issue
 * @return array
 */
function issue_istatuses($issueid)
{
	global $dbi;

	$statuses = array();
	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		$gstatuses = group_istatuses($group['gid']);

		foreach ($gstatuses as $key => $val) {
      if (!array_key_exists($key,$statuses)) {
        $statuses[$key] = $val;
      }
		}
	}

	return $statuses;
}
/* }}} */

/* {{{ Function: issue_categories */
/**
 * Retrieve array of all categories for a issue
 * 
 * @param integer $issueid ID of issue
 * @return array
 */
function issue_categories($issueid)
{
	global $dbi;

	$categories = array();
	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		$gcategories = group_categories($group['gid']);

		foreach ($gcategories as $key => $val) {
      if (!array_key_exists($key,$categories)) {
				$categories[$key] = $val;
			}
		}
	}

	return $categories;
}
/* }}} */

/* {{{ Function: issue_products */
/**
 * Retrieve array of all products for a issue
 * 
 * @param integer $issueid ID of issue
 * @return array
 */
function issue_products($issueid)
{
	global $dbi;

	$products = array();
	$groups = issue_groups($issueid);

	foreach ($groups as $group) {
		$gproducts = group_products($group['gid']);

		foreach ($gproducts as $key => $val) {
      if (!array_key_exists($key,$products)) {
				$products[$key] = $val;
			}
		}
	}

	return $products;
}
/* }}} */

/* {{{ Function: issue_notify */
/**
 * Send out notifcations for a issue
 *
 * @param integer $issueid ID of issue
 * @param array $users Array of users to notify
 * @param boolean $new_event Whether or not a new event was posted
 */
function issue_notify($issueid,$users = array(),$new_event = TRUE)
{
  global $dbi;

  if (!issue_exists($issueid)) {
    return;
  }

  //var to store whether the subsctibe to this issue link has been added (see below) MWarner 4/22/2010
  $subBitAdded=0;
  
  // Make sure we have the mail class and initialize it
  include_once(_CLASSES_."mail.class.php");
  $mailer = new MAILER();

  // Retrieve the groups in this issue
  $groups = issue_groups($issueid);
  $gcount = count($groups);

  // Statuses
  list($registered) = fetch_status(TYPE_REGISTERED);
  $closed = fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED));

  if ($new_event) {
  	$sql  = "SELECT action,private,userid ";
	  $sql .= "FROM events ";
  	$sql .= "WHERE issueid='$issueid' ";
	  $sql .= "ORDER BY eid DESC LIMIT 1";
    $event = $dbi->fetch_row($sql,"array");
    if (is_array($event)) {
      $event['action'] = stripslashes($event['action']);
    }
  }

	$sql  = "SELECT private,status,severity,summary,problem,opened_by,opened,modified ";
	$sql .= "FROM issues ";
	$sql .= "WHERE issueid='$issueid'";
  $issue = $dbi->fetch_row($sql,"array");
  $issue['summary'] = trim(stripslashes($issue['summary']));
  $issue['problem'] = trim(stripslashes($issue['problem']));

  if (in_array($issue['status'],fetch_status(TYPE_CLOSED))) {
    $subject = "(CLOSED) Issue #$issueid {$issue['summary']}";
  } else if ($issue['status'] == $registered
  and $issue['opened'] == $issue['modified']) {
    $subject = "(NEW) Issue #$issueid {$issue['summary']}";
  } else {
    $subject = "(UPDATED) Issue #$issueid {$issue['summary']}";
  }

  if (!is_array($event)) {
    $message  = "The details of this issue have been modified.  ";
    $message .= "Please login and view the issue log for more information.\n";
	if ($issue['status'] == $registered and $issue['opened'] == $issue['modified']) {//send opener name MWarner 2/11/2010
		$message = "Issue Created by ".username($issue['opened_by'])."\n\n";
	}
  } else {
    if (in_array($issue['status'],fetch_status(TYPE_CLOSED))) {
      $message = "Closed issue $issueid by ".username($event['userid'])."\n\n";
	  //send action in message, too MWarner 2/2/2010
	  $message .= "Action:\n{$event['action']}\n";
    } else if ($issue['status'] != $registered
    or $issue['opened'] != $issue['modified']) {
      $message  = "Update to issue $issueid by ".username($event['userid'])."\n\n";
      $message .= "Action:\n{$event['action']}\n";
    } else {
      $message = "Issue Created by ".username($issue['opened_by'])."\n\n";
      //send action in message, too MWarner 2/2/2010
	  $message .= "Action:\n{$event['action']}\n";
   }
  }

  if ($issue['status'] != $registered) {
    $sql  = "SELECT requester,list ";
    $sql .= "FROM issue_requesters ";
    $sql .= "WHERE issueid='$issueid'";
    list($requester,$list) = $dbi->fetch_row($sql);
    if (!empty($requester)) {
      issue_log($issueid,"Notifying requester ($requester)");
      $msg .= $message."\n";
      $msg .= "To respond to this issue just reply to this email leaving the subject intact.\n";
      $mailer->set("email_from",$list);
      $mailer->subject($subject);
      $mailer->to($requester);
      $mailer->message($msg);
      $mailer->send();
    }
  } else {
    $message .= "\n\nProblem:\n{$issue['problem']}\n";
  }

  $message .= "\n\n"._URL_."?module=issues&action=view&issueid=$issueid";

  $userlist = array();

	foreach ($groups as $group) {
    if (show_issue($issueid,$group['gid'])) {
      $sql  = "SELECT userid,type ";
      $sql .= "FROM notifications ";
      $sql .= "WHERE gid='{$group['gid']}'";
      $notify = $dbi->fetch_all($sql,"array");
      if (!is_null($notify)) {
        foreach ($notify as $row) {
          $userlist[] = array(
            "userid"  => $row['userid'],
            "type"    => $row['type']
          );
        }
      }

      $assigned = issue_assigned($issueid,$group['gid']);
      if (!in_array($assigned,$userlist)) {
        $userlist[] = array(
          "userid"  => $assigned,
          "type"    => "E"
        );
      }

      $sql  = "SELECT severity ";
      $sql .= "FROM issues ";
      $sql .= "WHERE issueid='{$issueid}'";
      $sev = $dbi->fetch_one($sql);
      if (!empty($sev)) {
        $sql  = "SELECT userid ";
        $sql .= "FROM group_users ";
        $sql .= "WHERE severity <= '{$sev}' ";
        $sql .= "AND gid='{$group['gid']}'";
        $sev_notify = $dbi->fetch_all($sql);
        if (is_array($sev_notify)) {
          foreach ($sev_notify as $userid) {
            $userlist[] = array(
              "userid" => $userid,
              "type"   => "S"
            );
          }
        }
      }
    }
	}
		
	$sql  = "SELECT userid ";
	$sql .= "FROM subscriptions ";
	$sql .= "WHERE issueid='$issueid'";
  $subscriptions = $dbi->fetch_all($sql);
  if (!is_null($subscriptions)) {
    foreach ($subscriptions as $userid) {
	    $userlist[] = array(
		    "userid"  => $userid,
			  "type"    => "E"
			);
		}
	}

  $owner = owner($issueid);
  if (!in_array($owner,$userlist)) {
    $userlist[] = array(
      "userid"  => $owner,
      "type"    => "E"
    );
  }

  if (is_array($users)) {
    foreach ($users as $userid) {
      $userlist[] = array(
        "userid"  => $userid,
        "type"    => "E"
      );
    }
  }

  $sent = array();

	$sql  = "SELECT COUNT(eid) ";
	$sql .= "FROM events ";
	$sql .= "WHERE issueid='$issueid'";
  $count = $dbi->fetch_one($sql);
	if ($count > 2) {
		$sql  = "SELECT userid,action,performed_on ";
		$sql .= "FROM events ";
		$sql .= "WHERE issueid='$issueid' ";
		$sql .= "AND private != 't' ";
		$sql .= "ORDER BY eid DESC LIMIT 2 OFFSET 1";
    $events = $dbi->fetch_all($sql,"array");
    if (!is_null($events)) {
			$message .= "\n\nPrevious Events:\n----------------\n";

      foreach ($events as $data) {
        $date = date_format($data['performed_on']);
				$message .= "Posted $date by ".username($data['userid'])."\n";
				$message .= stripslashes($data['action'])."\n\n";
			}
		}
	}

  $org_subject = $subject;

  foreach ($userlist as $user) {
    if (empty($user['userid'])) {
      continue;
    }
	
	//don't email the the assignee when the assignee is the creator or updater MWarner 2/3/2010
  	if($user['userid']==$_SESSION['userid']){
		continue;
	}
	
    $email = preg_match("/S/i",$user['type']) ? sms($user['userid']) : email($user['userid']);

    if (in_array($email,$sent)
    or empty($email)) {
      continue;
    }

    if (!user_active($user['userid'])) {
      continue;
    }

    if (($event['private'] == "t" or $issue['private'] == "t")
    and !issue_priv($issueid,"view_private",$user['userid'])) {
      continue;
    }
    
    $mailer->add_header("X-Issue-Tracker-Severity: {$issue['severity']}");
    if (is_array($users)) {
      if (@in_array($user['userid'],$users)) {
        $mailer->add_header("X-Issue-Tracker-Selected: true");
      }
    }
    if ($user['userid'] == $owner) {
      $mailer->add_header("X-Issue-Tracker-Owner: true");
    }

    $new_subject  = "";
    $user_groups = user_groups($user['userid']);

    reset($groups);
    foreach ($groups as $group) {
      if (in_array($group['gid'],$user_groups)) {
        $mailer->add_header("X-Issue-Tracker-Group: ".$group['name']);
        $new_subject .= empty($new_subject) ? "(".$group['name'] : "/".$ggroup['name'];
      }

      if ($user['userid'] == issue_assigned($issueid,$group['gid'])) {
        $mailer->add_header("X-Issue-Tracker-Assigned: true");
      }
    }
  
    //add subscription link to bottom of message MWarner 4/21/2010
	$message.=(!$subBitAdded)?"\n\nIf you would like to subscribe to notifications for this issue, please click the link below\n"._URL_."?module=issues&action=view&gid=1&toggle_subscribe=true&issueid=".$issueid:"";
    $subBitAdded=1;
	$new_subject .= !empty($new_subject) ? ")" : "";
    $subject = $new_subject.$org_subject;
    $message = stripslashes($message);

    // Send Mail
    $mailer->set("email_from",_EMAIL_);
    $mailer->subject($subject);
    $mailer->to($email);
    $mailer->message($message);
    $mailer->send();
    array_push($sent,$email);
  }

  $maillist = implode(",",$sent);
	issue_log($issueid,"Notifications sent to $maillist");
}
/* }}} */

/* {{{ Function: show_issue */
/**
 * Determine if a issue should be shown in a group
 *
 * @param integer $issueid ID of issue
 * @param integer $gid ID of group
 * @return boolean
 */
function show_issue($issueid,$gid)
{
  global $dbi;

  $sql  = "SELECT show_issue ";
  $sql .= "FROM issue_groups ";
  $sql .= "WHERE issueid='$issueid' ";
  $sql .= "AND gid='$gid'";
  $show = $dbi->fetch_one($sql);
  if ($show == "t") {
    return TRUE;
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: reopen_issue */
/**
 * Reopen an issue
 *
 * @param integer $issueid Id of issue to reopen
 */
function reopen_issue($issueid)
{
	global $dbi;

	$issue_groups = issue_groups($issueid);
	$owner = owner($issueid);
	
	foreach ($issue_groups as $group) {
		if ($_SESSION['userid'] == $owner
		or (in_array($group['gid'],$_SESSION['groups'])
		and permission_check("technician",$group['gid']))) {
			$tech = TRUE;
			break;
		}
	}

	if (closed($issueid) and $tech) {
    list($registered) = fetch_status(TYPE_REGISTERED);
	  $update["status"]   = $registered;
	  $update["modified"]	= time();
	  $dbi->update("issues",$update,"WHERE issueid='$issueid'");
	}

	issue_log($issueid,"Issue Reopened");
	return;
}
/* }}} */

/* {{{ Function: escalate_issue */
/**
 * Escalate an issue
 *
 * @param integer $issueid Ticket to escalate
 * @param integer $gid Group to escalate to
 */
function escalate_issue($issueid,$gid)
{
	global $dbi;

	$sql  = "SELECT show_issue ";
	$sql .= "FROM issue_groups ";
	$sql .= "WHERE issueid='$issueid' ";
	$sql .= "AND gid='$gid'";
  $show = $dbi->fetch_one($sql);
  if (!is_null($show)) {
		if ($show == "f") {
			$update['show_issue'] = "t";
			$dbi->update("issue_groups",$update,"WHERE issueid='$issueid' AND gid='$gid'");
		}
	} else {
		$insert['issueid']		= $issueid;
		$insert['gid']		= $gid;
		$insert['opened']	= time();
		$dbi->insert("issue_groups",$insert);
  	issue_log($issueid,"Issue escalated to ".group_name($gid),TRUE);
  }
}
/* }}} */

/* {{{ Function: deescalate_issue */
/**
 * Deescalate an issue from a group
 * 
 * @param integer $issueid Id of issue
 * @param integer $gid Id of Group
 */
function deescalate_issue($issueid,$gid)
{
	global $dbi;
	
	$update['show_issue'] = "f";
	$dbi->update("issue_groups",$update,"WHERE issueid='$issueid' AND gid='$gid'");
 	unset($update);

  $insert['action']       = group_name($gid)." has de-escalated the issue.";
  $insert['private']      = "t";
  $insert['userid']       = $_SESSION['userid'];
  $insert['performed_on'] = time();
  $insert['issueid']          = $issueid;
  $dbi->insert("events",$insert);

  $update['modified']     = time();
  $dbi->update("issues",$update,"WHERE issueid='$issueid'");

	issue_log($issueid,"De-escalated from ".group_name($gid),TRUE);
}
/* }}} */

/* {{{ Function: issue_log */
/**
 * Adds an entry to the logs for an issue
 *
 * @param integer $issueid ID of issue
 * @param string $msg Message to log
 * @param integer $userid ID of user
 */
function issue_log($issueid,$msg,$private = null,$userid = null)
{
	global $dbi;

	if (empty($msg) or empty($issueid)) {
		return;
	}

  if (empty($userid) and empty($_SESSION['userid'])) {
    $userid = _PARSER_;
  }

	$insert['issueid']  = $issueid;
	$insert['logged']		= time();
	$insert['userid']		= !is_null($userid) ? $userid : $_SESSION['userid'];
	$insert['message']	= $msg;
  $insert['private']  = $private === TRUE ? "t" : "f";
	$dbi->insert("issue_log",$insert);
}
/* }}} */

/* {{{ Function: update_view_tracking */
/**
 * Update the viewed time on an issue for the current user
 *
 * @param integer $issueid ID of issue
 */
function update_view_tracking($issueid)
{
  global $dbi;

  $sql  = "SELECT viewed ";
  $sql .= "FROM view_tracking ";
  $sql .= "WHERE issueid='".$_GET['issueid']."' ";
  $sql .= "AND userid='".$_SESSION['userid']."'";
  $viewed = $dbi->fetch_one($sql);
  if (!is_null($viewed)) {
    $where  = "WHERE issueid='$issueid' ";
    $where .= "AND userid='".$_SESSION['userid']."'";
    $update['viewed'] = time();
    $dbi->update("view_tracking",$update,$where);
  } else {
    $insert['issueid']= $issueid;
    $insert['userid']	= $_SESSION['userid'];
    $insert['viewed']	= time();
    $dbi->insert("view_tracking",$insert);
  }
}
/* }}} */

/* {{{ Function: unread_events */
/**
 * Retrieve the number of events in an issue that given users has not seen
 *
 * @param integer $issueid ID of issue
 * @param integer $userid ID of user
 * @param boolean $private Count private or not
 * @return integer
 */
function unread_events($issueid,$userid,$private = FALSE)
{
  global $dbi;

  $sql  = "SELECT viewed ";
  $sql .= "FROM view_tracking ";
  $sql .= "WHERE issueid='$issueid' ";
  $sql .= "AND userid='$userid'";
  $viewed = $dbi->fetch_one($sql);
  if (is_null($viewed)) {
    $viewed = 0;
  }

  $sql  = "SELECT COUNT(eid) ";
  $sql .= "FROM events ";
  $sql .= "WHERE issueid='$issueid' ";
  $sql .= "AND performed_on > $viewed ";
  $sql .= !$private ? "AND private != 't' " : "";
  $count = $dbi->fetch_one($sql);
  return $count;
}
/* }}} */

/* {{{ Function: issue_exists */
/**
 * Checks to see if an issue exists
 *
 * @param integer $issueid Id of issue
 * @return boolean
 */
function issue_exists($issueid)
{
  global $dbi;

  $sql  = "SELECT issueid ";
  $sql .= "FROM issues ";
  $sql .= "WHERE issueid='$issueid'";
  $id = $dbi->fetch_one($sql);
  if (!is_null($id)) {
    return TRUE;
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: issue_escalated_to */
/** 
 * Determines if given issue was escalated to this group
 *
 * @param integer $issueid ID of issue
 * @param integer $gid ID of group
 * @return boolean
 */
function issue_escalated_to($issueid,$gid)
{
  global $dbi;

  $sql  = "SELECT gid ";
  $sql .= "FROM issues ";
  $sql .= "WHERE issueid='$issueid'";
  $igid = $dbi->fetch_one($sql);
  if (!empty($igid)) {
    if ($gid != $igid) {
      return TRUE;
    }
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: issue_escalated_from */
/** 
 * Determines if given issue was escalated from this group
 *
 * @param integer $issueid ID of issue
 * @param integer $gid ID of group
 * @return boolean
 */
function issue_escalated_from($issueid,$gid)
{
  global $dbi;

  $sql  = "SELECT gid ";
  $sql .= "FROM issues ";
  $sql .= "WHERE issueid='$issueid' ";
  $igid = $dbi->fetch_one($sql);
  if (!empty($igid)) {
    if ($gid == $igid) {
      $sql  = "SELECT COUNT(gid) ";
      $sql .= "FROM issue_groups ";
      $sql .= "WHERE issueid='$issueid'";
      $count = $dbi->fetch_one($sql);
      if ($count > 1) {
        return TRUE;
      }
    }
  }

  return FALSE;
}
/* }}} */
?>
