<?php
if (@$_SESSION['prefs']['imgext'] == "gif" or preg_match("/(4.7)|(4.8)/",$_SERVER['HTTP_USER_AGENT'])) {
  define("IMGDIR","themes/default/images/gif/");
  $imgext = "gif";
} else {
  define("IMGDIR","themes/default/images/png/");
  $imgext = "png";
}

/**
 * Available image extensions for this theme
 * format:
 *  ext => comment
 */
$_ENV['image_exts'] = array(
  "png" => "Look better, but load slower in Internet Explorer",
  "gif" => "",
);

$_ENV['imgs'] = array(
  "announce"      => IMGDIR."announce.$imgext",
  "back"          => IMGDIR."back.$imgext",
  "category"      => IMGDIR."category.$imgext",
  "debug"         => IMGDIR."debug.$imgext",
  "deescalate"    => IMGDIR."deescalate.$imgext",
  "delete"        => IMGDIR."delete.$imgext",
  "edit"          => IMGDIR."edit.$imgext",
  "email"         => IMGDIR."email.$imgext",
  "escalate"      => IMGDIR."escalate.$imgext",
  "file"          => IMGDIR."file.$imgext",
  "group"         => IMGDIR."group.$imgext",
  "help"          => IMGDIR."help.$imgext",
  "hide_closed"   => IMGDIR."hide_closed.$imgext",
  "high"          => IMGDIR."high.$imgext",
  "issue_log"     => IMGDIR."issue_log.$imgext",
  "logo"          => IMGDIR."logo4.$imgext",
  "low"           => IMGDIR."low.$imgext",
  "motd"          => IMGDIR."motd.$imgext",
  "move"          => IMGDIR."move.$imgext",
  "new_announce"  => IMGDIR."new_announce.$imgext",
  "new_group"     => IMGDIR."new_group.$imgext",
  "new_issue"     => IMGDIR."new_issue.$imgext",
  "new_user"      => IMGDIR."new_user.$imgext",
  "no"            => IMGDIR."no.$imgext",
  "normal"        => IMGDIR."normal.$imgext",
  "ok"            => IMGDIR."ok.$imgext",
  "permission"    => IMGDIR."permission.$imgext",
  "print"         => IMGDIR."print.$imgext",
  "private_event" => IMGDIR."private_event.$imgext",
  "private"       => IMGDIR."private.$imgext",
  "product"       => IMGDIR."product.$imgext",
  "public"        => IMGDIR."public.$imgext",
  "search"        => IMGDIR."search.$imgext",
  "show_closed"   => IMGDIR."show_closed.$imgext",
  "status"        => IMGDIR."status.$imgext",
  "style"         => IMGDIR."style.$imgext",
  "subscribe"     => IMGDIR."subscribe.$imgext",
  "system"        => IMGDIR."system.$imgext",
  "unsubscribe"   => IMGDIR."unsubscribe.$imgext",
  "urgent"        => IMGDIR."urgent.$imgext",
  "user"          => IMGDIR."user.$imgext"
);
?>
