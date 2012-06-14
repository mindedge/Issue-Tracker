<?php
/* $Id: files.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

// Make sure user is an admin
if (!is_admin()) {
  redirect();
}

if ($_GET['subaction'] == "delete") {
  if ($_POST['confirm'] == "true") {
    $sql  = "SELECT file_type,typeid,name,uploaded_on ";
    $sql .= "FROM files ";
    $sql .= "WHERE fid='{$_GET['fid']}'";
    $data = $dbi->fetch_row($sql,"array");
    if (!is_null($data)) {
      if (!mime_check($data['name'])) {
        $data['name'] .= ".dl";
      }
      
      $filename = !empty($data['uploaded_on']) 
        ? "{$data['uploaded_on']}-{$data['name']}" 
        : $data['$name'];
     
      if (file_exists(_FILES_."{$data['file_type']}/{$data['typeid']}/$filename")) {
        unlink(_FILES_."{$data['file_type']}/{$data['typeid']}/$filename");
      }
      
      $sql  = "DELETE FROM files WHERE fid='".$_GET['fid']."'";
      $dbi->query($sql);

      $update['fid'] = "";
      $dbi->update("events",$update,"WHERE fid='".$_GET['fid']."'");
      
      if ($data['file_type'] == "issues") {
        issue_log($id,"File {$data['name']} removed from issue");
        redirect("?module=issues&action=files&issueid={$data['typeid']}");
        return;
      }

      redirect("?module=admin&action=files");
    }
  } else {
    $smarty->display("admin/files/delete.tpl");
  }
} else {
  $links[] = array(
    "txt" => "Back to Administration",
    "url" => "?module=admin",
    "img" => $_ENV['imgs']['back']
  );
}
?>
