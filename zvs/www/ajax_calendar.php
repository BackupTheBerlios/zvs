<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003-2006 Christian Ehret (chris@ehret.name)
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
* Get the calendar
* 
* Calendar
* 
* @since 2006-02-24
* @author Christian Ehret <chris@ehret.name> 
*/

class Timer {
// Starts, Ends and Displays Page Creation Time
   function getmicrotime() {
       list($usec, $sec) = explode(" ", microtime());
       return ((float)$usec + (float)$sec);
   }    
   
   function starttime() {
   $this->st = $this->getmicrotime();
   }
       
   function displaytime() {
       $this->et = $this->getmicrotime();
       return round(($this->et - $this->st), 3);
   }
}
$time = new Timer;
$time->starttime();

include_once("../includes/default.inc.php");
$auth -> is_authenticated();

include_once('calendarclass.inc.php');
include_once('bookingclass.inc.php');
include_once('roomclass.inc.php');

$cal = New Calendar;
$book = New Booking;
$room = New Room;

$smartyType = "www";


$month = $request -> GetVar('month', 'post');
$year = $request -> GetVar('year', 'post');
$view = $request -> GetVar('view', 'post');
$step = $request -> GetVar('step', 'post');

//print "view:". $view ." year: ".$year ."month: " .$month; 

$smarty -> assign('tpl_navstep', $step);
$smarty -> assign('tpl_navmonth', $month);
$smarty -> assign('tpl_navyear', $year);
$smarty -> assign('tpl_view', $view);
$smarty -> assign('tpl_years', $cal->getdates());

// get rooms
$rooms = $room -> get();

/*$monthName = $cal -> returnMonthName($month);
$prevMonth = $cal -> previous_month($month, $year, false, false);
$displayyear = $year;
*/
if ($step !== '') {
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
    /*
    $smarty -> assign('tpl_next', $cal -> next_month($month, $year, true, false));
    $smarty -> assign('tpl_halfnext', $cal -> next_month($month, $year, false, false));
    $smarty -> assign('tpl_prev', $cal -> previous_month($month, $year, true, false));
    $smarty -> assign('tpl_halfprev', $cal -> previous_month($month, $year, false, true));
    */
} else {

    $smarty -> assign('tpl_cal', $cal -> GetMonth($year, $month, 0));

    for ($i = 0; $i < count($rooms); ++$i) {
        $id = $rooms[$i]['roomid'];
        $roomcal[$i] = $cal -> GetMonth($year, $month, $id);
    } 

    $smarty -> assign('tpl_roomcal', $roomcal);
    $smarty -> assign('tpl_step', 'true');
    /*
    $smarty -> assign('tpl_next', $cal -> next_month($month, $year, false, false));
    $smarty -> assign('tpl_halfnext', $cal -> next_month($month, $year, true, true));
    $smarty -> assign('tpl_prev', $cal -> previous_month($month, $year, false, false));
    $smarty -> assign('tpl_halfprev', $cal -> previous_month($month, $year, true, false));
    */
} 

$smarty -> assign('tpl_room', $rooms);
/*$smarty -> assign('tpl_dropdownmonth', $cal -> returnMonthName($month));
$smarty -> assign('tpl_monthname', $monthName);
$smarty -> assign('tpl_dropdownyear', $year);
$smarty -> assign('tpl_year', $displayyear);*/

echo $smarty->fetch('ajax_calendar.tpl');
echo 'Script took '.$time->displaytime().' seconds to execute<br/>';
//$smarty->display('ajax_calendar.tpl');