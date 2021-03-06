<?php
/**
* Copyright notice
* 
*                   (c) 2003-2004 Christian Ehret (chris@ehret.name)
*                   All rights reserved
* 
*                   This script is part of the ZVS project. The ZVS project is 
*                   free software; you can redistribute it and/or modify
*                   it under the terms of the GNU General Public License as published by
*                   the Free Software Foundation; either version 2 of the License, or
*                   (at your option) any later version.
* 
*                   The GNU General Public License can be found at
*                   http://www.gnu.org/copyleft/gpl.html.
*                   A copy is found in the textfile GPL.txt and important notices to the license 
*                   from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*                   This script is distributed in the hope that it will be useful,
*                   but WITHOUT ANY WARRANTY; without even the implied warranty of
*                   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*                   GNU General Public License for more details.
* 
*                   This copyright notice MUST APPEAR in all copies of the script!
*/

/**
* class Timetracker
* 
* Class for tracking employee times
* 
* This class has all functions which are needed for tracking the times of the employees.
* 
* @since 2004-10-05
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: timetrackerclass.inc.php,v 1.5 2004/12/13 23:17:55 ehret Exp $
*/
class Timetracker {
    // property global difference
    var $gdiff = 0; 
    // property global difference of not cleared times
    var $gdiffnoncleared = 0;

