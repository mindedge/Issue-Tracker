<?php
/* $Id: file.func.php 4 2004-08-10 00:36:34Z eroberts $ */

/* {{{ Size Constants */
define("_SIZEGB_",1073741824);
define("_SIZEMB_",1048576);
define("_SIZEKB_",1024);
/* }}} */

/* {{{ Function: fsize */
/**
 * Determine the size of a file
 *
 * @param integer $fid ID of file
 * @return string
 */
function fsize($fid)
{
  global $dbi;

  $sql  = "SELECT uploaded_on,name,typeid,file_type ";
  $sql .= "FROM files ";
  $sql .= "WHERE fid='$fid'";
  list($date,$name,$id,$type) = $dbi->fetch_row($sql);
  if (!empty($name)) {
    $filename = !empty($date) ? $filename = $date."-".$name : $name;
    if (file_exists(_FILES_."$type/$id/$filename")) {
      $size = filesize(_FILES_."$type/$id/$filename");

      if ($size >= _SIZEGB_) {
        $size = number_format(($size / _SIZEGB_),2) . " GB";
      } elseif ($size >= _SIZEMB_) {
        $size = number_format(($size / _SIZEMB_),2) . " MB";
      } elseif ($size >= _SIZEKB_) {
        $size = number_format(($size / _SIZEKB_),2) . " KB";
      } elseif ($size >= 0) {
        $size = $size . " bytes";
      } else {
        $size = "0 bytes";
      }
    }
  } else {
    $size = "N/A";
  }

  return $size;
}
/* }}} */

/* {{{ Function: can_download */
/**
 * Determines whether or not a user can download a file
 *
 * @param integer $fid ID of file to check
 * @return boolean
 */
function can_download($fid)
{
  global $dbi;

  if (is_admin() or is_employee()) {
    return TRUE;
  }

  $sql  = "SELECT typeid,file_type ";
  $sql .= "FROM files ";
  $sql .= "WHERE fid='$fid'";
  list($id,$type) = $dbi->fetch_row($sql);
  if (!empty($id)) {
    switch ($type) {
      case "groups":
        if (user_in_group($gid)) {
          return TRUE;
        }
        break;
      case "issues":
        if (can_view_issue($id,$_SESSION['userid'])) {
          return TRUE;
        }
        break;
      default:
        logger("Could not determine type for file $fid");
        return FALSE;
        break;
    }
  }

  return FALSE;
}
/* }}} */

/* {{{ Function: mime_check */
/**
 * Determines if a file is valid for upload/download
 *
 * @param string $filename is the full name of the file to be reviewed
 * @return boolean
 */
function mime_check($filename)
{
  global $bad_mime;

  if (empty($filename)) {
    return FALSE;
  } else {
    foreach ($bad_mime as $key => $val) {
      if (preg_match("/".$val."$/i",trim($filename))) {
        return FALSE;
      }
    }
  }

  return TRUE;
}
  /* }}} */

/* {{{ Function: upload */
/**
 * Upload a file
 *
 * @param integer $id ID of the issue or group to associate with
 * @param string $type Type of upload (issue|group)
 * @return integer
 */
