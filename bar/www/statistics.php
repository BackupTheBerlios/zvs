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
* 01/19/2004 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('statisticsclass.inc.php');
$statistics = New Statistics;
include_once("../includes/barguestclass.inc.php");
$barguest = new Barguest;
include_once("../includes/articlecatclass.inc.php");
$cat = new Articlecat;
$smarty->assign("tpl_title", "Statistiken");
$smarty->assign('tpl_nav', 'statistics');
$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";
$theotherdate = "$day-$month-$year";
$thestart1 = "$day.$month.$year";
$theotherstart1 = "$day-$month-$year";
$theend1 = "$day.$month.$year";
$theotherend1 = "$day-$month-$year";

$smarty->assign('tpl_dates', $barguest->getdates());
$smarty->assign('tpl_cat', $cat->getall());
$thecat1 = -1;
$thecat2 = -1;
$thecat3 = -1;
if ($request->GetVar('frm_cat1', 'post') !== $request->undefined) {
    $thecat1 = $request->GetVar('frm_cat1', 'post');
} 
if ($request->GetVar('frm_cat2', 'post') !== $request->undefined) {
    $thecat2 = $request->GetVar('frm_cat2', 'post');
} 
if ($request->GetVar('frm_cat3', 'post') !== $request->undefined) {
    $thecat3 = $request->GetVar('frm_cat3', 'post');
} 
$smarty->assign('tpl_thecat1', $thecat1);
$sess->SetVar('thecat1', $thecat1);
$smarty->assign('tpl_thecat2', $thecat2);
$sess->SetVar('thecat2', $thecat2);
$smarty->assign('tpl_thecat3', $thecat3);
$sess->SetVar('thecat3', $thecat3);

$from_clock1 = "0";
$till_clock1 = "23";
$from_clock2 = "0";
$till_clock2 = "23";
$from_clock3 = "0";
$till_clock3 = "23";

if ($request->GetVar('frm_from_clock1','post') !== $request->undefined) {
    $from_clock1 = $request->GetVar('frm_from_clock1','post');
}
if ($request->GetVar('frm_till_clock1','post') !== $request->undefined) {
    $till_clock1 = $request->GetVar('frm_till_clock1','post');
}

if ($request->GetVar('frm_from_clock2','post') !== $request->undefined) {
    $from_clock2 = $request->GetVar('frm_from_clock2','post');
}
if ($request->GetVar('frm_till_clock2','post') !== $request->undefined) {
    $till_clock2 = $request->GetVar('frm_till_clock2','post');
}

if ($request->GetVar('frm_from_clock3','post') !== $request->undefined) {
    $from_clock3 = $request->GetVar('frm_from_clock3','post');
}
if ($request->GetVar('frm_till_clock3','post') !== $request->undefined) {
    $till_clock3 = $request->GetVar('frm_till_clock3','post');
}

$smarty->assign('tpl_from_clock1', $from_clock1);
$sess->SetVar('from_clock1', $from_clock1);
$smarty->assign('tpl_till_clock1', $till_clock1);
$sess->SetVar('till_clock1', $till_clock1);
$smarty->assign('tpl_from_clock2', $from_clock2);
$sess->SetVar('from_clock2', $from_clock2);
$smarty->assign('tpl_till_clock2', $till_clock2);
$sess->SetVar('till_clock2', $till_clock2);
$smarty->assign('tpl_from_clock3', $from_clock3);
$sess->SetVar('from_clock3', $from_clock3);
$smarty->assign('tpl_till_clock3', $till_clock3);
$sess->SetVar('till_clock3', $till_clock3);

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
$sess->SetVar('what', $what);
$smarty->assign('tpl_theotherdate', $theotherdate);
$smarty->assign('tpl_thedate', $thedate);
$sess->SetVar('thedate',$thedate);
$smarty->assign('tpl_theotherend', $theotherend);
$smarty->assign('tpl_theend', $theend);
$sess->SetVar('theend', $theend);
$smarty->assign('tpl_theotherstart', $theotherstart);
$smarty->assign('tpl_thestart', $thestart);
$sess->SetVar('thestart', $thestart);
$smarty->assign('tpl_start1', $thestart1);
$sess->SetVar('thestart1', $thestart1);
$smarty->assign('tpl_theotherstart1', $theotherstart1);
$smarty->assign('tpl_end1', $theend1);
$sess->SetVar('theend1', $theend1);
$smarty->assign('tpl_theotherend1', $theotherend1);

if ($what == 'thedate') {
    list($day, $month, $year) = split('[.]', $thedate);
    $thestart = "$year-$month-$day 00:00:00";
    $theend = "$year-$month-$day 23:59:59";
    $smarty->assign('tpl_statistics', $statistics->get($thestart, $theend, $thecat1, $from_clock1, $till_clock1));
} elseif ($what == 'timeline') {
    list($day, $month, $year) = split('[.]', $theend1);
    $theend1 = "$year-$month-$day 23:59:59";
    list($day, $month, $year) = split('[.]', $thestart1);
    $thestart1 = "$year-$month-$day 00:00:00";
    $smarty->assign('tpl_statistics', $statistics->get($thestart1, $theend1, $thecat2, $from_clock2, $till_clock2));
} else {
    list($month, $year) = split('[/]', $theend);
    $theend = "$year-$month-01 00:00:00";
    list($month, $year) = split('[/]', $thestart);
    $thestart = "$year-$month-01 00:00:00";
    $smarty->assign('tpl_statistics', $statistics->get($thestart, $theend, $thecat3, $from_clock3, $till_clock3));
} 

$smarty->display('statistics.tpl');

?>