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
* Manage users
* 
* Settings
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('userclass.inc.php');
$user = New User;
$smarty -> assign("tpl_title", "Benutzerverwaltung");
$smarty -> assign('tpl_nav', 'settings');
$smarty -> assign('tpl_subnav', 'edituser');
$smarty -> assign("tpl_challenge", session_id());
$smarty -> assign('tpl_group', $user->getallgroups());

if ($request -> GetVar('frm_userid', 'post') !== $request -> undefined) {
    if ($request -> GetVar('frm_action', 'post') == 'edit') {
        $smarty -> assign('tpl_editid', $request -> GetVar('frm_userid', 'post'));
    } else if ($request -> GetVar('frm_action', 'post') == 'addnew') {
        $smarty -> assign('tpl_addnew', 'true');
    } else if ($request -> GetVar('frm_action', 'post') == 'del') {
        $user -> del($request -> GetVar('frm_userid', 'post'));
    } else {
        $check = $user -> saveupdate();
    } 
} 

$smarty -> assign('tpl_user', $user -> getall());

$smarty -> display('edituser.tpl');

?>
