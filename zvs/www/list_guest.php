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
* list checked-in guests
* 
* guest
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('guestlistclass.inc.php');
$guestlist = New Guestlist;
include_once('bookingcategoryclass.inc.php');
$bcat = New BookingCategory;
$thebcat = -1;
if ($request->GetVar('frm_bookcat','post') !== $request->undefined) {
    $thebcat = $request->GetVar('frm_bookcat','post');
}
$smarty->assign('tpl_thebookcat',$thebcat);
$smarty->assign("tpl_title", "Anwesenheitsliste");
$smarty->assign('tpl_nav', 'lists');
$smarty->assign('tpl_subnav', 'checkout');
$smarty->assign('tpl_children0_field', $request->GetVar('children0', 'session'));
$smarty->assign('tpl_children1_field', $request->GetVar('children1', 'session'));
$smarty->assign('tpl_children2_field', $request->GetVar('children2', 'session'));
$smarty->assign('tpl_children3_field', $request->GetVar('children3', 'session'));

$smarty->assign('tpl_bookcat', $bcat->get());

$smarty->assign('tpl_guests', $guestlist->get($thebcat));

$smarty->display('list_guest.tpl');

?>
