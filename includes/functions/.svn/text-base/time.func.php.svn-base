<?php
/* $Id: time.func.php 2 2004-08-05 21:42:03Z eroberts $ */

/* {{{ Time Constants */
define("_MINUTE_",60);
define("_HOUR_",_MINUTE_ * 60);
define("_DAY_",_HOUR_ * 24);
define("_WEEK_",_DAY_ * 7);
define("_MONTH_",_WEEK_ * 4);
define("_YEAR_",_WEEK_ * 52);
/* }}} */

/* {{{ Function: date_format */
/**
 * Just a simple function to have a central location
 * where all date formats can be modified at once, might
 * even through in option for users to specify their own
 * timezone at some point
 *
 * @param integer $timestamp Unix timestamp
 * @return string
 */
 if(!function_exists('date_format')){//to get rid of double declare MWarner 6/18/2009
	function date_format($timestamp = null,$showtime = TRUE)
	{
	  if (empty($timestamp)) {
	    $timestamp = time();
	  }
	
	  if ($_SESSION['prefs']['local_tz'] == "t") {
	    if ($showtime) {
	      $date = gmdate($_SESSION['prefs']['date_format']." h:ia",$timestamp - ($_COOKIE['tz'] * 3600));
	    } else {
	      $date = gmdate($_SESSION['prefs']['date_format'],$timestamp - ($_COOKIE['tz'] * 3600));
	    }
	  } else {
	    if ($showtime) {
	      $date = date($_SESSION['prefs']['date_format']." h:ia",$timestamp);
	    } else {
	      $date = date($_SESSION['prefs']['date_format'],$timestamp);
	    }
	  }
	  return $date;
	}
}
/* }}} */

/* {{{ Function: time_format */
/**
 * Take a amount of time in seconds and make it humanly readable
 *
 * @param integer $time Amount of time in seconds
 * @return string $string
 */
if(!function_exists('time_format')){//to get rid of double declare MWarner 6/18/2009
	function time_format($time)
	{
	  // now here's how to reconstruct it
	  $days = (int)($time / _DAY_);
	  // find the remainder of that operation
	  $remainder =  $time % _DAY_;
	  // now find the hours in the remainder
	  $hours  =  (int)($remainder / _HOUR_);
	  // and the remainder of THAT operation
	  $remainder = $remainder % _HOUR_;
	  // now we're down to minutes
	  $minutes = (int)($remainder / _MINUTE_);
	  // and what remains is ...
	  $seconds = $remainder % _MINUTE_;
	
	  $string = sprintf("%3.3d day%s %2.2d hour%s %2.2d minute%s %2.2d second%s",
	    $days,$days != 1 ? "s" : "",$hours,$hours != 1 ? "s" : "",
	    $minutes,$minutes != 1 ? "s" : "",$seconds,$seconds != 1 ? "s" : "");
	
	  return $string;
	}
}
/* }}} */
?>
