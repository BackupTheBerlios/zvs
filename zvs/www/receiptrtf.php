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
* View "receipt" as RTF
* 
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();

include_once("../includes/fileselector.inc.php");

include_once("receiptclass.inc.php");
$receipt = New Receipt;

if ($request->GetVar('receiptid', 'get') !== $request->undefined) {
    $receiptid = $request->GetVar('receiptid', 'get');

    $receiptdata = $receipt->getComplete($receiptid);
	$price = $receiptdata[data]['price_total'];
	$commission = $receipt->getCommissionForReceipt($receiptid, '0', $price, true);

    $table = '\trowd\trgaph70\trleft-108\trbrdrl\brdrs\brdrw15\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3 \clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx2444\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx3124\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx4371\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx5051\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx6298\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx7545\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx8792\pard';
    $table .= '\intbl\nowidctlpar\b\fs16 Artikel\cell Menge\cell Netto-Einzel\cell MwSt\cell Brutto-Einzel\cell Netto-Gesamt\cell Brutto-Gesamt\b0\cell\row';
    for ($i = 0; $i < count($receiptdata[items]); $i++) {
        $table .= '\trowd\trgaph70\trleft-108\trbrdrl\brdrs\brdrw15\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3 \clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx2444\clvertalc\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx3124\clvertalc\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx4371\clvertalc\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx5051\clvertalc\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx6298\clvertalc\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx7545\clvertalc\clbrdrl\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\clbrdrr\brdrw15\brdrs\brdrcf1\clbrdrb\brdrw15\brdrs\brdrcf1 \cellx8792\pard';
        $table .= '\intbl\nowidctlpar ' . ereg_replace('<br />', '\par', nl2br($receiptdata[items][$i]['article'])) . '\cell\qr  ' . $receiptdata[items][$i]['number'] . '\cell ' . $receiptdata[items][$i]['netto_single'] . ' EUR\cell ' . $receiptdata[items][$i]['mwst'] . ' %\cell ' . $receiptdata[items][$i]['brutto_single'] . ' EUR\cell ' . $receiptdata[items][$i]['netto'] . ' EUR\cell ' . $receiptdata[items][$i]['brutto'] . ' EUR\cell\row';
    } 
    $table .= '\trowd\trgaph70\trleft-108\brdrs\brdrw10\brdrcf1 \trbrdrt\brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3 \brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx2444\clvertalc\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx3124\clvertalc\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx4371\clvertalc\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx5051\clvertalc\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx6298\clvertalc\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx7545\clvertalc\brdrw15\brdrs\brdrcf1\clbrdrt\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx8792\pard';
    $table .= '\intbl\nowidctlpar\cell\qr\cell\cell\cell\cell ' . $receiptdata[data]['price_netto_total'] . ' EUR\cell\b ' . $receiptdata[data]['price_total'] . ' EUR\b0\cell\row';
	
	for ($i = 0; $i < count($commission); $i++)
	{
    	$table .= '\trowd\trgaph70\trleft-108\brdrs\brdrw15\brdrcf1 \brdrs\brdrw15\brdrcf1 \trbrdrr\brdrs\brdrw15\brdrcf1 \trbrdrb\brdrs\brdrw15\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3 \brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx2444\clvertalc\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx3124\clvertalc\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx4371\clvertalc\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx5051\clvertalc\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx6298\clvertalc\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx7545\clvertalc\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1\brdrw15\brdrs\brdrcf1 \cellx8792\pard';
    	$table .= '\intbl\nowidctlpar '.ereg_replace('<br />', '\par', nl2br($commission[$i]['description'])).'\cell\qr\cell\cell\cell\cell\cell ';
		if ($i == count($commission)-1) {
		 $table .= '\b ';   
		}
		$table .= $commission[$i]['amount'] . ' EUR';
		if ($i == count($commission)-1) {
		 $table .= '\b0 ';   
		}
		$table .= '\cell\row';

	}	
	$table .= '\pard\nowidctlpar';
} 
// get RTF-Template
$tplfile = selectfile('tpl_receipt.rtf');

$tplHandle = fopen($tplfile, 'r');
$tpl = fread($tplHandle, filesize($tplfile));
fclose($tplHandle);
// replace placeholders
$tpl = ereg_replace("%table%", $table, $tpl);
$tpl = ereg_replace("%address%", ereg_replace('<br />', '\par', nl2br($receiptdata[data][address])), $tpl);
$tpl = ereg_replace("%receiptnumber%", $receiptdata[data][referenceid], $tpl);
$tpl = ereg_replace("%date%", $receiptdata[data][receipt_date], $tpl); 
// show RTF-File
header("Cache-control: private");
header("Content-type: application/rtf");
header("Content-Disposition: attachment; filename=\"receipt.rtf\"");

echo $tpl;

?>