<?php
/**
 * Update a user's preference
 *
 * @param integer $userid ID of user
 * @param string $pref Preference to update
 * @param mixed $value Value to assign to preference
 */
function update_preference($userid,$pref,$value)
{
  global $dbi;

  $pref = trim($pref);

  $sql  = "SELECT value ";
  $sql .= "FROM user_prefs ";
  $sql .= "WHERE userid='{$userid}' ";
  $sql .= "AND preference='{$pref}'";
  $curr_value = $dbi->fetch_one($sql);
  if (!empty($curr_value)) {
    // if the preference exists then update
    $update['value'] = $value;
    $dbi->update("user_prefs",$update,"WHERE userid='{$userid}' AND preference='{$pref}'");
    unset($update);
  } else {
    // otherwise insert a new record
    $insert['userid'] = $userid;
    $insert['preference'] = $pref;
    $insert['value'] = $value;
    $dbi->insert("user_prefs",$insert);
    unset($insert);
  }

  // check to see if we have a session
  if (!empty($_SESSION['userid'])) {
    // if we did, then check to see if this is the current user
    if ($_SESSION['userid'] == $userid) {
      $_SESSION['prefs'][$pref] = $value;
    }
  }
}
?>
