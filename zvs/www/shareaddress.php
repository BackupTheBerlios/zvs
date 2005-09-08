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
* Share address
* 
* Guest
* 
* @since 2005-08-22
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('guestclass.inc.php');
$guest = New Guest;
$smarty -> assign("tpl_title", "Adresse verkn&uuml;pfen");
$smarty -> assign('tpl_nav', 'gast');
$smarty -> assign('tpl_type', 'showgast');
if ($request -> GetVar('guestid', 'get') !== $request -> undefined) {
	$guestid = $request -> GetVar('guestid', 'get');
	$type = $request -> GetVar('type', 'get');
} elseif ($request -> GetVar('frm_guestid', 'post') !== $request -> undefined) {
	$guestid = $request -> GetVar('frm_guestid', 'post');
	$type = $request -> GetVar('frm_type', 'post');
}
$smarty -> assign('tpl_gast', $guest -> getGuest($guestid));
$smarty -> assign('tpl_type', $type);
$smarty->assign('tpl_finish', false);
if ($request->GetVar('frm_newaddress','post') !== $request->undefined) {
    $guest->shareaddress($request->GetVar('frm_newaddress','post'), $guestid, $type);
	$smarty->assign('tpl_finish', true);
} elseif ($request -> GetVar('frm_firstname', 'post') !== $request -> undefined) {
    $guests = $guest -> asearch($request -> GetVar('frm_firstname', 'post'), $request -> GetVar('frm_lastname', 'post'));
    $smarty -> assign('tpl_numresult', sizeof($guests));
    $smarty -> assign('tpl_isresult', 'true');
    $smarty -> assign('tpl_firstname', $request -> GetVar('frm_firstname', 'post'));
    $smarty -> assign('tpl_lastname', $request -> GetVar('frm_lastname', 'post'));
    $smarty -> assign('tpl_result', $guests);
} 
$smarty -> display('shareaddress.tpl');

?>
