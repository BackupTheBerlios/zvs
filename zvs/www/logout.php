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
* Logout page
* 
* Global
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/

$smartyType = "www";

include_once("../includes/default.inc.php");
$smarty -> assign("tpl_title", "Abmelden");
$smarty -> assign("tpl_nav", "logout");

$login = $request->GetVar('login','Session');
$smarty -> assign('tpl_login', rawurlencode($login));

$success = $sess -> DestroySession();
if ($success) {
    $smarty -> assign('tpl_logout', 'true');
} 
$smarty -> display('logout.tpl');
?>