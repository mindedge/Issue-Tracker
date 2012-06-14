<?php
/* $Id: edit_permissions.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
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

$sql  = "SELECT permsetid,name ";
$sql .= "FROM permission_sets";
$result = $dbi->query($sql);
if ($dbi->num_rows($result) > 0) {
	$sets = array();

	while (list($id,$name) = $dbi->fetch($result)) {
		$sets[$id] = $name;
	}
}
$smarty->assign('psets',$sets);

$members = group_members($_GET['gid']);
$smarty->assign('members',$members);

if ($_GET['submit'] == "true") {
	foreach ($members as $key => $val) {
		$update['perm_set'] = $_POST["perm_set_$key"];
		$dbi->update("group_users",$update,"WHERE userid='$key' AND gid='".$_GET['gid']."'");
		unset($update);
		logger("$val permission set for ".group_name($_GET['gid'])." set to ".$sets[$_POST["perm_set_".$key]].".","user_permissions");
	}

  $sql  = "DELETE FROM group_permissions ";
  $sql .= "WHERE gid='".$_GET['gid']."'";
  $dbi->query($sql);
  
  if (is_array($_POST['group_perms'])) {
    foreach ($_POST['group_perms'] as $key => $val) {
      $insert['gid']    = $_GET['gid'];
      $insert['permid'] = !empty($val) ? $val : 'NULL';
      $dbi->insert("group_permissions",$insert);
      unset($insert);
    }
  }
  
	redirect("?module=groups&action=view&gid=".$_GET['gid']);
}
	
$links[] = array(
  "txt" => "Back to Group Information",
  "url" => "?module=groups&action=view&gid=".$_GET['gid'],
  "img" => $_ENV['imgs']['back']
);

$sql  = "SELECT permid,permission ";
$sql .= "FROM permissions ";
$sql .= "WHERE group_perm='t'";
$perms = $dbi->fetch_all($sql,"array");
$smarty->assign('perms',$perms);

$sql  = "SELECT permid ";
$sql .= "FROM group_permissions ";
$sql .= "WHERE gid='".$_GET['gid']."'";
$gperms = $dbi->fetch_all($sql);
$smarty->assign('gperms',$gperms);

$smarty->display("groups/edit_permissions.tpl");
?>
