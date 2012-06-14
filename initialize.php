<?php
/* $Id: initialize.php 4 2004-08-10 00:36:34Z eroberts $ */
// Make sure register globals is turned off.  As of v4.0, Issue-Tracker
// will no longer function correctly with it turned on.  If you have
// other applications that require it to work, then you can create a
// .htaccess file in the root Issue-Tracker directory that contains
// the following line
//
// php_flag register_globals off
//
// You must have AllowOverride set to Options or All in your Apache
// configuration for this to work though
if (ini_get("register_globals") == 1) {
  print "Please turn off register_globals in your php.ini \n";
  print "or make sure your webserver is setup to obey .htaccess files.\n";
  exit;
}
//set timeout to 8hrs minutes MWarner 2/8/2010
ini_set("session.gc_maxlifetime",8*60*60);
# Squash notices cause they annoy me
//error_reporting(E_ALL ^ E_NOTICE);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
// Make sure _PATH_ is defined, otherwise when we pull in the config
// file it will have no idea where to find our directories
if (!defined("_PATH_")) {
  define("_PATH_",dirname(__FILE__));
}

// Without these two files we're screwed
require_once(_PATH_."/conf/config.php");
require_once(_CLASSES_."dbi.class.php");
include_once(SMARTY_DIR."Smarty.class.php");


// If the logs directory is not writable, quit now
if (!defined("_PARSER_")) {
  if (!is_writable(_LOGS_)) {
    print "Logs directory is not writable by the web server.  Please correct this.";
    exit;
  }
}

// If we're accessing issue-tracker through the browser
// and we're not using the db session handler then
// make sure the sessions director is writable
if (defined("BROWSER")) {
  if (!$session_handler) {
    if (!is_writable(_SESSIONS_)) {
      print "Sessions directory is not writable by the web server.  Please correct this.";
      exit;
    }
    session_save_path(_SESSIONS_);
  } else {
    include_once(_FUNCTIONS_."session.func.php");
  }
}

// Initialize the database abstraction layer
$dbi = new DBI;
$dbi->init($db);
$dbi->set("admin_email",_ADMINEMAIL_);
$dbi->set("email_from",_EMAIL_);
$dbi->set("log_queries",FALSE);
// Log any queries that take more than 1 second to complete
// this should give us a good idea where any bottlenecks are
$dbi->set("long_query","1");

// Only start smarty and sessions if viewing through browser
if (defined("BROWSER")) {
  session_name(_SESSIONNAME_);
  session_start();

  if (!@is_array($_SESSION['errors']) or !@is_array($_SESSION['errors'])) {
    $_SESSION['errors'] = array();
  }

  $_SESSION['theme'] = (!empty($_SESSION['theme']) and file_exists(_THEMES_.$_SESSION['theme'])) ? $_SESSION['theme'] : $default_theme;

  $smarty = new Smarty;
  $smarty->template_dir = _TEMPLATES_.$_SESSION['theme']."/tpl/";
  $smarty->compile_dir  = _TPLCOMPILE_;
  $smarty->config_dir   = _TPLCONFIG_;
  $smarty->cache_dir    = _TPLCACHE_;
  $smarty->debugging    = FALSE;
  $smarty->caching      = FALSE;  // DO NOT CHANGE THIS!
}

// Load all functions file located in _FUNCTIONS_
if ($dir = @opendir(_FUNCTIONS_)) {
  while (($item = readdir($dir)) !== FALSE) {
    if ($item == "." or $item == ".." or $item == "CVS") {
      continue;
    }

    //if (is_file(_FUNCTIONS_.$item)and eregi("\.func\.php$",$item)) {
	if (is_file(_FUNCTIONS_.$item) && preg_match("/\.func\.php$/i",$item)) {
      include_once(_FUNCTIONS_.$item);
    }
  }
}

// Include any module function files
$includes = module_includes("funcs");
foreach ($includes as $inc) {
  include($inc);
}

// Make sure to run any module specific initialization
// or any module setup scripts
$includes = module_includes("init");
foreach ($includes as $inc) {
  include($inc);
}
module_setup();

// Load cache files
if ($dir = opendir(_CACHE_)) {
  while (($file = readdir($dir)) !== false) {
    if ($item == "." or $item == ".." or $item == "CVS" or is_dir($file)) {
      continue;
    }

    if (is_file(_CACHE_.$file)) {
      include_once(_CACHE_.$file);
    }
  }

  closedir($dir);
}

if (defined("BROWSER")) {
  if (!is_writable(_THEMES_)) {
    logger("Themes directory not writable, users will not be able to store custom settings.","system_errors");
  }

  if (file_exists(_THEMES_.$_SESSION['theme']."/functions.php")) {
    include_once(_THEMES_.$_SESSION['theme']."/functions.php");
  }

  if (file_exists(_THEMES_.$_SESSION['theme']."/images.php")) {
    include_once(_THEMES_.$_SESSION['theme']."/images.php");
  }

  generate_theme_css();
  generate_user_css();

  $title  = _TITLE_;
  $title .= !empty($_GET['module']) ? " :: ".ucwords($_GET['module']) : "";
  $title .= !empty($_GET['action']) ? " :: ".ucwords($_GET['action']) : "";
  $title .= !empty($_GET['gid']) ? " :: Group ".group_name($_GET['gid']) : "";
  $title .= !empty($_GET['issueid']) ? " :: ".$_GET['issueid'] : "";
  $smarty->assign('title',$title);
  $smarty->assign('crumbs',build_crumbs());
  $smarty->assign('cssfile',cssfile());
}

// Dont display any errors, just log them in
// the logs directory
ini_set("display_errors",1);
ini_set("log_errors",1);
ini_set("error_log",_LOGS_."phperrors");

// If using the issue-tracker error handler
// instead of default, then set it now
if ($error_handler) {
  set_error_handler("it_error_handler");
}

?>
