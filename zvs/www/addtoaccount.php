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
* Add to Account
* 
* Settings
* 
* @since 2004-10-03
* @author Christian Ehret <chris@ehret.name> 
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
$smarty->assign("tpl_title", "Zahlungseingang");
include_once('accountclass.inc.php');
$account = New Account;
include_once('bookingclass.inc.php');
$booking = new Booking;

if ($request->GetVar('frm_description', 'post') !== $request->undefined) {
    if ($request->GetVar('frm_bookids', 'post') !== $request->undefined) {
        $bookids = $request->GetVar('frm_bookids', 'post');
    } else {
        $bookids = array($request->GetVar('frm_bookingid', 'post'));
    } 
    $account->book($request->GetVar('frm_guestid', 'post'), $request->GetVar('frm_bookingid', 'post'), $request->GetVar('frm_date_payment', 'post'), $request->GetVar('frm_description', 'post'), $request->GetVar('frm_amount', 'post'), $request->GetVar('frm_paycat', 'post'), $request->GetVar('frm_receiptid', 'post'), $request->GetVar('frm_on_receipt', 'post'));
    $addids = $request->GetVar('frm_bookings', 'post');
    for ($i = 0; $i < count($addids); $i++) {
        if ($addids[$i] !== $request->GetVar('frm_bookingid', 'post')) {
            $account->setStatus($request->GetVar('frm_receiptid', 'post'), $addids[$i]);
        } 
    } 
    $smarty->assign('tpl_close', 'true');
} else {
    include_once('paycategoryclass.inc.php');
    $pcat = New PayCategory;

    $todaydate = getdate();
    $day = $todaydate['mday'];
    $month = $todaydate['mon'];
    $year = $todaydate['year'];
    $thedate = "$day.$month.$year";
    $smarty->assign('tpl_thedate', $thedate);
    $smarty->assign('tpl_guestid', $request->GetVar('frm_accountguestid', 'post'));
    $smarty->assign('tpl_bookingid', $request->GetVar('frm_bookid', 'post'));
    $smarty->assign('tpl_bookdate', $booking->getDate($request->GetVar('frm_bookid', 'post')));
    $smarty->assign('tpl_receiptid', $request->GetVar('frm_receiptid', 'post'));
    $smarty->assign('tpl_on_receipt', $request->GetVar('frm_on_receipt', 'post'));
    if ($request->GetVar('frm_bookids', 'post') !== $request->undefined) {
        $bookids = $request->GetVar('frm_bookids', 'post');
        $smarty->assign('tpl_bookids', $bookids);
        for ($i = 0; $i < count($bookids); $i++) {
            $bookings[$i] = $booking->getDate($bookids[$i]);
        } 
        $smarty->assign('tpl_bookings', $bookings);
    } 
    if ($request->GetVar('frm_difference', 'post') !== $request->undefined) {
        $difference = number_format(strtr($request->GetVar('frm_difference', 'post'), ',', '.'), 2, '.', '');
    } else {
        $difference = "";
    } 
    $smarty->assign('tpl_difference', $difference);
    $smarty->assign('tpl_close', 'false');
	$smarty->assign('tpl_pcats', $pcat->getall());
} 



$smarty->display('addtoaccount.tpl');

?>