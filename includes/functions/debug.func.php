<?php
/* $Id: debug.func.php 4 2004-08-10 00:36:34Z eroberts $ */

/* {{{ Function: debug */
/**
 * Send debug message to debug file
 *
 * @param mixed $data
 * @param string $description
 */
function debug($data,$description = null) 
{ 
  if (isset($_SESSION['debugger'])) {
    if ($_SESSION['debugger'] == "on") {
      if (is_array($data)) {
        ob_start(); 
        print_r($data); 
        $data = ob_get_contents(); 
        ob_end_clean();
        $data = explode("\n",$data);
      }
     
      if (function_exists("debug_backtrace")) {
        $backtrace = debug_backtrace();
      }

      $buffer .= "<tr><td class=\"debug\">\n";
      $buffer .= "<pre class=\"fixed\">\n";

      $buffer .= date_format(time())."<br />\n";

      if (!empty($description)) {
        $buffer .= "<b><u>$description</u></b>\n";
      }
      
      if (is_array($backtrace)) {
        foreach ($backtrace as $val) {
          $buffer .= sprintf("    <b>File</b>: %-70.70s",$val['file'])."\n";
          $buffer .= sprintf("    <b>Line</b>: %-6.6d",$val['line'])."\n";
          $buffer .= sprintf("<b>Function</b>: %-32.32s",$val['function'])."\n";
          $buffer .= "<b>----------</b>\n";
        }
      }
      
      if (is_array($data)) {
        foreach ($data as $line) {
          $buffer .= colorize_debug($line)."\n";
        }
      } else {
        $data = wordwrap($data,80,'<br />',1);
        $buffer .= $data."\n";
      }
     
      $buffer .= "</pre>\n";
      $buffer .= "</td></tr>\n";

      print "<script type=\"text/javascript\" language=\"javascript\">\n";
      $lines = explode("\n",$buffer);
      foreach ($lines as $line) {
        print "debugwin.document.writeln('$line');\n";
      }
      print "</script>\n";
    }
  }
}
/* }}} */

/* {{{ Function: colorize_debug */
/**
 * Colorize the debug output of arrays
 *
 * @param string $array Array to colorize
 */ 
function colorize_debug($array) 
{ 
  $array = str_replace('[','<font color="magenta">[</font><font color="red">',$array); 
  $array = str_replace(']','</font><font color="magenta">]</font>',$array); 
  $array = str_replace('Array','<font color="green">Array</font>',$array); 
  $array = str_replace('=>','<font color="navy">=></font>',$array); 
  return $array; 
}
/* }}} */
?>
