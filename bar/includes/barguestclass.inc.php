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
* class Barguest
* 
* Class for barguests
* 
* This class has all functions which are needed for the barguests.
* 
* @since 2004-01-06
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: barguestclass.inc.php,v 1.3 2004/12/07 18:48:05 ehret Exp $
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
        global $gDatabase2, $tbl_barguest, $request, $errorhandler, $namerows;

        $guest = array();
        $query = "SELECT pk_barguest_id, firstname, lastname
		                 FROM $tbl_barguest
						 WHERE ISNULL(deleted_date)
						 ORDER BY lastname, firstname  ";
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
					'sum' => $this->getSum(MetabaseFetchResult($gDatabase2, $result, $row, 0))
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
            for ($year = $startyear; $year <= $endyear+1; ++$year) {
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
        $query = "SELECT firstname, lastname
		                 FROM $tbl_barguest
						 WHERE pk_barguest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguest::getName()', $query);
        } else {
            $row = 0;
            $guestName = array();
            $guestName = array ('firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 1)
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
			                  (pk_barguest_id, firstname, lastname, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s,  NOW(), %s, NOW(), %s )",
            $barguestid,
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
    * @param stirng $lastname lastname
    * @access public 
    * @since 2004-01-12
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function update($guestid, $firstname, $lastname)
    {
        global $gDatabase, $request, $tbl_barguest, $errorhandler;

        $query = sprintf("UPDATE $tbl_barguest
						  SET firstname = %s,
						      lastname = %s,
							  updated_date = NOW(),
							  fk_updated_user_id = %s
						 WHERE pk_barguest_id = %s",
            MetabaseGetTextFieldValue($gDatabase, $firstname),
            MetabaseGetTextFieldValue($gDatabase, $lastname),
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
} 

?>
