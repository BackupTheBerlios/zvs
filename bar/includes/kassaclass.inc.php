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
* class Kassa
* 
* Class for kassa
* 
* This class has all functions which are needed for the kassa.
* 
* @since 2004-01-06
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: kassaclass.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/
class Kassa {
    /**
    * Kassa::get()
    * 
    * This function returns all bought articles for one guest.
    * 
    * @param number $guestid guest id
    * @param string $order order desc or asc
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($guestid, $order)
    {
        global $gDatabase2, $tbl_bararticle, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows;
        $article = array();
        $query = "SELECT pk_bararticle_id, description, price, DATE_FORMAT( timestamp, '%d.%m.%Y, %H:%i' ), num, pk_bought_id " .
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
            $errorhandler->display('SQL', 'Kassa::get()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $total = MetabaseFetchResult($gDatabase2, $result, $row, 2) * MetabaseFetchResult($gDatabase2, $result, $row, 4);
                $sum += $total;
                $article[$row] = array ('articleid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'timestamp' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'num' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'boughtid' => MetabaseFetchResult($gDatabase2, $result, $row, 5),
                    'total' => number_format($total, 2, '.', ''),
                    'color' => $color
                    );
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 
            $article[$row] = array ('articleid' => 0,
                'description' => "Summe:",
                'price' => "",
                'timestamp' => "",
                'num' => "",
                'boughtid' => "",
                'total' => number_format($sum, 2, '.', ''),
                'color' => $color
                );
        } 
        return $article;
    } 
    /**
    * Kassa::getTimeline()
    * 
    * This function returns all bought articles for one guest.
    * 
    * @param number $guestid guest id
    * @param date $start start date
    * @param date $end end date
    * @param string $order order desc or asc
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getTimeline($guestid, $start, $end, $order)
    {
        global $gDatabase2, $tbl_bararticle, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows;
        $article = array();
        list($day, $month, $year) = split('.', $start);
        $query = "SELECT pk_bararticle_id, description, price, DATE_FORMAT( timestamp, '%d.%m.%Y, %H:%i' ), num, pk_bought_id, paid,
				  DATE_FORMAT( b.updated_date, '%d.%m.%Y, %H:%i Uhr' )
                 FROM $tbl_bought b
				  		  LEFT JOIN $tbl_barguest ON $tbl_barguest.pk_barguest_id = b.fk_barguest_id
				  	      LEFT JOIN $tbl_bararticle ON b.fk_bararticle_id = $tbl_bararticle.pk_bararticle_id
						  WHERE pk_barguest_id = $guestid ";
        if ($start !== "") {
            list($day, $month, $year) = split('[.]', $start);
            $query .= "AND UNIX_TIMESTAMP(timestamp) >= " . mktime(0, 0, 0, $month, $day, $year) . " ";
        } 
        if ($end !== "") {
            list($day, $month, $year) = split('[.]', $end);
            $query .= "AND UNIX_TIMESTAMP(timestamp) <= " . mktime(0, 0, 0, $month, $day + 1, $year) . " ";
        } 
        $query .= "ORDER BY timestamp " . $order;

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Kassa::getTimeline()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $total = MetabaseFetchResult($gDatabase2, $result, $row, 2) * MetabaseFetchResult($gDatabase2, $result, $row, 4); 
                // print "paid: ".MetabaseFetchBooleanResult($gDatabase2, $result, $row, 6);
                if (MetabaseFetchBooleanResult($gDatabase2, $result, $row, 6)) {
                    $sum2 += $total;
                    $sum += $total;
                    $paid = $total;
                } else {
                    $sum += $total;
                    $paid = "0.00";
                } 
                $article[$row] = array ('articleid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'timestamp' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'num' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'boughtid' => MetabaseFetchResult($gDatabase2, $result, $row, 5),
                    'paid' => MetabaseFetchBooleanResult($gDatabase2, $result, $row, 6),
					'updated' => MetabaseFetchResult($gDatabase2, $result, $row, 7),					
                    'total1' => number_format($total, 2, '.', ''),
                    'total2' => number_format($paid, 2, '.', ''),
                    'color' => $color
                    );
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 
            $article[$row] = array ('articleid' => 0,
                'description' => "Summe:",
                'price' => "",
                'timestamp' => "",
                'num' => "",
                'boughtid' => "",
                'paid' => "",
				'updated' => "",
                'total1' => number_format($sum, 2, '.', ''),
                'total2' => number_format($sum2, 2, '.', ''),
                'color' => $color
                );
            $sum -= $sum2;
            $article[$row + 1] = array ('articleid' => 0,
                'description' => "zu zahlen:",
                'price' => "",
                'timestamp' => "",
                'num' => "",
                'boughtid' => "",
                'paid' => "",
				'updated' => "",
                'total1' => number_format($sum, 2, '.', ''),
                'total2' => "",
                'color' => $color
                );
        } 
        return $article;
    } 
    /**
    * Kassa::checkout()
    * 
    * This function checks out a user.
    * 
    * @param  $guestid guest id
    * @param  $setinactive if true user is set deleted
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function checkout($guestid, $setinactive)
    {
        global $gDatabase2, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows, $wwwroot;
        $article = array();
        $query = sprintf("UPDATE $tbl_bought
						  SET paid = %s
						  WHERE fk_barguest_id = %s",
            MetabaseGetBooleanFieldValue($gDatabase2, true),
            $guestid
            );

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Kassa::checkout()', $query);
        } else {
            if ($setinactive == "true") {
                $query = sprintf("UPDATE $tbl_barguest
								   SET deleted_date = NOW(),
								   fk_deleted_user_id = %s
								   WHERE pk_barguest_id = %s",
                    $request->GetVar('uid', 'session'),
                    $guestid
                    );
                $result = MetabaseQuery($gDatabase2, $query);
                if (!$result) {
                    $errorhandler->display('SQL', 'Kassa::checkout()', $query);
                } else {
                    header("Location: $wwwroot");
                } 
            } 
        } 
    } 
    /**
    * Kassa::storno()
    * 
    * This function stornos out an article.
    * 
    * @param  $boughtid bought id
    * @access public 
    * @since 2004-01-08
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function storno($boughtid)
    {
        global $gDatabase2, $tbl_bought, $request, $errorhandler;
        $query = sprintf("DELETE FROM $tbl_bought
						  WHERE pk_bought_id = %s",
            $boughtid
            );

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Kassa::storno()', $query);
        } 
    } 
    /**
    * Kassa::pay()
    * 
    * This function sets an article paid.
    * 
    * @param  $boughtid bought id
    * @access public 
    * @since 2004-01-08
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function pay($boughtid)
    {
        global $gDatabase2, $tbl_bought, $request, $errorhandler;
        $query = sprintf("UPDATE $tbl_bought
						  SET paid = %s,
						  updated_date = NOW(),
						  fk_updated_user_id = %s
						  WHERE pk_bought_id = %s",
            MetabaseGetBooleanFieldValue($gDatabase2, true),
            $request->GetVar('uid', 'session'),
            $boughtid
            );

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Kassa::pay()', $query);
        } 
    } 

    /**
    * Kassa::setinactive()
    * 
    * This function sets a user inactive.
    * 
    * @param  $guestid guest id
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function setinactive($guestid)
    {
        global $gDatabase2, $tbl_barguest, $request, $errorhandler, $wwwroot;
        $query = sprintf("UPDATE $tbl_barguest
								   SET deleted_date = NOW(),
								   fk_deleted_user_id = %s
								   WHERE pk_barguest_id = %s",
            $request->GetVar('uid', 'session'),
            $guestid
            );
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Kassa::setinactive()', $query);
        } else {
            header("Location: $wwwroot");
        } 
    } 
} 

?>