<?php
/**
* Copyright notice
* 
*   (c) 2003-2004 Christian Ehret (chris@ehret.name)
*   All rights reserved
* 
*   This script is part of the ZVS project. The ZVS project is 
*   free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
* 
*   The GNU General Public License can be found at
*   http://www.gnu.org/copyleft/gpl.html.
*   A copy is found in the textfile GPL.txt and important notices to the license 
*   from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*   This script is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
* 
*   This copyright notice MUST APPEAR in all copies of the script!
*/

/**
* income list as csv
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();

include_once("accountclass.inc.php");
$account = New Account;

$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";

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
if ($request->GetVar('thedate', 'get') !== $request->undefined) {
    $thedate = $request->GetVar('thedate', 'get');
} 

$thestart = str_replace('-', '/', $thestart);
$theend = str_replace('-', '/', $theend);
$thestart1 = str_replace('-', '/', $thestart1);
$theend1 = str_replace('-', '/', $theend1);
$thedate = str_replace('-', '.', $thedate);

if ($request->GetVar('what', 'get') !== $request->undefined) {
    $what = $request->GetVar('what', 'get');
} else {
    $what = 'thedate';
} 
$paycat = -1;
if ($request->GetVar('paycat', 'get') !== $request->undefined) {
    $paycat = $request->GetVar('paycat', 'get');
} 
if ($what == 'thedate') {
    list($day, $month, $year) = split('[.]', $thedate);
    $thestart = "$year-$month-$day 00:00:00";
    $theend = "$year-$month-$day 23:59:59";
    $statarr = $account->getlist($thestart, $theend, $paycat);
} elseif ($what == 'timeline') {
    list($day, $month, $year) = split('[/]', $theend1);
    $theend = "$year-$month-$day 23:59:59";
    $rtfdate = "bis $day.$month.$year ";
    list($day, $month, $year) = split('[/]', $thestart1);
    $thestart = "$year-$month-$day 00:00:00";
    $rtfdate = "vom $day.$month.$year " . $rtfdate;
    $statarr = $account->getlist($thestart, $theend, $paycat);
} else {
    list($month, $year) = split('[/]', $theend);
    $theend = "$year-$month-01 00:00:00";
    list($month, $year) = split('[/]', $thestart);
    $thestart = "$year-$month-01 00:00:00";
    $statarr = $account->getlist($thestart, $theend, $paycat);
} 

$tpl = "\"Datum:\";\"Zahlungskategorie:\";\"Beschreibung:\";\"Betrag:\";\"Name:\";\"Vorname:\";\"Rechnungsnummer:\";\"Rechnungsdatum:\";
";

for ($i = 0; $i < count($statarr); $i++) {
    $tpl .= $statarr[$i]['date_payment'] . ";" . $statarr[$i]['paycat'] . ";" . $statarr[$i]['description'] . ";" . str_replace('.', ',', $statarr[$i]['amount']) . ";" . $statarr[$i]['lastname'] . ";" . $statarr[$i]['firstname'] . ";" . $statarr[$i]['receipt_reference_id'] . ";" . $statarr[$i]['receipt_date'] . ";
";
} 
// show CSV
header("Cache-control: private");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=\"income.csv\"");
echo $tpl;

?>