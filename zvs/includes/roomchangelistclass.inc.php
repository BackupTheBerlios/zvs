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
* class roomchangelist
* 
* Class for generating room change lists
* 
* This class has all functions which are needed for the lists.
* 
* @author Christian Ehret <chris@uffbasse.de> 
* @since 2004-06-12
* @version $Id: roomchangelistclass.inc.php,v 1.1 2004/11/03 14:51:26 ehret Exp $
*/
class Roomchangelist {
    /**
    * roomchangelist::getlist()
    * 
    * This function returns a list of room changes.
    * 
    * @param date $start start date
    * @param date $end end date
    * @return array guests
    * @access public 
    * @since 2004-06-12
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getlist($start, $end)
    {
        global $gDatabase, $tbl_booking, $tbl_room, $tbl_guest, $tbl_booking_detail, $tbl_bookingcat, $tbl_booking_detail_guest, $errorhandler;

        $bookings = array();
		//$start = $start -1;
		$end = $end -1;
        $query = "SELECT bd.end_date, DATE_FORMAT(bd.end_date, '%d.%m.%Y'), 
						  r.room, bd.fk_room_id " .
        sprintf("FROM $tbl_booking b, $tbl_booking_detail bd
				 		  LEFT JOIN $tbl_room r ON r.pk_room_id = bd.fk_room_id
						  WHERE (UNIX_TIMESTAMP(bd.end_date) BETWEEN %s AND %s) 
						  AND b.pk_booking_id = bd.fk_booking_id 
						  AND ISNULL(b.deleted_date) 
						  ORDER BY bd.end_date, r.room",
            MetabaseGetTextFieldValue($gDatabase, $start),
            MetabaseGetTextFieldValue($gDatabase, $end)
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Roomchangelist::getlist()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $enddate = MetabaseFetchResult($gDatabase, $result, $row, 0);
                $roomid = MetabaseFetchResult($gDatabase, $result, $row, 3);
                $query = "SELECT 
		                  DATE_FORMAT(bd.start_date, '%d.%m.%Y'), 
				 		  bc.bookingcat,
						  b.persons, b.children, b.children2, b.children3, b.booking_type,
						  g.firstname, g.lastname, b.additional_info, DATE_FORMAT(bd.end_date, '%d.%m.%Y')
                          FROM $tbl_booking b, $tbl_booking_detail bd
						  LEFT JOIN $tbl_guest g ON b.fk_guest_id = g.pk_guest_id
				 		  LEFT JOIN $tbl_room r ON r.pk_room_id = bd.fk_room_id
						  LEFT JOIN $tbl_bookingcat bc ON b.fk_bookingcat_id = bc.pk_bookingcat_id
						  WHERE bd.fk_room_id = $roomid AND bd.start_date >= '$enddate'
						  AND b.pk_booking_id = bd.fk_booking_id 
						  AND ISNULL(b.deleted_date) 
						  ORDER BY bd.start_date LIMIT 0,1";

                $result2 = MetabaseQuery($gDatabase, $query);
                if (!$result2) {
                    $errorhandler->display('SQL', 'Roomchangelist::getlist()', $query);
                } elseif (MetabaseNumberOfRows($gDatabase, $result2) == 1) {
                    $bookings[$row] = array ('enddate' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'room' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                        'color' => $color,
                        'startdate' => MetabaseFetchResult($gDatabase, $result2, 0, 0),
                        'bookingcat' => MetabaseFetchResult($gDatabase, $result2, 0, 1),
                        'person' => MetabaseFetchResult($gDatabase, $result2, 0, 2),
                        'children1' => MetabaseFetchResult($gDatabase, $result2, 0, 3),
                        'children2' => MetabaseFetchResult($gDatabase, $result2, 0, 4),
                        'children3' => MetabaseFetchResult($gDatabase, $result2, 0, 5),
						'firstname' => MetabaseFetchResult($gDatabase, $result2, 0, 7),
						'lastname' => MetabaseFetchResult($gDatabase, $result2, 0, 8),
						'addinfo' => MetabaseFetchResult($gDatabase, $result2, 0, 9),
						'enddate2' => MetabaseFetchResult($gDatabase, $result2, 0, 10)
                        );
                } else {
                    $bookings[$row] = array ('enddate' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'room' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                        'color' => $color,
                        'startdate' => "",
                        'bookingcat' => "",
                        'person' => "",
                        'children1' => "",
                        'children2' => "",
                        'children3' => "",
						'firstname' => "",
						'lastname' => "",
						'addinfo' => "",	
						'enddate2' => ""					
                        );
                } 
            } 
        } 
        return $bookings;
    } 

    /**
    * roomchangelist::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2004-06-12
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
            $errorhandler->display('SQL', 'roomchangelist::getdates()', $query);
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
} 

?>
