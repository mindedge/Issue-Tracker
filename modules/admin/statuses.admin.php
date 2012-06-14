<?php
/* $Id: statuses.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

// Used to make sure only 1 "Registered" status is defined
list($registered) = fetch_status(TYPE_REGISTERED);
$smarty->assign('status_types',$status_types);

if(is_admin() or permission_check('status_manager')){
  if ($_GET['subaction'] == "delete"
  and !empty($_GET['id'])) {
    if ($_POST['confirm'] == "true") {
	  	$sql  = "DELETE FROM statuses ";
  	  $sql .= "WHERE sid='".$_GET['id']."'";
 	  	$dbi->query($sql);
	  gen_cache("statuses","sid","status");//regnerate the status cache file MWarner 2/4/2010
      
      redirect("?module=admin&action=statuses");
    } else {
      $smarty->display("admin/statuses/delete.tpl");
    }
  } else if ($_GET['subaction'] == "new") {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['status'])) {
        push_error("Status can not be empty.");
      } else if ($_POST['status_type'] == TYPE_REGISTERED
      and !empty($registered)) {
        push_error("Only one \"Registered\" status is allowed.");
      } else {
        $sql  = "SELECT sid ";
        $sql .= "FROM statuses ";
        $sql .= "WHERE LOWER(status) = LOWER('".trim($_POST['status'])."')";
        $sid = $dbi->fetch_one($sql);
        if (!empty($sid)) {
          push_error("This status already exists.");
        } else {
          $insert['status'] = $_POST['status'];
          $insert['status_type'] = $_POST['status_type'];
          $dbi->insert("statuses",$insert);
		  gen_cache("statuses","sid","status");//regnerate the status cache file MWarner 2/4/2010
          redirect("?module=admin&action=statuses");
        }
      }
    }
    
    if (empty($_POST['commit']) or errors()) {
      $smarty->display("admin/statuses/new.tpl");
    }
  } else if ($_GET['subaction'] == "edit" and !empty($_GET['id'])) {
    if ($_POST['commit'] == "true") {
      if (empty($_POST['status'])) {
        push_error("Status can not be empty.");
      } else if ($_POST['status_type'] == TYPE_REGISTERED
      and !empty($registered)
      and $_GET['id'] != $registered) {
        push_error('Only one "Registered" status is allowed.');
      } else {
        $sql  = "SELECT sid ";
        $sql .= "FROM statuses ";
        $sql .= "WHERE LOWER(status) = LOWER('".trim($_POST['status'])."')";
        $sid = $dbi->fetch_one($sql);
        if (empty($sid) or $sid == $_GET['id']) {
          $update['status'] = $_POST['status'];
          $update['status_type'] = $_POST['status_type'];
          $dbi->update("statuses",$update,"WHERE sid='".$_GET['id']."'");
		  gen_cache("statuses","sid","status");//regnerate the status cache file MWarner 2/4/2010
          redirect("?module=admin&action=statuses");
        } else {
          push_error("This status already exists.");
        }
      }
    } 

    if (empty($_POST['commit']) or errors()) {
      $sql  = "SELECT status,status_type ";
      $sql .= "FROM statuses ";
      $sql .= "WHERE sid='".$_GET['id']."'";
      $status = $dbi->fetch_row($sql,"array");
      $smarty->assign('status',$status);
      $smarty->display("admin/statuses/edit.tpl");
    }
  } else {
    $links[] = array(
      "txt" => "Back to Administration",
      "url" => "?module=admin",
      "img" => $_ENV['imgs']['back']
    );
  	$links[] = array(
	  	"txt"	=> "New Status",
		  "url"	=> "?module=admin&action=statuses&subaction=new",
      "img" => $_ENV['imgs']['status']
    );

  	$sql  = "SELECT sid,status,status_type ";
	  $sql .= "FROM statuses ";
  	$sql .= "ORDER BY status";
    $statuses = $dbi->fetch_all($sql,"array");
    $num_statuses = count($statuses);
    for ($x = 0;$x < $num_statuses;$x++) {
      $statuses[$x]['status_type'] = $status_types[$statuses[$x]['status_type']];
    }
    $smarty->assign('statuses',$statuses);
    $smarty->display("admin/statuses.tpl");
  }
} else {
  redirect();
}
?>
