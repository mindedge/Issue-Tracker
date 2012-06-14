<?php
/* $Id: funcs.php 2 2004-08-05 21:42:03Z eroberts $ */
/** 
 * @package Issue-Tracker
 * @subpackage Administration
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

/* {{{ Function: colorize_log */
/**
 * Colorize log output for easy viewing
 *
 * @param string $buffer Information to colorize
 */
function colorize_log($buffer)
{
  $buffer = str_replace("[","<font color=\"red\">[</font>",$buffer);
  $buffer = str_replace("]","<font color=\"red\">]</font>",$buffer);
  $buffer = str_replace("(","<font color=\"red\">(</font>",$buffer);
  $buffer = str_replace(")","<font color=\"red\">)</font>",$buffer);
  $buffer = str_replace("{","<font color=\"red\">{</font>",$buffer);
  $buffer = str_replace("}","<font color=\"red\">}</font>",$buffer);
  $buffer = str_replace("Array","<font color=\"blue\">Array</font>",$buffer);
  $buffer = str_replace("=>","<font color=\"magenta\">=></font>",$buffer);
  $buffer = str_replace(":","<font color=\"green\">:</font>",$buffer);
  return $buffer;
}
/* }}} */
?>
