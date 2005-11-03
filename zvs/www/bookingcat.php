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
* Manage booking categories
* 
* Settings
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('bookingcategoryclass.inc.php');
$bcat = New BookingCategory;
$smarty -> assign("tpl_title", "Buchungskategorien verwalten");
$smarty -> assign('tpl_nav', 'settings');
$smarty -> assign('tpl_subnav', 'catsettings');
$smarty -> assign('tpl_subnav2', 'bookingcat');

if ($request -> GetVar('frm_bcatid', 'post') !== $request -> undefined) {
    if ($request -> GetVar('frm_action', 'post') == 'edit') {
        $smarty -> assign('tpl_editid', $request -> GetVar('frm_bcatid', 'post'));
    } else if ($request -> GetVar('frm_action', 'post') == 'addnew') {
        $smarty -> assign('tpl_addnew', 'true');
    } else if ($request -> GetVar('frm_action', 'post') == 'del') {
        $bcat -> del($request -> GetVar('frm_bcatid', 'post'));
    } else {
        $check = $bcat -> saveupdate();
    } 
} 

$smarty -> assign('tpl_bcat', $bcat -> get());

$smarty -> display('bookingcat.tpl');

?>
