<?php
/**
* Settings "homepage"
* 
* Settings
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
$smarty -> assign("tpl_title", "Einstellungen");
$smarty -> assign('tpl_nav', 'settings');

$smarty -> display('settings.tpl');

?>
