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
* List employee times
* 
* Lists
* 
* 10/07/2004 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default2.inc.php");
$auth->is_authenticated();
include_once("employeeclass.inc.php");
$employee = New Employee;
include_once("timetrackerclass.inc.php");
$timetracker = New Timetracker;

$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];

if ($request->GetVar('frm_start', 'post') !== $request->undefined) {
    $thestart = $request->GetVar('frm_start', 'post');
} else {
    $thestart = $month . '/' . $year;
} 

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
} 

$employeeid = $request->GetVar('uid','session');


$smarty->assign('tpl_theemployeeid', $employeeid);
$smarty->assign('tpl_theend', $theend);
$smarty->assign('tpl_thestart', $thestart);

$smarty->assign("tpl_title", "Zeiten");
$smarty->assign('tpl_nav', 'list');

if ($employeeid !== -1) {
	list($month, $year) = split('[/]', $theend);
    $theend = mktime(0, 0, 0, $month, 1, $year);
    list($month, $year) = split('[/]', $thestart);
    $thestart = mktime(0, 0, 0, $month, 1, $year);
    $smarty->assign('tpl_list', $timetracker->gettimes($employeeid, $thestart, $theend, false));
}

$smarty->assign('tpl_employee', $employee->getall());
$smarty->assign('tpl_dates', $timetracker->getdates());

$smarty->display('list_employeetime.tpl');

?>