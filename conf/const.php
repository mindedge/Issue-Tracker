<?php
/* $Id: const.php 11 2004-12-13 17:22:28Z eroberts $ */
/******************************************************************
 * NOTE: Do not edit this file unless you know what you are doing *
 ******************************************************************/
/**
 * Base URL used to access your instance of Issue-Tracker.  You should
 * no longer have to set this manually unless for some reason you run
 * into trouble where it is not set correctly.  If you do need to set
 * it then make sure to include http:// or https:// and the trailing slash.
 */
if (!defined("_URL_")) {
  if (!empty($_SERVER['SCRIPT_URI'])) {
    if (preg_match("IIS",$_SERVER['SERVER_SOFTWARE'])) {
      define("_URL_",$_SERVER['SCRIPT_URI']."index.php");
    } else {
      define("_URL_",$_SERVER['SCRIPT_URI']);
    }
  } else {
    if (preg_match("IIS",$_SERVER['SERVER_SOFTWARE'])) {
      define("_URL_", (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'
        .$_SERVER['HTTP_HOST']
        .substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/') + 1)."index.php");
    } else {
      define("_URL_", (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'
        .$_SERVER['HTTP_HOST']
        .substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/') + 1));
    }
  }
}
if (!defined("_URL_")) {
  echo("Could not automatically define the _URL_ constant, please define it manually in conf/config.php or conf/const.php.");
  exit;
}

/**
 * File URL used for downloading files
 */
define("_FILE_URL_",str_replace("index.php","",_URL_));

/**
 * This is the user that file directories and uploaded files
 * will be owned by.
 */
define("_WEBUSR_","apache");

/**
 * This is the group that file directories and uploaded files
 * will be owned by.
 */
define("_WEBGRP_","apache");

/**
 * Employees group id, members of this group are granted 
 * additional privileges over normal users
 */
define("_EMPLOYEES_",1);

/**
 * Group where rejects from the mail parser will be sent
 * This is done mainly to catch any cases where the mail
 * parser may have screwed up and rejected a valid mail
 */
define("_PARSERGROUP_",3);

/**
 * Userid for the user that events done through anonymous email
 * will be logged as, the username for this user should normally
 * show up as "client"
 */
define("_PARSER_",3);

/**
 * Location of the includes directory.  Unless you have modified the
 * original directory structure of Issue-Tracker you should not have
 * to change this.  Make sure to include the trailing slash.
 */
define("_INCLUDES_",_PATH_."/includes/");

/**
 * Location of the classes directory. Unless you have modified the
 * original directory structure of Issue-Tracker you should not have
 * to change this.  Make sure to include the trailing slash.
 */
define("_CLASSES_",_INCLUDES_."classes/");

/**
 * Location of the modules directory. Unless you have modified the
 * original directory structure of Issue-Tracker you should not have
 * to change this.  Make sure to include the trailing slash.
 */
define("_MODULES_",_PATH_."/modules/");

/**
 * Location of the functions directory. Unless you have modified the
 * original directory structure of Issue-Tracker you should not have
 * to change this.  Make sure to include the trailing slash.
 */
define("_FUNCTIONS_",_INCLUDES_."functions/");

/**
 * Location where css files are generated.  This directory should be
 * web accessible and writeable by your web server.
 */
define("_CSS_",_PATH_."/css/");

/**
 * Location of the cache directory.  This directory is where cache
 * arrays will be stored.  These arrays are used to pull frequently
 * queried information like usernames, statuses, categories, etc.
 * This is done to save the overhead of having to make huge amounts
 * of queries on pages that pull alot of information like group
 * issue listings.
 */
define("_CACHE_",_PATH_."/cache/");

/**
 * Location of the logs directory. Unless you have modified the
 * original directory structure of Issue-Tracker you should not have
 * to change this.  Make sure to include the trailing slash.
 */
define("_LOGS_",_PATH_."/logs/");

/**
 * Location of sessions directory.  This is where issue-tracker session
 * files will be kept.  Make sure it is writable by the web server user.
 * For security purposes you may want to make this directory not web
 * accessible.  This is only used if $session_handler is set to FALSE.
 */
define("_SESSIONS_",_PATH_."/sessions/");

/**
 * Location of the themes directory. Unless you have modified the
 * original directory structure of Issue-Tracker you should not have
 * to change this.  Make sure to include the trailing slash.
 */
define("_THEMES_",_PATH_."/themes/");

/**
 * Location of the jpgragh classes.  If this doesn't point to the right place
 * then graph generation will not work correctly.  The JPGRAPH graphing
 * classes are not included with Issue-Tracker but can be found at 
 * http://www.aditus.nu/jpgraph/
 */
define("_JPGRAPH_",_PATH_."/graphing/");

/**
 * Location where graph images will be stored.  Make sure this
 * directory is web accessible.  The default for this is inside
 * the images directory which you should not need to change.
 */
define("_GRAPHS_",_PATH_."/images/graphs/");

/**
 * Location of help files.  These are plain text or html files
 * that correspond to module actions.  If a file exists for an
 * action then the help link should automatically display.
 */
define("_HELP_",_PATH_."/help/");

/**
 * Location where uploaded files will be kept.  This directory must
 * be writable by your webserver, but for security purposes should
 * not be web accessible.  Make sure to include the trailing slash.
 */
define("_FILES_","/var/issueTrackerFiles/");

/**
 * Maximum upload size allowed for normal users
 */
define("_MAXUPLOAD_", 52428800);

/**
 * Session Name
 */
define("_SESSIONNAME_","it");

/**
 * Default Timezone
 * If you know a better way to figure out the server's
 * offset from GMT in hours please let me know.
 */
$tz = date("O",time());
if (preg_match("-",$tz)) {
  $hour = substr($tz,0,3);
  $min = substr($tz,3,2);
} else {
  $hour = substr($tz,0,2);
  $min = substr($tz,2,2);
}
if ($min != "00") {
  switch ($min) {
    case 15:  $hour += .25; break;
    case 30:  $hour += .50; break;
    case 45:  $hour += .75; break;
    default:                break;
  }
}
define("_DEFTZ_",$hour);


/**
 * Smarty Constants
 */
define("SMARTY_DIR",_CLASSES_."smarty/");
define("_TEMPLATES_",_THEMES_);
define("_TPLCACHE_",_CACHE_."templates/");
define("_TPLCOMPILE_",_TPLCACHE_."compiled/");
define("_TPLCONFIG_",dirname(__FILE__)."/templates/");

/**
 * Status Types
 * These are used to define what each status is used for,
 * such as a closed status, waiting on tech, etc, so that
 * each one does not need to be hard coded.
 */
$status_types = array(
  1 => "Registered",    // Issue is created
  2 => "Waiting",       // Issue is waiting on someone
  3 => "Long Term",     // Issue will be long term (not counted in auto closer)
  4 => "Stale",         // Issue is stale (not updated in 2 weeks)
  5 => "Closed",        // Issue is closed by actual person
  6 => "Auto Closed"    // Issue is closed by automatic script
);

// Status Type Constants
define("TYPE_REGISTERED",1);
define("TYPE_WAITING",2);
define("TYPE_LONG_TERM",3);
define("TYPE_STALE",4);
define("TYPE_CLOSED",5);
define("TYPE_AUTO_CLOSED",6);

/**
 * Severities
 * Array to match severity number with a text representation
 */
$severities = array(
  0 => "None",
  1 => "Urgent",
  2 => "High",
  3 => "Normal",
  4 => "Low"
);

// Severity Constants
define("SEV_URGENT",1);
define("SEV_HIGH",2);
define("SEV_NORMAL",3);
define("SEV_LOW",4);

// Permission Set Constants for default system sets
define("PSET_GADMIN",1);
define("PSET_CLIENT",2);
define("PSET_PCLIENT",3);
define("PSET_SCLIENT",4);
define("PSET_TECH",5);

// Issue Tracker Version Number
define("_VERSION_","Issue-Tracker 4.0.4 (mindedge mod)");
?>
