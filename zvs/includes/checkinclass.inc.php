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
* class Checkin
* 
* Class for checkins
* 
* This class has all functions which are needed for the checkin progress.
* 
* @author Christian Ehret <chris@uffbasse.de> 
* @since 2003-09-02
* @version $Id: checkinclass.inc.php,v 1.1 2004/11/03 14:43:39 ehret Exp $
*/
class Checkin {
    /**
    * Checkin::get()
    * 
    * This function returns a list of guests not checked in yet.
    * 
    * @return array guests
    * @access public 
    * @since 2003-09-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get()
    {
        global $gDatabase, $tbl_booking, $tbl_guest, $tbl_booking_detail, $tbl_booking_detail_guest, $errorhandler;

        $guests = array();
        $query = "SELECT pk_booking_id, fk_guest_id, firstname, lastname, " . "DATE_FORMAT($tbl_booking.start_date, '%d.%m.%Y'), " . "DATE_FORMAT($tbl_booking.end_date, '%d.%m.%Y'), " . "pk_booking_detail_id " .
        sprintf("FROM $tbl_booking, $tbl_guest, $tbl_booking_detail " . "WHERE checked_in = %s " . "AND $tbl_booking.start_date <= NOW() " . "AND pk_guest_id = fk_guest_id " . "AND pk_booking_id = fk_booking_id " . "AND ISNULL($tbl_booking.deleted_date) " . "ORDER BY lastname",
            MetabaseGetBooleanFieldValue($gDatabase, false)
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Checkin::get()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $guests[$row] = array ('bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'guestid' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'startdate' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'enddate' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'bookingdetailid' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'color' => $color
                    );
            } 
        } 
        return $guests;
    } 

    /**
    * Checkin::checkbookingin()
    * 
    * This function checks in a booking.
    * 
    * @param integer $bookingid bookingid
    * @access public 
    * @since 2003-09-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function checkbookingin($bookingid)
    {
        global $gDatabase, $tbl_booking, $errorhandler;

        $guests = array();
        $query = sprintf("UPDATE $tbl_booking " . "SET checked_in = %s " . "WHERE pk_booking_id = %s ",
            MetabaseGetBooleanFieldValue($gDatabase, true),
            $bookingid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Checkin::checkin()', $query);
        } 
    } 
} 

?>
