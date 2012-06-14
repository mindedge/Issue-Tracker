<?php
/* $Id: new.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Groups
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (!is_employee()) {
  redirect();
}

if (!empty($_POST['gname'])) {
  // make sure a group name was given
  if (empty($_POST['gname'])) {
    push_error("Please enter a name for this group");
  }
  if (!empty($_POST['startdate'])
  and !preg_match("^(0{0,1}[1-9]|1[012])/(0{0,1}[1-9]|[12][0-9]|3[01])/(19|20)[0-9][0-9]$",$_POST['startdate'])) {
    push_error("Invalid start date.");
  }
  if (!empty($_POST['enddate'])
  and !preg_match("^(0{0,1}[1-9]|1[012])/(0{0,1}[1-9]|[12][0-9]|3[01])/(19|20)[0-9][0-9]$",$_POST['enddate'])) {
    push_error("Invalid end date.");
  }
  if (!empty($_POST['amount']) and !preg_match('[0-9\.]{1,}',$_POST['amount'])) {
    push_error("Invalid value given for amount, please exclude commas. (#.##)");
  }

  $sql  = "SELECT gid ";
  $sql .= "FROM groups ";
  $sql .= "WHERE LOWER(name)=LOWER('".addslashes($_POST['gname'])."')";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    push_error("This group name is already taken.");
  }

  if (!errors()) {
    $parts = explode("/",$_POST['startdate']);
    $sdate = mktime(0,0,0,$parts[0],$parts[1],$parts[2]);
    $parts = explode("/",$_POST['enddate']);
    $edate = mktime(0,0,0,$parts[0],$parts[1],$parts[2]);

    $insert['name']       = $_POST['gname'];
    $insert['address']    = $_POST['address'];
    $insert['address2']   = $_POST['address2'];
    $insert['contact']    = $_POST['pcontact'];
    $insert['tech']       = $_POST['tcontact'];
    $insert['tao']        = $_POST['tao'];
    $insert['brm']        = $_POST['brm'];
    $insert['sales']      = $_POST['sales'];
    $insert['amount']     = !empty($_POST['amount']) ? $_POST['amount'] : 0;
    $insert['bought']     = !empty($_POST['bought']) ? $_POST['bought'] : 0;
    $insert['start_date'] = $sdate;
    $insert['end_date']   = $edate;
    if (!empty($_POST['type'])) {
      $insert['group_type'] = $_POST['grouptype'];
    }
    $insert['email']      = $_POST['emailaddy'];
    $insert['notes']      = $_POST['notes'];

    // insert new group into datbase
    $gid = $dbi->insert("groups",$insert,"groups_gid_seq");

    if (!empty($gid)) {
      group_useradd($_SESSION['userid'],$gid);

      $update['perm_set'] = PSET_GADMIN;
      $dbi->update("group_users",$update,"WHERE gid='$gid' AND userid='".$_SESSION['userid']."'");
      unset($update);
      @session_register('GROUP_WIZARD');
      $_SESSION['GROUP_WIZARD'] = TRUE;
      gen_cache("groups","gid","name");
      redirect("?module=groups&action=edit&type=categories&gid=$gid");
    } else {
      push_error("This group could not be created please contact "._ADMINEMAIL_." about this issue.");
    }
  }
}

$links[] = array(
  "txt" => "Back to Groups",
  "url" => "?module=groups",
  "img" => $_ENV['imgs']['back']
);

$smarty->display("groups/new.tpl");
?>
