<?php
/* $Id: funcs.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Groups
 */

//if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

/* {{{ Function: group_exists */
/**
 * Verifies that a group actually exists with given gid
 *
 * @param integer $gid ID of group to verify
 * @return boolean
 */
function group_exists($gid)
{
	global $dbi;

	$sql  = "SELECT gid ";
	$sql .= "FROM groups ";
	$sql .= "WHERE gid='".trim($gid)."'";
	$result = $dbi->query($sql);
	if ($dbi->num_rows($result) > 0) {
    $dbi->free($result);
		return TRUE;
	}

	return FALSE;
}
/* }}} */

/* {{{ Function: group_name */
/**
 * Get the name of a group from the database and return it
 *
 * @param integer $gid ID of group to get name of
 * @return string
 */
function group_name($gid)
{
  global $dbi,$groups_name_cache,$cache_data;

  if (is_array($groups_name_cache)
  and in_array("groups",$cache_data)
  and @array_key_exists($gid,$groups_name_cache)) {
    return $groups_name_cache[$gid];
  } else {
    // Since we didn't find the name in cache
    // make sure to generate new cache file
    gen_cache("groups","gid","name");
    
    $sql  = "SELECT name ";
    $sql .= "FROM groups ";
    $sql .= "WHERE gid='$gid'";
    $result = $dbi->query($sql);
    if($dbi->num_rows($result) > 0){
      list($name) = $dbi->fetch($result);
      $dbi->free($result);
      return stripslashes($name);
    }

    return "UNKNOWN";
  }
}
/* }}} */

/* {{{ Function: group_useradd */
/**
 * Add a user to a group
 *
 * @param integer $userid ID of user to add to group
 * @param integer $gid ID of group to add user to
 */
function group_useradd($userid,$gid)
{
  global $dbi;

  // check to make sure this user isn't already in the group
  $sql  = "SELECT userid ";
  $sql .= "FROM group_users ";
  $sql .= "WHERE gid='$gid' ";
  $sql .= "AND userid='$userid'";
  $result = $dbi->query($sql);
  if($dbi->num_rows($result) > 0){
    $dbi->free($result);
    return;
  }

  // form insert array
  $insert["userid"]       = $userid;
  $insert["gid"]          = $gid;
  $insert["show_group"]   = "t";
  $dbi->insert("group_users",$insert);

  $uname  = username($userid,FALSE);
  $gname  = group_name($gid);
  logger("$uname added to $gname.","users");
}
/* }}} */

/* {{{ Function: group_userdel */
/**
 * Remove a user from a group
 *
 * @param integer $userid ID of user to remove from group
 * @param integer $gid ID of group to remove user from
 * @return boolean
 */
function group_userdel($userid,$gid)
{
  // pull globals
  global $dbi;

	$uname  = username($userid);
	$gname  = group_name($gid);
	
  $sql  = "DELETE FROM group_users ";
  $sql .= "WHERE gid='$gid' ";
  $sql .= "AND userid='$userid'";
  $result = $dbi->query($sql);
	if ($dbi->affected_rows($result) == 1) {
		logger("$uname removed from $gname","users");	
    $notify_email = notify_list($gid,"E");
    $notify_sms = notify_list($gid,"S");

    if (in_array($userid,$notify_email)) {
      notify_del($val,$_GET['gid'],"E");
    }
    if (in_array($userid,$notify_sms)) {
      notify_del($val,$_GET['gid'],"S");
    }
		return TRUE;
	} else {
		return FALSE;
	}
}
/* }}} */

/* {{{ Function: group_members */
/**
 * Retrieve array of uids for group
 *
 * @param integer $gid ID of group to get members list for
 * @param string $ignore INTERNAL FUNCTION USE ONLY
 * @return array
 */
