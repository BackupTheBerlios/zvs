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
* Manage guest categories
* 
* Guest
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('guestclass.inc.php');
include_once('guestcategoryclass.inc.php');
$guest = New Guest;
$gcategory = New GuestCategory;
$smarty -> assign("tpl_title", "Gast bearbeiten/anlegen");
$smarty -> assign('tpl_nav', 'gast');
$smarty -> assign('tpl_subnav', 'cat');
$smarty -> assign('tpl_type', 'editgast');

if ($request -> GetVar('guestid', 'get') !== $request -> undefined) {
    $guestid = $request -> GetVar('guestid', 'get');
} elseif ($request -> GetVar('frm_gastid', 'post') !== $request -> undefined) {
    $guestid = $request -> GetVar('frm_gastid', 'post');
} else { // noch kein Gast angelegt
    header("Location: " . $wwwroot . "editgast.php");
    exit;
} 

if ($request -> GetVar('frm_changeAction', 'post') == 'add') {
    $gcategory -> subscribe($request -> GetVar('frm_gastid', 'post'), $request -> GetVar('frm_catid', 'post'));
} else if ($request -> GetVar('frm_changeAction', 'post') == 'del') {
    $gcategory -> unsubscribe($request -> GetVar('frm_gastid', 'post'), $request -> GetVar('frm_catid', 'post'));
} 
// Load data
$smarty -> assign('tpl_category', $gcategory -> getallwithstatus($guestid));
$smarty -> assign('tpl_gast', $guest -> getGuest($guestid));

$smarty -> assign('tpl_cat', $cat);

$smarty -> display('editcat.tpl');

?>