function upload($id,$type = "issues")
{
  global $dbi;

  clearstatcache();

  // Make sure files directory exists
  if (!file_exists(_FILES_)) {
    if (!mkdir(_FILES_,0700)) {
      push_fatal_error("Creation of main file upload directory failed!");
      return FALSE;
    }
    chown(_FILES_,_WEBUSR_);
    chgrp(_FILES_,_WEBGRP_);
	}

  // cycle through the $_FILES array
  foreach ($_FILES as $upload) {
    if (empty($upload['name']) or $upload['size'] < 0) {
      continue;
    }

    // make sure there is a directory for this type
    if (!file_exists(_FILES_.$type)) {
      if (!mkdir(_FILES_.$type,0700)) {
        push_fatal_error("Creation of $type file upload directory failed!");
        return FALSE;
      }
      chown(_FILES_.$type,_WEBUSR_);
      chgrp(_FILES_.$type,_WEBGRP_);
    }
    
    if (!file_exists(_FILES_."$type/$id")) {
      if (!mkdir(_FILES_."$type/$id",0700)) {
        push_fatal_error("Creation of issue file directory failed!");
        return FALSE;
      }
      chown(_FILES_."$type/$id",_WEBUSR_);
      chgrp(_FILES_."$type/$id",_WEBGRP_);
    } 

    // check if the file is a cgi file for older versions of apache that do not handle thie gracefully
    $date = time();

    if (!mime_check($upload['name'])) {
      $newname = $date."-".$upload['name'].".dl";
    } else {
      $newname = $date."-".$upload['name'];
    }
 
 	//replace spaces, ampersands, question marks, and colons with underscores so the download link doesn't break MWarner 4/20/2010
	$newname=str_replace(array(" ","&","?",":"),array("_","_and_","_","_"),$newname);
	$newname=str_replace("__","_",$newname);//replace double underscore to make it pretty
	$upload['name']=str_replace(array(" ","&","?",":"),array("_","_and_","_","_"),$upload['name']);
	$upload['name']=str_replace("__","_",$upload['name']);//replace double underscore to make it pretty
	
    // move file from tmp to the right directory
    if (move_uploaded_file($upload['tmp_name'],_FILES_."$type/$id/$newname")) {
      chown(_FILES_."$type/$id/$newname",_WEBUSR_);
      chgrp(_FILES_."$type/$id/$newname",_WEBGRP_);

      $insert['file_type']  = $type;
      $insert['typeid']     = $id;
      $insert['userid']     = $_SESSION['userid']; 
      $insert['uploaded_on']= $date;
      $insert['name']       = $upload['name'];
      $insert['private']    = $_POST['eprivate'] == "on" ? "t" : "f";
      $fid = $dbi->insert("files",$insert,"files_fid_seq");

      if (!empty($fid)) {
        if ($type == "groups") {
          logger(username($_SESSION['userid'])." uploaded ".$upload['name']." to ".group_name($id),"uploads");
        } else {
          logger(username($_SESSION['userid'])." uploaded ".$upload['name']." to issue $id.","uploads");
          issue_log($_GET['issueid'],"File uploaded: ".$upload['name']);
        }
        $files[] = $fid;
      } else {
        push_fatal_error($upload['name']." could not be uploaded.");
      }
    }
  }

  return $files;
}
/* }}} */

/* {{{ Function: download */
/**
 * Download a file by its fid
 *
 * @param integer $fid ID of file to be downloaded
 */
function download($fid)
{
  global $dbi;

  clearstatcache();

  // check to see if user can
  // download this file
  if (can_download($fid)) {
    $sql  = "SELECT name,uploaded_on,typeid,file_type ";
    $sql .= "FROM files ";
    $sql .= "WHERE fid='$fid'";
    list($name,$date,$id,$type) = $dbi->fetch_row($sql);
    if (!empty($id)) {
      if (!mime_check($name)) {
        $name .= ".dl";
      }

      // make sure to get correct file
      if ($date != "" and file_exists(_FILES_."$type/$id/$date-$name")) {
        $name = $date."-".$name;
      }

      $fullname = _FILES_."$type/$id/$name";

      if (!empty($name) and file_exists($fullname)) {
        logger(username($_SESSION['userid'],FALSE)." downloading file $fid ($name).","downloads");
        header("Content-Type: application/download");
        header("Content-Disposition: inline; filename=$name;");
        header("Content-Length: ".filesize($fullname));
        readfile($fullname);
		die();//die here, otherwise part of the header template will be appended to ASCII files MWarner 4/28/2010
      }
    }
  }
}
/* }}} */

/* {{{ Function: logger */
/**
 * Log messages to database/file
 *
 * @param string $message Message to be logged to file
 * @param string $type Type of logging
 */
function logger($message,$type)
{
  global $dbi;

  debug($message,ucwords(str_replace("_"," ",$type)));

  /*
  if ($dbi->get("link")) {
    $insert['log_type']			= $type;
    $insert['log_time']			= time();
    $insert['log_message']	= $message;
    $insert['log_user']			= $_SESSION['userid'];
    $dbi->insert("logs",$insert);
  } else {
  */
  	//$date = "[".date_format()."]";
	//to stop the bugs MWarner 6.19.09
	$datetime = date_create(date("Y-m-d h:i:s"));//'2008-08-03 14:52:10'
    $date = "[".date_format($datetime,"Y-m-d_h:i:s")."]";

    if (!empty($_SESSION['userid'])) {
      $user = "[User: ".username($_SESSION['userid'])."]";
    }

    $fp = fopen(_LOGS_."/".$type,"a+");
    fwrite($fp,"$date $user $message\n");
    fclose($fp);
  //}
}
/* }}} */

/* {{{ Function: remove_dir */
/**
 * Recursively removes a directory
 *
 * @param string $directory Directory to remove
 */
function remove_dir($directory)
{
  if (!preg_match("/^.*\/$/i",$directory)) {
    $directory .= "/";
  }

  clearstatcache();

  if (file_exists($directory)) {
    if ($dir = @opendir($directory)) {
      while (($item = readdir($dir)) !== false) {
        if ($item == "." or $item == "..") {
          continue;
        }

        if (is_file($directory.$item)) {
          unlink($directory.$item);
        } else {
          remove_dir($directory.$item);
        }
      }
    }
  }
}
/* }}} */
?>
