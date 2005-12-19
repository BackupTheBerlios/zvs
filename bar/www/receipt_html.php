<?php
/**
* Copyright notice
* 
*   (c) 2003-2004 Christian Ehret (chris@ehret.name)
*   All rights reserved
* 
*   This script is part of the ZVS project. The ZVS project is 
*   free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
* 
*   The GNU General Public License can be found at
*   http://www.gnu.org/copyleft/gpl.html.
*   A copy is found in the textfile GPL.txt and important notices to the license 
*   from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*   This script is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
* 
*   This copyright notice MUST APPEAR in all copies of the script!
*/

/**
* View "receipt" as HTML (for POS-Printer)
* 
* 
* 11/19/2005 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";

include_once("../includes/default.inc.php");

$auth->is_authenticated();
include_once("../includes/fileselector.inc.php");
include_once("kassaclass.inc.php");
$kassacls = New Kassa;
include_once("barguestclass.inc.php");
$barguest = New Barguest;

if ($request->GetVar('cats', 'get') !== $request->undefined) {
    $cats = explode(",", $request->GetVar('cats', 'get'));
} else {
    $cats = array();
} 

if ($request->GetVar('guestid', 'get') !== $request->undefined) {
    $theguestid = $request->GetVar('guestid', 'get');

    $guestarticles = $kassacls->get($theguestid, 'ASC', $cats);

} else {
    $theguestid = $request->GetVar('frm_theguestid', 'get');
    $start = $request->GetVar('frm_start', 'get');
    $end = $request->GetVar('frm_end', 'get');
    $guestarticles = $kassacls->getTimeline($theguestid, $start, $end, 'ASC', $cats);

} 
$smarty -> assign("tpl_logo", $tplfile = selectfile('logo.gif'));
$smarty -> assign('tpl_name', $barguest->getName($theguestid));
$smarty -> assign('tpl_date', date("d.m.Y"));
$smarty -> assign("tpl_receipt", $guestarticles);
$smarty -> display('receipt_html.tpl');

?>