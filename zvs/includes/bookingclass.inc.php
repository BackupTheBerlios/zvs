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
* class Booking
* 
* Class for bookings
* 
* This class has all functions which are needed for bookings.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: bookingclass.inc.php,v 1.2 2005/05/05 10:03:20 ehret Exp $
*/
class Booking {
    /**
    * Booking::book()
    * 
    * This functions make a booking
    * 
    * @return integer bookingid
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function book()
    {
        global $request, $errorhandler, $gDatabase, $tbl_booking, $tbl_booking_detail, $tbl_booking_detail_guest; 
        // transaction control
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit); 
        // get booking reference id
        $query = "SELECT date_format( sysdate( ) , '%y%m%d' ) sysdate, 
		 			(count( b.pk_booking_id ) + 1 ) booking_no 
		 			FROM $tbl_booking b 
		 			WHERE date_format( b.inserted_date, '%Y%m%d' ) = date_format( sysdate( ) , '%Y%m%d' ) ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Booking::book()', $query);
        } else {
            $sysdate = MetabaseFetchResult($gDatabase, $result, 0, 0);
            $bookingno = substr(MetabaseFetchResult($gDatabase, $result, 0, 1) + 10000, 1);
            $hotel_code = $request->GetVar('hotel_code', 'session');
            $reference_id = $hotel_code . "-" . $sysdate . "-" . $bookingno;
        } 

        $name = "zvs_pk_booking_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$bookid);
        $strreservationuntil = "";
        if ($request->GetVar('frm_reservationduration', 'post') != "") {
            $reservationuntil = explode(".", $request->GetVar('frm_reservationduration', 'post'));
            $strreservationuntil = $reservationuntil[2] . "-" . $reservationuntil[1] . "-" . $reservationuntil[0];
        } 
        $query = sprintf("INSERT INTO $tbl_booking 
						(pk_booking_id, fk_bookingcat_id, fk_guest_id, 
						 start_date, end_date, inserted_date, 
						 fk_inserted_user_id, persons, children,
						 booking_type, reservation_until, additional_info, booking_reference_id,
						 children2, children3, children0) 
						 VALUES (%s, %s, %s, %s, %s, NOW(), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
            $bookid,
            $request->GetVar('frm_cat', 'post'),
            $request->GetVar('frm_guestid', 'post'),
            MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_startdate', 'post'))),
            MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_enddate', 'post'))),
            $request->GetVar('uid', 'session'),
            $request->GetVar('frm_persons', 'post'),
            $request->GetVar('frm_children', 'post'),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_bookingtype', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $strreservationuntil),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $reference_id),
            $request->GetVar('frm_children2', 'post'),
            $request->GetVar('frm_children3', 'post'),
            $request->GetVar('frm_children0', 'post')			
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Booking::book()', $query);
        } else {
            $name = "zvs_pk_booking_detail_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$bookdetailid);
            $query = sprintf("INSERT INTO $tbl_booking_detail 
							  (pk_booking_detail_id, fk_booking_id, fk_room_id, 
							   start_date, end_date, inserted_date, 
							   fk_inserted_user_id, persons, children, 
							   additional_info, children2, children3, children0)
							   VALUES (%s, %s, %s, %s, %s, NOW(), %s, %s, %s, %s, %s, %s, %s )",
                $bookdetailid,
                $bookid,
                $request->GetVar('frm_room', 'post'),
                MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_startdate', 'post'))),
                MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $request->GetVar('frm_enddate', 'post'))),
                $request->GetVar('uid', 'session'),
                $request->GetVar('frm_persons', 'post'),
                $request->GetVar('frm_children', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
                $request->GetVar('frm_children2', 'post'),
                $request->GetVar('frm_children3', 'post'),
                $request->GetVar('frm_children0', 'post')				
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Booking::book()', $query);
            } else {
                $query = sprintf("INSERT INTO $tbl_booking_detail_guest 
								(pk_fk_booking_detail_id, pk_fk_guest_id) 
								VALUES (%s, %s) ",
                    $bookdetailid,
                    $request->GetVar('frm_guestid', 'post')
                    );
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Booking::book()', $query);
                } else {
                    $success = MetabaseCommitTransaction($gDatabase); 
                    // end transaction
                    $auto_commit = true;
                    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
                } 
            } 
        } 
        return $bookid;
    } 

    /**
    * Booking::del()
    * 
    * This function marks a booking with a id as deleted
    * 
    * @param number $bookid id of booking
    * @param number $bookingdetailid id of booking detail
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($bookid, $bookingdetailid)
    {
        global $tbl_booking, $tbl_booking_detail, $gDatabase, $request, $errorhandler; 
        // transaction control
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

        $query = sprintf("UPDATE $tbl_booking 
		                  SET deleted_date = NOW(), 
						  fk_deleted_user_id = %s 
						  WHERE pk_booking_id = %s ",
            $request->GetVar('uid', 'session'),
            $bookid
            );

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Booking::del()', $query);
        } else {
            $query = sprintf("UPDATE $tbl_booking_detail 
							  SET deleted_date = NOW(), 
							  fk_deleted_user_id = %s 
							  WHERE pk_booking_detail_id = %s ",
                $request->GetVar('uid', 'session'),
                $bookingdetailid
                );

            $result = MetabaseQuery($gDatabase, $query);

            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Booking::del()', $query);
            } else {
                $success = MetabaseCommitTransaction($gDatabase); 
                // end transaction
                $auto_commit = true;
                $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
            } 
        } 
    } 

    /**
    * Booking::deloldreservations()
    * 
    * This function marks all old reservations as deleted
    * 
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function deloldreservations()
    {
        global $tbl_booking, $tbl_booking_detail, $gDatabase, $request, $errorhandler; 
        // transaction control
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

        $query = sprintf("SELECT pk_booking_id 
		                  FROM $tbl_booking
						  WHERE booking_type = %s ",
            MetabaseGetTextFieldValue($gDatabase, 'R')
            );
        $query .= "AND DATE_FORMAT( reservation_until, '%Y-%m-%d' ) < CURRENT_DATE( )" . "AND ISNULL(fk_deleted_user_id)";
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Booking::deloldreservations()', $query);
        } else {
            $row = 0;

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $query = sprintf("UPDATE $tbl_booking " . "SET deleted_date = NOW(), " . "fk_deleted_user_id = %s " . "WHERE pk_booking_id = %s ",
                    1,
                    MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 0))
                    );

                $result2 = MetabaseQuery($gDatabase, $query);

                if (!$result2) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Booking::deloldreservations()', $query);
                } else {
                    $query = sprintf("UPDATE $tbl_booking_detail " . "SET deleted_date = NOW(), " . "fk_deleted_user_id = %s " . "WHERE fk_booking_id = %s ",
                        1,
                        MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 0))
                        );
                    $result2 = MetabaseQuery($gDatabase, $query);

                    if (!$result2) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Booking::deloldreservations()', $query);
                    } else {
                        $success = MetabaseCommitTransaction($gDatabase); 
                        // end transaction
                        $auto_commit = true;
                        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
                    } 
                } 
            } 
        } 
    } 

    /**
    * Booking::getoldreservations()
    * 
    * This function returns all old reservations
    * 
    * @access public 
    * @return array reservations
    * @since 2004-02-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getoldreservations()
    {
        global $tbl_booking, $tbl_guest, $tbl_salutation, $gDatabase, $request, $errorhandler;

        $query = "SELECT b.pk_booking_id, DATE_FORMAT( b.start_date, '%d.%m.%Y' ), DATE_FORMAT( b.end_date, '%d.%m.%Y' ),
				  s.salutation_de, g.academic_title, g.firstname, g.lastname
		          FROM $tbl_booking b
				  LEFT JOIN $tbl_guest g ON b.fk_guest_id = g.pk_guest_id
				  LEFT JOIN $tbl_salutation s ON g.fk_salutation_id = s.pk_salutation_id
				  WHERE b.booking_type = ";
        $query .= MetabaseGetTextFieldValue($gDatabase, 'R');
        $query .= "AND DATE_FORMAT( b.reservation_until, '%Y-%m-%d' ) < CURRENT_DATE( )
		           AND ISNULL(b.fk_deleted_user_id)";

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Booking::getoldreservations()', $query);
        } else {
            $row = 0;
            $reservations = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $reservations[$row] = array ('bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'startdate' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'enddate' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'salutation' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'academictitle' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'color' => $color
                    );
            } 
            return $reservations;
        } 
    } 

    /**
    * Booking::deloldreservation()
    * 
    * This function marks an old reservation as deleted
    * 
    * @param number $bookingid booking id
    * @access public 
    * @since 2004-02-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function deloldreservation($bookingid)
    {
        global $tbl_booking, $tbl_booking_detail, $gDatabase, $request, $errorhandler; 
        // transaction control
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

        $query = sprintf("UPDATE $tbl_booking 
		                  SET deleted_date = NOW(), 
						  fk_deleted_user_id = %s 
						  WHERE pk_booking_id = %s ",
            1,
            MetabaseGetTextFieldValue($gDatabase, $bookingid)
            );

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Booking::deloldreservation()', $query);
        } else {
            $query = sprintf("UPDATE $tbl_booking_detail 
							   SET deleted_date = NOW(), 
							   fk_deleted_user_id = %s 
							   WHERE fk_booking_id = %s ",
                1,
                MetabaseGetTextFieldValue($gDatabase, $bookingid)
                );
            $result = MetabaseQuery($gDatabase, $query);

            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Booking::deloldreservation()', $query);
            } else {
                $success = MetabaseCommitTransaction($gDatabase); 
                // end transaction
                $auto_commit = true;
                $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
            } 
        } 
    } 

    /**
    * Booking::extendreservation()
    * 
    * This function extends the duration of a reservation
    * 
    * @param number $bookingid booking id
    * @param date $date date
    * @access public 
    * @since 2004-02-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function extendreservation($bookingid, $date)
    {
        global $tbl_booking, $gDatabase, $errorhandler, $request;
        $reservationuntil = explode(".", $date);
        $strreservationuntil = $reservationuntil[2] . "-" . $reservationuntil[1] . "-" . $reservationuntil[0];
        $query = sprintf("UPDATE $tbl_booking 
		                  SET reservation_until = %s,
						  updated_date = NOW(), 
						  fk_updated_user_id = %s 
						  WHERE pk_booking_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $strreservationuntil),
            $request->GetVar('uid', 'session'),
            MetabaseGetTextFieldValue($gDatabase, $bookingid)
            );

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Booking::extendreservation()', $query);
        } 
    } 

    /**
    * Booking::getFreeRooms()
    * 
    * This function return free rooms
    * within a time period given by start and end
    * 
    * @param timestamp $start startdate
    * @param timestamp $end enddate
    * @return array returns an array of freerooms
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getFreeRooms($start, $end)
    {
        global $tbl_booking_detail, $tbl_room, $gDatabase, $errorhandler;
        $freerooms = array();
        $start = $start + 1;
        $end = $end-1;
        $query = sprintf("SELECT DISTINCT fk_room_id  
		                 FROM $tbl_booking_detail 
						 WHERE (%s BETWEEN UNIX_TIMESTAMP(start_date) AND UNIX_TIMESTAMP(end_date) 
						 OR %s BETWEEN UNIX_TIMESTAMP(start_date) AND UNIX_TIMESTAMP(end_date))
						 AND ISNULL(fk_deleted_user_id)",
            MetabaseGetTextFieldValue($gDatabase, $start),
            MetabaseGetTextFieldValue($gDatabase, $end)
            );
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Booking::getFreeRooms()', $query);
        } else {
            $row = 0;
            $occupied = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $occupied[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
            } 

            $where = "pk_room_id NOT  IN (";
            for ($i = 0; $i < count($occupied); $i++) {
                if ($i > 0) {
                    $where .= ", ";
                } 
                $where .= MetabaseGetTextFieldValue($gDatabase, $occupied[$i]);
            } 
            $where .= ")";

            $query = "SELECT pk_room_id, room 
			          FROM $tbl_room 
					  WHERE " . $where . " AND ISNULL(fk_deleted_user_id)";

            $result = MetabaseQuery($gDatabase, $query);

            if (!$result) {
                $errorhandler->display('SQL', 'Booking::getFreeRooms()', $query);
            } else {
                $row = 0;

                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $freerooms[$row] = array ('roomid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        'name' => MetabaseFetchResult($gDatabase, $result, $row, 1)
                        );
                } 
            } 
        } 

        return $freerooms;
    } 

    /**
    * Booking::get()
    * 
    * Get the data of a booking
    * All data like guestid, roomid, time are returned
    * 
    * @param number $bookingdetailid id of booking detail
    * @return array all data for a booking
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($bookingdetailid)
    {
        global $tbl_booking, $tbl_booking_detail, $tbl_guest, $tbl_guest_address, $tbl_room, $tbl_bookingcat, $gDatabase, $errorhandler;

        $query = "SELECT b.fk_bookingcat_id, b.fk_guest_id, bd.fk_room_id, 
		          UNIX_TIMESTAMP(b.start_date), UNIX_TIMESTAMP(b.end_date), b.persons, 
				  b.children, g.firstname, g.lastname, r.room, 
				  bc.bookingcat, TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) AS days, 
				  b.booking_type, DATE_FORMAT(b.reservation_until, '%d.%m.%Y'), b.additional_info, 
				  bd.fk_booking_id, r.capacity, ga.pk_fk_address_id, b.booking_reference_id,
				  b.children2, b.children3, b.children0 
				  FROM $tbl_booking b, $tbl_booking_detail bd, $tbl_guest g, $tbl_room r, $tbl_bookingcat bc 
				  LEFT JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
				  WHERE bd.pk_booking_detail_id = " . $bookingdetailid . " 
				  AND b.pk_booking_id = bd.fk_booking_id 
				  AND b.fk_guest_id = g.pk_guest_id 
				  AND bd.fk_room_id = r.pk_room_id 
				  AND b.fk_bookingcat_id = bc.pk_bookingcat_id "; 
        // "AND g.pk_guest_id = ga.pk_fk_guest_id ".
        // "AND ga.default_address = ".MetabaseGetBooleanFieldValue($gDatabase, true);
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::get()', $query);
        } else {
            $row = 0;
            $booking = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $bookingtype = "";
                switch (MetabaseFetchResult($gDatabase, $result, $row, 12)) {
                    case 'R':
                        $bookingtype = "Reservierung";
                        break;
                    case 'B':
                        $bookingtype = "Buchung";
                        break;
                    case 'P':
                        $bookingtype = "Abgerechnet";
                        break;
                } 

                $booking = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'gastid' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'roomid' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'start' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'end' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'days' => MetabaseFetchResult($gDatabase, $result, $row, 11),
                    'persons' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'children' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'room' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 7) . " " . MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'nicestart' => date("d. m. Y", MetabaseFetchResult($gDatabase, $result, $row, 3)),
                    'niceend' => date("d. m. Y", MetabaseFetchResult($gDatabase, $result, $row, 4)),
                    'catname' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                    'bookingtypename' => $bookingtype,
                    'bookingtype' => MetabaseFetchResult($gDatabase, $result, $row, 12),
                    'reservationuntil' => MetabaseFetchResult($gDatabase, $result, $row, 13),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 14),
                    'bookid' => MetabaseFetchResult($gDatabase, $result, $row, 15),
                    'bookingdetailid' => $bookingdetailid,
                    'capacity' => MetabaseFetchResult($gDatabase, $result, $row, 16),
                    'addressid' => MetabaseFetchResult($gDatabase, $result, $row, 17),
                    'referenceid' => MetabaseFetchResult($gDatabase, $result, $row, 18),
                    'children2' => MetabaseFetchResult($gDatabase, $result, $row, 19),
                    'children3' => MetabaseFetchResult($gDatabase, $result, $row, 20),
					'children0' => MetabaseFetchResult($gDatabase, $result, $row, 21),
                    'additionalguests' => $this->getAdditionalGuest($bookingdetailid, MetabaseFetchResult($gDatabase, $result, $row, 1))
                    );
            } 
            return $booking;
        } 
    } 

    /**
    * Booking::getMeldedata()
    * 
    * Get the data for "Meldeschein"
    * All data like guestid, roomid, time are returned
    * 
    * @param number $bookid id of booking
    * @return array all data for a booking
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getMeldedata($bookid)
    {
        global $tbl_booking, $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_room, $tbl_bookingcat, $tbl_country, $gDatabase, $errorhandler, $request;

        /*$query = "SELECT $tbl_booking.fk_bookingcat_id, $tbl_booking.fk_guest_id, " . "UNIX_TIMESTAMP(start_date), UNIX_TIMESTAMP(end_date), TO_DAYS( end_date ) - TO_DAYS( start_date ) AS days, $tbl_booking.persons, " . "children, firstname, lastname, $tbl_bookingcat.bookingcat, " . "DATE_FORMAT($tbl_guest.date_of_birth , '%d.%m.%Y'), postalcode, city, " . "address, country_de " . "FROM $tbl_booking, $tbl_guest, $tbl_guest_address, $tbl_address, $tbl_room, $tbl_bookingcat, $tbl_country " .
        sprintf("WHERE pk_booking_id = %s " . "AND $tbl_booking.fk_guest_id = $tbl_guest.pk_guest_id " . "AND $tbl_booking.fk_bookingcat_id = $tbl_bookingcat.pk_bookingcat_id " . "AND fk_country_id = $tbl_country.pk_country_id " . "AND $tbl_guest.pk_guest_id = $tbl_guest_address.pk_fk_guest_id " . "AND $tbl_guest_address.default_address  = %s " . "AND $tbl_address.pk_address_id = $tbl_guest_address.pk_fk_address_id",
            $bookid,
            MetabaseGetBooleanFieldValue($gDatabase, true)
            );
*/
        $query = "SELECT $tbl_booking.fk_bookingcat_id, $tbl_booking.fk_guest_id, 
				  UNIX_TIMESTAMP(start_date), UNIX_TIMESTAMP(end_date), 
				  TO_DAYS( end_date ) - TO_DAYS( start_date ) AS days, $tbl_booking.persons, 
				  children, firstname, lastname, $tbl_bookingcat.bookingcat, 
				  DATE_FORMAT($tbl_guest.date_of_birth , '%d.%m.%Y'), postalcode, city, 
				  address, c.country_de, birthplace, n.country_de AS nationality, identification, 
				  passport, agency, DATE_FORMAT(issue_date, '%d.%m.%Y') 
				  FROM $tbl_booking 
				  LEFT JOIN $tbl_guest ON ($tbl_booking.fk_guest_id = $tbl_guest.pk_guest_id) 
				  LEFT JOIN $tbl_guest_address ON ($tbl_guest_address.default_address  = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
				  AND $tbl_guest.pk_guest_id = $tbl_guest_address.pk_fk_guest_id) 
				  LEFT JOIN $tbl_address ON ($tbl_address.pk_address_id = $tbl_guest_address.pk_fk_address_id) 
				  LEFT JOIN $tbl_bookingcat ON ($tbl_booking.fk_bookingcat_id = $tbl_bookingcat.pk_bookingcat_id) 
				  LEFT JOIN $tbl_country c ON (fk_country_id = c.pk_country_id )
				  LEFT JOIN $tbl_country n ON (fk_nationality_id  = n.pk_country_id )
				  WHERE pk_booking_id =  " . $bookid;
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Booking::getMeldedata()', $query);
        } else {
            $booking = array();

            $booking = array ('catid' => MetabaseFetchResult($gDatabase, $result, 0, 0),
                'gastid' => MetabaseFetchResult($gDatabase, $result, 0, 1),
                'start' => MetabaseFetchResult($gDatabase, $result, 0, 2),
                'end' => MetabaseFetchResult($gDatabase, $result, 0, 3),
                'days' => MetabaseFetchResult($gDatabase, $result, 0, 4),
                'persons' => MetabaseFetchResult($gDatabase, $result, 0, 5),
                'children' => MetabaseFetchResult($gDatabase, $result, 0, 6),
                'firstname' => MetabaseFetchResult($gDatabase, $result, 0, 7),
                'lastname' => MetabaseFetchResult($gDatabase, $result, 0, 8),
                'nicestart' => date("d. m. Y", MetabaseFetchResult($gDatabase, $result, 0, 2)),
                'niceend' => date("d. m. Y", MetabaseFetchResult($gDatabase, $result, 0, 3)),
                'catname' => MetabaseFetchResult($gDatabase, $result, 0, 9),
                'birthdate' => MetabaseFetchResult($gDatabase, $result, 0, 10),
                'zip' => MetabaseFetchResult($gDatabase, $result, 0, 11),
                'city' => MetabaseFetchResult($gDatabase, $result, 0, 12),
                'street' => MetabaseFetchResult($gDatabase, $result, 0, 13),
                'country' => MetabaseFetchResult($gDatabase, $result, 0, 14),
                'birthplace' => MetabaseFetchResult($gDatabase, $result, 0, 15),
                'nationality' => MetabaseFetchResult($gDatabase, $result, 0, 16),
                'identity' => MetabaseFetchResult($gDatabase, $result, 0, 17),
                'passport' => MetabaseFetchResult($gDatabase, $result, 0, 18),
                'agency' => MetabaseFetchResult($gDatabase, $result, 0, 19),
                'issue_date' => MetabaseFetchResult($gDatabase, $result, 0, 20)
                );

            return $booking;
        } 
    } 

    /**
    * Booking::emailConfirmation()
    * 
    * Create a mailto link for email confirmation
    * 
    * @param number $bookid id of booking
    * @return string mailto link
    * @access public 
    * @since 2003-09-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function emailConfirmation($bookid)
    {
        include_once("../includes/fileselector.inc.php");
        include_once(selectfile('emailconfirmation.php'));
        return createEmailConfirmation($bookid);
    } 

    /**
    * Booking::addAdditionalGuest()
    * 
    * add additional guest to a booking
    * 
    * @param number $bookingdetailid id of bookingdetail
    * @param number $guestid id of guest
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function addAdditionalGuest($bookingdetailid, $guestid)
    {
        global $tbl_booking_detail_guest, $gDatabase, $errorhandler, $request;

        $query = sprintf("INSERT INTO $tbl_booking_detail_guest 
		                 (pk_fk_booking_detail_id, pk_fk_guest_id)
						 VALUES (%s, %s )",
            $bookingdetailid,
            $guestid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::addAdditionalGuest()', $query);
        } 
    } 

    /**
    * Booking::getAdditionalGuest()
    * 
    * Get the data of additional guests for a bookingdetail
    * 
    * @param number $bookingdetailid id of bookingdetail
    * @param number $keepoutguestid id of "mainguest" which will be left out
    * @return array guest data
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getAdditionalGuest($bookingdetailid, $keepoutguestid)
    {
        global $tbl_booking_detail_guest, $tbl_guest, $gDatabase, $errorhandler;

        $query = sprintf("SELECT pk_guest_id, firstname, lastname 
						FROM $tbl_guest, $tbl_booking_detail_guest 
						WHERE pk_fk_booking_detail_id = %s 
						AND pk_guest_id = pk_fk_guest_id 
						AND pk_guest_id <> %s 
						ORDER BY lastname, firstname ",
            $bookingdetailid,
            $keepoutguestid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::getAdditionalGuest()', $query);
        } else {
            $guests = array();
            $row = 0;

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $guests[$row] = array ('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2)
                    );
            } 
            return $guests;
        } 
    } 

    /**
    * Booking::delAdditionalGuest()
    * 
    * Deletes an additional guest for a booking
    * 
    * @param number $bookingdetailid id of bookingdetail
    * @param number $delguestid id of guest to delete
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function delAdditionalGuest($bookingdetailid, $delguestid)
    {
        global $tbl_booking_detail_guest, $gDatabase, $errorhandler;

        $query = sprintf("DELETE FROM $tbl_booking_detail_guest 
						WHERE pk_fk_booking_detail_id = %s 
						AND pk_fk_guest_id = %s ",
            $bookingdetailid,
            $delguestid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::delAdditionalGuest()', $query);
        } 
    } 

    /**
    * Booking::bookingConfirmationMail()
    * 
    * prepares the link for a confirmation email
    * 
    * @param number $bookid id of booking
    * @return string link
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function bookingConfirmationMail($bookid)
    {
        $query = "SELECT salutation_de, academic_title, firstname, lastname, " . "formal_greeting, start_date, end_date, persons, children, " . "booking_type, reservation_until, email " . "FROM $tbl_salutation, $tbl_guest, $tbl_booking, " . "$tbl_address, $tbl_guest_address " . "WHERE pk_salutation_id = fk_salutation_id " . "AND pk_guest_id = fk_guest_id " . "AND pk_fk_guest_id = pk_guest_id " . "AND pk_fk_address_id = pk_address_id " . "AND default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " " . "AND pk_booking_id = " . $bookid;

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::bookingConfirmationMail()', $query);
        } else {
            $mailto = MetabaseFetchResult($gDatabase, $result, 0, 11);
        } 

        $subject = "";
        $body = "";
    } 

    /**
    * Booking::searchWithoutEscorts()
    * 
    * search for a guest without escorts
    * 
    * @param int $bookingdetailid booking detail id
    * @param string $firstname firstname
    * @param string $lastname lastname
    * @return array guest data
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function searchWithoutEscorts($bookingdetailid, $firstname, $lastname)
    {
        global $gDatabase, $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_booking_detail_guest, $tbl_country, $errorhandler, $request;

        $guest = array();
        $exclguest = array();

        $query = "SELECT pk_fk_guest_id FROM $tbl_booking_detail_guest WHERE pk_fk_booking_detail_id = $bookingdetailid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::searchWithoutEscorts()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $exclguest[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
            } 
        } 
        $query = "SELECT pk_guest_id, firstname, lastname, city, fk_country_id, country_de 
				  FROM $tbl_guest g 
				  LEFT JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id 
				  							AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . "
				  LEFT JOIN $tbl_address a ON a.pk_address_id = ga.pk_fk_address_id
	              LEFT JOIN $tbl_country c ON c.pk_country_id = a.fk_country_id 
				  ";
        if (count($exclguest > 0)) {
            $query .= " WHERE g.pk_guest_id ";
            if (count($exclguest) > 1) {
                $query .= " NOT IN (";
                for ($i = 0; $i < count($exclguest); $i++) {
                    if ($i <> 0) {
                        $query .= ", ";
                    } 
                    $query .= $exclguest[$i];
                } 
                $query .= ") ";
            } else {
                $query .= "<> $exclguest[0] ";
            } 
            if ($firstname != "" or $lastname != "") {
                $query .= "AND ";
            } 
        } else {
            if ($firstname != "" or $lastname != "") {
                $query .= "WHERE ";
            } 
        } 

        if ($firstname != "") {
            $query .= "firstname LIKE '%" . $firstname . "%' ";
        } 
        if ($firstname != "" and $lastname != "") {
            $query .= "AND ";
        } 
        if ($lastname != "") {
            $query .= "lastname LIKE '%" . $lastname . "%' ";
        } 

        $query .= "GROUP BY pk_guest_id ORDER BY lastname ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::searchWithoutEscorts()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $guest[$row] = array('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'city' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'country' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'country_name' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'color' => $color
                    );
            } 
        } 

        return $guest;
    } 

    /**
    * Booking::getDate()
    * 
    * Get date of a booking
    * 
    * @param number $bookingid id of booking
    * @return array dates for a booking
    * @access public 
    * @since 2004-04-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getDate($bookingid)
    {
        global $tbl_booking, $gDatabase, $errorhandler;

        $query = "SELECT DATE_FORMAT(b.start_date, '%d.%m.%Y'), DATE_FORMAT(b.end_date, '%d.%m.%Y'),  
				  b.booking_type, b.booking_reference_id 
				  FROM $tbl_booking b
				  WHERE b.pk_booking_id = " . $bookingid;
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::getDate()', $query);
        } else {
            $row = 0;
            $booking = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $bookingtype = "";
                switch (MetabaseFetchResult($gDatabase, $result, $row, 2)) {
                    case 'R':
                        $bookingtype = "Reservierung";
                        break;
                    case 'B':
                        $bookingtype = "Buchung";
                        break;
                    case 'P':
                        $bookingtype = "Abgerechnet";
                        break;
                } 

                $booking = array ('bookid' => $bookingid,
                    'start' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'end' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'bookingtype' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'bookingreferenceid' => MetabaseFetchResult($gDatabase, $result, $row, 3)
                    );
            } 
            return $booking;
        } 
    } 

    /**
    * Booking::linkGuestAddress()
    * 
    * link the addresses form one guest to another
    * 
    * @param number $guestid id of source guest
    * @param number $guestid id of second guest
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function linkGuestAddress($guestid, $guestid2)
    {
        global $tbl_guest_address, $gDatabase, $errorhandler, $request;

        $query = sprintf("SELECT pk_fk_address_id, address_type, default_address
						 FROM $tbl_guest_address 
		                 WHERE pk_fk_guest_id = %s",
            $guestid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::linkGuestAddress()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $query = sprintf("INSERT INTO $tbl_guest_address 
								(pk_fk_guest_id, pk_fk_address_id, address_type, default_address)
								VALUES (%s, %s, %s, %s)",
                    $guestid2,
                    MetabaseFetchResult($gDatabase, $result, $row, 0),
                    MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 1)),
                    MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 2))
                    );
                $result2 = MetabaseQuery($gDatabase, $query);
                if (!$result2) {
                    $errorhandler->display('SQL', 'Booking::linkGuestAddress()', $query);
                } 
            } 
        } 
    } 

    /**
    * Booking::showPossibleEscorts()
    * 
    * show all guest who have a booking with a guest without actual escorts
    * 
    * @param int $bookingdetailid booking detail id
	* @param int $guestid guest id
    * @return array guest data
    * @access public 
    * @since 2004-06-27
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function showPossibleEscorts($bookingdetailid, $guestid)
    {
        global $gDatabase, $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_booking_detail_guest, $tbl_country, $errorhandler, $request;

        $guest = array();
        $exclguest = array();

        $query = "SELECT pk_fk_guest_id FROM $tbl_booking_detail_guest WHERE pk_fk_booking_detail_id = $bookingdetailid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::showPossibleEscorts()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $exclguest[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
            } 
        } 
		MetabaseFreeResult($gDatabase, $result);
        $query = "( 
					SELECT DISTINCT b.fk_guest_id AS pk_guest_id, g.lastname AS lastname, 
						g.firstname AS firstname, a.city AS city, c.country_de  AS country_de 
					FROM zvs_booking_detail_guest bdg 
					LEFT JOIN zvs_booking_detail bd ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id 
					LEFT JOIN zvs_booking b ON bd.fk_booking_id = b.pk_booking_id 
					LEFT JOIN zvs_guest g ON b.fk_guest_id = g.pk_guest_id 
				  LEFT JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id 
				  							AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . "				  
				  LEFT JOIN $tbl_address a ON a.pk_address_id = ga.pk_fk_address_id
	              LEFT JOIN $tbl_country c ON c.pk_country_id = a.fk_country_id 					
					WHERE bdg.pk_fk_guest_id =  $guestid 
						AND b.fk_guest_id != $guestid 
				";
        if (count($exclguest > 0)) {
            $query .= " AND g.pk_guest_id ";
            if (count($exclguest) > 1) {
                $query .= " NOT IN (";
                for ($i = 0; $i < count($exclguest); $i++) {
                    if ($i <> 0) {
                        $query .= ", ";
                    } 
                    $query .= $exclguest[$i];
                } 
                $query .= ") ";
            } else {
                $query .= "<> $exclguest[0] ";
            } 
        } 
	
        $query .= "	GROUP BY pk_guest_id 					
				  ) UNION ( 
				    SELECT DISTINCT bdg2.pk_fk_guest_id AS pk_guest_id, g.lastname AS lastname, 
						g.firstname AS firstname, a.city AS city, c.country_de  AS country_de
					FROM zvs_booking_detail_guest bdg 
					LEFT JOIN zvs_booking_detail bd ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id 
					LEFT JOIN zvs_booking b ON bd.fk_booking_id = b.pk_booking_id 
					LEFT JOIN zvs_booking_detail bd2 ON b.pk_booking_id = bd2.fk_booking_id 
					LEFT JOIN zvs_booking_detail_guest bdg2 ON bd2.pk_booking_detail_id = bdg2.pk_fk_booking_detail_id 
					LEFT JOIN zvs_guest g ON bdg2.pk_fk_guest_id = g.pk_guest_id 
				  LEFT JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id 
				  	AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . "
				  LEFT JOIN $tbl_address a ON a.pk_address_id = ga.pk_fk_address_id
	              LEFT JOIN $tbl_country c ON c.pk_country_id = a.fk_country_id 					
					WHERE bdg.pk_fk_guest_id =  $guestid 
						 AND bdg2.pk_fk_guest_id != $guestid 
				";
        if (count($exclguest > 0)) {
            $query .= " AND g.pk_guest_id ";
            if (count($exclguest) > 1) {
                $query .= " NOT IN (";
                for ($i = 0; $i < count($exclguest); $i++) {
                    if ($i <> 0) {
                        $query .= ", ";
                    } 
                    $query .= $exclguest[$i];
                } 
                $query .= " ) ";
            } else {
                $query .= "<> $exclguest[0] ";
            } 
        } 

        $query .= " GROUP BY pk_guest_id 
				) 
				ORDER BY lastname, firstname ";

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Booking::showPossibleEscorts()', $query);
        } else {
            $row = 0;
            for ($row = 0; $row < MetabaseNumberOfRows($gDatabase, $result); ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $guest[$row] = array('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'city' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'country_name' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'color' => $color
                    );
            } 
        } 
        return $guest;
    } 

    /**
    * Booking::getBookingDetailId()
    * 
    * Gets the bookingdetailid for a booking
    * 
    * @param number $bookingid id of booking
    * @return bookingdetailid
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getBookingDetailId($bookingid)
    {
        global $tbl_booking_detail, $gDatabase, $errorhandler;

        $query = "SELECT pk_booking_detail_id FROM $tbl_booking_detail 
						WHERE fk_booking_id = $bookingid ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Booking::getBookingDetailId()', $query);
        } 
		return  MetabaseFetchResult($gDatabase, $result, 0, 0);
    } 

} 

?>
