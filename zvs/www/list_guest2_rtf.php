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
* list of guests in a time period as RTF
* 
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();

include_once("../includes/fileselector.inc.php");

include_once('guestlistclass.inc.php');
$guestlist = New Guestlist;
$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";
$bcat = -1;
if ($request->GetVar('bcat','get') !== $request->undefined) {
    $bcat = $request->GetVar('bcat','get');
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
    $thestart = mktime(0, 0, 0, $month, $day, $year);
    $theend = mktime(23, 59, 59, $month, $day, $year);
    $statarr = $guestlist->getlist($thestart, $theend, $bcat);
} elseif ($what == 'timeline'){
	list($day, $month, $year) = split('[/]', $theend1);
	$theend = mktime(23, 59, 59, $month, $day, $year);
	$rtfdate = "bis $day.$month.$year ";
	list($day, $month, $year) = split('[/]', $thestart1);
	$thestart = mktime(0, 0, 0, $month, $day, $year);
	$rtfdate = "vom $day.$month.$year ".$rtfdate;
	$statarr = $guestlist->getlist($thestart, $theend, $bcat);
} else {
	list($month, $year) = split('[/]', $theend);
	$theend = mktime(0, 0, 0, $month, 1, $year);
	list($month, $year) = split('[/]', $thestart);
	$thestart = mktime(0, 0, 0, $month, 1, $year);
	$statarr = $guestlist->getlist($thestart, $theend, $bcat);
}
$children0 = $request->GetVar('children0', 'session');
$children1 = $request->GetVar('children1', 'session');
$children2 = $request->GetVar('children2', 'session');
$children3 = $request->GetVar('children3', 'session');

//	$table = '\trowd\trgaph70\trleft-108\trrh513\trbrdrl\brdrs\brdrw15\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx1172\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx2453\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx3734\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx5013\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx6293\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx7573\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx8900\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx10227\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx11192\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx12157\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx13122\pard';
	$table .= '\trowd\trgaph70\trleft-108\trrh513\trbrdrl\brdrs\brdrw15\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx1172\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx2453\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx3734\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx5013\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx6293\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx7573\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx8900\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx10227\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx11192\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx12157\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx13122\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx14087\pard';
//    $table .= '\intbl\nowidctlpar\b\fs22 Zimmer\cell Nachname\cell Vorname\cell von\cell bis\cell Buchungs-kategorie\cell Buchungs-status\cell Erwachsene\cell '.$children0.'\cell '.$children1.'\cell '.$children2.'\cell '.$children3.'\cell\row\trowd\trgaph70\trleft-108\trrh256\trbrdrl\brdrs\brdrw15\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx1172\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx2453\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx3734\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx5013\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx6293\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx7573\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx8900\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx10227\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx11192\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx12157\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx13122\pard';
	$table .= '\intbl\nowidctlpar\b\fs22 Zimmer\cell Nachname\cell Vorname\cell von\cell bis\cell Buchungs-kategorie\cell Buchungs-status\cell Erwachsene\cell '.$children0.'\cell '.$children1.'\cell '.$children2.'\cell '.$children3.'\cell\row\trowd\trgaph70\trleft-108\trrh256\trbrdrl\brdrs\brdrw15\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx1172\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx2453\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx3734\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx5013\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx6293\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx7573\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx8900\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx10227\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx11192\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx12157\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx13122\clbrdrt\brdrw15\brdrs\brdrcf1 \cellx14087\\pard';
    for ($i = 0; $i < count($statarr); $i++) {
        $table .= '\intbl\nowidctlpar\b0 '.$statarr[$i]['room'].'\cell '.$statarr[$i]['lastname'].'\cell '.$statarr[$i]['firstname'].'\cell '.$statarr[$i]['startdate'].'\cell '.$statarr[$i]['enddate'].'\cell '.$statarr[$i]['bookingcat'].'\cell '.$statarr[$i]['bookingtype'].'\cell '.$statarr[$i]['person'].'\cell '.$statarr[$i]['children0'].'\cell '.$statarr[$i]['children1'].'\cell '.$statarr[$i]['children2'].'\cell '.$statarr[$i]['children3'].'\cell\row\pard';
    } 

	$table .= '\nowidctlpar\par';
 
// get RTF-Template
$tplfile = selectfile('tpl_guest.rtf');

$tplHandle = fopen($tplfile, 'r');
$tpl = fread($tplHandle, filesize($tplfile));
fclose($tplHandle);
// replace placeholders
$tpl = ereg_replace("%table%", $table, $tpl);
$tpl = ereg_replace("%date%", date("d.m.Y"), $tpl); 
// show RTF-File
header("Cache-control: private");
header("Content-type: application/rtf");
header("Content-Disposition: attachment; filename=\"guests.rtf\"");

echo $tpl;

?>