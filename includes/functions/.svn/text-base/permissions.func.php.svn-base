<?php
/* $Id: permissions.func.php 2 2004-08-05 21:42:03Z eroberts $ */

/* {{{ Function: is_admin */
/**
 * Determine if a user is an admin
 *
 * @param integer $userid
 * @returns boolean
 */
function is_admin($userid = null)
{
  global $dbi;

  if (!is_array($_ENV['admin'])) {
    $_ENV['admin'] = array();
  }

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }
  
  if (array_key_exists($userid,$_ENV['admin'])) {
    return $_ENV['admin'][$userid];
  } else {
    // form query to get admin
    $sql  = "SELECT admin ";
    $sql .= "FROM users ";
    $sql .= "WHERE userid='$userid'";
    $admin = $dbi->fetch_one($sql);
    if ($admin == "t") {
      $_ENV['admin'][$userid] = TRUE;
      return TRUE;
    }

    $_ENV['admin'][$userid] = FALSE;
    return FALSE;
  }
  
  return FALSE;
}
/* }}} */

/* {{{ Function: is_employee */
/**
 * Determines whether or not the user is an employee
 *
 * @param integer $userid ID of user to check
 * @returns boolean
 */
function is_employee($userid = null)
{
  global $dbi;

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }

  if (is_admin($userid)) {
    return TRUE;
  }

  $sql  = "SELECT userid ";
  $sql .= "FROM group_users ";
  $sql .= "WHERE userid='$userid' ";
  $sql .= "AND gid='"._EMPLOYEES_."'";
  $emp = $dbi->fetch_one($sql);
  if (!is_null($emp)) {
    return TRUE;
  } 

  return FALSE;
}
/* }}} */

/* {{{ Function: is_manager */
/**
 * Determine if a user is a manager
 *
 * @param integer $userid ID of user to check
 * @returns boolean
 */
function is_manager($userid = null)
{
  global $dbi;

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }

  if (is_admin($userid)) {
    return TRUE;
  }

  if (is_employee($userid)
  and permission_check("update_group",_EMPLOYEES_,$userid)) {
    return TRUE;
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: permission_set */
/**
 * Retrieve the permission set for a given user in a given group
 *
 * @param integer $gid ID of group to look in
 * @param integer $userid ID of user to get permission set for
 * @returns array
 */
function permission_set($gid,$userid = null)
{
  global $dbi;

  $pset = array();

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }

  $sql  = "SELECT p.permissions,g.perm_set ";
  $sql .= "FROM group_users g, permission_sets p ";
  $sql .= "WHERE g.userid='$userid' ";
  $sql .= "AND g.gid='$gid' ";
  $sql .= "AND g.perm_set = p.permsetid";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($pset,$id) = $dbi->fetch($result);
    $pset = explode(",",stripslashes($pset));

    if (!is_array($pset)) {
      logger("Permission set $id returns none arrary.","permissions");
      return;
    }
  }

  return $pset;
}
/* }}} */

/* {{{ Function: permission_set_id */
/**
 * Retrieve the permission set id for a given user in a given group
 *
 * @param integer $gid ID of group to look in
 * @param integer $userid ID of user to get permission set for
 * @return integer
 */
function permission_set_id($gid,$userid = null)
{
  global $dbi;

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }

  $sql  = "SELECT perm_set ";
  $sql .= "FROM group_users ";
  $sql .= "WHERE userid='$userid' ";
  $sql .= "AND gid='$gid'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($id) = $dbi->fetch($result);

    return $id;
  }

  return;
}
/* }}} */

/* {{{ Function: permission */
/**
 * Retrieve the text of a permission
 *
 * @param integer $permid ID of permission
 */
function permission($permid)
{
  global $dbi;

  $sql  = "SELECT permission ";
  $sql .= "FROM permissions ";
  $sql .= "WHERE permid='$permid'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($permission) = $dbi->fetch($result);
    return $permission;
  }

  return "UNKNOWN";
}
/* }}} */

/* {{{ Function: permission_set_name */
/**
 * Retrieve the permission set name for a permission set id
 *
 * @param integer $psetid ID of the permission set
 * @return string
 */
function permission_set_name($psetid)
{
  global $dbi;

  $sql  = "SELECT name ";
  $sql .= "FROM permission_sets ";
  $sql .= "WHERE permsetid='$psetid'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($name) = $dbi->fetch($result);

    return $name;
  }

  return;
}
/* }}} */

/* {{{ Function: permission_check */
/**
 * Determine if a user has a certain permission
 *
 * @param string $priv Privilege to be checked
 * @param integer $userid ID of user to check
 * @param integer $gid ID of group to check
 * @returns boolean
 */
