<?php
/**
* Copyright notice
* 
*            (c) 2003-2004 Christian Ehret (chris@ehret.name)
*            All rights reserved
* 
*            This script is part of the ZVS project. The ZVS project is 
*            free software; you can redistribute it and/or modify
*            it under the terms of the GNU General Public License as published by
*            the Free Software Foundation; either version 2 of the License, or
*            (at your option) any later version.
* 
*            The GNU General Public License can be found at
*            http://www.gnu.org/copyleft/gpl.html.
*            A copy is found in the textfile GPL.txt and important notices to the license 
*            from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*            This script is distributed in the hope that it will be useful,
*            but WITHOUT ANY WARRANTY; without even the implied warranty of
*            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*            GNU General Public License for more details.
* 
*            This copyright notice MUST APPEAR in all copies of the script!
*/

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

$newperiod = 'false';
if ($request->GetVar('frm_period', 'post') !== $request->undefined) {
    $theperiod = $request->GetVar('frm_period', 'post');
} else {
    $actPeriod = $article->getactPeriod();
    $theperiod = $actPeriod['periodid'];
} 
if ($request->GetVar('frm_action', 'post') == 'edit') {
    $smarty->assign('tpl_cat', $articlecat->getAll());
    $smarty->assign('tpl_editid', $request->GetVar('frm_articleid', 'post'));
} elseif ($request->GetVar('frm_action', 'post') == 'addnew') {
    $smarty->assign('tpl_cat', $articlecat->getAll());
    $smarty->assign('tpl_addnew', 'true');
} elseif ($request->GetVar('frm_action', 'post') == 'del') {
    $article->del($request->GetVar('frm_articleid', 'post'));
} elseif ($request->GetVar('frm_action', 'post') == 'new') {
    $check = $article->saveupdate();
} elseif ($request->GetVar('frm_action', 'post') == 'changeperiod') {
} elseif ($request->GetVar('frm_action', 'post') == 'saveupdatePeriod') {
    $theperiod = $article->saveupdatePeriod();
} elseif ($request->GetVar('frm_action', 'post') == 'newPeriod') {
    $theperiod = -1;
    $newperiod = 'true';
} 
$smarty->assign('tpl_article', $article->getall(false, $theperiod));
$smarty->assign('tpl_period', $article->getPeriod());
$smarty->assign('tpl_newPeriod', $newperiod);
$smarty->assign('tpl_theperiod', $theperiod);
$smarty->assign("tpl_selectedPeriod", $article->getselPeriod($theperiod));
$smarty->display('editarticle.tpl');

?>
