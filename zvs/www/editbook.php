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
* Edit bookings
* 
* Calendar
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('bookingclass.inc.php');
include_once('calendarclass.inc.php');
include_once('roomclass.inc.php');
include_once('bookingcategoryclass.inc.php');
include_once('guestclass.inc.php');
include_once('checkinclass.inc.php');
include_once('checkoutclass.inc.php');
$cal = New Calendar;
$room = New Room;
$bcat = New BookingCategory;
$guest = New Guest;
$booking = New Booking;
$checkin = New Checkin;
$checkout = New Checkout;
$firstpage = false;
// select Countries
$smarty->assign("tpl_countries", $guest->GetCountries());
$smarty->assign('tpl_children0_field', $request->GetVar('children0', 'session'));
$smarty->assign('tpl_children1_field', $request->GetVar('children1', 'session'));
$smarty->assign('tpl_children2_field', $request->GetVar('children2', 'session'));
$smarty->assign('tpl_children3_field', $request->GetVar('children3', 'session'));

$navmonth = $request->GetVar('month', 'get');
$navyear = $request->GetVar('year', 'get');
$navstep = $request->GetVar('navstep', 'get');
$bookid = $request->GetVar('bookid', 'get');
$bookingdetailid = $request->GetVar('bookingdetailid', 'get');

if ($request->GetVar('checkin', 'get') !== $request->undefined) {
    $smarty->assign('tpl_checkin', $request->GetVar('checkin', 'get'));
} else if ($request->GetVar('frm_checkin', 'post') !== $request->undefined) {
    $smarty->assign('tpl_checkin', $request->GetVar('frm_checkin', 'post'));
} else {
    $smarty->assign('tpl_checkin', 'false');
} 
if ($request->GetVar('checkout', 'get') !== $request->undefined) {
    $smarty->assign('tpl_checkout', $request->GetVar('checkout', 'get'));
} else if ($request->GetVar('frm_checkout', 'post') !== $request->undefined) {
    $smarty->assign('tpl_checkout', $request->GetVar('frm_checkout', 'post'));
} else {
    $smarty->assign('tpl_checkout', 'false');
} 
if ($navmonth == "") {
    $navmonth = $request->GetVar('frm_navmonth', 'post');
} 

if ($navyear == "") {
    $navyear = $request->GetVar('frm_navyear', 'post');
} 

if ($navstep == "") {
    $navstep = $request->GetVar('frm_navstep', 'post');
} 

if ($bookid == "") {
    $bookid = $request->GetVar('frm_bookid', 'post');
} 

if ($bookingdetailid == "") {
    $bookingdetailid = $request->GetVar('frm_bookingdetailid', 'post');
} 

$smarty->assign('tpl_navyear', $navyear);
$smarty->assign('tpl_navmonth', $navmonth);
$smarty->assign('tpl_navstep', $navstep);
$smarty->assign('tpl_bookid', $bookid);
$smarty->assign('tpl_bookingdetailid', $bookingdetailid);

