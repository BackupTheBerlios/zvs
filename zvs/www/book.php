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
* Add a booking
* 
* Calendar
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('calendarclass.inc.php');
include_once('roomclass.inc.php');
include_once('bookingcategoryclass.inc.php');
include_once('guestclass.inc.php');
include_once('bookingclass.inc.php');

	$smarty -> assign('tpl_children_field1', $request->GetVar('children1', 'session'));
	$smarty -> assign('tpl_children_field2', $request->GetVar('children2', 'session'));
	$smarty -> assign('tpl_children_field3', $request->GetVar('children3', 'session'));	
	
$cal = New Calendar;
$room = New Room;
$bcat = New BookingCategory;
$guest = New Guest;
$book = New Booking;

$navmonth = $request -> GetVar('month', 'get');
$navyear = $request -> GetVar('year', 'get');
$navstep = $request -> GetVar('navstep', 'get');
$bookid = $request -> GetVar('bookid', 'get');

if ($navmonth == "") {
    $navmonth = $request -> GetVar('frm_navmonth', 'post');
} 

if ($navyear == "") {
    $navyear = $request -> GetVar('frm_navyear', 'post');
} 

if ($navstep == "") {
    $navstep = $request -> GetVar('frm_navstep', 'post');
} 

if ($bookid == "") {
    $bookid = $request -> GetVar('frm_bookid', 'post');
} 


$smarty -> assign('tpl_navyear', $navyear);
$smarty -> assign('tpl_navmonth', $navmonth);
$smarty -> assign('tpl_navstep', $navstep);
$smarty -> assign('tpl_bookid', $bookid);

