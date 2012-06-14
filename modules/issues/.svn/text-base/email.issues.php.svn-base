<?php
/* $Id: email.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (!permission_check("technician",$_GET['gid'])) {
	redirect("?module=issues&action=view&issueid=".$_GET['issueid']."&gid=".$_GET['gid']);
}

if (empty($_GET['issueid'])
or !issue_exists($_GET['issueid'])) {
  redirect("?module=issues");
}

if (!empty($_POST['address'])) {
	$sql  = "SELECT etype,severity,assigned_to,opened_by ";
	$sql .= "FROM issues ";
	$sql .= "WHERE issueid='".$_GET['issueid']."'";
  list($etype,$severity,$assigned_to,$opened_by) = $dbi->fetch_row($sql);

  $subject = "Issue Tracker Issue #".$_GET['issueid'];
	$message .= "Summary:     ".$_POST['subject']."\n";
	$message .= "Opened By:   ".username($opened_by)."\n";
	$message .= "Assigned To: ".email($_SESSION['userid'])."\n";
	$message .= "Severity:    ".severity_text($severity)."\n\n";
	$message .= "Problem:\n".urldecode(stripslashes($_POST['problem']))."\n\n";

  if (is_array($_POST['eids'])) {
    $events = implode(",",$_POST['eids']);

		$sql  = "SELECT action,userid,performed_on ";
		$sql .= "FROM events ";
    $sql .= "WHERE eid IN ($events) ";
    $sql .= "ORDER BY performed_on DESC";
    $events = $dbi->fetch_all($sql);
    foreach ($events as $event) {
			$message .= "****** Event by ".username($event['userid'])." (".date_format($event['performed_on']).") ******\n\n";
			$message .= $event['action']."\n\n";
		}
	}

	$message .= "\n\n\n-------------------------\nIssue can be found at:\n";
	$message .= _URL_."/?module=issues&action=view&issueid=".$_GET['issueid']."\n";
	$message .= "If you need an account email "._ADMINEMAIL_;
	$message = stripslashes($message);

  // Make sure we have mailer class and initialize it
  include_once(_CLASSES_."mail.class.php");
  if (!is_object($mailer)) {
    $mailer = new MAILER();
    $mailer->set("email_from",_EMAIL_);
  }
  $mailer->subject($subject);
  $mailer->to($_POST['address']);
  $mailer->message($message);
  $mailer->send();
  redirect("?module=issues&action=view&issueid=".$_GET['issueid']);
}

$links[] = array(
  "txt" => "Back to Issue",
  "url" => "?module=issues&action=view&issueid=".$_GET['issueid'],
  "img" => $_ENV['imgs']['back']
);
 
$sql  = "SELECT problem,summary ";
$sql .= "FROM issues ";
$sql .= "WHERE issueid='".$_GET['issueid']."'";
list($problem,$summary) = $dbi->fetch_row($sql);

$smarty->assign('problem',$problem);
$smarty->assign('summary',$summary);

$sql  = "SELECT eid,action,userid ";
$sql .= "FROM events ";
$sql .= "WHERE issueid='".$_GET['issueid']."' ";
$sql .= "ORDER BY performed_on";
$events = $dbi->fetch_all($sql,"array");

$smarty->assign('events',$events);
$smarty->display("issues/email.tpl");
?>
