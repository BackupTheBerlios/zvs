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
* class guestlist
* 
* Class for guestlist
* 
* This class has all functions which are needed for the lists.
* 
* @author Christian Ehret <chris@uffbasse.de> 
* @since 2004-06-05
* @version $Id: guestlistclass.inc.php,v 1.2 2005/03/14 16:10:35 ehret Exp $
*/
class Guestlist {
    /**
    * Guestlist::get()
    * 
    * This function returns a list of guests wich are checked in.
    * 
    * @return array guests
    * @access public 
    * @param int $bcat booking category (-1 for all)
    * @since 2004-06-05
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($bcat)
    {
        global $gDatabase, $tbl_booking, $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_room, $tbl_booking_detail, $tbl_bookingcat, $tbl_booking_detail_guest, $errorhandler;

        $guests = array();
        $query = "SELECT b.pk_booking_id, b.fk_guest_id, g.firstname, g.lastname, 
		                  DATE_FORMAT(b.start_date, '%d.%m.%Y'), 
				 		  DATE_FORMAT(b.end_date, '%d.%m.%Y'), 
				 		  bd.pk_booking_detail_id, r.room, bc.bookingcat,
						  b.persons, b.children, b.children2, b.children3, b.booking_type,
						  a.email " .
        sprintf("FROM $tbl_booking b, $tbl_guest g, $tbl_booking_detail bd
				 		  LEFT JOIN $tbl_room r ON r.pk_room_id = bd.fk_room_id
						  LEFT JOIN $tbl_bookingcat bc ON b.fk_bookingcat_id = bc.pk_bookingcat_id
						  LEFT JOIN $tbl_guest_address ga ON ga.pk_fk_guest_id = g.pk_guest_id AND default_address = %s
						  LEFT JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id
						  WHERE b.checked_in = %s 
						  AND b.checked_out = %s
						  AND g.pk_guest_id = b.fk_guest_id 
						  AND b.pk_booking_id = bd.fk_booking_id 
						  AND ISNULL(b.deleted_date) ",
			MetabaseGetBooleanFieldValue($gDatabase, true),						  
            MetabaseGetBooleanFieldValue($gDatabase, true),
            MetabaseGetBooleanFieldValue($gDatabase, false)
            );
        if ($bcat != -1) {
            $query .= "AND b.fk_bookingcat_id = $bcat ";
        } 
        $query .= "ORDER BY r.room ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Checkout::get()', $query);
        } else {
            $row = 0;
            $person = 0;
            $children1 = 0;
            $children2 = 0;
            $children3 = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (MetabaseFetchResult($gDatabase, $result, $row, 13) == 'R') {
                    $bookingtype = 'Reservierung';
                } elseif (MetabaseFetchResult($gDatabase, $result, $row, 13) == 'B') {
                    $bookingtype = 'Buchung';
                } else {
                    $bookingtype = 'Abgerechnet';
                } 

                $guests[$row] = array ('bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'guestid' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'startdate' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'enddate' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'bookingdetailid' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'room' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'bookingcat' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'person' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                    'children1' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                    'children2' => MetabaseFetchResult($gDatabase, $result, $row, 11),
                    'children3' => MetabaseFetchResult($gDatabase, $result, $row, 12),
                    'bookingtype' => $bookingtype,
					'email' => MetabaseFetchResult($gDatabase, $result, $row, 14),
                    'color' => $color
                    );
                $person += MetabaseFetchResult($gDatabase, $result, $row, 9);
                $children1 += MetabaseFetchResult($gDatabase, $result, $row, 10);
                $children2 += MetabaseFetchResult($gDatabase, $result, $row, 11);
                $children3 += MetabaseFetchResult($gDatabase, $result, $row, 12);
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 
            $guests[$row] = array ('bookingid' => '',
                'guestid' => '',
                'firstname' => '',
                'lastname' => '',
                'startdate' => '',
                'enddate' => '',
                'bookingdetailid' => '',
                'room' => '',
                'bookingcat' => '',
                'person' => $person,
                'children1' => $children1,
                'children2' => $children2,
                'children3' => $children3,
                'bookingtype' => 'Summe: ',
                'color' => $color
                );
        } 
        return $guests;
    } 
    /**
    * Guestlist::getlist()
    * 
    * This function returns a list of guests wich are checked in.
    * 
    * @param date $start start date
    * @param date $end end date
    * @param int $bcat booking cat (-1 for all)
    * @return array guests
    * @access public 
    * @since 2004-06-05
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getlist($start, $end, $bcat)
    {
        global $gDatabase, $tbl_booking, $tbl_guest, $tbl_guest_address, $tbl_address, $tbl_room, $tbl_booking_detail, $tbl_bookingcat, $tbl_booking_detail_guest, $errorhandler;

        $guests = array();
        $query = "SELECT b.pk_booking_id, b.fk_guest_id, g.firstname, g.lastname, 
		                  DATE_FORMAT(b.start_date, '%d.%m.%Y'), 
				 		  DATE_FORMAT(b.end_date, '%d.%m.%Y'), 
				 		  bd.pk_booking_detail_id, r.room, bc.bookingcat,
						  b.persons, b.children, b.children2, b.children3, b.booking_type, a.email " .
        sprintf("FROM $tbl_booking b, $tbl_guest g, $tbl_booking_detail bd
				 		  LEFT JOIN $tbl_room r ON r.pk_room_id = bd.fk_room_id
						  LEFT JOIN $tbl_bookingcat bc ON b.fk_bookingcat_id = bc.pk_bookingcat_id
						  LEFT JOIN $tbl_guest_address ga ON ga.pk_fk_guest_id = g.pk_guest_id AND default_address = %s
						  LEFT JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id						  
						  WHERE ((UNIX_TIMESTAMP(b.start_date) BETWEEN %s AND %s) 
						  OR (UNIX_TIMESTAMP(b.end_date) BETWEEN %s AND %s)
						  OR (%s BETWEEN UNIX_TIMESTAMP(b.start_date) AND UNIX_TIMESTAMP(b.end_date))
						  OR (%s BETWEEN UNIX_TIMESTAMP(b.start_date) AND UNIX_TIMESTAMP(b.end_date)))
						  AND g.pk_guest_id = b.fk_guest_id 
						  AND b.pk_booking_id = bd.fk_booking_id 
						  AND ISNULL(b.deleted_date) ",
			MetabaseGetBooleanFieldValue($gDatabase, true),
            MetabaseGetTextFieldValue($gDatabase, $start),
            MetabaseGetTextFieldValue($gDatabase, $end),
            MetabaseGetTextFieldValue($gDatabase, $start),
            MetabaseGetTextFieldValue($gDatabase, $end),
            MetabaseGetTextFieldValue($gDatabase, $start),
            MetabaseGetTextFieldValue($gDatabase, $end)
            );
        if ($bcat != -1) {
            $query .= "AND b.fk_bookingcat_id = $bcat ";
        } 
        $query .= "ORDER BY r.room ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Checkout::get()', $query);
        } else {
            $row = 0;
            $person = 0;
            $children1 = 0;
            $children2 = 0;
            $children3 = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (MetabaseFetchResult($gDatabase, $result, $row, 13) == 'R') {
                    $bookingtype = 'Reservierung';
                } elseif (MetabaseFetchResult($gDatabase, $result, $row, 13) == 'B') {
                    $bookingtype = 'Buchung';
                } else {
                    $bookingtype = 'Abgerechnet';
                } 

                $guests[$row] = array ('bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'guestid' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'startdate' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'enddate' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'bookingdetailid' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'room' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'bookingcat' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'person' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                    'children1' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                    'children2' => MetabaseFetchResult($gDatabase, $result, $row, 11),
                    'children3' => MetabaseFetchResult($gDatabase, $result, $row, 12),
					'email' => MetabaseFetchResult($gDatabase, $result, $row, 14),
                    'bookingtype' => $bookingtype,
                    'color' => $color
                    );
                $person += MetabaseFetchResult($gDatabase, $result, $row, 9);
                $children1 += MetabaseFetchResult($gDatabase, $result, $row, 10);
                $children2 += MetabaseFetchResult($gDatabase, $result, $row, 11);
                $children3 += MetabaseFetchResult($gDatabase, $result, $row, 12);
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 
            $guests[$row] = array ('bookingid' => '',
                'guestid' => '',
                'firstname' => '',
                'lastname' => '',
                'startdate' => '',
                'enddate' => '',
                'bookingdetailid' => '',
                'room' => '',
                'bookingcat' => '',
                'person' => $person,
                'children1' => $children1,
                'children2' => $children2,
                'children3' => $children3,
                'bookingtype' => 'Summe: ',
                'color' => $color
                );
        } 
        return $guests;
    } 

    /**
    * Guestlist::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2004-06-05
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getdates()
    {
        global $gDatabase, $tbl_booking, $request, $errorhandler;

        $dates = array();
        $j = 0;
        $query = "SELECT DATE_FORMAT(min( start_date  ) ,'%Y'),  DATE_FORMAT(max( end_date  ),'%Y')  
		                 FROM $tbl_booking  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guestlist::getdates()', $query);
        } else {
            $startyear = MetabaseFetchResult($gDatabase, $result, 0, 0);
            $endyear = MetabaseFetchResult($gDatabase, $result, 0, 1);
            for ($year = $startyear; $year <= $endyear; ++$year) {
                for ($i = 1; $i <= 12; $i++) {
                    $dates[$j] = $i . '/' . $year;
                    $j++;
                } 
            } 
        } 
        return $dates;
    } 
    /**
    * Guestlist::getBirthdayList()
    * 
    * This function returns a list of guests wich have their birthday in a given month.
    * 
    * @return array guests
    * @access public 
    * @param number $month Month
    * @since 2004-07-26
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getBirthdayList($month)
    {
        global $gDatabase, $tbl_guest, $errorhandler;

        $guests = array();
        $query = "SELECT pk_guest_id, firstname, lastname, DATE_FORMAT(date_of_birth ,'%d.%m.%Y'),
						 DATE_FORMAT(now(), '%Y') - DATE_FORMAT(date_of_birth ,'%Y')
		                 FROM $tbl_guest
						 WHERE DATE_FORMAT( date_of_birth, '%m' ) = $month 
						 ORDER BY DATE_FORMAT( date_of_birth, '%d') ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guestlist::getBirthdayList()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $guests[$row] = array ('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'birthday' => MetabaseFetchResult($gDatabase, $result, $row, 3),
					'age' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'color' => $color
                    );
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            }
			return $guests; 
        } 
    } 


    /**
    * Guestlist::getBirthdayReminders()
    * 
    * This function returns a list of guests wich have their birthday and the reminder set.
    * 
    * @return array guests
    * @access public 
    * @since 2004-07-26
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getBirthdayReminders()
    {
        global $gDatabase, $tbl_guest, $request, $errorhandler;
		$days = $request->GetVar('birthday_days','Session');
        $guests = array();
        $query = "SELECT pk_guest_id, firstname, lastname, DATE_FORMAT(date_of_birth ,'%d.%m.%Y'),
						 DATE_FORMAT(now(), '%Y') - DATE_FORMAT(date_of_birth ,'%Y')
		                 FROM $tbl_guest
						 WHERE DATE_FORMAT( date_of_birth, '%m%d' ) BETWEEN DATE_FORMAT( now(), '%m%d' ) AND DATE_FORMAT( DATE_ADD(now(), INTERVAL $days DAY), '%m%d' ) 				  
						 AND birthday_reminder = ". MetabaseGetBooleanFieldValue($gDatabase, true)."
						 ORDER BY DATE_FORMAT( date_of_birth, '%d') ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guestlist::getBirthdayReminders()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $guests[$row] = array ('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'birthday' => MetabaseFetchResult($gDatabase, $result, $row, 3),
					'age' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'color' => $color
                    );
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            }
			return $guests; 
        } 
    } 


} 

?>
