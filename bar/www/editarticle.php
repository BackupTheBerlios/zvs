<?php
/**
* Manage articles
* 
* Settings
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('articleclass.inc.php');
include_once('articlecatclass.inc.php');
$article = New article;
$articlecat = New articlecat;
$smarty->assign("tpl_title", "Artikelverwaltung");
$smarty->assign('tpl_nav', 'settings');
$smarty->assign('tpl_subnav', 'editarticle');

if ($request->GetVar('frm_articleid', 'post') !== $request->undefined) {
    if ($request->GetVar('frm_action', 'post') == 'edit') {
        $smarty->assign('tpl_cat', $articlecat->getAll());
        $smarty->assign('tpl_editid', $request->GetVar('frm_articleid', 'post'));
    } else if ($request->GetVar('frm_action', 'post') == 'addnew') {
		$smarty->assign('tpl_cat', $articlecat->getAll());
        $smarty->assign('tpl_addnew', 'true');
    } else if ($request->GetVar('frm_action', 'post') == 'del') {
        $article->del($request->GetVar('frm_articleid', 'post'));
    } else {
        $check = $article->saveupdate();
    } 
} 

$smarty->assign('tpl_article', $article->getall(false));

$smarty->display('editarticle.tpl');

?>
