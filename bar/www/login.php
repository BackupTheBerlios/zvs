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
* Login page
* 
* Global
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
global $smarty, $request, $sess, $auth;

$smarty -> assign("tpl_title", "Login");
if ($request -> GetVar('username', 'post') !== $request->undefined) {
    $auth_username = $request -> GetVar('username', 'post');
} 

$value = (isset($this -> auth["uname"]) ? $this -> auth["uname"] : "");

$sess -> SetVar("reg_url", $action);
$smarty -> assign("tpl_uname", $value);
$smarty -> assign("tpl_challenge", session_id());
$smarty -> assign("tpl_url", $request -> GetURI());
$smarty -> assign("tpl_hiddenfields", $request -> returnPostDataAsHiddenFields());
if ($request -> GetVar('login', 'get') !== $request->undefined ) {
    $smarty -> assign('tpl_login', $request -> GetVar('login', 'get'));
} else if ($request -> GetVar('username', 'post') !== $request->undefined ) {
    $smarty -> assign('tpl_login', $request -> GetVar('username', 'post'));
}

if (isset($auth_username)) {
    $smarty -> assign("tpl_issetuname", "true");
} 
$smarty -> display('login.tpl');

?>
