<?php
/* $Id: funcs.php 4 2004-08-10 00:36:34Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Users
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

/* {{{ Function: gen_passwd */
/**
 * Generate password string
 *
 * @return string
 */
function gen_passwd()
{
	$pass = substr(md5(rand(1,1000000)),0,rand(6,12));
	return $pass;
}
/* }}} */

/* {{{ Funtion: reset_passwd */
/**
 * Reset a user's password and email the new one to them
 *
 * @param integer $userid ID of user to reset password for
 */
function reset_passwd($userid)
{
	global $dbi;

	if (!user_exists($userid)) {
		return;
	}

	$pass = gen_passwd();
	$update['password'] = md5($pass);
	$dbi->update("users",$update,"WHERE userid='$userid'");
	unset($update);

	$subject = _COMPANY_." Support Portal Alert";
	$message  = "Your password to the "._COMPANY_." Support Portal has been reset.\n\n";
	$message .= "Your new password is: $pass\n\n";
	$message .= "You may login to the interface at "._URL_." ";
	$message .= "and change this password at any time.  If you do not know the username ";
	$message .= "that you were given at the time of your account creation, you can use ";
	$message .= "your email address as a login name with the password that has been ";
	$message .= "sent to you.  If you have any questions please contact ";
	$message .= _ADMINEMAIL_.".\n\n\n";
	$message .= "            - "._COMPANY_;

  // Make sure we have mail class and initialize it
  include_once(_CLASSES_."mail.class.php");
  if (!is_object($mailer)) {
    $mailer = new MAILER();
    $mailer->set("email_from",_EMAIL_);
  }
  $mailer->subject($subject);
  $mailer->to(email($userid));
  $mailer->message($message);
  $mailer->send();
}
/* }}} */
	
/* {{{ Function: user_exists */
/**
 * Determine if a user actually exists
 *
 * @param integer $userid ID of user to look for
 * @return boolean
 */
function user_exists($userid)
{
	global $dbi;

	$sql  = "SELECT userid ";
	$sql .= "FROM users ";
	$sql .= "WHERE userid='$userid'";
	$result = $dbi->query($sql);
	if ($dbi->num_rows($result) > 0) {
		return TRUE;
	}

	return FALSE;
}
/* }}} */

/* {{{ Function: create_user */
/**
 * Creates a new user account, returns the new user's userid if successful
 * and false if not
 *
 * @param array $user_data Array containing user data
 * @return integer|null
 */
function create_user($user_data)
{
	global $dbi;

  extract($user_data);

  if (empty($username) or empty($email)) {
    return null;
  }

  $failed = FALSE;

	$sql  = "SELECT userid ";
	$sql .= "FROM users ";
	$sql .= "WHERE LOWER(username) = LOWER('$username')";
  list($uid) = $dbi->fetch_one($sql);
  if (!is_null($uid)) {
    push_error("This username is already in use by another user.");
    return null;
  }

  $sql  = "SELECT userid ";
  $sql .= "FROM users ";
  $sql .= "WHERE LOWER(email) = LOWER('$email')";
  list($uid) = $dbi->fetch_one($sql);
  if (!is_null($uid)) {
    push_error("This email address is already in use by another user.");
    return null;
	}

  $password = gen_passwd();

	$insert['username'] = $username;
	$insert['email'] = $email;
  if (!empty($first)) {
    $insert['first_name'] = $first;
  }
  if (!empty($last)) {
    $insert['last_name'] = $last;
  }
  if (!empty($admin)) {
  	$insert['admin'] = $admin;
  }
	$insert['password']	= md5($password);
	$insert['active'] = "t";
  $userid = $dbi->insert("users",$insert,"users_userid_seq");
  if (!is_null($userid)) {
		$subject = _COMPANY_." Support Portal Account Created";
		$message  = "A user was created with your email address for the "._COMPANY_." Issue Tracking System.\n";
		$message .= "You may access your account by going to:\n";
		$message .= _URL_."\n";
		$message .= "Login with the following information.\n\n";
		$message .= "Username: ".$user_data['username']."\n";
		$message .= "Password: $password\n\n";
		$message .= "Once logged in you may change your password by clicking ";
		$message .= "on the preferences link on the left hand side.  ";
		$message .= "If you have any questions please contact "._ADMINEMAIL_.".\n\n\n";
		$message .= "            - "._COMPANY_;

    // Make sure we have mail class and initialize it
    include_once(_CLASSES_."mail.class.php");
    if (!is_object($mailer)) {
      $mailer = new MAILER();
      $mailer->set("email_from",_EMAIL_);
    }
    $mailer->subject($subject);
    $mailer->to($email);
    $mailer->message($message);
    $mailer->send();
		return $userid;
	}

	return null;
}
/* }}} */
	
/* {{{ Function: user_active */
/**
 * Determine if a user is active or not
 *
 * @param integer $userid
 * @return boolean
 */
function user_active($userid)
{
	// pull in globals
	global $dbi;

	$sql  = "SELECT userid ";
	$sql .= "FROM users ";
	$sql .= "WHERE active='t' ";
	$sql .= "AND userid='$userid'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
    return TRUE;
  }
}
/* }}} */

/* {{{ Function: username */
/**
 * Returns username, if $link is TRUE then it makes it a link
 * to retrive the user's information
 *
 * @param integer $userid ID of user to lookup, will default to $_SESSION['userid']
 * @param boolean $link Use link or not
 * @return string $username
 */
