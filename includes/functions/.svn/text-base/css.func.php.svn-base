<?php
/* $Id: css.func.php 2 2004-08-05 21:42:03Z eroberts $ */

/* {{{ Function: generate_theme_css */
/**
 * Generate the css files for themes
 */
function generate_theme_css()
{
  if ($dir = @opendir(_THEMES_)) {
    while (($item = readdir($dir)) !== false) {
      if ($item == "." or $item == ".." or $item == "CVS") {
        continue;
      }
      
      if (is_dir(_THEMES_.$item) and file_exists(_THEMES_."$item/theme.php")) {
        if (!file_exists(_CSS_."$item.css")
        or filemtime(_THEMES_."$item/theme.php") > filemtime(_CSS_."$item.css")
        or filemtime(_THEMES_."$item/screen.css") > filemtime(_CSS_."$item.css")) {
          write_css("$item.css",_THEMES_."$item/theme.php",_THEMES_.$item."/screen.css");
        }

        if (!file_exists(_CSS_."$item-ns4.css")
        or filemtime(_THEMES_."$item/theme.php") > filemtime(_CSS_."$item-ns4.css")
        or filemtime(_THEMES_."$item/screen-ns4.css") > filemtime(_CSS_."$item-ns4.css")) {
          write_css("$item-ns4.css",_THEMES_."$item/theme.php",_THEMES_.$item."/screen-ns4.css");
        }
      }
    }
  }
}
/* }}} */

/* {{{ Function: generate_user_css */
/**
 * Generate the css file for currently logged in user
 */
function generate_user_css()
{
  global $default_theme;

  if (!isset($_SESSION['userid'])) {
    return;
  }

  $_SESSION['theme'] = empty($_SESSION['theme']) ? $default_theme : $_SESSION['theme'];

  if (file_exists(_THEMES_.$_SESSION['theme']."/screen.css")) {
    $template = _THEMES_.$_SESSION['theme']."/screen.css";
  }

  if (file_exists(_THEMES_.$_SESSION['userid'].".theme.php")) {
    if (!file_exists(_CSS_.$_SESSION['userid'].".css")
    or filemtime(_THEMES_.$_SESSION['userid'].".theme.php") > filemtime(_CSS_.$_SESSION['userid'].".css")
    or filemtime($template) > filemtime(_CSS_.$_SESSION['userid'].".css")) {
      $filename = $_SESSION['userid'].".css";
      $theme = _THEMES_.$_SESSION['userid'].".theme.php";
    
      write_css($filename,$theme,$template);
    }
  }
}
/* }}} */

/* {{{ Function: write_css */
/**
 * Write out the actual css files used
 *
 * @param string $filename CSS file to write
 * @param string $theme Theme file to include
 * @param string $template CSS template to use
 */
function write_css($filename,$theme,$template)
{
  if (empty($template)) {
    logger("No template specified to generate $filename!","css_errors");
    return;
  }

  if (!file_exists($theme)
  or !file_exists($template)) {
    return;
  }

  $buffer = '$buffer = "';

  $fp = fopen($template,"r");
  $buffer .= fread($fp,filesize($template));
  fclose($fp);

  $buffer .= '";';

  include($theme);

  $fsize = "$font_size$font_unit";
  $underline = !$underline ? "none" : "underline";
  eval($buffer);

  $fp = fopen(_CSS_.$filename,"w");
  fwrite($fp,$buffer);
  fclose($fp);
}
/* }}} */

/* {{{ Function: cssfile */
/**
 * Determines which css file should be used
 *
 * @return string
 */
function cssfile()
{
  global $default_theme;
 
  if (isset($_SESSION['userid'])) {
    if (file_exists(_CSS_.$_SESSION['userid'].".css")) {
      return $_SESSION['userid'].".css";
    }
  }

  
  if (preg_match("/mozilla/i",$_SERVER['HTTP_USER_AGENT']) && preg_match("/(4\.7)|(4\.8)/",$_SERVER['HTTP_USER_AGENT'])) {
    if (file_exists(_CSS_.$_SESSION['theme']."-ns4.css")) {
      $cssfile = $_SESSION['theme']."-ns4.css";
    } else if (file_exists(_CSS_.$default_theme."-ns4.css")) {
      $cssfile = $default_theme."-ns4.css";
    } else {
      logger("Unable to find netscape specific css file!","css_errors");
    }
  } else if (file_exists(_CSS_.$_SESSION['theme'].".css")) {
    $cssfile = $_SESSION['theme'].".css";
  } else  if (file_exists(_CSS_.$default_theme.".css")) {
    $cssfile = $default_theme.".css";
  } else {
    logger("Unable to find suitable css file!","css_errors");
  }

  return $cssfile;
}
/* }}} */
?>
