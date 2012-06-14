<?php
/* $Id: funcs.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Announcements
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

/* {{{ Function: announcement_title */
/**
 * Gets title for announement
 *
 * @param integer $aid Id of announcement to pull title for
 * @return string $title
 */
function announcement_title($aid)
{
  global $dbi;

	$sql  = "SELECT title ";
	$sql .= "FROM announcements ";
	$sql .= "WHERE aid='$aid'";
	$result = $dbi->query($sql);
	if ($dbi->num_rows($result) > 0) {
		list($title) = $dbi->fetch($result);
    $dbi->free($result);
    return $title;
  }
}
/* }}} */

/* {{{ Function: announcements */
/**
 * Pulls an array of announcements for the given group,
 * if gid is omitted then pull for global announcements
 *
 * @param integer $gid Id of group to pull announcements for
 * @return array
 */
function announcements($gid = null)
{
  global $dbi;

  // make sure to initialize $announcements as an array
  $announcements = array();

  if (empty($gid)) {
    $sql  = "SELECT aid,title ";
    $sql .= "FROM announcements ";
    $sql .= "WHERE is_global='t'";
    $sql .= "ORDER BY aid DESC";
  } else {
    $sql  = "SELECT a.aid,a.title ";
    $sql .= "FROM announcements a,announce_permissions p ";
    $sql .= "WHERE a.aid=p.aid ";
    $sql .= "AND p.gid='$gid' ";
    $sql .= "ORDER BY a.aid DESC";
  }

  $result = $dbi->query($sql);
	if ($dbi->num_rows($result) > 0) {
    while (list($aid,$title) = $dbi->fetch($result)) {
      $announcements[$aid] = $title;
    }

    $dbi->free($result);
  }

  if (!empty($gid)) {
    $sql  = "SELECT s.parent_gid ";
    $sql .= "FROM sub_groups s, groups g ";
    $sql .= "WHERE s.parent_gid=g.gid ";
    $sql .= "AND s.child_gid='$gid' ";
    $sql .= "AND g.prop_announce='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      list($parent) = $dbi->fetch($result);
      $dbi->free($result);
      $a = announcements($parent);

      if (count($a) > 0) {
        foreach ($a as $key => $val) {
          if (!array_key_exists($key,$announcements)) {
            $announcements[$key] = $val;
          }
        }
      }
    }

    $sql  = "SELECT child_gid ";
    $sql .= "FROM sub_groups ";
    $sql .= "WHERE parent_gid='$gid' ";
    $sql .= "AND prop_announce='t'";
    $result = $dbi->query($sql);
    if ($dbi->num_rows($result) > 0) {
      while (list($child) = $dbi->fetch($result)) {
        $a = announcements($child);

        if (count($a) > 0) {
          foreach ($a as $key => $val) {
            if (!array_key_exists($key,$announcements)) {
              $announcements[$key] = $val;
            }
          }
        }
      }

      $dbi->free($result);
    }
  }

  return $announcements;
}
/* }}} */

/* {{{ Function: can_view_announcement */
/**
 * Determine if a user can see an announcement
 *
 * @param integer $aid Id of announcement
 * @return boolean
 */
function can_view_announcement($aid)
{
  global $dbi;

	$sql  = "SELECT aid ";
	$sql .= "FROM announcements ";
	$sql .= "WHERE aid='$aid' ";
	$sql .= "AND is_global='t'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
    $dbi->free($result);
		return TRUE;
	}

  $sql  = "SELECT gid ";
  $sql .= "FROM announce_permissions ";
  $sql .= "WHERE aid='$aid'";
  $result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
    while(list($gid) = $dbi->fetch($result)){
      if(in_array($gid,$_SESSION['groups'])){
        return TRUE;
      }
    }
    $dbi->free($result);
  }

  return FALSE;
}
/* }}} */
?>
