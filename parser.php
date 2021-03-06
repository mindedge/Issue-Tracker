#!/usr/bin/php -d register_globals=off -q
<?php
/* $Id: parser,v 1.15 2003/11/14 16:31:46 tuxmonkey Exp $ */
// vim: ts=2 sw=2 fdm=marker
// Ok, everything good so far, brining in the config file
// and run the initialize script to pull everything in
define("PARSER",TRUE);
require_once(dirname(__FILE__)."/initialize.php");
require_once(_CLASSES_."mail.class.php");

/* {{{ maillog(&$parser) */
function maillog(&$parser)
{
  $message  = "Received mail from: ".$parser->headers['from']."\n";

  if (_DEBUGMODE_) {
    $headers = var_export($parser->headers,TRUE);
    $args = var_export($parser->args,TRUE);
    $mime = var_export($parser->mime_parts,TRUE);
    $message .= "Headers:\n{$headers}\n\n";
    $message .= "Arguments:\n{$args}\n\n";
    $message .= "Mime Parts:\n{$mime}\n\n";
    $message .= "Body:\n{$parser->body}\n\n";
  }

  logger(trim($message),"parser");
}
/* }}} */

/* {{{ attach_files($issueid,&$parser) */
// Used to add attached files to issues
function attach_files($issueid,&$parser)
{
  global $dbi;

  // make sure we actually have a issueid
  if (empty($issueid)) {
    return;
  }

  // Make sure the files directory is defined
  if (!defined("_FILES_")) {
    logger("Files directory not defined.","parser");
    return;
  }

  // Make sure the files directory exists
  if (file_exists(_FILES_)) {
    // Make sure files directory is writeable
    if (!is_writeable(_FILES_)) {
      logger("Files directory not writeable.","parser");
      return;
    }
  } else {
    // Create the files directory
    if (!mkdir(_FILES_,0770)) {
      logger("Files directory could not be created.","parser");
      return;
    }
    chown(_FILES_,_WEBUSR_);
    chgrp(_FILES_,_WEBGRP_);
  }

  // Make sure the issue directory exists
  if (!file_exists(_FILES_."issues")) {
    if (!mkdir(_FILES_."issues",0770)) {
      logger("Issues file directory could not be created.","parser");
      return;
    }
    chown(_FILES_."issues",_WEBUSR_);
    chgrp(_FILES_."issues",_WEBGRP_);
  } else {
    // Make sure the directory is writeable
    if (!is_writeable(_FILES_."issues")) {
      logger("Issues file directory not writeable.","parser");
      return;
    }
  }

  // Make sure the issue specific directory exists
  if (!file_exists(_FILES_."issues/$issueid")) {
    if (!mkdir(_FILES_."issues/$issueid",0770)) {
      logger("Could not create files directory for issue $issueid.","parser");
      return;
    }
    chown(_FILES_."issues/$issueid",_WEBUSR_);
    chgrp(_FILES_."issues/$issueid",_WEBGRP_);
  } else {
    // Make sure the issue specific file directory is writeable
    if (!is_writeable(_FILES_."issues/$issueid")) {
      logger("Files directory for issue $issueid is not writeable.","parser");
      return;
    }
  }

  // Get current timestamp
  $timestamp = time();

  // Only run through this if we actually have a mime message
  if (count($parser->mime_parts) > 0) {
    foreach ($parser->mime_parts as $mime) {
      // If its an attachment of type base64 then decode
      // and write the file, plain text attachments are
      // automatically added to the parsed mail body
      if (!empty($mime['filename'])) {
        $filename = $timestamp."-".$mime['filename'];

        if ($mime['content-transfer-encoding'] == "base64") {
          if ($fp = fopen(_FILES_."issues/$issueid/$filename","w")) {
            fwrite($fp,trim(base64_decode($mime['body'])));
            fclose($fp);
            chown(_FILES_."issues/$issueid/$filename",_WEBUSR_);
            chgrp(_FILES_."issues/$issueid/$filename",_WEBGRP_);

            logger($mime['filename']." uploaded to issue $issueid.","parser");
            issue_log($issueid,"File uploaded: ".$mime['filename'],FALSE,_PARSER_);

            $insert['file_type'] = "issues";
            $insert['typeid'] = $issueid;
            $insert['userid'] = _PARSER_;
            $insert['uploaded_on'] = $timestamp;
            $insert['name'] = $mime['filename'];
            $dbi->insert("files",$insert);
          }
		} else if (preg_match("/text\/plain/i",$mime['content-type'])) {
          if ($fp = fopen(_FILES_."issues/$issueid/$filename","w")) {
            fwrite($fp,trim($mime['body']));
            fclose($fp);
            chown(_FILES_."issues/$issueid/$filename",_WEBUSR_);
            chgrp(_FILES_."issues/$issueid/$filename",_WEBGRP_);

            logger($mime['filename']." uploaded to issue $issueid.","parser");
            issue_log($issueid,"File uploaded: ".$mime['filename'],FALSE,_PARSER_);

            $insert['file_type'] = "issues";
            $insert['typeid'] = $issueid;
            $insert['userid'] = _PARSER_;
            $insert['uploaded_on'] = $timestamp;
            $insert['name'] = $mime['filename'];
            $dbi->insert("files",$insert);
          }
        }
      }
    }
  }
}
/* }}} */