function username($userid,$link = FALSE)
{
	global $dbi,$users_username_cache,$cache_data;

  if (empty($userid)) {
    return "&nbsp;";
  }

  if (is_array($users_username_cache)
  and in_array("users",$cache_data)
  and @array_key_exists($userid,$users_username_cache)) {
    $username = $users_username_cache[$userid];
  } else {
    // Since we didn't find the name in cache
    // make sure to generate new cache file
    gen_cache("users","userid","username");

  	// form query to get username
  	$sql  = "SELECT username ";
	  $sql .= "FROM users ";
  	$sql .= "WHERE userid='$userid'";
	  $result = $dbi->query($sql);
  	if ($dbi->num_rows($result) > 0) {
	  	list($username) = $dbi->fetch($result);
  	}
  }
	
	if ($link and $_SESSION['javascript'] == "t") {
		$url        = "?module=users&action=whois&userid=$userid";
    $name       = "User Info";
    $features   = "location=no,menubar=no,status=no,toolbar=no";
    $features  .= ",width=400,height=185,screenx=200,screeny=200";
    $javascript = " onClick=\"window.open('$url','$name','$features')\"";
	  $username = "<a$javascript>$username</a>";
	}

	return $username;
}
/* }}} */

/* {{{ Function: email */
/**
 * Takes userid and returns associated email
 *
 * @param integer $userid ID of user to retrieve email for
 * @return string
 */
function email($userid)
{
	global $dbi;

	// form query to get email
	$sql  = "SELECT email ";
	$sql .= "FROM users ";
	$sql .= "WHERE userid='".$userid."'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		list($email) = $dbi->fetch($result);
    $email = stripslashes($email);
	}

	return $email;
}
/* }}} */

/* {{{ Function: sms */
/**
 * Takes userid and returns associated sms
 *
 * @param integer $userid ID of user to get sms for
 * @return string
 */
function sms($userid)
{
	global $dbi;

	$sql  = "SELECT sms ";
	$sql .= "FROM users ";
	$sql .= "WHERE userid='$userid'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		list($sms) = $dbi->fetch($result);
    $sms = stripslashes($sms);
	} else {
		$sms = "UNKNOWN";
	}

	return $sms;
}
/* }}} */

/* {{{ Function: user_groups */
/**
 * Retrive array of groups the user belongs to
 *
 * @param integer $uid ID of user
 * @param boolean $query Format return for sql query
 * @return array
 */
function user_groups($uid,$query = FALSE)
{
	global $dbi;

	$first = TRUE;

	if(!$query){
		$groups = array();
	}

	$sql  = "select u.gid ";
  $sql .= "from group_users u, groups g ";
  $sql .= "where u.userid='$uid' ";
  $sql .= "and g.gid = u.gid ";
  $sql .= "order by g.name";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
		while(list($gid) = $dbi->fetch($result)){
			if($query == TRUE){
				if(!$first){
					$groups .= ",";
				}
				$groups .= $gid;
				$first = FALSE;
			} else {
				$groups[] = $gid;
			}
		}
	}

	return $groups;
}
/* }}} */

/* {{{ Function: user_menu */
/**
 * Takes userid and returns associated menu
 *
 * @param integer $userid ID of user
 * @return array $menu
 */
function user_menu($userid)
{
	global $dbi;

	$sql  = "SELECT text,url ";
	$sql .= "FROM menus ";
	$sql .= "WHERE userid='$userid'";
	$result = $dbi->query($sql);
	if($dbi->num_rows($result) > 0){
    while (list($text,$url) = $dbi->fetch($result)) {
      $menu[$text] = $url;
    }

    $dbi->free($result);
	}

	return $menu;
}
/* }}} */

/* {{{ Function: whois */
/**
 * Show a small page showing a users information
 *
 * @param integer $userid ID of user
 */
function whois($userid)
{
  global $dbi;

  $sql  = "SELECT first_name,last_name,username,email ";
  $sql .= "FROM users ";
  $sql .= "WHERE userid='$userid'";
  $user = $dbi->fetch_row($sql,"array");
  $smarty->assign('user',$user);
  $smarty->display("users/whois.tpl");
  exit;
}
/* }}} */

/* {{{ Function: user_preferences */
/**
 * Retrieve array of user preferences
 *
 * @param integer $userid ID of user
 * @param string $preference Preference to retrieve
 * @return array
 */
function user_preferences($userid = null,$preference = null)
{
  global $dbi;

  $curr_prefs = array();

  if (is_null($userid)) {
    $userid = $_SESSION['userid'];
  }

  if (!empty($preference)) {
    $sql  = "SELECT value ";
    $sql .= "FROM user_prefs ";
    $sql .= "WHERE userid='$userid' ";
    $sql .= "AND LOWER(preference)=LOWER('$preference') ";
    $value = $dbi->fetch_one($sql);
    return $value;
  }

  $sql  = "SELECT preference,value ";
  $sql .= "FROM user_prefs ";
  $sql .= "WHERE userid='$userid'";
  $prefs = $dbi->fetch_all($sql,"array");
  if (is_array($prefs)) {
    foreach ($prefs as $pref) {
      $curr_prefs[$pref['preference']] = $pref['value'];
    } 
  }

  if (empty($curr_prefs['sort_by'])) {
    $curr_prefs['sort_by'] = "issueid";
  }

  if (!empty($curr_prefs['show_fields'])) {
    $curr_prefs['show_fields'] = explode(",",$curr_prefs['show_fields']);
  } else {
    $curr_prefs['show_fields'] = array();
  }

  if (empty($curr_prefs['date_format'])) {
    $curr_prefs['date_format'] = "m/d/Y";
  }

  if (empty($curr_prefs['local_tz'])) {
    $curr_prefs['local_tz'] = "f";
  }

  return $curr_prefs;
}
/* }}} */
?>
