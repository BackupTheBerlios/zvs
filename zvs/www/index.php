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
* Show calendar
* 
* calendar
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('calendarclass.inc.php');
include_once('bookingcategoryclass.inc.php');
include_once('bookingclass.inc.php');
include_once('roomclass.inc.php');
include_once('guestlistclass.inc.php');
$cal = New Calendar;
$bcat = New BookingCategory;
$room = New Room;
$book = New Booking;
$guestlist = New Guestlist;

$smarty -> assign("tpl_title", "Zimmerplan");
$smarty -> assign('tpl_nav', 'calendar');
$smarty -> assign('tpl_type', 'calendar');

// check for old reservations
$numoldres = count($book -> getoldreservations());
if (($numoldres > 0) && ($request->GetVar('showoldres','Session') !== 'noshow')) {
    $smarty -> assign('tpl_oldreservations','true');
} else {
	$smarty -> assign('tpl_oldreservations','false');
}
$numbirthday = count($guestlist->getBirthdayReminders());
if ($numbirthday > 0 && $request->GetVar('showbirthdays','Session') !== 'noshow') {
    $smarty -> assign('tpl_birthdays','true');
} else {
    $smarty -> assign('tpl_birthdays','false');
}
$smarty -> assign('tpl_numoldres', $numoldres);

$todaydate = getdate();
$month = $todaydate['mon'];
$year = $todaydate['year'];
$view = 'type';

if ($request -> GetVar('month', 'get') !== $request -> undefined) {
    $month = $request -> GetVar('month', 'get');
    $year = $request -> GetVar('year', 'get');
} else if ($request -> GetVar('month', 'post') !== $request -> undefined) {
    $month = $request -> GetVar('month', 'post');
    $year = $request -> GetVar('year', 'post');
}  else if ($request -> GetVar('cal_month', 'session') !== $request -> undefined) {
    $month = $request -> GetVar('cal_month', 'session');
    $year = $request -> GetVar('cal_year', 'session');
}
$sess->SetVar('cal_month', $month);
$sess->SetVar('cal_year', $year);

if ($request -> GetVar('view', 'get') !== $request -> undefined) {
    $view = $request -> GetVar('view', 'get');
} else if ($request -> GetVar('view', 'post') !== $request -> undefined) {
    $view = $request -> GetVar('view', 'post');
} 

if ($view == 'type') {
    $smarty -> assign('tpl_colorP', $request -> GetVar('colorP', 'session'));
    $smarty -> assign('tpl_colorB', $request -> GetVar('colorB', 'session'));
    $smarty -> assign('tpl_colorR', $request -> GetVar('colorR', 'session'));
    $smarty -> assign('tpl_subnav', 'type');
} else {
    $smarty -> assign('tpl_subnav', 'cat');
} 

$smarty -> assign('tpl_navstep', $request -> GetVar('step', 'get'));
$smarty -> assign('tpl_navmonth', $month);
$smarty -> assign('tpl_navyear', $year);
$smarty -> assign('tpl_view', $view);
$smarty -> assign('tpl_years', $cal->getdates());
// get categories
$smarty -> assign('tpl_bcat', $bcat -> get());
// get rooms
$rooms = $room -> get();

$monthName = $cal -> returnMonthName($month);
$prevMonth = $cal -> previous_month($month, $year, false, false);
$displayyear = $year;

if ($request -> GetVar('step', 'get') !== $request -> undefined) {
    if ($month == 12) {
        $nextmonth = 1;
        $tmpyear = $year + 1;
        $displayyear = $year . '/' . $tmpyear;
    } else {
        $nextmonth = $month + 1;
    } 
    $monthName = $monthName . '/' . $cal -> returnMonthName($nextmonth);

    $smarty -> assign('tpl_step', 'false');
    $smarty -> assign('tpl_cal', $cal -> GetHalfMonth($year, $month, 0));

    for ($i = 0; $i < count($rooms); ++$i) {
        $id = $rooms[$i]['roomid'];
        $roomcal[$i] = $cal -> GetHalfMonth($year, $month, $id);
    } 
    $smarty -> assign('tpl_roomcal', $roomcal);
    $smarty -> assign('tpl_next', $cal -> next_month($month, $year, true, false));
    $smarty -> assign('tpl_halfnext', $cal -> next_month($month, $year, false, false));
    $smarty -> assign('tpl_prev', $cal -> previous_month($month, $year, true, false));
    $smarty -> assign('tpl_halfprev', $cal -> previous_month($month, $year, false, true));
} else {
    $smarty -> assign('tpl_cal', $cal -> GetMonth($year, $month, 0));

    for ($i = 0; $i < count($rooms); ++$i) {
        $id = $rooms[$i]['roomid'];
        $roomcal[$i] = $cal -> GetMonth($year, $month, $id);
    } 
    $smarty -> assign('tpl_roomcal', $roomcal);
    $smarty -> assign('tpl_step', 'true');
    $smarty -> assign('tpl_next', $cal -> next_month($month, $year, false, false));
    $smarty -> assign('tpl_halfnext', $cal -> next_month($month, $year, true, true));
    $smarty -> assign('tpl_prev', $cal -> previous_month($month, $year, false, false));
    $smarty -> assign('tpl_halfprev', $cal -> previous_month($month, $year, true, false));
} 

$smarty -> assign('tpl_room', $rooms);
$smarty -> assign('tpl_dropdownmonth', $cal -> returnMonthName($month));
$smarty -> assign('tpl_monthname', $monthName);
$smarty -> assign('tpl_dropdownyear', $year);
$smarty -> assign('tpl_year', $displayyear);

$smarty -> display('index.tpl');

?>