/* {{{ reject(&$parser,$message) */
// Used when mail is rejected by parser
// Send back the original message to user
function reject(&$parser,$message)
{
  if (empty($message)) {
    exit;
  }

  $message .= "\n\n";
  $message .= "Original Message:\n";
  $message .= "-----------------\n";
  $message .= "Subject: ".$parser->headers['subject']."\n\n";
  $message .= "Body:\n".$parser->body;

  $parser->subject("Issue Tracker Alert");
  $parser->to($parser->headers['from']);
  $parser->message($message);
  $parser->send();
  exit;
}
/* }}} */

// Read raw email from stdin
if ($fp = fopen("php://stdin","r")) {
  while (!feof($fp)) {
    $rawdata .= fgets($fp,1024);
  }
  fclose($fp);
}

$fp = fopen("/tmp/incoming-mail","w");
fwrite($fp,$rawdata);
fclose($fp);

// Pull current timestamp
$currtime = time();

// Retrieve public addresses
$groups = public_address();

// Initialize the mailer class and decode the incoming mail
$parser = new mailer($rawdata);

// Set the outgoing email address to the one given in config.php
$parser->set("email_from",_EMAIL_);

// Log the mail
maillog($parser);

// If a group was given then find out the group id
if (is_array($parser->args)) {
  if (array_key_exists("group",$parser->args)) {
    $sql  = "SELECT gid ";
    $sql .= "FROM groups ";
    $sql .= "WHERE LOWER(name) = LOWER('{$parser->args['group']}')";
    $gid = $dbi->fetch_one($sql);
    if (!empty($gid)) {
      $parser->args['group'] = $gid;
    } else {
      reject($parser,"The {$parser->args['group']} group does not exist.");
    }
  }
}

if (preg_match("/issue #",$parser->subject."/i") and !isset($parser->args['issue'])) {
   preg_match("/Issue\ #([0-9]+)/i",$parser->subject,$issue);
   $parser->args['issue'] = $issue[1];
}

// Check to see if this is a public email group
if (empty($parser->args['group'])) {
  if (is_array($parser->headers['to'])) {
    foreach ($parser->headers['to'] as $to) {
      if (in_array($to,$groups)) {
        $parser->args['group'] = array_search(strtolower($to),$groups);
        $parser->args['list'] = $to;
        $public = TRUE;
        break;
      }
    }
  } else {
    if (in_array($parser->headers['to'],$groups)) {
      $parser->args['group'] 
        = array_search(strtolower($parser->headers['to']),$groups);
      $parser->args['list'] = $parser->headers['to'];
      $public = TRUE;
    }
  }
}

// Check this here to avoid 
if (!empty($parser->args['issue'])) {
  $requester = issue_requester($parser->args['issue']);
  if ($parser->headers['from'] == $requester) {
    $public = TRUE;
    $valid = TRUE;
  }
}