if ($request->GetVar('frm_step', 'post') == "editescort") {
    $smarty->assign('tpl_step', '90');
} else if ($request->GetVar('frm_step', 'post') == "91") {
    $guests = $booking->searchWithoutEscorts($request->GetVar('frm_bookingdetailid', 'post'), $request->GetVar('frm_vorname', 'post'), $request->GetVar('frm_nachname', 'post'));

    if (count($guests) == 1) {
        $selected = $guests[0][guestid];
    } 
        $smarty->assign('tpl_vorname', $request->GetVar('frm_vorname', 'post'));
        $smarty->assign('tpl_nachname', $request->GetVar('frm_nachname', 'post'));
    if (count($guests) > 0) {
        $smarty->assign('tpl_step', '91');
        $smarty->assign('tpl_result', $guests);
        $smarty->assign('tpl_selected', $selected);
        $smarty->assign("tpl_salutation", $guest->getSalutation());		
    } else {
        $smarty->assign('tpl_notfound', 'true');
        $smarty->assign("tpl_salutation", $guest->getSalutation());
        $smarty->assign('tpl_step', '90');
    } 
} else if ($request->GetVar('frm_step', 'post') == "92") {
    $guestids = array();
    $guestids = $request->GetVar('frm_addguestid', 'post');
    for ($i = 0; $i < count($guestids); $i++) {
        $booking->addAdditionalGuest($request->GetVar('frm_bookingdetailid', 'post'), $guestids[$i]);
    } 
} else if ($request->GetVar('frm_step', 'post') == "93") {
    $additionalguestid = $guest->saveupdateguest();
    $booking->addAdditionalGuest($request->GetVar('frm_bookingdetailid', 'post'), $additionalguestid);
	if ($request->GetVar('frm_keepaddress', 'post') == "true") {
		$booking->linkGuestAddress($request->GetVar('frm_guestid','post'),$additionalguestid);
	}
} else if ($request->GetVar('frm_step', 'post') == "delescort") {
    $booking->delAdditionalGuest($request->GetVar('frm_bookingdetailid', 'post'), $request->GetVar('frm_delescortid', 'post'));
} else if ($request->GetVar('frm_step', 'post') == "addPosEscort") {
    $booking->addAdditionalGuest($request->GetVar('frm_bookingdetailid', 'post'), $request->GetVar('frm_addPosEscortid', 'post'));
} else if ($request->GetVar('frm_step', 'post') == "checkin") {
    $checkin->checkbookingin($bookid);
    $smarty->assign('tpl_checkedin', 'true');
} else if ($request->GetVar('frm_step', 'post') == "checkout") {
    $checkout->checkbookingout($bookid);
    $smarty->assign('tpl_checkedout', 'true');
} else if ($request->GetVar('frm_step', 'post') == "del") {
    $booking->del($bookid, $bookingdetailid);
    $smarty->assign('tpl_step', '10');
} else if ($request->GetVar('frm_step', 'post') == "editcat") {
    $smarty->assign('tpl_step', 'editcat');
    $smarty->assign('tpl_bcat', $bcat->get());
} else if ($request->GetVar('frm_step', 'post') == "editend") {
    $smarty->assign('tpl_step', 'editend');
    $smarty->assign('tpl_extdays', $cal->getExtensionTimes($request->GetVar('frm_start', 'post'), $request->GetVar('frm_roomid', 'post')));
} else if ($request->GetVar('frm_step', 'post') == "saveend") {
    $success = MetabaseAutoCommitTransactions($gDatabase, false);
    $query = sprintf("UPDATE $tbl_booking SET end_date = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_extdays', 'post'))),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 
    $query = sprintf("UPDATE $tbl_booking_detail SET end_date = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE fk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_extdays', 'post'))),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $success = MetabaseCommitTransaction($gDatabase);
        $success = MetabaseAutoCommitTransactions($gDatabase, true);
    } 
} else if ($request->GetVar('frm_step', 'post') == "changeguest") {
	$query = sprintf("SELECT fk_guest_id FROM $tbl_booking 
					  WHERE pk_booking_id = %s ",
					  $bookid
					  );
    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 	
	$oldguestid = MetabaseFetchResult($gDatabase, $result, 0, 0);
    $smarty->assign('tpl_guestlist', $guest->getListWithoutEscorts($bookingdetailid, $oldguestid));	
    $smarty->assign('tpl_step', 'changeguest');
} else if ($request->GetVar('frm_step', 'post') == "saveguest") {	
	$success = MetabaseAutoCommitTransactions($gDatabase, false);
	$query = sprintf("SELECT fk_guest_id FROM $tbl_booking 
					  WHERE pk_booking_id = %s ",
					  $bookid
					  );
    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 	
	$oldguestid = MetabaseFetchResult($gDatabase, $result, 0, 0);
	$query = sprintf("UPDATE $tbl_booking SET fk_guest_id = %s,
					  updated_date = NOW(), fk_updated_user_id = %s 
					  WHERE pk_booking_id = %s ",
					  $request->GetVar('frm_guest','post'),
					  $request->GetVar('uid', 'session'),
					  $bookid
					  );
    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 
	$query = "UPDATE $tbl_booking_detail_guest
			  SET pk_fk_guest_id = ". $request->GetVar('frm_guest','post') ."
			  WHERE pk_fk_booking_detail_id = ". $bookingdetailid ."
			  AND pk_fk_guest_id = ". $oldguestid;
    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $success = MetabaseCommitTransaction($gDatabase);
        $success = MetabaseAutoCommitTransactions($gDatabase, true);	
	}			  					  
} else if ($request->GetVar('frm_step', 'post') == "editstart") {
    $smarty->assign('tpl_step', 'editstart');
    $smarty->assign('tpl_extdays', $cal->getExtensionTimes2($request->GetVar('frm_end', 'post'), $request->GetVar('frm_roomid', 'post')));
} else if ($request->GetVar('frm_step', 'post') == "savestart") {
    $success = MetabaseAutoCommitTransactions($gDatabase, false);
    $query = sprintf("UPDATE $tbl_booking SET start_date = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_extdays', 'post'))),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 
    $query = sprintf("UPDATE $tbl_booking_detail SET start_date = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE fk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_extdays', 'post'))),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $success = MetabaseCommitTransaction($gDatabase);
        $success = MetabaseAutoCommitTransactions($gDatabase, true);
    } 
	
} else if ($request->GetVar('frm_step', 'post') == "savecat") {
    $query = sprintf("UPDATE $tbl_booking SET fk_bookingcat_id = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_cat', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 
} else if ($request->GetVar('frm_step', 'post') == "edittype") {
    // duration for reservation
    $today = getdate();
    $todaydate = date("Y-m-d", $today[0]);
    $defdays = $request->GetVar('defaultreservationduration', 'session');
    $reservation = date("d.m.Y", strtotime("$todaydate + $defdays days"));
    $smarty->assign('tpl_reservationduration', $reservation);

    $smarty->assign('tpl_step', 'edittype');
} else if ($request->GetVar('frm_step', 'post') == "savetype") {
    $strreservationuntil = "";
    if ($request->GetVar('frm_bookingtype', 'post') == "R") {
        $reservationuntil = explode(".", $request->GetVar('frm_reservationduration', 'post'));
        $strreservationuntil = $reservationuntil[2] . "-" . $reservationuntil[1] . "-" . $reservationuntil[0];
    } 
    $query = sprintf("UPDATE $tbl_booking SET booking_type = %s, reservation_until = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_bookingtype', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $strreservationuntil),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 
} else if ($request->GetVar('frm_step', 'post') == "editroom") {
    $bookdata = $booking->get($bookingdetailid);
    $smarty->assign('tpl_step', 'editroom');
	$freerooms[0] = array( 'roomid' => $bookdata["roomid"],
	                    'name' => $bookdata["room"]);
	$freerooms = array_merge($freerooms, $booking->getFreeRooms($bookdata['start'], $bookdata['end']));
    $smarty->assign('tpl_rooms', $freerooms);
} else if ($request->GetVar('frm_step', 'post') == "saveroom") {
    $query = sprintf("UPDATE $tbl_booking_detail SET fk_room_id = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_room', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $errorhandler->display('SQL', 'editbook.php', $query);
    } 
} else if ($request->GetVar('frm_step', 'post') == "editinfo") {
    $smarty->assign('tpl_step', 'editinfo');
} else if ($request->GetVar('frm_step', 'post') == "saveinfo") {
    $query = sprintf("UPDATE $tbl_booking_detail SET  additional_info  = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
	    $query = sprintf("UPDATE $tbl_booking SET  additional_info  = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
	        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
	        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
	        MetabaseGetTextFieldValue($gDatabase, $bookid)
	        );
	
	    $result = MetabaseQuery($gDatabase, $query);
	    if (!$result) {
	        $errorhandler->display('SQL', 'editbook.php', $query);
	    }	
	
	}
} else if ($request->GetVar('frm_step', 'post') == "editpersons") {
    $smarty->assign('tpl_step', 'editpersons');
} else if ($request->GetVar('frm_step', 'post') == "savepersons") {
    // transaction control
    $auto_commit = false;
    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

    $query = sprintf("UPDATE $tbl_booking SET persons = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_persons', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $query = sprintf("UPDATE $tbl_booking_detail SET persons = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_persons', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
            MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'editbook.php', $query);
        } else {
            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
    } 
} else if ($request->GetVar('frm_step', 'post') == "editchildren0") {
    $smarty->assign('tpl_step', 'editchildren0');	
} else if ($request->GetVar('frm_step', 'post') == "editchildren") {
    $smarty->assign('tpl_step', 'editchildren');
} else if ($request->GetVar('frm_step', 'post') == "editchildren2") {
    $smarty->assign('tpl_step', 'editchildren2');
} else if ($request->GetVar('frm_step', 'post') == "editchildren3") {
    $smarty->assign('tpl_step', 'editchildren3');
} else if ($request->GetVar('frm_step', 'post') == "savechildren0") {
    // transaction control
    $auto_commit = false;
    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

    $query = sprintf("UPDATE $tbl_booking SET children0 = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children0', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $query = sprintf("UPDATE $tbl_booking_detail SET children0 = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children0', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
            MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'editbook.php', $query);
        } else {
            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
    } 
	
} else if ($request->GetVar('frm_step', 'post') == "savechildren") {
    // transaction control
    $auto_commit = false;
    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

    $query = sprintf("UPDATE $tbl_booking SET children = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $query = sprintf("UPDATE $tbl_booking_detail SET children = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
            MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'editbook.php', $query);
        } else {
            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
    } 
} else if ($request->GetVar('frm_step', 'post') == "savechildren2") {
    // transaction control
    $auto_commit = false;
    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

    $query = sprintf("UPDATE $tbl_booking SET children2 = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children2', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $query = sprintf("UPDATE $tbl_booking_detail SET children2 = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children2', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
            MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'editbook.php', $query);
        } else {
            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
    } 
} else if ($request->GetVar('frm_step', 'post') == "savechildren3") {
    // transaction control
    $auto_commit = false;
    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

    $query = sprintf("UPDATE $tbl_booking SET children3 = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children3', 'post')),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $query = sprintf("UPDATE $tbl_booking_detail SET children3 = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_children3', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
            MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'editbook.php', $query);
        } else {
            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
    } 
} else if ($request->GetVar('frm_step', 'post') == "editdays") {
    $freenights = $cal->getFreeNights($request->GetVar('frm_start', 'post'), $request->GetVar('frm_roomid', 'post'));

    if ($freenights == 0) {
        $freenights = 100;
    } 

    $days = array();
    for ($i = 0; $i < $freenights; ++$i) {
        $days[$i] = $i + 1;
    } 
    $smarty->assign('tpl_days', $days);
    $smarty->assign('tpl_step', 'editdays');
} else if ($request->GetVar('frm_step', 'post') == "savedays") {
    $start = $request->GetVar('frm_start', 'post');
    $starttmp = date("Y-m-d", $start);
    $days = $request->GetVar('frm_days', 'post');
    $end = strtotime("$starttmp + $days days"); 
    // transaction control
    $auto_commit = false;
    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

    $query = sprintf("UPDATE $tbl_booking SET end_date = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_id = %s ",
        MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $end)),
        MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
        MetabaseGetTextFieldValue($gDatabase, $bookid)
        );

    $result = MetabaseQuery($gDatabase, $query);
    if (!$result) {
        $success = MetabaseRollbackTransaction($gDatabase);
        $errorhandler->display('SQL', 'editbook.php', $query);
    } else {
        $query = sprintf("UPDATE $tbl_booking_detail SET end_date = %s, updated_date = NOW(), fk_updated_user_id = %s WHERE pk_booking_detail_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $end)),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('uid', 'session')),
            MetabaseGetTextFieldValue($gDatabase, $bookingdetailid)
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'editbook.php', $query);
        } else {
            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
    } 
} else {
    $smarty->assign('tpl_step', '0');
    $smarty->assign('tpl_emailconfirmation', $booking->emailConfirmation($bookid));
	$firstpage = true;
} 

$bookdata = $booking->get($bookingdetailid);
// check room capacity
if ($bookdata[persons] + $bookdata[children0] + $bookdata[children] + $bookdata[children2] + $bookdata[children3] > $bookdata[capacity]) {
    $smarty->assign('tpl_overload', 'true');
} else {
    $smarty->assign('tpl_overload', 'false');
} 

if (count($bookdata[additionalguests]) . "guests " > ($bookdata[persons] + $bookdata[children] + $bookdata[children2] + $bookdata[children3])) {
    $smarty->assign('tpl_addoverload', 'true');
} else {
    $smarty->assign('tpl_addoverload', 'false');
} 

if ($guest->checkAddress($bookdata[gastid])) {
    $smarty->assign('tpl_checkaddress', 'true');
} else {
    $smarty->assign('tpl_checkaddress', 'false');
} 

	$smarty->assign('tpl_posEscorts', $booking->showPossibleEscorts($bookingdetailid, $bookdata[gastid]));

$smarty->assign('tpl_bookdata', $bookdata);
$smarty->display('editbook.tpl');

?>