function group_members($gid,$ignore = null)
{
  // pull globals
  global $dbi;

  // initialize empty array
  $members = array();

  // retrieve users that are directly part of group
  $sql  = "SELECT userid ";
  $sql .= "FROM group_users ";
  $sql .= "WHERE gid='$gid'";
	$result = $dbi->query($sql);
	if ($dbi->num_rows($result) > 0) {
    while (list($uid) = $dbi->fetch($result)) {
      array_push($members,$uid);
    }

		$dbi->free($result);
  }

  // retrieve users from parent group
  if ($ignore != "parent") {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_user='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $parent_members = group_members($parent,"child");

      foreach ($parent_members as $key => $val) {
        if (!in_array($key,$members)) {
          array_push($members,$key);
        }
      }
    }
  }

  // retrieve users from child groups that are set
  // to propogate to parent group
  if ($ignore != "child") {
    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_user='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $child_members = group_members($child,"parent");

        foreach ($child_members as $key => $val) {
          if (!in_array($key,$members)) {
            array_push($members,$key);
          }
        }
      }

      $dbi->free($result);
    }
  }

  // now turn $members array into associative array
  // of userid/username pairs
  $mbrs = implode(",",$members);
  $sql  = "SELECT userid,username ";
  $sql .= "FROM users ";
  $sql .= "WHERE userid IN ($mbrs) ";
  $sql .= "ORDER BY username";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    while (list($userid,$username) = $dbi->fetch($result)) {
      $group_users[$userid] = $username;
    }
  }

  return $group_users;
}
/* }}} */

/* {{{ Function: notify_add */
/**
 * Add user to default notify list of a group
 *
 * @param integer $userid ID of user to add to notify list
 * @param integer $gid ID of group to add user to
 */
function notify_add($userid,$gid,$type)
{
  // pull globals
  global $dbi;

  if($type != "S"){
    $type = "E";
  }

  $sql  = "SELECT userid ";
  $sql .= "FROM notifications ";
  $sql .= "WHERE userid='$userid' ";
  $sql .= "AND gid='$gid' ";
  $sql .= "AND type='$type'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
    $dbi->free($result);
		return;
  } else {
		$insert['userid'] = $userid;
  	$insert['gid']    = $gid;
    $insert['type']   = $type;

	  $dbi->insert("notifications",$insert);
  	unset($insert);
  }

	$uname = username($userid,FALSE);
  $gname = group_name($gid);
	logger("Adding $uname to $type notification list of $gname.","users");
}
/* }}} */

/* {{{ Function: notify_del */
/**
 * Remove user from default notify list of a group
 *
 * @param integer $userid ID of user to remove from notify list
 * @param integer $gid ID of group to remove from
 * @return boolean
 */
function notify_del($userid,$gid,$type)
{
  global $dbi;

  $sql  = "DELETE FROM notifications ";
  $sql .= "WHERE userid='$userid' ";
  $sql .= "AND gid='$gid' ";
  $sql .= "AND type='$type'";
	$result = $dbi->query($sql);
  if($dbi->affected_rows($result) == 1){
	  $uname = username($userid,FALSE);
    $gname = group_name($gid);
    logger("Removing $uname from default notify list of $gname.","users");

		return TRUE;
  } else {
		return FALSE;
	}
}
/* }}} */

/* {{{ Function: notify_list */
/**
 * Retrive list of users receiving notifications for a group
 *
 * @param integer $gid ID of group to check
 * @param string $type Type of notifcations 'E' = Email, 'S' = SMS
 * @return array
 */
function notify_list($gid,$type = "E")
{
  global $dbi;

  $notify = array();

  $sql  = "SELECT userid ";
  $sql .= "FROM notifications ";
  $sql .= "WHERE gid='$gid' ";
  $sql .= "AND type='$type'";
  $result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
    while(list($uid) = $dbi->fetch($result)){
      $notify[] = $uid;
    }
		$dbi->free($result);
  }

  return $notify;
}
/* }}} */

/* {{{ Function: group_active */
/**
 * Determine if a group is active
 *
 * @param integer $gid ID of group to check
 * @return boolean
 */
