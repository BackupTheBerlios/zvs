<?php
/**
* Manage articlecategories
* 
* Settings
* 
* 08/30/2004 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('articlecatclass.inc.php');
$articlecat = New articlecat;
$smarty -> assign("tpl_title", "Artikelkategorieverwaltung");
$smarty -> assign('tpl_nav', 'settings');
$smarty -> assign('tpl_subnav', 'editarticlecat');

if ($request -> GetVar('frm_articlecatid', 'post') !== $request -> undefined) {
    if ($request -> GetVar('frm_action', 'post') == 'edit') {
        $smarty -> assign('tpl_editid', $request -> GetVar('frm_articlecatid', 'post'));
    } else if ($request -> GetVar('frm_action', 'post') == 'addnew') {
        $smarty -> assign('tpl_addnew', 'true');
    } else if ($request -> GetVar('frm_action', 'post') == 'del') {
        $articlecat -> del($request -> GetVar('frm_articlecatid', 'post'));
    } else {
        $check = $articlecat -> saveupdate();
    } 
} 

$smarty -> assign('tpl_article', $articlecat -> getall());

$smarty -> display('editarticlecat.tpl');

?>
