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
* select timeframe for receipt
* 
* Settings
* 
* 01/06/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
$smarty -> assign("tpl_title", "Liste &uuml;ber Zeitraum erstellen");
$smarty->assign("tpl_title", "Archiv");
$smarty->assign('tpl_nav', 'archive');
$smarty->assign('tpl_subnav', '');

$theguestid = $request->GetVar('guestid', 'get');
include_once("kassaclass.inc.php");
$kassacls = New Kassa;
include_once("barguestclass.inc.php");
$barguest = New Barguest;


if ($request->GetVar('frm_start', 'get') !== $request->undefined) {
    $theguestid = $request->GetVar('frm_theguestid', 'get');
	$start = $request->GetVar('frm_start', 'get');
	$end = $request->GetVar('frm_end', 'get');
    $guestarticles = $kassacls->getTimeline($theguestid, $start, $end, 'ASC');
	$smarty->assign('tpl_guestarticles', $guestarticles);

}
	$smarty->assign('tpl_guest', $barguest->getName($theguestid));
$smarty->assign('tpl_theguestid',$theguestid);
$smarty->display('selectreceipt2.tpl');

?>
