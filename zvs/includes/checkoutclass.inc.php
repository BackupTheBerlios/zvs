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
* class Checkout
* 
* Class for checkouts
* 
* This class has all functions which are needed for the checkout progress.
* 
* @author Christian Ehret <chris@uffbasse.de> 
* @since 2003-09-02
* @version $Id: checkoutclass.inc.php,v 1.1 2004/11/03 14:50:54 ehret Exp $
*/
class Checkout {
    /**
    * Checkout::get()
    * 
    * This function returns a list of guests checked in.
    * 
    * @return array guests
    * @access public 
    * @since 2004-01-22
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get()
    {
        global $gDatabase, $tbl_booking, $tbl_guest, $tbl_room, $tbl_booking_detail, $tbl_booking_detail_guest, $errorhandler;

        $guests = array();
        $query =         "SELECT pk_booking_id, fk_guest_id, firstname, lastname, 
		                  DATE_FORMAT($tbl_booking.start_date, '%d.%m.%Y'), 
				 		  DATE_FORMAT($tbl_booking.end_date, '%d.%m.%Y'), 
				 		  pk_booking_detail_id, room ". 
        		 sprintf("FROM $tbl_booking, $tbl_guest, $tbl_booking_detail 
				 		  LEFT JOIN $tbl_room ON pk_room_id = fk_room_id
						  WHERE checked_in = %s 
						  AND checked_out = %s
						  AND pk_guest_id = fk_guest_id 
						  AND pk_booking_id = fk_booking_id 
						  AND ISNULL($tbl_booking.deleted_date) 
						  ORDER BY lastname",
            MetabaseGetBooleanFieldValue($gDatabase, true),
			MetabaseGetBooleanFieldValue($gDatabase, false)
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Checkout::get()', $query);
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
					'room' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'color' => $color
                    );
            } 
        } 
        return $guests;
    } 

    /**
    * Checkin::checkbookingout()
    * 
    * This function checks out a booking.
    * 
    * @param integer $bookingid bookingid
    * @access public 
    * @since 2004-01-22
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function checkbookingout($bookingid)
    {
        global $gDatabase, $tbl_booking, $errorhandler;

        $guests = array();
        $query = sprintf("UPDATE $tbl_booking 
		                  SET checked_out = %s 
						  WHERE pk_booking_id = %s ",
            MetabaseGetBooleanFieldValue($gDatabase, true),
            $bookingid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Checkout::checkbookingout()', $query);
        } 
    } 
} 

?>
