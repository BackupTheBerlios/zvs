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
* List receipts
* 
* Lists
* 
* @since 2004-02-25
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
$smarty->assign("tpl_title", "Rechnungen");
$smarty->assign('tpl_nav', 'lists');
$smarty->assign('tpl_subnav', 'receipt');
$smarty->assign('tpl_type', 'lists');

include_once("receiptclass.inc.php");
$receipt = New Receipt;

$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";
$theotherdate = "$day-$month-$year";

$threeweeksago = getdate(strtotime("-3 weeks"));
$threeweeksagoday = $threeweeksago['mday'];
$threeweeksagomonth = $threeweeksago['mon'];
$threeweeksagoyear = $threeweeksago['year'];
$threeweeksagothedate = "$threeweeksagoday.$threeweeksagomonth.$threeweeksagoyear";
$threeweeksagotheotherdate = "$threeweeksagoday-$threeweeksagomonth-$threeweeksagoyear";

$smarty->assign('tpl_dates', $receipt->getdates());
if ($request->GetVar('frm_start', 'post') !== $request->undefined) {
    $thestart = $request->GetVar('frm_start', 'post');
} else {
    $thestart = $month . '/' . $year;
} 
$theotherstart = str_replace('/', '-', $thestart);
if ($request->GetVar('frm_end', 'post') !== $request->undefined) {
    $theend = $request->GetVar('frm_end', 'post');
} else {
    if ($month == 12) {
        $year = $year + 1;
        $month = 1;
    } else {
        $month = $month + 1;
    } 
    $theend = $month . '/' . $year;
} 
$theotherend = str_replace('/', '-', $theend);
if ($request->GetVar('frm_newstart', 'post') == "true") {
    list($month, $year) = split('[/]', $thestart);
    $month = number_format($month, 0, '', '');
    $year = number_format($year, 0, '', '');
    if ($month == 12) {
        $year = $year + 1;
        $month = 1;
    } else {
        $month = $month + 1;
    } 
    $theend = $month . '/' . $year;
    $theotherend = $month . '-' . $year;
} 
if ($request->GetVar('frm_thedate', 'post') !== $request->undefined) {
    $thedate = $request->GetVar('frm_thedate', 'post');
} 

$theotherdate = str_replace('.', '-', $thedate);

if ($request->GetVar('frm_start1', 'post') !== $request->undefined) {
    $thestart1 = $request->GetVar('frm_start1', 'post');
} else {
    $thestart1 = $threeweeksagothedate;
} 

$theotherstart1 = str_replace('.', '-', $thestart1);

if ($request->GetVar('frm_end1', 'post') !== $request->undefined) {
    $theend1 = $request->GetVar('frm_end1', 'post');
} else {
    $theend1 = $thedate;
} 

$theotherend1 = str_replace('.', '-', $theend1);

if ($request->GetVar('frm_what', 'post') !== $request->undefined) {
    $what = $request->GetVar('frm_what', 'post');
} else {
    $what = 'timeline';
} 

$display = 'all';

$smarty->assign('tpl_what', $what);
$smarty->assign('tpl_theotherdate', $theotherdate);
$smarty->assign('tpl_thedate', $thedate);
$smarty->assign('tpl_theotherend', $theotherend);
$smarty->assign('tpl_theend', $theend);
$smarty->assign('tpl_theotherstart', $theotherstart);
$smarty->assign('tpl_thestart', $thestart);
$smarty->assign('tpl_start1', $thestart1);
$smarty->assign('tpl_theotherstart1', $theotherstart1);
$smarty->assign('tpl_end1', $theend1);
$smarty->assign('tpl_theotherend1', $theotherend1);

if ($what == 'thedate') {
    list($day, $month, $year) = split('[.]', $thedate);
    $thestart = "$year-$month-$day 00:00:00";
    $theend = "$year-$month-$day 23:59:59";
    if ($request->GetVar('frm_display', 'post') !== $request->undefined) {
        $display = $request->GetVar('frm_display', 'post');
    } 
    $smarty->assign('tpl_receipt', $receipt->getlist($thestart, $theend, $display));
} elseif ($what == 'timeline') {
    list($day, $month, $year) = split('[.]', $theend1);
    $theend1 = "$year-$month-$day 23:59:59";
    list($day, $month, $year) = split('[.]', $thestart1);
    $thestart1 = "$year-$month-$day 00:00:00";
    if ($request->GetVar('frm_display2', 'post') !== $request->undefined) {
        $display = $request->GetVar('frm_display2', 'post');
    } 
    $smarty->assign('tpl_receipt', $receipt->getlist($thestart1, $theend1, $display));
} else {
    list($month, $year) = split('[/]', $theend);
    $theend = "$year-$month-01 00:00:00";
    list($month, $year) = split('[/]', $thestart);
    $thestart = "$year-$month-01 00:00:00";
    if ($request->GetVar('frm_display3', 'post') !== $request->undefined) {
        $display = $request->GetVar('frm_display3', 'post');
    } 
    $smarty->assign('tpl_receipt', $receipt->getlist($thestart, $theend, $display));
} 

$smarty->assign('tpl_display', $display);
$smarty->display('list_receipt.tpl');

?>