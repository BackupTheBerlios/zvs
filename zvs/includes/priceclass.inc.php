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
* class price
* 
* Class for price functionality
* 
* This class has all functions which are needed for the prices for the rooms.
* 
* @since 2004-01-01
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: priceclass.inc.php,v 1.1 2004/11/03 14:49:32 ehret Exp $
*/
class price {
    /**
    * price::getall()
    * 
    * get all prices
    * 
    * @param char $price_type price type 'N' normal 'A' advanced
    * @access public 
    * @return array prices
    * @since 2004-01-01
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall($price_type)
    {
        global $gDatabase, $request, $tbl_price, $tbl_price2, $errorhandler;
        $prices = array();
        if ($price_type == 'N') {
            $query = "SELECT fk_roomcat_id, fk_bookingcat_id, fk_season_id,
				  price_person, price_children, price_absolute, price_type,
				  price_person_short, price_children_short, price_absolute_short,
				  price_children2, price_children2_short, price_children3, price_children3_short
				  FROM $tbl_price ";
            $result = MetabaseQuery($gDatabase, $query);
            if ($result) {
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['person'] = MetabaseFetchResult($gDatabase, $result, $row, 3);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['children'] = MetabaseFetchResult($gDatabase, $result, $row, 4);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['absolute'] = MetabaseFetchResult($gDatabase, $result, $row, 5);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['type'] = MetabaseFetchResult($gDatabase, $result, $row, 6);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['person_short'] = MetabaseFetchResult($gDatabase, $result, $row, 7);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['children_short'] = MetabaseFetchResult($gDatabase, $result, $row, 8);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['absolute_short'] = MetabaseFetchResult($gDatabase, $result, $row, 9);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['children2'] = MetabaseFetchResult($gDatabase, $result, $row, 10);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['children2_short'] = MetabaseFetchResult($gDatabase, $result, $row, 11);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['children3'] = MetabaseFetchResult($gDatabase, $result, $row, 12);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['children3_short'] = MetabaseFetchResult($gDatabase, $result, $row, 13);
                } 
            } 
            if ($request->GetVar('debug', 'get') == 'true') {
                print $query;
                print '<br><br>';
                print '<pre>';
                print_r($result);
                print '</pre><br><br>';
                print '<pre>';
                print_r($prices);
                print '</pre>';
            } 
        } else {
            $query = "SELECT fk_roomcat_id, fk_bookingcat_id, fk_season_id,
				  price, price_short, persons_included, price_additional,
				  price_short_additional
				  FROM $tbl_price2 ";
            $result = MetabaseQuery($gDatabase, $query);
            if ($result) {
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['price'] = MetabaseFetchResult($gDatabase, $result, $row, 3);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['price_short'] = MetabaseFetchResult($gDatabase, $result, $row, 4);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['person'] = MetabaseFetchResult($gDatabase, $result, $row, 5);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['additional'] = MetabaseFetchResult($gDatabase, $result, $row, 6);
                    $prices[MetabaseFetchResult($gDatabase, $result, $row, 2)][MetabaseFetchResult($gDatabase, $result, $row, 0)][MetabaseFetchResult($gDatabase, $result, $row, 1)]['additional_short'] = MetabaseFetchResult($gDatabase, $result, $row, 7);
                } 
            } 
            if ($request->GetVar('debug', 'get') == 'true') {
                print $query;
                print '<br><br>';
                print '<pre>';
                print_r($result);
                print '</pre><br><br>';
                print '<pre>';
                print_r($prices);
                print '</pre>';
            } 		
        } 
        return $prices;
    } 
    /**
    * price::save()
    * 
    * save prices for a season
    * 
    * @access public 
    * @since 2004-01-01
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function save()
    {
        global $gDatabase, $request, $tbl_price, $tbl_price2, $errorhandler, $rcat, $bcat; 
        // turn on Transaction Control
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        $seasonids = array();
        $seasonids = $request->getVar('frm_seasonid', 'post');
        $bcats = $bcat->Get();
        $rcats = $rcat->get('N');
        $rcats2 = $rcat->get('A');

        for ($i = 0; $i < count($seasonids); $i++) {
            // delete all old entries for the season for price normal
            $query = sprintf("DELETE FROM $tbl_price WHERE fk_season_id = %s",
                $seasonids[$i]
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Price::save()', $query);
            } 
            // delete all old entries for the season for price advanced
            $query = sprintf("DELETE FROM $tbl_price2 WHERE fk_season_id = %s",
                $seasonids[$i]
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Price::save()', $query);
            } 
            // insert new values
            for ($j = 0; $j < count($bcats); $j++) {
                for ($k = 0; $k < count($rcats); $k++) {
                    $frmperson = "frm_price_adult_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmperson_short = "frm_price_adult_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmchildren = "frm_price_child_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmchildren_short = "frm_price_child_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmchildren2 = "frm_price_child2_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmchildren2_short = "frm_price_child2_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmchildren3 = "frm_price_child3_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmchildren3_short = "frm_price_child3_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmabsolute = "frm_price_pausch_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmabsolute_short = "frm_price_pausch_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];
                    $frmtype = "frm_type_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats[$k][catid];

                    $priceperson = 0.00;
                    $pricepersonshort = 0.00;
                    $pricechildren = 0.00;
                    $pricechildrenshort = 0.00;
                    $pricechildren2 = 0.00;
                    $pricechildren2short = 0.00;
                    $pricechildren3 = 0.00;
                    $pricechildren3short = 0.00;

                    if ($request->GetVar($frmperson, 'post') !== "") {
                        $priceperson = $request->GetVar($frmperson, 'post');
                    } 
                    if ($request->GetVar($frmperson_short, 'post') !== "") {
                        $pricepersonshort = $request->GetVar($frmperson_short, 'post');
                    } 
                    if ($request->GetVar($frmchildren, 'post') !== "") {
                        $pricechildren = $request->GetVar($frmchildren, 'post');
                    } 
                    if ($request->GetVar($frmchildren_short, 'post') !== "") {
                        $pricechildrenshort = $request->GetVar($frmchildren_short, 'post');
                    } 
                    if ($request->GetVar($frmchildren2, 'post') !== "") {
                        $pricechildren2 = $request->GetVar($frmchildren2, 'post');
                    } 
                    if ($request->GetVar($frmchildren2_short, 'post') !== "") {
                        $pricechildren2short = $request->GetVar($frmchildren2_short, 'post');
                    } 
                    if ($request->GetVar($frmchildren3, 'post') !== "") {
                        $pricechildren3 = $request->GetVar($frmchildren3, 'post');
                    } 
                    if ($request->GetVar($frmchildren3_short, 'post') !== "") {
                        $pricechildren3short = $request->GetVar($frmchildren3_short, 'post');
                    } 

                    $name = "zvs_pk_price_id";
                    $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$priceid);
                    $query = sprintf("INSERT INTO $tbl_price
								  (pk_price_id, fk_roomcat_id, fk_bookingcat_id,
								   fk_season_id, price_person, price_children, 
								   price_type, inserted_date, fk_inserted_user_id, 
								   price_person_short, price_children_short,
								   price_children2, price_children2_short, price_children3, price_children3_short) 
								   VALUES
								   (%s, %s, %s, %s, %s, %s, %s, NOW(), %s, %s, %s, %s, %s, %s, %s) ",
                        $priceid,
                        $rcats[$k][catid],
                        $bcats[$j][bcatid],
                        $seasonids[$i],
                        $priceperson,
                        $pricechildren,
                        MetabaseGetTextFieldValue($gDatabase, 'PP'),
                        $request->GetVar('uid', 'session'),
                        $pricepersonshort,
                        $pricechildrenshort,
                        $pricechildren2,
                        $pricechildren2short,
                        $pricechildren3,
                        $pricechildren3short
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Price::save()', $query);
                    } 
                } 

                for ($k = 0; $k < count($rcats2); $k++) {
                    $frmprice = "frm_price_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats2[$k][catid];
                    $frmprice_short = "frm_price_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats2[$k][catid];
                    $frmperson = "frm_person_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats2[$k][catid];
                    $frmadditional = "frm_additional_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats2[$k][catid];
                    $frmadditional_short = "frm_additional_short_" . $seasonids[$i] . "_" . $bcats[$j][bcatid] . "_" . $rcats2[$k][catid];

                    $price = 0.00;
                    $priceshort = 0.00;
                    $additional = 0.00;
                    $additionalshort = 0.00;

                    if ($request->GetVar($frmprice, 'post') !== "") {
                        $price = $request->GetVar($frmprice, 'post');
                    } 
                    if ($request->GetVar($frmprice_short, 'post') !== "") {
                        $priceshort = $request->GetVar($frmprice_short, 'post');
                    } 
                    if ($request->GetVar($frmadditional, 'post') !== "") {
                        $additional = $request->GetVar($frmadditional, 'post');
                    } 
                    if ($request->GetVar($frmadditional_short, 'post') !== "") {
                        $additionalshort = $request->GetVar($frmadditional_short, 'post');
                    } 

                    $name = "zvs_pk_price2_id";
                    $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$priceid);
                    $query = sprintf("INSERT INTO $tbl_price2
								  (pk_price2_id, fk_roomcat_id, fk_bookingcat_id,
								   fk_season_id, price, price_short, 
								   persons_included, price_additional, price_short_additional,
								   inserted_date, fk_inserted_user_id) 
								   VALUES
								   (%s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s) ",
                        $priceid,
                        $rcats2[$k][catid],
                        $bcats[$j][bcatid],
                        $seasonids[$i],
                        $price,
                        $priceshort,
                        MetabaseGetTextFieldValue($gDatabase, $request->GetVar($frmperson, 'post')),
                        $additional,
                        $additionalshort,
                        $request->GetVar('uid', 'session')
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Price::save()', $query);
                    } 
                } 
            } 
        } 
        $success = MetabaseCommitTransaction($gDatabase); 
        // end transaction
        $auto_commit = true;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
    } 
} 

?>