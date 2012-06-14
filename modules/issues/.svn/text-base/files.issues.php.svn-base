<?php
/* $Id: files.issues.php 2 2004-08-05 21:42:03Z eroberts $ */
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

if (!empty($_GET['private'])
and !empty($_GET['fid'])
and issue_priv($_GET['issueid'],"view_private")) {
  $sql  = "SELECT typeid ";
  $sql .= "FROM files ";
  $sql .= "WHERE fid='".$_GET['fid']."' ";
  $sql .= "AND file_type='issues' ";
  $id = $dbi->fetch_one($sql);
  if ($id == $_GET['issueid']) {
    $update['private'] = $_GET['private'] == "true" ? "t" : "f";
    $dbi->update("files",$update,"WHERE fid='".$_GET['fid']."'");
  }
}

if ($_GET['submit'] == "true") {
  upload($_GET['issueid']);
  redirect("?module=issues&action=files&issueid=".$_GET['issueid']);
}

if (can_view_issue($_GET['issueid'])) {
  $links[] = array(
    "txt" => "Back to Issue",
    "url" => "?module=issues&action=view&issueid=".$_GET['issueid'],
    "img" => $_ENV['imgs']['back']
  );

  $sql  = "SELECT fid,userid,uploaded_on,name,private ";
  $sql .= "FROM files ";
  $sql .= "WHERE typeid='".$_GET['issueid']."'";
  $sql .= "AND file_type='issues' ";
  $sql .= !issue_priv($_GET['issueid'],"view_private") ? "AND private != 't' " : "";
  $sql .= "ORDER BY uploaded_on";
  $files = $dbi->fetch_all($sql,"array"); 
  $smarty->assign('files',$files);

  $smarty->display("issues/files.tpl");
} else {
  redirect();
}
?>
