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
* Show guest data
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
$smarty -> assign('tpl_nav', 'showgast');
$smarty -> assign('tpl_subnav', 'hauptgast');
$smarty -> assign('tpl_type', 'showgast');

if ($request -> GetVar('guestid', 'get') !== $request -> undefined) {
    $smarty -> assign('tpl_gast', $guest -> getGuest($request -> GetVar('guestid', 'get')));
} elseif ($request -> GetVar('frm_gastid', 'post') !== $request -> undefined) {
    $check = $guest -> saveupdateguest();
    if ($check) {
        header("Location: $wwwroot");
        exit;
    } 
} 
$smarty -> display('showgast.tpl');

?>
