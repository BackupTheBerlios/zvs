<?php
/**
* Copyright notice
* 
*      (c) 2003-2004 Christian Ehret (chris@ehret.name)
*      All rights reserved
* 
*      This script is part of the ZVS project. The ZVS project is 
*      free software; you can redistribute it and/or modify
*      it under the terms of the GNU General Public License as published by
*      the Free Software Foundation; either version 2 of the License, or
*      (at your option) any later version.
* 
*      The GNU General Public License can be found at
*      http://www.gnu.org/copyleft/gpl.html.
*      A copy is found in the textfile GPL.txt and important notices to the license 
*      from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*      This script is distributed in the hope that it will be useful,
*      but WITHOUT ANY WARRANTY; without even the implied warranty of
*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*      GNU General Public License for more details.
* 
*      This copyright notice MUST APPEAR in all copies of the script!
*/

/**
* class Barguest
* 
* Class for barguests
* 
* This class has all functions which are needed for the barguests.
* 
* @since 2004-01-06
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: barguestclass.inc.php,v 1.4 2004/12/14 17:28:35 ehret Exp $
*/
class Barguest {
    /**
    * Barguest::getSum()
    * 
    * This function returns all bought articles for one guest.
    * 
    * @param number $guestid guest id
    * @return number sum
    * @access public 
    * @since 2004-09-09
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getSum($guestid)
    {
        global $gDatabase2, $tbl_bararticle, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows;
        $article = array();
        $sum = 0;
        $query = "SELECT SUM(price*num) " .
        sprintf("FROM $tbl_bought
				  		  LEFT JOIN $tbl_barguest ON $tbl_barguest.pk_barguest_id = $tbl_bought.fk_barguest_id
				  	      LEFT JOIN $tbl_bararticle ON $tbl_bought.fk_bararticle_id = $tbl_bararticle.pk_bararticle_id
						  WHERE pk_barguest_id = %s
						  AND paid = %s 
						  ORDER BY timestamp %s",
            $guestid,
            MetabaseGetBooleanFieldValue($gDatabase2, false),
            $order
            );

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getSum()', $query);
        } else {
            $sum = MetabaseFetchResult($gDatabase2, $result, 0, 0);
        } 
        return number_format($sum, 2, '.', '');
    } 
    /**
    * Barguest::getall()
    * 
    * This function returns all guests.
    * 
    * @return array guests
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase2, $tbl_barguest, $tbl_bookingcat, $request, $errorhandler, $namerows;

        $guest = array();
        $query = "SELECT bg.pk_barguest_id, bg.firstname, bg.lastname,
						 bc.bookingcat, bc.color
		                 FROM $tbl_barguest bg
						 LEFT JOIN $tbl_bookingcat bc ON bg.fk_bookingcat_id = bc.pk_bookingcat_id
						 WHERE ISNULL(bg.deleted_date)
						 ORDER BY bg.lastname, bg.firstname  ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getall()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                if ($row % 3 == 0) {
                    $newline = "true";
                } else {
                    $newline = "false";
                } 
                if (($row + 1) % 3 == 0) {
                    $endline = "true";
                } else {
                    $endline = "false";
                } 
                $guest[$row] = array ('guestid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'newline' => $newline,
                    'endline' => $endline,
                    'sum' => $this->getSum(MetabaseFetchResult($gDatabase2, $result, $row, 0)),
                    'bookingcat' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'bccolor' => MetabaseFetchResult($gDatabase2, $result, $row, 4)
                    );
            } while ($row % 3 !== 0) {
                if (($row + 1) % 3 == 0) {
                    $endline = "true";
                } else {
                    $endline = "false";
                } 
                $guest[$row] = array ('guestid' => "0",
                    'firstname' => "",
                    'lastname' => "",
                    'newline' => "false",
                    'endline' => $endline
                    );
                $row++;
            } 
            /*
			while ($row % $namerows <> 0) {
                $guest[$row] = array ('guestid' => "0",
                    'firstname' => "",
                    'lastname' => "",
                    'newline' => "false"
                    );
                $row++;
            } // while
*/
        } 
        return $guest;
    } 
    /**
    * Barguest::getlist()
    * 
    * This function returns all guests including deleted ones.
    * 
    * @return array guests
    * @access public 
    * @since 2004-01-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getlist($thestart, $theend)
    {
        global $gDatabase2, $tbl_barguest, $tbl_bought, $request, $errorhandler;

        $guest = array();
        $query = "SELECT pk_barguest_id, firstname, lastname, DATE_FORMAT(MAX($tbl_bought.timestamp), '%d.%m.%Y' ) 
		                 FROM $tbl_barguest
						 LEFT JOIN $tbl_bought ON $tbl_barguest.pk_barguest_id = $tbl_bought.fk_barguest_id
						 WHERE NOT ISNULL(timestamp)
						 AND timestamp >= '$thestart'
						 AND timestamp <= '$theend'
						 GROUP BY pk_barguest_id
						 ORDER BY lastname, firstname  ";

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getlist()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $guest[$row] = array ('guestid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'lastaction' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'color' => $color
                    );
            } 
        } 
        return $guest;
    } 
    /**
    * Barguest::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2004-01-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getdates()
    {
        global $gDatabase2, $tbl_bought, $request, $errorhandler;

        $dates = array();
        $j = 0;
        $query = "SELECT DATE_FORMAT(min( timestamp ) ,'%Y'),  DATE_FORMAT(max( timestamp ),'%Y')  
		                 FROM $tbl_bought  ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getdates()', $query);
        } else {
            $startyear = MetabaseFetchResult($gDatabase2, $result, 0, 0);
            $endyear = MetabaseFetchResult($gDatabase2, $result, 0, 1);
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
    * Barguest::getName()
    * 
    * This function returns the name of a guest.
    * 
    * @param  $guestid guest id
    * @return string name
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getName($guestid)
    {
        global $gDatabase2, $tbl_barguest, $request, $errorhandler;
        $guestName = "";
        $query = "SELECT firstname, lastname
		                 FROM $tbl_barguest
						 WHERE pk_barguest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getName()', $query);
        } else {
            $row = 0;
            $guestName = MetabaseFetchResult($gDatabase2, $result, $row, 0) . " " . MetabaseFetchResult($gDatabase2, $result, $row, 1);
        } 
        return $guestName;
    } 

    /**
    * Barguest::getNameSplit()
    * 
    * This function returns the name of a guest.
    * 
    * @param  $guestid guest id
    * @return array name
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getNameSplit($guestid)
    {
        global $gDatabase2, $tbl_barguest, $request, $errorhandler;
        $guestName = "";
        $query = "SELECT firstname, lastname, fk_bookingcat_id
		                 FROM $tbl_barguest
						 WHERE pk_barguest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getName()', $query);
        } else {
            $row = 0;
            $guestName = array();
            $guestName = array ('firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
				'bookingcatid' => MetabaseFetchResult($gDatabase2, $result, $row, 2)
                );
        } 
        return $guestName;
    } 

    /**
    * Barguest::add()
    * 
    * Add a guest
    * 
    * @return guest id
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function add()
    {
        global $gDatabase, $request, $tbl_barguest, $errorhandler;

        $name = "zvs_pk_barguest_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$barguestid);
        $query = sprintf("INSERT INTO $tbl_barguest
			                  (pk_barguest_id, fk_bookingcat_id, firstname, lastname, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s, %s,  NOW(), %s, NOW(), %s )",
            $barguestid,
			$request->GetVar('frm_bookingcat', 'post'),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_firstname', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_lastname', 'post')),
            $request->GetVar('uid', 'session'),
            $request->GetVar('uid', 'session')
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'BarGuest::add()', $query);
        } else {
            return $barguestid;
        } 
    } 

    /**
    * Barguest::update()
    * 
    * update a guest
    * 
    * @param number $guestid guest id
    * @param string $firstname firstname
    * @param string $lastname lastname
	* @param integer $bookingcat booking category id
    * @access public 
    * @since 2004-01-12
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function update($guestid, $firstname, $lastname, $bookingcat)
    {
        global $gDatabase, $request, $tbl_barguest, $errorhandler;

        $query = sprintf("UPDATE $tbl_barguest
						  SET firstname = %s,
						      lastname = %s,
							  fk_bookingcat_id = %s,
							  updated_date = NOW(),
							  fk_updated_user_id = %s
						 WHERE pk_barguest_id = %s",
            MetabaseGetTextFieldValue($gDatabase, $firstname),
            MetabaseGetTextFieldValue($gDatabase, $lastname),
			$bookingcat,
            $request->GetVar('uid', 'session'),
            $guestid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'BarGuest::update()', $query);
        } 
    } 

    /**
    * User::del()
    * 
    * Deletes an article
    * 
    * @param number $articleid article id
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($articleid)
    {
        global $gDatabase, $tbl_bararticle, $errorhandler, $request;

        $query = sprintf("UPDATE $tbl_bararticle SET 
							 deleted_date = NOW(), 
							 fk_deleted_user_id = %s 
							 WHERE pk_bararticle_id = %s ",
            $request->GetVar('uid', 'session'),
            $articleid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'BarGuest::del()', $query);
        } 
    } 

    /**
    * User::buy()
    * 
    * Buys an article
    * 
    * @param number $articleid article id
    * @param number $guestid guest id
    * @param number $ number
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function buy($articleid, $guestid, $num)
    {
        global $gDatabase, $tbl_bought, $errorhandler, $request;

        $name = "zvs_pk_bought_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$boughtid);
        $query = sprintf("INSERT INTO $tbl_bought 
						  (pk_bought_id, fk_barguest_id, fk_bararticle_id,
						   num, timestamp, paid, inserted_date, fk_inserted_user_id)
						   VALUES (%s, %s, %s, %s, NOW(), %s, NOW(), %s)",
            $boughtid,
            $guestid,
            $articleid,
            $num,
            MetabaseGetBooleanFieldValue($gDatabase, false),
            $request->GetVar('uid', 'session')
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'BarGuest::buy()', $query);
        } 
    } 

    /**
    * Guest::importZVSCategory()
    * 
    * Import ZVS Booking Categories
    * 
    * @access public 
    * @since 2004-12-14
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function importZVSCategory()
    {
        global $gDatabase, $tbl_bookingcat, $tbl_zvs_bookingcat, $gZVSDatabase, $tbl_user, $errorhandler, $request;

        $query = "SELECT pk_bookingcat_id, bookingcat, color
		                 FROM $tbl_zvs_bookingcat 
						 WHERE ISNULL(deleted_date)";

        $zvsresult = MetabaseQuery($gZVSDatabase, $query);
        if (!$zvsresult) {
            $errorhandler->display('SQL', 'Guest::importZVSCategory()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gZVSDatabase, $zvsresult)) == 0; ++$row) {
                $query = "SELECT pk_bookingcat_id 
				          FROM $tbl_bookingcat
						  WHERE fk_zvsbookingcat_id = " . MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 0);
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $errorhandler->display('SQL', 'Guest::importZVSCategory()', $query);
                } else {
                    if (MetabaseNumberOfRows($gDatabase, $result) == 1) {
                        $query = sprintf("UPDATE $tbl_bookingcat 
										  SET bookingcat = %s, 
										  color = %s
										  WHERE pk_bookingcat_id = %s",
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 1)),
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 2)),
                            MetabaseFetchResult($gDatabase, $result, 0, 0)
                            );
                    } else {
                        $name = "zvs_pk_bookingcat_id";
                        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$bookingcatid);
                        $query = sprintf("INSERT INTO $tbl_bookingcat
										  (pk_bookingcat_id, fk_zvsbookingcat_id, bookingcat, color, inserted_date, fk_inserted_user_id)
										  VALUES (%s, %s, %s, %s, NOW(), %s)",
                            $bookingcatid,
                            MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 0),
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 1)),
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 2)),
                            1
                            );
                    } 
                    $result2 = MetabaseQuery($gDatabase, $query);
                    if (!$result2) {
                        $errorhandler->display('SQL', 'Guest::importZVSCategory()', $query);
                    } 
                } 
            } 
        } 
    } 

    /**
    * Guest::importZVSGuest()
    * 
    * Import ZVS User
    * 
    * @access public 
    * @since 2004-12-14
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function importZVSGuest()
    {
        global $gDatabase, $tbl_bookingcat, $tbl_barguest, $tbl_zvs_bookingcat, $tbl_zvs_guest, $tbl_zvs_booking, $tbl_zvs_booking_detail, $gZVSDatabase, $tbl_user, $errorhandler, $request;

        $guests = array();
        $query = "SELECT pk_guest_id, firstname, lastname, fk_bookingcat_id " .
        sprintf("FROM $tbl_zvs_booking, $tbl_zvs_guest, $tbl_zvs_booking_detail 
						  WHERE checked_in = %s 
						  AND checked_out = %s
						  AND pk_guest_id = fk_guest_id 
						  AND pk_booking_id = fk_booking_id 
						  AND ISNULL($tbl_zvs_booking.deleted_date) 
						  ORDER BY lastname",
            MetabaseGetBooleanFieldValue($gZVSDatabase, true),
            MetabaseGetBooleanFieldValue($gZVSDatabase, false)
            );

        $zvsresult = MetabaseQuery($gZVSDatabase, $query);
        if (!$zvsresult) {
            $errorhandler->display('SQL', 'Guest::importZVSGuest()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gZVSDatabase, $zvsresult)) == 0; ++$row) {
                $query = "SELECT pk_bookingcat_id 
				          FROM $tbl_bookingcat
						  WHERE fk_zvsbookingcat_id = " . MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 3);
                $catresult = MetabaseQuery($gDatabase, $query);
                if (!$catresult) {
                    $errorhandler->display('SQL', 'Guest::importZVSGuest()', $query);
                } else {
                    $query = "SELECT pk_barguest_id 
				          FROM $tbl_barguest
						  WHERE fk_zvsguest_id = " . MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 0);
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $errorhandler->display('SQL', 'Guest::importZVSGuest()', $query);
                    } 

                    if (MetabaseNumberOfRows($gDatabase, $result) == 1) {
                        $query = sprintf("UPDATE $tbl_barguest 
										  SET firstname = %s, 
										  lastname = %s,
										  fk_bookingcat_id = %s
										  WHERE pk_barguest_id = %s",
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 1)),
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 2)),
                            MetabaseFetchResult($gDatabase, $catresult, 0, 0),
                            MetabaseFetchResult($gDatabase, $result, 0, 0)
                            );
                    } else {
                        $name = "zvs_pk_barguest_id";
                        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$barguestid);
                        $query = sprintf("INSERT INTO $tbl_barguest
										  (pk_barguest_id, fk_zvsguest_id, fk_bookingcat_id, firstname, lastname, inserted_date, fk_inserted_user_id)
										  VALUES (%s, %s, %s, %s, %s, NOW(), %s)",
                            $barguestid,
                            MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 0),
                            MetabaseFetchResult($gDatabase, $catresult, 0, 0),
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 1)),
                            MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gZVSDatabase, $zvsresult, $row, 2)),
                            1
                            );
                    } 
                    $result2 = MetabaseQuery($gDatabase, $query);
                    if (!$result2) {
                        $errorhandler->display('SQL', 'Guest::importZVSGuest()', $query);
                    } 
                } 
            } 
        } 
    } 

    /**
    * Barguest::getBookingcat()
    * 
    * This function returns the booking category of a guest.
    * 
    * @param  $guestid guest id
    * @return array bookingcategory
    * @access public 
    * @since 2004-12-14
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getBookingcat($guestid)
    {
        global $gDatabase2, $tbl_barguest, $tbl_bookingcat, $request, $errorhandler;
        $bc = "";
        $query = "SELECT bc.bookingcat, bc.color
		                 FROM $tbl_barguest bg
						 LEFT JOIN $tbl_bookingcat bc ON bg.fk_bookingcat_id = bc.pk_bookingcat_id
						 WHERE pk_barguest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getBookingcat()', $query);
        } else {
            $row = 0;
            $bc = array ('name' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                'color' => MetabaseFetchResult($gDatabase2, $result, $row, 1)
                );
        } 
        return $bc;
    } 

    /**
    * Barguest::getAllBookingcat()
    * 
    * This function returns all booking categories.
    * 
    * @return array booking categories
    * @access public 
    * @since 2004-12-14
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getAllBookingcat()
    {
        global $gDatabase2, $tbl_bookingcat, $errorhandler;
        $bc = "";
        $query = "SELECT pk_bookingcat_id, bookingcat, color
		                 FROM $tbl_bookingcat";

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getAllBookingcat()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $bc[$row] = array ('bookingcatid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'color' => MetabaseFetchResult($gDatabase2, $result, $row, 2)
                    );
            } 
        } 
        return $bc;
    } 
} 

?>