function permission_check($perm,$gid = null,$userid = null)
{
  global $dbi;

  if (empty($userid)) {
    $userid = $_SESSION['userid'];
  }

  if(is_admin($userid)){
    return TRUE;
  }

  $sql  = "SELECT permid,group_perm,user_perm ";
  $sql .= "FROM permissions ";
  $sql .= "WHERE permission='$perm'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($permid,$group,$user) = $dbi->fetch($result);
    $dbi->free($result);
  } else {
    logger("Lookup against unknown permission ($perm).","permissions");
    return FALSE;
  }

  if ($user == "t") {
    $sql  = "SELECT userid ";
    $sql .= "FROM user_permissions ";
    $sql .= "WHERE userid='$userid' ";
    $sql .= "AND permid='$permid'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      $dbi->free($result);
      return TRUE;
    }
  }

  if ($group == "t") {
    if ($userid == $_SESSION['userid']) {
      $user_groups = $_SESSION['groups'];
    } else {
      $user_groups = user_groups($userid);
    }

    foreach ($user_groups as $key => $val) {
      $sql  = "SELECT permid ";
      $sql .= "FROM group_permissions ";
      $sql .= "WHERE permid='$permid' ";
      $sql .= "AND gid='$val'";
      $result = $dbi->query($sql);
      if ($dbi->num_rows($result) > 0) {
        $dbi->free($result);
        return TRUE;
      }
    }

    return FALSE;
  }

  if (!is_null($gid)) {
    $pset = permission_set($gid,$userid);
    
    if (in_array($perm,$pset)) {
      return TRUE;
    }
  
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s,groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_user='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      if (!empty($parent)) {
        $pset = permission_set($parent,$userid);
     
        if (in_array($perm,$pset)) {
          return TRUE;
        }
      }
    }

    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_issue='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $pset = permission_set($child,$userid);

        if (in_array($perm,$pset)) {
          $dbi->free($result);
          return TRUE;
        }
      }

      $dbi->free($result);
    }
  } else {
    foreach ($_SESSION['groups'] as $key => $val) {
      $pset = permission_set($val,$userid);

      if (in_array($perm,$pset)) {
        return TRUE;
      }

      $sql  = "SELECT s.parent_gid ";
      $sql .= "FROM sub_groups s,groups g ";
      $sql .= "WHERE s.parent_gid=g.gid ";
      $sql .= "AND s.child_gid='$val' ";
      $sql .= "AND g.prop_user='t'";
      $result = $dbi->query($sql);
      if ($dbi->num_rows($result) > 0) {
        list($parent) = $dbi->fetch($result);
        $dbi->free($result);
        if (!empty($parent)) {
          $pset = permission_set($parent,$userid);
       
          if (in_array($perm,$pset)) {
            return TRUE;
          }
        }
      }

      $sql  = "SELECT child_gid ";
      $sql .= "FROM sub_groups ";
      $sql .= "WHERE parent_gid='$val' ";
      $sql .= "AND prop_issue='t'";
      $result = $dbi->query($sql);
      if ($dbi->num_rows($result) > 0) {
        while (list($child) = $dbi->fetch($result)) {
          $pset = permission_set($child,$userid);

          if (in_array($perm,$pset)) {
            $dbi->free($result);
            return TRUE;
          }
        }

        $dbi->free($result);
      }
    }
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: authenticate */
/**
 * Attempt to authenticate a user
 *
 * @param string $username Username of user
 * @param string $password Password of user
 * @return boolean|integer
 */
function authenticate($username,$password)
{
  global $dbi;

  // The login actuall allows users to login by
  // their username or email address, both of
  // which should be unique to each user
  // so now we have to determine which one we're
  // looking up
  $field = preg_match("@",$username) ? "email" : "username";

  $sql  = "SELECT username,userid,theme ";
  $sql .= "FROM users ";
  $sql .= "WHERE LOWER($field)=LOWER('".addslashes($username)."') ";
  $sql .= "AND password='".md5($password)."' ";
  $sql .= "AND active='t'";
  $result = $dbi->query($sql);
  if($dbi->num_rows($result) > 0){
    list($username,$uid,$theme) = $dbi->fetch($result);

    // If we're calling the authentication function from
    // the browser then make sure to define the needed
    // session variables, and then redirect to the user
    if (defined("BROWSER")) {
      $_SESSION['userid'] = $uid;
      $_SESSION['javascript'] = $_POST['javascript'] == "enabled" ? "t" : "f";
      $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['theme'] = !empty($theme) ? $theme : $_SESSION['theme'];
      $_SESSION['prefs'] = user_preferences($uid);

      if (empty($_SESSION['prefs']['show_fields'])) {
        $_SESSION['prefs']['show_fields'] = array();
      } else {
        $_SESSION['prefs']['show_fields'] = explode(",",$_SESSION['prefs']['show_fields']);
      }
      if (empty($_SESSION['prefs']['sort_by'])) {
        $_SESSION['prefs']['sort_by'] = "issueid";
      }
      if (empty($_SESSION['prefs']['word_wrap'])) {
        $_SESSION['prefs']['word_wrap'] = 80;
      }

      logger("$username logged in.","logins");

      if (!empty($_POST['request'])) {
        redirect("/?".$_POST['request']);
      } else {
        redirect();	
      }
    } else {
      // If we're not calling authentication
      // from the browser then just return
      // the retrieved userid
      return $uid;
    }
  } else {
    // If we didnt pull a userid then just return error message
    // for the browser and FALSE if not
    if (defined("BROWSER")) {
      push_error("Invalid login and/or password.");
    } else {
      return FALSE;
    }
  }
}
/* }}} */

/* {{{ Function: group_permission */
/**
 * Determine if a permission is a group permission
 *
 * @param integer $permid ID of permission
 * @return boolean
 */
function group_permission($permid)
{
  global $dbi;

  $sql  = "SELECT group_perm ";
  $sql .= "FROM permissions ";
  $sql .= "WHERE permid='$permid'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($group) = $dbi->fetch($result);
    $dbi->free($result);
    
    if ($group == "t") {
      return TRUE;
    }
  }

  return FALSE;
}
/* }}} */
?>
