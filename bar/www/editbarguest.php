<?php
/**
* Edit bar guest
* 
* Settings
* 
* 01/12/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$auth -> is_authenticated();
$smarty -> assign("tpl_title", "Gast editieren");

if ($request->GetVar('frm_firstname','post') !== $request->undefined) {
    $guestid = $request->GetVar('frm_guestid','post');
    $barguest->update($guestid ,$request->GetVar('frm_firstname','post') ,$request->GetVar('frm_lastname','post') );
	$smarty->assign('tpl_theguestid', $guestid);
	$smarty->assign('tpl_added','true');
} else {
	$guestid = $request->GetVar('guestid','get');
	$smarty->assign('tpl_added','false');
	$smarty -> assign("tpl_guestid", $guestid);
	$smarty->assign("tpl_barguest", $barguest->GetNameSplit($guestid));
}

$smarty -> display('editbarguest.tpl');

?>