// if we have a defined $gid then we are dealing with a
// public email group and do not need to deal with
// the authentication step
if ($public != TRUE) {
  $sql  = "SELECT userid,username,admin,active ";
  $sql .= "FROM users ";
  $sql .= "WHERE email='".trim($parser->headers['from'])."'";
  $data = $dbi->fetch_row($sql,"array");
  if (is_array($data)) {
    extract($data);
  } else {
    reject($parser,$parser->headers['from']." does not belong to a valid Issue-Tracker user.");
  }

  // Make sure this user account is active
  if ($active != "t") {
    reject($parser,"Your account has been suspended.");
  }

  // Pull the user's groups, if none, stop now
  $groups = user_groups($userid);
  if (!is_array($groups)) {
    reject($parser,"You do not belong to any groups within Issue-Tracker.");
  }
 
  // If we have a issueid then make sure this user belongs
  // to at least one of the groups in the issue
  if (!empty($parser->args['issue'])) {
    if (!can_view_issue($parser->args['issue'],$userid)) {
      reject($parser,"You do not have the correct permissions to update this issue.");
    } else {
      $valid = TRUE;
    }
  }

  // If a group was given then check to make sure
  // the user belongs to that group
  if (!empty($parser->args['group'])) {
    if (!in_array($parser->args['group'],$groups)) {
      reject($parser,"You do not belong to the ".group_name($parser->args['group'])." group.");
    }

    if (empty($parser->args['issue']) 
    and !permission_check("create_issues",$parser->args['group'],$userid)) {
      reject($parser,"You do not have permission to create issues in the ".group_name($parser->args['group'])." group.");
    }
  } else if (empty($parser->args['issue'])) {
    if (count($groups) > 1) {
      $message  = "You belong to multiple groups but did not specify which ";
      $message .= "group to create this issue in.  Please specify a group ";
      $message .= "by adding \"[Group=<group name>]\" to the subject.";
      reject($parser,$message);
    } else {
      $parser->args['group'] = $groups[0];
    }
  }
}

