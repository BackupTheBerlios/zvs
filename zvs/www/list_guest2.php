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
* list of guests in a time period
* 
* guest
* 
* @since 2004-05-06
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('guestlistclass.inc.php');
$smarty->assign("tpl_title", "Anwesenheitsliste");
$smarty->assign('tpl_nav', 'lists');
$smarty->assign('tpl_type', 'lists');
$smarty->assign('tpl_subnav', 'guestlist2');
$smarty->assign('tpl_children1_field', $request->GetVar('children1', 'session'));
$smarty->assign('tpl_children2_field', $request->GetVar('children2', 'session'));
$smarty->assign('tpl_children3_field', $request->GetVar('children3', 'session'));

$guestlist = New Guestlist;
include_once('bookingcategoryclass.inc.php');
$bcat = New BookingCategory;

$smarty->assign('tpl_bookcat', $bcat->get());
$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";
$theotherdate = "$day-$month-$year";

$smarty->assign('tpl_dates', $guestlist->getdates());
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
} 

$theotherstart1 = str_replace('.', '-', $thestart1);

if ($request->GetVar('frm_end1', 'post') !== $request->undefined) {
    $theend1 = $request->GetVar('frm_end1', 'post');
} 

$theotherend1 = str_replace('.', '-', $theend1);

if ($request->GetVar('frm_what', 'post') !== $request->undefined) {
    $what = $request->GetVar('frm_what', 'post');
} else {
    $what = 'thedate';
} 


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
$thebcat = -1;
if ($what == 'thedate') {
    list($day, $month, $year) = split('[.]', $thedate);
    $thestart = mktime(0, 0, 0, $month, $day, $year);
    $theend = mktime(23, 59, 59, $month, $day, $year);
    if ($request->GetVar('frm_bookcat1', 'post') !== $request->undefined) {
        $thebcat = $request->GetVar('frm_bookcat1', 'post');
    } 	
    $smarty->assign('tpl_guests', $guestlist->getlist($thestart, $theend, $thebcat));
} elseif ($what == 'timeline') {
    list($day, $month, $year) = split('[.]', $theend1);
    $theend1 = mktime(23, 59, 59, $month, $day, $year);
    list($day, $month, $year) = split('[.]', $thestart1);
    $thestart1 = mktime(0, 0, 0, $month, $day, $year);
    if ($request->GetVar('frm_bookcat2', 'post') !== $request->undefined) {
        $thebcat = $request->GetVar('frm_bookcat2', 'post');
    } 		
    $smarty->assign('tpl_guests', $guestlist->getlist($thestart1, $theend1, $thebcat));
} else {
    list($month, $year) = split('[/]', $theend);
    $theend = mktime(0, 0, 0, $month, 1, $year);
    list($month, $year) = split('[/]', $thestart);
    $thestart = mktime(0, 0, 0, $month, 1, $year);
    if ($request->GetVar('frm_bookcat3', 'post') !== $request->undefined) {
        $thebcat = $request->GetVar('frm_bookcat3', 'post');
    } 		
    $smarty->assign('tpl_guests', $guestlist->getlist($thestart, $theend, $thebcat));
} 
$smarty->assign('tpl_thebookcat',$thebcat);

$smarty->display('list_guest2.tpl');

?>
