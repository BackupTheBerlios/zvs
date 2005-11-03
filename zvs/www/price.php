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
* Manage prices
* 
* Settings
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('seasonclass.inc.php');
include_once('bookingcategoryclass.inc.php');
include_once('roomcategoryclass.inc.php');
include_once('priceclass.inc.php');
$season = New Season;
$bcat = New BookingCategory;
$rcat = New RoomCategory;
global $bcat, $rcat;
$price = New Price;
$smarty -> assign("tpl_title", "Preise verwalten");
$smarty -> assign('tpl_nav', 'settings');
$smarty -> assign('tpl_subnav', 'syssettings');
$smarty -> assign('tpl_subnav2', 'price');
$smarty -> assign('tpl_type','price');
$smarty -> assign('tpl_children1',$request->GetVar('children1','session'));
$smarty -> assign('tpl_children2',$request->GetVar('children2','session'));
$smarty -> assign('tpl_children3',$request->GetVar('children3','session'));

if ($request->GetVar('frm_theyear','post') !== $request->undefined) {
    $theyear = $request->GetVar('frm_theyear','post');
} elseif ($request->GetVar('theyear','get') !== $request->undefined) {
    $theyear = $request->GetVar('theyear','get');
} else {
	$todaydate = getdate();
	$theyear = $todaydate['year'];
}

if ($request->GetVar('frm_theseason','post') !== $request->undefined) {
    $theseason = $request->GetVar('frm_theseason','post');
} elseif ($request->GetVar('theseason','get') !== $request->undefined) {
    $theseason = $request->GetVar('theseason','get');
} else {
	$theseason = -1;
}
$smarty->assign('tpl_theseason',$theseason);

if ($request->GetVar('frm_action','post') == 'save') {
    $price->save();
}

$prices = $price->getall('N');
$prices2 = $price->getall('A');


if ($request->GetVar('frm_copy','post') !== $request->undefined) {
	$cpyfrom = $request->GetVar('frm_copy','post');
	$cpyto = substr($theseason,1, strlen($theseason));
	$prices[$cpyto] = $prices[$cpyfrom];
	$prices2[$cpyto] = $prices2[$cpyfrom];
	$setaltered = true;
} else {
	$setaltered = false;
}
$smarty -> assign('tpl_altered', $setaltered);
$smarty -> assign('tpl_prices', $prices);
$smarty -> assign('tpl_prices2', $prices2);
$smarty -> assign('tpl_theyear', $theyear);
$smarty -> assign('tpl_years', $season->getYears());
$smarty -> assign('tpl_seasons', $season->GetOneYear($theyear));
$smarty -> assign('tpl_allseasons', $season->get());
$smarty -> assign('tpl_bcat', $bcat->Get());
$smarty -> assign('tpl_rcat', $rcat->get('N'));
$smarty -> assign('tpl_rcat2', $rcat->get('A'));

$smarty -> display('price.tpl');

?>
