<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003-2004 Christian Ehret (chris@ehret.name)
*  All rights reserved
*
*  This script is part of the ZVS project. The ZVS project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Statistics
* 
* 12/07/2004 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once("jpgraph.php");
include_once("jpgraph_bar.php");
include_once('statisticsclass.inc.php');
$statistics = New Statistics;

$what = $request->GetVar('what','session');
$thedate = $request->GetVar('thedate', 'session');
$theend1 = $request->GetVar('theend1', 'session');
$thestart1 = $request->GetVar('thestart1', 'session');
$theend = $request->GetVar('theend', 'session');
$thestart = $request->GetVar('thestart', 'session');
$thecat1 = $request->GetVar('thecat1', 'session');
$thecat2 = $request->GetVar('thecat2', 'session');
$thecat3 = $request->GetVar('thecat3', 'session');

if ($what == 'thedate') {
    list($day, $month, $year) = split('[.]', $thedate);
    $thestart = "$year-$month-$day 00:00:00";
    $theend = "$year-$month-$day 23:59:59";
    $data = $statistics->get($thestart, $theend, $thecat1);
	$timeline = "vom $day.$month.$year";
} elseif ($what == 'timeline') {
    list($day, $month, $year) = split('[.]', $theend1);
    $theend1 = "$year-$month-$day 23:59:59";
	$timeline = "vom $day.$month.$year ";
    list($day, $month, $year) = split('[.]', $thestart1);
    $thestart1 = "$year-$month-$day 00:00:00";
    $data = $statistics->get($thestart1, $theend1, $thecat2);
	$timeline .= "bis $day.$month.$year ";
} else {
    list($month, $year) = split('[/]', $theend);
    $theend = "$year-$month-01 00:00:00";
	$timeline = "vom 1.$month.$year ";
    list($month, $year) = split('[/]', $thestart);
    $thestart = "$year-$month-01 00:00:00";
    $data = $statistics->get($thestart, $theend, $thecat3);
	$timeline .= "bis 1.$month.$year ";	
} 

for ($i=0; $i<count($data); $i++){
 $labels[$i]= $data[$i]['description'];
 $gdata[$i] = $data[$i]['num'];
}

$graph = new Graph(700, 500, "auto");
$graph->SetColor("white");
$graph->SetFrame(false);
$graph->SetScale("textlin");

$graph->title->Set("Verkaufte Artikel $timeline");
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->SetLabelAngle(90); 
$graph->xaxis->title->Set("Artikel");
$graph->yaxis->title->Set("Stückzahl");
$graph->yaxis->SetTitleMargin(45);
$graph->xaxis->SetTickLabels($labels);
$graph->img->SetMargin(60, 40, 40, 150);

$barplot = new BarPlot($gdata);
$barplot->SetColor(array("red", "green", "blue", "gray", "yellow"));
$barplot->SetFillColor(array("red", "green", "blue", "gray", "yellow"));

$graph->Add($barplot);

$graph->Stroke();

?>
