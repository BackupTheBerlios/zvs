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
* List employee work times
* 
* Lists
* 
* @since 2004-10-97
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
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

if ($request->GetVar('frm_employee', 'post') !== $request->undefined) {
    $employeeid = $request->GetVar('frm_employee', 'post');
} else {
	$employeeid = -1;
}

$smarty->assign('tpl_theemployeeid', $employeeid);
$smarty->assign('tpl_theend', $theend);
$smarty->assign('tpl_thestart', $thestart);

$smarty->assign("tpl_title", "Mitarbeiter Zeiten");
$smarty->assign('tpl_nav', 'lists');
$smarty->assign('tpl_subnav', 'employeetime');
$smarty->assign('tpl_type', 'listemployeetime');


if ($request -> GetVar('frm_timetrackerid', 'post') !== $request -> undefined) {
    if ($request -> GetVar('frm_action', 'post') == 'edit') {
        $smarty -> assign('tpl_editid', $request -> GetVar('frm_timetrackerid', 'post'));
    } elseif ($request -> GetVar('frm_action', 'post') == 'addnew') {
        $smarty -> assign('tpl_addnew', 'true');
		$smarty -> assign('tpl_editid', -1);
    } elseif ($request -> GetVar('frm_action', 'post') == 'del') {
        //$room -> del($request -> GetVar('frm_roomid', 'post'));
		$smarty -> assign('tpl_editid', -1);		
    } elseif ($request -> GetVar('frm_timetrackerid', 'post') !== "") {
        $check = $timetracker -> saveupdate();
		$smarty -> assign('tpl_editid', -1);	   
    } else {
		$smarty -> assign('tpl_editid', -1);		
	}
} 

if ($employeeid !== -1) {
	list($month, $year) = split('[/]', $theend);
    $theend = mktime(0, 0, 0, $month, 1, $year);
    list($month, $year) = split('[/]', $thestart);
    $thestart = mktime(0, 0, 0, $month, 1, $year);
    $smarty->assign('tpl_list', $timetracker->gettimes($employeeid, $thestart, $theend));
}
$smarty->assign('tpl_employee', $employee->getall());
$smarty->assign('tpl_dates', $timetracker->getdates());

$smarty->display('list_employeetime.tpl');

?>