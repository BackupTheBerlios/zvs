<?php
/**
* Logout page
* 
* Global
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";

include_once("../includes/default.inc.php");
$smarty -> assign("tpl_title", "Abmelden");
$smarty -> assign("tpl_nav", "logout");

$login = $request->GetVar('login','Session');
$smarty -> assign('tpl_login', rawurlencode($login));

$success = $sess -> DestroySession();
if ($success) {
    $smarty -> assign('tpl_logout', 'true');
} 
$smarty -> display('logout.tpl');
?>
