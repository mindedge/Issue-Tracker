<?php
/* $Id: dbi.class.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * Database Abstraction Layer
 *
 * This is the database abstraction layer used for Issue-Tracker.
 * Currently it supports MySQL & PostgreSQL
 *
 * To initialize the dbi you must first form an array with your
 * database parameters, and then pass the array to the init method.
 *
 * <code>
 * <?php
 * $db = array(
 *	"type"	=>	"<mysql|pgsql>",
 *	"host"	=>	"<host>",
 *	"port"	=>	"<port>",
 *	"name"	=>	"<database>",
 *	"user"	=>	"<username>",
 *	"pass"	=>	"<password>"
 * );
 *
 * include_once("dbi.class.php");
 * $dbi = new DBI;
 * $dbi->init($db);
 * ?>
 * </code>
 * 
 * @author Edwin Robertson {TuxMonkey}
 * @version 4.0
 * @package Issue-Tracker
 * @copyright Edwin Robertson
 */
class DBI {
  var $type;
  var $host;
  var $port;
  var $user;
  var $pass;
  var $name;
  var $link;
  var $log_queries = FALSE;
  var $long_query = 2;
  var $admin_email;
  var $email_from;

  /**
   * Used to set various class variables
   *
   * @param string $var Class variable to be set
   * @param mixed $val Value to assign to the class variable
   * @return nothing
   */
  function set($var,$val)
  {
    $this->$var = $val;
  }

  /**
   * Retrieve the value of the specified variable
   *
   * @param string $var Variable to retrieve
   * @return string
   */
  function get($var)
  {
    return $this->$var;
  }

  /**
   * Initialize database variables and make database connection
   * 
   * @param array $params
   */
  function init($params)
  {
    foreach ($params as $key => $val) {
      $this->$key = $val;
    }
    
    switch ($this->type) {
      case "mysql":
        if (!empty($this->port)) {
          $this->link = mysql_connect($this->host.":".$this->port,$this->user,$this->pass)
            or $this->logger("Database connection failed!","DBI");
        } else {
          $this->link = mysql_connect($this->host,$this->user,$this->pass)
            or $this->logger("Database connection failed!","DBI");
        }
        if ($this->link) {
          mysql_select_db($this->name,$this->link);
          return TRUE;
        }
        break;
      case "pgsql":
        // Build the connection string
        $conn_str  = "user=".$this->user;
        $conn_str .= !empty($this->pass) ? " password='".$this->pass."'" : "";
        $conn_str .= !empty($this->host) ? " host=".$this->host : "";
        $conn_str .= !empty($this->port) ? " port=".$this->port : "";
        $conn_str .= " dbname=".$this->name;

        $this->link = pg_connect($conn_str)
          or $this->logger("Database connection failed!","DBI");
        break;
      default:
        $this->logger("Unknown database type in init()","DBI");
        break;
    }
  }

  /**
   * Execute given SQL string and return result
   *
   * @param string $sql SQL string to execute
   * @return resource
   */
  function query($sql)
  {
    if (empty($sql)) {
      $this->logger("query() called with empty SQL string","DBI");
      return FALSE;
    }

    if ($this->log_queries) {
      $this->logger($sql,"queries");
    }


    switch ($this->type) {
      case "mysql":
        $start = $this->getmicrotime();
        $result = @mysql_query($sql,$this->link);
        $query_time = $this->getmicrotime() - $start;
        break;
      case "pgsql":
        $start = $this->getmicrotime();
        $result = @pg_query($this->link,$sql);
        $query_time = $this->getmicrotime() - $start;
        break;
      default:
        $this->logger("Unknown database type in query()","DBI");
        break;
    }
    
    if ($query_time > $this->long_query) {
      $this->logger($sql,"long_queries");
    }

    if ($result) {
      return $result;
    } else {
      $this->logger($sql,"failed_queries");
      return FALSE;
    }
  }

