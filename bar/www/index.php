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
$auth->is_authenticated();
include_once("barguestclass.inc.php");
$barguest = new Barguest;
$theguestid = -1;
$theguest = "";

include_once('statisticsclass.inc.php');
$statistics = New Statistics;

include_once('articlecatclass.inc.php');
$articlecat = New articlecat;

$cats = $articlecat->getall();
$smarty->assign('tpl_nextnum', count($cats)+1);

$smarty->assign('tpl_showlast', 'false');

if ($request->GetVar('frm_cat', 'post') !== $request->undefined) {
    $cat = "verkauf".$request->GetVar('frm_cat', 'post');
} else {
	$cat = "verkauf".$cats[0]['articlecatid'];
}

$smarty->assign('tpl_thecat', $cat);

if ($request->GetVar('showlast','get') !== $request->undefined) {
    $smarty->assign('tpl_showlast', 'true');
}
if ($request->GetVar('frm_articleid', 'post') !== $request->undefined) {
    $articleid = $request->GetVar('frm_articleid', 'post');
    $theguestid = $request->GetVar('guestid', 'get');
    $num = $request->GetVar('frm_num', 'post');
    $barguest->buy($articleid, $theguestid, $num);
	$smarty->assign('tpl_showlast', 'true');
} 
if ($request->GetVar('guestid', 'get') !== $request->undefined) {
    $theguestid = $request->GetVar('guestid', 'get');
    $theguest = $barguest->getName($theguestid);
    include_once("articleclass.inc.php");
    $articlecls = New Article;
    //$articles = $articlecls->Getall(true);
	$articles = array();
	for ($i=0; $i < count($cats); $i++){
		$cats[$i]['articles'] = $articlecls->Getallcat(true, $cats[$i]['articlecatid']);
	}
    $smarty->assign('tpl_articles', $articles);
    include_once("kassaclass.inc.php");
    $kassacls = New Kassa;
    if ($request->GetVar('frm_checkout', 'post') == "true") {
        $payids = $request->getVar('payid', 'post');
        for ($i = 0; $i < count($payids); ++$i) {
            $kassacls->pay($payids[$i]);
        } 
        if ($request->GetVar('frm_setinactive', 'post') == "true") {
            $kassacls->checkout($theguestid, $request->GetVar('frm_setinactive', 'post'));
        } 
    } 
    if ($request->GetVar('frm_storno', 'post') == "true") {
        $kassacls->storno($request->GetVar('frm_boughtid', 'post'));
    } 
    if ($request->GetVar('frm_pay', 'post') == "true") {
        $kassacls->pay($request->GetVar('frm_boughtid', 'post'));
    } 
    $guestarticles = $kassacls->get($theguestid, 'DESC');
    $smarty->assign('tpl_guestarticles', $guestarticles);
} 

$smarty->assign('tpl_cat', $cats);

$barguests = $barguest->getAll();

$smarty->assign('tpl_barguests', $barguests);
$smarty->assign('tpl_theguestid', $theguestid);
$smarty->assign('tpl_theguest', $theguest);

$smarty->assign("tpl_title", "ZVS Barinterface");
$smarty->assign("tpl_nav", "sell");
$smarty->assign('tpl_sum', $statistics->GetNow());
$smarty->display('index.tpl');

?>
