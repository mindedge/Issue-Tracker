<?php
/* $Id: funcs.php 2 2004-08-05 21:42:03Z eroberts $ */

if (preg_match("/".basename(__FILE__)."/i",$_SERVER['PHP_SELF'])) {
  print "Direct module access forbidden.";
  exit;
}

/* {{{ Function: generate_report */
/**
 * Generate report for given group
 *
 * @param integer $gid ID of group
 * @param integer $sdate Start Date (unix timestamp)
 * @param integer $edate End Date (unix timestamp)
 */
function generate_report($gid,$sdate = null,$edate = null)
{
  global $dbi,$smarty;

  $smarty->assign('report_title',group_name($gid)." Report");

  if (is_array($_POST['options'])) {
    include(_REPORTS_."reports/per_category.php");
    include(_REPORTS_."reports/per_status.php");
    include(_REPORTS_."reports/per_product.php");
    include(_REPORTS_."reports/per_severity.php");
    include(_REPORTS_."reports/per_technician.php");
    include(_REPORTS_."reports/avg_close.php");
    include(_REPORTS_."reports/max_close.php");
    include(_REPORTS_."reports/avg_first.php");
    include(_REPORTS_."reports/max_first.php");
    include(_REPORTS_."reports/num_hours.php");
    include(_REPORTS_."reports/num_events.php");
    include(_REPORTS_."reports/num_opened.php");
    include(_REPORTS_."reports/num_resolved.php");
    include(_REPORTS_."reports/escalated_to.php");
    include(_REPORTS_."reports/escalated_from.php");
  }

  if ($_POST['display_issues'] == "on") {
    include(_REPORTS_."reports/display_issues.php");
  }

  $smarty->display("reports/report.tpl");
}
/* }}} */

/* {{{ Function: generate_tech_report */
/**
 * Generate report for given tech/user
 *
 * @param integer $userid ID of user
 * @param integer $sdate Start Date (unix timestamp)
 * @param integer $edate End Date (unix timestamp)
 */
function generate_tech_report($userid,$sdate = null,$edate = null)
{
  global $dbi,$smarty;

  $smarty->assign('report_title',"Report for user: ".username($userid));

  if (is_array($_POST['options'])) {
    include(_REPORTS_."reports/per_category.php");
    include(_REPORTS_."reports/per_status.php");
    include(_REPORTS_."reports/per_product.php");
    include(_REPORTS_."reports/per_severity.php");
    include(_REPORTS_."reports/per_technician.php");
    include(_REPORTS_."reports/avg_close.php");
    include(_REPORTS_."reports/max_close.php");
    include(_REPORTS_."reports/avg_first.php");
    include(_REPORTS_."reports/max_first.php");
    include(_REPORTS_."reports/num_hours.php");
    include(_REPORTS_."reports/num_events.php");
    include(_REPORTS_."reports/num_opened.php");
    include(_REPORTS_."reports/num_resolved.php");
  }

  if ($_POST['display_issues'] == "on") {
    include(_REPORTS_."reports/display_issues.php");
  }

  $smarty->display("reports/report.tpl");
}
/* }}} */

/* {{{ Function: hbar_graph */
/**
 * Generates a horizontal bar graph from given data
 *
 * @param string $title Title of graph
 * @param array $data Data to be plot, each key will be used as the label
 */
function hbar_graph($title,$data)
{
  if (!is_array($data) or count($data) < 1) {
    return;
  }

  include_once(_JPGRAPH_."jpgraph.php");
  include_once(_JPGRAPH_."jpgraph_bar.php");

  $filename = str_replace("\n","_",$title).".png";
  $filename = str_replace("/","-",$filename);
  $filename = _GRAPHS_.str_replace(" ","_",$filename);

  if (file_exists($filename)
  and filemtime($filename) < _HOUR_) {
    return str_replace(_PATH_."/",_URL_,$filename);
  }
  
  $names = array();
  $items = array();

  foreach ($data as $key => $val) {
    array_push($names,$key);
    array_push($items,$val);
    $high = $val > $high ? $val : $high;
    $longest = strlen($key) > $longest ? strlen($key) : $longest;
  }

  if (count($names) > 20) {
    $height = count($names) * 30;
  } else {
    $height = 480;
  }

  // Setup the graph. 
  $graph = new Graph(640,$height,"auto");	
  $graph->SetScale("textint");

  if (count($names) > 20) {
    if ($high >= 4) {
      $graph->xaxis->scale->SetGrace(20);
    } else {
      $graph->xaxis->scale->SetGrace(50);
    }
    $graph->Set90AndMargin(($longest * 5) + 50,20,50,10);
    $graph->xaxis->SetTickLabels($names);
    $graph->title->SetFont(FF_FONT2,FS_NORMAL);
    $graph->title->Set($title);
    $graph->title->SetColor('black');
    $graph->xaxis->SetFont(FF_FONT1,FS_NORMAL);
    $graph->yaxis->SetFont(FF_FONT1,FS_NORMAL);
    $bplot = new BarPlot($items);
    $bplot->value->SetColor("black");
    $bplot->value->SetFont(FF_FONT1,FS_NORMAL);
    $bplot->value->SetFormat("%3d");
    $bplot->value->SetAlign("right","center");
  } else {
    if ($high >= 4) {
      $graph->yaxis->scale->SetGrace(20);
    } else {
      $graph->yaxis->scale->SetGrace(50);
    }
    $graph->xaxis->SetLabelAngle(90);
    $graph->SetMargin(50,20,20,($longest * 5) + 50);
    $graph->xaxis->SetTickLabels($names);
    $graph->title->SetFont(FF_FONT2,FS_NORMAL);
    $graph->title->Set($title);
    $graph->title->SetColor('black');
    $graph->xaxis->SetFont(FF_FONT1,FS_NORMAL);
    $graph->yaxis->SetFont(FF_FONT1,FS_NORMAL);
    $bplot = new BarPlot($items);
    $bplot->value->SetColor("black");
    $bplot->value->SetFont(FF_FONT1,FS_NORMAL);
    $bplot->value->SetFormat("%3d");
    $bplot->value->SetAlign("center","bottom");
  }
  
  $bplot->value->Show();
  $bplot->SetWidth(0.5);

  // Setup color for gradient fill style 
  $bplot->SetFillGradient("#336699","white",GRAD_HOR);

  // Set color for the frame of each bar
  $bplot->SetColor("black");
  $graph->Add($bplot);

  // Finally send the graph to the browser
  $graph->Stroke($filename);
  return str_replace(_PATH_."/",_URL_,$filename);
}
/* }}} */
?>