function group_active($gid)
{
	// pull in globals
	global $dbi;

	$sql  = "SELECT active ";
	$sql .= "FROM groups ";
	$sql .= "WHERE active='t' ";
	$sql .= "AND gid='$gid'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		$dbi->free($result);
		return TRUE;
  }

	return FALSE;
}
/* }}} */

/* {{{ Function: show_group */
/**
 * Determine if we should show the group to the user or not
 *
 * @param integer $gid ID of group
 * @return boolean
 */
function show_group($gid)
{
	global $dbi;

	$sql  = "SELECT show_group ";
	$sql .= "FROM group_users ";
	$sql .= "WHERE gid='$gid' ";
	$sql .= "AND userid='".$_SESSION['userid']."'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		list($show) = $dbi->fetch($result);
    $dbi->free($result);
		if($show == "f"){
			return FALSE;
		}
	}

	return TRUE;
}
/* }}} */

/* {{{ Function: escalation_groups */
/**
 * Retrieve array of escalation groups for a group
 *
 * @param integer $gid ID of group
 * @return array
 */
function escalation_groups($gid)
{
	global $dbi;

	$egroups = array();

	$sql  = "SELECT g.name,e.egid ";
	$sql .= "FROM groups g, escalation_points e ";
	$sql .= "WHERE e.gid='$gid' ";
  $sql .= "AND e.egid=g.gid";
  $groups = $dbi->fetch_all($sql,"array");
  if (!is_null($groups)) {
    foreach ($groups as $group) {
      $egroups[$group['egid']] = $group['name'];
		}
	}

	return $egroups;
}
/* }}} */

/* {{{ Function: group_statuses */
/**
 * Retrieve array of statuses for a group
 *
 * @param integer $gid ID of group
 * @param string $ignore INTERNAL FUNCTION USE ONLY
 * @return array
 */
function group_statuses($gid,$ignore = null)
{
	global $dbi;

  $allowed = implode(",",fetch_status(array(
    TYPE_WAITING,
    TYPE_LONG_TERM,
    TYPE_CLOSED
  )));

	$statuses = array();

	$sql  = "SELECT g.sid,s.status ";
	$sql .= "FROM group_statuses g, statuses s ";
	$sql .= "WHERE g.gid='$gid' ";
	$sql .= "AND g.sid = s.sid ";
  $sql .= "AND s.sid IN ($allowed) ";
	$sql .= "ORDER BY s.status";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		while(list($sid,$status) = $dbi->fetch($result)){
			$statuses[$sid] = $status;
		}

    $dbi->free($result);
	}

  if ($ignore != "parent") {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_status='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $s = group_statuses($parent,"child");
      
      if (count($s) > 0) {
        foreach ($s as $key => $val) {
          if (!array_key_exists($key,$statuses)) {
            $statuses[$key] = $val;
          }
        }
      }
    }
  }

  if ($ignore != "child") {
    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_status='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $s = group_statuses($child);

        if (count($s) > 0) {
          foreach ($s as $key => $val) {
            if (!array_key_exists($key,$statuses)) {
              $statuses[$key] = $val;
            }
          }
        }
      }

      $dbi->free($result);
    }
  }

	return $statuses;
}
/* }}} */

/* {{{ Function: group_istatuses */
/**
 * Retrieve array of internal statuses for a group
 *
 * @param integer $gid ID of group
 * @param string $ignore INTERNAL FUNCTION USE ONLY
 * @return array
 */
