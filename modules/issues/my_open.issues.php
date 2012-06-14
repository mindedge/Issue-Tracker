<?php
/* $Id: my_open.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
/** 
 * @package Issue-Tracker
 * @subpackage Issues
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if($_GET['showall'] != "true"){
  $links[] = array(
    "img" => $_ENV['imgs']['show_clsoed'],
    "txt" => " Show Closed ",
    "url" => "?module=issues&action=my_open&showall=true&gid=".$_GET['gid']
  );
} else {
  $links[] = array(
    "img" => $_ENV['imgs']['hide_closed'],
    "txt" => " Hide Closed ",
    "url" => "?module=issues&action=my_open&showall=false&gid=".$_GET['gid']
  );
}

// fetch needed statuses
list($registered) = fetch_status(TYPE_REGISTERED);
$closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

// Make sure we have something to sort by
if (empty($_GET['sort'])) {
  $_GET['sort'] = "status";
}

$url  = "?module=issues&action=my_open$show$reverse";
$url .= $_GET['showall'] != "true" ? "&showall=true" : "";
$url .= $_GET['reverse'] != "true" ? "&reverse=true" : "";
$smarty->assign('url',$url);

$sql  = "SELECT issueid,summary,status,gid,severity ";
$sql .= "FROM issues ";
$sql .= "WHERE opened_by='".$_SESSION['userid']."' ";
//show these, too. MWarner 1/28/2010
//$sql .= "AND status != '$registered' ";
$sql .= $_GET['showall'] != "true" ? "AND status NOT IN ($closed) " : "";
$sql .= "ORDER BY ".$_GET['sort']." DESC";
$issues = $dbi->fetch_all($sql,"array");

$smarty->assign('issues',$issues);
$smarty->display("issues/my_open.tpl");
?>
