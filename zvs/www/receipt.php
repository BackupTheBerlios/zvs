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
* Show receipt
* 
* receipt
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('../includes/receiptclass.inc.php');
$receipt = New Receipt;
include_once('../includes/articleclass.inc.php');
$article = New Article;
$receiptid = -1;
$loaddraft = false;
$draftdeleted = false;

$smarty->assign('tpl_articles', $article->get());
// save receipt
if ($request->GetVar('frm_action', 'post') == "save") {
    $receiptid = $receipt->save();
    $smarty->assign('tpl_saved', 'true');
    $smarty->assign('tpl_location', $wwwroot . 'receiptrtf.php/receiptid.' . $receiptid . '/receiptrtf.php'); 
    // save draft receipt
} elseif ($request->GetVar('frm_action', 'post') == "savedraft") {
    $draftreceiptid = $receipt->savedraft();
    $smarty->assign('tpl_saved', 'draft'); 
    // do anything else than save
} elseif ($request->GetVar('frm_action', 'post') == "deletedraft") {
    $receipt->deletedraft($request->GetVar('frm_draftreceiptid', 'post'), true);
    $location = $wwwroot . "checkopenbookings.php/bookid." . $request->GetVar('frm_bookid', 'post') . "/checkopenbookings.php";
    header("Location: $location");
} else {
    $smarty->assign('tpl_saved', 'false');
    $shortstay = false;
    $smartyshortstay = 'false';
    $length_short_stay = $request->GetVar('length_short_stay', 'session');
    $smarty->assign('tpl_shortstaydays', $length_short_stay);
    if ($request->GetVar('guestid', 'get') !== $request->undefined) {
        $guestid = $request->GetVar('guestid', 'get');
    } elseif ($request->GetVar('frm_guestid', 'post') !== $request->undefined) {
        $guestid = $request->GetVar('frm_guestid', 'post');
    } else {
        $guestid = -1;
    } 
    // if there is more than one booking (post)
    if ($request->GetVar('frm_bookidarr', 'post') !== $request->undefined) {
        $mwst_room = $request->GetVar('mwst_room', 'Session');
        $bookids = $request->GetVar('frm_bookidarr', 'post');
        $receiptdata = array('data' => '',
            'items' => array());
        $smarty->assign('tpl_bookid', $bookids[0]);
        $smarty->assign('tpl_bookids', $bookids);
        foreach ($bookids as $bookid) {
            $tmp = $receipt->get($bookid, $length_short_stay, $guestid); 
            // something went wrong
            if (!$tmp) {
                $smarty->assign('tpl_error', 'true');
                $smarty->display('receipt.tpl');
                exit;
            } 
            if ($receiptdata['data'] == "") {
                $receiptdata['data'] = $tmp['data'];
            } else {
                $receiptdata['data']['start_date'][count($receiptdata['data']['start_date'])] = $tmp['data']['start_date'][0];
                $receiptdata['data']['end_date'][count($receiptdata['data']['end_date'])] = $tmp['data']['end_date'][0];
            } 
            $itemtmp = $tmp['items'];
            for ($i = 0; $i < count($itemtmp); $i++) {
                array_push($receiptdata['items'], $itemtmp[$i]);
            } 
            $nextcolor = 0;
            $netto = 0;
            $brutto = 0;
            for ($i = 0; $i < count($receiptdata['items']); $i++) {
                $receiptdata['items'][$i]['id'] = $i;
                $receiptdata['items'][$i]['color'] = $nextcolor;
                $netto += $receiptdata['items'][$i]['netto'];
                $brutto += $receiptdata['items'][$i]['brutto'];
                if ($nextcolor == 0) {
                    $nextcolor = 1;
                } else {
                    $nextcolor = 0;
                } 
            } 
            $receiptdata['data']['price_netto_total'] = number_format($netto, 2, '.', '');
            $receiptdata['data']['price_total'] = number_format($brutto, 2, '.', '');
        } 
        // only one booking	(post)
    } elseif ($request->GetVar('frm_bookid', 'post') !== $request->undefined) {
        $mwst_room = $request->GetVar('mwst_room', 'Session');
        if ($request->GetVar('frm_bookids', 'post') !== $request->undefined) {
            $bookids = $request->GetVar('frm_bookids', 'post');
            $bookid = $bookids[0];
            $smarty->assign('tpl_bookids', $bookids);
        } else {
            $bookid = $request->GetVar('frm_bookid', 'post');
            $bookids[0] = $bookid;
        } 

        if ($request->GetVar('receiptid', 'post') !== $request->undefined) {
            $receiptid = $request->GetVar('frm_receiptid', 'post');
        } 
        $smarty->assign('tpl_bookid', $bookid);
        $receiptdata = $receipt->recalculate($bookid, $length_short_stay, $guestid);
        $smarty->assign('tpl_changed', $request->GetVar('frm_changed', 'post'));
        if ($request->GetVar('frm_action', 'post') == "add") {
            $id = $request->GetVar('frm_action_id', 'post')-1;
            $articleid = $request->GetVar('frm_article', 'post');
            $receiptdata = $receipt->additem($id, $bookid, $length_short_stay, $articleid, $guestid);
        } elseif ($request->GetVar('frm_action', 'post') == "del") {
            $id = $request->GetVar('frm_action_id', 'post')-1;
            $receiptdata = $receipt->delitem($id, $bookid, $length_short_stay, $guestid);
        } 
        // one booking (get)
    } else {
        $bookid = $request->GetVar('bookid', 'get');
        if ($request->GetVar('receiptid', 'get') !== $request->undefined) {
            $receiptid = $request->GetVar('receiptid', 'get');
        } else {
            $receiptid = $receipt->getReceiptId($bookid, $guestid);
        } 
        $bookids[0] = $bookid;
        $smarty->assign('tpl_bookid', $bookid);
        if ($receiptid == -1) {
            // is there a draft version ?
            if ($request->GetVar('draftreceiptid', 'get') !== $request->undefined) {
                $receiptdata = $receipt->getCompleteDraft($request->GetVar('draftreceiptid', 'get'), $guestid);
                $guestid = $receiptdata[data][guestid];
                $load = true;
                $smarty->assign('tpl_draft', 'true');
            } elseif ($receipt->getDraftReceiptId($bookid, $guestid) <> -1) {
                $receiptdata = $receipt->getCompleteDraft($receipt->getDraftReceiptId($bookid, $guestid), $guestid);
                $guestid = $receiptdata[data][guestid];
                $load = true;
                $smarty->assign('tpl_bookids', $receiptdata['data']['bookid']);
                $smarty->assign('tpl_draft', 'true');
            } else {
                $receiptdata = $receipt->get($bookid, $length_short_stay, $guestid); 
                // something went wrong
                if (!$receiptdata) {
                    $smarty->assign('tpl_error', 'true');
                    $smarty->display('receipt.tpl');
                    exit;
                } 

                $guestid = $receiptdata[data][guestid];
                $load = false;
                $smarty->assign('tpl_draft', 'false');
            } 
            $receiptdate = date("d.m.Y");
            $smarty->assign('tpl_changed', 'false');
        } else {
            $receiptdata = $receipt->getComplete($receiptid);
            $guestid = $receiptdata[data][guestid];
            $load = true;
            $smarty->assign('tpl_changed', 'true');
            $smarty->assign('tpl_bookids', $receiptdata['data']['bookid']);
        } 
    } 
    if ($guestid !== -1 && !$load) {
        $receiptdata[data][guestid] = $guestid;
        $receiptdata[data][address] = $receipt->getAddress($guestid);
    } 
    $days = $receiptdata[days];

    $smarty->assign('tpl_addguests', $receipt->getAdditionalGuestForBooking($bookids, $receiptdata[data][guestid]));

    if ($days <= $length_short_stay) {
        $shortstay = true;
        $smartyshortstay = 'true';
    } 
    if (count($receiptdata[items]) > 1) {
        $smarty->assign('tpl_allowdelete', 'true');
    } else {
        $smarty->assign('tpl_allowdelete', 'false');
    } 
    if ($receiptdata[items][count($receiptdata[items])-1][color] == 1) {
        $nextcolor = 0;
        $nextnextcolor = 1;
    } else {
        $nextcolor = 1;
        $nextnextcolor = 0;
    } 
    $sum = $receiptdata[data][price_total];
    $smarty->assign('tpl_nextcolor', $nextcolor); 
    // no receipt in system
    if ($receiptid == -1) {
        // more than one booking (from booking choice)
        if ($request->GetVar('frm_bookidarr', 'post') !== $request->undefined) {
            $bookids = $request->GetVar('frm_bookidarr', 'post'); 
            // more than one booking (from post of this form)
        } elseif ($request->GetVar('frm_bookids', 'post') !== $request->$request->undefined) {
            $bookids = $request->GetVar('frm_bookids', 'post');
        } 
        if (count($bookids) > 1) {
            for ($i = 0; $i < count($bookids); $i++) {
                $tmp = $receipt->getCommission($bookids[$i], $nextnextcolor, $sum, $receiptdata[data][guestid]);
                $sum = $tmp[count($tmp)-1]['amount'];
                if ($i !== count($bookids)-1) {
                    unset ($tmp[count($tmp)-1]);
                } 
                foreach ($tmp as $data) {
                    if ($nextcolor == 0) {
                        $nextcolor = 1;
                    } else {
                        $nextcolor = 0;
                    } 
                    $data['color'] = $nextcolor;
                    $commissiondata[count($commissiondata)] = $data;
                } 
            } 
            // one booking
        } else {
            $commissiondata = $receipt->getCommission($bookid, $nextnextcolor, $sum, $receiptdata[data][guestid]);
        } 

        $commissiondata2 = array(); 
        // receipt exists
    } else {
        $commissiondata = $receipt->getCommissionForReceipt($receiptid, $nextnextcolor, $sum, true);
        if ($commissiondata[count($commissiondata)-1]['color'] == 0) {
            $nextcolor = 1;
        } else {
            $nextcolor = 0;
        } 

        if (count($commissiondata) >= 1) {
            $commissiondata2 = $receipt->getCommissionForReceipt($receiptid, $nextcolor, $commissiondata[count($commissiondata)-1]['amount'], false);
        } else {
            $commissiondata2 = $receipt->getCommissionForReceipt($receiptid, $nextcolor, $sum, false);
        } 
    } 

    if (count($commissiondata) == 0) {
        if (count($commissiondata2) == 0) {
            $difference = $sum;
        } else {
            $difference = $commissiondata2[count($commissiondata2)-1]['amount'];
        } 
    } else {
        if (count($commissiondata2) == 0) {
            $difference = $commissiondata[count($commissiondata)-1]['amount'];
        } else {
            $difference = $commissiondata2[count($commissiondata2)-1]['amount'];
        } 
    } 

    $smarty->assign('tpl_commission', $commissiondata);
    $smarty->assign('tpl_commission2', $commissiondata2);
    $smarty->assign('tpl_difference', strtr($difference, ".", ","));

    $smarty->assign('tpl_shortstay', $smartyshortstay);
    $smarty->assign('tpl_receiptdata', $receiptdata);
    $smarty->assign('tpl_addresses', $receipt->getAddresses($guestid));
} 
if ($request->GetVar('frm_bookidarr', 'post') !== $request->undefined) {
    $bookids = $request->GetVar('frm_bookidarr', 'post');
    $smarty->assign('tpl_bookid', $bookids[0]);
    $smarty->assign('tpl_bookids', $bookids);
} 

$smarty->display('receipt.tpl');

?>