function group_istatuses($gid,$ignore = null)
{
	global $dbi;

	$statuses = array();

	$sql  = "SELECT g.sid,s.status ";
	$sql .= "FROM group_istatuses g, statuses s ";
	$sql .= "WHERE g.gid='$gid' ";
	$sql .= "AND g.sid = s.sid ";
	$sql .= "ORDER BY s.status";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		while(list($sid,$status) = $dbi->fetch($result)){
			$statuses[$sid] = $status;
		}

    $dbi->free($result);
	}

  if ($ignore != "parent") {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_status='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $s = group_istatuses($parent,"child");
      
      if (count($s) > 0) {
        foreach ($s as $key => $val) {
          if (!array_key_exists($key,$statuses)) {
            $statuses[$key] = $val;
          }
        }
      }
    }
  }

  if ($ignore != "child") {
    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_status='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $s = group_istatuses($child);

        if (count($s) > 0) {
          foreach ($s as $key => $val) {
            if (!array_key_exists($key,$statuses)) {
              $statuses[$key] = $val;
            }
          }
        }
      }

      $dbi->free($result);
    }
  }

	return $statuses;
}
/* }}} */

/* {{{ Function: group_categories */
/**
 * Retrieve array of categories for a group
 *
 * @param integer $gid ID of group
 * @param string $ignore INTERNAL FUNCTION USE ONLY
 * @return array
 */
function group_categories($gid,$ignore = null)
{
	global $dbi;

	$categories = array();

	$sql  = "SELECT g.cid,c.category ";
	$sql .= "FROM group_categories g, categories c ";
	$sql .= "WHERE g.gid='$gid' ";
	$sql .= "AND g.cid = c.cid ";
	$sql .= "ORDER BY c.category";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		while(list($cid,$category) = $dbi->fetch($result)){
			$categories[$cid] = $category;
		}
	}

  if ($ignore != "parent") {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_category='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $c = group_categories($parent,"child");
      
      if (count($c) > 0) {
        foreach ($c as $key => $val) {
          if (!array_key_exists($key,$categories)) {
            $categories[$key] = $val;
          }
        }
      }
    }
  }

  if ($ignore != "child") {
    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_category='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $c = group_categories($child,"parent");

        if (count($c) > 0) {
          foreach ($c as $key => $val) {
            if (!array_key_exists($key,$categories)) {
              $categories[$key] = $val;
            }
          }
        }
      }

      $dbi->free($result);
    }
  }

	return $categories;
}
/* }}} */

/* {{{ Function: group_products */
/**
 * Retrieve array of products for a group
 *
 * @param integer $gid ID of group
 * @param string $ignore INTERNAL FUNCTION USE ONLY
 * @return array
 */
function group_products($gid,$ignore = null)
{
	global $dbi;

	$products = array();

	$sql  = "SELECT p.pid,p.product ";
	$sql .= "FROM group_products g, products p ";
  $sql .= "WHERE p.pid=g.pid ";
	$sql .= "AND g.gid='$gid'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		while(list($pid,$product) = $dbi->fetch($result)){
			$products[$pid] = $product;
		}
	}

  if ($ignore != "parent") {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_product='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $p = group_products($parent);
      
      if (count($p) > 0) {
        foreach ($p as $key => $val) {
          if (!array_key_exists($key,$products)) {
            $products[$key] = $val;
          }
        }
      }
    }
  }

  if ($ignore != "child") {
    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_product='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $p = group_products($child);

        if (count($p) > 0) {
          foreach ($p as $key => $val) {
            if (!array_key_exists($key,$products)) {
              $products[$key] = $val;
            }
          }
        }
      }

      $dbi->free($result);
    }
  }

	return $products;
}
/* }}} */

/* {{{ Function: user_in_group */
/**
 * Determine if a user is a member of given group
 *
 * @param integer $gid ID of group
 * @param integer $userid ID of user
 * @return boolean
 */
