<?php
/**
* Show bar interface
* 
* bar interface
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$theguestid = -1;
$theguest = "";
if ($request->GetVar('guestid','get') !== $request->undefined) {
    $theguestid = $request->GetVar('guestid','get');
	$theguest = $barguest->getName($theguestid);
	include_once("kassaclass.inc.php");
	$kassacls = New Kassa;
	if ($request->GetVar('frm_checkout','post') == "true") {
	    $kassacls->checkout($theguestid, $request->GetVar('frm_setinactive','post'));	
	}	
	$articles = $kassacls->get($theguestid);
	$smarty->assign('tpl_articles',$articles);
} 



$barguests = $barguest -> getAll();
$smarty->assign('tpl_barguests', $barguests);
$smarty->assign('tpl_theguestid', $theguestid);
$smarty->assign('tpl_theguest', $theguest);


$smarty -> assign("tpl_title", "ZVS Barinterface");
$smarty -> assign("tpl_nav", "kassa");

$smarty -> display('kassa.tpl');

?>
