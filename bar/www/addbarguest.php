<?php
/**
* Add bar guest
* 
* Settings
* 
* 01/06/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$auth -> is_authenticated();
$smarty -> assign("tpl_title", "Gast hinzuf&uuml;gen");
if ($request->GetVar('frm_firstname','post') !== $request->undefined) {
    $guestid = $barguest->add();
	$smarty->assign('tpl_theguestid', $guestid);
	$smarty->assign('tpl_added','true');
} else {
	$smarty->assign('tpl_added','false');
}

$smarty -> display('addbarguest.tpl');

?>
