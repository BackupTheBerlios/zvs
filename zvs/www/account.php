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
* Show account
* 
* Guest
* 
* @since 2004-10-03
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('guestclass.inc.php');
$guest = New Guest;
include_once('accountclass.inc.php');
$account = New Account;
include_once('paycategoryclass.inc.php');
$pcat = New PayCategory;

$todaydate = getdate();
$day = $todaydate['mday'];
$month = $todaydate['mon'];
$year = $todaydate['year'];
$thedate = "$day.$month.$year";
$smarty->assign('tpl_thedate', $thedate);

$smarty->assign("tpl_title", "Gast Konto");
if ($request->GetVar('type', 'get') == "edit") {
    $smarty->assign('tpl_nav', 'gast');
    $smarty->assign('tpl_type', 'edit');
} else {
    $smarty->assign('tpl_nav', 'showgast');
    $smarty->assign('tpl_type', 'show');
} 

if ($request->GetVar('do','get') == "del") {
    $account->del($request->GetVar('id','get'));
}
$smarty->assign('tpl_subnav', 'account');

if ($request->GetVar('guestid', 'get') !== $request->undefined) {
    $guestid = $request->GetVar('guestid', 'get');
}
$smarty->assign('tpl_guestid', $guestid);
if ($request->GetVar('showall', 'get') == 'true') {
    $number = 0;
} else {
    $number = 10;
} 
if ($request->GetVar('frm_description', 'post') !== $request->undefined) {
    $account->book($guestid, $request->GetVar('frm_bookingid', 'post'), $request->GetVar('frm_date_payment', 'post'), $request->GetVar('frm_description', 'post'), $request->GetVar('frm_amount', 'post'), $request->GetVar('frm_paycat', 'post'), -1, false);
} 

$smarty->assign('tpl_gast', $guest->getGuest($guestid));
$smarty->assign('tpl_accounts', $account->get($guestid, $number));
$smarty->assign('tpl_openbookings', $account->getOpenBookings($guestid));
$smarty->assign('tpl_pcats', $pcat->getall());


$smarty->display('account.tpl');

?>
