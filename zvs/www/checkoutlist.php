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
* Checkout a guest
* 
* calendar
* 
* @since 2004-01-22
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('checkoutclass.inc.php');
if ($request->GetVar('list', 'get') == 'true') {
    $smarty->assign("tpl_title", "Anwensenheitsliste");
    $smarty->assign('tpl_nav', 'lists');
    $smarty->assign('tpl_subnav', 'checkout');
    $smarty->assign('tpl_checkout', 'false');
} else {
    $smarty->assign("tpl_title", "Checkout");
    $smarty->assign('tpl_nav', 'calendar');
    $smarty->assign('tpl_subnav', 'checkout');
    $smarty->assign('tpl_checkout', 'true');
} 
$checkout = New Checkout;

$smarty->assign('tpl_guests', $checkout->get());

$smarty->display('checkoutlist.tpl');

?>