if ($request -> GetVar('frm_step', 'post') == "2") {
    $smarty -> assign('tpl_step', '2');
    $smarty -> assign('tpl_startdate', $request -> GetVar('frm_startdate', 'post'));
    $smarty -> assign('tpl_room', $request -> GetVar('frm_room', 'post'));
    $smarty -> assign('tpl_days', $request -> GetVar('frm_days', 'post'));
    $start = $request -> GetVar('frm_startdate', 'post');
    $starttmp = date("Y-m-d", $start);
    $days = $request -> GetVar('frm_days', 'post');
    $end = strtotime("$starttmp + $days days");
    $smarty -> assign('tpl_enddate', $end);
    $smarty -> assign('tpl_niceroom', $room -> getname($request -> GetVar('frm_room', 'post')));
    $smarty -> assign('tpl_cat', $request -> GetVar('frm_cat', 'post'));
    $smarty -> assign('tpl_persons', $request -> GetVar('frm_persons', 'post'));
    $smarty -> assign('tpl_children', $request -> GetVar('frm_children', 'post'));
    $smarty -> assign('tpl_children2', $request -> GetVar('frm_children2', 'post'));
    $smarty -> assign('tpl_children3', $request -> GetVar('frm_children3', 'post'));		
    $smarty -> assign('tpl_bookingtype', $request -> GetVar('frm_bookingtype', 'post'));
    $smarty -> assign('tpl_description', $request -> GetVar('frm_description', 'post'));
    if ($request -> GetVar('frm_bookingtype', 'post') == "R") {
        $smarty -> assign('tpl_reservationduration', $request -> GetVar('frm_reservationduration', 'post'));
    } else {
        $smarty -> assign('tpl_reservationduration', '');
    } 
    $smarty -> assign('tpl_countries', $guest -> getCountries());
} else if ($request -> GetVar('frm_step', 'post') == "3") {
    $smarty -> assign('tpl_startdate', $request -> GetVar('frm_startdate', 'post'));
    $smarty -> assign('tpl_enddate', $request -> GetVar('frm_enddate', 'post'));
    $smarty -> assign('tpl_room', $request -> GetVar('frm_room', 'post'));
    $smarty -> assign('tpl_days', $request -> GetVar('frm_days', 'post'));
    $smarty -> assign('tpl_niceroom', $room -> getname($request -> GetVar('frm_room', 'post')));
    $smarty -> assign('tpl_cat', $request -> GetVar('frm_cat', 'post'));
    $smarty -> assign('tpl_persons', $request -> GetVar('frm_persons', 'post'));
    $smarty -> assign('tpl_children', $request -> GetVar('frm_children', 'post'));
    $smarty -> assign('tpl_children2', $request -> GetVar('frm_children2', 'post'));
    $smarty -> assign('tpl_children3', $request -> GetVar('frm_children3', 'post'));		
    $smarty -> assign('tpl_bookingtype', $request -> GetVar('frm_bookingtype', 'post'));
    $smarty -> assign('tpl_description', $request -> GetVar('frm_description', 'post'));
    $smarty -> assign('tpl_reservationduration', $request -> GetVar('frm_reservationduration', 'post')); 
	$smarty -> assign('tpl_ofirstname', $request -> GetVar('frm_vorname', 'post'));
	$smarty -> assign('tpl_olastname', $request -> GetVar('frm_nachname', 'post'));

    // add new guest
    if ($request -> GetVar('frm_newguest', 'post') == "true") {
        $guests = $guest -> quickinsert($request -> GetVar('frm_vorname', 'post'), $request -> GetVar('frm_nachname', 'post'));
        $selected = $guests[0][guestid];
    } else {
        $guests = $guest -> easysearch($request -> GetVar('frm_vorname', 'post'), $request -> GetVar('frm_nachname', 'post'));
        $selected = $guests[0][guestid];
    } 

    if (count($guests) > 0) {
        $smarty -> assign('tpl_step', '3');
        $smarty -> assign('tpl_result', $guests);
        $smarty -> assign('tpl_selected', $selected);
    } else {
        $smarty -> assign('tpl_notfound', 'true');
        $smarty -> assign('tpl_vorname', $request -> GetVar('frm_vorname', 'post'));
        $smarty -> assign('tpl_nachname', $request -> GetVar('frm_nachname', 'post'));
        $smarty -> assign('tpl_step', '2');
    } 
} else if ($request -> GetVar('frm_step', 'post') == "4") {
    $smarty -> assign('tpl_step', '4');

    $smarty -> assign('tpl_niceroom', $room -> getname($request -> GetVar('frm_room', 'post')));
    $bookid = $book -> book();
	$smarty -> assign('tpl_emailconfirmation',$book->emailConfirmation($bookid));
	$smarty -> assign('tpl_bookid', $bookid);
	$smarty -> assign('tpl_bookingdetailid', $book -> getBookingDetailId($bookid));
    $smarty -> assign('tpl_cat', $request -> GetVar('frm_cat', 'post'));
    $smarty -> assign('tpl_start', date("d. m. Y", $request -> GetVar('frm_startdate', 'post')));
    $smarty -> assign('tpl_end', date("d. m. Y", $request -> GetVar('frm_enddate', 'post')));
    $smarty -> assign('tpl_nights', $request -> GetVar('frm_days', 'post'));
    $smarty -> assign('tpl_persons', $request -> GetVar('frm_persons', 'post'));
    $smarty -> assign('tpl_children', $request -> GetVar('frm_children', 'post'));
    $smarty -> assign('tpl_children2', $request -> GetVar('frm_children2', 'post'));
    $smarty -> assign('tpl_children3', $request -> GetVar('frm_children3', 'post'));		
    $smarty -> assign('tpl_bookingtype', $request -> GetVar('frm_bookingtype', 'post'));
    $smarty -> assign('tpl_reservationduration', $request -> GetVar('frm_reservationduration', 'post'));
    $smarty -> assign('tpl_description', $request -> GetVar('frm_description', 'post')); 
    // get categories
    $smarty -> assign('tpl_bcat', $bcat -> get());
} else {
    $start = $request -> GetVar('start', 'get'); 
    // duration for reservation
    $today = getdate();
    $todaydate = date("Y-m-d", $today[0]);
    $defdays = $request -> GetVar('defaultreservationduration', 'session');
    $reservation = date("d.m.Y", strtotime("$todaydate + $defdays days"));
    $smarty -> assign('tpl_reservationduration', $reservation);

    $roomid = $request -> GetVar('room', 'get');
    $freenights = $cal -> getFreeNights($start, $roomid);
    if ($freenights == 0) {
        $freenights = 100;
    } 

    $smarty -> assign('tpl_startdate', $start);
    $smarty -> assign('tpl_startnice', date("D, d. m. Y", $start));
    $smarty -> assign('tpl_room', $roomid);
    $smarty -> assign('tpl_niceroom', $room -> getname($roomid));
    $starttmp = date("Y-m-d", $start);
    $days = array();
    for ($i = 0; $i < $freenights; ++$i) {
		$j = $i + 1;
        $days[$i]["count"] = $j;
		$days[$i]["date"] = date("D, d. m. Y", strtotime("$starttmp + $j days"));
    } 
    $smarty -> assign('tpl_days', $days); 
    // get categories
    $smarty -> assign('tpl_bcat', $bcat -> get());
} 

$smarty -> display('book.tpl');

?>
