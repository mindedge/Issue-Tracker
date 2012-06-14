<?php
/* $Id: update.issues.php 6 2004-12-06 21:57:06Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (empty($_GET['gid']) and !empty($_POST['gid'])) {
	$_GET['gid'] = $_POST['gid'];
}

// fetch "Registered" status
list($registered) = fetch_status(TYPE_REGISTERED);
$closed = fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED));

// form query to pull current info
$sql  = "SELECT category,product,status,istatus,severity,iseverity ";
$sql .= "FROM issues ";
$sql .= "WHERE issueid='".$_GET['issueid']."'";
$result = $dbi->query($sql);
list($cid,$pid,$sid,$isid,$sev,$isev) = $dbi->fetch($result);

// Error Checking
if ($sid == $registered and $_POST['new_status'] == "") {
	push_error("Please update the status of this issue.");
}
if ($_POST['dur'] != "" and !preg_match("([0-9]+|[0-9]{1,3}\.[0-9]+)",$_POST['dur'])) {
	push_error("Please enter a valid duration. (#.##)");
}
if (isset($_FILES['upload']['name'])) {
  $upload = $_FILES['upload'];  
  $size = round((_MAXUPLOAD_ / 1024) / 1024,2);
    
  if ($upload['size'] > _MAXUPLOAD_ and !is_admin($_SESSION['userid'])) {
		push_error("Attached file exceeds size limit ($size MB).");
  }
}
if (empty($_GET['gid'])) {
	push_error("You either do not have permission to update this issue or did not choose a group.");
}
if (defined("MAXLENGTH")) {
  if (strlen($_POST['event']) > MAXLENGTH and MAXLENGTH != 0) {
    push_error("Your event exceeds the maximum accepted length of ".number_format(MAXLENGTH)." characters.");
    push_error("Please attach the event as a file.");
  }
}

// Update issue if no errors
if(!errors()){
  $event .= "\n\n";

	// Escalation
	if(!empty($_POST['egid'])){
		escalate_issue($_GET['issueid'],$_POST['egid']);
	}

	// Begin Group Specific Changes
	$sql  = "SELECT first_response,assigned_to ";
	$sql .= "FROM issue_groups ";
	$sql .= "WHERE issueid='".$_GET['issueid']."' ";
	$sql .= "AND gid='".$_GET['gid']."'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		list($first,$assigned) = $dbi->fetch($result);
		
		if(empty($first)){
			$update['first_response'] = time();
		}
		
		if($assigned != $_POST['assign'] and !empty($_POST['assign'])){
			$update['assigned_to'] = $_POST['assign'];
			issue_log($_GET['issueid'],username($_POST['assign'])." assigned to issue for ".group_name($_GET['gid']));
		}
	} else {
		$update['first_response'] = time();

		if (!empty($_POST['assign'])) {
			$update['assigned_to'] = $_POST['assign'];
			issue_log($_GET['issueid'],username($_POST['assign'])." assigned to issue for ".group_name($_GET['gid']));
		}
	}

	if (is_array($update)) {
		$dbi->update("issue_groups",$update,"WHERE issueid='".$_GET['issueid']."' AND gid='".$_GET['gid']."'");
		unset($update);
	}
	// End Group Specific Changes

	// Main Ticket Update
  if ($_POST['cat'] != $cid and !empty($_POST['cat'])) {
    $update["category"] = $_POST['cat'];
		issue_log($_GET['issueid'],"Category set to: ".category($_POST['cat']));
  }

  if ($_POST['prod'] != $pid and !empty($_POST['prod'])) {
    $update['product'] = $_POST['prod'];
    issue_log($_GET['issueid'],"Product set to: ".product($_POST['prod']));
  }

  if ($_POST['new_status'] != $sid and !empty($_POST['new_status'])) {
    $update["status"] = $_POST['new_status'];
		issue_log($_GET['issueid'],"Status set to: ".status($_POST['new_status']));

    if (in_array($_POST['new_status'],$closed)) {
			$update['closed'] = time();
		}
  }

  if ($_POST['new_istatus'] != $isid and !empty($_POST['new_istatus'])) {
    $update["istatus"] = $_POST['new_istatus'];
		issue_log($_GET['issueid'],"Internal status set to: ".status($_POST['new_istatus']),TRUE);
  }

  if ($_POST['severity'] != $sev and !empty($_POST['severity'])) {
    $update["severity"] = $_POST['severity'];
		issue_log($_GET['issueid'],"Severity set to: ".severity_text($_POST['severity']));
  }

  if ($_POST['iseverity'] != $isev and !empty($_POST['iseverity'])) {
    $update["iseverity"] = $_POST['iseverity'];
		issue_log($_GET['issueid'],"Internal severity set to: ".severity_text($_POST['iseverity']),TRUE);
  }

  if (!empty($_POST['summary'])
  and $_POST['summary'] != issue_summary($_GET['issueid'])){
  	$update["summary"] = str_replace("\"","'",$_POST['summary']);
		issue_log($_GET['issueid'],"Summary edited");
  }

  $update["private"]  = $_POST['tprivate'] == "on" ? "t" : "f";
  $update["modified"] = time();
  $dbi->update("issues",$update,"WHERE issueid='".$_GET['issueid']."'");
  unset($update);	
	// End Main Ticket Update
  
	// Begin Event Creation
  $insert["duration"] = empty($_POST['dur']) ? "0.00" : $_POST['dur'];

  if (!empty($_FILES['upload']['name'])) {
    $fid = upload($_GET['issueid']);
    if (!empty($fid)) {
      $insert["fid"] = $fid[0];
    }
  }
    
  // make sure there is actually something to this event
  if (trim($_POST['event']) != "") {
    $new_event = TRUE;
    $insert["action"] 			= $_POST['event'];
    $insert["performed_on"] = time();
    $insert["userid"] 			= $_SESSION['userid'];
    $insert["issueid"]			= $_GET['issueid'];

    if ($_POST['new_status'] != $sid) {
      $insert["status"] = $_POST['new_status'];
    } else {
      $insert["status"] = $sid;
    }

    $insert["private"] = ($_POST['eprivate'] == "on" or ($_GET['gid'] != $_POST['ogid'])) ? "t" : "f";
    $dbi->insert("events",$insert);
  } else {
    $new_event = FALSE;
  }

  unset($insert);
  // End Event Creation

  // Begin Notifications
	$notify_list = !is_array($_POST['notify_list']) ? array() : $_POST['notify_list'];
  if (!$new_event) {
    issue_notify($_GET['issueid'],$notify_list,FALSE);
  } else {
    issue_notify($_GET['issueid'],$notify_list);
  }
	// End Notifications

  redirect("?module=issues&action=view&issueid=".$_GET['issueid']."&gid=".$_GET['gid']);
}

include_once(_MODULES_."issues/view.issues.php");
?>
