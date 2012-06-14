<?php
/* $Id: style.prefs.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * @package Issue-Tracker
 * @subpackage Preferences
 */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
	exit;
}

$elements = array(
	"Default" => array(
		"fgcolor" => "fgcolor",
		"bgcolor" => "bgcolor"
	),
	"Table Headers" => array(
		"fgcolor" => "table_head_fgcolor",
		"bgcolor" => "table_head_bgcolor"
	),
	"Titlebars" => array(
		"fgcolor"	=> "titlebar_fgcolor",
		"bgcolor" => "titlebar_bgcolor"
	),
  "Sub Titles" => array(
    "fgcolor" => "subtitle_fgcolor",
    "bgcolor" => "subtitle_bgcolor"
  ),
  "Alternating Row 1" => array(
    "fgcolor" => "row1_fgcolor",
    "bgcolor" => "row1_bgcolor"
  ),
  "Alternating Row 2" => array(
    "fgcolor" => "row2_fgcolor",
    "bgcolor" => "row2_bgcolor"
  ),
	"Label Cells" => array(
		"fgcolor" => "label_fgcolor",
		"bgcolor" => "label_bgcolor"
	),
	"Data Cells" => array(
		"fgcolor" => "data_fgcolor",
		"bgcolor" => "data_bgcolor"
	),
	"Menu Items" => array(
		"fgcolor" => "menu_fgcolor",
		"bgcolor" => "menu_bgcolor"
	),
	"Submenu Items" => array(
		"fgcolor" => "submenu_fgcolor",
		"bgcolor" => "submenu_bgcolor"
	),
	"Error Messages" => array(
		"fgcolor" => "error_fgcolor",
		"bgcolor" => "error_bgcolor"
	)
);

if (file_exists(_THEMES_.$_SESSION['userid'].".theme.php")) {
  include(_THEMES_.$_SESSION['userid'].".theme.php");
} else {
  include(_THEMES_.$_SESSION['theme']."/theme.php");
}

if ($_GET['reset'] == "true") {
	if (file_exists(_THEMES_.$_SESSION['userid'].".theme.php")) {
	  unlink(_THEMES_.$_SESSION['userid'].".theme.php");
	}
  if (file_exists(_CSS_.$_SESSION['userid'].".css")) {
    unlink(_CSS_.$_SESSION['userid'].".css");
  }
  redirect("?module=prefs&action=style");
}

if ($_GET['submit'] == "true") {
	if ($_GET['predefined']) {
		if (file_exists(_THEMES_.$_SESSION['userid'].".theme.php")) {
	  	unlink(_THEMES_.$_SESSION['userid'].".theme.php");
		}
    if (file_exists(_CSS_.$_SESSION['userid'].".css")) {
      unlink(_CSS_.$_SESSION['userid'].".css");
    }
		$_SESSION['theme']		= $_POST['theme'];
		$update['theme']	= $_POST['theme'];
		$dbi->update("users",$update,"WHERE userid='".$_SESSION['userid']."'");
	} else {
		$theme_file = "<?php\n";
		$theme_file .= sprintf("\$%-24s = \"%s\";\n","font_size",$_POST['style_font_size']);
		$theme_file .= sprintf("\$%-24s = \"%s\";\n","font_unit",$_POST['style_font_unit']);
		$theme_file .= sprintf("\$%-24s = \"%s\";\n","font_family",$_POST['style_font_family']);
		$theme_file .= sprintf("\$%-24s = \"%s\";\n","border_color",$_POST['style_border_color']);
    $theme_file .= sprintf("\$%-24s = \"%s\";\n","link_hover",$_POST['style_link_hover']);
		$style_underline = $_POST['style_underline'] == "on" ? "TRUE" : "FALSE";
		$theme_file .= sprintf("\$%-24s = %s;\n","underline",$style_underline);

		foreach ($elements as $key => $val) {
			$theme_file .= sprintf("\$%-24s = \"%s\";\n",$val['fgcolor'],$_POST['style_'.$val['fgcolor']]);
			$theme_file .= sprintf("\$%-24s = \"%s\";\n",$val['bgcolor'],$_POST['style_'.$val['bgcolor']]);
		}
	
		$theme_file .= "?>";

		$fp = fopen(_THEMES_.$_SESSION['userid'].".theme.php","w");
		fwrite($fp,$theme_file);
		fclose($fp);

    if (!empty($_POST['imgext'])) {
      if (!empty($_SESSION['prefs']['imgext'])) {
        $update['value'] = $_POST['imgext'];
        $dbi->update("user_prefs",$update,"WHERE userid='".$_SESSION['userid']."' AND preference='imgext'");
        unset($update);
      } else {
        $insert['userid'] = $_SESSION['userid'];
        $insert['preference'] = "imgext";
        $insert['value'] = $_POST['imgext'];
        $dbi->insert("user_prefs",$insert);
        unset($insert);
      }
    }
	}
  redirect("?module=prefs&action=style");
} else {
	if ($dir = @opendir(_THEMES_)) {
		while (($file = readdir($dir)) !== false) {
			if ($file == "." or $file == ".." or $file == "CVS") {
				continue;
			}
			
			if (is_dir(_THEMES_.$file)
      and file_exists(_THEMES_.$file."/theme.php")
      and file_exists(_THEMES_.$file."/screen.css")
      and file_exists(_THEMES_.$file."/tpl")
      and is_dir(_THEMES_.$file."/tpl")) {
        $themes[] = $file;
			}
		}  
		closedir($dir);
    if (is_array($themes) and @count($themes) > 1) {
      $smarty->assign('themes',$themes);
      $smarty->display("prefs/themes.tpl");
    }
	}

  if (is_writable(_THEMES_)) {
    $links[] = array(
      "txt"  => "Reset to Defaults",
      "url"   => "?module=prefs&action=style&reset=true"
    );

    $smarty->assign('font_size',$font_size);
    $smarty->assign('font_unit',$font_unit);
    $smarty->assign('font_family',$font_family);
    $smarty->assign('border_color',$border_color);
    $smarty->assign('link_hover',$link_hover);
    $smarty->assign('underline',$underline);
    $smarty->assign('elements',$elements);
    
    foreach ($elements as $key => $val) {
      $values[$val['fgcolor']] = $$val['fgcolor'];
      $values[$val['bgcolor']] = $$val['bgcolor'];
    }

    $smarty->assign('values',$values);
    $smarty->display("prefs/style.tpl");
  }
}
?>
