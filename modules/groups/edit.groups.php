<?php
/* $Id: edit.groups.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Groups
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

if (!is_employee() or empty($_GET['type'])) {
  redirect();
}

$wizard = array("categories","products","statuses");

/* {{{ Edit Types */
$edit_types = array(
	/* {{{ Categories */
	"categories" => array(
		"gtable"	=> "group_categories",
		"table"		=> "categories",
		"id"			=> "cid",
		"field"		=> "category",
		"gfunc"		=> "group_categories",
		"func"		=> "category",
		"single"	=> "category",
		"plural"	=> "categories"
	),
	/* }}} */
	/* {{{ Products */
	"products" => array(
		"gtable"	=> "group_products",
		"table"		=> "products",
		"id"			=> "pid",
		"field"		=> "product",
		"gfunc"		=> "group_products",
		"func"		=> "product",
		"single"	=> "product",
		"plural"	=> "products"
	),
	/* }}} */
	/* {{{ Statuses */
	"statuses" => array(
		"gtable"	=> "group_statuses",
		"table"		=> "statuses",
		"id"			=> "sid",
		"field"		=> "status",
		"gfunc"		=> "group_statuses",
		"func"		=> "status",
		"single"	=> "status",
		"plural"	=> "statuses"
	),
	/* }}} */
	/* {{{ Internal Statuses */
	"istatuses" => array(
		"gtable"	=> "group_istatuses",
		"table"		=> "statuses",
		"id"			=> "sid",
		"field"		=> "status",
		"gfunc"		=> "group_istatuses",
		"func"		=> "status",
		"single"	=> "internal status",
		"plural"	=> "internal statuses"
	),
	/* }}} */
	/* {{{ Escalation Points */
	"escalation" => array(
		"gtable"	=> "escalation_points",
		"table"		=> "groups",
		"id"			=> "gid",
		"field"		=> "name",
		"gfunc"		=> "escalation_groups",
		"func"		=> "group_name",
		"single"	=> "escalation point",
		"plural"	=> "escalation points"
	)
	/* }}} */
);
/* }}} */

/* {{{ Short Form Variables */
$id 		= $edit_types[$_GET['type']]['id'];
$field	= $edit_types[$_GET['type']]['field'];
$gtable	= $edit_types[$_GET['type']]['gtable'];
$table	= $edit_types[$_GET['type']]['table'];
$gfunc	= $edit_types[$_GET['type']]['gfunc'];
$func		= $edit_types[$_GET['type']]['func'];
$single	= $edit_types[$_GET['type']]['single'];
$plural	= $edit_types[$_GET['type']]['plural'];
/* }}} */

if ($_GET['submit'] == "true") {
	if (is_array($_POST['add'])) {
		foreach ($_POST['add'] as $val) {
			$insert['gid']	= $_GET['gid'];
			if ($_GET['type'] == "escalation") {
				$insert['egid'] = $val;
			} else {
				$insert[$id] = $val;
			}
			$dbi->insert($gtable,$insert);
		}
	}

	if (is_array($_POST['del'])) {
    foreach ($_POST['del'] as $val) {
      $sql  = "DELETE FROM $gtable ";
      $sql .= "WHERE gid='".$_GET['gid']."' ";
      if ($_GET['type'] == "escalation") {
        $sql .= "AND egid='$val'";
      } else {
        $sql .= "AND $id='$val'";
      }
      $dbi->query($sql);
    }
	}

  if (isset($_SESSION['GROUP_WIZARD'])) {
    if (in_array($_GET['type'],$wizard)) {
      $sql  = "SELECT count($id) ";
      $sql .= "FROM $gtable ";
      $sql .= "WHERE gid='".$_GET['gid']."' ";
      $result = $dbi->query($sql);
      list($num) = $dbi->fetch($result);

      if ($num < 1) {
        push_error("Groups must have at least one $single.");
        push_error("If no $plural are available to add to this group, contact the system admin at "._ADMINEMAIL_);
      }	else {
        if (array_search($_GET['type'],$wizard) == (count($wizard) - 1)) {
          unset($_SESSION['GROUP_WIZARD']);
          redirect("?module=groups&action=view&gid=".$_GET['gid']);
        } else {
          $type = $wizard[array_search($_GET['type'],$wizard) + 1];
          redirect("?module=groups&action=edit&type=$type&gid=".$_GET['gid']);
        }
      }
    } else {
      redirect("?module=groups&action=edit&type=".$_GET['type']."&gid=".$_GET['gid']);
    }
  } else {
    redirect("?module=groups&action=view&gid=".$_GET['gid']);
  }
}

if (group_exists($_GET['gid'])) {
  $links[] = array(
    "txt" => "Back to Group Information",
    "url" => "?module=groups&action=view&gid=".$_GET['gid'],
    "img" => $_ENV['imgs']['back']
  );

  $smarty->assign('plural',$plural);
  $smarty->assign('title',group_name($_GET['gid'])." ".ucwords($plural));
  
	$list = $gfunc($_GET['gid']);
  $smarty->assign('list',$list);

  $sql  = "SELECT $id as id,$field as field ";
  $sql .= "FROM $table ";
  $sql .= "ORDER BY $field";
  $data = $dbi->fetch_all($sql,"array");
  $smarty->assign('data',$data);

  $smarty->display("groups/edit.tpl");
} else {
  redirect("?module=groups");
}
?>
