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
* View calendar as PDF
* 
* Calendar
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/
include_once("../includes/default.inc.php");

$leftmargin = 15;

$auth -> is_authenticated();

include_once('calendarclass.inc.php');
include_once('bookingcategoryclass.inc.php');
include_once('roomclass.inc.php');

$cal = New Calendar;
$bcat = New BookingCategory;
$room = New Room;

$title = "Zimmerplan";
$view = 'type';

if ($request -> GetVar('view', 'get') !== $request -> undefined) {
    $view = $request -> GetVar('view', 'get');
} else if ($request -> GetVar('view', 'post') !== $request -> undefined) {
    $view = $request -> GetVar('view', 'post');
} 

if ($view == 'type') {
    $title .= " (Belegungsart)";
} else {
    $smarty -> assign('tpl_subnav', 'cat');
    $title .= " (Buchungskategorien)";
} 

function getHeader()
{
    global $pdf, $categories, $calendar, $xstart, $ystart, $fonttype, $redfill0,
    $redfill1, $greenfill0, $greenfill1, $bluefill0, $bluefill1, $leftmargin,
    $monthName, $displayyear, $title, $view, $request;

    $pdf -> SetXY(55, 10);

    $pdf -> SetFont($fonttype, 'B', 16);
    $pdf -> Write(5, $title . ' ' . $monthName . ' ' . $displayyear);
    $pdf -> SetFont($fonttype, 'B', 12);
    $pdf -> Ln(8);
    $pdf -> SetX(55);

    $xstart = 55;
    $ystart = 18; 
    // categories
    $pdf -> SetFont($fonttype, '', 10);
    if ($view == 'type') {
        $red = hexdec(substr($request -> GetVar('colorP', 'session'), 1, 2));
        $green = hexdec(substr($request -> GetVar('colorP', 'session'), 3, 2));
        $blue = hexdec(substr($request -> GetVar('colorP', 'session'), 5, 2));
        $pdf -> SetFillColor($red, $green, $blue);
        $pdf -> Rect($xstart, $ystart, 5, 5, 'DF');
        $xstart += 5;
        $pdf -> SetX($xstart);
        $pdf -> Write(5, "Abgerechnet");
        $xstart += $pdf -> GetStringWidth("Abgerechnet") + 10;

        $red = hexdec(substr($request -> GetVar('colorB', 'session'), 1, 2));
        $green = hexdec(substr($request -> GetVar('colorB', 'session'), 3, 2));
        $blue = hexdec(substr($request -> GetVar('colorB', 'session'), 5, 2));
        $pdf -> SetFillColor($red, $green, $blue);
        $pdf -> Rect($xstart, $ystart, 5, 5, 'DF');
        $xstart += 5;
        $pdf -> SetX($xstart);
        $pdf -> Write(5, "Buchung");
        $xstart += $pdf -> GetStringWidth("Buchung") + 10;

        $red = hexdec(substr($request -> GetVar('colorR', 'session'), 1, 2));
        $green = hexdec(substr($request -> GetVar('colorR', 'session'), 3, 2));
        $blue = hexdec(substr($request -> GetVar('colorR', 'session'), 5, 2));
        $pdf -> SetFillColor($red, $green, $blue);
        $pdf -> Rect($xstart, $ystart, 5, 5, 'DF');
        $xstart += 5;
        $pdf -> SetX($xstart);
        $pdf -> Write(5, "Reservierung");
        $xstart += $pdf -> GetStringWidth("Reservierung") + 10;
    } else {
        for ($i = 0; $i < count($categories); $i++) {
            if ($pdf -> GetX() + 5 + $pdf -> GetStringWidth($categories[$i][name]) > 240) {
                $pdf -> SetY($pdf -> GetY() + 8);
                $xstart = 55;
                $ystart += 8;
            } 

            $red = hexdec(substr($categories[$i][catcolor], 1, 2));
            $green = hexdec(substr($categories[$i][catcolor], 3, 2));
            $blue = hexdec(substr($categories[$i][catcolor], 5, 2));
            $pdf -> SetFillColor($red, $green, $blue);
            $pdf -> Rect($xstart, $ystart, 5, 5, 'DF');
            $xstart += 5;
            $pdf -> SetX($xstart);
            $pdf -> Write(5, $categories[$i][name]);
            $xstart += $pdf -> GetStringWidth($categories[$i][name]) + 10;
        } 
    } 
    $ystart += 16;
    $xstart = $leftmargin;
    $pdf -> SetY($ystart, $xstart);

    $pdf -> SetDrawColor(255, 217, 28);
    $pdf -> SetFillColor($redfill0, $greenfill0, $bluefill0);

    $pdf -> Rect($xstart, $ystart, 50, 9, 'DF');
    $xstart += 50;
    for ($i = 0; $i < count($calendar); $i++) {
        // check if monthchange
        if ($calendar[$i][weekday] == '') {
            $pdf -> Rect($xstart, $ystart, 3, 9, 'DF');
            $pdf -> SetX($xstart);
            $pdf -> SetY($ystart);
            $xstart += 3;
        } else {
            $pdf -> Rect($xstart, $ystart, 6, 9, 'DF');
            $pdf -> SetX($xstart);
            $pdf -> Write(4, $calendar[$i][weekday]);
            $pdf -> SetXY($xstart, $ystart + 5);
            $pdf -> Write(4, $calendar[$i][date]);
            $pdf -> SetY($ystart);
            $xstart += 6;
        } 
    } 
} 

