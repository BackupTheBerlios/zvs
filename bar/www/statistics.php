<?php
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
$smarty->assign('tpl_thecat2', $thecat2);
$smarty->assign('tpl_thecat3', $thecat3);

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

if ($what == 'thedate') {
    list($day, $month, $year) = split('[.]', $thedate);
    $thestart = "$year-$month-$day 00:00:00";
    $theend = "$year-$month-$day 23:59:59";
    $smarty->assign('tpl_statistics', $statistics->get($thestart, $theend, $thecat1));
} elseif ($what == 'timeline') {
    list($day, $month, $year) = split('[.]', $theend1);
    $theend1 = "$year-$month-$day 23:59:59";
    list($day, $month, $year) = split('[.]', $thestart1);
    $thestart1 = "$year-$month-$day 00:00:00";
    $smarty->assign('tpl_statistics', $statistics->get($thestart1, $theend1, $thecat2));
} else {
    list($month, $year) = split('[/]', $theend);
    $theend = "$year-$month-01 00:00:00";
    list($month, $year) = split('[/]', $thestart);
    $thestart = "$year-$month-01 00:00:00";
    $smarty->assign('tpl_statistics', $statistics->get($thestart, $theend, $thecat3));
} 

$smarty->display('statistics.tpl');

?>