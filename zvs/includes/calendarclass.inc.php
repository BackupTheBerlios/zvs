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
* class Calendar
* 
* Class for calendar
* 
* This class has all functions which are needed for displaying the calendar.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: calendarclass.inc.php,v 1.2 2005/01/11 09:18:18 ehret Exp $
*/
class Calendar {
    /**
    * Calendar::returnMonthName()
    * 
    * This function returns the name of a month
    * 
    * @param number $monthnumber number of the month
    * @return string returns the name of a month
    * @access private 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function returnMonthName($monthnumber)
    {
        $month = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
        return $month[$monthnumber];
    } 

    /**
    * Calendar::returnDayName()
    * 
    * This function returns the name of a day
    * 
    * @param number $daynumber number of the day
    * @return string returns the name of a day
    * @access private 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function returnDayName($daynumber)
    {
        $day = array ("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
        while ($daynumber > 6) {
            $daynumber = $daynumber - 7;
        } 
        return $day[$daynumber];
    } 

    /**
    * Calendar::previous_month()
    * 
    * This function calculates the previous month
    * 
    * @param number $month month
    * @param number $year year
    * @param boolean $halfmonth show halfmonth or not
    * @param boolean $correction if true increase month
    * @return string returns a string in url format with month and year
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function previous_month($month, $year, $halfmonth, $correction)
    {
        if ($month > 1) {
            $month = $month - 1;
            $year = $year;
        } elseif ($month == 1) {
            $month = 12;
            $year = $year - 1;
        } 
        if ($correction) {
            if ($month == 12) {
                $month = 1;
                $year = $year + 1;
            } else {
                ++$month;
            } 
        } 
        if ($halfmonth) {
            $url = '/month.' . $month . '/year.' . $year . '/step.half';
        } else {
            $url = '/month.' . $month . '/year.' . $year;
        } 
        return $url;
    } 

    /**
    * Calendar::next_month()
    * 
    * This function calculates the next month
    * 
    * @param number $month month
    * @param number $year year
    * @param boolean $halfmonth show halfmonth or not
    * @param boolean $correction if true increase month
    * @return string returns a string in url format with month and year
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function next_month($month, $year, $halfmonth, $correction)
    {
        if ($month < 12) {
            $month = $month + 1;
            $year = $year;
        } elseif ($month == 12) {
            $month = 1;
            $year = $year + 1;
        } 
        if ($correction) {
            if ($month == 1) {
                $month = 12;
                $year = $year -1;
            } else {
                --$month;
            } 
        } 
        if ($halfmonth) {
            $url = '/month.' . $month . '/year.' . $year . '/step.half';
        } else {
            $url = '/month.' . $month . '/year.' . $year;
        } 
        return $url;
    } 

    /**
    * Calendar::getMonth()
    * 
    * This function returns a month with bookings
    * 
    * @param number $year year
    * @param number $month month
    * @param number $roomid roomid
    * @return array month with bookings
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getMonth($year, $month, $roomid)
    {
        global $tbl_booking_detail, $tbl_booking, $tbl_bookingcat, $tbl_guest, $gDatabase, $request, $errorhandler;
        $first_of_month = mktime (8, 0, 0, $month, 1, $year);
        $maxdays = date('t', $first_of_month);
        $date_info = getdate($first_of_month);
        $month = $date_info['mon'];
        $year = $date_info['year'];

        if ($roomid <> 0) {
            $booked = array();

            $query = "SELECT pk_booking_detail_id, fk_bookingcat_id, 
					  $tbl_booking.fk_guest_id, UNIX_TIMESTAMP($tbl_booking_detail.start_date), 
					  UNIX_TIMESTAMP($tbl_booking_detail.end_date), color, 
					  lastname, firstname, $tbl_bookingcat.bookingcat, $tbl_booking_detail.persons, 
					  $tbl_booking_detail.children, booking_type, 
					  DATE_FORMAT(reservation_until, '%d.%m.%Y'), 
					  $tbl_booking.additional_info, UNIX_TIMESTAMP($tbl_booking.start_date), 
					  UNIX_TIMESTAMP($tbl_booking.end_date), $tbl_booking.pk_booking_id,
					  $tbl_booking_detail.children2, $tbl_booking_detail.children3 
					  FROM $tbl_booking_detail, $tbl_booking, $tbl_bookingcat, $tbl_guest 
					  WHERE $tbl_booking_detail.fk_booking_id = $tbl_booking.pk_booking_id 
					  AND $tbl_booking.fk_bookingcat_id = $tbl_bookingcat.pk_bookingcat_id 
					  AND $tbl_guest.pk_guest_id = $tbl_booking.fk_guest_id 
					  AND fk_room_id = " . $roomid . " 
					  AND $tbl_booking_detail.deleted_date IS NULL 
					  ORDER BY $tbl_booking_detail.start_date";

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Calendar::getMonth()', $query);
            } else {
                $row = 0;
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $bookingtype = "";
                    $bookingtypecolor = "";
                    switch (MetabaseFetchResult($gDatabase, $result, $row, 11)) {
                        case 'R':
                            $bookingtype = "Reservierung";
                            $bookingtypecolor = $request->GetVar('colorR', 'session');
                            break;
                        case 'B':
                            $bookingtype = "Buchung";
                            $bookingtypecolor = $request->GetVar('colorB', 'session');
                            break;
                        case 'P':
                            $bookingtype = "Abgerechnet";
                            $bookingtypecolor = $request->GetVar('colorP', 'session');
                            break;
                    } 
                    $booked[$row] = array ('bookingdetailid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        'catid' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'gastid' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                        'start' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                        'end' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                        'color' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                        'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                        'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                        'cat' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                        'persons' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                        'children' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                        'children2' => MetabaseFetchResult($gDatabase, $result, $row, 17),
                        'children3' => MetabaseFetchResult($gDatabase, $result, $row, 18),
                        'bookingtype' => MetabaseFetchResult($gDatabase, $result, $row, 11),
                        'bookingtypename' => $bookingtype,
                        'bookingtypecolor' => $bookingtypecolor,
                        'reservationuntil' => MetabaseFetchResult($gDatabase, $result, $row, 12),
                        'description' => MetabaseFetchResult($gDatabase, $result, $row, 13),
                        'totalstart' => MetabaseFetchResult($gDatabase, $result, $row, 14),
                        'totalend' => MetabaseFetchResult($gDatabase, $result, $row, 15),
                        'bookid' => MetabaseFetchResult($gDatabase, $result, $row, 16)
                        );
                } 
            } 
        } 

        $weekday = $date_info['wday'];
        $day = 1;
        $monthArray = array();

        while ($day <= $maxdays) {
            $firstday = "";
            $lastday = "";
            $lastdaydata = array();
            $linkDate = mktime (8, 0, 0, $month, $day, $year);

            $bookid = "";
            $color = "";
            $infotxt = "";

            if ($roomid <> 0) {
                $firstday = "";
                $lastday = "";
                foreach($booked as $booking) {
                    $endarr = getdate($booking['end']);
                    $startarr = getdate($booking['start']);
                    $endstr = mktime(8, 0, 0, $endarr['mon'], $endarr['mday'], $endarr['year']);
                    $startstr = mktime(8, 0, 0, $startarr['mon'], $startarr['mday'], $startarr['year']);
                    if ($linkDate <= $endstr and $linkDate >= $startstr) {
                        $bookid = $booking['bookid'];
                        $bookingdetailid = $booking['bookingdetailid'];
                        $color = $booking['color'];
                        $bookingtypecolor = $booking['bookingtypecolor'];
                        $infotxt = "<b>Name:</b> " . $booking['firstname'] . "&nbsp;" . $booking['lastname'] . "<br>" . "<b>Anreisetag:</b> " . date("d. m. Y", $booking['totalstart']) . "<br>" . "<b>Abreisetag:</b> " . date("d. m. Y", $booking['totalend']) . "<br>" . "<b>Kategorie:</b> " . $booking['cat'] . "<br>" . "<b>Belegungsart:</b> " . $booking['bookingtypename'];

                        if ($booking['bookingtype'] == 'R') {
                            $infotxt .= " bis " . $booking['reservationuntil'];
                        } 
                        $infotxt .= "<br><b>Personen:</b> " . $booking['persons'];

                        if ($booking['persons'] <> 1) {
                            $infotxt .= " Erwachsene";
                        } else {
                            $infotxt .= " Erwachsener";
                        } 
                        $childrentotal = $booking['children'] + $booking['children2'] + $booking['children3'];
                        if ($childrentotal <> 0) {
                            $infotxt .= ", " . $childrentotal;
                            if ($childrentotal <> 1) {
                                $infotxt .= " Kinder";
                            } else {
                                $infotxt .= " Kind";
                            } 
                            $infotxt .= " (" . $booking['children'] . "/" . $booking['children2'] . "/" . $booking['children3'] . ")";
                        } 
                        if ($booking['description'] != "") {
                            $infotxt .= "<br><b>Bemerkung:</b> " . $booking['description'];
                        } 

                        if ($startstr == $linkDate) {
                            $firstday = "true"; 
                            // $lastdaydata = array();
                        } 

                        if ($endstr == $linkDate) {
                            $lastday = "true";
                            $lastdaydata = array('date' => $day,
                                'linkDate' => $linkDate,
                                'weekday' => $this->returnDayName($weekday),
                                'bookid' => $bookid,
                                'bookingdetailid' => $bookingdetailid,
                                'color' => $color,
                                'infotxt' => $infotxt,
                                'bookingtypecolor' => $bookingtypecolor
                                );
                        } 
                    } 
                } 
            } 

            $monthArray[$day-1] = array ('date' => $day,
                'linkDate' => $linkDate,
                'weekday' => $this->returnDayName($weekday),
                'bookid' => $bookid,
                'bookingdetailid' => $bookingdetailid,
                'color' => $color,
                'infotxt' => $infotxt,
                'firstday' => $firstday,
                'lastday' => $lastday,
                'lastdaydata' => $lastdaydata,
                'bookingtypecolor' => $bookingtypecolor
                );
            $day++;
            $weekday++;
        } 
        return $monthArray;
    } 

    /**
    * Calendar::getHalfMonth()
    * 
    * This function returns a month starting at the 15th with bookings
    * using the Calendar::getMonth() function
    * 
    * @param number $year year
    * @param number $month month
    * @param number $roomid roomid
    * @return array month with bookings
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getHalfMonth($year, $month, $roomid)
    {
        $arr1 = $this->getMonth($year, $month, $roomid);
        $arr2 = $this->getMonth($year, $month + 1, $roomid);
        $j = 0;
        for ($i = 14; $i <= count($arr1); ++$i) {
            $monthArray[$j] = $arr1[$i];
            ++$j;
        } 
        --$j;
        for ($i = 0; $i < 15; ++$i) {
            $monthArray[$j] = $arr2[$i];
            ++$j;
        } 
        return $monthArray;
    } 

    /**
    * Calendar::getFreeNights()
    * 
    * Get numbers of FreeNights from a date
    * 
    * @param timestamp $date Startday
    * @param number $roomid Roomid
    * @return number Number of free nights
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getFreeNights($date, $roomid)
    {
        global $tbl_booking_detail, $gDatabase, $errorhandler;

        $query = sprintf("SELECT UNIX_TIMESTAMP(start_date) 
		                  FROM $tbl_booking_detail 
						  WHERE UNIX_TIMESTAMP(start_date) > %s 
						  AND fk_room_id = %s 
						  AND deleted_date IS NULL 
						  ORDER BY start_date 
						  LIMIT 0,1 ",
            MetabaseGetTextFieldValue($gDatabase, $date),
            $roomid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Calendar::getFreeNights()', $query);
        } else {
            $rows = MetabaseNumberOfRows($gDatabase, $result);
            if ($rows > 0) {
                return (MetabaseFetchResult($gDatabase, $result, 0, 0) - $date) / 86400;
            } else {
                return 0;
            } 
        } 
    } 

    /**
    * Calendar::getExtensionTimes()
    * 
    * Get the dates the room is free from a date
    * 
    * @param timestamp $date Startday
    * @param number $roomid Roomid
    * @return array dates
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getExtensionTimes($date, $roomid)
    {
        global $tbl_booking_detail, $gDatabase, $errorhandler;
        $query = sprintf("SELECT UNIX_TIMESTAMP(start_date) 
		                  FROM $tbl_booking_detail 
						  WHERE UNIX_TIMESTAMP(start_date) > %s 
						  AND fk_room_id = %s 
						  AND deleted_date IS NULL 
						  ORDER BY start_date 
						  LIMIT 0,1 ",
            MetabaseGetTextFieldValue($gDatabase, $date),
            $roomid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Calendar::$this->getExtensionTimes()', $query);
        } else {
            $rows = MetabaseNumberOfRows($gDatabase, $result);

            if ($rows > 0) {
                $freenights = (MetabaseFetchResult($gDatabase, $result, 0, 0) - $date) / 86400;
            } else {
                $freenights = 100;
            } 
            $starttmp = date("Y-m-d", $date);

            $days = array();
            for ($i = 0; $i < $freenights && $i < 100; ++$i) {
                $j = $i + 1;
                $days[$i]["count"] = $j;
                $days[$i]["date"] = date("D, d. m. Y", strtotime("$starttmp + $j days"));
                if ($j > 1) {
                    $days[$i]["date"] .= " ($j N&auml;chte)";
                } else {
                    $days[$i]["date"] .= " ($j Nacht)";
                } 
                $days[$i]["thedate"] = strtotime("$starttmp + $j days");
            } 
            return $days;
        } 
    } 

    /**
    * Calendar::getExtensionTimes2()
    * 
    * Get the dates the room is free before a date
    * 
    * @param timestamp $date endday
    * @param number $roomid Roomid
    * @return array dates
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getExtensionTimes2($date, $roomid)
    {
        global $tbl_booking_detail, $gDatabase, $errorhandler;
        $query = sprintf("SELECT UNIX_TIMESTAMP(end_date), end_date 
		                  FROM $tbl_booking_detail 
						  WHERE UNIX_TIMESTAMP(end_date) < %s 
						  AND fk_room_id = %s 
						  AND deleted_date IS NULL 
						  ORDER BY end_date DESC
						  LIMIT 0,1 ",
            MetabaseGetTextFieldValue($gDatabase, $date),
            $roomid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Calendar::$this->getExtensionTimes2()', $query);
        } else {
            $rows = MetabaseNumberOfRows($gDatabase, $result);

            if ($rows > 0) {
                $freenights = round(($date - MetabaseFetchResult($gDatabase, $result, 0, 0)) / 86400);
                $starttmp = date("Y-m-d", MetabaseFetchResult($gDatabase, $result, 0, 0));
            } else {
                $freenights = 100;
                $starttmp = date("Y-m-d", mktime(8, 0, 0, date("m", $date) , date("d", $date) - $freenights, date("Y", $date)));
            } 

            $days = array();
            $nights = $freenights;
            for ($i = 0; $i < $freenights && $i < 100; ++$i) {
                $j = $i;
                $days[$i]["count"] = $j;
                $days[$i]["date"] = date("D, d. m. Y", strtotime("$starttmp + $j days"));
                if ($nights > 1) {
                    $days[$i]["date"] .= " ($nights N&auml;chte)";
                } else {
                    $days[$i]["date"] .= " ($nights Nacht)";
                } 
                $days[$i]["thedate"] = strtotime("$starttmp + $j days");
                $nights -= 1;
            } 
            return $days;
        } 
    } 

    /**
    * Calendar::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2005-01-11
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getdates()
    {
        global $gDatabase, $tbl_booking_detail, $request, $errorhandler;

        $dates = array();
        $j = 0;
        $query = "SELECT DATE_FORMAT(min( start_date  ) ,'%Y')  
		                 FROM $tbl_booking_detail  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Calendar::getdates()', $query);
        } else {
            $startyear = MetabaseFetchResult($gDatabase, $result, 0, 0);
            $todaydate = getdate();
            $todayyear = $todaydate['year'];
            $i = 0;
            for ($year = $startyear; $year <= $todayyear; ++$year) {
                $dates[$i] = $year;
                ++$i;
            } 
            for ($j = 1; $j <= 20; ++$j) {
                $dates[$i] = $year + $j;
                ++$i;
            } 

        } 
        return $dates;
    } 
} 

?>
