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
include_once("kassaclass.inc.php");
$kassacls = New Kassa;
include_once("barguestclass.inc.php");
$barguest = New Barguest;

if ($request->GetVar('frm_selectedcat', 'post') !== $request->undefined) {
    $cats = $request->GetVar('frm_selectedcat', 'post');
} else {
    $cats = array();
} 

if ($request->GetVar('payid', 'post') !== $request->undefined) {
	$items = $request->GetVar('payid', 'post');
} else {
	$items = array();
}

if ($request->GetVar('frm_guestid', 'post') !== $request->undefined) {
    $theguestid = $request->GetVar('frm_guestid', 'post');
    $guestarticles = $kassacls->getBon($theguestid, $cats, $items);
}
/*
for ($i=0; $i <= count($guestarticles); $i++) {
	if (!in_array($guestarticles[$i]['boughtid'], $items) && $guestarticles[$i]['articleid'] !== 0) {
	  unset($guestarticles[$i]);
	}
}

$guestarticles = array_values($guestarticles);
*/
$sum = 0.00;
$tax = array();
for ($i=0; $i < count($guestarticles)-1; $i++) {
	$sum  += $guestarticles[$i]['total'];
	$tax[$guestarticles[$i]['tax']]['brutto'] += $guestarticles[$i]['total'];
}
ksort($tax);
$tpl_tax = array();
$i = 0;
foreach ($tax as $key => $val) {
 $tpl_tax[$i]['tax'] = $key;
 $brutto =  $val['brutto'];
 $netto =  round(($val['brutto'] * 100)/($key+100),2);
 $tax_value = $brutto - $netto;
 $tpl_tax[$i]['netto'] = number_format($netto, 2, '.', '');
 $tpl_tax[$i]['brutto'] = number_format($brutto, 2, '.', '');
 $tpl_tax[$i]['tax_value'] = number_format($tax_value, 2, '.', '');
 $i++;
}


$guestarticles[$i]['total'] = number_format($sum, 2, '.', '');

$smarty -> assign("tpl_logo", 'logo.gif');
$smarty -> assign('tpl_name', $barguest->getName($theguestid));
$smarty -> assign('tpl_date', date("d.m.Y"));
$smarty -> assign("tpl_receipt", $guestarticles);
$smarty -> assign ('tpl_tax', $tpl_tax);
$smarty -> display('receipt_html.tpl');

?>