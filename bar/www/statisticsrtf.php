<?php
/**
 * View statistics as RTF
 * 
 * 
 * 1/22/2004 by Christian Ehret chris@uffbasse.de
 */
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();

include_once("../includes/fileselector.inc.php");
include_once('../includes/statisticsclass.inc.php');
$statistics = New Statistics;
include_once("../includes/barguestclass.inc.php");
$barguest = new Barguest;

$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";

$thecat1 = -1;
$thecat2 = -1;
$thecat3 = -1;
if ($request->GetVar('thecat1', 'get') !== $request->undefined) {
    $thecat1 = $request->GetVar('thecat1', 'get');
} 
if ($request->GetVar('thecat2', 'get') !== $request->undefined) {
    $thecat2 = $request->GetVar('thecat2', 'get');
} 
if ($request->GetVar('thecat3', 'get') !== $request->undefined) {
    $thecat3 = $request->GetVar('thecat3', 'get');
} 

if ($request->GetVar('start', 'get') !== $request->undefined) {
    $thestart = $request->GetVar('start', 'get');
} else {
    $thestart = $month . '/' . $year;
} 
if ($request->GetVar('start1', 'get') !== $request->undefined) {
    $thestart1 = $request->GetVar('start1', 'get');
} else {
    $thestart1 = $day . '/' . $month . '/' . $year;
} 
if ($request->GetVar('end', 'get') !== $request->undefined) {
    $theend = $request->GetVar('end', 'get');
} else {
    if ($month == 12) {
        $year = $year + 1;
        $month = 1;
    } else {
        $month = $month + 1;
    } 
    $theend = $month . '/' . $year;
} 
if ($request->GetVar('end1', 'get') !== $request->undefined) {
    $theend1 = $request->GetVar('end1', 'get');
} else {
    if ($month == 12) {
        $year = $year + 1;
        $month = 1;
    } else {
        $month = $month + 1;
    } 
    $theend1 = $day . '/' . $month . '/' . $year;
} 
if ($request->GetVar('thedate','get') !== $request->undefined) {
    $thedate = $request->GetVar('thedate','get');
}

$thestart = str_replace('-', '/', $thestart);
$theend = str_replace('-', '/', $theend);
$thestart1 = str_replace('-', '/', $thestart1);
$theend1 = str_replace('-', '/', $theend1);
$thedate = str_replace('-', '.', $thedate);

if ($request->GetVar('what','get') !== $request->undefined) {
    $what = $request->GetVar('what','get');
} else {
	$what = 'thedate';
}

if ($what == 'thedate') {
	list($day, $month, $year) = split('[.]', $thedate);
	$thestart = "$year-$month-$day 00:00:00";
	$theend = "$year-$month-$day 23:59:59";
    $statarr = $statistics->get($thestart, $theend, $thecat1);
	$rtfdate = "am $day.$month.$year";
} elseif ($what == 'timeline'){
	list($day, $month, $year) = split('[/]', $theend1);
	$theend = "$year-$month-$day 23:59:59";
	$rtfdate = "bis $day.$month.$year ";
	list($day, $month, $year) = split('[/]', $thestart1);
	$thestart = "$year-$month-$day 00:00:00";
	$rtfdate = "vom $day.$month.$year ".$rtfdate;
	$statarr = $statistics->get($thestart, $theend, $thecat2);
} else {
	list($month, $year) = split('[/]', $theend);
	$theend = "$year-$month-01 00:00:00";
	$rtfdate = "bis 01.$month.$year ";
	list($month, $year) = split('[/]', $thestart);
	$thestart = "$year-$month-01 00:00:00";
	$statarr = $statistics->get($thestart, $theend, $thecat3);
	$rtfdate = "vom 01.$month.$year ".$rtfdate;
}


	$table = '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrb\brdrw10\brdrs \cellx851\clbrdrb\brdrw10\brdrs \cellx4678\clbrdrb\brdrw10\brdrs \cellx5954\clbrdrb\brdrw10\brdrs \cellx7230\pard\intbl\nowidctlpar\b Anzahl\b0\cell\b Artikel\b0\cell\qr\b Einzelpreis\b0\cell\b Summe\b0\cell\row';
    for ($i = 0; $i < count($statarr); $i++) {
        if ($i == count($statarr)-1) {
		    $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrt\brdrw10\brdrs\brdrw10\brdrs \cellx851\clbrdrt\brdrw10\brdrs\brdrw10\brdrs \cellx4678\clbrdrt\brdrw10\brdrs\brdrw10\brdrs \cellx5954\clbrdrt\brdrw10\brdrs\brdrw10\brdrs \cellx7230\pard\intbl\nowidctlpar \cell\cell\pard\intbl\nowidctlpar\qr\b Summe: \b0\cell\b '.str_replace('.',',',$statarr[$i]['total']).' EUR\b0\cell\row\pard\nowidctlpar\par';		
        } else {
		    $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx851\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx4678\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx5954\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx7230\pard\intbl\nowidctlpar '. $statarr[$i]['num'] . '\cell '.$statarr[$i]['description'].'\cell\pard\intbl\nowidctlpar\qr '.str_replace('.',',',$statarr[$i]['price']).' EUR\cell '.str_replace('.',',',$statarr[$i]['total']).' EUR\cell\row';
        } 
    } 

// get RTF-Template
$tplfile = selectfile('tpl_statistics.rtf');
// $tplfile = 'C:\wwwroot\zvs\default\tpl_meldeschein.rtf';
$tplHandle = fopen($tplfile, 'r');
$tpl = fread($tplHandle, filesize($tplfile));
fclose($tplHandle);
// replace placeholders
$tpl = ereg_replace("%table%", $table, $tpl);
$tpl = ereg_replace("%date%", $rtfdate, $tpl); 
// show RTF-File
header("Cache-control: private");
header("Content-type: application/rtf");
header("Content-Disposition: attachment; filename=\"statistics.rtf\"");

echo $tpl;

?>