<?php
/**
* select timeframe for receipt
* 
* Settings
* 
* 01/06/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
$smarty -> assign("tpl_title", "Bon &uuml;ber Zeitraum erstellen");

$theguestid = $request->GetVar('guestid', 'get');

$smarty->assign('tpl_theguestid',$theguestid);
$smarty->display('selectreceipt.tpl');

?>