  /**
   * Return number of fields present in a single row of given resultset
   *
   * @param resource $result Result to count fields in
   * @return integer
   */
  function num_fields($result)
  {
    if (!is_resource($result)) {
      $this->logger("Invalid database result passed to num_fields()","DBI");
      return FALSE;
    }
    
    switch ($this->type) {
      case "mysql":
        $fields = @mysql_num_fields($result);
        break;
      case "pgsql":
        $fields = @pg_num_fields($result);
        break;
      default:
        $this->logger("Unknown database type in num_fields()","DBI");
        break;
    }

    return $fields;
  }

  /**
   * Return name of field from resultset
   *
   * @param resource $result
   * @param integer $field
   * @return string
   */
  function field_name($result,$field)
  {
    if (!is_resource($result)) {
      $this->logger("Invalid database result passed to field_name()","DBI");
      return FALSE;
    }

    switch ($this->type) {
      case "mysql":
        $name = @mysql_field_name($result,$field);
        break;
      case "pgsql":
        $name = @pg_field_name($result,$field);
        break;
      default:
        $this->logger("Unknown database type in field_name()","DBI");
        break;
    }

    return $name;
  }

  /**
   * Return number of rows in a resultset
   *
   * @param resource $result
   * @return integer
   */
  function num_rows($result)
  {
    if (!is_resource($result)) {
      $this->logger("Invalid database result passed to num_rows()","DBI");
      return FALSE;
    }
  
    switch ($this->type) {
      case "mysql":
        $rows = @mysql_num_rows($result);
        break;
      case "pgsql":
        $rows = @pg_num_rows($result);
        break;
      default:
        $this->logger("Unknown database type in num_rows()","DBI");
        break;
    }

    return $rows;
  }

  /**
   * Return number of rows affected by result
   *
   * @param resource $result
   * @return integer
   */
  function affected_rows($result = null)
  {
    if (!is_resource($result)) {
      $this->logger("Invalid database result passed to affected_rows()","DBI");
      return FALSE;
    }

    switch ($this->type) {
      case "mysql":
        $rows = @mysql_affected_rows($this->link);
        break;
      case "pgsql":
        $rows = @pg_affected_rows($result);
        break;
      default:
        $this->logger("Unknown database type in affected_rows()","DBI");
        break;
    }

    return $rows;
  }

  /**
   * Fetch a row from given resultset
   *
   * @param resource $result
   * @param string $rtype Type of fetch to perform (row,field,array,object)
   * @param integer $offset Only used if specify field for $rtype
   * @return mixed
   */
  function fetch($result,$rtype = "row",$offset = 0)
  {
    $rtype = strtolower($rtype);

    switch ($this->type) {
      case "mysql":
        if ($rtype == "object") {
          $data = @mysql_fetch_object($result);
        } else if ($rtype == "field") {
          $data = @mysql_fetch_field($result,$offset);
        } else if ($rtype == "array") {
          $data = @mysql_fetch_array($result,MYSQL_ASSOC);
        } else {
          $data = @mysql_fetch_row($result);
        }
        break;
      case "pgsql":
        if ($rtype == "object") {
          $data = @pg_fetch_object($result);
        } else if ($rtype == "field") {
          $error  = "Fetch method not implemented in this version of PHP.";
          $this->logger($error,"DBI");
        } else if ($rtype == "array") {
          $data = @pg_fetch_array($result,null,PGSQL_ASSOC);
        } else {
          $data = @pg_fetch_row($result);
        }
        break;
      default:
        $this->logger("Unknown database type in fetch()","DBI");
        break;
    }

    return $data;
  }

  /**
   * Free memory used by a result
   *
   * @param resource $result
   */
  function free($result)
  {
    if (!is_resource($result)) {
      $this->logger("Invalid database result passed to free()","DBI");
      return FALSE;
    }

    switch ($this->type) {
      case "mysql":
        @mysql_free_result($result);
        break;
      case "pgsql":
        @pg_free_result($result);
        break;
      default:
        $this->logger("Unknown database type in free()","DBI");
        break;
    }
  }

  /**
   * Close connection to database server
   */
  function close()
  {
    switch ($this->type) {
      case "mysql":
        @mysql_close($this->link);
        break;
      case "pgsql":
        @pg_close($this->link);
        break;
      default:
        $this->logger("Unknown database type in close()","DBI");
        break;
    }
  }

