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
* View "meldeschein" as RTF
* 
* Calendar
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();
include_once('../includes/bookingclass.inc.php');
include_once("../includes/fileselector.inc.php");

$booking = New Booking;

$bookid = $request->GetVar('bookid', 'get');
$bookdata = $booking->getMeldedata($bookid);
// get RTF-Template
$tplfile = selectfile('tpl_meldeschein.rtf');
// $tplfile = 'C:\wwwroot\zvs\default\tpl_meldeschein.rtf';
$tplHandle = fopen($tplfile, 'r');
$tpl = fread($tplHandle, filesize($tplfile));
fclose($tplHandle);
// replace placeholders
$tpl = ereg_replace("%arrival%", $bookdata[nicestart], $tpl);
$tpl = ereg_replace("%depature%", $bookdata[niceend], $tpl);
$tpl = ereg_replace("%name1%", $bookdata[lastname], $tpl);
$tpl = ereg_replace("%firstname1%", $bookdata[firstname], $tpl);
$birthday = "";
if ($bookdata[birthdate] !== "00.00.0000") {
    $birthday = $bookdata[birthdate];
} 
$tpl = ereg_replace("%birthday1%", $birthday, $tpl);
$tpl = ereg_replace("%birthplace1%", $bookdata[birthplace], $tpl);
$tpl = ereg_replace("%nationality1%", $bookdata[nationality], $tpl);
$identity = "";
if ($bookdata[passport] != "") {
    if ($bookdata[identity] == 'P') {
        $identity = "Personalausweis-Nummer: ";
    } else if ($bookdata[identity] == 'R') {
        $identity = "Reisepass-Nummer: ";
    } else if ($bookdata[identity] == 'F') {
        $identity = "Führerschein-Nummer: ";
    } 
} 
$tpl = ereg_replace("%identity1%", $identity . $bookdata[passport], $tpl);
$tpl = ereg_replace("%agency1%", $bookdata[agency], $tpl);
if ($bookdata[agency] != "" || $bookdata[issue_date] != "") {
    $issue_date = ", " . $bookdata[issue_date];
} else {
    $issue_date = $bookdata[issue_date];
} 
$tpl = ereg_replace("%issue_date1%", $issue_date, $tpl);
$tpl = ereg_replace("%zip1%", $bookdata[zip], $tpl);
$tpl = ereg_replace("%city1%", $bookdata[city], $tpl);
$tpl = ereg_replace("%street1%", $bookdata[street], $tpl);
$tpl = ereg_replace("%country1%", $bookdata[country], $tpl);
$tpl = ereg_replace("%children%", $bookdata[children], $tpl);
// show RTF-File
header("Cache-control: private");
header("Content-type: application/rtf");
header("Content-Disposition: attachment; filename=\"meldeschein.rtf\"");

echo $tpl;

?>