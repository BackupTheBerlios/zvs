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
* class receipt
* 
* Class for receipt functionality
* 
* This class has all functions which are needed for the receipts.
* 
* @since 2004-02-04
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: receiptclass.inc.php,v 1.1 2004/11/03 14:50:18 ehret Exp $
*/
class receipt {
    /**
    * price::get()
    * 
    * get receipt
    * 
    * @access public 
    * @param number $bookingid booking id
    * @param number $length_short_stay length of short stay
    * @param number $guestid guest id
    * @return array receipt
    * @since 2004-02-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($bookingid, $length_short_stay, $guestid)
    {
        global $gDatabase, $tbl_price, $tbl_price2, $tbl_booking, $tbl_booking_detail, $tbl_room, $tbl_season,
        $tbl_guest, $tbl_guest_address, $tbl_address, $tbl_salutation, $tbl_country, $tbl_roomcat,
        $tbl_bookingcat, $errorhandler, $request, $tbl_article, $tbl_roomcat_article, $tbl_account;

        $mwst_room = $request->GetVar('mwst_room', 'Session');
        $receipt = array();
        $query = "SELECT rc.price_type FROM $tbl_booking b
					LEFT JOIN $tbl_booking_detail bd ON bd.fk_booking_id = b.pk_booking_id
					LEFT JOIN $tbl_room r ON bd.fk_room_id = r.pk_room_id
					LEFT JOIN $tbl_roomcat rc ON r.fk_roomcat_id = rc.pk_roomcat_id
					WHERE b.pk_booking_id = $bookingid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::get()', $query);
        } else {
            $price_type = MetabaseFetchResult($gDatabase, $result, 0, 0);
        } 
        // normal price type (per Person)
        if ($price_type == 'N') {
            $personlocation = -1;
            $childrenlocation = -1;
            $children2location = -1;
            $children3location = -1;
            $pauschlocation = -1;

            $query = "SELECT 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_person_short <> 0.00
							THEN 
								p.price_person_short
							ELSE
								p.price_person
						END AS price_person, 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_children_short <> 0.00
							THEN 
								p.price_children_short
							ELSE
								p.price_children
						END	AS price_children, 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_absolute_short <> 0.00
							THEN 
								p.price_absolute_short
							ELSE
								p.price_absolute
						END	AS price_absolute, 						
					     p.price_type,
						 DATE_FORMAT(b.start_date, '%d.%m.%Y'), DATE_FORMAT(b.end_date, '%d.%m.%Y'), 
						 b.persons, b.children, r.room, s.name, 
						 TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) AS days, 
						 g.firstname, g.lastname, g.academic_title, b.booking_reference_id,
						 a.postalcode, a.city, a.address, sal.salutation_de, coun.country_de, 
						 bc.bookingcat,
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_person_short <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END AS price_person_short, 	
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_children_short <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END	AS price_children_short, 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_absolute_short <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END	AS price_absolute_short,		
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_children2_short <> 0.00
							THEN 
								p.price_children2_short
							ELSE
								p.price_children2
						END	AS price_children2, 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_children3_short <> 0.00
							THEN 
								p.price_children3_short
							ELSE
								p.price_children3
						END	AS price_children3, 	
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_children2_short <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END	AS price_children2_short, 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_children3_short <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END	AS price_children3_short,
					b.children2, b.children3, r.fk_roomcat_id, g.pk_guest_id, bc.days 																																						 
					FROM $tbl_price p, $tbl_booking b
					LEFT JOIN $tbl_booking_detail bd ON bd.fk_booking_id = b.pk_booking_id
					LEFT JOIN $tbl_room r ON bd.fk_room_id = r.pk_room_id
					LEFT JOIN $tbl_guest g ON (b.fk_guest_id = g.pk_guest_id) 
				 	LEFT JOIN $tbl_guest_address ga ON (ga.default_address  = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
					 	AND g.pk_guest_id = ga.pk_fk_guest_id) 
				 	LEFT JOIN $tbl_address a ON (a.pk_address_id = ga.pk_fk_address_id) 
					LEFT JOIN $tbl_salutation sal ON (g.fk_salutation_id = sal.pk_salutation_id) 
					LEFT JOIN $tbl_country coun ON (a.fk_country_id = coun.pk_country_id )	
					LEFT JOIN $tbl_bookingcat bc ON (b.fk_bookingcat_id = bc.pk_bookingcat_id) 
					LEFT JOIN $tbl_season s ON b.start_date BETWEEN s.start_date AND s.end_date AND ISNULL(s.deleted_date)
					WHERE b.pk_booking_id = $bookingid 
							AND p.fk_roomcat_id = r.fk_roomcat_id 
							AND p.fk_bookingcat_id = b.fk_bookingcat_id 
							AND p.fk_season_id = s.pk_season_id 
							AND ISNULL(p.deleted_date)
				";
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Receipt::get()', $query);
            } else {
                $bcdays = MetabaseFetchResult($gDatabase, $result, 0, 32);
                $roomcatid = MetabaseFetchResult($gDatabase, $result, 0, 30);
                $realdays = MetabaseFetchResult($gDatabase, $result, 0, 10);
                $days = ceil($realdays / $bcdays);
                if ($realdays % $bcdays <> 0) {
                    $pauscherror = "Die Buchungskategorie enth&auml;lt $bcdays Tage - es wurden aber $realdays Tage gebucht!";
                } else {
                    $pauscherror = '';
                } 
                $price_type = MetabaseFetchResult($gDatabase, $result, 0, 3);
                $persons = MetabaseFetchResult($gDatabase, $result, 0, 6);
                $num_person = $days * $persons;
                $price_person = MetabaseFetchResult($gDatabase, $result, 0, 0);
                $price_person_netto = round($price_person * 100 / (100 + $mwst_room), 2);
                $price_person_total = $num_person * $price_person;
                $price_person_netto_total = $num_person * $price_person_netto;
                $children = MetabaseFetchResult($gDatabase, $result, 0, 7);
                $num_children = $days * $children;
                $price_children = MetabaseFetchResult($gDatabase, $result, 0, 1);
                $price_children_netto = round($price_children * 100 / (100 + $mwst_room), 2);
                $price_children_total = $num_children * $price_children;
                $price_children_netto_total = $num_children * $price_children_netto;
                $children2 = MetabaseFetchResult($gDatabase, $result, 0, 28);
                $num_children2 = $days * $children2;
                $price_children2 = MetabaseFetchResult($gDatabase, $result, 0, 24);
                $price_children2_netto = round($price_children2 * 100 / (100 + $mwst_room), 2);
                $price_children2_total = $num_children2 * $price_children2;
                $price_children2_netto_total = $num_children2 * $price_children2_netto;
                $children3 = MetabaseFetchResult($gDatabase, $result, 0, 29);
                $num_children3 = $days * $children3;
                $price_children3 = MetabaseFetchResult($gDatabase, $result, 0, 25);
                $price_children3_netto = round($price_children3 * 100 / (100 + $mwst_room), 2);
                $price_children3_total = $num_children3 * $price_children3;
                $price_children3_netto_total = $num_children3 * $price_children3_netto;
                $num_absolute = $days;
                $price_absolute = MetabaseFetchResult($gDatabase, $result, 0, 2);
                $price_absolute_netto = round($price_absolute * 100 / (100 + $mwst_room), 2);
                $price_absolute_total = $num_absolute * $price_absolute;
                $price_absolute_netto_total = $num_absolute * $price_absolute_netto;
                if ($guestid == -1 || $guestid == '') {
                    $guestid = MetabaseFetchResult($gDatabase, $result, 0, 31);
                } 

                if ($price_type == 'PP') {
                    $price_netto_total = $price_person_netto_total + $price_children_netto_total + $price_children2_netto_total + $price_children3_netto_total;
                    $price_total = $price_person_total + $price_children_total + $price_children2_total + $price_children3_total;
                } else {
                    $price_netto_total = $price_absolute_netto_total;
                    $price_total = $price_absolute_total;
                } 
                $address = "";
                if (MetabaseFetchResult($gDatabase, $result, 0, 18) !== 'n/a') {
                    $address .= MetabaseFetchResult($gDatabase, $result, 0, 18) . "\n";
                } 

                if (trim(MetabaseFetchResult($gDatabase, $result, 0, 13)) !== "") {
                    $address .= MetabaseFetchResult($gDatabase, $result, 0, 13) . " ";
                } 
                $address .= MetabaseFetchResult($gDatabase, $result, 0, 11) . " " . MetabaseFetchResult($gDatabase, $result, 0, 12) . "\n";
                $address .= MetabaseFetchResult($gDatabase, $result, 0, 17) . "\n";
                $address .= MetabaseFetchResult($gDatabase, $result, 0, 15) . " " . MetabaseFetchResult($gDatabase, $result, 0, 16) . "\n\n";
                if (MetabaseFetchResult($gDatabase, $result, 0, 19) !== 'n/a') {
                    $address .= MetabaseFetchResult($gDatabase, $result, 0, 19);
                } 

                $receipt[data] = array ('bookid' => $bookingid,
                    'guestid' => $guestid,
                    'referenceid' => '',
                    'address' => $address,
                    'receipt_date' => date("d.m.Y"),
                    'start_date' => array (MetabaseFetchResult($gDatabase, $result, 0, 4)),
                    'end_date' => array (MetabaseFetchResult($gDatabase, $result, 0, 5)),
                    'receiptid' => '-1',
                    'draftreceiptid' => '-1',
                    'price_netto_total' => $price_netto_total,
                    'price_total' => $price_total,
                    'pauscherror' => $pauscherror
                    );

                $i = 0;
                $nextcolor = 0;

                if ($price_type == "PP") {
                    if ($persons > 0) {
                        $article = MetabaseFetchResult($gDatabase, $result, 0, 20) . "\n";
                        $article .= $persons;
                        if ($persons > 1) {
                            $article .= " Erwachsene\n";
                        } else {
                            $article .= " Erwachsener\n";
                        } 
                        $article .= $realdays;
                        if ($realdays > 1) {
                            $article .= " &Uuml;bernachtungen";
                        } else {
                            $article .= " &Uuml;bernachtung";
                        } 
                        if (MetabaseFetchResult($gDatabase, $result, 0, 21) == 'true') {
                            $article .= " (Kurzbuchertarif)";
                        } 

                        $receipt[items][$i][color] = $nextcolor;
                        $receipt[items][$i][id] = $i;
                        $receipt[items][$i][itemid] = -1;
                        $receipt[items][$i][article] = $article;
                        $receipt[items][$i][number] = $num_person;
                        $receipt[items][$i][netto_single] = number_format($price_person_netto, 2, '.', '');
                        $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                        $receipt[items][$i][brutto_single] = number_format($price_person, 2, '.', '');
                        $receipt[items][$i][netto] = number_format($price_person_netto_total, 2, '.', '');
                        $receipt[items][$i][brutto] = number_format($price_person_total, 2, '.', '');
                        $personlocation = $i;
                        $i++;
                        if ($nextcolor == 0) {
                            $nextcolor = 1;
                        } else {
                            $nextcolor = 0;
                        } 
                    } 
                    if ($children > 0) {
                        $article = MetabaseFetchResult($gDatabase, $result, 0, 20) . "\n";
                        $article .= $children;
                        /*
                    if ($children > 1) {
                        $article .= " Kinder\n";
                    } else {
                        $article .= " Kind\n";
                    } 
					*/
                        $article .= " " . $request->GetVar('children1', 'session') . "\n";
                        $article .= $days;
                        if ($days > 1) {
                            $article .= " &Uuml;bernachtungen";
                        } else {
                            $article .= " &Uuml;bernachtung";
                        } 
                        if (MetabaseFetchResult($gDatabase, $result, 0, 21) == 'true') {
                            $article .= " (Kurzbuchertarif)";
                        } 