function user_in_group($gid,$userid = null)
{
  global $dbi;

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }

  $members = group_members($gid);
  if (is_array($members)) {
    if (array_key_exists($userid,$members)) {
      return TRUE;
    }
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: is_parent */
/**
 * Determines if a group is the parent group of another
 *
 * @param integer $parent Possible parent group
 * @param integer $child Possible child group
 * @return boolean
 */
function is_parent($parent,$child)
{
  global $dbi;

  $sql  = "SELECT parent_gid ";
  $sql .= "FROM sub_groups ";
  $sql .= "WHERE parent_gid='$parent' ";
  $sql .= "AND child_gid='$child'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    $dbi->free($result);
    return TRUE;
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: is_child */
/**
 * Determines if a group is a child group of another
 *
 * @param integer $child Possible child group
 * @param integer $parent Possible parent group
 * @return boolean
 */
function is_child($child,$parent)
{
  global $dbi;

  $sql  = "SELECT child_gid ";
  $sql .= "FROM sub_groups ";
  $sql .= "WHERE child_gid='$child' ";
  $sql .= "AND parent_gid='$parent'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    $dbi->free($result);
    return TRUE;
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: possible_children */
/**
 * Retrieves an array of possible sub groups
 * for the given group
 *
 * @param integer $gid ID of group
 * @return array
 */
function possible_children($gid)
{
  global $dbi;
  
  $children = array();
  
  $sql  = "SELECT gid,name ";
  $sql .= "FROM groups ";
  $sql .= "ORDER BY name";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    while (list($id,$name) = $dbi->fetch($result)) {
      if (is_parent($id,$gid)
      or is_child($id,$gid)
      or $id == $gid) {
        continue;
      }

      $groups[$id] = $name;
    }
  }
   
  return $groups;
}
/* }}} */

/* {{{ Function: group_issues */
/**
 * Retrieve array of issues that should be viewable by given group
 *
 * @param integer $gid ID of group
 * @param integer $limit Number of issues to return
 * @param boolean $show_registered Whether or not to show registered issues
 * @param string $ignore INTERNAL FUNCTION USE ONLY
 * @return array
 */
function group_issues($gid,$limit = null,$show_registered = TRUE,$ignore = null)
{
  global $dbi;

  if (empty($_GET['sort'])) {
    $_GET['sort'] = $_SESSION['prefs']['sort_by'];
  }

  $issues = array();
  list($registered) = fetch_status(TYPE_REGISTERED);
  $closed = implode(",",fetch_status(array(TYPE_CLOSED,TYPE_AUTO_CLOSED)));

  if ($ignore != "parent") {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_issue='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $gid .= ",$parent";
    }
  }

  if ($ignore != "child") {
    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_issue='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $gid .= ",$child";
      }

      $dbi->free($result);
    }
  }
    // pull due_date, doo MWarner 3/23/2010
	$sql  = "SELECT i.issueid,i.summary,i.private, i.due_date, i.opened_by";

	foreach ($_SESSION['prefs']['show_fields'] as $val) {
		switch ($val) {
      case "flags":
        continue;
        break;
			case "assigned_to":
				$sql .= ",g.assigned_to";//,u.username
				break;
			case "opened_by":
				$sql .= ",u.username";
				break;
			default:
				$sql .= ",i.$val";
				break;
		}
	}

	$sql .= " FROM issues i, issue_groups g";
	//always pull from this table MWarner 5/31/2012
  $sql .= (1 || in_array("opened_by",$_SESSION['prefs']['show_fields']) )? ",users u" : "";
  if (preg_match(",",$gid)) {
    $sql .= " WHERE g.gid IN ($gid) ";
  } else {
  	$sql .= " WHERE g.gid = '$gid' ";
  }
	$sql .= "AND i.issueid = g.issueid ";
	//get assigned_to's name table MWarner 5/31/2012
	if($_GET["sort"]=="assigned_to"){
		$sql .= "AND u.userid = g.assigned_to ";
	}else{
  		$sql .= in_array("opened_by",$_SESSION['prefs']['show_fields']) ? "AND u.userid = i.opened_by " : "";
	}
	

 	
	$sql .= !permission_check("view_private",$gid) ? "and i.private != 't' " : "";
  $sql .= !$show_registered ? "AND i.status != '$registered' " : "";
  $sql .= $_GET['showall'] != "true" ? "AND i.status NOT IN ($closed) " : "";

	if ($_GET['sort'] == "assigned_to") {
		//$sql .= "ORDER BY g.assigned_to ";
		$sql .= "ORDER BY u.username ";
	} else if ($_GET['sort'] == "opened_by") {
		$sql .= "ORDER BY u.username ";
	} else {
		$sql .= "ORDER BY i.".$_GET['sort']." ";
	}

  if ($_GET['sort'] == "severity") {
    $sql .= $_GET['reverse'] == "true" ? "DESC" : "ASC";
  } else {
    $sql .= $_GET['reverse'] == "true" ? "DESC" : "ASC";//this was backwards MWarner 5/31/2012
  }
  //echo "<HR>".$sql."<HR>";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    while ($row = $dbi->fetch($result,"array")) {
	if($_GET["sort"]=="assigned_to"){
		$SQL="select username from users where userid=".$row["opened_by"];
		$result2 = $dbi->query($SQL);
		$row2 = $dbi->fetch($result2,"array");
		$row["username"]=$row2["username"];
	}
      $issues[$row['issueid']] = $row;
    }
    $dbi->free($result);
  }

  return $issues;
}
/* }}} */ 

