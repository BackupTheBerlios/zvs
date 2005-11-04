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
* View "meldeschein" as PDF
* 
* Calendar
* 
* 07/27/2003 by Christian Ehret chris@uffbasse.de
*/
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('bookingclass.inc.php');
$booking = New Booking;

$bookid = $request->GetVar('bookid', 'get');
$bookdata = $booking->getMeldedata($bookid);

define('FPDF_FONTPATH', $fontpath);
include_once('fpdf.php');
include_once('pdf.php');
$fonttype = 'times';

$pdf = new PDF();
$pdf->Open();
$pdf->SetTitle('ZVS Meldeschein');
$pdf->SetAuthor($request->GetVar('hotel_name', 'session'));
$pdf->SetCreator('ZVS');
$pdf->AliasNbPages();
$pdf->AddPage(P);
$pdf->ln(5);
$y = $pdf->GetY(); 
// Address
$pdf->SetFont($fonttype, 'B', 10);
$pdf->Write(5, $request->GetVar('hotel_name', 'session'));
$pdf->ln(4);
$pdf->SetFont($fonttype, '', 10);
$pdf->Write(5, $request->GetVar('hotel_street', 'session'));
$pdf->ln(4);
$pdf->SetFont($fonttype, '', 10);
$pdf->Write(5, $request->GetVar('hotel_zip', 'session') . " " . $request->GetVar('hotel_city', 'session')); 
// Headline
$pdf->SetXY(120, $y);
$pdf->SetFont($fonttype, 'B', 12);
$pdf->Write(5, "Meldeschein für Beherbergungsstätten");
$pdf->SetXY(120, $y + 5);
$pdf->SetFont($fonttype, '', 6);
$pdf->Write(3, "Rechtsgrundlage für die Erhebung der nachfolgend aufgeführten Daten sind");
$pdf->SetXY(120, $y + 8);
$pdf->Write(3, "§§23 und 24 des Meldegesetzes vom 11. April 1983 (GBI. S. 117)");

$pdf->SetFont($fonttype, 'B', 10);
$pdf->SetXY(10, 60);
$pdf->Write(5, "Tag der Ankunft");
$pdf->SetY(65);
$pdf->Write(5, "Tag der voraussichtlichen Abreise");
$pdf->SetY(70);
$pdf->Write(5, "Familienname");
$pdf->SetY(75);
$pdf->Write(5, "Vornamen");
$pdf->SetY(80);
$pdf->Write(5, "Geburtsdatum");
$pdf->SetY(85);
$pdf->Write(5, "Geburtsort");
$pdf->SetY(90);
$pdf->Write(5, "Staatsangehörigkeit");
$pdf->SetY(95);
$pdf->Write(5, "Ausweis");
$pdf->SetY(100);
$pdf->Write(5, "Ausstellende Behörde, Ausstellungsdatum");
$pdf->SetY(105);
$pdf->Write(5, "Postleitzahl, Wohnort");
$pdf->SetY(110);
$pdf->Write(5, "Straße, Hausnummer");
$pdf->SetY(115);
$pdf->Write(5, "Staat");
$pdf->SetY(120);
$pdf->Write(5, "Anzahl der begleitenden Kinder");

$pdf->SetFont($fonttype, '', 10);
$pdf->SetXY(100, 60);
$pdf->Write(5, $bookdata[nicestart]);
$pdf->SetXY(100, 65);
$pdf->Write(5, $bookdata[niceend]);
$pdf->SetXY(100, 70);
$pdf->Write(5, $bookdata[lastname]);
$pdf->SetXY(100, 75);
$pdf->Write(5, $bookdata[firstname]);
$pdf->SetXY(100, 80);
if ($bookdata[birthdate] !== "00.00.0000") {
    $pdf->Write(5, $bookdata[birthdate]);
} 
$pdf->SetXY(100, 85);
$pdf->Write(5, $bookdata[birthplace]);
$pdf->SetXY(100, 90);
$pdf->Write(5, $bookdata[nationality]);
$pdf->SetXY(100, 95);
$identity = "";
if ($bookdata[identity] == 'P') {
    $identity = "Personalausweis-";
} else if ($bookdata[identity] == 'R') {
    $identity = "Reisepass-";
} else if ($bookdata[identity] == 'F') {
    $identity = "Führerschein-";       
}
$pdf->Write(5, $identity . "Nummer: " . $bookdata[passport]);
$pdf->SetXY(100, 100);
$pdf->Write(5, $bookdata[agency] . ", " . $bookdata[issue_date]);
$pdf->SetXY(100, 105);
$pdf->Write(5, $bookdata[zip] . " " . $bookdata[city]);
$pdf->SetXY(100, 110);
$pdf->Write(5, $bookdata[street]);
$pdf->SetXY(100, 115);
$pdf->Write(5, $bookdata[country]);
$pdf->SetXY(100, 120);
$pdf->Write(5, $bookdata[children]); 
// Table
$pdf->Line(10, 60, 190, 60);
$pdf->Line(10, 65, 190, 65);
$pdf->Line(10, 70, 190, 70);
$pdf->Line(10, 75, 190, 75);
$pdf->Line(10, 80, 190, 80);
$pdf->Line(10, 85, 190, 85);
$pdf->Line(10, 90, 190, 90);
$pdf->Line(10, 95, 190, 95);
$pdf->Line(10, 100, 190, 100);
$pdf->Line(10, 105, 190, 105);
$pdf->Line(10, 110, 190, 110);
$pdf->Line(10, 115, 190, 115);
$pdf->Line(10, 120, 190, 120);
$pdf->Line(10, 125, 190, 125);

$pdf->Line(100, 60, 100, 125); 
// signs
$pdf->SetFont($fonttype, '', 8);
$pdf->Line(10, 150, 90, 150);
$pdf->SetXY(10, 150);
$pdf->Write(3, "Unterschrift des Gastes bzw. Reiseleiters");

$pdf->Line(110, 150, 190, 150);
$pdf->SetXY(110, 150);
$pdf->Write(3, "Unterschrift des Ehegatten");

$pdf->ln();
$pdf->Output();

?>
