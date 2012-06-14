<?php
/* $Id: session.func.php 2 2004-08-05 21:42:03Z eroberts $ */

/* {{{ Function: it_session_open */
/**
 * Start a session - Do not access this function directly
 */
function it_session_open($save_path,$session_name)
{
  global $dbi;

  it_session_gc(ini_get("session.gc_maxlifetime"));
  return TRUE;
}
/* }}} */

/* {{{ Function: it_session_close */
/**
 * Close a session - Do not access this function directly
 */
function it_session_close()
{
  return TRUE;
}
/* }}} */

/* {{{ Function: it_session_read */
/**
 * Read session data - Do not access this function directly
 */
function it_session_read($id)
{
  global $dbi;

  $id = addslashes($id);
  $expire = time() + ini_get("session.gc_maxlifetime");

  $sql  = "SELECT session_data ";
  $sql .= "FROM sessions ";
  $sql .= "WHERE session_id='$id'";
  $result = $dbi->query($sql);
  if ($dbi->num_rows($result) > 0) {
    list($data) = $dbi->fetch($result);
    
    return $data;
  } else {
    $sql  = "INSERT INTO sessions ";
    $sql .= "VALUES('$id','','$expire')";
    $dbi->query($sql);
  }

  return "";
}
/* }}} */

/* {{{ Function: it_session_write */
/**
 * Write session data - Do not access this function directly
 */
function it_session_write($id,$data)
{
  global $dbi;

  $id = addslashes($id);
  $data = addslashes($data);
  $expire = time() + ini_get("session.gc_maxlifetime");

  $sql  = "UPDATE sessions ";
  $sql .= "SET session_data='$data',session_expires='$expire' ";
  $sql .= "WHERE session_id='$id'";
  $dbi->query($sql);
  return TRUE;
}
/* }}} */

/* {{{ Function: it_session_destroy */
/**
 * Destroy session - Do not access this function directly
 */
function it_session_destroy($id)
{
  global $dbi;

  $sql  = "DELETE FROM sessions ";
  $sql .= "WHERE session_id='$id'";
  $dbi->query($sql);
  return TRUE;
}
/* }}} */

/* {{{ Function: it_session_gc */
/**
 * Session garbage cleanup - Do not access this function directly
 */
function it_session_gc($maxlifetime)
{
  global $dbi;

  $sql  = "DELETE FROM sessions ";
  $sql .= "WHERE session_expires < ".time();
  $dbi->query($sql);
  return TRUE;
}
/* }}} */

/* {{{ Function: redirect */
/**
 * This is just a simple redirect function
 * but it makes sure that the session is written
 * and closed before the redirect happens
 *
 * @param string $url URL to redirect to
 */
function redirect($url = null)
{
  if (!preg_match("/^http|https/i",$url)) {
    $url = _URL_.$url;
  }

  session_write_close();
  header("Location: $url");
  exit;
}
/* }}} */

if ($session_handler === TRUE) {
  session_set_save_handler(
    "it_session_open",
    "it_session_close",
    "it_session_read",
    "it_session_write",
    "it_session_destroy",
    "it_session_gc"
  );
}
?>
