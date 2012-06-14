<?php
/* $Id: edit.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (empty($_GET['eid'])) {
  redirect("?module=issues");
}

if ($disable_edit and !is_admin($_SESSION['userid'])) {
  redirect("?module=issues");
}

if ($_POST['commit'] == "true") {
  if ($_POST['event'] == "") {
    push_error("Must enter something for the event.");
  }

  if (!errors()) {
    // get old event
    $sql  = "SELECT action ";
    $sql .= "FROM events ";
    $sql .= "WHERE eid='".$_GET['eid']."'";
    $old_event = $dbi->fetch_one($sql);

    // write file for new event
    $fp = fopen("logs/new_event","w");
    fwrite($fp,$_POST['event']);
    fclose($fp);

    // write file for old event
    $fp = fopen("logs/old_event","w");
    fwrite($fp,$old_event);
    fclose($fp);

    // get difference between files
    $diff = `/usr/bin/diff -c5 logs/old_event logs/new_event`;

    // delete tmp files
    unlink("logs/old_event");
    unlink("logs/new_event");

    // form insert array
    $insert["eid"]      = $_GET['eid'];
    $insert["modified"] = time();
    $insert["changes"]  = $diff;
    $insert["userid"]   = $_SESSION['userid'];

    // insert old event
    $dbi->insert("event_modifications",$insert);
    unset($insert);

    // set new action
    $update["action"] = $_POST['event'];

    // update events table
    $dbi->update("events",$update,"WHERE eid='".$_GET['eid']."'");
    unset($update);
    unset($event);
      
    redirect("?module=issues&action=view&issueid=".$_GET['issueid']."&gid=".$_GET['gid']);
  }
}

$sql  = "SELECT action,userid ";
$sql .= "FROM events ";
$sql .= "WHERE eid='{$_GET['eid']}'";
$data = $dbi->fetch_row($sql,"array");
if (!is_null($data)) {
  if ($data['userid'] == $_SESSION['userid'] or is_admin()) {
    $smarty->assign('event',$data['action']);
    $smarty->display("issues/edit_event.tpl");
  }
}
?>
