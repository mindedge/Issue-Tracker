<?php
/* $Id: errors.func.php 2 2004-08-05 21:42:03Z eroberts $ */

/* {{{ Function: it_error_handler */
/**
 * Customer error handling for issue-tracker
 *
 * NOTE: Do not call this function directly
 */
function it_error_handler($errno,$errstr,$errfile,$errline)
{
	global $dbi,$backtrace;

	$is_fatal = array(
		E_ERROR,
		E_CORE_ERROR,
		E_USER_ERROR
	);

	switch($errno){
		case E_ERROR:
		case E_USER_ERROR:
			$string = "Fatal run-time error: $errstr\n";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$string = "Run-time warning: $errstr\n";
			break;
		case E_PARSE:
			$string = "Parse error: $errstr\n";
			break;
		case E_NOTICE:
		case E_USER_NOTICE:
			// ignore
			return;
			break;
		case E_CORE_WARNING:
			$string = "PHP CORE WARNING: $errstr\n";
			break;
		case E_CORE_ERROR:
			$string = "PHP CORE ERROR: $errstr\n";
			break;
		case E_COMPILE_WARNING:
			$string = "Zend Compile Warning: $errstr\n";
			break;
		default:
			$string = "ERROR: $errstr\n";
			break;
	}

	if(function_exists("debug_backtrace") and $backtrace === TRUE){
		$backtrace = debug_backtrace();
		for ($x = 1;$x < count($backtrace);$x++) {
			$string .= sprintf("\tFile: %s\n\t\tLine: %d\n\t\tFunction: %s\n",
				$backtrace[$x]['file'],$backtrace[$x]['line'],
				$backtrace[$x]['function']);
		}
	} else {
		$string .= "\tFile: $errfile Line: $errline";
	}				

	if (is_array($is_fatal)) {
		if (in_array($errno,$is_fatal)) {
			$headers  = "Subject: Issue Tracker Error\n";
			error_log($string,1,_ADMINEMAIL_,$headers);
		}
	}

	if ($dbi->get("link")) {
		logger($string,"phperrors");
	} else {
    $date = "[".date_format()."]";
    debug($date.$string,"PHP Errors");
		error_log($date.$string."\n",3,_LOGS_."phperrors");
	}

	if (is_array($is_fatal)) {
		if(in_array($errno,$is_fatal)){
			exit(1);
		}
	}
}
/* }}} */

/* {{{ Function: push_error */
/**
 * Add a error message onto the error array, only added this function
 * because I'm lazy and didn't want to keep typing $_SESSION['errors']
 *
 * @param string $message The error message to add
 */
function push_error($message)
{
	array_push($_SESSION['errors'],$message);
}
/* }}} */

/* {{{ Function: push_fatal_error */
/**
 * Add a error message to the errors array and also notify the system
 * administrator of the error message.
 *
 * @param string $message The error message to add
 */
function push_fatal_error($message)
{
  global $dbi;

	array_push($_SESSION['errors'],$message." The system administrator has been notified.");
  
  ob_start();
  print_r($GLOBALS);
  $contents = ob_get_contents();
  ob_end_clean();
  
  $message .= "\n\n$contents";
  admin_notify($message);
}
/* }}} */

/* {{{ Function: errors */
/**
 * Determine if there are errors to be displayed
 *
 * @return boolean
 */
function errors()
{
	if (count($_SESSION['errors']) != 0) {
		return TRUE;
	}

	return FALSE;
}
/* }}} */
?>
