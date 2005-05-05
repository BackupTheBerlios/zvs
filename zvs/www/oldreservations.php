<?php
/**
 * Copyright notice
 * 
 *     (c) 2003-2004 Christian Ehret (chris@ehret.name)
 *     All rights reserved
 * 
 *     This script is part of the ZVS project. The ZVS project is 
 *     free software; you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation; either version 2 of the License, or
 *     (at your option) any later version.
 * 
 *     The GNU General Public License can be found at
 *     http://www.gnu.org/copyleft/gpl.html.
 *     A copy is found in the textfile GPL.txt and important notices to the license 
 *     from the author is found in LICENSE.txt distributed with these scripts.
 * 
 * 
 *     This script is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     This copyright notice MUST APPEAR in all copies of the script!
 */

/**
 * Show old reservations
 * 
 * calendar
 * 
 * @since 2004-06-05
 * @author Christian Ehret <chris@ehret.name> 
 */
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('bookingclass.inc.php');

$sess->SetVar('showoldres', 'noshow');
$book = New Booking;

$navmonth = $request->GetVar('month', 'get');
$navyear = $request->GetVar('year', 'get');
$navstep = $request->GetVar('navstep', 'get');

if ($navmonth == "") {
    $navmonth = $request->GetVar('frm_navmonth', 'post');
} 

if ($navyear == "") {
    $navyear = $request->GetVar('frm_navyear', 'post');
} 

if ($navstep == "") {
    $navstep = $request->GetVar('frm_navstep', 'post');
} 

$smarty->assign('tpl_navyear', $navyear);
$smarty->assign('tpl_navmonth', $navmonth);
$smarty->assign('tpl_navstep', $navstep);

if ($request->GetVar('frm_res_all', 'post') == 'true') {
    $ids = $request->GetVar('frm_ids', 'post');
    for ($i = 0; $i < count($ids); $i++) {
        $book->extendreservation($ids[$i], $request->GetVar('frm_date', 'post'));
    } 
} elseif ($request->GetVar('frm_del_all', 'post') == 'true') {
    $ids = $request->GetVar('frm_ids', 'post');
    for ($i = 0; $i < count($ids); $i++) {
        $book->deloldreservation($ids[$i]);
    } 
} else {
    if ($request->GetVar('del', 'get') !== $request->undefined) {
        $book->deloldreservation($request->GetVar('del', 'get'));
    } 
    if ($request->GetVar('frm_id', 'post') !== $request->undefined) {
        $book->extendreservation($request->GetVar('frm_id', 'post'), $request->GetVar('frm_date', 'post'));
    } 
} 
$displayrows = 10;
$max = $book->getnumoldreservations();

$pages = floor ($max / $displayrows);
if ($max % $displayrows <> 0) {
    $pages++;
} 

$pageLinks = array();

for ($i = 0; $i < $pages; $i++) {
    $pageLinks[$i] = array('start' => $i * $displayrows,
        'number' => $i + 1
        );
} 

$smarty->assign('tpl_pages', $pageLinks);

if ($request->GetVar('start', 'get') != "") {
    $start = $request->GetVar('start', 'get');
} else {
    $start = 0;
} 
$smarty->assign('tpl_start', $start);
$smarty->assign('tpl_thispageno', floor($start / $displayrows) + 1);

$smarty->assign('tpl_oldreservations', $book->getoldreservations($start, $displayrows));
$smarty->display('oldreservations.tpl');

?>