$todaydate = getdate();
$month = $todaydate['mon'];
$year = $todaydate['year'];

if ($request -> GetVar('month', 'get') !== $request -> undefined) {
    $month = $request -> GetVar('month', 'get');
    $year = $request -> GetVar('year', 'get');
} else if ($request -> GetVar('month', 'post') !== $request -> undefined) {
    $month = $request -> GetVar('month', 'post');
    $year = $request -> GetVar('year', 'post');
} 
// get categories
$categories = $bcat -> get();
// get rooms
$rooms = $room -> get();

$monthName = $cal -> returnMonthName($month);
$prevMonth = $cal -> previous_month($month, $year, false, false);
$displayyear = $year;

if ($request -> GetVar('step', 'get') !== $request -> undefined) {
    if ($month == 12) {
        $nextmonth = 1;
        $tmpyear = $year + 1;
        $displayyear = $year . '/' . $tmpyear;
    } else {
        $nextmonth = $month + 1;
    } 
    $monthName = $monthName . '/' . $cal -> returnMonthName($nextmonth);

    $calendar = $cal -> GetHalfMonth($year, $month, 0);

    for ($i = 0; $i < count($rooms); ++$i) {
        $id = $rooms[$i]['roomid'];
        $roomcal[$i] = $cal -> GetHalfMonth($year, $month, $id);
    } 
} else {
    $calendar = $cal -> GetMonth($year, $month, 0);

    for ($i = 0; $i < count($rooms); ++$i) {
        $id = $rooms[$i]['roomid'];
        $roomcal[$i] = $cal -> GetMonth($year, $month, $id);
    } 
} 

define('FPDF_FONTPATH', $fontpath);
include_once('fpdf.php');
include_once('pdf.php');
$fonttype = 'times';

$pdf = new PDF();
$pdf -> Open();
$pdf -> SetTitle('ZVS Zimmerplan');
$pdf -> SetAuthor($request -> GetVar('hotel_name', 'session'));
$pdf -> SetCreator('ZVS');
$pdf -> AliasNbPages();
$pdf -> AddPage(L);

$redfill0 = 255;
$redfill1 = 255;
$greenfill0 = 242;
$greenfill1 = 255;
$bluefill0 = 189;
$bluefill1 = 255;

getHeader();

$ystart += 9;
/*
    if ($ystart < 42)
    {
        $ystart = 42;
    } */ 
