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
* Show guest documents
* 
* Guest
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('guestclass.inc.php');
$guest = New Guest;
$smarty -> assign("tpl_title", "Gast bearbeiten/anlegen");
if ($request -> GetVar('type', 'get') == "edit") {
    $smarty -> assign('tpl_nav', 'gast');
	$smarty->assign('tpl_type','edit');
} else {
    $smarty -> assign('tpl_nav', 'showgast');
	$smarty -> assign('tpl_type','show');
} 
$smarty -> assign('tpl_subnav', 'documents');

if ($request -> GetVar('guestid', 'get') !== $request -> undefined) {
	$guestid = $request -> GetVar('guestid', 'get');
	$smarty -> assign('tpl_guestid', $guestid);
	if ($request->GetVar('showall', 'get') == 'true') {
	    $number = 0;
	} else {
		$number = 10;
	}
    $smarty -> assign('tpl_gast', $guest -> getGuest($guestid));
    $smarty -> assign('tpl_meldedocuments', $guest -> getMeldeData($guestid, $number));
    $smarty -> assign('tpl_bookings', $guest -> getLastBookings($guestid, $number));
    $smarty -> assign('tpl_laststays', $guest -> getLastStays($guestid, $number));
    $smarty -> assign('tpl_lastreceipts', $guest -> getLastReceipts($guestid, $number));	
} 

$smarty -> display('showguestdocuments.tpl');

?>