    /**
    * Timetracker::calcDateDiff()
    * 
    * This function returns the difference between two timestamps.
    * 
    * @param timestamp $start start date
    * @param timestamp $end end date
    * @param timestamp $cleared cleared date
    * @return string time difference
    * @access public 
    * @since 2004-10-08
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function calcDateDiff($start, $end, $cleared)
    {
        $diff = abs($end - $start);
        if ($cleared !== -1) {
            $this->gdiffnoncleared += $diff;
        } 
        $this->gdiff += $diff;
        $seconds = 0;
        $hours = 0;
        $minutes = 0;

        if ($diff % 86400 > 0) {
            $rest = ($diff % 86400);
            $days = ($diff - $rest) / 86400;

            if ($rest % 3600 > 0) {
                $rest1 = ($rest % 3600);
                $hours = ($rest - $rest1) / 3600;

                if ($rest1 % 60 > 0) {
                    $rest2 = ($rest1 % 60);
                    $minutes = ($rest1 - $rest2) / 60;
                    $seconds = $rest2;
                } else
                    $minutes = $rest1 / 60;
            } else
                $hours = $rest / 3600;
        } else
            $days = $diff / 86400;
        $hours = ($days * 24) + $hours;
        $time = $hours . 'h ' . $minutes . 'm ' . $seconds . 's ';
        return $time;
    } 

    /**
    * Timetracker::getSalary()
    * 
    * This function returns the salary for one user in the showed time period.
    * 
    * @param  $uid user id
    * @param boolean $cleared show all or non cleared
    * @return string salary
    * @access public 
    * @since 2004-10-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getSalary($uid, $cleared = false)
    {
        global $gDatabase, $tbl_employee, $errorhandler;
		if (!$cleared) {
		    $diff = $this->gdiff;
		} else {
			$diff = $this->gdiffnoncleared;
		}
        $query = sprintf("SELECT salary 
		                 FROM $tbl_employee
						 WHERE pk_employee_id = %s ",
            $uid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::getStatus()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) == 0) {
                return 0;
            } else {
                return round(MetabaseFetchResult($gDatabase, $result, 0, 0) * $diff / 3600, 2);
            } 
        } 
    } 

    /**
    * Timetracker::Diff()
    * 
    * This function returns the difference between two timestamps.
    * 
    * @param boolean $cleared show all or non cleared
    * @return string formated time difference
    * @access public 
    * @since 2004-10-08
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function Diff($cleared = false)
    {
        if ($cleared) {
            $diff = $this->gdiffnoncleared;
        } else {
            $diff = $this->gdiff;
        } 
        $seconds = 0;
        $hours = 0;
        $minutes = 0;

        if ($diff % 86400 > 0) {
            $rest = ($diff % 86400);
            $days = ($diff - $rest) / 86400;

            if ($rest % 3600 > 0) {
                $rest1 = ($rest % 3600);
                $hours = ($rest - $rest1) / 3600;

                if ($rest1 % 60 > 0) {
                    $rest2 = ($rest1 % 60);
                    $minutes = ($rest1 - $rest2) / 60;
                    $seconds = $rest2;
                } else
                    $minutes = $rest1 / 60;
            } else
                $hours = $rest / 3600;
        } else
            $days = $diff / 86400;
        $hours = ($days * 24) + $hours;
        $time = $hours . 'h ' . $minutes . 'm ' . $seconds . 's ';
        return $time;
    } 

    /**
    * Timetracker::getStatus()
    * 
    * This function returns the status of a person.
    * 
    * @param number $uid user id
    * @return numer 0 if not logged in
    * @access public 
    * @since 2004-10-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getStatus($uid)
    {
        global $gDatabase, $tbl_timetracker, $errorhandler;
        $query = sprintf("SELECT pk_timetracker_id 
		                 FROM $tbl_timetracker
						 WHERE fk_employee_id = %s 
						 AND ISNULL(end_date)
						 AND ISNULL(deleted_date)",
            $uid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::getStatus()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) == 0) {
                return 0;
            } else {
                return MetabaseFetchResult($gDatabase, $result, 0, 0);
            } 
        } 
    } 
    /**
    * Timetracker::toggle()
    * 
    * This function returns all employees.
    * 
    * @return string time differenz (0 if period is started)
    * @access public 
    * @since 2004-10-05
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function toggle()
    {
        global $gDatabase, $tbl_timetracker, $request, $errorhandler;
        $timetrackerid = $this->getStatus($request->GetVar('uid', 'session'));
        if ($timetrackerid == 0) {
            $name = "zvs_pk_timetracker_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$timetrackerid);
            $query = sprintf("INSERT INTO $tbl_timetracker 
				                  (pk_timetracker_id, fk_employee_id, start_date, inserted_date, fk_inserted_user_id) 
								  VALUES (%s, %s, NOW(), NOW(), %s)",
                $timetrackerid,
                $request->GetVar('uid', 'session'),
                $request->GetVar('uid', 'session')
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Timetracker::toggle()', $query);
            } else {
                return "0";
            } 
        } else {
            $query = sprintf("UPDATE $tbl_timetracker SET
								  end_date = NOW(),
								  fk_updated_user_id = %s,
								  updated_date = NOW()
								  WHERE pk_timetracker_id = %s",
                $request->GetVar('uid', 'session'),
                $timetrackerid
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Timetracker::toggle()', $query);
            } 
        } 
    } 

    /**
    * Timetracker::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2004-10-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getdates()
    {
        global $gDatabase, $tbl_timetracker, $request, $errorhandler;

        $dates = array();
        $j = 0;
        $query = "SELECT DATE_FORMAT(min( start_date  ) ,'%Y'),  DATE_FORMAT(max( start_date  ),'%Y')  
		                 FROM $tbl_timetracker  WHERE start_date != 0000 AND ISNULL(deleted_date)";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::getdates()', $query);
        } else {
            $startyear = MetabaseFetchResult($gDatabase, $result, 0, 0);
            $endyear = MetabaseFetchResult($gDatabase, $result, 0, 1);
            for ($year = $startyear; $year <= $endyear + 1; ++$year) {
                for ($i = 1; $i <= 12; $i++) {
                    $dates[$j] = $i . '/' . $year;
                    $j++;
                } 
            } 
        } 
        return $dates;
    } 

    /**
    * Timetracker::gettimes()
    * 
    * This function returns an array with all dates.
    * 
    * @param int $userid employee id
    * @param date $start start date
    * @param date $end end date
    * @param boolean $showsum show sum
	* @param string $type all = show all, cleared = show cleared, open = show non cleared
    * @return array times
    * @access public 
    * @since 2004-10-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function gettimes($userid, $start, $end, $showsum = true, $type = 'all')
    {
        global $gDatabase, $tbl_timetracker, $request, $errorhandler;

        $dates = array();
        $end = $end -1;
        $j = 0;
        $query = "SELECT DATE_FORMAT(start_date, '%d.%m.%Y %H:%i' ), DATE_FORMAT(end_date, '%d.%m.%Y %H:%i' ),
						 DATE_FORMAT(start_date, '%Y-%m-%d %H:%i:%s' ), 
						 CASE WHEN ISNULL(end_date)
						 THEN 
						   DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s' )
						 ELSE 
						   DATE_FORMAT(end_date, '%Y-%m-%d %H:%i:%s' )
						 END,
						 pk_timetracker_id,
						 DATE_FORMAT(start_date, '%d.%m.%Y' ),
						 DATE_FORMAT(start_date, '%H:%i:%s' ),
						 CASE WHEN ISNULL(end_date)
						 THEN 
						   DATE_FORMAT(NOW(), '%d.%m.%Y' )
						 ELSE 
						   DATE_FORMAT(end_date, '%d.%m.%Y' )
						 END,			
						 CASE WHEN ISNULL(end_date)
						 THEN 
						   DATE_FORMAT(NOW(), '%H:%i:%s' )
						 ELSE 
						   DATE_FORMAT(end_date, '%H:%i:%s' )
						 END,
						 DATE_FORMAT(cleared_date, '%d.%m.%Y' )						 			 
		                 FROM $tbl_timetracker  
						 WHERE fk_employee_id = $userid 
						 AND ISNULL(deleted_date)
						 AND (UNIX_TIMESTAMP(end_date) BETWEEN " . MetabaseGetTextFieldValue($gDatabase, $start) . " AND " . MetabaseGetTextFieldValue($gDatabase, $end) . ") ";
		if ($type == 'cleared') {
		    $query .= "AND NOT ISNULL(cleared_date) ";
		}elseif ($type == 'open') {
			$query .= "AND ISNULL(cleared_date) ";
		}		 
		$query .= "ORDER BY start_date";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::gettimes()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 1;
                if ($row % 2 <> 0) {
                    $color = 0;
                } 
                $dates[$row] = array ('start_date' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'end_date' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'diff' => $this->calcDateDiff(strtotime(MetabaseFetchResult($gDatabase, $result, $row, 2)), strtotime(MetabaseFetchResult($gDatabase, $result, $row, 3)), strtotime(MetabaseFetchResult($gDatabase, $result, $row, 9))),
                    'timetracker_id' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'start_date_only' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'start_time' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'end_date_only' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'end_time' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'cleared' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                    'color' => $color);
            } 

            $color = 1;
            if ($row % 2 <> 0) {
                $color = 0;
            } 
            if ($showsum) {
                $diff = $this->Diff() . " (" . $this->getSalary($userid) . " EUR)";
                $diff2 = $this->Diff(true) . " (" . $this->getSalary($userid, true) . " EUR)";
            } else {
                $diff = $this->Diff();
                $diff2 = $this->Diff(true);
            } 
            $dates[$row] = array('start_date' => '',
                'end_date' => '',
                'diff' => $diff,
                'diff2' => $diff2,
                'color' => $color);
        } 
        return $dates;
    } 

    /**
    * Timetracker::saveupdate()
    * 
    * save a new timespan or update an existing one
    * 
    * @return number timetracker id
    * @access public 
    * @since 2004-10-13
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_timetracker, $errorhandler;

        $timetrackerid = $request->GetVar('frm_timetrackerid', 'post');
        $start = $request->GetVar('frm_thestart', 'post');
        $start = explode(".", $start);
        $start = $start[2] . "-" . $start[1] . "-" . $start[0] . " " . $request->GetVar('frm_starttime', 'post');

        $end = $request->GetVar('frm_theend', 'post');
        $end = explode(".", $end);
        $end = $end[2] . "-" . $end[1] . "-" . $end[0] . " " . $request->GetVar('frm_endtime', 'post'); 
        // update
        if ($timetrackerid !== '0') {
            $query = sprintf("UPDATE $tbl_timetracker SET 
							   start_date = %s, 
							   end_date = %s,
							   updated_date = NOW(),
							   fk_updated_user_id = %s
							   WHERE pk_timetracker_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $start),
                MetabaseGetTextFieldValue($gDatabase, $end),
                $request->GetVar('frm_employee', 'post'),
                $timetrackerid
                );
        } else { // new
            $name = "zvs_pk_timetracker_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$timetrackerid);
            $query = sprintf("INSERT INTO $tbl_timetracker
							  (pk_timetracker_id, fk_employee_id, start_date, end_date, inserted_date, fk_inserted_user_id )
							  VALUES (%s, %s, %s, %s, NOW(), %s )",
                $timetrackerid,
                $request->GetVar('frm_employee', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $start),
                MetabaseGetTextFieldValue($gDatabase, $end),
                $request->GetVar('frm_employee', 'post')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::saveupdate()', $query);
        } else {
            return $timetrackerid;
        } 
    } 

    /**
    * Timetracker::getpresent()
    * 
    * This function returns an array with all dates.
    * 
    * @return array employees
    * @access public 
    * @since 2004-11-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getpresent()
    {
        global $gDatabase, $tbl_timetracker, $tbl_employee, $request, $errorhandler;
        $employees = array();
        $query = "SELECT DATE_FORMAT(tt.start_date, '%d.%m.%Y %H:%i' ), e.lastname, e.firstname
		                 FROM $tbl_timetracker tt
						 LEFT JOIN $tbl_employee e ON tt.fk_employee_id = e.pk_employee_id
						 WHERE ISNULL(tt.end_date) AND ISNULL(tt.deleted_date)
						 ORDER BY tt.start_date";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::getpresent()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $employees[$row] = array ('start_date' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'color' => $color);
            } 
        } 
        return $employees;
    } 

    /**
    * Timetracker::del()
    * 
    * delete a timespan
    * 
    * @access public 
    * @since 2004-11-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($timetrackerid)
    {
        global $gDatabase, $request, $tbl_timetracker, $errorhandler;

        $query = sprintf("UPDATE $tbl_timetracker SET 
							   deleted_date = NOW(), 
							   fk_deleted_user_id = %s
							   WHERE pk_timetracker_id = %s ",
            $request->GetVar('frm_employee', 'post'),
            $timetrackerid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::del()', $query);
        } 
    } 

    /**
    * Timetracker::clear()
    * 
    * mark a timespan as cleared
    * 
    * @access public 
    * @since 2004-11-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function clear($timetrackerid)
    {
        global $gDatabase, $request, $tbl_timetracker, $errorhandler;

        $query = sprintf("UPDATE $tbl_timetracker SET 
							   cleared_date = NOW(), 
							   fk_cleared_user_id = %s
							   WHERE pk_timetracker_id = %s ",
            $request->GetVar('uid', 'session'),
            $timetrackerid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Timetracker::clear()', $query);
        } 
    } 
} 
