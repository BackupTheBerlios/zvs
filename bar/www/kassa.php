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
* Show bar interface
* 
* bar interface
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$theguestid = -1;
$theguest = "";
if ($request->GetVar('guestid','get') !== $request->undefined) {
    $theguestid = $request->GetVar('guestid','get');
	$theguest = $barguest->getName($theguestid);
	include_once("kassaclass.inc.php");
	$kassacls = New Kassa;
	if ($request->GetVar('frm_checkout','post') == "true") {
	    $kassacls->checkout($theguestid, $request->GetVar('frm_setinactive','post'));	
	}	
	$articles = $kassacls->get($theguestid);
	$smarty->assign('tpl_articles',$articles);
} 



$barguests = $barguest -> getAll();
$smarty->assign('tpl_barguests', $barguests);
$smarty->assign('tpl_theguestid', $theguestid);
$smarty->assign('tpl_theguest', $theguest);


$smarty -> assign("tpl_title", "ZVS Barinterface");
$smarty -> assign("tpl_nav", "kassa");

$smarty -> display('kassa.tpl');

?>