/* {{{ Function: group_over_limit */
/**
 * Determine if a group has reached their limit
 *
 * @param integer $gid ID of group
 * @param string $type Only match given limit type
 * @return boolean
 */
function group_over_limit($gid,$type = null)
{
  global $dbi;

  if (empty($gid)) {
    return FALSE;
  }

  $sql  = "SELECT group_type,bought,start_date,end_date ";
  $sql .= "FROM groups ";
  $sql .= "WHERE gid='$gid'";
  $data = $dbi->fetch_row($sql,"array");
  if (!is_null($data)) {
    extract($data);

    if (!is_null($type) and $group_type != $type) {
      return FALSE;
    }

    if ($group_type == "hours") {
      $sql  = "SELECT issueid ";
      $sql .= "FROM issue_groups ";
      $sql .= "WHERE gid='$gid'";
      $issues = $dbi->fetch_all($sql);
      if (!is_null($issues)) {
        $issues = implode(",",$issues);

        $sql  = "SELECT SUM(duration) ";
        $sql .= "FROM events ";
        $sql .= "WHERE issueid IN ($issues) ";
        if (!empty($start_date) and !empty($end_date)) {
          $sql .= "AND performed_on >= $start_date ";
        }
        $hours = $dbi->fetch_one($sql);
        if (!is_null($hours)) {
          if ($hours >= $bought) {
            return TRUE;
          }
        }
      }
    } else if ($group_type == "issues") {
      $sql  = "SELECT COUNT(issueid) ";
      $sql .= "FROM issues ";
      $sql .= "WHERE gid='$gid'";
      if (!empty($start_date) and !empty($end_date)) {
        $sql .= "AND opened >= $start_date ";
      }
      $issues = $dbi->fetch_one($sql);
      if (!is_null($issues)) {
        if ($issues >= $bought) {
          return TRUE;
        }
      }
    }
  }

  return FALSE;
}
/* }}} */

/**
 * Retrieve array of the public email address for group(s)
 *
 * @param integer $groupId ID of group
 * @return array
 */
function public_address($groupId = null)
{
  global $dbi;
  
  // initialize the address array
  $address = array();
  
  $sql  = "SELECT gid,LOWER(email) AS email ";
  $sql .= "FROM groups ";
  $sql .= "WHERE email != '' ";
  $sql .= !is_null($groupId) ? "AND gid='{$groupId}' " : "";
  $groups = $dbi->fetch_all($sql,"array");
  if (is_array($groups)) {
    if (!is_null($groupId)
    and $groups[0]['gid'] == $groupId) {
      return $groups[0]['email'];
    } else {
      foreach ($groups as $group) {
        $address[$group['gid']] = $group['email'];
      }
    }
  }

  return $address;
}
?>