                        $receipt[items][$i][color] = $nextcolor;
                        $receipt[items][$i][id] = $i;
                        $receipt[items][$i][itemid] = -1;
                        $receipt[items][$i][article] = $article;
                        $receipt[items][$i][number] = $num_children;
                        $receipt[items][$i][netto_single] = number_format($price_children_netto, 2, '.', '');
                        $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                        $receipt[items][$i][brutto_single] = number_format($price_children, 2, '.', '');
                        $receipt[items][$i][netto] = number_format($price_children_netto_total, 2, '.', '');
                        $receipt[items][$i][brutto] = number_format($price_children_total, 2, '.', '');
                        $childrenlocation = $i;
                        $i++;
                        if ($nextcolor == 0) {
                            $nextcolor = 1;
                        } else {
                            $nextcolor = 0;
                        } 
                    } 
                    if ($children2 > 0) {
                        $article = MetabaseFetchResult($gDatabase, $result, 0, 20) . "\n";
                        $article .= $children2;
                        /*
                    if ($children2 > 1) {
                        $article .= " Kinder\n";
                    } else {
                        $article .= " Kind\n";
                    } 
					*/
                        $article .= " " . $request->GetVar('children2', 'session') . "\n";
                        $article .= $days;
                        if ($days > 1) {
                            $article .= " &Uuml;bernachtungen";
                        } else {
                            $article .= " &Uuml;bernachtung";
                        } 
                        if (MetabaseFetchResult($gDatabase, $result, 0, 26) == 'true') {
                            $article .= " (Kurzbuchertarif)";
                        } 

                        $receipt[items][$i][color] = $nextcolor;
                        $receipt[items][$i][id] = $i;
                        $receipt[items][$i][itemid] = -1;
                        $receipt[items][$i][article] = $article;
                        $receipt[items][$i][number] = $num_children2;
                        $receipt[items][$i][netto_single] = number_format($price_children2_netto, 2, '.', '');
                        $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                        $receipt[items][$i][brutto_single] = number_format($price_children2, 2, '.', '');
                        $receipt[items][$i][netto] = number_format($price_children2_netto_total, 2, '.', '');
                        $receipt[items][$i][brutto] = number_format($price_children2_total, 2, '.', '');
                        $children2location = $i;
                        $i++;
                        if ($nextcolor == 0) {
                            $nextcolor = 1;
                        } else {
                            $nextcolor = 0;
                        } 
                    } 
                    if ($children3 > 0) {
                        $article = MetabaseFetchResult($gDatabase, $result, 0, 20) . "\n";
                        $article .= $children3;
                        /*
                    if ($children3 > 1) {
                        $article .= " Kinder\n";
                    } else {
                        $article .= " Kind\n";
                    } 
					*/
                        $article .= " " . $request->GetVar('children3', 'session') . "\n";
                        $article .= $days;
                        if ($days > 1) {
                            $article .= " &Uuml;bernachtungen";
                        } else {
                            $article .= " &Uuml;bernachtung";
                        } 
                        if (MetabaseFetchResult($gDatabase, $result, 0, 27) == 'true') {
                            $article .= " (Kurzbuchertarif)";
                        } 

                        $receipt[items][$i][color] = $nextcolor;
                        $receipt[items][$i][id] = $i;
                        $receipt[items][$i][itemid] = -1;
                        $receipt[items][$i][article] = $article;
                        $receipt[items][$i][number] = $num_children3;
                        $receipt[items][$i][netto_single] = number_format($price_children3_netto, 2, '.', '');
                        $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                        $receipt[items][$i][brutto_single] = number_format($price_children3, 2, '.', '');
                        $receipt[items][$i][netto] = number_format($price_children3_netto_total, 2, '.', '');
                        $receipt[items][$i][brutto] = number_format($price_children3_total, 2, '.', '');
                        $children3location = $i;
                        $i++;
                        if ($nextcolor == 0) {
                            $nextcolor = 1;
                        } else {
                            $nextcolor = 0;
                        } 
                    } 
                } else {
                    $article = MetabaseFetchResult($gDatabase, $result, 0, 20) . "\n";
                    $article .= $days;
                    if ($days > 1) {
                        $article .= " &Uuml;bernachtungen";
                    } else {
                        $article .= " &Uuml;bernachtung";
                    } 
                    if (MetabaseFetchResult($gDatabase, $result, 0, 21) == 'true') {
                        $article .= " (Kurzbuchertarif)";
                    } 

                    $receipt[items][$i][color] = $nextcolor;
                    $receipt[items][$i][id] = $i;
                    $receipt[items][$i][itemid] = -1;
                    $receipt[items][$i][article] = $article;
                    $receipt[items][$i][number] = $num_absolute;
                    $receipt[items][$i][netto_single] = number_format($price_absolute_netto, 2, '.', '');
                    $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                    $receipt[items][$i][brutto_single] = number_format($price_absolute, 2, '.', '');
                    $receipt[items][$i][netto] = number_format($price_absolute_netto_total, 2, '.', '');
                    $receipt[items][$i][brutto] = number_format($price_absolute_total, 2, '.', '');
                    $pauschlocation = $i;
                    $i++;
                    if ($nextcolor == 0) {
                        $nextcolor = 1;
                    } else {
                        $nextcolor = 0;
                    } 
                } 

                $query = "SELECT article, price_netto, price_brutto, mwst, price_type, 
					  person, children, children2, children3, included
					  FROM $tbl_article, $tbl_roomcat_article
					  WHERE pk_article_id = pk_fk_article_id 
					  AND pk_fk_roomcat_id = " . $roomcatid;
                $result2 = MetabaseQuery($gDatabase, $query);
                if (!$result2) {
                    $errorhandler->display('SQL', 'Receipt::get()', $query);
                } else {
                    for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result2)) == 0; ++$row) {
                        $price_substract = MetabaseFetchResult($gDatabase, $result2, $row, 2);
                        $price_netto_substract = round($price_substract * 100 / (100 + $mwst_room), 2);
                        if (MetabaseFetchResult($gDatabase, $result2, $row, 4) == 'PP') {
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 5) == true && $num_person > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_person;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_person * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_person * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;
                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 
                                // substract included articles
                                if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 9) == true) {
                                    $price_person -= $price_substract;
                                    $price_person_netto = round($price_person * 100 / (100 + $mwst_room), 2);
                                    $price_person_total = $num_person * $price_person;
                                    $price_person_netto_total = $num_person * $price_person_netto;
                                    $receipt[items][$personlocation][brutto_single] = number_format($price_person , 2, '.', '');
                                    $receipt[items][$personlocation][netto_single] = number_format($price_person_netto, 2, '.', '');
                                    $receipt[items][$personlocation][netto] = number_format($price_person_netto_total, 2, '.', '');
                                    $receipt[items][$personlocation][brutto] = number_format($price_person_total, 2, '.', '');
                                    $receipt[data][price_netto_total] -= $price_netto_substract * $num_person;
                                    $receipt[data][price_total] -= $price_substract * $num_person;
                                } 

                                $receipt[data][price_netto_total] = $receipt[data][price_netto_total] + ($num_person * MetabaseFetchResult($gDatabase, $result2, $row, 1));
                                $receipt[data][price_total] = $receipt[data][price_total] + ($num_person * MetabaseFetchResult($gDatabase, $result2, $row, 2));
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 6) == true && $num_children > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_children;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;
                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 
                                // substract included articles
                                if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 9) == true) {
                                    $price_children -= $price_substract;
                                    $price_children_netto = round($price_children * 100 / (100 + $mwst_room), 2);
                                    $price_children_total = $num_children * $price_children;
                                    $price_children_netto_total = $num_children * $price_children_netto;
                                    $receipt[items][$childrenlocation][brutto_single] = number_format($price_children , 2, '.', '');
                                    $receipt[items][$childrenlocation][netto_single] = number_format($price_children_netto, 2, '.', '');
                                    $receipt[items][$childrenlocation][netto] = number_format($price_children_netto_total, 2, '.', '');
                                    $receipt[items][$childrenlocation][brutto] = number_format($price_children_total, 2, '.', '');
                                    $receipt[data][price_netto_total] -= $price_netto_substract * $num_children;
                                    $receipt[data][price_total] -= $price_substract * $num_children;
                                } 
                                $receipt[data][price_netto_total] = $receipt[data][price_netto_total] + ($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 1));
                                $receipt[data][price_total] = $receipt[data][price_total] + ($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 2));
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 7) == true && $num_children2 > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_children2;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;
                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 
                                // substract included articles
                                if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 9) == true) {
                                    $price_children2 -= $price_substract;
                                    $price_children2_netto = round($price_children2 * 100 / (100 + $mwst_room), 2);
                                    $price_children2_total = $num_children2 * $price_children2;
                                    $price_children2_netto_total = $num_children2 * $price_children2_netto;
                                    $receipt[items][$children2location][brutto_single] = number_format($price_children2 , 2, '.', '');
                                    $receipt[items][$children2location][netto_single] = number_format($price_children2_netto, 2, '.', '');
                                    $receipt[items][$children2location][netto] = number_format($price_children2_netto_total, 2, '.', '');
                                    $receipt[items][$children2location][brutto] = number_format($price_children2_total, 2, '.', '');
                                    $receipt[data][price_netto_total] -= $price_netto_substract * $num_children2;
                                    $receipt[data][price_total] -= $price_substract * $num_children2;
                                } 
                                $receipt[data][price_netto_total] = ($receipt[data][price_netto_total] + ($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 1)));
                                $receipt[data][price_total] = ($receipt[data][price_total] + ($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 2)));
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 6) == true && $num_children3 > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_children3;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;
                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 
                                // substract included articles
                                if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 9) == true) {
                                    $price_children3 -= $price_substract;
                                    $price_children3_netto = round($price_children3 * 100 / (100 + $mwst_room), 2);
                                    $price_children3_total = $num_children3 * $price_children3;
                                    $price_children3_netto_total = $num_children3 * $price_children3_netto;
                                    $receipt[items][$children3location][brutto_single] = number_format($price_children3 , 2, '.', '');
                                    $receipt[items][$children3location][netto_single] = number_format($price_children3_netto, 2, '.', '');
                                    $receipt[items][$children3location][netto] = number_format($price_children3_netto_total, 2, '.', '');
                                    $receipt[items][$children3location][brutto] = number_format($price_children3_total, 2, '.', '');
                                    $receipt[data][price_netto_total] -= $price_netto_substract * $num_children3;
                                    $receipt[data][price_total] -= $price_substract * $num_children3;
                                } 
                                $receipt[data][price_netto_total] = ($receipt[data][price_netto_total] + ($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 1)));
                                $receipt[data][price_total] = ($receipt[data][price_total] + ($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 2)));
                            } 
                        } else {
                            $receipt[items][$i][color] = $nextcolor;
                            $receipt[items][$i][id] = $i;
                            $receipt[items][$i][itemid] = -1;
                            $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                            $receipt[items][$i][number] = 1;
                            $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                            $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                            $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                            $receipt[items][$i][netto] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                            $receipt[items][$i][brutto] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                            $i++;
                            if ($nextcolor == 0) {
                                $nextcolor = 1;
                            } else {
                                $nextcolor = 0;
                            } 

                            $receipt[data][price_netto_total] = ($receipt[data][price_netto_total] + MetabaseFetchResult($gDatabase, $result2, $row, 1));
                            $receipt[data][price_total] = ($receipt[data][price_total] + MetabaseFetchResult($gDatabase, $result2, $row, 2));
                        } 
                    } 
                } 
                $receipt[data][price_netto_total] = number_format($receipt[data][price_netto_total], 2, '.', '');
                $receipt[data][price_total] = number_format($receipt[data][price_total], 2, '.', '');
            } 
            // advanced price type
        } else {
            $query = "SELECT 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_short <> 0.00
							THEN 
								p.price_short
							ELSE
								p.price
						END AS price, 
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_short_additional <> 0.00
							THEN 
								p.price_short_additional
							ELSE
								p.price_additional
						END	AS price_additional, 
						 DATE_FORMAT(b.start_date, '%d.%m.%Y'), DATE_FORMAT(b.end_date, '%d.%m.%Y'), 
						 r.room, s.name, 
						 TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) AS days, 
						 g.firstname, g.lastname, g.academic_title, b.booking_reference_id,
						 a.postalcode, a.city, a.address, sal.salutation_de, coun.country_de, 
						 bc.bookingcat,
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_short <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END AS price_short, 	
					CASE  
						WHEN TO_DAYS( b.end_date ) - TO_DAYS( b.start_date ) <= $length_short_stay AND p.price_short_additional <> 0.00
							THEN 
								'true'
							ELSE
								'false'
						END	AS price_short_additional, 
					b.persons + b.children + b.children2 + b.children3 as persons, 
					r.fk_roomcat_id, g.pk_guest_id, p.persons_included, b.persons, b.children, b.children2,
					b.children3, bc.days 																																						 
					FROM $tbl_price2 p, $tbl_booking b
					LEFT JOIN $tbl_booking_detail bd ON bd.fk_booking_id = b.pk_booking_id
					LEFT JOIN $tbl_room r ON bd.fk_room_id = r.pk_room_id
					LEFT JOIN $tbl_guest g ON (b.fk_guest_id = g.pk_guest_id) 
				 	LEFT JOIN $tbl_guest_address ga ON (ga.default_address  = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
					 	AND g.pk_guest_id = ga.pk_fk_guest_id) 
				 	LEFT JOIN $tbl_address a ON (a.pk_address_id = ga.pk_fk_address_id) 
					LEFT JOIN $tbl_salutation sal ON (g.fk_salutation_id = sal.pk_salutation_id) 
					LEFT JOIN $tbl_country coun ON (a.fk_country_id = coun.pk_country_id )	
					LEFT JOIN $tbl_bookingcat bc ON (b.fk_bookingcat_id = bc.pk_bookingcat_id) 
					LEFT JOIN $tbl_season s ON b.start_date BETWEEN s.start_date AND s.end_date AND ISNULL(s.deleted_date)
					WHERE b.pk_booking_id = $bookingid 
							AND p.fk_roomcat_id = r.fk_roomcat_id 
							AND p.fk_bookingcat_id = b.fk_bookingcat_id 
							AND p.fk_season_id = s.pk_season_id 
							AND ISNULL(p.deleted_date)
				";
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Receipt::get()', $query);
            } else {
                $bcdays = MetabaseFetchResult($gDatabase, $result, 0, 27);
                $roomcatid = MetabaseFetchResult($gDatabase, $result, 0, 20);
                $realdays = MetabaseFetchResult($gDatabase, $result, 0, 6);
                $days = ceil($realdays / $bcdays);
                if ($realdays % $bcdays <> 0) {
                    $pauscherror = "Die Buchungskategorie enth&auml;lt $bcdays Tage - es wurden aber $realdays Tage gebucht!";
                } else {
                    $pauscherror = '';
                } 
                $persons = MetabaseFetchResult($gDatabase, $result, 0, 19);
                $num_person = $days * $persons;
                $base_price = MetabaseFetchResult($gDatabase, $result, 0, 0);
                $base_price_netto = round($base_price * 100 / (100 + $mwst_room), 2);
                $base_price_total = $days * $base_price;
                $base_price_netto_total = $days * $base_price_netto;
                $included = MetabaseFetchResult($gDatabase, $result, 0, 22);
                $add_num = $persons - $included;
                $add_price = MetabaseFetchResult($gDatabase, $result, 0, 1);
                $add_price_netto = round($add_price * 100 / (100 + $mwst_room), 2);
                if ($add_num > 0) {
                    $add_price_total = $days * $add_num * $add_price;
                    $add_price_netto_total = $days * $add_num * $add_price_netto;
                } else {
                    $add_price_total = 0.00;
                    $add_price_netto_total = 0.00;
                } 
                $num_persons = $days * MetabaseFetchResult($gDatabase, $result, 0, 23);
                $num_children = $days * MetabaseFetchResult($gDatabase, $result, 0, 24);
                $num_children2 = $days * MetabaseFetchResult($gDatabase, $result, 0, 25);
                $num_children3 = $days * MetabaseFetchResult($gDatabase, $result, 0, 25);

                $guestid = MetabaseFetchResult($gDatabase, $result, 0, 21);

                $price_netto_total = $base_price_netto_total + $add_price_netto_total;
                $price_total = $base_price_total + $add_price_total;

                $address = "";
                if (MetabaseFetchResult($gDatabase, $result, 0, 14) !== 'n/a') {
                    $address .= MetabaseFetchResult($gDatabase, $result, 0, 14) . "\n";
                } 

                if (trim(MetabaseFetchResult($gDatabase, $result, 0, 9)) !== "") {
                    $address .= MetabaseFetchResult($gDatabase, $result, 0, 9) . " ";
                } 
                $address .= MetabaseFetchResult($gDatabase, $result, 0, 7) . " " . MetabaseFetchResult($gDatabase, $result, 0, 8) . "\n";
                $address .= MetabaseFetchResult($gDatabase, $result, 0, 13) . "\n";
                $address .= MetabaseFetchResult($gDatabase, $result, 0, 11) . " " . MetabaseFetchResult($gDatabase, $result, 0, 12) . "\n\n";
                if (MetabaseFetchResult($gDatabase, $result, 0, 15) !== 'n/a') {
                    $address .= MetabaseFetchResult($gDatabase, $result, 0, 15);
                } 

                $receipt[data] = array ('bookid' => $bookingid,
                    'guestid' => $guestid,
                    'referenceid' => MetabaseFetchResult($gDatabase, $result, 0, 10) . '-R',
                    'address' => $address,
                    'receipt_date' => date("d.m.Y"),
                    'start_date' => array (MetabaseFetchResult($gDatabase, $result, 0, 2)),
                    'end_date' => array (MetabaseFetchResult($gDatabase, $result, 0, 3)),
                    'receiptid' => '-1',
                    'price_netto_total' => $price_netto_total,
                    'price_total' => $price_total,
                    'pauscherror' => $pauscherror
                    );
                $i = 0;
                $nextcolor = 0;

                if ($persons > 0) {
                    $article = MetabaseFetchResult($gDatabase, $result, 0, 16) . "\n";
                    $article .= "Grundpreis (";
                    if ($persons > $included) {
                        $article .= $included;
                    } else {
                        $article .= $persons;
                    } 
                    if ($persons > 1) {
                        $article .= " Personen)\n";
                    } else {
                        $article .= " Person)\n";
                    } 
                    $article .= $realdays;
                    if ($realdays > 1) {
                        $article .= " &Uuml;bernachtungen";
                    } else {
                        $article .= " &Uuml;bernachtung";
                    } 
                    if (MetabaseFetchResult($gDatabase, $result, 0, 17) == 'true') {
                        $article .= " (Kurzbuchertarif)";
                    } 

                    $receipt[items][$i][color] = $nextcolor;
                    $receipt[items][$i][id] = $i;
                    $receipt[items][$i][itemid] = -1;
                    $receipt[items][$i][article] = $article;
                    $receipt[items][$i][number] = $days;
                    $receipt[items][$i][netto_single] = number_format($base_price_netto, 2, '.', '');
                    $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                    $receipt[items][$i][brutto_single] = number_format($base_price, 2, '.', '');
                    $receipt[items][$i][netto] = number_format($base_price_netto_total, 2, '.', '');
                    $receipt[items][$i][brutto] = number_format($base_price_total, 2, '.', '');
                    $i++;

                    if ($nextcolor == 0) {
                        $nextcolor = 1;
                    } else {
                        $nextcolor = 0;
                    } 
                } 
                if ($add_num > 0) {
                    $article = MetabaseFetchResult($gDatabase, $result, 0, 16) . "\n";

                    if ($add_num > 1) {
                        $article .= $add_num . " zus&auml;tzliche Personen\n";
                    } else {
                        $article .= $add_num . " zus&auml;tzliche Person\n";
                    } 

                    $article .= $days;
                    if ($days > 1) {
                        $article .= " &Uuml;bernachtungen";
                    } else {
                        $article .= " &Uuml;bernachtung";
                    } 
                    if (MetabaseFetchResult($gDatabase, $result, 0, 18) == 'true') {
                        $article .= " (Kurzbuchertarif)";
                    } 

                    $receipt[items][$i][color] = $nextcolor;
                    $receipt[items][$i][id] = $i;
                    $receipt[items][$i][itemid] = -1;
                    $receipt[items][$i][article] = $article;
                    $receipt[items][$i][number] = $add_num * $days;
                    $receipt[items][$i][netto_single] = number_format($add_price_netto, 2, '.', '');
                    $receipt[items][$i][mwst] = $request->GetVar('mwst_room', 'Session');
                    $receipt[items][$i][brutto_single] = number_format($add_price, 2, '.', '');
                    $receipt[items][$i][netto] = number_format($add_price_netto_total, 2, '.', '');
                    $receipt[items][$i][brutto] = number_format($add_price_total, 2, '.', '');
                    $i++;
                    if ($nextcolor == 0) {
                        $nextcolor = 1;
                    } else {
                        $nextcolor = 0;
                    } 
                } 

                $query = "SELECT article, price_netto, price_brutto, mwst, price_type, 
					  person, children, children2, children3, included
					  FROM $tbl_article, $tbl_roomcat_article
					  WHERE pk_article_id = pk_fk_article_id 
					  AND pk_fk_roomcat_id = " . $roomcatid;
                $result2 = MetabaseQuery($gDatabase, $query);
                if (!$result2) {
                    $errorhandler->display('SQL', 'Receipt::get()', $query);
                } else {
                    for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result2)) == 0; ++$row) {
                        $price_substract = MetabaseFetchResult($gDatabase, $result2, $row, 1);
                        $price_netto_substract = round($price_substract * 100 / (100 + $mwst_room), 2);
                        if (MetabaseFetchResult($gDatabase, $result2, $row, 4) == 'PP') {
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 5) == true && $num_person > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_persons;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_persons * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_persons * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;
                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 

                                $receipt[data][price_netto_total] = $receipt[data][price_netto_total] + ($num_persons * MetabaseFetchResult($gDatabase, $result2, $row, 1));
                                $receipt[data][price_total] = $receipt[data][price_total] + ($num_persons * MetabaseFetchResult($gDatabase, $result2, $row, 2));
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 6) == true && $num_children > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_children;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;

                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 

                                $receipt[data][price_netto_total] = $receipt[data][price_netto_total] + ($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 1));
                                $receipt[data][price_total] = $receipt[data][price_total] + ($num_children * MetabaseFetchResult($gDatabase, $result2, $row, 2));
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 7) == true && $num_children2 > 0) {
                                $receipt[items][$i][color] = $nextcolor;
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_children2;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;

                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 

                                $receipt[data][price_netto_total] = ($receipt[data][price_netto_total] + ($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 1)));
                                $receipt[data][price_total] = ($receipt[data][price_total] + ($num_children2 * MetabaseFetchResult($gDatabase, $result2, $row, 2)));
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row, 6) == true && $num_children3 > 0) {
                                $receipt[items][$i][color] = $nextcolor . "children3";
                                $receipt[items][$i][id] = $i;
                                $receipt[items][$i][itemid] = -1;
                                $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                                $receipt[items][$i][number] = $num_children3;
                                $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                                $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                                $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                                $receipt[items][$i][netto] = number_format(($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 1)), 2, '.', '');
                                $receipt[items][$i][brutto] = number_format(($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 2)), 2, '.', '');
                                $i++;
                                if ($nextcolor == 0) {
                                    $nextcolor = 1;
                                } else {
                                    $nextcolor = 0;
                                } 

                                $receipt[data][price_netto_total] = ($receipt[data][price_netto_total] + ($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 1)));
                                $receipt[data][price_total] = ($receipt[data][price_total] + ($num_children3 * MetabaseFetchResult($gDatabase, $result2, $row, 2)));
                            } 
                        } else {
                            $receipt[items][$i][color] = $nextcolor;
                            $receipt[items][$i][id] = $i;
                            $receipt[items][$i][itemid] = -1;
                            $receipt[items][$i][article] = MetabaseFetchResult($gDatabase, $result2, $row, 0);
                            $receipt[items][$i][number] = 1;
                            $receipt[items][$i][netto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                            $receipt[items][$i][mwst] = MetabaseFetchResult($gDatabase, $result2, $row, 3);
                            $receipt[items][$i][brutto_single] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                            $receipt[items][$i][netto] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 1), 2, '.', '');
                            $receipt[items][$i][brutto] = number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2), 2, '.', '');
                            $i++;
                            if ($nextcolor == 0) {
                                $nextcolor = 1;
                            } else {
                                $nextcolor = 0;
                            } 

                            $receipt[data][price_netto_total] = ($receipt[data][price_netto_total] + MetabaseFetchResult($gDatabase, $result2, $row, 1));
                            $receipt[data][price_total] = ($receipt[data][price_total] + MetabaseFetchResult($gDatabase, $result2, $row, 2));
                        } 
                    } 
                } 
                $receipt[data][price_netto_total] = number_format($receipt[data][price_netto_total], 2, '.', '');
                $receipt[data][price_total] = number_format($receipt[data][price_total], 2, '.', '');
            } 
        } 
        return $receipt;
    } 

    /**
    * price::recalculate()
    * 
    * recalculate receipt
    * 
    * @access public 
    * @param number $bookingid booking id
    * @param number $length_short_stay length of short stay
    * @param number $guestid 
    * @return array receipt
    * @since 2004-02-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function recalculate($bookingid, $length_short_stay, $guestid)
    {
        global $request;
        $mwst_room = $request->GetVar('mwst_room', 'Session');
        $receiptdata = $this->get($bookingid, $length_short_stay, $guestid);
        $receiptdata[data][address] = $request->GetVar('frm_address', 'post');
        $receiptdata[data][referenceid] = $request->GetVar('frm_referenceid', 'post');
        $receiptdata[data][receipt_date] = $request->GetVar('frm_receiptdate', 'post');
        $receiptdata[data][receiptid] = $request->GetVar('frm_receiptid', 'post');
        $receiptdata[data][draftreceiptid] = $request->GetVar('frm_draftreceiptid', 'post');
        $start_arr = array();
        $end_arr = array();
        $i = 0;
        while ($request->GetVar('frm_start_' . $i, 'post') !== $request->undefined) {
            $start_arr[$i] = $request->GetVar('frm_start_' . $i, 'post');
            $end_arr[$i] = $request->GetVar('frm_end_' . $i, 'post');
            ++$i;
        } 
        $receiptdata[data][start_date] = $start_arr;
        $receiptdata[data][end_date] = $end_arr;
        $receiptdata[items] = $this->getitems();
        $price_netto_total = 0.00;
        $price_total = 0.00;
        for ($i = 0; $i < count($receiptdata[items]); $i++) {
            $price_netto_total += $receiptdata[items][$i][netto];
            $price_total += $receiptdata[items][$i][brutto];
        } 
        $receiptdata[data][price_netto_total] = number_format($price_netto_total, 2, '.', '');
        $receiptdata[data][price_total] = number_format($price_total, 2, '.', '');
        return $receiptdata;
    } 

    /**
    * price::getitems()
    * 
    * get receipt itmes
    * 
    * @access public 
    * @return array receipt items
    * @since 2004-02-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getitems()
    {
        global $request;
        $receiptitems = array();
        $nextcolor = 0;
        $i = 0;
        do {
            $article = $request->GetVar('frm_article_' . $i, 'post');
            $number = $request->GetVar('frm_number_' . $i, 'post');
            $mwst = $request->GetVar('frm_mwst_' . $i, 'post');
            $itemid = $request->GetVar('frm_itemid_' . $i, 'post');
            $brutto_single = $request->GetVar('frm_brutto_' . $i, 'post');
            $brutto = $number * $brutto_single;
            $netto_single = round($brutto_single * 100 / (100 + $mwst), 2);
            $netto = $number * $netto_single;
            $receiptitems[$i][color] = $nextcolor;
            $receiptitems[$i][id] = $i;
            $receiptitems[$i][itemid] = $itemid;
            $receiptitems[$i][article] = $article;
            $receiptitems[$i][number] = $number;
            $receiptitems[$i][netto_single] = number_format($netto_single, 2, '.', '');
            $receiptitems[$i][mwst] = $mwst;
            $receiptitems[$i][brutto_single] = number_format($brutto_single, 2, '.', '');
            $receiptitems[$i][netto] = number_format($netto, 2, '.', '');
            $receiptitems[$i][brutto] = number_format($brutto, 2, '.', '');
            if ($nextcolor == "0") {
                $nextcolor = "1";
            } else {
                $nextcolor = "0";
            } 

            $i++;
        } while ($request->GetVar('frm_article_' . $i, 'post') !== $request->undefined);

        return $receiptitems;
    } 
    /**
    * price::save()
    * 
    * save receipt
    * 
    * @return $receiptid receipt id
    * @access public 
    * @since 2004-02-26
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function save()
    {
        global $gDatabase, $tbl_receiptnumber, $tbl_receipt, $tbl_receipt_booking, $tbl_receipt_item, $tbl_account, $errorhandler, $request;
        include_once("accountclass.inc.php");
        $accountcls = new Account;
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        $receipt = array();
        $doneitems = array();
        $commissionids = array();
        $commissionids = $request->GetVar('frm_commissionid', 'post');
        $receipt = $this->recalculate($request->GetVar('frm_bookid', 'post'), $request->GetVar('length_short_stay', 'session'), $request->GetVar('frm_guestid', 'post'));
        $receiptdate = explode(".", $receipt[data][receipt_date]);
        $strreceiptdate = $receiptdate[2] . "-" . $receiptdate[1] . "-" . $receiptdate[0];

        if ($request->GetVar('frm_bookids', 'post') !== $request->undefined) {
            $bookids = $request->GetVar('frm_bookids', 'post');
        } else {
            $bookids = array($request->GetVar('frm_bookid', 'post'));
        } 

        for ($i = 0; $i < count($receipt[data][start_date]); $i++) {
            $start = explode(".", $receipt[data][start_date][$i]);
            $strstart[$i] = $start[2] . "-" . $start[1] . "-" . $start[0];
            $end = explode(".", $receipt[data][end_date][$i]);
            $strend[$i] = $end[2] . "-" . $end[1] . "-" . $end[0];
        } 

        if ($receipt[data][receiptid] <> -1) {
            $receiptid = $receipt[data][receiptid];
            $query = sprintf("UPDATE $tbl_receipt SET
							  fk_guest_id = %s,
							  address = %s,
						 	  receipt_date = %s, 
							  sum_netto = %s, 
							  sum_brutto = %s, 
						 	  updated_date = NOW(), 
							  fk_updated_user_id = %s
							  WHERE pk_receipt_id = %s",
                $receipt[data][guestid],
                MetabaseGetTextFieldValue($gDatabase, $receipt[data][address]),
                MetabaseGetTextFieldValue($gDatabase, $strreceiptdate),
                $receipt[data][price_netto_total],
                $receipt[data][price_total],
                $request->GetVar('uid', 'session'),
                $receiptid
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Receipt::save()', $query);
            } else {
                for ($i = 0; $i < count($bookids); $i++) {
                    // delete drafts
                    if ($this->getDraftReceiptId($bookids[$i], $receipt[data][guestid]) !== -1) {
                        $this->deletedraft($this->getDraftReceiptId($bookids[$i], $receipt[data][guestid]), false);
                    } 
                    $query = sprintf("UPDATE $tbl_receipt_booking
								  SET start_date = %s, end_date = %s
								  WHERE pk_fk_receipt_id = %s AND pk_fk_booking_id = %s",
                        MetabaseGetTextFieldValue($gDatabase, $strstart[$i]),
                        MetabaseGetTextFieldValue($gDatabase, $strend[$i]),
                        $receiptid,
                        $bookids[$i]
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Receipt::save()', $query);
                    } 
                } 
                // get all items which are in the system
                $query = "SELECT pk_receipt_item_id FROM $tbl_receipt_item WHERE fk_receipt_id = " . $receipt[data][receiptid];
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Receipt::save()', $query);
                } else {
                    $olditems = array();
                    for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                        $olditems[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                    } 
                    for ($i = 0; $i < count($receipt[items]); ++$i) {
                        // is a new one
                        if ($receipt[items][$i][itemid] == -1 || !in_array($receipt[items][$i][itemid], $olditems)) {
                            $name = "zvs_pk_receipt_item_id";
                            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$receiptitemid);
                            $query = sprintf("INSERT INTO $tbl_receipt_item
							 (pk_receipt_item_id, fk_receipt_id, article, amount,
							 price_netto, price_brutto, mwst,  
							 inserted_date, fk_inserted_user_id)
							 VALUES (%s, %s, %s, %s, %s, %s, %s, NOW(), %s )",
                                $receiptitemid,
                                $receiptid,
                                MetabaseGetTextFieldValue($gDatabase, $receipt[items][$i][article]),
                                $receipt[items][$i][number],
                                $receipt[items][$i][netto_single],
                                $receipt[items][$i][brutto_single],
                                $receipt[items][$i][mwst],
                                $request->GetVar('uid', 'session')
                                );
                            $result = MetabaseQuery($gDatabase, $query);
                            if (!$result) {
                                $success = MetabaseRollbackTransaction($gDatabase);
                                $errorhandler->display('SQL', 'Receipt::save()', $query);
                            } 
                        } else {
                            array_push($doneitems, $receipt[items][$i][itemid]);
                            $query = sprintf("UPDATE $tbl_receipt_item SET
									  article = %s, 
									  amount = %s,
							 		  price_netto = %s, 
									  price_brutto = %s, 
									  mwst = %s,  
							 		  updated_date = NOW(), 
									  fk_updated_user_id = %s
									  WHERE pk_receipt_item_id = %s",
                                MetabaseGetTextFieldValue($gDatabase, $receipt[items][$i][article]),
                                $receipt[items][$i][number],
                                $receipt[items][$i][netto_single],
                                $receipt[items][$i][brutto_single],
                                $receipt[items][$i][mwst],
                                $request->GetVar('uid', 'session'),
                                $receipt[items][$i][itemid]
                                );
                            $result = MetabaseQuery($gDatabase, $query);
                            if (!$result) {
                                $success = MetabaseRollbackTransaction($gDatabase);
                                $errorhandler->display('SQL', 'Receipt::save()', $query);
                            } 
                        } 
                    } 
                    // set deleted items delted
                    $deleteitems = array_values(array_diff($olditems, $doneitems));
                    for ($i = 0; $i < count($deleteitems); $i++) {
                        $query = sprintf("UPDATE $tbl_receipt_item SET
										deleted_date = NOW(),
										fk_deleted_user_id = %s
										WHERE pk_receipt_item_id = %s ",
                            $request->GetVar('uid', 'session'),
                            $deleteitems[$i]
                            );
                        $result = MetabaseQuery($gDatabase, $query);
                        if (!$result) {
                            $success = MetabaseRollbackTransaction($gDatabase);
                            $errorhandler->display('SQL', 'Receipt::save()', $query);
                        } 
                    } 
                } 
            } 
        } else {
            // get reference_id
            $query = sprintf("SELECT actual_number, year FROM $tbl_receiptnumber
							  LIMIT 0,1");
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Receipt::save()', $query);
            } else {
                $todaydate = getdate();
                $thisyear = $todaydate['year'];
                $referenceid = MetabaseFetchResult($gDatabase, $result, 0, 0);
                $year = MetabaseFetchResult($gDatabase, $result, 0, 1);

                if ($year < $thisyear) {
                    $referenceid = 0000000001;
                    $year = $thisyear;
                } else {
                    $referenceid += 1;
                } 
                $query = "UPDATE $tbl_receiptnumber
						 SET actual_number = $referenceid,
						 year = $year ";
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Receipt::save()', $query);
                } 
                $strreferenceid = $thisyear . "-" . substr($referenceid + 10000000000, 1);
            } 

            $name = "zvs_pk_receipt_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$receiptid);
            $query = sprintf("INSERT INTO $tbl_receipt
						 (pk_receipt_id, fk_guest_id, receipt_reference_id, address,
						 receipt_date,  sum_netto, sum_brutto, 
						 inserted_date, fk_inserted_user_id)
						 VALUES (%s, %s, %s, %s, %s, %s, %s, NOW(), %s )",
                $receiptid,
                $receipt[data][guestid],
                MetabaseGetTextFieldValue($gDatabase, $strreferenceid),
                MetabaseGetTextFieldValue($gDatabase, $receipt[data][address]),
                MetabaseGetTextFieldValue($gDatabase, $strreceiptdate),
                $receipt[data][price_netto_total],
                $receipt[data][price_total],
                $request->GetVar('uid', 'session')
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Receipt::save()', $query);
            } else {
                for ($i = 0; $i < count($bookids); $i++) {
                    // delete drafts
                    if ($this->getDraftReceiptId($bookids[$i], $receipt[data][guestid]) !== -1) {
                        $this->deletedraft($this->getDraftReceiptId($bookids[$i], $receipt[data][guestid]), false);
                    } 
                    $query = sprintf("INSERT INTO $tbl_receipt_booking
								  (pk_fk_receipt_id, pk_fk_booking_id, start_date, end_date)
								  VALUES (%s, %s, %s, %s)",
                        $receiptid,
                        $bookids[$i],
                        MetabaseGetTextFieldValue($gDatabase, $strstart[$i]),
                        MetabaseGetTextFieldValue($gDatabase, $strend[$i])
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Receipt::save()', $query);
                    } 
                } 

                $sum = $receipt[data][price_total];
                for ($k = 0; $k <= count($commissionids); ++$k) {
                    if ($commissionids[$k] != "") {
                        $query = sprintf("SELECT amount FROM $tbl_account
									  WHERE pk_account_id = %s",
                            $commissionids[$k]
                            );
                        $result = MetabaseQuery($gDatabase, $query);
                        if (!$result) {
                            $success = MetabaseRollbackTransaction($gDatabase);
                            $errorhandler->display('SQL', 'Receipt::save()', $query);
                        } elseif (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                            $sum += MetabaseFetchResult($gDatabase, $result, 0, 0) * -1;
                        } 
                        $query = sprintf("UPDATE $tbl_account
						          SET allocated = %s,
						   		  fk_receipt_id = %s,
								  on_receipt = %s,
						  		  updated_date = NOW(),
						  		  fk_updated_user_id = %s
								  WHERE pk_account_id = %s",
                            MetabaseGetBooleanFieldValue($gDatabase, true),
                            $receiptid,
                            MetabaseGetBooleanFieldValue($gDatabase, true),
                            $request->GetVar('uid', 'session'),
                            $commissionids[$k]
                            );
                        $result = MetabaseQuery($gDatabase, $query);
                        if (!$result) {
                            $success = MetabaseRollbackTransaction($gDatabase);
                            $errorhandler->display('SQL', 'Receipt::save()', $query);
                        } 
                    } 
                } 

                for ($i = 0; $i < count($receipt[items]); ++$i) {
                    $name = "zvs_pk_receipt_item_id";
                    $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$receiptitemid);
                    $query = sprintf("INSERT INTO $tbl_receipt_item
							 (pk_receipt_item_id, fk_receipt_id, article, amount,
							 price_netto, price_brutto, mwst,  
							 inserted_date, fk_inserted_user_id)
							 VALUES (%s, %s, %s, %s, %s, %s, %s, NOW(), %s )",
                        $receiptitemid,
                        $receiptid,
                        MetabaseGetTextFieldValue($gDatabase, $receipt[items][$i][article]),
                        $receipt[items][$i][number],
                        $receipt[items][$i][netto_single],
                        $receipt[items][$i][brutto_single],
                        $receipt[items][$i][mwst],
                        $request->GetVar('uid', 'session')
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Receipt::save()', $query);
                    } 
                } 
            } 
        } 
        $success = MetabaseCommitTransaction($gDatabase); 
        // end transaction
        $auto_commit = true;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        for ($i = 0; $i < count($bookids); $i++) {
            $accountcls->setStatus($receiptid, $bookids[$i]);
        } 
        return $receiptid;
    } 

    /**
    * price::getComplete()
    * 
    * get complete receipt data
    * 
    * @access public 
    * @param  $receiptid receipt id
    * @return array receipt
    * @since 2004-02-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getComplete($receiptid)
    {
        global $gDatabase, $tbl_receipt, $tbl_booking, $tbl_receipt_booking, $tbl_receipt_item, $errorhandler;
        $receipt = array();
        $receipt[data] = array();
        $receipt[items] = array();

        $query = "SELECT rb.pk_fk_booking_id, r.receipt_reference_id, r.address, 
				  DATE_FORMAT(r.receipt_date, '%d.%m.%Y'), DATE_FORMAT(rb.start_date, '%d.%m.%Y'), 
				  DATE_FORMAT(rb.end_date, '%d.%m.%Y'), r.fk_guest_id
				  FROM $tbl_receipt r
				  LEFT JOIN $tbl_receipt_booking rb ON r.pk_receipt_id = rb.pk_fk_receipt_id
				  LEFT JOIN $tbl_booking b ON rb.pk_fk_booking_id = b.pk_booking_id
				  WHERE r.pk_receipt_id = $receiptid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getComplete()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $bookids[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                $start[$row] = MetabaseFetchResult($gDatabase, $result, $row, 4);
                $end[$row] = MetabaseFetchResult($gDatabase, $result, $row, 5);
            } 
            $receipt[data] = array ('bookid' => $bookids,
                'referenceid' => MetabaseFetchResult($gDatabase, $result, 0, 1),
                'address' => MetabaseFetchResult($gDatabase, $result, 0, 2),
                'receipt_date' => MetabaseFetchResult($gDatabase, $result, 0, 3),
                'start_date' => $start,
                'end_date' => $end,
                'guestid' => MetabaseFetchResult($gDatabase, $result, 0, 6),
                'receiptid' => $receiptid,
                'draftreceiptid' => -1
                );

            $query = "SELECT article, amount, price_netto, price_brutto, 
					  mwst, amount * price_netto as total_netto, 
					  amount * price_brutto as total_brutto, pk_receipt_item_id 
					  FROM $tbl_receipt_item
					  WHERE fk_receipt_id = $receiptid 
					  AND ISNULL(fk_deleted_user_id) ";

            $result = MetabaseQuery($gDatabase, $query);
            $color = 1;
            if (!$result) {
                $errorhandler->display('SQL', 'Receipt::getComplete()', $query);
            } else {
                $row = 0;
                $sumnetto = 0.00;
                $sumbrutto = 0.00;
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    if ($color == 1) {
                        $color = 0;
                    } else {
                        $color = 1;
                    } 
                    $sumnetto += MetabaseFetchResult($gDatabase, $result, $row, 5);
                    $sumbrutto += MetabaseFetchResult($gDatabase, $result, $row, 6);
                    $receipt[items][$row] = array ('article' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        'number' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'netto_single' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 2), 2, '.', ''),
                        'brutto_single' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 3), 2, '.', ''),
                        'mwst' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                        'netto' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 5), 2, '.', ''),
                        'brutto' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 6), 2, '.', ''),
                        'color' => $color,
                        'id' => $row,
                        'itemid' => MetabaseFetchResult($gDatabase, $result, $row, 7)
                        );
                } 
                $receipt[data][price_netto_total] = number_format($sumnetto, 2, '.', '');
                $receipt[data][price_total] = number_format($sumbrutto, 2, '.', '');
            } 
            return $receipt;
        } 
    } 

    /**
    * price::getCompleteDraft()
    * 
    * get complete draft receipt data
    * 
    * @access public 
    * @param  $draftreceiptid receipt id
    * @param  $guestid guest id
    * @return array receipt
    * @since 2004-04-18
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getCompleteDraft($draftreceiptid, $guestid)
    {
        global $gDatabase, $tbl_draftreceipt, $tbl_booking, $tbl_draftreceipt_booking, $tbl_draftreceipt_item, $errorhandler;
        $receipt = array();
        $receipt[data] = array();
        $receipt[items] = array();

        $query = "SELECT rb.pk_fk_booking_id, '0000-0000000000' AS referenceid, r.address, 
				  DATE_FORMAT(r.receipt_date, '%d.%m.%Y'), DATE_FORMAT(rb.start_date, '%d.%m.%Y'), 
				  DATE_FORMAT(rb.end_date, '%d.%m.%Y'), r.fk_guest_id
				  FROM $tbl_draftreceipt r
				  LEFT JOIN $tbl_draftreceipt_booking rb ON r.pk_draftreceipt_id = rb.pk_fk_draftreceipt_id
				  LEFT JOIN $tbl_booking b ON rb.pk_fk_booking_id = b.pk_booking_id
				  WHERE r.pk_draftreceipt_id = $draftreceiptid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getCompleteDraft()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $bookids[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                $start[$row] = MetabaseFetchResult($gDatabase, $result, $row, 4);
                $end[$row] = MetabaseFetchResult($gDatabase, $result, $row, 5);
            } 
            if ($guestid == -1) {
                $guestid = MetabaseFetchResult($gDatabase, $result, 0, 6);
            } 
            $receipt[data] = array ('bookid' => $bookids,
                'referenceid' => MetabaseFetchResult($gDatabase, $result, 0, 1),
                'address' => MetabaseFetchResult($gDatabase, $result, 0, 2),
                'receipt_date' => MetabaseFetchResult($gDatabase, $result, 0, 3),
                'start_date' => $start,
                'end_date' => $end,
                'guestid' => $guestid,
                'receiptid' => -1,
                'draftreceiptid' => $draftreceiptid
                );

            $query = "SELECT article, amount, price_netto, price_brutto, 
					  mwst, amount * price_netto as total_netto, 
					  amount * price_brutto as total_brutto, pk_draftreceipt_item_id 
					  FROM $tbl_draftreceipt_item
					  WHERE fk_draftreceipt_id = $draftreceiptid 
					  AND ISNULL(fk_deleted_user_id) ";

            $result = MetabaseQuery($gDatabase, $query);
            $color = 1;
            if (!$result) {
                $errorhandler->display('SQL', 'Receipt::getCompleteDraft()', $query);
            } else {
                $row = 0;
                $sumnetto = 0.00;
                $sumbrutto = 0.00;
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    if ($color == 1) {
                        $color = 0;
                    } else {
                        $color = 1;
                    } 
                    $sumnetto += MetabaseFetchResult($gDatabase, $result, $row, 5);
                    $sumbrutto += MetabaseFetchResult($gDatabase, $result, $row, 6);
                    $receipt[items][$row] = array ('article' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        'number' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'netto_single' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 2), 2, '.', ''),
                        'brutto_single' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 3), 2, '.', ''),
                        'mwst' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                        'netto' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 5), 2, '.', ''),
                        'brutto' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 6), 2, '.', ''),
                        'color' => $color,
                        'id' => $row,
                        'itemid' => MetabaseFetchResult($gDatabase, $result, $row, 7)
                        );
                } 
                $receipt[data][price_netto_total] = number_format($sumnetto, 2, '.', '');
                $receipt[data][price_total] = number_format($sumbrutto, 2, '.', '');
            } 
            return $receipt;
        } 
    } 

    /**
    * price::getReceiptId()
    * 
    * get receipt Id for a booking
    * 
    * @access public 
    * @param  $bookingid booking id
    * @param  $guestid guest id
    * @return array receipt
    * @since 2004-03-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getReceiptId($bookingid, $guestid)
    {
        global $gDatabase, $tbl_receipt_booking, $tbl_receipt, $errorhandler;
        $receiptid = -1;
        $query = "SELECT pk_fk_receipt_id 
		          FROM $tbl_receipt_booking, $tbl_receipt 
				  WHERE pk_fk_booking_id = $bookingid
				  AND pk_fk_receipt_id = pk_receipt_id ";
        if ($guestid <> -1) {
            $query .= "AND fk_guest_id  = $guestid";
        } 
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getReceiptId()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) == 1) {
                $receiptid = MetabaseFetchResult($gDatabase, $result, 0, 0);
            } elseif (MetabaseNumberOfRows($gDatabase, $result) > 1) {
                $row = 0;
                $receiptid = array();
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $receiptid[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                } 
            } 
        } 
        return $receiptid;
    } 

    /**
    * price::getReceiptIds()
    * 
    * get receipt Id for a booking
    * 
    * @access public 
    * @param  $bookingid booking id
    * @return array receipt
    * @since 2004-03-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getReceiptIds($bookingid)
    {
        global $gDatabase, $tbl_receipt_booking, $errorhandler;
        $receiptid = -1;
        $query = "SELECT pk_fk_receipt_id 
		          FROM $tbl_receipt_booking
				  WHERE pk_fk_booking_id = $bookingid";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getReceiptIds()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) == 1) {
                $receiptid = MetabaseFetchResult($gDatabase, $result, 0, 0);
            } elseif (MetabaseNumberOfRows($gDatabase, $result) > 1) {
                $row = 0;
                $receiptid = array();
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $receiptid[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                } 
            } 
        } 
        return $receiptid;
    } 

    /**
    * price::getDraftReceiptId()
    * 
    * get draft receipt Id for a booking
    * 
    * @access public 
    * @param  $bookingid booking id
    * @param  $guestid guest id
    * @return $draftreceiptid draft receiptid
    * @since 2004-03-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getDraftReceiptId($bookingid, $guestid)
    {
        global $gDatabase, $tbl_draftreceipt_booking, $tbl_draftreceipt, $errorhandler;
        $draftreceiptid = -1;
        $query = "SELECT pk_fk_draftreceipt_id 
		          FROM $tbl_draftreceipt_booking, $tbl_draftreceipt 
				  WHERE pk_fk_booking_id = $bookingid
				  AND pk_fk_draftreceipt_id = pk_draftreceipt_id ";
        if ($guestid <> -1) {
            $query .= "AND fk_guest_id  = $guestid";
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getDraftReceiptId()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                $draftreceiptid = MetabaseFetchResult($gDatabase, $result, 0, 0);
            } 
        } 
        return $draftreceiptid;
    } 

    /**
    * price::getDraftReceiptId()
    * 
    * get draft receipt Id for a booking
    * 
    * @access public 
    * @param  $bookingid booking id
    * @return $draftreceiptid draft receiptid
    * @since 2004-03-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getDraftReceiptIds($bookingid)
    {
        global $gDatabase, $tbl_draftreceipt_booking, $tbl_draftreceipt, $errorhandler;
        $draftreceiptid = -1;
        $query = "SELECT pk_fk_draftreceipt_id
		          FROM $tbl_draftreceipt_booking
				  WHERE pk_fk_booking_id = $bookingid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getDraftReceiptIds()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) == 1) {
                $draftreceiptid = MetabaseFetchResult($gDatabase, $result, 0, 0);
            } elseif (MetabaseNumberOfRows($gDatabase, $result) > 1) {
                $row = 0;
                $draftreceiptid = array();
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $draftreceiptid[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                } 
            } 
        } 

        return $draftreceiptid;
    } 

    /**
    * receipt::getGuestId()
    * 
    * get guest Id for a booking
    * 
    * @access public 
    * @param  $bookingid booking id
    * @return array receipt
    * @since 2004-03-02
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getGuestId($bookingid)
    {
        global $gDatabase, $tbl_booking, $errorhandler;
        $guestid = -1;
        $query = "SELECT fk_guest_id FROM $tbl_booking WHERE pk_booking_id = $bookingid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getGuestId()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                $guestid = MetabaseFetchResult($gDatabase, $result, 0, 0);
            } 
        } 
        return $guestid;
    } 
    /**
    * price::delitem()
    * 
    * delete an item
    * 
    * @access public 
    * @param number $id id from item to delete
    * @param number $bookingid booking id
    * @param number $length_short_stay length of short stay
    * @param number $guestid guest id
    * @return array receipt
    * @since 2004-03-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function delitem($id, $bookingid, $length_short_stay, $guestid)
    {
        $receiptdata = $this->recalculate($bookingid, $length_short_stay, $guestid);
        $tmparr = $receiptdata[items];
        $arrsize = count($tmparr);

        $receiptdata[items] = '';
        $k = 0;
        $nextcolor = 1;
        for ($m = 0; $m < $arrsize; $m++) {
            if ($m !== $id) {
                if ($nextcolor == "0") {
                    $nextcolor = "1";
                } else {
                    $nextcolor = "0";
                } 
                $tmparr[$m][color] = $nextcolor;
                $tmparr[$m][id] = $k;
                $receiptdata[items][$k] = $tmparr[$m];
                ++$k;
            } 
        } 
        for ($i = 0; $i < count($receiptdata[items]); $i++) {
            $price_netto_total += $receiptdata[items][$i][netto];
            $price_total += $receiptdata[items][$i][brutto];
        } 
        $receiptdata[data][price_netto_total] = number_format($price_netto_total, 2, '.', '');
        $receiptdata[data][price_total] = number_format($price_total, 2, '.', '');
        return $receiptdata;
    } 

    /**
    * price::additem()
    * 
    * add an item after another one
    * 
    * @access public 
    * @param number $id id from item after new one should be inserted
    * @param number $bookingid booking id
    * @param number $length_short_stay length of short stay
    * @param number $articleid article id
    * @param number $guestid guest id
    * @return array receipt
    * @since 2004-03-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function additem($id, $bookingid, $length_short_stay, $articleid, $guestid)
    {
        global $article;
        $receiptdata = $this->recalculate($bookingid, $length_short_stay, $guestid);
        $tmparr = $receiptdata[items];
        $arrsize = count($tmparr);

        $receiptdata[items] = '';
        $k = 0;
        $nextcolor = "1";
        for ($m = 0; $m < $arrsize; $m++) {
            if ($nextcolor == "0") {
                $nextcolor = "1";
            } else {
                $nextcolor = "0";
            } 
            $tmparr[$m][id] = $k;
            $tmparr[$m][color] = $nextcolor;
            $receiptdata[items][$k] = $tmparr[$m];
            ++$k;
            if ($tmparr[$m][id] == $id) {
                if ($nextcolor == "0") {
                    $nextcolor = "1";
                } else {
                    $nextcolor = "0";
                } 
                if ($articleid !== "-1") {
                    $articledata = $article->getone($articleid);
                    $tmparr2[color] = $nextcolor;
                    $tmparr2[id] = $k;
                    $tmparr2[itemid] = -1;
                    $tmparr2[article] = $articledata[article];
                    $tmparr2[number] = "1";
                    $tmparr2[netto_single] = $articledata[price_netto];
                    $tmparr2[mwst] = $articledata[mwst];
                    $tmparr2[brutto_single] = $articledata[price_brutto];
                    $tmparr2[netto] = $articledata[price_netto];
                    $tmparr2[brutto] = $articledata[price_brutto];
                } else {
                    $tmparr2[color] = $nextcolor;
                    $tmparr2[id] = $k;
                    $tmparr2[itemid] = -1;
                    $tmparr2[article] = "";
                    $tmparr2[number] = "1";
                    $tmparr2[netto_single] = "0.00";
                    $tmparr2[mwst] = "0";
                    $tmparr2[brutto_single] = "0.00";
                    $tmparr2[netto] = "0.00";
                    $tmparr2[brutto] = "0.00";
                } 
                $receiptdata[items][$k] = $tmparr2;
                ++$k;
            } 
        } 
        for ($i = 0; $i < count($receiptdata[items]); $i++) {
            $price_netto_total += $receiptdata[items][$i][netto];
            $price_total += $receiptdata[items][$i][brutto];
        } 
        $receiptdata[data][price_netto_total] = number_format($price_netto_total, 2, '.', '');
        $receiptdata[data][price_total] = number_format($price_total, 2, '.', '');
        return $receiptdata;
    } 

    /**
    * price::getCommission()
    * 
    * add an item after another one
    * 
    * @access public 
    * @param  $bookid book id
    * @param  $color color
    * @param  $sum sum of receipt
    * @param  $guestid guest id
    * @return array commission
    * @since 2004-03-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getCommission($bookid, $color, $sum, $guestid)
    {
        global $errorhandler, $tbl_account, $tbl_booking, $tbl_paycat, $gDatabase;
        $query = "SELECT a.pk_account_id, a.description, a.amount,
				  DATE_FORMAT(a.date_payment, '%d.%m.%Y'), p.paycat 
					  FROM $tbl_account a, $tbl_booking b
					  LEFT JOIN $tbl_paycat p ON a.fk_paycat_id = p.pk_paycat_id
					  WHERE 
					  b.pk_booking_id = $bookid
					  AND a.fk_booking_id = $bookid 
					  AND a.fk_guest_id = $guestid
					  AND a.on_receipt = " . MetabaseGetBooleanFieldValue($gDatabase, false);
        $result2 = MetabaseQuery($gDatabase, $query);
        if (!$result2) {
            $errorhandler->display('SQL', 'Receipt::getCommision()', $query);
        } else {
            $commission = array();
            if (MetabaseNumberOfRows($gDatabase, $result2) > 0) {
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result2)) == 0; ++$row) {
                    $description = MetabaseFetchResult($gDatabase, $result2, $row, 3) . " " . MetabaseFetchResult($gDatabase, $result2, $row, 4);
                    if (MetabaseFetchResult($gDatabase, $result2, $row, 1) != "") {
                        $description .= "\n" . MetabaseFetchResult($gDatabase, $result2, $row, 1);
                    } 
                    $commission[$row] = array('color' => $color,
                        'description' => $description,
                        'amount' => number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2) * -1, 2, '.', ''),
                        'accountid' => MetabaseFetchResult($gDatabase, $result2, $row, 0)
                        );
                    $sum += (MetabaseFetchResult($gDatabase, $result2, $row, 2) * -1);
                    if ($color == 0) {
                        $color = 1;
                    } else {
                        $color = 0;
                    } 
                } 
                $commission[$row] = array('color' => $color,
                    'description' => '',
                    'amount' => number_format($sum, 2, '.', ''),
                    'accountid' => ''
                    );
            } 
            return $commission;
        } 
    } 

    /**
    * price::getCommissionForReceipt()
    * 
    * get Commission data for an existing Receipt
    * 
    * @access public 
    * @param  $receiptid book id
    * @param  $color color
    * @param  $sum sum of receipt
    * @param  $on_receipt on receipt
    * @return array commission
    * @since 2004-03-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getCommissionForReceipt($receiptid, $color, $sum, $on_receipt)
    {
        global $errorhandler, $tbl_account, $tbl_paycat, $tbl_booking, $gDatabase;
        $query = "SELECT a.pk_account_id, a.description, a.amount,
		 		  DATE_FORMAT(a.date_payment, '%d.%m.%Y'), p.paycat 
					  FROM $tbl_account a
					  LEFT JOIN $tbl_paycat p ON a.fk_paycat_id = p.pk_paycat_id
					  WHERE a.fk_receipt_id = $receiptid
					  AND allocated = " . MetabaseGetBooleanFieldValue($gDatabase, true) . "
					  AND on_receipt = " . MetabaseGetBooleanFieldValue($gDatabase, $on_receipt);
        $result2 = MetabaseQuery($gDatabase, $query);
        if (!$result2) {
            $errorhandler->display('SQL', 'Receipt::getCommissionForReceipt()', $query);
        } else {
            $commission = array();
            if (MetabaseNumberOfRows($gDatabase, $result2) > 0) {
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result2)) == 0; ++$row) {
                    $description = MetabaseFetchResult($gDatabase, $result2, $row, 3) . " " . MetabaseFetchResult($gDatabase, $result2, $row, 4);
                    if (MetabaseFetchResult($gDatabase, $result2, $row, 1) != "") {
                        $description .= "\n" . MetabaseFetchResult($gDatabase, $result2, $row, 1);
                    } 
                    $commission[$row] = array('color' => $color,
                        'description' => $description,
                        'amount' => number_format(MetabaseFetchResult($gDatabase, $result2, $row, 2) * -1, 2, '.', ''),
                        'accountid' => MetabaseFetchResult($gDatabase, $result2, $row, 0)
                        );
                    $sum += (MetabaseFetchResult($gDatabase, $result2, $row, 2) * -1);
                    if ($color == 0) {
                        $color = 1;
                    } else {
                        $color = 0;
                    } 
                } 
                $commission[$row] = array('color' => $color,
                    'description' => '',
                    'amount' => number_format($sum, 2, '.', ''),
                    'accountid' => ''
                    );
            } 
            return $commission;
        } 
    } 

    /**
    * Receipt::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2004-03-25
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getdates()
    {
        global $gDatabase, $tbl_receipt, $request, $errorhandler;

        $dates = array();
        $j = 0;
        $query = "SELECT DATE_FORMAT(min( receipt_date  ) ,'%Y'),  DATE_FORMAT(max( receipt_date  ),'%Y')  
		                 FROM $tbl_receipt  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getdates()', $query);
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
    * Receipt::getlist()
    * 
    * This function returns all receipts.
    * 
    * @param date $thestart start date
    * @param date $theend end date
    * @param string $display display
    * @return array receipts
    * @access public 
    * @since 2004-01-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getlist($thestart, $theend, $display)
    {
        global $gDatabase, $tbl_receipt, $tbl_booking, $tbl_receipt_booking, $tbl_guest, $request, $errorhandler;
        include_once('accountclass.inc.php');
        $account = New Account;

        $receipt = array();
        $query = "SELECT pk_receipt_id, receipt_reference_id, DATE_FORMAT(receipt_date, '%d.%m.%Y' ),
						 pk_fk_booking_id, sum_brutto, g.firstname, g.lastname, r.fk_guest_id
		                 FROM $tbl_receipt r
						 LEFT JOIN $tbl_receipt_booking rb ON r.pk_receipt_id = rb.pk_fk_receipt_id
						 LEFT JOIN $tbl_booking b ON rb.pk_fk_booking_id = b.pk_booking_id
						 LEFT JOIN $tbl_guest g ON r.fk_guest_id = g.pk_guest_id
						 WHERE receipt_date >= '$thestart'
						 AND receipt_date <= '$theend'
						 GROUP BY pk_receipt_id
						 ORDER BY receipt_date DESC";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getlist()', $query);
        } else {
            $row = 0;
            $i = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $receiptsum = $account->getReceiptSum(MetabaseFetchResult($gDatabase, $result, $row, 0));
                $sum = MetabaseFetchResult($gDatabase, $result, $row, 4);
                if ($display == 'all' || ($display == 'open' && $receiptsum['sum'] <> 0) || ($display == 'payed' && $receiptsum['sum'] == 0) || ($display == 'commission' && $receiptsum['type'] == 'yellow')) {
                    $receipt[$i] = array ('receiptid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        'receipt_reference' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'receipt_date' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                        'bookid' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                        'receipt_sum' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 4), 2, '.', ''),
                        'color' => $color,
                        'type' => $receiptsum['type'],
                        'paid' => number_format($receiptsum['payed'], 2, '.', ''),
                        'diff' => number_format($receiptsum['sum'], 2, '.', ''),
                        'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                        'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                        'guestid' => MetabaseFetchResult($gDatabase, $result, $row, 7)
                        );
                    $i++;
                } 
            } 
        } 
        return $receipt;
    } 
    /**
    * Receipt::getOpenBookings()
    * 
    * This function returns all bookings form a guest without a receipt.
    * 
    * @param int $guestid guest id
    * @param array $bookingids booking id of booking which should not be returned
    * @return array bookings
    * @access public 
    * @since 2004-03-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getOpenBookings($guestid, $bookingids)
    {
        global $gDatabase, $tbl_receipt, $tbl_receipt_booking, $tbl_booking_detail_guest, $tbl_booking, $tbl_booking_detail, $tbl_room, $request, $errorhandler;
        $query = "SELECT b.pk_booking_id, DATE_FORMAT(b.start_date, '%d.%m.%Y'), 
			      DATE_FORMAT(b.end_date, '%d.%m.%Y'), ro.room
				  FROM $tbl_booking_detail_guest bdg
				  LEFT JOIN $tbl_booking_detail bd ON bd.pk_booking_detail_id = bdg.pk_fk_booking_detail_id
				  LEFT JOIN $tbl_booking b ON bd.fk_booking_id = b.pk_booking_id AND ISNULL(b.deleted_date)
				  LEFT JOIN $tbl_room ro ON bd.fk_room_id = ro.pk_room_id
				  LEFT JOIN $tbl_receipt_booking rb ON b.pk_booking_id = rb.pk_fk_booking_id
				  LEFT JOIN $tbl_receipt r ON rb.pk_fk_receipt_id = r.pk_receipt_id
				  WHERE rb.pk_fk_booking_id IS  NULL 
				  AND b.pk_booking_id IS NOT NULL
				  AND bdg.pk_fk_guest_id = $guestid
				  ORDER BY b.start_date ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getOpenBookings()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (in_array(MetabaseFetchResult($gDatabase, $result, $row, 0), $bookingids)) {
                    $selected = 'checked = "checked"';
                    $disabled = 'disabled="disabled"';
                } else {
                    $selected = '';
                    $disabled = '';
                } 
                $bookings[$row] = array ('bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'start' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'end' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'room' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'color' => $color,
                    'selected' => $selected,
                    'disabled' => $disabled
                    );
            } 
            return $bookings;
        } 
    } 
    /**
    * Receipt::getItemslist()
    * 
    * This function returns all receipts.
    * 
    * @param date $thestart start date
    * @param date $theend end date
	* @param int $mwst Mwst
    * @return array receiptitmes
    * @access public 
    * @since 2004-04-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getitemslist($thestart, $theend, $mwst)
    {
        global $gDatabase, $tbl_receipt_item, $tbl_receipt, $tbl_booking, $tbl_receipt_booking, $tbl_guest, $request, $errorhandler;

        $receipt = array();
        $query = "SELECT DISTINCT(pk_receipt_item_id), ri.article, ri.amount, ri.price_netto, ri.price_brutto, ri.mwst, 
				  r.receipt_reference_id, r.address, DATE_FORMAT(r.receipt_date, '%d.%m.%Y' ),
				  g.firstname, g.lastname 
				  FROM $tbl_receipt_item ri
				  LEFT JOIN $tbl_receipt r ON ri.fk_receipt_id = r.pk_receipt_id
						 LEFT JOIN $tbl_receipt_booking rb ON r.pk_receipt_id = rb.pk_fk_receipt_id
						 LEFT JOIN $tbl_booking b ON rb.pk_fk_booking_id = b.pk_booking_id
						 LEFT JOIN $tbl_guest g ON r.fk_guest_id = g.pk_guest_id
						 WHERE r.receipt_date >= '$thestart'
						 AND r.receipt_date <= '$theend' 
						 AND ISNULL(ri.deleted_date) ";
						 
		if ($mwst !== -1 && $mwst !== "-1") {
		    $query .= "AND ri.mwst = $mwst ";
		}				 			
		$query .= "ORDER BY r.pk_receipt_id, ri.mwst";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getitemslist()', $query);
        } else {
            $row = 0;
            $nettosum = 0.00;
            $bruttosum = 0.00;
            $nettototal = 0.00;
            $bruttototal = 0.00;

            $totalrows = MetabaseNumberOfRows($gDatabase, $result);
            for ($row = 0; $row < $totalrows; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $nextrow = $row + 1;
                $nettosum += MetabaseFetchResult($gDatabase, $result, $row, 3) * MetabaseFetchResult($gDatabase, $result, $row, 2);
                $bruttosum += MetabaseFetchResult($gDatabase, $result, $row, 4) * MetabaseFetchResult($gDatabase, $result, $row, 2);
                $nettototal += MetabaseFetchResult($gDatabase, $result, $row, 3) * MetabaseFetchResult($gDatabase, $result, $row, 2);
                $bruttototal += MetabaseFetchResult($gDatabase, $result, $row, 4) * MetabaseFetchResult($gDatabase, $result, $row, 2);
                if ($row == $totalrows-1) {
                    $strnettosum = number_format($nettosum, 2, '.', '');
                    $nettosum = 0.00;
                    $strbruttosum = number_format($bruttosum, 2, '.', '');
                    $bruttosum = 0.00;
                } elseif ((MetabaseFetchResult($gDatabase, $result, $row, 5) == MetabaseFetchResult($gDatabase, $result, $nextrow, 5)) && (MetabaseFetchResult($gDatabase, $result, $row, 6) == MetabaseFetchResult($gDatabase, $result, $nextrow, 6))) {
                    $strnettosum = '';
                    $strbruttosum = '';
                } else {
                    $strnettosum = number_format($nettosum, 2, '.', '');
                    $nettosum = 0.00;
                    $strbruttosum = number_format($bruttosum, 2, '.', '');
                    $bruttosum = 0.00;
                } 

                $receipt[$row] = array ('article' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'amount' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'price_netto' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 3), 2, '.', ''),
                    'sum_netto' => number_format((MetabaseFetchResult($gDatabase, $result, $row, 3) * MetabaseFetchResult($gDatabase, $result, $row, 2)), 2, '.', ''),
                    'price_brutto' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 4), 2, '.', ''),
                    'sum_brutto' => number_format((MetabaseFetchResult($gDatabase, $result, $row, 4) * MetabaseFetchResult($gDatabase, $result, $row, 2)), 2, '.', ''),
                    'mwst' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'receipt_reference_id' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'address' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'receipt_date' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                    'color' => $color,
                    'netto_sum' => $strnettosum,
                    'brutto_sum' => $strbruttosum
                    );
            } 

            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 

            $receipt[$row] = array ('article' => '',
                'amount' => '',
                'price_netto' => '',
                'sum_netto' => '',
                'price_brutto' => '',
                'sum_brutto' => '',
                'mwst' => '',
                'receipt_reference_id' => '',
                'address' => '',
                'receipt_date' => '',
                'firstname' => '',
                'lastname' => '',
                'color' => $color,
                'netto_sum' => number_format($nettototal, 2, '.', ''),
                'brutto_sum' => number_format($bruttototal, 2, '.', '')
                );
        } 
        return $receipt;
    } 

    /**
    * price::savedraft()
    * 
    * save draft receipt
    * 
    * @return $draftreceiptid draft receipt id
    * @access public 
    * @since 2004-04-18
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function savedraft()
    {
        global $gDatabase, $tbl_draftreceipt, $tbl_draftreceipt_booking, $tbl_draftreceipt_item, $tbl_account, $errorhandler, $request;
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        $receipt = array();
        $doneitems = array();
        $commissionids = array();
        $commissionids = $request->GetVar('frm_commissionid', 'post');
        $receipt = $this->recalculate($request->GetVar('frm_bookid', 'post'), $request->GetVar('length_short_stay', 'session'), $request->GetVar('frm_guestid', 'post'));
        $receiptdate = explode(".", $receipt[data][receipt_date]);
        $strreceiptdate = $receiptdate[2] . "-" . $receiptdate[1] . "-" . $receiptdate[0];

        if ($request->GetVar('frm_bookids', 'post') !== $request->undefined) {
            $bookids = $request->GetVar('frm_bookids', 'post');
        } else {
            $bookids = array($request->GetVar('frm_bookid', 'post'));
        } 

        for ($i = 0; $i < count($receipt[data][start_date]); $i++) {
            $start = explode(".", $receipt[data][start_date][$i]);
            $strstart[$i] = $start[2] . "-" . $start[1] . "-" . $start[0];
            $end = explode(".", $receipt[data][end_date][$i]);
            $strend[$i] = $end[2] . "-" . $end[1] . "-" . $end[0];
        } 

        if ($receipt[data][draftreceiptid] <> -1 && $receipt[data][draftreceiptid] <> "") {
            $draftreceiptid = $receipt[data][draftreceiptid];
            $query = sprintf("UPDATE $tbl_draftreceipt SET
							  fk_guest_id = %s,
							  address = %s,
						 	  receipt_date = %s, 
							  sum_netto = %s, 
							  sum_brutto = %s, 
						 	  updated_date = NOW(), 
							  fk_updated_user_id = %s
							  WHERE pk_draftreceipt_id = %s",
                $receipt[data][guestid],
                MetabaseGetTextFieldValue($gDatabase, $receipt[data][address]),
                MetabaseGetTextFieldValue($gDatabase, $strreceiptdate),
                $receipt[data][price_netto_total],
                $receipt[data][price_total],
                $request->GetVar('uid', 'session'),
                $draftreceiptid
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
            } else {
                for ($i = 0; $i < count($bookids); $i++) {
                    $query = sprintf("UPDATE $tbl_draftreceipt_booking
								  SET start_date = %s, end_date = %s
								  WHERE pk_fk_draftreceipt_id = %s AND pk_fk_booking_id = %s",
                        MetabaseGetTextFieldValue($gDatabase, $strstart[$i]),
                        MetabaseGetTextFieldValue($gDatabase, $strend[$i]),
                        $draftreceiptid,
                        $bookids[$i]
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                    } 
                } 
                // get all items which are in the system
                $query = "SELECT pk_draftreceipt_item_id FROM $tbl_draftreceipt_item WHERE fk_draftreceipt_id = " . $receipt[data][draftreceiptid];
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                } else {
                    $olditems = array();
                    for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                        $olditems[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
                    } 
                    for ($i = 0; $i < count($receipt[items]); ++$i) {
                        // is a new one
                        if ($receipt[items][$i][itemid] == -1 || !in_array($receipt[items][$i][itemid], $olditems)) {
                            $name = "zvs_pk_draftreceipt_item_id";
                            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$draftreceiptitemid);
                            $query = sprintf("INSERT INTO $tbl_draftreceipt_item
							 (pk_draftreceipt_item_id, fk_draftreceipt_id, article, amount,
							 price_netto, price_brutto, mwst,  
							 inserted_date, fk_inserted_user_id)
							 VALUES (%s, %s, %s, %s, %s, %s, %s, NOW(), %s )",
                                $draftreceiptitemid,
                                $draftreceiptid,
                                MetabaseGetTextFieldValue($gDatabase, $receipt[items][$i][article]),
                                $receipt[items][$i][number],
                                $receipt[items][$i][netto_single],
                                $receipt[items][$i][brutto_single],
                                $receipt[items][$i][mwst],
                                $request->GetVar('uid', 'session')
                                );
                            $result = MetabaseQuery($gDatabase, $query);
                            if (!$result) {
                                $success = MetabaseRollbackTransaction($gDatabase);
                                $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                            } 
                        } else {
                            array_push($doneitems, $receipt[items][$i][itemid]);
                            $query = sprintf("UPDATE $tbl_draftreceipt_item SET
									  article = %s, 
									  amount = %s,
							 		  price_netto = %s, 
									  price_brutto = %s, 
									  mwst = %s,  
							 		  updated_date = NOW(), 
									  fk_updated_user_id = %s
									  WHERE pk_draftreceipt_item_id = %s",
                                MetabaseGetTextFieldValue($gDatabase, $receipt[items][$i][article]),
                                $receipt[items][$i][number],
                                $receipt[items][$i][netto_single],
                                $receipt[items][$i][brutto_single],
                                $receipt[items][$i][mwst],
                                $request->GetVar('uid', 'session'),
                                $receipt[items][$i][itemid]
                                );
                            $result = MetabaseQuery($gDatabase, $query);
                            if (!$result) {
                                $success = MetabaseRollbackTransaction($gDatabase);
                                $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                            } 
                        } 
                    } 
                    // set deleted items delted
                    $deleteitems = array_values(array_diff($olditems, $doneitems));
                    for ($i = 0; $i < count($deleteitems); $i++) {
                        $query = sprintf("UPDATE $tbl_draftreceipt_item SET
										deleted_date = NOW(),
										fk_deleted_user_id = %s
										WHERE pk_draftreceipt_item_id = %s ",
                            $request->GetVar('uid', 'session'),
                            $deleteitems[$i]
                            );
                        $result = MetabaseQuery($gDatabase, $query);
                        if (!$result) {
                            $success = MetabaseRollbackTransaction($gDatabase);
                            $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                        } 
                    } 
                } 
            } 
        } else {
            $name = "zvs_pk_draftreceipt_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$draftreceiptid);
            $query = sprintf("INSERT INTO $tbl_draftreceipt
						 (pk_draftreceipt_id, fk_guest_id, address,
						 receipt_date,  sum_netto, sum_brutto, 
						 inserted_date, fk_inserted_user_id)
						 VALUES (%s, %s, %s, %s, %s, %s, NOW(), %s )",
                $draftreceiptid,
                $receipt[data][guestid],
                MetabaseGetTextFieldValue($gDatabase, $receipt[data][address]),
                MetabaseGetTextFieldValue($gDatabase, $strreceiptdate),
                $receipt[data][price_netto_total],
                $receipt[data][price_total],
                $request->GetVar('uid', 'session')
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
            } else {
                for ($i = 0; $i < count($bookids); $i++) {
                    $query = sprintf("INSERT INTO $tbl_draftreceipt_booking
								  (pk_fk_draftreceipt_id, pk_fk_booking_id, start_date, end_date)
								  VALUES (%s, %s, %s, %s)",
                        $draftreceiptid,
                        $bookids[$i],
                        MetabaseGetTextFieldValue($gDatabase, $strstart[$i]),
                        MetabaseGetTextFieldValue($gDatabase, $strend[$i])
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                    } 
                } 

                $sum = $receipt[data][price_total];
                for ($k = 0; $k <= count($commissionids); ++$k) {
                    if ($commissionids[$k] != "") {
                        $query = sprintf("SELECT amount FROM $tbl_account
									  WHERE pk_account_id = %s",
                            $commissionids[$k]
                            );
                        $result = MetabaseQuery($gDatabase, $query);
                        if (!$result) {
                            $success = MetabaseRollbackTransaction($gDatabase);
                            $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                        } elseif (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                            $sum += MetabaseFetchResult($gDatabase, $result, 0, 0) * -1;
                        } 
                    } 
                } 

                for ($i = 0; $i < count($receipt[items]); ++$i) {
                    $name = "zvs_pk_draftreceipt_item_id";
                    $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$draftreceiptitemid);
                    $query = sprintf("INSERT INTO $tbl_draftreceipt_item
							 (pk_draftreceipt_item_id, fk_draftreceipt_id, article, amount,
							 price_netto, price_brutto, mwst,  
							 inserted_date, fk_inserted_user_id)
							 VALUES (%s, %s, %s, %s, %s, %s, %s, NOW(), %s )",
                        $draftreceiptitemid,
                        $draftreceiptid,
                        MetabaseGetTextFieldValue($gDatabase, $receipt[items][$i][article]),
                        $receipt[items][$i][number],
                        $receipt[items][$i][netto_single],
                        $receipt[items][$i][brutto_single],
                        $receipt[items][$i][mwst],
                        $request->GetVar('uid', 'session')
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Receipt::savedraft()', $query);
                    } 
                } 
            } 
        } 
        $success = MetabaseCommitTransaction($gDatabase); 
        // end transaction
        $auto_commit = true;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        return $draftreceiptid;
    } 

    /**
    * price::deletedraft()
    * 
    * delete draft receipt
    * 
    * @param number $draftreceiptid draft receipt id
    * @param boolean $transc transaction control
    * @access public 
    * @since 2004-04-18
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function deletedraft($draftreceiptid, $transc)
    {
        global $gDatabase, $tbl_draftreceipt, $tbl_draftreceipt_booking, $tbl_draftreceipt_item, $errorhandler, $request;
        if ($transc) {
            $auto_commit = false;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
        $query = "DELETE FROM $tbl_draftreceipt_item WHERE fk_draftreceipt_id = " . $draftreceiptid ;
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Receipt::deletedraft()', $query);
        } 
        $query = "DELETE FROM $tbl_draftreceipt_booking WHERE pk_fk_draftreceipt_id = " . $draftreceiptid ;
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Receipt::deletedraft()', $query);
        } 
        $query = "DELETE FROM $tbl_draftreceipt WHERE pk_draftreceipt_id = " . $draftreceiptid ;
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Receipt::deletedraft()', $query);
        } else {
            if ($transc) {
                $success = MetabaseCommitTransaction($gDatabase); 
                // end transaction
                $auto_commit = true;
                $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
            } 
        } 
    } 

    /**
    * Receipt::getAdditionalGuestForBooking()
    * 
    * Get the data of additional guests for a booking
    * 
    * @param array $bookids id of booking
    * @param number $guestid id of guest not to include
    * @return array guest data
    * @access public 
    * @since 2004-04-21
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getAdditionalGuestForBooking($bookids, $guestid)
    {
        global $tbl_booking_detail_guest, $tbl_booking, $tbl_booking_detail, $tbl_guest, $gDatabase, $errorhandler;

        $where = " ";
        for ($i = 0; $i < count($bookids); $i++) {
            if ($i == 0) {
                $where .= "WHERE ";
            } else {
                $where .= "OR ";
            } 
            $where .= "pk_booking_id = " . $bookids[$i] . " ";
        } 
        $query = "SELECT DISTINCT g.pk_guest_id, g.firstname, g.lastname, b.fk_guest_id
						FROM $tbl_booking b
						LEFT JOIN $tbl_booking_detail bd ON bd.fk_booking_id = b.pk_booking_id
						LEFT JOIN $tbl_booking_detail_guest bdg ON bd.pk_booking_detail_id = bdg.pk_fk_booking_detail_id
						LEFT JOIN $tbl_guest g ON bdg.pk_fk_guest_id = g.pk_guest_id  " . $where;

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getAdditionalGuestForBooking()', $query);
        } else {
            $guests = array();
            $row = 0;
            $i = 0;

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                if (MetabaseFetchResult($gDatabase, $result, $row, 0) !== $guestid) {
                    // || $guestid == -1 && MetabaseFetchResult($gDatabase, $result, $row, 0) !== MetabaseFetchResult($gDatabase, $result, $row, 3)) || ($guestid !== -1 && MetabaseFetchResult($gDatabase, $result, $row, 0) !== $guestid)) {
                    $sum = 0.00;

                    for ($c = 0; $c < count($bookids); $c++) {
                        $sum = $this->getCommission($bookids[$c], 0, $sum, MetabaseFetchResult($gDatabase, $result, $row, 0));
                        $sum = number_format($sum[count($sum)-1]['amount'] * -1.00, 2, '.', '');
                    } 

                    $guests[$i] = array ('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                        'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                        'sum' => $sum
                        );
                    $i++;
                } 
            } 
            return $guests;
        } 
    } 

    /**
    * Receipt::getAddress()
    * 
    * Get the address of a guests
    * 
    * @param number $guestid id of a guest
    * @return string guest adress
    * @access public 
    * @since 2004-04-21
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getAddress($guestid)
    {
        global $tbl_guest, $tbl_guest_address, $tbl_address, $tbl_salutation, $tbl_country, $gDatabase, $errorhandler;

        $query = "SELECT g.firstname, g.lastname, g.academic_title,
						 a.postalcode, a.city, a.address, sal.salutation_de, coun.country_de
				    FROM  $tbl_guest g 
				 	LEFT JOIN $tbl_guest_address ga ON (ga.default_address  = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
					 	AND g.pk_guest_id = ga.pk_fk_guest_id) 
				 	LEFT JOIN $tbl_address a ON (a.pk_address_id = ga.pk_fk_address_id) 
					LEFT JOIN $tbl_salutation sal ON (g.fk_salutation_id = sal.pk_salutation_id) 
					LEFT JOIN $tbl_country coun ON (a.fk_country_id = coun.pk_country_id )	
					WHERE g.pk_guest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getAddress()', $query);
        } 
        $address = "";
        if (MetabaseFetchResult($gDatabase, $result, 0, 6) !== 'n/a') {
            $address .= MetabaseFetchResult($gDatabase, $result, 0, 6) . "\n";
        } 

        if (trim(MetabaseFetchResult($gDatabase, $result, 0, 2)) !== "") {
            $address .= MetabaseFetchResult($gDatabase, $result, 0, 2) . " ";
        } 
        $address .= MetabaseFetchResult($gDatabase, $result, 0, 0) . " " . MetabaseFetchResult($gDatabase, $result, 0, 1) . "\n";
        $address .= MetabaseFetchResult($gDatabase, $result, 0, 5) . "\n";
        $address .= MetabaseFetchResult($gDatabase, $result, 0, 3) . " " . MetabaseFetchResult($gDatabase, $result, 0, 4) . "\n\n";
        if (MetabaseFetchResult($gDatabase, $result, 0, 7) !== 'n/a') {
            $address .= MetabaseFetchResult($gDatabase, $result, 0, 7);
        } 
        return $address;
    } 

    /**
    * Receipt::getAddresses()
    * 
    * Get the addresses of a guests
    * 
    * @param number $guestid id of a guest
    * @return array guest adresses
    * @access public 
    * @since 2004-06-08
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getAddresses($guestid)
    {
        global $tbl_guest, $tbl_guest_address, $tbl_address, $tbl_salutation, $tbl_country, $gDatabase, $errorhandler;

        $query = "SELECT g.firstname, g.lastname, g.academic_title,
						 a.postalcode, a.city, a.address, sal.salutation_de, coun.country_de,
						 ga.address_type 
				    FROM  $tbl_guest g 
				 	LEFT JOIN $tbl_guest_address ga ON (g.pk_guest_id = ga.pk_fk_guest_id) 
				 	LEFT JOIN $tbl_address a ON (a.pk_address_id = ga.pk_fk_address_id) 
					LEFT JOIN $tbl_salutation sal ON (g.fk_salutation_id = sal.pk_salutation_id) 
					LEFT JOIN $tbl_country coun ON (a.fk_country_id = coun.pk_country_id )	
					WHERE g.pk_guest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getAddress()', $query);
        } 
        $ret = array();
        $row = 0;

        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
            $address = "";
            if (MetabaseFetchResult($gDatabase, $result, $row, 6) !== 'n/a') {
                $address .= MetabaseFetchResult($gDatabase, $result, $row, 6) . "\\n";
            } 

            if (trim(MetabaseFetchResult($gDatabase, $result, $row, 2)) !== "") {
                $address .= MetabaseFetchResult($gDatabase, $result, $row, 2) . " ";
            } 
            $address .= MetabaseFetchResult($gDatabase, $result, $row, 0) . " " . MetabaseFetchResult($gDatabase, $result, $row, 1) . "\\n";
            $address .= MetabaseFetchResult($gDatabase, $result, $row, 5) . "\\n";
            $address .= MetabaseFetchResult($gDatabase, $result, $row, 3) . " " . MetabaseFetchResult($gDatabase, $result, $row, 4) . "\\n\\n";
            if (MetabaseFetchResult($gDatabase, $result, $row, 7) !== 'n/a') {
                $address .= MetabaseFetchResult($gDatabase, $result, $row, 7);
            } 
			$ret[$row]['address'] = $address;
			$ret[$row]['type'] = MetabaseFetchResult($gDatabase, $result, $row, 8);
        } 
        return $ret;
    } 

    /**
    * Receipt::getReceipient()
    * 
    * Get the address of a guests
    * 
    * @param number $receiptid id of a receipt
    * @return array guest name
    * @access public 
    * @since 2004-04-21
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getReceipient($receiptid)
    {
        global $tbl_guest, $tbl_receipt, $gDatabase, $errorhandler;

        $query = "SELECT g.firstname, g.lastname, g.pk_guest_id
				    FROM  $tbl_receipt r
					LEFT JOIN $tbl_guest g ON r.fk_guest_id = g.pk_guest_id
					WHERE r.pk_receipt_id = " . $receiptid;

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getReceipient()', $query);
        } 
        $name = array ('name' => MetabaseFetchResult($gDatabase, $result, 0, 1) . ", " . MetabaseFetchResult($gDatabase, $result, 0, 0),
            'guestid' => MetabaseFetchResult($gDatabase, $result, 0, 2)
            );
        return $name;
    } 
    /*
    * Receipt::getDraftReceipient()
    * 
    * Get the address of a guests
    * 
    * @param number $draftreceiptid id of a draft receipt
    * @return array guest name
    * @access public 
    * @since 2004-04-21
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getDraftReceipient($draftreceiptid)
    {
        global $tbl_guest, $tbl_draftreceipt, $gDatabase, $errorhandler;

        $query = "SELECT g.firstname, g.lastname, g.pk_guest_id
				    FROM  $tbl_draftreceipt r
					LEFT JOIN $tbl_guest g ON r.fk_guest_id = g.pk_guest_id
					WHERE r.pk_draftreceipt_id = " . $draftreceiptid;

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getDraftReceipient()', $query);
        } 
        $name = array ('name' => MetabaseFetchResult($gDatabase, $result, 0, 1) . ", " . MetabaseFetchResult($gDatabase, $result, 0, 0),
            'guestid' => MetabaseFetchResult($gDatabase, $result, 0, 2)
            );
        return $name;
    } 

    /**
    * Receipt::getMwst()
    * 
    * Get the Mwst
    * 
    * @return array Mwst
    * @access public 
    * @since 2004-06-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getMwst()
    {
        global $tbl_receipt_item, $gDatabase, $errorhandler;

        $query = "SELECT DISTINCT (mwst)FROM $tbl_receipt_item ORDER BY mwst;";
		
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Receipt::getMwst()', $query);
        } 
        $ret = array();
        $row = 0;

        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
            $ret[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
        } 
        return $ret;
    } 
} 
