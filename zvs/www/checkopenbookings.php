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
* Check for open bookings
* 
* receipt
* 
* @since 2004-03-30
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('../includes/receiptclass.inc.php');
$receipt = New Receipt;
$bookid = $request->GetVar('bookid', 'get');
$location = $wwwroot . "receipt.php/bookid." . $bookid;
if ($request->getVar('guestid', 'get') !== $request->undefined) {
    $location .= "/guestid." . $request->getVar('guestid', 'get');
    $guestid = $request->getVar('guestid', 'get');
} else {
    $guestid = -1;
} 
$location .= "/receipt.php";
$smarty->assign('tpl_bookid', $bookid);
$smarty->assign('tpl_location', $location);
$location = "Location: " . $location;
$receiptids = $receipt->getReceiptIds($bookid);
$draftreceiptids = $receipt->getDraftReceiptIds($bookid);
if ($receiptids == -1 && $draftreceiptids == -1) {
    $bookids = array($bookid);
    if ($request->getVar('guestid', 'get') == $request->undefined) {
        $openBookings = $receipt->getOpenBookings($receipt->getGuestId($bookid), $bookids);
    } else {
        $openBookings = $receipt->getOpenBookings($request->getVar('guestid', 'get'), $bookids);
    } 


    // we have only this one booking
    if (count($openBookings) == 1) {
        Header($location);
    } else {
        $smarty->assign('tpl_type', 'bookings');
        $smarty->assign('tpl_openBookings', $openBookings);
        $smarty->display('checkopenbookings.tpl');
    } 
    // we have more than one receipt
} else {
    $count = 0;
    if (count($receiptids) > 1) {
        $receipts = array();
        for ($i = 0; $i < count($receiptids); $i++) {
            if ($request->GetVar('direct', 'get') == 'true') {
                $name = $receipt->getReceipient($receiptids[$i]);
                if ($guestid == $name['guestid']) {
                    $receipts[$i] = array('receiptid' => $receiptids[$i],
                        'name' => $name['name'],
                        'guestid' => $name['guestid']
                        );
                    $count++;
                } 
            } else {
                $name = $receipt->getReceipient($receiptids[$i]);
                $receipts[$i] = array('receiptid' => $receiptids[$i],
                    'name' => $name['name'],
                    'guestid' => $name['guestid']
                    );
                $count++;
            } 
        } 
        $smarty->assign('tpl_receipts', $receipts);
    } elseif ($receiptids !== -1) {
        $name = $receipt->getReceipient($receiptids);
        $receipts[0] = array('receiptid' => $receiptids,
            'name' => $name['name'],
            'guestid' => $name['guestid']
            );
        $count++;
        $smarty->assign('tpl_receipts', $receipts);
    } 
    if (count($draftreceiptids) > 1) {
        $draftreceipts = array();
        for ($i = 0; $i < count($draftreceiptids); $i++) {
            if ($request->GetVar('direct', 'get') == 'true') {
                $name = $receipt->getDraftReceipient($draftreceiptids[$i]);
                if ($guestid == $name['guestid']) {
                    $draftreceipts[$i] = array('draftreceiptid' => $draftreceiptids[$i],
                        'name' => $name['name'],
                        'guestid' => $name['guestid']
                        );
                    $count++;
                } 
            } else {
                $name = $receipt->getDraftReceipient($draftreceiptids[$i]);
                $draftreceipts[$i] = array('draftreceiptid' => $draftreceiptids[$i],
                    'name' => $name['name'],
                    'guestid' => $name['guestid']
                    );
                $count++;
            } 
        } 
        $smarty->assign('tpl_draftreceipts', $draftreceipts);
    } elseif ($draftreceiptids !== -1) {
        $name = $receipt->getDraftReceipient($draftreceiptids);
        $draftreceipts[0] = array('draftreceiptid' => $draftreceiptids,
            'name' => $name['name'],
            'guestid' => $name['guestid']
            );
        $count++;
        $smarty->assign('tpl_draftreceipts', $draftreceipts);
        if ($guestid == $name['guestid']) {
            $location .= '/draftreceiptid.' . $draftreceiptids . '/guestid.' . $name['guestid'] . './receipt.php';
        } 
    } 

    if ($count > 1) {
        $smarty->display('checkopenbookings.tpl');
    } else {
        // we still have only one receipt, so go directly to receipt
        Header($location);
    } 
} 

?>