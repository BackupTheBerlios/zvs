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
* View "receipt" as RTF
* 
* 
* 1/11/2004 by Christian Ehret chris@uffbasse.de
*/
$nocachecontrol = true;

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

    $table = '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrb\brdrw10\brdrs \cellx983\clbrdrb\brdrw10\brdrs \cellx4243\clbrdrb\brdrw10\brdrs \cellx6794\clbrdrb\brdrw10\brdrs \cellx8212\clbrdrb\brdrw10\brdrs \cellx9526\pard\intbl\ql\b Anzahl\b0\cell\b Artikel\b0\cell\b Datum\b0\cell\b\qr0 Preis\b0\cell\b Total\b0\cell\row';
    for ($i = 0; $i < count($guestarticles); $i++) {
        if ($i == count($guestarticles)-1) {
            $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrt\brdrw10\brdrs \cellx983\clbrdrt\brdrw10\brdrs \cellx4243\clbrdrt\brdrw10\brdrs \cellx6794\clbrdrt\brdrw10\brdrs \cellx8212\clbrdrt\brdrw10\brdrs \cellx9526\pard\intbl\cell\cell\cell\pard\intbl\qr\b Summe:\cell ' . $guestarticles[$i]['total'] . ' \\\'80 \cell\b0\row\pard\par';
        } else {
            $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrt\brdrw10\brdrs \cellx983\clbrdrt\brdrw10\brdrs \cellx4243\clbrdrt\brdrw10\brdrs \cellx6794\clbrdrt\brdrw10\brdrs \cellx8212\clbrdrt\brdrw10\brdrs \cellx9526\pard\intbl ' . $guestarticles[$i]['num'] . '\cell ' . $guestarticles[$i]['description'] . '\cell ' . $guestarticles[$i]['timestamp'] . ' Uhr\cell\pard\intbl\qr ' . $guestarticles[$i]['price'] . ' \\\'80\cell ' . $guestarticles[$i]['total'] . ' \\\'80\cell\row';
        } 
    } 
} else {
    $theguestid = $request->GetVar('frm_theguestid', 'get');
    $start = $request->GetVar('frm_start', 'get');
    $end = $request->GetVar('frm_end', 'get');
    $guestarticles = $kassacls->getTimeline($theguestid, $start, $end, 'ASC', $cats);

    $table = '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrb\brdrw10\brdrs \cellx830\clbrdrb\brdrw10\brdrs \cellx3420\clbrdrb\brdrw10\brdrs \cellx4662\clbrdrb\brdrw10\brdrs \cellx5904\clbrdrb\brdrw10\brdrs \cellx7145\clbrdrb\brdrw10\brdrs \cellx8387\clbrbrb\brdrw10\brdrs \cellx9629\pard\intbl\nowidctlpar\b Anzahl\b0\cell\b Artikel\b0\cell\b Datum\b0\cell\b\qr Preis\b0\cell\b Total\b0\cell\b Bezahlt\cell Datum\cell\row';
    for ($i = 0; $i < count($guestarticles); $i++) {
        if ($i == count($guestarticles)-2) {
            $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\cellx830\clbrdrt\brdrw10\brdrs \cellx3420\clbrdrt\brdrw10\brdrs \cellx4662\clbrdrt\brdrw10\brdrs \cellx5904\clbrdrt\brdrw10\brdrs \cellx7145\clbrdrt\brdrw10\brdrs \cellx8387\clbrdrt\brdrw10\brdrs\brdrw10\brdrs \cellx9629\pard\intbl\nowidctlpar\cell\cell\cell\pard\intbl\nowidctlpar\qr\b Summe:\cell ' . $guestarticles[$i]['total1'] . ' \\\'80\cell ' . $guestarticles[$i]['total2'] . ' \\\'80\cell\cell\b0\row';
        } elseif ($i == count($guestarticles)-1) {
            $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\cellx830\cellx3420\cellx4662\cellx5904\cellx7145\cellx8387\brdrw10\brdrs\brdrw10\brdrs \cellx9629\pard\intbl\nowidctlpar\cell\cell\cell\pard\intbl\nowidctlpar\qr\b Differenz:\cell ' . $guestarticles[$i]['total1'] . ' \\\'80\b0\cell\cell\cell\row\pard\nowidctlpar\par';
        } else {
            $table .= '\trowd\trgaph10\trleft-10\trrh301\trpaddl10\trpaddr10\trpaddfl3\trpaddfr3\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx830\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx3420\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx4662\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx5904\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx7145\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8387\clbrdrt\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx9629\pard\intbl\nowidctlpar\b0 ' . $guestarticles[$i]['num'] . '\cell ' . $guestarticles[$i]['description'] . '\cell ' . str_replace(',', ',\par', $guestarticles[$i]['timestamp']) . ' Uhr\cell\pard\intbl\nowidctlpar\qr ' . $guestarticles[$i]['price'] . ' \\\'80\cell ' . $guestarticles[$i]['total1'] . ' \\\'80\cell ' . $guestarticles[$i]['total2'] . ' \\\'80\cell ' . str_replace(',', ',\par', $guestarticles[$i]['updated']) . ' \cell\row';
        } 
    } 
} 
// get RTF-Template
$tplfile = selectfile('tpl_receipt.rtf');
// $tplfile = 'C:\wwwroot\zvs\default\tpl_meldeschein.rtf';
$tplHandle = fopen($tplfile, 'r');
$tpl = fread($tplHandle, filesize($tplfile));
fclose($tplHandle);
// replace placeholders
$tpl = ereg_replace("%test%", $table, $tpl);
$tpl = ereg_replace("%name%", $barguest->getName($theguestid), $tpl);
$tpl = ereg_replace("%date%", date("d.m.Y"), $tpl); 
// show RTF-File
header("Cache-control: private");
header("Content-type: application/rtf");
header("Content-Disposition: attachment; filename=\"bon.rtf\"");

echo $tpl;

?>