  /**
   * Retrieve the last insert id
   *
   * @param string $sequence The sequence to pull last id from
   * @return integer
   */
  function insert_id($sequence = null)
  {
    switch ($this->type) {
      case "mysql":
        $id = @mysql_insert_id();
        break;
      case "pgsql":
        if (is_null($sequence)) {
          return FALSE;
        }
        
        $sql = "SELECT last_value FROM $sequence";
        $id = $this->fetch_one($sql);
        break;
      default:
        $this->logger("Unknown database type in insert_id()","DBI");
        break;
    }

    return $id;
  }

  /**
   * Retrieve the first column of first row from
   * result of given sql string
   *
   * @param string $sql SQL string to execute
   * @return mixed
   */
  function fetch_one($sql)
  {
    $result = $this->query($sql);
    if ($this->num_rows($result) > 0) {
      list($data) = $this->fetch($result);
      $this->free($result);
      return $data;
    }

    return null;
  }

  /**
   * Retrieve the first row from result of given sql string
   *
   * @param string $sql SQL string to execute
   * @param string $rtype Type of data returned (row,array,object,field)
   * @return mixed
   */
  function fetch_row($sql,$rtype = "row")
  {
    $result = $this->query($sql);
    if ($this->num_rows($result) > 0) {
      $row = $this->fetch($result,$rtype);
      $this->free($result);
      return $row;
    }

    return null;
  }

  /**
   * Runs a query and returns the result in an associative array
   *
   * @param string $sql
   * @param string $rtype Type of data returned (row,array)
   * @return array
   */
  function fetch_all($sql,$rtype = "row")
  {
    $result = $this->query($sql);
    if ($this->num_rows($result) > 0) {
      $rows = array();
    
      while ($row = $this->fetch($result,$rtype)) {
        if (count($row) > 1) {
          array_push($rows,$row);
        } else {
          array_push($rows,$row[0]);
        }
      }

      $this->free($result);
      return $rows;
    }

    return null;
  }

  /**
   * Generic insert function, if sequence is specified then the last
   * id will be returned
   *
   * @param string $table Table to insert data into
   * @param array $data Array of data to be inserted
   * @return integer
   */
  function insert($table,$data,$sequence = null)
  {
    $first = TRUE;

    if (!is_array($data)) {
      return;
    }

    foreach ($data as $key => $val) {
      if (!$first) {
        $fields .= ",";
        $values .= ",";
      }
      
      $fields .= $key;
      $values .= !empty($val) ? "'".addslashes($val)."'" : "NULL";
      $first = FALSE;
    }

    if ($this->transactions) {
      $this->query("BEGIN;");
    }

    $sql  = "INSERT INTO $table ";
    $sql .= "($fields) ";
    $sql .= "VALUES($values);";
    $result = $this->query($sql);

    if (!$result) {
      return;
    }
    
    if ($result and !is_null($sequence)) {
      $id = $this->insert_id($sequence);
      return $id;
    }

    return TRUE;
  }
  
  /**
   * Generic update function, will only update a single row
   *
   * @param string $table Table to update
   * @param array $data Data to update in the table
   * @param string $condition Any conditional statements (Where id=3)
   */
  function update($table,$data,$condition = null)
  {
    $first = TRUE;

    foreach ($data as $key => $val) {
      if (!$first) {
        $values .= ",";
      }

      $values .= "$key=";
      $values .= !empty($val) ? "'".addslashes($val)."'" : "NULL";
      $first = FALSE;
    }

    $sql  = "UPDATE $table ";
    $sql .= "SET $values ";
    $sql .= $condition;
    $result = $this->query($sql);
  }

  /**
   * Retrieve the current unix timestamp with microseconds
   */
  function getmicrotime()
  {
    $time = microtime();
    $parts = explode(" ",$time);
    $time = $parts[0] + $parts[1];
    return $time;
  }

  /**
   * Logging function
   *
   * @param string $msg Message to be logged to file
   * @param string $type Type of msg (error,query)
   */
  function logger($msg,$type = "error")
  {
    $date = "[".date("m-d-Y h:ia",time())."]";
    if ($fp = fopen(_LOGS_.$type,"a+")) {
      fwrite($fp,"$date $msg\n");
      fclose($fp);
    }
  }
}
?>
