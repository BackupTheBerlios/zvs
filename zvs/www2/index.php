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
* Employee Timetracker
* 
* 10/03/2004 by Christian Ehret chris@uffbasse.de
*/

include_once("../includes/default2.inc.php");
$auth -> is_authenticated();
include_once("timetrackerclass.inc.php");
$timetracker = new Timetracker;
$smarty -> assign("tpl_title", "An/Abmelden");
$smarty -> assign('tpl_nav', 'index');
$smarty -> assign('tpl_type', 'index');
$toggled = false;

if ($request -> GetVar('toggle', 'post') !== $request->undefined ) {
	$timetracker->toggle();
	$toggled = true;
}

if ($timetracker->getStatus($request->GetVar('uid', 'session')) == 0) {
	if ($toggled) {
	    $smarty->assign('tpl_status', 'toggledtrue');
	} else {
	    $smarty -> assign('tpl_status', 'false');	
	}
} else {
	if ($toggled) {
	    $smarty->assign('tpl_status', 'toggledfalse');
	} else {
	    $smarty -> assign('tpl_status', 'true');	
	}

}

$smarty -> display('index.tpl');

?>
