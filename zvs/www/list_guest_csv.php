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
* list checked-in guests as csv
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();
$bcat = -1;
if ($request->GetVar('bcat', 'get') !== $request->undefined) {
    $bcat = $request->GetVar('bcat', 'get');
} 

include_once('guestlistclass.inc.php');
$guestlist = New Guestlist;
$statarr = $guestlist->get($bcat);
$children1 = $request->GetVar('children1', 'session');
$children2 = $request->GetVar('children2', 'session');
$children3 = $request->GetVar('children3', 'session');
$tpl = "\"Zimmer:\";\"Nachname:\";\"Vorname:\";\"Email:\";\"von:\";\"bis:\";\"Buchungskategorie:\";\"Buchungsstatus:\";\"Erwachsene:\";\"$children1:\";\"$children2:\";\"$children3:\";
";

for ($i = 0; $i < count($statarr); $i++) {
    $tpl .= $statarr[$i]['room'] . ";" . $statarr[$i]['lastname'] . ";" . $statarr[$i]['firstname'] . ";" . $statarr[$i]['email'] . ";" . $statarr[$i]['startdate'] . ";" . $statarr[$i]['enddate'] . ";" . $statarr[$i]['bookingcat'] . ";" . $statarr[$i]['bookingtype'] . ";" . $statarr[$i]['person'] . ";" . $statarr[$i]['children1'] . ";" . $statarr[$i]['children2'] . ";" . $statarr[$i]['children3'] . ";
";
} 
// show CSV
header("Cache-control: private");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=\"guest.csv\"");
echo $tpl;

?>