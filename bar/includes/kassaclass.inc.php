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
* class Kassa
* 
* Class for kassa
* 
* This class has all functions which are needed for the kassa.
* 
* @since 2004-01-06
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: kassaclass.inc.php,v 1.8 2005/12/21 21:36:09 ehret Exp $
*/
class Kassa {
    /**
    * Kassa::get()
    * 
    * This function returns all bought articles for one guest.
    * 
    * @param number $guestid guest id
    * @param string $order order desc or asc
    * @param array $cats categories
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($guestid, $order, $cats = array())
    {
        global $gDatabase2, $tbl_bararticle, $tbl_user, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows;
        $article = array();
        if (count($cats) > 0) {
            $catstr = "AND ba.fk_bararticlecat_id IN (";
            for ($i = 0; $i < count($cats); $i++) {
                if ($i > 0) {
                    $catstr .= ", ";
                } 
                $catstr .= $cats[$i];
            } 
            $catstr .= ")";
        } else {
            return array();
        } 

        $query = "SELECT ba.pk_bararticle_id, ba.description, ba.price, 
		          DATE_FORMAT( b.timestamp, '%d.%m.%Y, %H:%i' ), b.num, b.pk_bought_id, 
				  u1.firstname, u1.lastname, DATE_FORMAT( b.inserted_date, '%d.%m.%Y, %H:%i' ), 
				  u2.firstname, u2.lastname, DATE_FORMAT( b.updated_date, '%d.%m.%Y, %H:%i' ), ba.tax " .
        sprintf("FROM $tbl_bought b
				  		  LEFT JOIN $tbl_barguest bg ON bg.pk_barguest_id = b.fk_barguest_id
				  	      LEFT JOIN $tbl_bararticle ba ON b.fk_bararticle_id = ba.pk_bararticle_id
						  LEFT JOIN $tbl_user u1 ON b.fk_inserted_user_id = u1.pk_user_id
						  LEFT JOIN $tbl_user u2 ON b.fk_updated_user_id = u2.pk_user_id
						  WHERE pk_barguest_id = %s
						  AND paid = %s 
						  $catstr
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
                    'inserted' => MetabaseFetchResult($gDatabase2, $result, $row, 6) . " " . MetabaseFetchResult($gDatabase2, $result, $row, 7),
                    'inserteddate' => MetabaseFetchResult($gDatabase2, $result, $row, 8),
                    'updated' => MetabaseFetchResult($gDatabase2, $result, $row, 9) . " " . MetabaseFetchResult($gDatabase2, $result, $row, 10),
                    'updateddate' => MetabaseFetchResult($gDatabase2, $result, $row, 11),
                    'tax' => MetabaseFetchResult($gDatabase2, $result, $row, 12),
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
    * Kassa::getBon()
    * 
    * This function returns all bought articles for one guest.
    * 
    * @param number $guestid guest id
    * @param string $order order desc or asc
    * @param array $cats categories
    * @return array articles
    * @access public 
    * @since 2005-12-20
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getBon($guestid, $cats = array(), $items = array())
    {
        global $gDatabase2, $tbl_bararticle, $tbl_user, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows;
        $article = array();
        if (count($cats) > 0) {
            $catstr = "AND ba.fk_bararticlecat_id IN (";
            for ($i = 0; $i < count($cats); $i++) {
                if ($i > 0) {
                    $catstr .= ", ";
                } 
                $catstr .= $cats[$i];
            } 
            $catstr .= ")";
        } else {
            $catstr = "";
        } 
				if (count($items) > 0) {
						$itemsstr = "AND b.pk_bought_id IN (";
						for ($i = 0; $i < count($items); $i++) {
							if ($i > 0){
								$itemsstr .= ", ";
							}
							$itemsstr .= $items[$i];
						}
						$itemsstr .= ")";
				} else {
					$itemsstr = "";
				}
        $query = "SELECT ba.pk_bararticle_id, ba.description, ba.price, sum(b.num), b.pk_bought_id, 
								 ba.tax " .
        sprintf("FROM $tbl_bought b
				  		  LEFT JOIN $tbl_barguest bg ON bg.pk_barguest_id = b.fk_barguest_id
				  	      LEFT JOIN $tbl_bararticle ba ON b.fk_bararticle_id = ba.pk_bararticle_id
						  WHERE pk_barguest_id = %s
						  AND paid = %s 
						  $catstr
						  $itemsstr
						  GROUP BY pk_bararticle_id
						  ORDER BY ba.description
						  ",
            $guestid,
            MetabaseGetBooleanFieldValue($gDatabase2, false)
            );
            
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Kassa::getBon()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $total = MetabaseFetchResult($gDatabase2, $result, $row, 2) * MetabaseFetchResult($gDatabase2, $result, $row, 3);
                $sum += $total;
                $article[$row] = array ('articleid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'num' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'boughtid' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'tax' => MetabaseFetchResult($gDatabase2, $result, $row, 5),
                    'total' => number_format($total, 2, '.', '')
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
    * @param array $cats categories
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getTimeline($guestid, $start, $end, $order, $cats = array())
    {
        global $gDatabase2, $tbl_bararticle, $tbl_user, $tbl_bought, $tbl_barguest, $request, $errorhandler, $articlerows;
        $article = array();
        if (count($cats) > 0) {
            $catstr = "AND ba.fk_bararticlecat_id IN (";
            for ($i = 0; $i < count($cats); $i++) {
                if ($i > 0) {
                    $catstr .= ", ";
                } 
                $catstr .= $cats[$i];
            } 
            $catstr .= ")";
        } else {
            return array();
        } 
        list($day, $month, $year) = split('.', $start);
        $query = "SELECT ba.pk_bararticle_id, ba.description, ba.price, DATE_FORMAT( b.timestamp, '%d.%m.%Y, %H:%i' ), num, pk_bought_id, paid,
				  DATE_FORMAT( b.updated_date, '%d.%m.%Y, %H:%i Uhr' ), u2.firstname, u2.lastname,
				  DATE_FORMAT( b.inserted_date, '%d.%m.%Y, %H:%i Uhr' ), u1.firstname, u1.lastname 
                 FROM $tbl_bought b
				  		  LEFT JOIN $tbl_barguest bg ON bg.pk_barguest_id = b.fk_barguest_id
				  	      LEFT JOIN $tbl_bararticle ba ON b.fk_bararticle_id = ba.pk_bararticle_id
						  LEFT JOIN $tbl_user u1 ON b.fk_inserted_user_id = u1.pk_user_id
						  LEFT JOIN $tbl_user u2 ON b.fk_updated_user_id = u2.pk_user_id
						  WHERE bg.pk_barguest_id = $guestid 
						  $catstr ";
        if ($start !== "") {
            list($day, $month, $year) = split('[.]', $start);
            $query .= "AND UNIX_TIMESTAMP(b.timestamp) >= " . mktime(0, 0, 0, $month, $day, $year) . " ";
        } 
        if ($end !== "") {
            list($day, $month, $year) = split('[.]', $end);
            $query .= "AND UNIX_TIMESTAMP(b.timestamp) <= " . mktime(0, 0, 0, $month, $day + 1, $year) . " ";
        } 
        $query .= "ORDER BY b.timestamp " . $order;

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
                    'updateduser' => MetabaseFetchResult($gDatabase2, $result, $row, 8) . " " . MetabaseFetchResult($gDatabase2, $result, $row, 9),
                    'inserted' => MetabaseFetchResult($gDatabase2, $result, $row, 10),
                    'inserteduser' => MetabaseFetchResult($gDatabase2, $result, $row, 11) . " " . MetabaseFetchResult($gDatabase2, $result, $row, 12),
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
					$startpage = $wwwroot . "index.php";
                    header("Location: $startpage");
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
			$startpage = $wwwroot . "index.php";
            header("Location: $startpage");
        } 
    } 
} 

?>