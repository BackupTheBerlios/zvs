<?php

/**
* Settings
* 
* 
* 
* archive database
* 
* 
* 
* 07/09/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";

include_once("../includes/default.inc.php");

$auth->is_authenticated();

$smarty->assign("tpl_title", "Daten archivieren");

$smarty->assign('tpl_nav', 'settings');

$smarty->assign('tpl_subnav', 'archive');
$smarty->assign('tpl_db', $request->GetVar('schema', 'session').'_bar');

 
$smarty->display('archivedb.tpl');

?>