// Ok now we actually create/update the issue
if (empty($parser->args['issue'])) {
  list($registered) = fetch_status(TYPE_REGISTERED);

  $insert['gid'] = $parser->args['group'];
  $insert['status'] = $registered;
  $insert['opened_by'] = empty($userid) ? _PARSER_ : $userid;
  $insert['opened'] = $currtime;
  $insert['modified'] = $currtime;
  $insert['summary'] = $parser->headers['subject'];
  $insert['problem'] = $parser->body;
  $insert['severity'] = SEV_NORMAL;
  if ($parser->args['private'] == "true") {
    $insert['private'] = "t";
  }
  $issueid = $dbi->insert("issues",$insert,"issues_issueid_seq");
  unset($insert);
  if (!empty($issueid)) {
    $insert['issueid'] = $issueid;
    $insert['gid'] = $parser->args['group'];
    $insert['opened'] = $currtime;
    $dbi->insert("issue_groups",$insert);
    unset($insert);

    issue_log(
      $issueid,
      "Issue Registered",
      FALSE,
      !empty($userid) ? $userid : _PARSER_
    );

    if (empty($userid)) {
      $insert['issueid'] = $issueid;
      $insert['list'] = $parser->args['list'];
      $insert['requester'] = $parser->headers['from'];
      $dbi->insert("issue_requesters",$insert);
      unset($insert);
    }

    $sql  = "SELECT name,notes ";
    $sql .= "FROM groups ";
    $sql .= "WHERE gid='{$parser->args['group']}'";
    $data = $dbi->fetch_row($sql,"array");
    if (is_array($data)) {
      $subject = "[Issue=$issueid]";

      // Only perform the search and replace if TID is in the notes
	  if (preg_match("[TID]",$data['notes'])) {
        $message = str_replace("[TID]",$issueid,$data['notes']);
        $message = str_replace("[SUBJECT]",$parser->subject,$message);
        $message = str_replace("[COMPANY]",_COMPANY_,$message);
        #$message = str_replace("[EMAIL]",group_email($parser->args['group']),$message);
        $message = str_replace("[GROUP]",$data['name'],$message);
      }

      if (!empty($message)) {
        $parser->subject($subject);
        $parser->to($parser->headers['from']);
        $parser->message($message);
        $parser->send();
      }
    } 

    attach_files($issueid,$parser);
    #issue_notify($issueid);
  }
} else {
  // Make sure this issue exists
  if (!issue_exists($parser->args['issue'])) {
    reject($parser,"The issue number you tried to update (Issue #{$parser->args['issue']}) does not exist.");
  }
  
  // Check to see if its ok 
  if ($valid !== TRUE) {
    reject($parser,"You do not have permission to update issue {$parser->args['issue']}.");
  }

  // Check to see if the issue was closed
  if (closed($parser->args['issue'])) {
    reject($parser,"The issue you are trying to update (Issue #{$parser->args['issue']}) has been closed.");
  }

  // Pull the current issue information
  $issue = issue_details($parser->args['issue']);

  // Ok, start the update process
  // Check to see if status was given
  if (!empty($args['status'])) {
    $sql  = "SELECT sid,status,status_type ";
    $sql .= "FROM statuses ";
    $sql .= "WHERE LOWER(status)=LOWER('{$parser->args['status']}')";
    $status = $dbi->fetch_row($sql,"array");
    if (is_array($status)) {
      if ($status['status_type'] != TYPE_REGISTERED) {
        if ($status['sid'] != $issue['status']) {
          $update['status'] = $status['sid'];
          issue_log(
            $parser->args['issue'],
            "Status changed to {$status['status']}",
            FALSE,
            !empty($userid) ? $userid : _PARSER_
          );
        }
      }
    }
  }

  // Check to see if severity was given
  if (!empty($parser->args['severity'])) {
    $severity = array_search(ucwords($parser->args['severity']));
    if (!empty($severity)) {
      if ($severity != $issue['severity']) {
        $update['severity'] = $severity;
        issue_log(
          $parser->args['issue'],
          "Severity changed to {$parser->args['severity']}",
          FALSE,
          !empty($userid) ? $userid : _PARSER_
        );
      }
    }
  }

  // Check to see if a category was given
  if (!empty($parser->args['category'])) {
    $sql  = "SELECT cid,category ";
    $sql .= "FROM categories ";
    $sql .= "WHERE LOWER(category) = LOWER('{$parser->args['category']}')";
    $category = $dbi->fetch_row($sql,"array");
    if (is_array($category)) {
      if ($issue['category'] != $category['cid']) {
        $update['category'] = $category['cid'];
        issue_log(
          $parser->args['issue'],
          "Category changed to {$category['category']}",
          FALSE,
          !empty($userid) ? $userid : _PARSER_
        );
      }
    }
  }

  // Check to see if a category was given
  if (!empty($parser->args['product'])) {
    $sql  = "SELECT pid,product ";
    $sql .= "FROM products ";
    $sql .= "WHERE LOWER(product) = LOWER('{$parser->args['product']}')";
    $product = $dbi->fetch_row($sql,"array");
    if (is_array($product)) {
      if ($issue['product'] != $product['pid']) {
        $update['product'] = $product['pid'];
        issue_log(
          $parser->args['issue'],
          "Product changed to {$product['product']}",
          FALSE,
          !empty($userid) ? $userid : _PARSER_
        );
      }
    }
  }
  
  $update['modified'] = $currtime;
  $dbi->update("issues",$update,"WHERE issueid='{$parser->args['issue']}'");
  unset($update);

  // Insert new event
  $insert['performed_on'] = $currtime;
  $insert['userid'] = empty($userid) ? _PARSER_ : $userid;
  $insert['action'] = $parser->body;
  $insert['issueid'] = $parser->args['issue'];
  if (!empty($userid)) {
    if (issue_priv($parser->args['issue'],"technician",$userid)) {
      if (!empty($parser->args['duration'])) {
		 if (preg_match("([0-9]{1,}|[0-9]{1,}\.[0-9]{1,2})",$parser->args['duration'])) {
          $insert['duration'] = $parser->args['duration'];
        }
      }
      if (!empty($parser->args['private'])) {
        if ($parser->args['private'] == "true") {
          $insert['private'] = "t";
        }
      }
    }
  }
  $eid = $dbi->insert("events",$insert,"events_eid_seq");
  unset($insert);

  attach_files($parser->args['issue'],$parser);
  
  if (!empty($eid)) {
    #issue_notify($parser->args['issue']);
  } else {
    reject($parser,"There was a problem adding your event to issue {$parser->args['issue']}.");
  }
}
?>
