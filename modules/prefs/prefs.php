<?php
/* $Id: prefs.php 3 2004-08-09 23:22:56Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Preferences
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if ($_GET['update'] == "true") {
  if(!preg_match("/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,})$/si",$_POST['email'])){
    push_error("Please enter an email address.");
  }

  $sql  = "SELECT userid ";
  $sql .= "FROM users ";
  $sql .= "WHERE LOWER(email)=LOWER('".$_POST['email']."') ";
  $sql .= "AND userid != '".$_SESSION['userid']."'";
  $result = $dbi->query($sql);
  if($dbi->num_rows($result) > 0){
    push_error("This email address is already in use by another user.");
  }

  if(!empty($_POST['oldpass'])){
    $sql  = "SELECT userid ";
    $sql .= "FROM users ";
    $sql .= "WHERE userid='".$_SESSION['userid']."' ";
    $sql .= "AND password='".md5($_POST['oldpass'])."'";
    if($result = $dbi->query($sql)){
      if($_POST['newpass'] != $_POST['confirm']){
        push_error("New Password and Confirmation do not match.");
      }
    } else {
      push_error("Old password is invalid.<br/>");
    }
  }

  if (!errors()) {
    $update["first_name"]   = $_POST['first'];
    $update["last_name"]    = $_POST['last'];
    $update['address']			= $_POST['address'];
    $update['address2']			= $_POST['address2'];
    $update['telephone']		= $_POST['phone'];
    $update["sms"]          = $_POST['sms'];
    $update["email"]        = $_POST['email'];
      
    if(!empty($_POST['newpass'])){
      $update["password"]   = md5($_POST['newpass']);
    }

    $dbi->update("users",$update,"WHERE userid='".$_SESSION['userid']."'");
    unset($update);
   
    if(!empty($_POST['new_text']) and !empty($_POST['new_link'])){
      $insert['userid'] = $_SESSION['userid'];
      $insert['text']   = $_POST['new_text'];
      $insert['url']   = $_POST['new_link'];
      $dbi->insert("menus",$insert);
      unset($insert);
    }

    update_preference($_SESSION['userid'],"show_fields",implode(",",$_POST['fields']));
    update_preference($_SESSION['userid'],"sort_by",$_POST['sort_by']);

    if (empty($_POST['wrap']) or $_POST['wrap'] == 0) {
      $_POST['wrap'] = 80;
    }

    if (!empty($_POST['wrap'])) {
      update_preference($_SESSION['userid'],"word_wrap",$_POST['wrap']);
    }
   
    update_preference($_SESSION['userid'],"disable_wrap",$_POST['disablewrap'] == "on" ? "t" : "f");
    update_preference($_SESSION['userid'],"date_format",$_POST['dformat']);
    update_preference($_SESSION['userid'],"local_tz",$_POST['localtz'] == "on" ? "t" : "f");
    update_preference($_SESSION['userid'],"session_timeout",$_POST['sesstimeout'] == "on" ? "t" : "f");
    redirect("?module=prefs");
  }
}

if (!empty($_GET['mid'])) {
  $sql  = "DELETE FROM menus ";
  $sql .= "WHERE userid='".$_SESSION['userid']."' ";
	$sql .= "AND mid='".$_GET['mid']."'";
	$dbi->query($sql);
}

$links[] = array(
  "img" => $_ENV['imgs']['style'],
  "txt" => "Style Preferences",
  "url" => "?module=prefs&action=style"
);

$links[] = array(
  "img" => $_ENV['imgs']['group'],
  "txt" => "Group Preferences",
  "url" => "?module=prefs&action=group"
);

// pull user information for this user
$sql  = "SELECT first_name,last_name,email,sms,address,address2,telephone ";
$sql .= "FROM users ";
$sql .= "WHERE userid='".$_SESSION['userid']."'";
$user = $dbi->fetch_row($sql,"array");
$smarty->assign('user',$user);

$sql  = "SELECT mid,text,url ";
$sql .= "FROM menus ";
$sql .= "WHERE userid='".$_SESSION['userid']."'";
$menu_items = $dbi->fetch_all($sql,"array");
$smarty->assign('menu_items',$menu_items);

$issue_fields = array(
	array( "field" => "issueid",			"name" => "Issue Number"	),
	array( "field" => "opened_by",		"name" => "Opened By"			),
	array( "field" => "assigned_to",	"name" => "Assigned To"		),
	array( "field" => "modified",			"name" => "Last Modified"	),
	array( "field" => "status",				"name" => "Status"				),
	array( "field" => "category",			"name" => "Category"			),
	array( "field" => "severity",			"name" => "Severity"			),
  array( "field" => "product",      "name" => "Product"       ),
  array( "field" => "flags",        "name" => "Flags"         )
);

$smarty->assign('issue_fields',$issue_fields);
$smarty->display("prefs/prefs.tpl");
?>
