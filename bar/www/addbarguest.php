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
* Add bar guest
* 
* Settings
* 
* 01/06/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$auth -> is_authenticated();
$smarty -> assign("tpl_title", "Gast hinzuf&uuml;gen");
if ($request->GetVar('frm_firstname','post') !== $request->undefined) {
    $guestid = $barguest->add();
	$smarty->assign('tpl_theguestid', $guestid);
	$smarty->assign('tpl_added','true');
} else {
	$smarty->assign('tpl_added','false');
}

$smarty -> assign('tpl_bookingcat', $barguest->getAllBookingcat());
$smarty -> display('addbarguest.tpl');

?>
