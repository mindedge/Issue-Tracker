/* $Id: THEMES,v 1.3 2003/10/08 07:06:21 tuxmonkey Exp $ */

Issue-Tracker Themes
--------------------
  Creating a theme for Issue-Tracker should be relatively simple for anyone
that wants to try, and for those that create themes and want them included
with the main package just send them to me at tm@tuxmonkey.com and I'll take
a look at them :).  The easiest way to get started would be to take the
default Issue-Tracker theme and start modifying it to your tastes.  There
are 4 things that you must have for a complete theme:

  theme.php       - This file contains the basic color and font settings
                  for your theme, and is used to generate the final css
                  file used for the theme.  An example of what should be
                  in this file is as follows:

                  <?php
                  $font_size                = 8;
                  $font_unit                = "pt";
                  $font_family              = "Verdana, Arial, Helvetica, sans-serif";
                  $border_color             = "gray";
                  $link_hover               = "highlight";
                  $underline                = FALSE;
                  $fgcolor                  = "black";
                  $bgcolor                  = "white";
                  $table_head_fgcolor       = "black";
                  $table_head_bgcolor       = "#666666";
                  $titlebar_fgcolor         = "white";
                  $titlebar_bgcolor         = "#336699";
                  $subtitle_fgcolor         = "white";
                  $subtitle_bgcolor         = "#333333";
                  $row1_fgcolor             = "black";
                  $row1_bgcolor             = "#white";
                  $row2_fgcolor             = "black";
                  $row2_bgcolor             = "#dddddd";
                  $label_fgcolor            = "black";
                  $label_bgcolor            = "#999999";
                  $data_fgcolor             = "black";
                  $data_bgcolor             = "#cccccc";
                  $menu_fgcolor             = "black";
                  $menu_bgcolor             = "#999999";
                  $submenu_fgcolor          = "black";
                  $submenu_bgcolor          = "#cccccc";
                  $error_fgcolor            = "red";
                  $error_bgcolor            = "#cccccc";
                  ?>


  screen.css      - This file is basically a CSS template that will be used
                  to generate the final css file used for the theme.  It
                  should look exactly like a standard CSS file but with
                  the above variables in placed where needed.


  images.php      - This file should contain the $_ENV['imgs'] array for your
                  theme.  This array is what determines what images are used
                  for things like severity icons, buttons, etc.  As of v4.0
                  the array should look something like this:
            
                  $_ENV['imgs'] = array(
                    "announce"      => "themes/default/images/announce.png",
                    "back"          => "themes/default/images/back.png",
                    "category"      => "themes/default/images/category.png",
                    "debug"         => "themes/default/images/debug.png",
                    "deescalate"    => "themes/default/images/deescalate.png",
                    "delete"        => "themes/default/images/delete.png",
                    "edit"          => "themes/default/images/edit.png",
                    "email"         => "themes/default/images/email.png",
                    "escalate"      => "themes/default/images/escalate.png",
                    "file"          => "themes/default/images/file.png",
                    "group"         => "themes/default/images/group.png",
                    "help"          => "themes/default/images/help.png",
                    "hide_closed"   => "themes/default/images/hide_closed.png",
                    "high"          => "themes/default/images/high.png",
                    "issue_log"     => "themes/default/images/issue_log.png",
                    "logo"          => "themes/default/images/logo.png",
                    "low"           => "themes/default/images/low.png",
                    "motd"          => "themes/default/images/motd.png",
                    "move"          => "themes/default/images/move.png",
                    "new_announce"  => "themes/default/images/new_announce.png",
                    "new_group"     => "themes/default/images/new_group.png",
                    "new_issue"     => "themes/default/images/new_issue.png",
                    "new_user"      => "themes/default/images/new_user.png",
                    "no"            => "themes/default/images/no.png",
                    "normal"        => "themes/default/images/normal.png",
                    "ok"            => "themes/default/images/ok.png",
                    "permission"    => "themes/default/images/permission.png",
                    "print"         => "themes/default/images/print.png",
                    "private_event" => "themes/default/images/private_event.png",
                    "private"       => "themes/default/images/private.png",
                    "product"       => "themes/default/images/product.png",
                    "public"        => "themes/default/images/public.png",
                    "search"        => "themes/default/images/search.png",
                    "show_closed"   => "themes/default/images/show_closed.png",
                    "status"        => "themes/default/images/status.png",
                    "style"         => "themes/default/images/style.png",
                    "subscribe"     => "themes/default/images/subscribe.png",
                    "system"        => "themes/default/images/system.png",
                    "unsubscribe"   => "themes/default/images/unsubscribe.png",
                    "urgent"        => "themes/default/images/urgent.png",
                    "user"          => "themes/default/images/user.png"
                  );

                  Where each element should point to the image that your theme
                  uses.  If your theme does not have its own images then you
                  can simply copy the images.php file right from the default
                  theme and the default images should be used.


  tpl directory   - This is the directory where all the actual html templates
                  should be located.  As of v4, Issue-Tracker uses the Smarty
                  template engine (http://smarty.php.net), so take a look at
                  the documentation for Smarty on how to create templates. The
                  number of templates used by Issue-Tracker is quite large so
                  I would recommend that you start your theme by copying the
                  tpl directory from the default theme and work from there.



  Ok, so that covers the minimum needed for a complete theme, but there are
also a couple of other things you can include in your theme to customize it
a little more.  Here is a list of optional things you can include in your
theme.

  functions.php   - This file should consist of custom template functions used
                  in your theme.  See the Smarty documentation on how to
                  create and register custom template functions.


  screen-ns4.css  - This file is the same as screen.css but will only be used
                  if someone logs in using the ancient Netscape 4 browser.

  That should about cover what a theme actually consists of.  Now for how to
install your themes.  Simply create a director inside the main issue-tracker
themes directory and place all your theme files inside of it.  Its that easy.
Once all the files are copied to the directory you can goto "Themes & Colors"
inside Issue-Tracker and you should see your theme in the predefined themes
dropdown box.  If you dont see it there, make sure all the required files
are present in the directory.
  If you have any questions please email me at tm@tuxmonkey.com
