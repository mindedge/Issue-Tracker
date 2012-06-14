<?php
/* $Id: edit_motd.admin.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

if (!empty($_POST['motd'])) {
	if ($fp = @fopen(_INCLUDES_."motd","w")) {
		fwrite($fp,$_POST['motd']);
		fclose($fp);
    redirect();
	} else {
		push_error("Could not open motd file for writing.");
	}
}

$links[] = array(
  "txt" => "Back to Administration",
  "url" => "?module=admin",
  "img" => $_ENV['imgs']['back']
);

if (file_exists(_INCLUDES_."motd")) {
	if ($fp = fopen(_INCLUDES_."motd","r")) {
		$motd = stripslashes(fread($fp,filesize(_INCLUDES_."motd")));
		fclose($fp);
    $smarty->assign('motd',$motd);
	} else {
		push_error("Could not open motd file for reading.");
	}
}

$smarty->display("admin/edit_motd.tpl");
?>
