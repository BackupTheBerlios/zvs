<?php
/**
* Add a special article
* 
* Settings
* 
* 01/10/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once("articleclass.inc.php");
$article = new Article;
$smarty->assign("tpl_title", "Sonderverkauf");

if ($request->GetVar('frm_description', 'post') !== $request->undefined) {
    include_once("barguestclass.inc.php");
    $barguest = new Barguest;

    $articleid = $article->addSpecial();

    $theguestid = $request->GetVar('frm_theguestid', 'post');
    $smarty->assign("tpl_theguestid", $theguestid);
    $num = $request->GetVar('frm_num', 'post');
    $barguest->buy($articleid, $theguestid, $num);

    $smarty->assign('tpl_added', 'true');
} else {
	$smarty->assign('tpl_articles', $article->getList());
    $smarty->assign("tpl_theguestid", $request->GetVar('guestid', get));
    $smarty->assign('tpl_added', 'false');
} 

$smarty->display('addspecial.tpl');

?>