// rooms
for ($i = 0; $i < count($rooms); $i++) {
    // new page
    if ($pdf -> GetY() > 170) {
        $pdf -> AddPage(L);
        getHeader();
        $ystart += 9;
    } 
    // $pdf->Write(5,$pdf->GetY());
    $xstart = $leftmargin;
    if ($i % 2 <> 0) {
        $sred = $redfill0;
        $sgreen = $greenfill0;
        $sblue = $bluefill0;
    } else {
        $sred = $redfill1;
        $sgreen = $greenfill1;
        $sblue = $bluefill1;
    } 

    $pdf -> SetFillColor($sred, $sgreen, $sblue);
    $pdf -> Rect($xstart, $ystart, 50, 9, 'DF');
    $pdf -> SetY($ystart + 2);
    $pdf -> SetX($xstart);
    $pdf -> Write(4, $rooms[$i][name]);

    $xstart += 50;

    for ($j = 0; $j < count($roomcal[$i]); $j++) {
        if ($view == 'type') {
            $red = hexdec(substr($roomcal[$i][$j][bookingtypecolor], 1, 2));
            $green = hexdec(substr($roomcal[$i][$j][bookingtypecolor], 3, 2));
            $blue = hexdec(substr($roomcal[$i][$j][bookingtypecolor], 5, 2));
        } else {
            $red = hexdec(substr($roomcal[$i][$j][color], 1, 2));
            $green = hexdec(substr($roomcal[$i][$j][color], 3, 2));
            $blue = hexdec(substr($roomcal[$i][$j][color], 5, 2));
        } 
        if (count($roomcal[$i][$j]) > 0) {
            if ($roomcal[$i][$j][color] !== "") {
                if ($roomcal[$i][$j][firstday] !== 'true' && $roomcal[$i][$j][lastday] !== 'true') {
                    $pdf -> SetFillColor($red, $green, $blue);
                    $pdf -> Rect($xstart, $ystart, 6, 9, 'DF');
                } else {
                    if ($roomcal[$i][$j][lastday] == 'true') {
                        if ($view == 'type') {
                            $pdf -> SetFillColor(hexdec(substr($roomcal[$i][$j-1][bookingtypecolor], 1, 2)), hexdec(substr($roomcal[$i][$j-1][bookingtypecolor], 3, 2)), hexdec(substr($roomcal[$i][$j-1][bookingtypecolor], 5, 2)));
                        } else {
                            $pdf -> SetFillColor(hexdec(substr($roomcal[$i][$j-1][color], 1, 2)), hexdec(substr($roomcal[$i][$j-1][color], 3, 2)), hexdec(substr($roomcal[$i][$j-1][color], 5, 2)));
                        } 
                        $pdf -> Rect($xstart, $ystart, 3, 9, 'DF');
                    } else {
                        $pdf -> SetFillColor($sred, $sgreen, $sblue);
                        $pdf -> Rect($xstart, $ystart, 3, 9, 'DF');
                    } 

                    if ($roomcal[$i][$j][firstday] == 'true') {
                        $pdf -> SetFillColor($red, $green, $blue);
                        $pdf -> Rect($xstart + 3, $ystart, 3, 9, 'DF');
                    } else {
                        $pdf -> SetFillColor($sred, $sgreen, $sblue);
                        $pdf -> Rect($xstart + 3, $ystart, 3, 9, 'DF');
                    } 
                } 
            } else {
                $pdf -> SetFillColor($sred, $sgreen, $sblue);
                $pdf -> Rect($xstart, $ystart, 6, 9, 'DF');
            } 
            $xstart += 6;
        } else {
            $pdf -> SetFillColor($sred, $sgreen, $sblue);
            $pdf -> Rect($xstart, $ystart, 3, 9, 'DF');
            $xstart += 3;
        } 
    } 

    $ystart += 9;
} 

$pdf -> ln();
$pdf -> Output();

?>
