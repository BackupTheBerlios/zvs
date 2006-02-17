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
$auth->is_authenticated();
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$theguestid = -1;
$theguest = "";
$thebookingcat = "";

include_once('statisticsclass.inc.php');
$statistics = New Statistics;

include_once('articlecatclass.inc.php');
$articlecat = New articlecat;

$cats = $articlecat->getall();

for ($i=0; $i< count($cats); $i++){
  $selectedcats[$i] = $cats[$i]['articlecatid'];
}
$smarty->assign('tpl_nextnum', count($cats)+1);

$smarty->assign('tpl_showlast', 'false');

if ($request->GetVar('frm_cat', 'post') !== $request->undefined) {
    $cat = "verkauf".$request->GetVar('frm_cat', 'post');
} else {
	$cat = "verkauf".$cats[0]['articlecatid'];
}


if ($request->GetVar('showlast','get') !== $request->undefined) {
    $smarty->assign('tpl_showlast', 'true');
}
if ($request->GetVar('frm_articleid', 'post') !== $request->undefined) {
    $articleid = $request->GetVar('frm_articleid', 'post');
    $theguestid = $request->GetVar('guestid', 'get');
    $num = $request->GetVar('frm_num', 'post');
    $barguest->buy($articleid, $theguestid, $num);
	$smarty->assign('tpl_showlast', 'true');
} 
if ($request->GetVar('guestid', 'get') !== $request->undefined) {
    $theguestid = $request->GetVar('guestid', 'get');
    $theguest = $barguest->getName($theguestid);
    $thegroupcolor = $barguest->getGroupColor($theguestid);
	$thebookingcat = $barguest->getBookingcat($theguestid);
    include_once("articleclass.inc.php");
    $articlecls = New Article;
    //$articles = $articlecls->Getall(true);
	$articles = array();
	for ($i=0; $i < count($cats); $i++){
		$cats[$i]['articles'] = $articlecls->Getallcat(true, $cats[$i]['articlecatid']);
	}
    $smarty->assign('tpl_articles', $articles);
    include_once("kassaclass.inc.php");
    $kassacls = New Kassa;
    if ($request->GetVar('frm_checkout', 'post') == "true") {
        $payids = $request->getVar('payid', 'post');
        for ($i = 0; $i < count($payids); ++$i) {
            $kassacls->pay($payids[$i]);
        } 
			$cat = "abrechnung";
			$selectedcats = $request->GetVar('frm_selectedcat','post');
        if ($request->GetVar('frm_setinactive', 'post') == "true") {
            $kassacls->checkout($theguestid, $request->GetVar('frm_setinactive', 'post'));
        } 
    } 
    if ($request->GetVar('frm_storno', 'post') == "true") {
		$selectedcats = $request->GetVar('frm_selectedcat','post');
        $kassacls->storno($request->GetVar('frm_boughtid', 'post'));
		$cat = "abrechnung";
    } 
    if ($request->GetVar('frm_multiple_storno', 'post') == "true") {
				$selectedcats = $request->GetVar('frm_selectedcat','post');
		    $payids = $request->getVar('payid', 'post');
        for ($i = 0; $i < count($payids); ++$i) {
        	$kassacls->storno($payids[$i]);
        }
		$cat = "abrechnung";
    }     
    if ($request->GetVar('frm_pay', 'post') == "true") {
		$selectedcats = $request->GetVar('frm_selectedcat','post');
        $kassacls->pay($request->GetVar('frm_boughtid', 'post'));
		$cat = "abrechnung";
    } 
	if ($request->GetVar('frm_changecat', 'post') == "true") {
		$selectedcats = $request->GetVar('frm_selectedcat','post');
	    $cat = "abrechnung";
	}
    $guestarticles = $kassacls->get($theguestid, 'DESC', $selectedcats);
    $smarty->assign('tpl_guestarticles', $guestarticles);
} 

$smarty->assign('tpl_import', $usezvs);
$smarty->assign('tpl_cat', $cats);
$smarty->assign('tpl_thecat', $cat);
$smarty->assign('tpl_selectedcat', $selectedcats);

$barguests = $barguest->getAll();

$smarty->assign('tpl_barguests', $barguests);
$smarty->assign('tpl_theguestid', $theguestid);
$smarty->assign('tpl_thebookingcat', $thebookingcat);
$smarty->assign('tpl_theguest', $theguest);
$smarty->assign('tpl_thegroupcolor', $thegroupcolor);

$smarty->assign("tpl_title", "ZVS Barinterface");
$smarty->assign("tpl_nav", "sell");
$smarty->assign('tpl_sum', $statistics->GetNow());
$smarty->display('index.tpl');

?>
